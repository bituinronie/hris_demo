<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use App\Traits\SettingTrait;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    use SettingTrait;

    public function __construct(
        public Request $REQUEST
    ){}

    /**
     * get value from body
     * 
     * @return array|boolean|object
     */
    private function getValueFromBody(){
        $keyName = strtoupper($this->REQUEST->route()->parameters['key']);

        if(in_array($keyName, $this->ARR_KEY)) {
            if($keyName == 'UPDATE_EMPLOYEE')
                $this->REQUEST->validate([
                    'value' => 'required|array',
                    'value.from' => 'required|date_format:Y-m-d',
                    'value.to' => 'required|date_format:Y-m-d|gte:value.from'
                ]);
            if($keyName == 'FLEXI')
                $this->REQUEST->validate([
                    'value' => 'required|array',
                    'value.from' => 'required|date_format:H:i:s',
                    'value.to' => 'required|date_format:H:i:s|gte:value.from'
                ]);
        }else if(in_array($keyName, $this->BOOLEAN_KEY)) {
            $this->REQUEST->validate([ 'value' => 'required|boolean' ]);
        }else {
            $this->REQUEST->validate([ 'value' => 'nullable' ]);
        }

        return $this->REQUEST->value ?? null;
    }

    /**
     * getting the setting value
     * 
     * @param string $key 
     */
    public function search(string $key){
        $this->checkUserAccess(auth()->user(), 'search setting');

        $upperKey = strtoupper($key);

        $entity = Setting::findByKey($upperKey);

        if($entity == null)
            return response()->json(['message' => 'no setting found.'], 400);

        return response()->json(['message' => $entity->value], 200);
    }

    /**
     * updating setting value
     * 
     * @param string $key
     */
    public function update(string $key){
        $this->checkUserAccess(auth()->user(), 'write setting');

        $upperKey = strtoupper($key);
        $value = $this->getValueFromBody();

        $entity = Setting::findByKey($upperKey);
        $entity->value = $value;

        $entity->save();

        return response()->json(null, 204);
    }
}
