<?php
namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Support\Str;

use App\Traits\Scopes\ModelScope;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Approver extends Model
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait;

    public $isShowUser = false;

    protected $fillable = [
        'leaves_1',
        'leaves_2',
        'leaves_3',
        'ob_1',
        'ob_2',
        'ob_3',
        'overtime_1',
        'overtime_2',
        'overtime_3',
        'request_1',
        'request_2',
        'request_3',
    ];

    protected $hidden = [
        'leaves_1',
        'leaves_2',
        'leaves_3',
        'ob_1',
        'ob_2',
        'ob_3',
        'overtime_1',
        'overtime_2',
        'overtime_3',
        'request_1',
        'request_2',
        'request_3',
    ];

    protected $casts = [
    ];

    public function employee(){
        return $this->hasOne(Employee::class, 'approver_id', 'id');
    }

    public function leaves1Employee(){
        return $this->belongsTo(Employee::class, 'leaves_1', 'id');
    }

    public function leaves2Employee(){
        return $this->belongsTo(Employee::class, 'leaves_2', 'id');
    }

    public function leaves3Employee(){
        return $this->belongsTo(Employee::class, 'leaves_3', 'id');
    }

    public function ob1Employee(){
        return $this->belongsTo(Employee::class, 'ob_1', 'id');
    }

    public function ob2Employee(){
        return $this->belongsTo(Employee::class, 'ob_2', 'id');
    }

    public function ob3Employee(){
        return $this->belongsTo(Employee::class, 'ob_3', 'id');
    }

    public function overtime1Employee(){
        return $this->belongsTo(Employee::class, 'overtime_1', 'id');
    }

    public function overtime2Employee(){
        return $this->belongsTo(Employee::class, 'overtime_2', 'id');
    }

    public function overtime3Employee(){
        return $this->belongsTo(Employee::class, 'overtime_3', 'id');
    }

    public function request1Employee(){
        return $this->belongsTo(Employee::class, 'request_1', 'id');
    }

    public function request2Employee(){
        return $this->belongsTo(Employee::class, 'request_2', 'id');
    }

    public function request3Employee(){
        return $this->belongsTo(Employee::class, 'request_3', 'id');
    }

    protected static $logName = 'Approver';

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName=='created')
            return 'A Approver has been assigned to an employees.';
        if ($eventName=='updated')
            return 'A Approver of an employees has been updated.';
        if ($eventName=='deleted')
            return 'A Approver has been removed from an employees.';
    }

    public function getLeaves1DataAttribute() {
        $employee = $this->leaves1Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

    public function getLeaves2DataAttribute() {
        $employee = $this->leaves2Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

    public function getLeaves3DataAttribute() {
        $employee = $this->leaves3Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

    public function getOb1DataAttribute() {
        $employee = $this->ob1Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

    public function getOb2DataAttribute() {
        $employee = $this->ob2Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

    public function getOb3DataAttribute() {
        $employee = $this->ob3Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

    public function getOvertime1DataAttribute() {
        $employee = $this->overtime1Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

    public function getOvertime2DataAttribute() {
        $employee = $this->overtime2Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

    public function getOvertime3DataAttribute() {
        $employee = $this->overtime3Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

    public function getRequest1DataAttribute() {
        $employee = $this->request1Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

    public function getRequest2DataAttribute() {
        $employee = $this->request2Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

    public function getRequest3DataAttribute() {
        $employee = $this->request3Employee;

        if($employee == null)
            return null;

        $data = [
            'id' => $employee->id,
            'name' => Str::upper($employee->name),
        ];

        if($this->isShowUser)
            $data['user'] = $employee->user;

        return (object) $data;
    }

}