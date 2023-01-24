<?php
namespace App\Console\ContextClasses;

use Exception;
use App\Exceptions\Handler;
use App\Console\ContextClasses\IndexClass;
use App\Console\ContextClasses\TemplateClass;

class GenerateClass extends IndexClass
{
    private $MODEL_NAME = null;
    private $TABLE_NAME = null;
    private $CONTROLLER_PATH = null;
    private $TEMPLATE;
    private $DATE_PREFIX = null;

    public function __construct($modelName){
        // init var
        $this->DATE_PREFIX = date('Y_m_d_His_');

        // process
        $contextFileUrl = $this->CONTEXT_URL."/$modelName.json";
        if(file_exists ($contextFileUrl)) { // validating file exists
            $JSON = $this->getJSONFile($contextFileUrl);
            if($JSON != false) {
                $this->MODEL_NAME = $JSON['modelName'];
                $this->TABLE_NAME = $JSON['tableName'];
                $this->CONTROLLER_PATH = $JSON['controllerLocation'];

                $this->TEMPLATE = new TemplateClass($JSON);
            }
        }
    }

    public function execute(){
        if($this->MODEL_NAME == null)
            return false;

        // Generate Model
        $this->generateModel();

        // Generate Migration
        $this->generateMigration();

        // Generate Controller
        $this->generateController();

        // Generate Routes
        $this->generateRoutes();

        // Generate API Docs
        $this->generateApiDocs();

        return true;
    }

    /**
     * Generate Model
     * 
     * @return boolean
     */
    private function generateModel(){
        $content = $this->TEMPLATE->getModelTemplate();
        $fileUrl = $this->MODEL_URL.'/'.$this->MODEL_NAME.".php";
        if(file_exists ($fileUrl))
            return false;

        $this->createFile($fileUrl, $content);
        return true;
    }

    /**
     * Generate Migration
     * 
     * @return boolean
     */
    private function generateMigration(){
        $content = $this->TEMPLATE->getMigrationTemplate();
        $tableFileName = 'create_'.$this->TABLE_NAME.'_table';
        $fileUrl = $this->MIGRATION_URL.'/'.$this->DATE_PREFIX.$tableFileName.'.php';
        if(file_exists ($fileUrl))
            return false;

        $this->createFile($fileUrl, $content);
        return true;
    }

    /**
     * Generate Controller w/ CRUD
     * 
     * @return boolean
     */
    private function generateController(){
        $content = $this->TEMPLATE->getControllerTemplate();
        $folderUrl = $this->CONTROLLER_URL.'/'.$this->CONTROLLER_PATH;

        if( is_dir($folderUrl) === false )
            mkdir($folderUrl);

        $fileUrl = $folderUrl.'/'.$this->MODEL_NAME.'Controller'.'.php';
        if(file_exists ($fileUrl))
            return false;

        $this->createFile($fileUrl, $content);
        return true;
    }

    /**
     * Generate Routes
     * 
     * @return boolean
     */
    private function generateRoutes(){
        $content = $this->TEMPLATE->getRouteTemplate();
        $this->appendFile($this->ROUTE_URL, $content);
        return true;
    }

    /**
     * Generate Routes
     * 
     * @return boolean
     */
    private function generateApiDocs(){
        $content = $this->TEMPLATE->generateApiDocsTemplate();

        $fileName = ucfirst($this->MODEL_NAME);
        $fileUrl = $this->API_DOCS_URL."/$fileName.yml";

       if(file_exists ($fileUrl))
            return false;

        $this->createFile($fileUrl, $content);
        return true;
    }
}
