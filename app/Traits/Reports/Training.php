<?php

namespace App\Traits\Reports;

use App\Models\Applicant;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\EmployeeTraining;
use Maatwebsite\Excel\Facades\Excel;
use App\Classes\Reports\TrainingTemplate;
use App\Classes\Reports\ApplicationMatrixTemplate;

/**
 * Application Matrix
 */
trait Training
{
    public function st($fileName)
    {
        return Excel::download(new TrainingTemplate($this->stData()), $fileName);
    }

    public function stData()
    {
        return collect([
            'items' => EmployeeTraining::groupBy('date_from', 'date_to', 'number_of_hours')->orderBy('date_from', 'DESC')
            ->limit(3)
            ->get()
            ->map(fn($item) => (object)[
        'id' => $item->training->id,
        'program' => Str::upper($item->training->program),
        'conducted_by' => Str::upper($item->training->conducted_by),
        'description' => strip_tags($item->training->description),
        'day' => !Carbon::parse($item->date_from)->diffInDays($item->date_to) ? 1 : Carbon::parse($item->date_from)->diffInDays($item->date_to),
        'date_from' => Carbon::parse($item->date_from)->format('F d, Y'),
        'date_to' => Carbon::parse($item->date_to)->format('F d, Y'),
        'year' => Carbon::parse($item->date_from)->format('Y'),
        'number' => $item->recordedEmployeesCount
        ])->toArray()
        ]);
    }
}