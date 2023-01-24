<?php
namespace App\Console\ContextClasses;

/**
 * Primary Classes
 */
class IndexClass
{
    public $CONTEXT_URL = 'app/Context';
    public $MODEL_URL = 'app/Models';
    public $MIGRATION_URL = 'database/migrations';
    public $CONTROLLER_URL = 'app/Http/Controllers/Api';
    public $ROUTE_URL = 'routes/api.php';
    public $API_DOCS_URL = 'api-docs';

    /**
     * Saving a File
     * 
     * @return void
     */
    public function createJSONFile(string $fileUrl, array $fileContent)
    {
        $myfile = fopen($fileUrl, "w");
        fwrite($myfile, json_encode($fileContent, JSON_PRETTY_PRINT));
        fclose($myfile);
    }

    /**
     * Saving a File
     * 
     * @return void
     */
    public function createFile(string $fileUrl, string $fileContent)
    {
        $myfile = fopen($fileUrl, "w");
        fwrite($myfile, $fileContent);
        fclose($myfile);
    }

    /**
     * Append a File
     * 
     * @return void
     */
    public function appendFile(string $fileUrl, string $fileContent)
    {
        $myfile = fopen($fileUrl, "a");
        fwrite($myfile, $fileContent);
        fclose($myfile);
    }

    /**
     * Convert JSON file to json
     * 
     * @return array|false
     */
    public function getJSONFile(string $fileUrl)
    {
        $extension = pathinfo($fileUrl, PATHINFO_EXTENSION);
        if ($extension != 'json')
            return false;

        $strJSON = file_get_contents($fileUrl);

        return json_decode($strJSON, true);
    }
}