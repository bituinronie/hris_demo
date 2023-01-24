<?php
namespace App\Traits\Reports;

use Mpdf\Mpdf;
use Carbon\Carbon;
use App\Models\Dtr;
use App\Models\Division;
use App\Models\Employee;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;
use App\Models\ServiceRecord;
use App\Traits\ConstantTrait;
use App\Classes\Reports\TimeKeepingTemplate;

/**
 * TimeKeeping
 */
trait TimeKeeping
{
    use ConstantTrait;

    public $DTR_SETTING = [
        'format' => [215.9, 279.4],
        'margin_left' => 8,
        'margin_right' => 8,
        'margin_top' => 5,
        'margin_bottom' => 5
    ];

    public $TS_SETTING = [
        'format' => [330, 203],
        'margin_left' => 8,
        'margin_right' => 8,
        'margin_top' => 5,
        'margin_bottom' => 8
    ];

    public $MS_SETTING = [
        'format' => [330, 203],
        'margin_left' => 2,
        'margin_right' => 2,
        'margin_top' => 5,
        'margin_bottom' => 8
    ];

    //* Validation
    public function checkEmployeeId($employeeId){
        if($employeeId == null)
            return false;

        return Employee::find($employeeId)?true:false;
    }

    public function dtr($employeeId, $dateFrom = null, $dateTo = null, $perPage = 31, $supervisor = ''){
        $type = gettype($employeeId);

        $report = new Mpdf($this->DTR_SETTING);
        $template = new TimeKeepingTemplate;

        switch ($type) {
            case 'integer':
                $data = $this->dtrData($employeeId, $dateFrom, $dateTo, $perPage);
                $data->supervisor = Str::upper($supervisor);

                $report->WriteHTML($template->dtr($data));

                break;
            case 'string':
                $data = $this->dtrData($employeeId, $dateFrom, $dateTo, $perPage);
                $data->supervisor = Str::upper($supervisor);

                $report->WriteHTML($template->dtr($data));

                break;
            case 'array':
                $employeeIdCount = count($employeeId);
                $i = 1;
                foreach ($employeeId as $id) {
                    $data = $this->dtrData($id, $dateFrom, $dateTo, $perPage);
                    $data->supervisor = Str::upper($supervisor);

                    $report->WriteHTML($template->dtr($data));
                    if($employeeIdCount > $i)
                        $report->AddPage();

                    $i++;
                }
                break;
        };
        

        return $report;
    }

    public function dtrData($employeeId, $dateFrom, $dateTo, $perPage = 31){
        // Employee
        $employee = Employee::find($employeeId);

        // Dtr
        $dtrs = Dtr::where('employee_id',$employeeId)
                    ->whereBetween('ref_date', [$dateFrom, $dateTo])
                    ->get()
                    ->forPage(1, $perPage) // Collection part
                    ->map(function($item) {
                        $item->showStats = true;
                        $stats = $item->parseDtr->get('stats');
                        $parsed = $item->parseDtr->toArray();

                        $clearedRemark = rtrim(
                                            str_replace('DAY OFF;', '',
                                                str_replace('HALF DAY;', '',
                                                    str_replace('UT;', '',
                                                        str_replace('LATE;', '',
                                                            str_replace('OT;','',
                                                                $parsed['remark']
                                                            )
                                                        )
                                                    )
                                                )
                                            )
                                        , ';');

                        return (object)[
                            'date' => $item->ref_date->format('d'),
                            'am_in' => $parsed['am_in'],
                            'am_out' => $parsed['am_out'],
                            'pm_in' => $parsed['pm_in'],
                            'pm_out' => $parsed['pm_out'],
                            'remark' => $parsed['remark'] == 'DAY OFF;' ? Str::upper($item->ref_date->format('l').'(Dayoff)') : ($clearedRemark == ''?null:$clearedRemark),
                            'ut_hrs' => $stats->diffHours(),
                            'ut_min' => $stats->diffMinutes(),
                        ];
                    })->toArray();

        // Stats
        $stats = Dtr::getStats($employeeId, $dateFrom, $dateTo);

        return (object) [
            'employee' => (object) [
                'emp_number' => $employee->employee_number,
                'name' => Str::upper($employee->nameLastNameFirst),
                'forMonth' => Carbon::parse($dateFrom)->format('F Y'),
            ],
            'dtr' => $dtrs,
            'totalUndertime' => $stats['summary']['diff_in_days']
        ];

    }

    public function tardinessSummary($placeOfWork = null, $dateFrom = null, $dateTo = null, $prepared = '', $preparedPosition = '',$supervisor = '', $supervisorPosition = ''){
        $data = $this->tardinessSummaryData($placeOfWork, $dateFrom, $dateTo);

        $data->placeOfWork = Str::upper($placeOfWork) ?? '';
        $data->date = (object) [
            'from' => Carbon::parse($dateFrom)->format('F d, Y'),
            'to' => Carbon::parse($dateTo)->format('F d, Y')
        ];

        $data->prepared = Str::upper($prepared);
        $data->preparedPosition = Str::upper($preparedPosition);
        $data->supervisor = Str::upper($supervisor);
        $data->supervisorPosition = Str::upper($supervisorPosition);

        $report = new Mpdf($this->TS_SETTING);

        $template = new TimeKeepingTemplate;
        $report->WriteHTML($template->ts($data));

        return $report;
    }

    public function tardinessSummaryData($placeOfWork, $dateFrom, $dateTo){

        $placeOfWork = Str::lower($placeOfWork);

        $period = CarbonPeriod::create($dateFrom, $dateTo);

        $data = collect();

        // Iterate over the period
        foreach ($period as $date) {
            $refDate = $date->format('Y-m-d');

            $dtrs = Dtr::where('ref_date', $refDate)->get()
                    ->filter(function($item) {
                        $item->showStats = true;
                        $stats = $item->parseDtr->get('stats');

                        if($stats->lateCount || $stats->utCount)
                            return true;

                        return false;
                    })->filter(function($item) use ($placeOfWork){
                        if($placeOfWork == null)
                            return true;

                        // sort place of work
                        $serviceRecord = ServiceRecord::getRecord($item->employee_id, $item->ref_date->format('Y-m-d'));
                        if(!$serviceRecord)
                            return false;

                        $employeePlaceOfWork = Str::lower($serviceRecord->place_of_work);

                        if($employeePlaceOfWork == $placeOfWork)
                            return true;

                        return false;
                    })->map(function($item) {
                        $item->showStats = true;
                        $stats = $item->parseDtr->get('stats');

                        $employee = $item->employee;

                        // get schedule printing
                        $schedule = Employee::getScheduleByDate($item->employee_id, $item->ref_date->format('Y-m-d'), true); // true => to strictly check sched
                        $scheduleOnPrint = "{$schedule->time_in->format('h:i A')}-{$schedule->time_out->format('h:i A')}";

                        $returnData = [
                            'employeeNumber' => $employee->employee_number,
                            'fullName' => Str::upper($employee->name),
                            'date' => $item->ref_date->format('F d, Y'),
                            'schedule' => $scheduleOnPrint,
                            'arrival' => $item->time_in?->format('h:i A') ?? null,
                            'departure' => $item->time_out?->format('h:i A') ?? null,
                            'late' => $stats->lateToReadable(),
                            'ut' => $stats->utToReadable(),
                        ];

                        return (object) $returnData;
                    });

            if($dtrs->count())
                $data->push($dtrs);
        }

        $returnData = $data->flatten(1)->sortBy('fullName')->sortBy('date');

        return (object) [
            'items' => $returnData->toArray()
        ];
    }

    public function bandiSummary($divisionId = null, $placeOfWork = null, $dateFrom = null, $dateTo = null, $prepared = '', $preparedPosition = '',$supervisor = '', $supervisorPosition = '') {
        $data = (object) [];

        $data->items = $this->bandiSummaryData($divisionId, $placeOfWork, $dateFrom, $dateTo);

        $data->division = Str::upper(Division::find($divisionId)?->name) ?? '';
        $data->placeOfWork = Str::upper($placeOfWork) ?? '';

        $data->date = (object) [
            'from' => Carbon::parse($dateFrom)->format('F d, Y'),
            'to' => Carbon::parse($dateTo)->format('F d, Y')
        ];

        $data->prepared = Str::upper($prepared);
        $data->preparedPosition = Str::upper($preparedPosition);
        $data->supervisor = Str::upper($supervisor);
        $data->supervisorPosition = Str::upper($supervisorPosition);

        $report = new Mpdf($this->TS_SETTING);
        $report->setAutoTopMargin = 'stretch';

        $template = new TimeKeepingTemplate;
        $report->WriteHTML($template->bs($data));

        return $report;
    }

    public function bandiSummaryData($divisionId = null, $placeOfWork = null, $dateFrom = null, $dateTo = null){
        $placeOfWork = Str::lower($placeOfWork);

        $employees = Employee::all()->filter(function($item) use ($divisionId, $placeOfWork, $dateFrom) {
            if($placeOfWork == null && $divisionId == null)
                return true;

            // get service record
            $serviceRecord = ServiceRecord::getRecord($item->id, $dateFrom);
            if(!$serviceRecord)
                return false;

            if($placeOfWork) {
                $employeePlaceOfWork = Str::lower($serviceRecord->place_of_work);

                if($employeePlaceOfWork != $placeOfWork)
                    return false;
            }

            if($divisionId) {
                if($serviceRecord->assigned_to != $divisionId)
                    return false;
            }

            return true;
        });

        $data = collect();

        foreach ($employees as $employee) {
            $timeLogs = $employee->timeLogs()
                                ->select('ref_date','post_date','type','name')
                                ->whereBetween('ref_date',[$dateFrom, $dateTo])
                                ->orderBy('ref_date','ASC')
                                ->orderBy('post_date','ASC')
                                ->get()
                                ->map(fn($item) => [
                                    'ref_date' => $item->ref_date->format('F d, Y'),
                                    'post_date' => $item->post_date->format('M d, y | H:m A'),
                                    'type' => str_replace('_',' ', $item->type),
                                    'name' => $item->name
                                ])
                                ->toArray();


            if(count($timeLogs))
                $data->put(
                    Str::upper($employee->name),
                    $timeLogs
                );
        }

        return $data->toArray();
    }

    public function monthlyAttendance($divisionId = null, $placeOfWork = null, $dateFrom = null, $dateTo = null, $prepared = '', $preparedPosition = '',$supervisor = '', $supervisorPosition = ''){
        $data = (object) [];

        $data->items = $this->monthlyAttendanceData($divisionId, $placeOfWork, $dateFrom, $dateTo);

        $datePeriod = collect(CarbonPeriod::create($dateFrom, $dateTo));

        $data->division = Str::upper(Division::find($divisionId)?->name) ?? '';
        $data->placeOfWork = Str::upper($placeOfWork) ?? '';

        $data->date = (object) [
            'from' => Carbon::parse($dateFrom)->format('F d, Y'),
            'to' => Carbon::parse($dateTo)->format('F d, Y'),
            'datesDays' => $datePeriod->map(fn($item) => $item->format('d'))->all(),
            'wordDays' => $datePeriod->map(fn($item) => $item->format('D'))->all()
        ];

        $data->prepared = Str::upper($prepared);
        $data->preparedPosition = Str::upper($preparedPosition);
        $data->supervisor = Str::upper($supervisor);
        $data->supervisorPosition = Str::upper($supervisorPosition);

        $report = new Mpdf($this->TS_SETTING);

        $template = new TimeKeepingTemplate;
        $report->WriteHTML($template->ma($data));

        return $report;
    }

    public function monthlyAttendanceData($divisionId, $placeOfWork = null, $dateFrom = null, $dateTo = null){
        $placeOfWork = Str::lower($placeOfWork);

        $employees = Employee::all()->filter(function($item) use ($placeOfWork, $divisionId, $dateFrom) {
            if($placeOfWork == null && $divisionId == null)
                return true;

            // get service record
            $serviceRecord = ServiceRecord::getRecord($item->id, $dateFrom);
            if(!$serviceRecord)
                return false;

            if($placeOfWork) {
                $employeePlaceOfWork = Str::lower($serviceRecord->place_of_work);

                if($employeePlaceOfWork != $placeOfWork)
                    return false;
            }

            if($divisionId) {
                if($serviceRecord->assigned_to != $divisionId)
                    return false;
            }

            return true;
        })->sortBy('name');

        $data = collect();

        $defaultItems = collect(CarbonPeriod::create($dateFrom, $dateTo))->map(fn($item) => null)->toArray();

        foreach ($employees as $employee) {
            $stats = Dtr::getReportStats($employee->id, $dateFrom, $dateTo);

            $stats->items = $employee->dtrs()
                            ->whereBetween('ref_date',[$dateFrom, $dateTo])
                            ->orderBy('ref_date','ASC')
                            ->get()
                            ->map(function($item) {
                                $item->showStats = true;
                                return $item->parseDtr['stats']->status();
                            })->toArray();

            if(empty($stats->items))
                $stats->items = $defaultItems;

            $data->put(Str::upper($employee->name), $stats);
        }

        return $data->toArray();
    }

    public function employeeAbsences($placeOfWork = null, $dateFrom = null, $dateTo = null, $prepared = '', $preparedPosition = '',$supervisor = '', $supervisorPosition = ''){
        $data = (object) [];

        $data->items = $this->employeeAbsencesData($placeOfWork, $dateFrom, $dateTo);

        $datePeriod = collect(CarbonPeriod::create($dateFrom, $dateTo));

        $data->placeOfWork = Str::upper($placeOfWork) ?? '';
        $data->date = (object) [
            'from' => Carbon::parse($dateFrom)->format('F d, Y'),
            'to' => Carbon::parse($dateTo)->format('F d, Y')
        ];

        $data->prepared = Str::upper($prepared);
        $data->preparedPosition = Str::upper($preparedPosition);
        $data->supervisor = Str::upper($supervisor);
        $data->supervisorPosition = Str::upper($supervisorPosition);

        $report = new Mpdf($this->TS_SETTING);
        $report->setAutoTopMargin = 'stretch';

        $template = new TimeKeepingTemplate;
        $report->WriteHTML($template->ea($data));

        return $report;
    }

    public function employeeAbsencesData($placeOfWork, $dateFrom, $dateTo){
        $placeOfWork = Str::lower($placeOfWork);

        $employees = Employee::all()->filter(function($item) use ($placeOfWork, $dateFrom) {
            if($placeOfWork == null)
                return true;

            // get service record
            $serviceRecord = ServiceRecord::getRecord($item->id, $dateFrom);
            if(!$serviceRecord)
                return false;

            $employeePlaceOfWork = Str::lower($serviceRecord->place_of_work);

            if($employeePlaceOfWork != $placeOfWork)
                return false;

            return true;
        })->sortBy('name');

        $data = collect();

        foreach ($employees as $employee) {
            $stats = Dtr::getReportStats($employee->id, $dateFrom, $dateTo);

            if($stats->absences == 0)
                continue;

            $data->push((object) [
                'employeeNumber' => $employee->employee_number,
                'name' => Str::upper($employee->name),
                'division' => $employee->division,
                'vl' => $stats->absencesStats->vl,
                'sl' => $stats->absencesStats->sl,
                'ml' => $stats->absencesStats->ml,
                'pl' => $stats->absencesStats->pl,
                'spl' => $stats->absencesStats->spl,
                'mandatory' => $stats->absencesStats->mandatory,
                'cto' => $stats->absencesStats->cto,
                'training' => $stats->absencesStats->training,
                'meeting' => $stats->absencesStats->meeting,
                'calamity' => $stats->absencesStats->calamity,
                'holiday' => $stats->absencesStats->holiday,
                'lwop' => $stats->absencesStats->lwop,
                'awol' => $stats->absencesStats->awol
            ]);
        }

        return $data->toArray();
    }
}
