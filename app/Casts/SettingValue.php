<?php

namespace App\Casts;

use App\Traits\SettingTrait;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SettingValue implements CastsAttributes
{
    use SettingTrait;

    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        // init variables
        $returnValue = $value;
        $keyName = $attributes['key'];

        if(in_array($keyName, $this->ARR_KEY))
            $returnValue = json_decode($value, true);
        else if(in_array($keyName, $this->BOOLEAN_KEY))
            $returnValue = $value == 'true'?true:false;

        return $returnValue;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  array  $value
     * @param  array  $attributes
     * @return string
     */
    public function set($model, $key, $value, $attributes)
    {
        // init variables
        $returnValue = null;
        $keyName = $attributes['key'];

        if(in_array($keyName, $this->ARR_KEY))
            $returnValue = json_encode($value);
        else if(in_array($keyName, $this->BOOLEAN_KEY))
            $returnValue = $value == true?'true':'false';
        else
            $returnValue = $value;

        return $returnValue;
    }
}