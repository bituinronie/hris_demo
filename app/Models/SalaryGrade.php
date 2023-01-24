<?php
namespace App\Models;

use App\Models\Setting;
use App\Traits\ModelTrait;

use App\Traits\Scopes\ModelScope;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;

use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalaryGrade extends Model
{
    use HasFactory, ModelScope, ModelAttribute, SoftDeletes, LogsActivity, ModelTrait;

    protected $fillable = [
        'salary_grade',
        'tranche',
        'step',
        'salary',
    ];

    protected $hidden = [
        'tranche'
    ];

    protected $casts = [
    ];

    protected $appends = ['is_new'];

    protected static $logName = 'Salary Grade';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Salary Grade from Tranche: {$this->tranche}, on Step #: {$this->step}, and SG-{$this->salary_grade} is $eventName";
    }

    public static function latestSG(){
        $latestTranche = self::select('tranche')->orderBy('tranche','DESC')->first()->tranche ?? null;
        if($latestTranche == null) // catch errror
            return [];

        return self::select('id','salary_grade','salary')->where('tranche',$latestTranche)->where('step', 1)->orderBy('salary_grade','ASC')->get()->makeHidden('is_new')->map(fn($item)=>[
            'salary_grade_id' => $item->id,
            'salary_grade' => "SG-{$item->salary_grade}",
            'salary' => $item->salary
        ]);
    }

    public static function parameterSG(){
        $tranche = Setting::activeTranche();

        return self::select('id','salary_grade','salary')->where('tranche',$tranche)->where('step', 1)->orderBy('salary_grade','ASC')->get()->makeHidden('is_new')->map(fn($item)=>[
            'salary_grade_id' => $item->id,
            'salary_grade' => "SG-{$item->salary_grade}",
            'salary' => $item->salary
        ]);
    }

}