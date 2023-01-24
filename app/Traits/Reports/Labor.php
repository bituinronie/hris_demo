<?php
namespace App\Traits\Reports;

use Mpdf\Mpdf;
use App\Models\Award;
use App\Models\Employee;
use Illuminate\Support\Str;
use App\Models\ServiceRecord;
use Maatwebsite\Excel\Facades\Excel;
use App\Classes\Reports\LaborTemplate;
use App\Classes\Reports\AppraisalTemplate;
use App\Models\Offense;

/**
 * Employee Management Trait
 */
trait Labor
{
    public $AWARD_SUMMARY_DATA = [
        'format' => [215.9, 279.4],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    public $OFFENSE_SUMMARY_DATA = [
        'format' => [279.4, 215.9],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    public function appraisalSummary($year, $prepared = '', $preparedPosition = '', $noted = '', $notedPosition = '')
    {
        $data = $this->appraisalSummaryData($year);
        $data->year = $year;
        $data->prepared = $prepared;
        $data->preparedPosition = $preparedPosition;
        $data->noted = $noted;
        $data->notedPosition = $notedPosition;

        return Excel::download(new AppraisalTemplate(collect($data)), $this->SUMMARY_OF_APPRAISALS);
    }

    public function appraisalSummaryData($year)
    {
        return (object)[
            'items' => Employee::all()
            //     ->filter(function ($item) use ($year) {
            //     return ServiceRecord::getRecord($item, "$year-01-01", true) ? true : false;
            // })
            ->map(function ($item) use ($year) {
            $appraisals = $item->appraisals()->whereYear('date', $year)->get();
            if ($appraisals->isEmpty())
                return null;

            $initAppraisal = [
                    'numeric' => '-',
                    'adjectival' => '-'
                ];

            $returnData = [
                    'name' => Str::upper($item->name),
                    'position' => Str::upper($item->designationName),
                    '1ST' => $initAppraisal,
                    '2ND' => $initAppraisal,
                    'OTHERS' => $initAppraisal,
                    'remarks' => ''
                ];

            foreach ($appraisals as $appraisal) {
                $returnData[$appraisal->semester]['numeric'] = $appraisal->numericRating;
                $returnData[$appraisal->semester]['adjectival'] = $appraisal->adjectivalRatingCode;

                $returnData['remarks'] .= ' ' . $appraisal->remarks;
            }

            $returnData['remarks'] = ltrim($returnData['remarks']);

            return json_decode(json_encode($returnData), FALSE);
        })
            ->filter()
            ->sortBy('name')
            ->values()
            ->toArray()
        ];
    }

    public function awardSummary($prepared = '', $preparedPosition = '', $noted = '', $notedPosition = '')
    {
        $data = $this->awardSummaryData();
        $data->prepared = $prepared;
        $data->preparedPosition = $preparedPosition;
        $data->noted = $noted;
        $data->notedPosition = $notedPosition;

        $report = new Mpdf($this->AWARD_SUMMARY_DATA);
        $report->setAutoTopMargin = 'stretch';

        $template = new LaborTemplate;
        $report->WriteHTML($template->awardSummary($data));

        return $report;
    }

    public function awardSummaryData()
    {
        $data = Award::all()->map(fn($item) => (object)[
        'name' => $item->employee->name,
        'date_awarded' => $item->dateAwardedOnDisplay,
        'type' => $item->type,
        'activity' => $item->activity,
        'remarks' => $item->remarks,
        ])
            ->sortBy('name');

        return (object)[
            'items' => $data
        ];
    }

    public function offenseSummary($prepared = '', $preparedPosition = '', $noted = '', $notedPosition = '')
    {
        $data = $this->offenseSummaryData();
        $data->prepared = $prepared;
        $data->preparedPosition = $preparedPosition;
        $data->noted = $noted;
        $data->notedPosition = $notedPosition;

        $report = new Mpdf($this->OFFENSE_SUMMARY_DATA);
        $report->setAutoTopMargin = 'stretch';

        $template = new LaborTemplate;
        $report->WriteHTML($template->offenseSummary($data));

        return $report;
    }

    public function offenseSummaryData()
    {
        $data = Offense::all()->map(fn($item) => (object)[
        'name' => $item->employee->name,
        'received_date' => $item->receivedDateOnDisplay,
        'type' => $item->type,
        'offense' => $item->offense,
        'corrective_action_taken' => $item->corrective_action_taken,
        'status' => $item->status,
        'remarks' => $item->remarks,
        'memo_date' => $item->memoDateOnDisplay,
        ])
            ->sortBy('name');

        return (object)[
            'items' => $data
        ];
    }
}