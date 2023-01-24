<?php

namespace App\Traits\Reports;

use App\Models\Applicant;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Classes\Reports\ApplicationMatrixTemplate;

/**
 * Application Matrix
 */
trait ApplicationMatrix
{
    public function am($positionName){
        return Excel::download(new ApplicationMatrixTemplate($this->amData($positionName)), $this->AM);
    }

    public function amData($positionName){
        $data = Applicant::where('positionTitle', $positionName)->get();

        $firstData = $data[0];

        return collect([
            'positionTitle' => $firstData->positionTitle,
            'vacantPosition' => $firstData->vacantOnPositions,
            'placeOfAssignment' => $firstData->placeOfAssignment,
            'dateOfPublication' => $firstData->dateOfPublication,
            'positionEducation' => $firstData->positionEducation,
            'positionTraining' => $firstData->positionTraining,
            'positionExperience' => $firstData->positionExperience,
            'positionEligibility' => $firstData->positionEligibility,
            'data' => $data->map(fn($item) => (object) [
                'name' => $item->fullName,
                'currentPosition' => $item->currentPosition,
                'employmentStatus' => $item->employmentStatus,
                'yearsInCurrentPosition' => $item->yearsInCurrentPosition,
                'civilStatus' => ucfirst(Str::lower($item->civilStatus)),
                'age' => $item->age,
                'birthdate' => $item->birthdate->format('F d, Y'),
                'height' => $item->heightInFeet,
                'gender' => $item->genderMin,
                'college' => $item->collegeOnReport,
                'workExperience' => $item->workExperienceOnReport,
                'training' => $item->TrainingOnReport,
                'eligibility' => $item->eligibilityOnReport,
                'address' => $item->address,
                'contactNumber' => $item->contactNumber,
                'email' => $item->email,
                'dateReceived' => $item->dateReceived->format('d/m/Y'),
                'remarks' => $item->remarks
            ])->toArray()
        ]);
    }

    public function checkPositionName($positionName){ // TODO
        return Applicant::where('positionTitle', $positionName)->first();
    }
}

