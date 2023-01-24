<?php
namespace App\Models;

use App\Casts\AsObject;
use App\Traits\ModelTrait;

use Illuminate\Support\Carbon;
use App\Traits\Scopes\ModelScope;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Applicant extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    protected $fillable = [
        'firstName',
        'lastName',
        'middleName',
        'nameExtension',

        'civilStatus',
        'birthdate',
        'height',
        'gender',
        'address',
        'contactNumber',
        'email',

        'currentPosition',
        'employmentStatus',
        'yearsInCurrentPosition',
        'college',
        'workExperience',
        'training',
        'eligibility',

        'positionTitle',
        'vacantOnPositions',
        'placeOfAssignment',
        'dateOfPublication',
        'positionEducation',
        'positionTraining',
        'positionExperience',
        'positionEligibility',

        'dateReceived',
        'remarks',
    ];

    protected $hidden = [
    ];

    protected $casts = [
        'birthdate' => 'datetime:Y-m-d',
        'college' => AsObject::class,
        'workExperience' => AsObject::class,
        'training' => AsObject::class,
        'eligibility' => 'array',
        'dateOfPublication' => 'datetime:Y-m-d',
        'dateReceived' => 'datetime:Y-m-d',
    ];

    protected static $logName = 'Applicant';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Applicant is $eventName";
    }

    public function getFullNameAttribute(){
        $name = $this->firstName;
        if($this->middleName != null)
            $name .= " ".$this->middleName[0]."."; // get the first letter
        $name .= " {$this->lastName} {$this->nameExtension}";

        return trim($name, ' ');
    }

    public function getAgeAttribute(){
        return (integer) $this->birthdate->diff(Carbon::now())->format('%y');
    }

    public function getHeightInFeetAttribute(){
        $inches = ceil($this->height * 39.3701);
        $feet = floor(($inches/12));
        $measurement = "$feet'".($inches%12);
        return $measurement;
    }

    public function getGenderMinAttribute(){
        return match($this->gender) {
            'MALE' => 'M',
            'FEMALE' => 'F',
            default => null
        };
    }

    public function getCollegeOnReportAttribute(){
        if(!$this->college)
            return "none";

        return collect($this->college)->map(function($item) {
            $returnString = "{$item->course} ({$item->school}";

            if($item?->yearGraduated)
                $returnString .=" {$item->yearGraduated}";

            if($item?->units)
                $returnString .= " {$item->units} Units";

            $returnString .= ")";

            return $returnString;
        })->implode('; ');
    }

    public function getWorkExperienceOnReportAttribute(){
        if(!$this->workExperience)
            return "none";

        return collect($this->workExperience)->map(function($item) {
            $returnString = "{$item->position} ({$item->company}";

            if($item?->dateFrom && $item->dateTo) {
                $dateFrom = Carbon::parse($item->dateFrom)->format('F Y');
                $dateTo = Carbon::parse($item->dateTo)->format('F Y');

                $returnString .=" $dateFrom - $dateTo";
            }else if($item?->dateFrom) {
                $dateFrom = Carbon::parse($item->dateFrom)->format('F Y');

                $returnString .=" $dateFrom - Present";
            }

            $returnString .= ")";

            return $returnString;
        })->implode('; ');
    }

    public function getTrainingOnReportAttribute(){
        if(!$this->training)
            return "none";

        return collect($this->training)
                ->map(fn($item) => "{$item->title} ({$item->hours} hrs. {$item->year})")
                ->implode('; ');
    }

    public function getEligibilityOnReportAttribute(){
        if(!$this->eligibility)
            return "none";

        return collect($this->eligibility)->implode('; ');
    }

}