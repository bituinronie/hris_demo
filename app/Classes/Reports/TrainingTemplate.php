<?php
namespace App\Classes\Reports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Classes\Template;

class TrainingTemplate implements FromView
{
    use Template {
        Template::__construct as private __templateConstruct;
    }

    public function __construct($data){
        $this->__templateConstruct(true); // init constructor for TemplateTrait

        $data->put('upperHeader', $this->UPPER_HEADER);
        $data->put('departmentName', $this->DEPARTMENT_NAME);
        $data->put('officeName', $this->OFFICE_NAME == 'N/A'?null:$this->OFFICE_NAME);

        $this->DATA = $data;
    }
    public function view() : View {
        return view('exports.st', $this->DATA);
    }
}
