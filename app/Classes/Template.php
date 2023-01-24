<?php
namespace App\Classes;

use App\Models\Setting;

/**
 * Template for reports
 */
trait Template
{
    public $HEADER_FONT = "'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif";
    public $BODY_FONT = "Arial, Helvetica, sans-serif";

    public $DEPARTMENT_NAME = 'N/A';
    public $OFFICE_NAME = 'N/A';

    public $UPPER_HEADER = null;
    public $HEADER = null;
    public $ADDRESS = null;
    public $CONTACT_NUMBER = null;

    public function __construct($isRepublic = false){
        $reportSettings = Setting::reportSettings();
        $this->ADDRESS = $reportSettings->address;
        $this->CONTACT_NUMBER = $reportSettings->contact_number;

        $this->DEPARTMENT_NAME = env('DEPARTMENT_NAME','N/A');
        $this->OFFICE_NAME = env('OFFICE_NAME','N/A');
        $this->UPPER_HEADER = env('OFFICE_NAME') && !$isRepublic ? env('DEPARTMENT_NAME') : "Republic of the Philippines";
        $this->HEADER = env('OFFICE_NAME') ?? env('DEPARTMENT_NAME');
    }

    public function applyHtmlTemplate($fileName, $styles, $body, $header = '', $footer='')
    {
        return "
            <!DOCTYPE html>
            <html>
                <head>
                    <title>$fileName</title>
                </head>
                <style>
                    $styles
                    @page {
                        header: page-header;
                        footer: page-footer;
                    }
                </style>
                <body>
                    <htmlpageheader name=\"page-header\">
                        $header
                    </htmlpageheader>
                    <htmlpagefooter name=\"page-footer\">
                        $footer
                    </htmlpagefooter>

                    $body
                </body>
            </html>";
    }

    public function image($fileName){
        $path = public_path("/img/$fileName");

        return $path;
    }
}
