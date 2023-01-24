<?php
namespace App\Classes;

use App\Models\LeaveLedger;
use Illuminate\Support\Str;
use App\Traits\ConstantTrait;

class DtrStatistic
{
    use ConstantTrait;

    // uses minutes for integer numbers
    public $diff = 0;
    public $late = 0;
    public $ut = 0;
    public $ot = 0;
    public $workMinutes = 0;

    public $remark = '';
    public $isAbsent = false;
    public $isHalfDay = false;

    public $lateCount = 0;
    public $utCount = 0;
    public $absentCount = 0;

    public $leavLedger = null;

    public function __construct($workMinutes = 0, $diff = 0, $ot = 0, $lateCount = 0, $utCount = 0)
    {
        $this->workMinutes = $workMinutes;
        $this->diff = $diff;
        $this->ot = $ot;
        $this->lateCount = $lateCount;
        $this->utCount = $utCount;
    }

    public function addDiff($diff, $for = null)
    {
        $this->diff += abs($diff);

        if ($for == 'UT')
            $this->ut += abs($diff);
        else if ($for == 'LATE')
            $this->late += abs($diff);
    }

    public function addWorkMinutes($workMinutes)
    {
        $this->workMinutes += abs($workMinutes);
    }

    public function addOt($ot, $updatedRemarks = null)
    {
        $this->ot += abs($ot);

        if ($updatedRemarks)
            $this->remark .= Str::upper($updatedRemarks);
        else
            $this->remark .= "OT;";
    }

    public function addLateCount($lateCount)
    {
        $this->lateCount += abs($lateCount);
    }

    public function addUtCount($utCount)
    {
        $this->utCount += abs($utCount);
    }

    public function addAbsentCount($absentCount = 1)
    {
        $this->absentCount += abs($absentCount);
    }

    public function addRemark($remark)
    {
        switch ($remark) {
            case 'UT':
                $this->utCount += 1;
                break;
            case 'HALF DAY':
                $this->isHalfDay = true;
                break;
            case 'LATE':
                $this->lateCount += 1;
                break;
            case 'ABSENT':
                $this->setAbsent();
                break;
        }

        $this->remark .= "$remark;";
    }

    public function addLeave($type, $leaveLedgerId)
    {
        $this->addRemark($type);
        $this->leaveLedger = LeaveLedger::find($leaveLedgerId);
    }

    public function setAbsent()
    {
        $this->isAbsent = true;
    }

    public function get()
    {
        $this->remark = $this->remark === '' ? null : Str::upper($this->remark);

        return $this;
    }

    public function diffToReadable()
    {
        return $this->toReadable($this->diff);
    }

    public function diffHours()
    {
        return (int)floor($this->diff / 60) ? (int)floor($this->diff / 60) : null;
    }

    public function diffMinutes()
    {
        return ($this->diff % 60) ? ($this->diff % 60) : null;
    }

    public function lateToReadable()
    {
        return $this->toReadable($this->late);
    }

    public function utToReadable()
    {
        return $this->toReadable($this->ut);
    }

    public function otToReadable()
    {
        return $this->toReadable($this->ot);
    }

    public function otToDays()
    {
        return $this->toDays($this->ot);
    }

    public function diffToDays()
    {
        return $this->toDays($this->diff);
    }

    public function workHours()
    {
        return $this->workMinutes / 60;
    }

    public function status()
    {
        if (!$this->workMinutes)
            return null;

        if ($this->isAbsent)
            return 'A';

        return 'P';
    // TODO: other infos
    }

    protected function toReadable($value)
    {
        if ($value === 0)
            return null;

        $hours = floor($value / 60);
        $minutes = ($value % 60);

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    // value default to minutes
    protected function toDays($value)
    {
        if ($value === 0)
            return 0.000;

        return round(($value / 60) * $this->daysPerHour, 3);
    }
}
