<?php
namespace App\Traits\Reports;

use Mpdf\Mpdf;
use App\Models\Remark;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Support\Str;
use App\Models\ServiceRecord;
use App\Traits\ConstantTrait;
use App\Models\EmploymentStatus;
use Illuminate\Support\Collection;
use App\Classes\Reports\HistoryTemplate;

/**
 * Employee Management Trait
 */
trait History
{
    use ConstantTrait;

    public $SR_SETTING = [
        'format' => [215.9, 279.4],
        'margin_left' => 5,
        'margin_right' => 5,
        'margin_top' => 5,
        'margin_bottom' => 5
    ];

    public $MU_SETTING = [
        'format' => [215.9, 279.4],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 10
    ];

    public $MC_SETTING = [
        'format' => [279.4,215.9],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    public $SS_SETTING = [
        'format' => [215.9,279.4],
        'margin_left' => 10,
        'margin_right' => 10,
        'margin_top' => 25,
        'margin_bottom' => 8
    ];

    //* Validation
    public function checkEmployeeId($employeeId){
        if($employeeId == null)
            return false;

        return Employee::find($employeeId)?true:false;
    }

    public function sr($id, $name = '', $position = '', $division = ''){
        $data = $this->srData($id);
        $data->supervisorName = $name;
        $data->supervisorPosition = $position;
        $data->supervisorDivision = $division;

        $report = new Mpdf($this->SR_SETTING);
        
        $template = new HistoryTemplate;
        $report->WriteHTML($template->sr($data));

        return $report;
    }

    public function mu($prepared = '', $preparedPosition = '', $supervisor = '', $supervisorPosition = ''){
        $data = $this->muData();
        $data->prepared = Str::upper($prepared);
        $data->preparedPosition = Str::upper($preparedPosition);
        $data->supervisor = Str::upper($supervisor);
        $data->supervisorPosition = Str::upper($supervisorPosition);

        $report = new Mpdf($this->MU_SETTING);
        
        $template = new HistoryTemplate;
        $report->WriteHTML($template->mu($data));

        return $report;
    }

    public function mc($prepared = '', $preparedPosition = '', $preparedDivision = '', $supervisor = '', $supervisorPosition = '', $supervisorDivision = ''){
        $data = $this->mcData();
        $data->prepared = Str::upper($prepared);
        $data->preparedPosition = Str::upper($preparedPosition);
        $data->preparedDivision = Str::upper($preparedDivision);

        $data->supervisor = Str::upper($supervisor);
        $data->supervisorPosition = Str::upper($supervisorPosition);
        $data->supervisorDivision = Str::upper($supervisorDivision);

        $report = new Mpdf($this->MC_SETTING);
        
        $template = new HistoryTemplate;
        $report->WriteHTML($template->mc($data));

        return $report;
    }

    public function ss($prepared = '', $preparedPosition = '', $preparedDivision = '', $supervisor = '', $supervisorPosition = '', $supervisorDivision = ''){
        $data = $this->ssData();
        $data->prepared = Str::upper($prepared);
        $data->preparedPosition = Str::upper($preparedPosition);
        $data->preparedDivision = Str::upper($preparedDivision);

        $data->supervisor = Str::upper($supervisor);
        $data->supervisorPosition = Str::upper($supervisorPosition);
        $data->supervisorDivision = Str::upper($supervisorDivision);

        $report = new Mpdf($this->SS_SETTING);
        
        $template = new HistoryTemplate;
        $report->WriteHTML($template->ss($data));

        return $report;
    }

    public function srData($id){
        // employee record
        $employee = Employee::find($id);
        $returnEmployee = (object) [
            'first_name' => Str::upper($employee['first_name']),
            'middle_name' => Str::upper($employee['middle_name']),
            'last_name' => Str::upper($employee['last_name']),
            'name_extension' => Str::upper($employee['name_extension']),
            'birth_date' => Str::upper(date("F d, Y", strtotime($employee['birth_date']))),
            'birth_place' =>  Str::upper($employee['birth_place'])
        ];

        // service record
        $serviceRecords = $employee->serviceRecords()->orderBy('date_from','ASC')->where('show_in_reports',1)->get();
        $data = $serviceRecords->map(function($item, $key) {
            return $item->toPrint();
        });
        $returnData = $data->toUpper()->chunk(20)->toArray();

        return (object) [
            'employee' => $returnEmployee,
            'serviceRecords' => $returnData
        ];
    }

    public function muData(){
        $srData = ServiceRecord::select('id','employee_id','level','employment_status_id','remark_id')->orderBy('date_from','DESC')->get();

        $empArr = [];

        $remarkIdsApplied = [21,3,4,7,5,22,23,19,17,18,29,20];

        $data = Remark::whereIn('id', $remarkIdsApplied)->get()->mapWithKeys(function($item){
                    //                                 PA PERMA  C1 C2 PRO   TEM  TC JO  CON  CASUAL
                    //                                 0  1 2 3  4  5  6 7   8 9  10 11 12 13 14 15
                    //                                    1 2 3        1 2   1 2         1 2  1 2
            return [Str::lower($item->description) => [0, 0,0,0, 0, 0, 0,0,  0,0, 0, 0,  0,0, 0,0]];

        })->toArray();

        $statusCond = function ($statusId) {
            return match($statusId) {
                1 => 0,
                2 => 1,
                3 => 4,
                12 => 5,
                5 => 6,
                4 => 8,
                13 => 10,
                10 => 11,
                6 => 12,
                9 => 14,
                default => null
            };
        };

        foreach ($srData as $value) {
            $i = null;
            if(!in_array($value['employee_id'], $empArr)){
                if (!is_null($value->remark_id)) {
                    $remark =  Remark::find($value->remark_id);
                    
                    $rem = Str::lower($remark->description);
                } else {
                    $rem = "";
                }

                $i = $statusCond($value->employment_status_id);

                if ($i === null) {
                    $empArr[] = $value->employee_id;
                    continue;
                }

                if(!in_array($value->employment_status_id, [1,3,10,12,13])) {
                    $i += match ($value->level) {
                        "1ST" => 0,
                        "2ND" => 1,
                        "3RD" => 2
                    };
                }

                

                if(isset($data[$rem])){
                    $data[$rem][$i] = $data[$rem][$i] + 1;
                }

                $empArr[] = $value->employee_id;
            }
        }

        return (object) [
            'data' => $data
        ];
    }

    public function mcData(){
        $srData = ServiceRecord::select('id','employee_id','employment_status_id','level','is_uniformed','remark_id')
                                ->orderBy('date_from','DESC')
                                ->get();

        $empArr = [];
        $data = [
            '1st' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ],
            '2nd' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ],
            '3rd' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ],
            'coterminus' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ],
            'casual' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ],
            'contractual' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ],
            'contractual' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ],
            'presidential' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ],
            'cos' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ],
            'jo' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ],

            'sub-total' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ],
            'total' => [
                'uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ],
                'non-uniformed' =>[
                    'male' => 0,
                    'female' => 0
                ]
            ]
        ];

        foreach ($srData as $value) {
            if(in_array($value->employee_id, $empArr) == false){
                if(!in_array($value->employment_status_id, $this->remarkIdNotApplied)) {
                    $empArr[] = $value->employee_id;
                    continue;
                }

                if($value->is_uniformed == 1){
                    $is_uniformed = "uniformed";
                }elseif($value->is_uniformed == 0){
                    $is_uniformed = "non-uniformed";
                }

                if(isset($is_uniformed)){
                    $gender = Str::lower(Employee::find($value['employee_id'])->gender);


                    if($value['employment_status_id'] == 3){
                        $data['coterminus'][$is_uniformed][$gender] += 1;
                        $data['sub-total'][$is_uniformed][$gender] += 1;
                        $data['total'][$is_uniformed][$gender] += 1;
                    }elseif($value['employment_status_id'] == 9){
                        $data['casual'][$is_uniformed][$gender] += 1;
                        $data['sub-total'][$is_uniformed][$gender] += 1;
                        $data['total'][$is_uniformed][$gender] += 1;
                    }elseif($value['employment_status_id'] == 6){
                        $data['contractual'][$is_uniformed][$gender] += 1;
                        $data['sub-total'][$is_uniformed][$gender] += 1;
                        $data['total'][$is_uniformed][$gender] += 1;
                    }elseif($value['employment_status_id'] == 1){
                        $data['presidential'][$is_uniformed][$gender] += 1;
                        $data['sub-total'][$is_uniformed][$gender] += 1;
                        $data['total'][$is_uniformed][$gender] += 1;
                    }elseif($value['employment_status_id'] == 11){
                        $data['cos'][$is_uniformed][$gender] += 1;
                        $data['total'][$is_uniformed][$gender] += 1;
                    }elseif($value['employment_status_id'] == 10){
                        $data['jo'][$is_uniformed][$gender] += 1;
                        $data['total'][$is_uniformed][$gender] += 1;
                    }else{
                        $data[$value['level']][$is_uniformed][$gender] += 1;
                        $data['sub-total'][$is_uniformed][$gender] += 1;
                        $data['total'][$is_uniformed][$gender] += 1;
                    }
                }

                $empArr[] = $value['employee_id'];
            }

        }

        return json_decode(
            json_encode(
                $data
            )
        );
    }

    // TODO
    public function ssData(){
        $positions = Position::all();

        $initTotal = [
            'authorized' => 0,
            'filled' => 0,
            'vacant' => 0
        ];

        $data = [
            'data' => [],
            'total' => $initTotal
        ];

        $appendToData = function($position, $to, $data) use($initTotal) {
            if(!isset(
                    $data['data']
                        [$position->fundingSourceDescription]
                        [$position->employmentStatusDescription]
                        ['data']
                        [$position->ssDescription]
                )
            ) {
                $data['data']
                    [$position->fundingSourceDescription]
                    [$position->employmentStatusDescription]
                    ['data']
                    [$position->ssDescription] = $initTotal;

                if(!isset(
                        $data['data']
                            [$position->fundingSourceDescription]
                            [$position->employmentStatusDescription]
                            ['total']
                    )
                ) {
                    $data['data']
                        [$position->fundingSourceDescription]
                        [$position->employmentStatusDescription]
                        ['total'] = $initTotal;
                }
            }

            $data['data']
                [$position->fundingSourceDescription]
                [$position->employmentStatusDescription]
                ['data']
                [$position->ssDescription]
                [$to] += 1;

            $data['data']
                [$position->fundingSourceDescription]
                [$position->employmentStatusDescription]
                ['total']
                [$to] += 1;

            $data['total']
                [$to] += 1;

            return $data;
        };


        foreach ($positions as $position) {

            $data = $appendToData($position, 'authorized', $data);

            if($position->employeeAssignedTo) {
                $data = $appendToData($position, 'filled', $data);
            }else {
                $data = $appendToData($position, 'vacant', $data);

            }
        }

        return json_decode(
            json_encode(
                $data
            )
        );
    }
}