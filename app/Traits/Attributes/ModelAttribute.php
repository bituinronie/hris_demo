<?php
namespace App\Traits\Attributes;

trait ModelAttribute {
    public function getCreatedAtAttribute($date){
        return $date != null?date('Y-m-d H:i:s', strtotime($date)):null;
    }

    public function getUpdatedAtAttribute($date){
        return $date != null?date('Y-m-d H:i:s', strtotime($date)):null;
    }

    public function getDeletedAtAttribute($date){
        return $date != null?date('Y-m-d H:i:s', strtotime($date)):null;
    }

    // checking the record is new
    public function getIsNewAttribute()
    {
        $timeToday = strtotime(date('Y-m-d H:i:s'));
        $timeLastWeek = strtotime(date('Y-m-d H:i:s')." - 1 weeks");

        $isNewRecord = false;
        if($this->created_at != null)
            $isNewRecord = $timeLastWeek <= strtotime($this->created_at) && $timeToday >= strtotime($this->created_at);

        return $isNewRecord;
    }

    // is_deleted
    public function getIsDeletedAttribute(){
        return $this?->deleted_at != null;
    }
}