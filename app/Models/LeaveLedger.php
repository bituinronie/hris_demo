<?php
namespace App\Models;

use App\Models\Employee;
use Carbon\CarbonPeriod;

use App\Traits\ModelTrait;
use Illuminate\Support\Str;

use App\Notifications\Request;
use Illuminate\Support\Carbon;
use App\Traits\LeaveLedgerTrait;
use App\Traits\Scopes\ModelScope;
use Spatie\MediaLibrary\HasMedia;
use App\Notifications\PortalRequest;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Attributes\ModelAttribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveLedger extends Model implements HasMedia
{
    use HasFactory, ModelScope, ModelAttribute, LogsActivity, ModelTrait, InteractsWithMedia, LeaveLedgerTrait;

    protected $fillable = [
        'employee_id',
        'from',
        'to',
        'request_type_id',
        'others_description',
        'credit',
        'ot_json',
        'status',
        'reason',
        'proof_type',
        'proof',
        'ob_venue',
        'is_paid',
        'remarks',
        'is_start',
        'approverStatus',
    ];

    static public $temporaryProof = null;
    static public $isToRevertBalance = false;

    protected $hidden = [
    ];

    protected $casts = [
        'is_start' => 'boolean',
        'from' => 'datetime:Y-m-d H:i:s',
        'to' => 'datetime:Y-m-d H:i:s',
        'ot_json' => 'array',
        'approverStatus' => 'array',
    ];

    protected static $logName = 'Leave Ledger';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A Leave Ledger is $eventName";
    }
    
    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function requestType()
    {
        return $this->hasOne(RequestType::class, 'id', 'request_type_id');
    }

    protected static function boot(){
        parent::boot();

        LeaveLedger::creating(function($model) {
             // preparing proof
             if(isset($model->proof)) {
                self::$temporaryProof = $model->proof;
            }

            unset($model->proof);

            if($model->status == 1) {
                // generate approverStatus 
                $model->approverStatus = self::initApproverStatus($model->employee, $model->requestType->category);
            }
        });

        LeaveLedger::updating(function($model) {
            // preparing proof
            if(isset($model->proof)) {
                self::$temporaryProof = $model->proof;
            }

            // isToRevertBalance
            if (in_array($model->getOriginal('status'), [2, 5, 6]) && $model->status == 4)
                $model->isToRevertBalance = true;

            unset($model->proof);
        });

        LeaveLedger::created(function($model) {
            // Proof Attatchment
            if(self::$temporaryProof) {
                $model->addMedia(self::$temporaryProof)
                    ->toMediaCollection('proof');

                self::$temporaryProof = null;
            }

            if($model->status == 1) { // notify the approver
                $isNotified = self::notifyApprover($model);

                if(!$isNotified) {
                    $hasDisapproved = collect($model->approverStatus)->isOnArray(3);

                    if(!$hasDisapproved)
                        $model->status = 2;
                    else
                        $model->status = 3;

                    $model->save();
                }

            }else if($model->status == 6) { // manual
                // affected related request
                self::applyRelatedRequest($model);
            }

            // is_start reset
            if($model->is_start)
                self::clearIsStart($model->employee, $model);
        });

        LeaveLedger::updated(function($model) {
            // Proof Attatchment
            if(self::$temporaryProof) {
                if($model->proofUrl != null)
                    $model->getMedia('proof')->first()->delete();

                $model->addMedia(self::$temporaryProof)
                    ->toMediaCollection('proof');

                self::$temporaryProof = null;
            }

            if($model->status == 1) { // (request) notify the approver
                $isNotified = self::notifyApprover($model);

                if(!$isNotified) {
                    $hasDisapproved = collect($model->approverStatus)->isOnArray(3);

                    if(!$hasDisapproved)
                        $model->status = 2;
                    else
                        $model->status = 3;

                    $model->save();
                }

            }else if($model->status == 2) { // approved
                // send to own email request approved
                $model->employee->user->notify(new PortalRequest($model));

                // affected related request
                self::applyRelatedRequest($model);
            }else if($model->status == 3) { // disapproved
                // send to own email request approved
                $model->employee->user->notify(new PortalRequest($model));
            }else if($model->status == 4) { // cancelled
                if($model->is_start) { // reverting to is_start false
                    $model->is_start = false;
                    $model->save();
                }

                if($model->isToRevertBalance)
                    self::cancelRelatedRequest($model);
            }else if($model->status == 5) { // automatic
                // send to own email request approved
                $model->employee->user->notify(new PortalRequest($model));

                // affected related request
                self::applyRelatedRequest($model);
            }else if($model->status == 6) { // manual
                // affected related request
                self::applyRelatedRequest($model);
            }

            // is_start reset
            if($model->is_start)
                self::clearIsStart($model->employee, $model);
        });
    }

    public static function findToApprove($leaveLedgerId, $employee = null){
        if(!$employee)
            $employee = auth()->user()->employee;

        if(!$employee)
            return null;

        $leaveLedger = self::find($leaveLedgerId);

        if(!$leaveLedger)
            return null;

        if(!self::isToApprove($employee, $leaveLedger))
            return null;

        return $leaveLedger;
    }

    public function getApproverInfoAttribute(){
        $approverData = $this->employee->approver;
        $approverData->isShowUser = true;

        $returnData = [];
        $i = 0;

        for ($i=1; $i <= count($this->approverStatus); $i++) { 
            $returnData[] = $approverData->{"{$this->requestCategory}{$i}Data"};
        }

        return $returnData == []?null:$returnData;
    }

    public function getRequestCategoryAttribute(){
        return Str::lower($this->requestType->category);
    }

    public function getRequestNameAttribute(){
        if($this->requestType->id == 29)
            return "{$this->requestType->description}: {$this->others_description}";

        return $this->requestType->description;
    }

    public function getProofUrlAttribute(){
        return $this->getMedia('proof')->first()?->getFullUrl();
    }

    public function getIsActiveAttribute(){
        return $this->status == 1 ? true : false;
    }

    public function getIsCountedAttribute(){
        $startingDate = self::getStatingDate($this->employee_id, $this->request_type_id);

        if(!$startingDate)
            return false;

        return $this->from >= $startingDate;
    }

    public function getIsToCancelAttribute(){
        return in_array($this->status, [1,2,5]) ? $this->from >= Carbon::now() : false;
    }

    public function getCanUpdateAttribute(){
        return $this->status == 6;
    }

    public function getWorkingDaysAttribute(){
        $period = CarbonPeriod::between($this->from, $this->to);

        $i = 0;

        foreach ($period as $date) {
            $date = $date->format('Y-m-d');

            $schedule = Employee::getScheduleByDate($this->employee_id, $date, true); // true => to strictly check sched

            if ($schedule)
                $i++;
        }

        return $i;
    }

    public function getDeductedToVlAttribute(){

        if ($this->request_type_id == 1)
            return abs($this->credit);

        if ($this->request_type_id == 3)
            return abs($this->credit);

        return 0;
    }

    public function getDeductedToSlAttribute(){
        return $this->request_type_id == 2 ? abs($this->credit) : 0;
    }

    public function getStatusOnDisplayAttribute(){
        return collect($this->requestStatus)->where('id', $this->status)->first()['value'];
    }

}