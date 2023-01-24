<?php
namespace App\Console\ContextClasses;

use App\Console\ContextClasses\IndexClass;

use Illuminate\Support\Str;

/**
 * Create Context Class
 */
class CreateClass extends IndexClass
{
    private $JSON = null;

    public function __construct($modelName){
        // table name
        $preTableName =(string) Str::of($modelName)->plural();

        $pieces = preg_split('/(?=[A-Z])/',$preTableName);
        $tableName = '';
        $routePrefix = '';
        $logName = '';
        foreach ($pieces as $piece) {
            $tableName .=strtolower($piece).'_';
            $routePrefix .=strtolower($piece).'-';
            $logName .=ucfirst($piece).' ';
        }

        $tableName = trim($tableName, "_");

        $routePrefix = trim($routePrefix, "-");
        $routePrefix = Str::singular($routePrefix);

        $logName = trim($logName, " ");
        $logName = Str::singular($logName);

        $this->JSON = [
            'modelName' => $modelName,
            'tableName' =>  $tableName,
            'entity' => [
                'example' => [
                    'definition' => '',
                    'additionalValidation' => '',
                    'additionalDefinition' => []
                ],
            ],
            "portalAccess" => [
                "search" => false,
                "update" => false,
                "create" => false,
                "delete" => false
            ],
            'hasDelete' => true,
            'isSoftDelete' => false,
            'logSetting' => null,
            'logName' => $logName,
            'controllerLocation' => '',
            'routePrefix' => $routePrefix,
            'apiVersion' => '0.0.0'
        ];

        $this->FILE_URL = $this->CONTEXT_URL."/$modelName.json";
    }

    /**
     * Executing Create Context
     * 
     * @return boolean
     */
    public function execute(){
        if(file_exists ($this->FILE_URL)) { // validating file name exists
            return false;
        }

        $this->createJSONFile($this->FILE_URL, $this->JSON);
        return true;
    }
}

