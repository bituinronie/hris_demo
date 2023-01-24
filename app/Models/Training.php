<?php
namespace App\Models;

use App\Models\Training;
use App\Traits\ModelTrait;

use App\Traits\Scopes\ModelScope;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;

use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory, ModelScope, ModelAttribute, SoftDeletes, LogsActivity, ModelTrait;

    protected $fillable = [
        'program',
        'type_of_ld',
        'sponsored_by',
        'is_foreign',
        'conducted_by',
        'description',
    ];

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected static $logName = 'Training';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Training is $eventName";
    }
    
    public function employeeTrainings()
    {
        return $this->hasMany(EmployeeTraining::class);
    }

    public function getLocationAttribute(){
        $location = null;
        if($this->is_foreign !== null)
            $location = $this->is_foreign?'FOREIGN':'LOCAL';

        return $location;
    }
}