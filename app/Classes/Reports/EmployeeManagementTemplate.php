<?php
namespace App\Classes\Reports;

use App\Classes\Template;
use Illuminate\Support\Str;

class EmployeeManagementTemplate
{
    use Template;

    public function pds($data){
        // style
        $style = "
            table, td, td {
                margin: 0 auto;
            border-collapse: collapse;
            }
            table {
                width: 100%;
                border: 2px solid black;
            }
            td {
                font-family: {$this->BODY_FONT};
            }
            .topText {
                position: absolute;
                top : 28px;
                left: 16px;
            }
            .top-text {
                font-family: {$this->HEADER_FONT};
                font-weight: bold;
                font-style: italic;
                font-size: 8px;
            }
            p.title {
                font-size: 22px;
                font-weight: bold;
                text-align: center;
            }
            p.body {
                font-size: 7px;
                font-weight: bold;
                text-align: left;
            }
            p.italic-body {
                font-size: 8px;
                font-weight: bold;
                text-align: left;
                font-style: italic;
            }
            td.light-body {
                font-size: 7px;
                font-weight: 400;
                text-align: left;
            }
            td.cs-id {
                font-size: 8px;
                font-weight: 400;
                text-align: left;
                background-color: rgb(150,150,150);
                border: 1px solid black;
            }
            td.cs-id-text {
                font-size: 6px;
                font-weight: 400;
                text-align: right;
                border: 1px solid black;
            }
            tr.after-title{
                border-bottom: 4px solid black;
            }
        
            td.sub-title{
                font-size: 13px;
                font-weight: bold;
                text-align: left;
                color: white;
                font-style: italic;
                font-stretch:ultra-condensed;
                padding-top: 1px;
                padding-bottom: 1px;
                background-color: rgb(150,150,150);
            }
            tr.after-sub-title{
                border: 2px solid black;
            }
        
            td{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 9px;
            }
        
            .number {
                text-align:left;
                vertical-align: text-top;
                background-color: rgb(234, 234, 234);
                font-size: 8px;
            }
        
            .key {
                background-color: rgb(234, 234, 234);
                border-right: 1px solid black;
            }
            .citi-key {
                border-left: 1px solid black;
            }
        
            .value {
                border: 1px solid black;
            }
        
            .zero-value {
                border: 0px solid black;
            }
        
            .border-key {
                border-top: 1px solid black;
            }
        
            .zero-right-border {
                border-right: 0px solid black;
            }
        
            .zero-left-border {
                border-left: 0px solid black;
            }
            .zero-bottom-border {
                border-bottom: 0px solid black;
            }
            .zero-top-border {
                border-top: 0px solid black;
            }
            .border-right {
                border-right: 1px solid black;
            }
        
            .middle-border {
                border-left: 2px solid black;
            }
            .up-down-border {
                border-top: 2px solid black;
                border-bottom: 2px solid black;
            }
            .value-up-down-border {
                border-top: 1px solid black;
                border-bottom: 1px solid black;
            }
            .sharp-border {
                border: 2px solid black;
            }
            .zero-border {
                border-left: 0px solid black;
            }
            .border-top {
                border-top: 1px solid black;
            }
        
            .bottom-text {
                font-family: {$this->BODY_FONT};
                font-size: 7px;
                text-align: right;
            }
            .sharp-right-border{
                border-right: 2px solid black;
            }
            .sharp-left-border{
                border-left: 2px solid black;
            }
            .no-border {
                border: 0px solid black;
            }
            u {
                text-decoration: none;
                border-bottom: 1px solid black;
            }
        ";

        $footer = "
        <div style=\"position: absolute; top: 348mm; right: 3mm;\">
            <p class=\"bottom-text\"><i><br>CS FORM 212 (Revised 2017), Page {PAGENO} of {nb}</i></p>
        </div>";

        // body
        $body = "
            <div class=\"topText\">
                <p class=\"top-text\">CS Form No. 212 <br>Revised 2017</p>
            </div>

            <table cellpadding=\"5\">
                <tr>
                    <td width=\"100%\" colspan=\"14\">
                        <center>
                            <br>
                            <p class=\"title\">PERSONAL DATA SHEET</p>
                            <br>
                        </center>

                    </td>
                </tr>
                <tr>
                    <td width=\"100%\" colspan=\"14\">
                    <br>
                    <p class=\"body\"><i>WARNING:</i> Any misrepresentation made in the Personal Data Sheet and the Work Experience Sheet shall cause the filing of administrative/criminal case/s against the person concerned.</p>
                    <p class=\"italic-body\"><br> READ THE ATTACHED GUIDE TO FILLING OUT THE PERSONAL DATA SHEET (PDS) BEFORE ACCOMPLISHING THE PDS FORM.</p>
                    </td>
                </tr>

                <tr class=\"after-title\">
                    <td width=\"72%\" colspan=\"10\" class=\"light-body\">
                        Print legibly. Tick appropriate boxes(<input type=\"checkbox\"/>) and use separate sheet if necessary. Indicate N/A if not applicable. <b>DO NOT ABBREVIATE.</b>
                    </td>
                    <td width =\"8%\" colspan=\"1\" class=\"cs-id\">
                        1. CS ID No.
                    </td>
                    <td width=\"20%\" colspan=\"3\" class=\"cs-id-text\">
                        (Do not fill up. For CSC use only)
                    </td>
                </tr>

                <tr class=\"after-sub-title\">
                    <td width=\"100%\" colspan=\"14\" class=\"sub-title\">I. PERSONAL INFORMATION</td>
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" class=\"number\"><p>2.</p></td>
                    <td width=\"15%\" colspan=\"2\" class=\"key\"><p>SURNAME</p></td>
                    <td width=\"84%\" colspan=\"11\" class=\"value\">{$data->last_name}</td>
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" class=\"number\"></td>
                    <td width=\"15%\" colspan=\"2\" class=\"key\"><p>FIRST NAME</p></td>
                    <td width=\"59%\" colspan=\"8\" class=\"value\">{$data->first_name}</td>
                    <td width=\"25%\" colspan=\"3\" class=\"key\"><p style=\"vertical-align: text-top; text-align: left; font-size:6px; padding-top: 0;\">NAME EXTENSION (JR., SR) </p>{$data->name_extension}</td>
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" class=\"number\"></td>
                    <td width=\"15%\" colspan=\"2\" class=\"key\"><p>MIDDLE NAME</p></td>
                    <td width=\"84%\" colspan=\"11\" class=\"value\">{$data->middle_name}</td>
                </tr>
                <tr style=\"border: 1px solid black;\">
                    <td width=\"100%\" colspan=\"14\" style=\"padding: 0 auto;\"></td>
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" class=\"number\"><p>3.</p></td>
                        <td width=\"15%\" colspan=\"2\" class=\"key\">
                        <p>DATE OF BIRTH<br>
                        (mm/dd/yyyy) </p>
                    </td>

                    <td width=\"29%\" colspan=\"3\" class=\"zero\">".date('m/d/Y',strtotime($data->birth_date))."</td>
                    <td width=\"22%\" colspan=\"3\" class=\"key citi-key middle-border\" style=\" vertical-align: text-top;\"><p>16. CITIZENSHIP</p></td>";

        if($data->citizenship == "DUAL_CITIZEN")
            $body .= "
                    <td width=\"33%\" colspan=\"5\" class=\"zero-value\"><p><input type=\"checkbox\"> Filipino  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> Dual Citizenship</p></td>";
        else
            $body .= "
                    <td width=\"33%\" colspan=\"5\" class=\"zero-value\"><p><input type=\"checkbox\" checked=\"checked\"> Filipino  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> Dual Citizenship</p></td>";

        $body .= "
            </tr>
            <tr>
                <td width=\"1%\" colspan=\"1\" class=\"number\"></td>
                <td width=\"15%\" colspan=\"2\" class=\"key\"></td>
                <td width=\"29%\" colspan=\"3\" class=\"zero\"></td>
                <td width=\"22%\" colspan=\"3\" class=\"key citi-key middle-border\" style=\" vertical-align: text-top;\"></td>
                <td width=\"10%\" colspan=\"2\" class=\"zero-value\"></td>";
        if(strtoupper($data->citizenship_by) == 'BIRTH')
            $body .= "
                    <td width=\"23%\" colspan=\"3\" class=\"zero-value\"><p><input type=\"checkbox\" checked=\"checked\"> by birth <input type=\"checkbox\"> by naturalization</p></td>";
        else
            $body .= "
                    <td width=\"23%\" colspan=\"3\" class=\"zero-value\"><p><input type=\"checkbox\"> by birth <input type=\"checkbox\" checked=\"checked\"> by naturalization</p></td>";

        $body .= "
            </tr>
            <tr>
                <td width=\"1%\" colspan=\"1\" class=\"number border-key\">4. </td>
                <td width=\"15%\" colspan=\"2\" class=\"key border-key\">PLACE OF BIRTH</td>
                <td width=\"29%\" colspan=\"3\" class=\"value\">{$data->birth_place}</td>
                <td width=\"22%\" colspan=\"3\" class=\"key middle-border\" style=\"text-align: center;\">If holder of  dual citizenship, </td>
                <td width=\"10%\" colspan=\"2\" class=\"zero-value\"></td>
                <td width=\"23%\" colspan=\"3\" class=\"zero-value\"><p>Pls. indicate country:</p></td>
            </tr>
            <tr>
                <td width=\"1%\" colspan=\"1\" class=\"number border-key\">5. </td>
                <td width=\"15%\" colspan=\"2\" class=\"key border-key\">SEX</td>";
        if($data->gender == "MALE")
            $body .= "
                    <td width=\"17%\" colspan=\"1\" class=\"value zero-right-border\"><p><input type=\"checkbox\" checked=\"checked\"> Male </p></td>
                    <td width=\"12%\" colspan=\"2\" class=\"value zero-left-border\"><p><input type=\"checkbox\"/> Female </p></td>";
        else
            $body .= "
                    <td width=\"17%\" colspan=\"1\" class=\"value zero-right-border\"><p><input type=\"checkbox\"/> Male </p></td>
                    <td width=\"12%\" colspan=\"2\" class=\"value zero-left-border\"><p><input type=\"checkbox\" checked=\"checked\"> Female </p></td>";

        $body .= "
                    <td width=\"22%\" colspan=\"3\" class=\"key middle-border\" style=\" vertical-align: text-top; text-align: center;\">please indicate the details.</td>
                    <td width=\"33%\" colspan=\"5\" class=\"zero-value\" style=\"text-align: center;\"><p>{$data->citizenship_by_country}</p></td>
                </tr>
                <tr>
                    <td width=\"1%\" rowspan=\"4\" colspan=\"1\" class=\"number border-key\">6. </td>
                    <td width=\"15%\" rowspan=\"4\" colspan=\"2\" class=\"key border-key\">CIVIL STATUS</td>";

        $body .= match($data->civil_status) {
            'SINGLE' => "
                <td width=\"17%\" colspan=\"1\" rowspan=\"2\" class=\"value zero-right-border\">
                    <p><input type=\"checkbox\" checked=\"checked\"> Single </p>
                    <p> <input type=\"checkbox\"> Widowed </p>
                </td>
                <td width=\"12%\" colspan=\"2\" rowspan=\"2\" class=\"value zero-left-border zero-bottom-border\" >
                    <p><input type=\"checkbox\"> Married </p>
                    <p><input type=\"checkbox\"> Separated </p>
                </td>",
            'WIDOWED' => "
                <td width=\"17%\" colspan=\"1\" rowspan=\"2\" class=\"value zero-right-border\">
                    <p><input type=\"checkbox\"> Single </p>
                    <p> <input type=\"checkbox\" checked=\"checked\"> Widowed </p>
                </td>
                <td width=\"12%\" colspan=\"2\" rowspan=\"2\" class=\"value zero-left-border zero-bottom-border\" >
                    <p><input type=\"checkbox\"> Married </p>
                    <p><input type=\"checkbox\"> Separated </p>
                </td>",
            'OTHERS' => "
                <td width=\"17%\" colspan=\"1\" rowspan=\"2\" class=\"value zero-right-border\">
                    <p><input type=\"checkbox\"> Single </p>
                    <p> <input type=\"checkbox\"> Widowed </p>
                </td>
                <td width=\"12%\" colspan=\"2\" rowspan=\"2\" class=\"value zero-left-border zero-bottom-border\" >
                    <p><input type=\"checkbox\"> Married </p>
                    <p><input type=\"checkbox\"> Separated </p>
                </td>",
            'MARRIED' => "
                <td width=\"17%\" colspan=\"1\" rowspan=\"2\" class=\"value zero-right-border\">
                    <p><input type=\"checkbox\"> Single </p>
                    <p> <input type=\"checkbox\"> Widowed </p>
                </td>
                <td width=\"12%\" colspan=\"2\" rowspan=\"2\" class=\"value zero-left-border zero-bottom-border\" >
                    <p><input type=\"checkbox\" checked=\"checked\"> Married </p>
                    <p><input type=\"checkbox\"> Separated </p>
                </td>",
            'SEPERATED' => "
                <td width=\"17%\" colspan=\"1\" rowspan=\"2\" class=\"value zero-right-border\">
                    <p><input type=\"checkbox\"> Single </p>
                    <p> <input type=\"checkbox\"> Widowed </p>
                </td>
                <td width=\"12%\" colspan=\"2\" rowspan=\"2\" class=\"value zero-left-border zero-bottom-border\" >
                    <p><input type=\"checkbox\"> Married </p>
                    <p><input type=\"checkbox\" checked=\"checked\"> Separated </p>
                </td>",
            default => "
                <td width=\"17%\" colspan=\"1\" rowspan=\"2\" class=\"value zero-right-border\">
                    <p><input type=\"checkbox\"> Single </p>
                    <p> <input type=\"checkbox\"> Widowed </p>
                </td>
                <td width=\"12%\" colspan=\"2\" rowspan=\"2\" class=\"value zero-left-border zero-bottom-border\" >
                    <p><input type=\"checkbox\"> Married </p>
                    <p><input type=\"checkbox\"> Separated </p>
                </td>"
        };
        $body .= "
                <td width=\"12%\" rowspan=\"6\" colspan=\"2\" class=\"key border-key middle-border\" style=\" vertical-align: text-top;\">17. RESIDENTIAL ADDRESS</td>
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center;\"><p>{$data->residential_housenum}</p></td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center;\"><p>{$data->residential_street}</p></td>
            </tr>
            <tr>
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>House/Block/Lot No.</i></p></td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>Street</i></p></td>
            </tr>
            <tr>";
        if($data->civil_status == "OTHERS")
            $body .= "
                    <td width=\"29%\" colspan=\"3\" rowspan=\"2\" class=\"value zero-right-border\">
                        <p> <input type=\"checkbox\" checked=\"checked\"> Other/s: {$data->civil_status_others}</p>
                    </td>";
        else
            $body .= "
                    <td width=\"29%\" colspan=\"3\" rowspan=\"2\" class=\"value zero-right-border\">
                        <p> <input type=\"checkbox\"> Other/s: {$data->civil_status_others}</p>
                    </td>";
        $body .= "
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center;\"><p>{$data->residential_subdivision}</p></td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center;\"><p>{$data->residential_barangay}</p></td>
            </tr>
            <tr>
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>Subdivision/Village</i></p></td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>Barangay</i></p></td>
            </tr>
            <tr>
                <td width=\"1%\" rowspan=\"2\" colspan=\"1\" class=\"number border-key\">7. </td>
                <td width=\"15%\" rowspan=\"2\" colspan=\"2\" class=\"key border-key\">HEIGHT (m)</td>
                <td width=\"29%\" rowspan=\"2\" colspan=\"3\" class=\"value\">{$data->height} m</td>
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center;\"><p>{$data->residential_city}</p></td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center;\"><p>{$data->residential_province}</p></td>
            </tr>
            <tr>
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>City/Municipality</i></p></td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>Province</i></p></td>
            </tr>
            <tr>
                <td width=\"1%\" colspan=\"1\" class=\"number border-key\">8. </td>
                <td width=\"15%\" colspan=\"2\" class=\"key border-key\">WEIGHT (kg)</td>
                <td width=\"29%\" colspan=\"3\" class=\"value\">{$data->weight} kg</td>
                <td width=\"12%\" colspan=\"2\" class=\"key middle-border\" style=\"text-align: center;\">ZIP  CODE</td>
                <td width=\"40%\" colspan=\"6\" class=\"value\" style=\"text-align:center;\">{$data->residential_zipcode}</td>
            </tr>

            <tr>
                <td width=\"1%\" colspan=\"1\" rowspan=\"2\" class=\"number border-key\" style=\"vertical-align: center;\">9. </td>
                <td width=\"15%\" colspan=\"2\" rowspan=\"2\" class=\"key border-key\">BLOOD TYPE</td>
                <td width=\"29%\" colspan=\"3\" rowspan=\"2\" class=\"value\">{$data->blood_type}</td>
                <td width=\"12%\" colspan=\"2\" rowspan=\"6\" class=\"key border-key middle-border\" style=\" vertical-align: text-top;\">17. PERMANENT ADDRESS</td>
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center;\"><p>{$data->permanent_housenum}</td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center;\"><p>{$data->permanent_street}</p></td>
            </tr>
            <tr>
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>House/Block/Lot No.</i></p></td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>Street</i></p></td>
            </tr>
            <tr>
                <td width=\"1%\" colspan=\"1\" rowspan=\"2\" class=\"number border-key\" style=\"vertical-align: center;\">10. </td>
                <td width=\"15%\" colspan=\"2\" rowspan=\"2\" class=\"key border-key\">GSIS ID NO.</td>
                <td width=\"29%\" colspan=\"3\" rowspan=\"2\" class=\"value\">{$data->gsis}</td>
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center;\"><p>{$data->permanent_subdivision}</p></td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center;\"><p>{$data->permanent_barangay}</p></td>
            </tr>
            <tr>
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>Subdivision/Village</i></p></td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>Barangay</i></p></td>
            </tr>
            <tr>
                <td width=\"1%\" colspan=\"1\" rowspan=\"2\" class=\"number border-key\" style=\"vertical-align: center;\">11. </td>
                <td width=\"15%\" colspan=\"2\" rowspan=\"2\" class=\"key border-key\">PAG-IBIG ID NO.</td>
                <td width=\"29%\" colspan=\"3\" rowspan=\"2\" class=\"value\">{$data->pagibig}</td>
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center;\"><p>{$data->permanent_city}</p></td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center;\"><p>{$data->permanent_province}</p></td>
            </tr>
            <tr>
                <td width=\"18%\" colspan=\"3\" class=\"value zero-right-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>City/Municipality</i></p></td>
                <td width=\"22%\" colspan=\"3\" class=\"value zero-left-border\" style=\"text-align: center; padding-top: 0; padding-bottom: 0;\"><p><i>Province</i></p></td>
            </tr>
            <tr>
                <td width=\"1%\" colspan=\"1\" class=\"number border-key\">12. </td>
                <td width=\"15%\" colspan=\"2\" class=\"key border-key\">PHILHEALTH NO.</td>
                <td width=\"29%\" colspan=\"3\" class=\"value\">{$data->philhealth}</td>
                <td width=\"12%\" colspan=\"2\" class=\"key middle-border\" style=\"text-align: center;\">ZIP  CODE</td>
                <td width=\"40%\" colspan=\"6\" class=\"value\" style=\"text-align:center;\">{$data->permanent_zipcode}</td>
            </tr>
            <tr>
                <td width=\"1%\" colspan=\"1\" class=\"number border-key\">13. </td>
                <td width=\"15%\" colspan=\"2\" class=\"key border-key\">SSS NO.</td>
                <td width=\"29%\" colspan=\"3\" class=\"value\">{$data->sss}</td>
                <td width=\"12%\" colspan=\"2\" class=\"key border-key middle-border\">19. TELEPHONE NO.</td>
                <td width=\"40%\" colspan=\"6\" class=\"value\">{$data->telephone}</td>
            </tr>
            <tr>
                <td width=\"1%\" colspan=\"1\" class=\"number border-key\">14. </td>
                <td width=\"15%\" colspan=\"2\" class=\"key border-key\">TIN NO.</td>
                <td width=\"29%\" colspan=\"3\" class=\"value\">{$data->tin}</td>
                <td width=\"12%\" colspan=\"2\" class=\"key border-key middle-border\">20. MOBILE NO.</td>
                <td width=\"40%\" colspan=\"6\" class=\"value\">{$data->mobile}</td>
            </tr>
            <tr>
                <td width=\"1%\" colspan=\"1\" class=\"number border-key\">15. </td>
                <td width=\"15%\" colspan=\"2\" class=\"key border-key\">AGENCY EMPLOYEE NO. </td>
                <td width=\"29%\" colspan=\"3\" class=\"value\">{$data->employee_number}</td>
                <td width=\"12%\" colspan=\"2\" class=\"key border-key middle-border\">21. E-MAIL ADDRESS (if any)</td>
                <td width=\"40%\" colspan=\"6\" class=\"value\">{$data->email}</td>
            </tr>
            <tr class=\"after-sub-title\">
                <td width=\"100%\" colspan=\"14\" class=\"sub-title\">II. FAMILY BACKGROUND</td>
            </tr>
            <tr>
                <td width=\"1%\" colspan=\"1\" rowspan=\"3\" class=\"number border-key\">22. </td>
                <td width=\"15%\" colspan=\"2\" class=\"key border-key\">SPOUSE'S SURNAME</td>
                <td width=\"41%\" colspan=\"5\" class=\"value\">{$data->spouse_last_name}</td>
                <td width=\"25%\" colspan=\"4\" class=\"key border-key\">23. NAME of CHILDREN  (Write full name and list all)</td>
                <td width=\"15%\" colspan=\"2\" class=\"key border-key\">DATE OF BIRTH (mm/dd/yyyy) </td>
            </tr>
            <tr>
                <td width=\"15%\" colspan=\"2\" class=\"key border-key zero-top-border\">FIRST NAME</td>
                <td width=\"29%\" colspan=\"3\" class=\"value\">{$data->spouse_first_name}</td>
                <td width=\"12%\" colspan=\"2\" class=\"key\" style=\"font-size:6px; padding-top: 0;\"><p>NAME EXTENSION (JR., SR) </p> {$data->spouse_name_extension}</td>";
        $i = 0;
        $childrenCount = count($data->children);
        if($childrenCount > $i && $childrenCount != 0){
            $body .= "
                    <td width=\"25%\" colspan=\"4\" class=\"value border-key\" style=\"text-align: center;\">".$data->children[$i]->name."</td>
                    <td width=\"15%\" colspan=\"2\" class=\"value border-key\" style=\"text-align: center;\">".date('m/d/Y',strtotime($data->children[$i]->birth_date))."</td>";
            $i ++;
        }else{
            $body .= "
                    <td width=\"25%\" colspan=\"4\" class=\"value border-key\" style=\"text-align: center;\">N/A</td>
                    <td width=\"15%\" colspan=\"2\" class=\"value border-key\" style=\"text-align: center;\">N/A</td>";
        }

        $body .= "
                </tr>
                <tr>
                    <td width=\"15%\" colspan=\"2\" class=\"key border-key zero-top-border\">MIDDLE NAME</td>
                    <td width=\"41%\" colspan=\"5\" class=\"value\">{$data->spouse_middle_name}</td>";

        // children function
        $childrenFunction = function($childrenData, $count, $i) {
            if($count > $i){
                return "
                    <td width=\"25%\" colspan=\"4\" class=\"value border-key\" style=\"text-align: center;\">".$childrenData[$i]->name."</td>
                    <td width=\"15%\" colspan=\"2\" class=\"value border-key\" style=\"text-align: center;\">".date('m/d/Y',strtotime($childrenData[$i]->birth_date))."</td>";
                $i ++;
            }else{
                return "
                    <td width=\"25%\" colspan=\"4\" class=\"value border-key\" style=\"text-align: center;\">N/A</td>
                    <td width=\"15%\" colspan=\"2\" class=\"value border-key\" style=\"text-align: center;\">N/A</td>";
            }
        };

        $body .= $childrenFunction($data->children, $childrenCount, $i);
        $i ++;

        $body .= "
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" class=\"number border-key\"></td>
                    <td width=\"15%\" colspan=\"2\" class=\"key border-key\">OCCUPATION</td>
                    <td width=\"41%\" colspan=\"5\" class=\"value\">{$data->spouse_occupation}</td>";

        $body .= $childrenFunction($data->children, $childrenCount, $i);
        $i ++;

        $body .= "
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" class=\"number border-key\"></td>
                    <td width=\"15%\" colspan=\"2\" class=\"key border-key\">EMPLOYER/BUSINESS NAME</td>
                    <td width=\"41%\" colspan=\"5\" class=\"value\">{$data->spouse_employer_business}</td>";

        $body .= $childrenFunction($data->children, $childrenCount, $i);
        $i ++;
        
        $body .= "
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" class=\"number border-key\"></td>
                    <td width=\"15%\" colspan=\"2\" class=\"key border-key\">BUSINESS ADDRESS</td>
                    <td width=\"41%\" colspan=\"5\" class=\"value\">{$data->spouse_business_address}</td>";

        $body .= $childrenFunction($data->children, $childrenCount, $i);
        $i ++;

        $body .= "
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" class=\"number border-key\"></td>
                    <td width=\"15%\" colspan=\"2\" class=\"key border-key\">TELEPHONE NO.</td>
                    <td width=\"41%\" colspan=\"5\" class=\"value\">{$data->spouse_telephone}</td>";

        $body .= $childrenFunction($data->children, $childrenCount, $i);
        $i ++;

        $body .= "
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" rowspan=\"3\" class=\"number border-key\">24. </td>
                    <td width=\"15%\" colspan=\"2\" class=\"key border-key\">FATHER'S SURNAME</td>
                    <td width=\"41%\" colspan=\"5\" class=\"value\">{$data->father_last_name}</td>";

        $body .= $childrenFunction($data->children, $childrenCount, $i);
        $i ++;

        $body .= "
                </tr>
                <tr>
                    <td width=\"15%\" colspan=\"2\" class=\"key border-key zero-top-border\">FIRST NAME</td>
                    <td width=\"29%\" colspan=\"3\" class=\"value\">{$data->father_first_name}</td>
                    <td width=\"12%\" colspan=\"2\" class=\"key\" style=\"font-size:6px; padding-top: 0;\"><p>NAME EXTENSION (JR., SR)</p> {$data->father_name_extension}</td>";

        $body .= $childrenFunction($data->children, $childrenCount, $i);
        $i ++;

        $body .= "
                </tr>
                <tr>
                    <td width=\"15%\" colspan=\"2\" class=\"key border-key zero-top-border\">MIDDLE NAME</td>
                    <td width=\"41%\" colspan=\"5\" class=\"value\">{$data->father_middle_name}</td>";

        $body .= $childrenFunction($data->children, $childrenCount, $i);
        $i ++;

        $body .= "
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" rowspan=\"4\" class=\"number border-key\">25. </td>
                    <td width=\"59%\" colspan=\"7\" class=\"key border-key\">MOTHER'S MAIDEN NAME</td>";

        $body .= $childrenFunction($data->children, $childrenCount, $i);
        $i ++;

        $body .= "
                </tr>
                <tr>
                    <td width=\"15%\" colspan=\"2\" class=\"key border-key zero-top-border\">MOTHER'S SURNAME</td>
                    <td width=\"41%\" colspan=\"5\" class=\"value\">{$data->mother_last_name}</td>";

        $body .= $childrenFunction($data->children, $childrenCount, $i);
        $i ++;

        $body .= "
                </tr>
                <tr>
                    <td width=\"15%\" colspan=\"2\" class=\"key border-key zero-top-border\">FIRST NAME</td>
                    <td width=\"41%\" colspan=\"5\" class=\"value\">{$data->mother_first_name}</td>";

        $body .= $childrenFunction($data->children, $childrenCount, $i);
        $i ++;

        $body  .= "
                </tr>
                <tr>
                    <td width=\"15%\" colspan=\"2\" class=\"key border-key zero-top-border\">MIDDLE NAME</td>
                    <td width=\"41%\" colspan=\"5\" class=\"value\">{$data->mother_middle_name}</td>
                    <td width=\"40%\" colspan=\"6\" class=\"key border-key\" style=\"text-align: center; color: red;\"><b><i>(Continue on separate sheet if necessary)</i></b></td>
                </tr>
                <tr class=\"after-sub-title\">
                    <td width=\"100%\" colspan=\"14\" class=\"sub-title\">III. EDUCATIONAL BACKGROUND</td>
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" rowspan=\"1\" class=\"key zero-right-border\"></td>
                    <td width=\"15%\" colspan=\"2\" rowspan=\"3\" class=\"key border-key\" style=\"text-align:center;\">LEVEL</td>
                    <td width=\"29%\" colspan=\"3\" rowspan=\"3\" class=\"key value\" style=\"text-align:center;\">NAME OF SCHOOL<br> (Write in full)</td>
                    <td width=\"20%\" colspan=\"3\" rowspan=\"3\" class=\"key value\" style=\"text-align:center;\">BASIC EDUCATION/DEGREE/COURSE<br>(Write in full) </td>
                    <td width=\"10%\" colspan=\"2\" rowspan=\"2\" class=\"key value middle-border\" style=\"text-align:center;\">PERIOD OF ATTENDANCE</td>
                    <td width=\"7%\" colspan=\"1\" rowspan=\"3\" class=\"key value middle-border\" style=\"text-align:center;\">HIGHEST LEVEL/<br>UNITS EARNED<p style=\"font-size: 6px;\">(if not graduated)</p></td>
                    <td width=\"7%\" colspan=\"1\" rowspan=\"3\" class=\"key value\" style=\"text-align:center;\">YEAR GRADUATED</td>
                    <td width=\"8%\" colspan=\"1\" rowspan=\"3\" class=\"key value\" style=\"text-align:center; font-size: 7px;\">SCHOLARSHIP/ ACADEMIC HONORS RECEIVED</td>
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" rowspan=\"1\" class=\"key zero-right-border\">26.</td>
                </tr>
                <tr>
                    <td width=\"1%\" colspan=\"1\" rowspan=\"1\" class=\"key zero-right-border\"></td>
                    <td width=\"5%\" colspan=\"1\" rowspan=\"1\" class=\"key value middle-border\" style=\"text-align:center;\">FROM</td>
                    <td width=\"5%\" colspan=\"1\" rowspan=\"1\" class=\"key value middle-border\" style=\"text-align:center;\">TO</td>
                </tr>
                <tr>
                    <td width=\"16%\" colspan=\"3\" class=\"key border-key\">ELEMENTARY</td>";
        if(isset($data->education->ELEMENTARY)){
            $body .= "
                    <td width=\"25%\" height=\"35\" colspan=\"3\" class=\"value\"  style=\"font-size:7px;\">{$data->education->ELEMENTARY->school_name}</td>
                    <td width=\"240%\" height=\"35\" colspan=\"3\" class=\"value\"  style=\"font-size:7px;\">{$data->education->ELEMENTARY->course}</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value middle-border\">{$data->education->ELEMENTARY->attended_from}</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value\">{$data->education->ELEMENTARY->attended_to}</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value middle-border\"  style=\"font-size:7px;\">{$data->education->ELEMENTARY->highest_level}</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value\">{$data->education->ELEMENTARY->year_graduated}</td>
                    <td width=\"8%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:6px;\">{$data->education->ELEMENTARY->honors}</td>";
        }else{
            $body .= "
                    <td width=\"25%\" height=\"35\" colspan=\"3\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"24%\" height=\"35\" colspan=\"3\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value middle-border\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value middle-border\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"8%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>";
        }
        $body .= "
                </tr>
                <tr>
                    <td width=\"16%\" colspan=\"3\" class=\"key border-key\">SECONDARY</td>";
        if(isset($data->education->SECONDARY)){
            $body .= "
                    <td width=\"25%\" height=\"35\" colspan=\"3\" class=\"value\"  style=\"font-size:7px;\">{$data->education->SECONDARY->school_name}</td>
                    <td width=\"240%\" height=\"35\" colspan=\"3\" class=\"value\"  style=\"font-size:7px;\">{$data->education->SECONDARY->course}</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value middle-border\">{$data->education->SECONDARY->attended_from}</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value\">{$data->education->SECONDARY->attended_to}</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value middle-border\"  style=\"font-size:7px;\">{$data->education->SECONDARY->highest_level}</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value\">{$data->education->SECONDARY->year_graduated}</td>
                    <td width=\"8%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:6px;\">{$data->education->SECONDARY->honors}</td>";
        }else{
            $body .= "
                    <td width=\"25%\" height=\"35\" colspan=\"3\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"24%\" height=\"35\" colspan=\"3\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value middle-border\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value middle-border\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"8%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>";
        }
        $body  .= "
                </tr>
                <tr>
                    <td width=\"16%\" colspan=\"3\" class=\"key border-key\">VOCATIONAL /<br>TRADE COURSE</td>";
        if(isset($data->education->VOCATIONAL)){
            $body .= "
                    <td width=\"25%\" height=\"35\" colspan=\"3\" class=\"value\"  style=\"font-size:7px;\">{$data->education->VOCATIONAL->school_name}</td>
                    <td width=\"240%\" height=\"35\" colspan=\"3\" class=\"value\"  style=\"font-size:7px;\">{$data->education->VOCATIONAL->course}</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value middle-border\">{$data->education->VOCATIONAL->attended_from}</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value\">{$data->education->VOCATIONAL->attended_to}</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value middle-border\"  style=\"font-size:7px;\">{$data->education->VOCATIONAL->highest_level}</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value\">{$data->education->VOCATIONAL->year_graduated}</td>
                    <td width=\"8%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:6px;\">{$data->education->VOCATIONAL->honors}</td>";
        }else{
            $body .= "
                    <td width=\"25%\" height=\"35\" colspan=\"3\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"24%\" height=\"35\" colspan=\"3\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value middle-border\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value middle-border\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"8%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>";
        }
        $body .= "
                </tr>
                <tr>
                    <td width=\"16%\" colspan=\"3\" class=\"key border-key\">COLLEGE</td>";
        if(isset($data->education->COLLEGE)){
            $body .= "
                    <td width=\"25%\" height=\"35\" colspan=\"3\" class=\"value\"  style=\"font-size:7px;\">{$data->education->COLLEGE->school_name}</td>
                    <td width=\"240%\" height=\"35\" colspan=\"3\" class=\"value\"  style=\"font-size:7px;\">{$data->education->COLLEGE->course}</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value middle-border\">{$data->education->COLLEGE->attended_from}</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value\">{$data->education->COLLEGE->attended_to}</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value middle-border\"  style=\"font-size:7px;\">{$data->education->COLLEGE->highest_level}</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value\">{$data->education->COLLEGE->year_graduated}</td>
                    <td width=\"8%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:6px;\">{$data->education->COLLEGE->honors}</td>";
        }else{
            $body .= "
                    <td width=\"25%\" height=\"35\" colspan=\"3\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"24%\" height=\"35\" colspan=\"3\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value middle-border\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value middle-border\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"8%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>";
        }
        $body  .= "
            </tr>
            <tr>
                <td width=\"16%\" colspan=\"3\" class=\"key border-key\">GRADUATE STUDIES </td>";
        if(isset($data->education->{'GRADUATE STUDIES'})){
            $body .= "
                    <td width=\"25%\" height=\"35\" colspan=\"3\" class=\"value\"  style=\"font-size:7px;\">{$data->education->{'GRADUATE STUDIES'}->school_name}</td>
                    <td width=\"240%\" height=\"35\" colspan=\"3\" class=\"value\"  style=\"font-size:7px;\">{$data->education->{'GRADUATE STUDIES'}->course}</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value middle-border\">{$data->education->{'GRADUATE STUDIES'}->attended_from}</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value\">{$data->education->{'GRADUATE STUDIES'}->attended_to}</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value middle-border\"  style=\"font-size:7px;\">{$data->education->{'GRADUATE STUDIES'}->highest_level}</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value\">{$data->education->{'GRADUATE STUDIES'}->year_graduated}</td>
                    <td width=\"8%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:6px;\">{$data->education->{'GRADUATE STUDIES'}->honors}</td>";
        }else{
            $body .= "
                    <td width=\"25%\" height=\"35\" colspan=\"3\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"24%\" height=\"35\" colspan=\"3\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value middle-border\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"5%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value middle-border\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"7%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>
                    <td width=\"8%\" height=\"35\" colspan=\"1\" class=\"value\" style=\"font-size:7px;\">N/A</td>";
        }
        $body .= "
                </tr>
                <tr>
                    <td width=\"100%\" colspan=\"14\" class=\"key up-down-border\" style=\"padding-top: 0; color: red; padding-bottom: 0; text-align: center;\"><b><i>(Continue on separate sheet if necessary)</i></b></td>
                </tr>
                <tr>
                    <td width=\"16%\" colspan=\"3\" class=\"key sharp-border\" style=\"text-align: center; padding: 10px 0 10px 0;\"><b><i>SIGNATURE</i></b></td>
                    <td width=\"44%\" colspan=\"6\" class=\"value sharp-border\"></td>
                    <td width=\"10%\" colspan=\"2\" class=\"key sharp-border\" style=\"text-align: center; padding: 10px 0 10px 0;\"><b><i>DATE</i></b></td>
                    <td width=\"22%\" colspan=\"3\" class=\"value sharp-border\">".date('m/d/Y')."</td>
                </tr>
            </table>";

        $body .= "
            <pagebreak />
            <table cellpadding=\"5\">
                <tr class=\"after-sub-title\">
                    <td width=\"100%\" colspan=\"13\" class=\"sub-title\">IV.  CIVIL SERVICE ELIGIBILITY</td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number border-key\" style=\"font-size: 6px;\">27.</td>
                    <td width=\"28%\" rowspan=\"2\" colspan=\"4\" class=\"key\">CAREER SERVICE/ RA 1080 (BOARD/ BAR) UNDER SPECIAL LAWS/ CES/ CSEE BARANGAY ELIGIBILITY / DRIVER'S LICENSE</td>
                    <td width=\"11%\" rowspan=\"2\" colspan=\"1\" class=\"key border-left\"><center>RATING<br>(If Applicable)</center></td>
                    <td width=\"12%\" rowspan=\"2\" colspan=\"2\" class=\"key border-left\"><center>DATE OF EXAMINATION / CONFERMENT</center></td>
                    <td width=\"30%\" rowspan=\"2\" colspan=\"3\" class=\"key border-left\"><center>PLACE OF EXAMINATION / CONFERMENT</center></td>
                    <td width=\"16%\" rowspan=\"1\" colspan=\"2\" class=\"key\"><center>LICENSE (if applicable)</center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number\"></td>
                    <td width=\"9%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>NUMBER</center></td>
                    <td width=\"7%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>Date of Validity</center></td>
                </tr>";

        $eligibilityCount = count($data->eligibility);
        for ($i=0; $i < 7; $i++) {
            if($i < $eligibilityCount){
                $eligibility = $data->eligibility[$i];

                $body .="
                <tr>
                    <td width=\"26%\" height=\"31.5\" colspan=\"5\" class=\"value\">{$eligibility->type}</td>
                    <td width=\"11%\" height=\"31.5\" colspan=\"1\" class=\"value\">{$eligibility->rating}</td>
                    <td width=\"12%\" height=\"31.5\" colspan=\"2\" class=\"value\">".($eligibility->date_conferment != 'N/A'?date('m/d/Y', strtotime($eligibility->date_conferment)):'N/A')."</td>
                    <td width=\"30%\" height=\"31.5\" colspan=\"3\" class=\"value\">{$eligibility->place_conferment}</td>
                    <td width=\"9%\" height=\"31.5\" colspan=\"1\" class=\"value\" style=\"font-size: 7px;\">{$eligibility->license_number}</td>
                    <td width=\"7%\" height=\"31.5\" colspan=\"1\" class=\"value\" style=\"font-size: 7px;\">".($eligibility->license_validity != 'N/A'?date('m/d/Y',strtotime($eligibility->license_validity)):'N/A')."</td>
                </tr>";
            }else{
                if($i === 0) {
                    $body .="
                        <tr>
                            <td width=\"26%\" height=\"31.5\" colspan=\"5\" class=\"value\">N/A</td>
                            <td width=\"11%\" height=\"31.5\" colspan=\"1\" class=\"value\">N/A</td>
                            <td width=\"12%\" height=\"31.5\" colspan=\"2\" class=\"value\">N/A</td>
                            <td width=\"30%\" height=\"31.5\" colspan=\"3\" class=\"value\">N/A</td>
                            <td width=\"9%\" height=\"31.5\" colspan=\"1\" class=\"value\">N/A</td>
                            <td width=\"7%\" height=\"31.5\" colspan=\"1\" class=\"value\">N/A</td>
                        </tr>";
                }else {
                    $body .="
                        <tr>
                            <td width=\"26%\" height=\"31.5\" colspan=\"5\" class=\"value\"></td>
                            <td width=\"11%\" height=\"31.5\" colspan=\"1\" class=\"value\"></td>
                            <td width=\"12%\" height=\"31.5\" colspan=\"2\" class=\"value\"></td>
                            <td width=\"30%\" height=\"31.5\" colspan=\"3\" class=\"value\"></td>
                            <td width=\"9%\" height=\"31.5\" colspan=\"1\" class=\"value\"></td>
                            <td width=\"7%\" height=\"31.5\" colspan=\"1\" class=\"value\"></td>
                        </tr>";
                }
            }
        }

        $body .= "
                <tr>
                    <td width=\"100%\" colspan=\"13\" class=\"key up-down-border\" style=\"padding-top: 0; color: red; padding-bottom: 0; text-align: center;\"><b><i>(Continue on separate sheet if necessary)</i></b></td>
                </tr>
                <tr class=\"after-sub-title\">
                    <td width=\"100%\" colspan=\"13\" class=\"sub-title zero-bottom-border\">V.  WORK EXPERIENCE<br><p style=\"font-size: 9px;\">(Include private employment.  Start from your recent work) Description of duties should be indicated in the attached Work Experience sheet.</p></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number border-key\" style=\"font-size: 6px;\">28.</td>
                    <td width=\"13%\" rowspan=\"2\" colspan=\"2\" class=\"key\"><center>INCLUSIVE DATES<br>(mm/dd/yyyy)</center></td>
                    <td width=\"26%\" rowspan=\"3\" colspan=\"3\" class=\"key\"><center>POSITION TITLE<br>(Write in full/Do not abbreviate)</center></td>
                    <td width=\"27%\" rowspan=\"3\" colspan=\"3\" class=\"key\"><center>DEPARTMENT / AGENCY / OFFICE / COMPANY<br>(Write in full/Do not abbreviate)</center></td>
                    <td width=\"7%\" rowspan=\"3\" colspan=\"1\" class=\"key\"><center>MONTHLY SALARY</center></td>
                    <td width=\"8%\" rowspan=\"3\" colspan=\"1\" class=\"key\" style=\"font-size: 7px;\"><center>SALARY/ JOB/ PAY GRADE (if applicable)& STEP  (Format \"00-0\")/ INCREMENT</center></td>
                    <td width=\"9%\" rowspan=\"3\" colspan=\"1\" class=\"key\" style=\"font-size: 8px;\"><center>STATUS OF APPOINTMENT</center></td>
                    <td width=\"7%\" rowspan=\"3\" colspan=\"1\" class=\"key\"><center>GOV'T SERVICE (Y/ N)</center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number\"></td>
                </tr>
                <tr>
                    <td width=\"8%\" rowspan=\"1\" colspan=\"2\" class=\"key border-key\"><center>From</center></td>
                    <td width=\"8%\" rowspan=\"1\" colspan=\"1\" class=\"key border-key\"><center>To</center></td>
                </tr>";

        $workExpCount = count($data->workExperience);
        for ($i=0; $i < 28; $i++) {
            if ($i < $workExpCount){
                $workExp = $data->workExperience[$i];

                $body .= "
                <tr>
                    <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"2\" class=\"value\">".($workExp->date_from != 'N/A'?date('m/d/Y', strtotime($workExp->date_from)):'N/A')."</td>
                    <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">".($workExp->date_to != 'PRESENT'?date('m/d/Y', strtotime($workExp->date_to)):$workExp->date_to)."</td>
                    <td width=\"26%\" height=\"31\" rowspan=\"1\" colspan=\"3\" class=\"value\">{$workExp->position}</td>
                    <td width=\"27%\" height=\"31\" rowspan=\"1\" colspan=\"3\" class=\"value\" style=\"font-size: 7px;\">{$workExp->company}</td>
                    <td width=\"7%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">{$workExp->salary}</td>
                    <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">{$workExp->pay_grade}</td>
                    <td width=\"9%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">{$workExp->status_of_appointment}</td>
                    <td width=\"7%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">".($workExp->is_government_service?'Y':'N')."</td>
                </tr>";
            } else {
                if($i === 0) {
                    $body .= "
                        <tr>
                            <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"2\" class=\"value\">N/A</td>
                            <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">N/A</td>
                            <td width=\"26%\" height=\"31\" rowspan=\"1\" colspan=\"3\" class=\"value\">N/A</td>
                            <td width=\"27%\" height=\"31\" rowspan=\"1\" colspan=\"3\" class=\"value\">N/A</td>
                            <td width=\"7%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">N/A</td>
                            <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">N/A</td>
                            <td width=\"9%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">N/A</td>
                            <td width=\"7%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">N/A</td>
                        </tr>";
                }else {
                    $body .= "
                        <tr>
                            <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"2\" class=\"value\"></td>
                            <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\"></td>
                            <td width=\"26%\" height=\"31\" rowspan=\"1\" colspan=\"3\" class=\"value\"></td>
                            <td width=\"27%\" height=\"31\" rowspan=\"1\" colspan=\"3\" class=\"value\"></td>
                            <td width=\"7%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\"></td>
                            <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\"></td>
                            <td width=\"9%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\"></td>
                            <td width=\"7%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\"></td>
                        </tr>";
                }
            }
        }

        $body .= "
                <tr>
                    <td width=\"100%\" colspan=\"13\" class=\"key up-down-border\" style=\"padding-top: 0; color: red; padding-bottom: 0; text-align: center;\"><b><i>(Continue on separate sheet if necessary)</i></b></td>
                </tr>
                <tr>
                    <td width=\"16%\" colspan=\"3\" class=\"key sharp-border\" style=\"text-align: center; padding: 10px 0 10px 0;\"><b><i>SIGNATURE</i></b></td>
                    <td width=\"38%\" colspan=\"5\" class=\"value sharp-border\"></td>
                    <td width=\"15%\" colspan=\"1\" class=\"key sharp-border\" style=\"text-align: center; padding: 10px 0 10px 0;\"><b><i>DATE</i></b></td>
                    <td width=\"31%\" colspan=\"4\" class=\"value sharp-border\">".date('m/d/Y')."</td>
                </tr>
            </table>";

        $body .="
            <pagebreak />
            <table cellpadding=\"5\">
                <tr class=\"after-sub-title\">
                    <td width=\"125%\" colspan=\"11\" class=\"sub-title\" style=\"font-size: 10.5px;\">VI. VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION/S</td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number border-key\" style=\"font-size: 6px;\">29.</td>
                    <td width=\"52%\" rowspan=\"2\" colspan=\"3\" class=\"key\"><center>NAME & ADDRESS OF ORGANIZATION<br>(Write in full)</center></td>
                    <td width=\"19%\" rowspan=\"1\" colspan=\"2\" class=\"key border-left\"><center>INCLUSIVE DATES<br>(mm/dd/yyyy)</center></td>
                    <td width=\"9%\" rowspan=\"2\" colspan=\"1\" class=\"key border-left\"><center>NUMBER OF HOURS</center></td>
                    <td width=\"42%\" rowspan=\"2\" colspan=\"4\" class=\"key border-left\"><center>POSITION / NATURE OF WORK</center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number\"></td>
                    <td width=\"10%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>From</center></td>
                    <td width=\"9%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>To</center></td>
                </tr>";

        $volunteeringCount = count($data->volunteering);
        for ($i=0; $i < 7; $i++) {
            if ($i < $volunteeringCount) {
                $volunteering = $data->volunteering[$i];

                $body .= "
                <tr>
                    <td width=\"55%\" height=\"26\" colspan=\"4\" class=\"value\">{$volunteering->organization}</td>
                    <td width=\"10%\" height=\"26\" colspan=\"1\" class=\"value border-left\">{$volunteering->date_from}</td>
                    <td width=\"9%\" height=\"26\" colspan=\"1\" class=\"value border-left\">{$volunteering->date_to}</td>
                    <td width=\"9%\" height=\"26\" colspan=\"1\" class=\"value border-left\">{$volunteering->number_of_hours}</td>
                    <td width=\"42%\" height=\"26\" colspan=\"4\" class=\"value border-left\">{$volunteering->position} / {$volunteering->nature_of_work}</td>
                </tr>";
            } else {
                if($i === 0) {
                    $body .= "
                        <tr>
                            <td width=\"55%\" height=\"26\" colspan=\"4\" class=\"value\">N/A</td>
                            <td width=\"10%\" height=\"26\" colspan=\"1\" class=\"value border-left\">N/A</td>
                            <td width=\"9%\" height=\"26\" colspan=\"1\" class=\"value border-left\">N/A</td>
                            <td width=\"9%\" height=\"26\" colspan=\"1\" class=\"value border-left\">N/A</td>
                            <td width=\"42%\" height=\"26\" colspan=\"4\" class=\"value border-left\">N/A</td>
                        </tr>";
                }else {
                    $body .= "
                        <tr>
                            <td width=\"55%\" height=\"26\" colspan=\"4\" class=\"value\"></td>
                            <td width=\"10%\" height=\"26\" colspan=\"1\" class=\"value border-left\"></td>
                            <td width=\"9%\" height=\"26\" colspan=\"1\" class=\"value border-left\"></td>
                            <td width=\"9%\" height=\"26\" colspan=\"1\" class=\"value border-left\"></td>
                            <td width=\"42%\" height=\"26\" colspan=\"4\" class=\"value border-left\"></td>
                        </tr>";
                }
            }
        }
        $body .= "
                <tr>
                    <td width=\"125%\" colspan=\"11\" class=\"key up-down-border\" style=\"padding-top: 0; color: red; padding-bottom: 0; text-align: center;\"><b><i>(Continue on separate sheet if necessary)</i></b></td>
                </tr>
                <tr class=\"after-sub-title\">
                    <td width=\"125%\" colspan=\"11\" class=\"sub-title zero-bottom-border\">VII.  LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED<br><p style=\"font-size: 8px;\">(Start from the most recent L&D/training program and include only the relevant L&D/training taken for the last five (5) years for Division Chief/Executive/Managerial positions)</p></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number border-key\" style=\"font-size: 6px;\">30.</td>
                    <td width=\"52%\" rowspan=\"3\" colspan=\"3\" class=\"key\"><center>TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS<br>(Write in full)</center></td>
                    <td width=\"19%\" rowspan=\"2\" colspan=\"2\" class=\"key border-left\"><center>INCLUSIVE DATES OF ATTENDANCE<br>(mm/dd/yyyy)</center></td>
                    <td width=\"9%\" rowspan=\"3\" colspan=\"1\" class=\"key border-left\"><center>NUMBER OF HOURS</center></td>
                    <td width=\"11%\" rowspan=\"3\" colspan=\"1\" class=\"key border-left\" style=\"font-size: 8px;\"><center>Type of LD(Managerial/ Supervisory/Technical/etc) </center></td>
                    <td width=\"31%\" rowspan=\"3\" colspan=\"3\" class=\"key border-left\"><center> CONDUCTED/ SPONSORED BY<br>(Write in full)</center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number\"></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number\"></td>
                    <td width=\"10%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>From</center></td>
                    <td width=\"9%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>To</center></td>
                </tr>";

        $trainingCount = count($data->training);
        for ($i=0; $i < 21; $i++) {
            if ($i < $trainingCount) {
                $training = $data->training[$i];

                $sponsored_conducted = "";
                if ($training->sponsored_by == $training->conducted_by) {
                    $sponsored_conducted = $training->sponsored_by;
                }else {
                    if ($training->sponsored_by != 'N/A')
                        $sponsored_conducted .= "{$training->sponsored_by}/";

                    if ($training->sponsored_by != 'N/A' && $training->conducted_by != 'N/A')
                        $sponsored_conducted .= '/';

                    if ($training->conducted_by != 'N/A')
                        $sponsored_conducted .= $training->conducted_by;
                }

                $body .= "
                <tr>
                    <td width=\"55%\" height=\"30\" colspan=\"4\" class=\"value\">{$training->program}</td>
                    <td width=\"10%\" height=\"30\" colspan=\"1\" class=\"value border-left\">".date('m/d/Y', strtotime($training->date_from))."</td>
                    <td width=\"9%\" height=\"30\" colspan=\"1\" class=\"value border-left\">".date('m/d/Y', strtotime($training->date_to))."</td>
                    <td width=\"9%\" height=\"30\" colspan=\"1\" class=\"value border-left\">{$training->number_of_hours}</td>
                    <td width=\"11%\" height=\"30\" colspan=\"1\" class=\"value border-left\">{$training->type_of_ld}</td>
                    <td width=\"31%\" height=\"30\" colspan=\"3\" class=\"value border-left\" style=\"font-size:5px;\">$sponsored_conducted</td>
                </tr>";
            } else {
                if($i === 0) {
                    $body .= "
                        <tr>
                            <td width=\"55%\" height=\"30\" colspan=\"4\" class=\"value\">N/A</td>
                            <td width=\"10%\" height=\"30\" colspan=\"1\" class=\"value border-left\">N/A</td>
                            <td width=\"9%\" height=\"30\" colspan=\"1\" class=\"value border-left\">N/A</td>
                            <td width=\"9%\" height=\"30\" colspan=\"1\" class=\"value border-left\">N/A</td>
                            <td width=\"11%\" height=\"30\" colspan=\"1\" class=\"value border-left\">N/A</td>
                            <td width=\"31%\" height=\"30\" colspan=\"3\" class=\"value border-left\">N/A</td>
                        </tr>";
                }else {
                    $body .= "
                        <tr>
                            <td width=\"55%\" height=\"30\" colspan=\"4\" class=\"value\"></td>
                            <td width=\"10%\" height=\"30\" colspan=\"1\" class=\"value border-left\"></td>
                            <td width=\"9%\" height=\"30\" colspan=\"1\" class=\"value border-left\"></td>
                            <td width=\"9%\" height=\"30\" colspan=\"1\" class=\"value border-left\"></td>
                            <td width=\"11%\" height=\"30\" colspan=\"1\" class=\"value border-left\"></td>
                            <td width=\"31%\" height=\"30\" colspan=\"3\" class=\"value border-left\"></td>
                        </tr>";
                }
            }
        }
        $body .= "
            <tr>
                <td width=\"125%\" colspan=\"11\" class=\"key up-down-border\" style=\"padding-top: 0; color: red; padding-bottom: 0; text-align: center;\"><b><i>(Continue on separate sheet if necessary)</i></b></td>
            </tr>
            <tr class=\"after-sub-title\">
                <td width=\"125%\" colspan=\"11\" class=\"sub-title zero-bottom-border\">VIII.  OTHER INFORMATION</p></td>
            </tr>
            <tr>
                <td width=\"33%\" colspan=\"2\" class=\"key\">31. SPECIAL SKILLS and HOBBIES</td>
                <td width=\"61%\" colspan=\"6\" class=\"key border-left\">32. NON-ACADEMIC DISTINCTIONS / RECOGNITION<br>(Write in full)</td>
                <td width=\"31%\" colspan=\"3\" class=\"key border-left\" style=\"font-size: 7px;\">33. MEMBERSHIP IN ASSOCIATION/ORGANIZATION<br>(Write in full)</td>
            </tr>";

        $skillCount = count($data->skill);
        $recognitionCount = count($data->recognition);
        $membershipCount = count($data->membership);

        for ($i=0; $i < 7; $i++) {
            $body .= "<tr>";

            if ($i < $skillCount)
                $body .= "<td width=\"33%\" height=\"27\" colspan=\"2\" class=\"value\" style=\"font-size: 7px;\">".$data->skill[$i]."</td>";
            else
                $body .= "<td width=\"33%\" height=\"27\" colspan=\"2\" class=\"value\"></td>";

            if ($i < $recognitionCount)
                $body .= "<td width=\"61%\" height=\"27\" colspan=\"6\" class=\"value border-left\" style=\"font-size: 7px;\">".$data->recognition[$i]."</td>";
            else
                $body .= "<td width=\"61%\" height=\"27\" colspan=\"6\" class=\"value border-left\"></td>";

            if($i < $membershipCount)
                $body .= "<td width=\"31%\" height=\"27\" colspan=\"3\" class=\"value border-left\" style=\"font-size: 7px;\">".$data->membership[$i]."</td>";
            else
                $body .= "<td width=\"31%\" height=\"27\" colspan=\"3\" class=\"value border-left\" style=\"font-size: 7px;\"></td>";

            $body .= "</tr>";
        }

        $body .= "
            <tr>
                <td width=\"125%\" colspan=\"11\" class=\"key up-down-border\" style=\"padding-top: 0; color: red; padding-bottom: 0; text-align: center;\"><b><i>(Continue on separate sheet if necessary)</i></b></td>
            </tr>
            <tr>
                <td width=\"33%\" colspan=\"2\" class=\"key sharp-border\" style=\"text-align: center; padding: 10px 0 10px 0;\"><b><i>SIGNATURE</i></b></td>
                <td width=\"41%\" colspan=\"4\" class=\"value sharp-border\"></td>
                <td width=\"20%\" colspan=\"2\" class=\"key sharp-border\" style=\"text-align: center; padding: 10px 0 10px 0;\"><b><i>DATE</i></b></td>
                <td width=\"31%\" colspan=\"3\" class=\"value sharp-border\">".date('m/d/Y')."</td>
            </tr>";

        $body .= "
            </table>
            <pagebreak/>
            <table cellpadding=\"5\"  width=\"103%\">
            <tr>
                <td width=\"3%\" class=\"number \" style=\"font-size: 6px;\">34.</td>
                <td width=\"63%\" colspan=\"4\" rowspan=\"3\" class=\"key\">
                    <p>
                    Are you related by consanguinity or affinity to the appointing or recommending authority, or to the
                    chief of bureau or office or to the person who has immediate supervision over you in the Office,
                    Bureau or Department where you will be appointed,
                    </p>
                </td>
                <td width=\"37%\" colspan=\"7\" rowspan=\"3\" class=\"value zero-bottom-border zero-right-border\"></td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number \"></td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number \"></td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number \"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\">
                    <p>
                    a. within the third degree?
                    </p>
                </td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">";
        $body .= match($data->is_affiliated_third) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };

        $body .= "
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number \"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\">
                    <p>
                    b. within the fourth degree (for Local Government Unit - Career Employees)?
                    </p>
                </td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">";
        $body .= match($data->is_affiliated_fourth) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };

        $body .= "
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number \"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                    <p>
                        If YES, give details: <u>&nbsp;{$data->affiliated_fourth}</u>
                    </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number \"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\"><p></p></td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number border-top\" style=\"font-size: 6px;\">35.</td>
                <td width=\"63%\" colspan=\"4\" class=\"key border-top\">
                    <p>
                    a. Have you ever been found guilty of any administrative offense?
                    </p>
                </td>
                <td width=\"1%\" class=\"value zero-right-border zero-bottom-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value zero-left-border zero-bottom-border zero-right-border\">";
        $body .= match($data->is_found_guilty) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };

        $body .= "
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                    <p>
                            If YES, give details: <u>&nbsp;{$data->found_guilty}</u>
                    </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\"><p></p></td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\" style=\"font-size: 6px;\"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\">
                    <p>
                        b. Have you been criminally charged before any court?
                    </p>
                </td>
                <td width=\"1%\" class=\"value zero-right-border zero-bottom-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value zero-left-border zero-bottom-border zero-right-border\">";
        $body .= match($data->is_criminally_charged) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };

        $body .= "
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                    <p>
                            If YES, give details:
                    </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                    <p>
                        Date Filed: <u>&nbsp;{$data->criminally_charged_date}</u>
                    </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                <p>
                    Status of Case/s: <u>&nbsp;{$data->criminally_charged_status}</u>
                </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number border-top\" style=\"font-size: 6px;\">36.</td>
                <td width=\"63%\" colspan=\"4\" class=\"key border-top\">
                    <p>
                        Have you ever been convicted of any crime or violation of any law, decree, ordinance or <br> regulation by any court or tribunal?
                    </p>
                </td>
                <td width=\"1%\" class=\"value zero-right-border zero-bottom-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value zero-left-border zero-bottom-border zero-right-border\">";
        $body .= match($data->is_convicted) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };

        $body .= "
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                <p>
                    If YES, give details: <u>&nbsp;{$data->convicted}</u>
                </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"63%\" colspan=\"4\" class=\"key\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\"><p></p></td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number border-top\" style=\"font-size: 6px;\">37.</td>
                <td width=\"63%\" colspan=\"4\" rowspan=\"3\" class=\"key border-top\" style=\"vertical-align: top;\">
                    <p>
                        Have you ever been separated from the service in any of the following modes: resignation,
                        retirement, dropped from the rolls, dismissal, termination, end of term, finished contract or phased
                        out (abolition) in the public or private sector?
                    </p>
                </td>
                <td width=\"1%\" class=\"value zero-right-border zero-bottom-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value zero-left-border zero-bottom-border zero-right-border\">";
        $body .= match($data->is_separated_service) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };

        $body .= "
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                    <p>
                        If YES, give details: <u>&nbsp;{$data->separated_service}</u>
                    </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\"><p></p></td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number border-top\" style=\"font-size: 6px;\">38.</td>
                <td width=\"63%\" colspan=\"4\" rowspan=\"2\" class=\"key border-top\" style=\"vertical-align: top;\">
                    <p>
                        a. Have you ever been a candidate in a national or local election held within the last year (except
                        Barangay election)?
                    </p>
                </td>
                <td width=\"1%\" class=\"value zero-right-border zero-bottom-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value zero-left-border zero-bottom-border zero-right-border\">";
        $body .= match($data->is_candidate) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };

        $body .= "
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                <p>
                        If YES, give details:  <u>&nbsp;{$data->candidate}</u>
                </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"63%\" colspan=\"4\" rowspan=\"2\" class=\"key\" style=\"vertical-align: top;\">
                    <p>
                        b. Have you resigned from the government service during the three (3)-month period before the
                        last election to promote/actively campaign for a national or local candidate?
                    </p>
                </td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">";
        $body .= match($data->is_resigned) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };
        
        $body  .= "</td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                <p>
                    If YES, give details: <u>&nbsp;{$data->resigned}</u>
                </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number border-top\" style=\"font-size: 6px;\">39.</td>
                <td width=\"63%\" colspan=\"4\" rowspan=\"3\" class=\"key border-top\" style=\"vertical-align: top;\">
                    <p>
                        Have you acquired the status of an immigrant or permanent resident of another country?
                    </p>
                </td>
                <td width=\"1%\" class=\"value zero-right-border zero-bottom-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value zero-left-border zero-bottom-border zero-right-border\">";
        $body .= match($data->is_immigrant) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };
          
        $body .= "
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                <p>
                    If YES, give details (country): <u>&nbsp;{$data->immigrant}</u>
                </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\"><p></p></td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number border-top\" style=\"font-size: 6px;\">40.</td>
                <td width=\"63%\" colspan=\"4\" rowspan=\"2\" class=\"key border-top\">
                    <p>
                        Pursuant to: (a) Indigenous People's Act (RA 8371); (b) Magna Carta for Disabled Persons (RA
                        7277); and (c) Solo Parents Welfare Act of 2000 (RA 8972), please answer the following items:
                    </p>
                </td>
                <td width=\"1%\"  rowspan=\"2\" class=\"value zero-bottom-border zero-right-border\"></td>
                <td width=\"36%\" colspan=\"6\" rowspan=\"2\" class=\"value zero-bottom-border zero-right-border zero-left-border\"></td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\">a.  </td>
                <td width=\"63%\" colspan=\"4\" rowspan=\"2\" class=\"key\" style=\"vertical-align: top;\">
                    <p>
                        Are you a member of any indigenous group?
                    </p>
                </td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">";
        $body .= match($data->is_indigenous) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };

        $body .= "
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                    <p>
                        If YES, give details: <u>&nbsp;{$data->indigenous}</u>
                    </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\">b.  </td>
                <td width=\"63%\" colspan=\"4\" rowspan=\"2\" class=\"key\" style=\"vertical-align: top;\">
                    <p>
                        Are you a person with disability?
                    </p>
                </td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">";
        $body .= match($data->is_disabled) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };
           
        $body .= "
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                    <p>
                        If YES, please specify ID No: <u>&nbsp;{$data->disabled}</u>
                    </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\">b.  </td>
                <td width=\"63%\" colspan=\"4\" rowspan=\"2\" class=\"key\" style=\"vertical-align: top;\">
                    <p>
                        Are you a solo parent?
                    </p>
                </td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">";
        $body .= match($data->is_solo) {
            false => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\" checked=\"checked\"> NO </p>",
            true => "<p> <input type=\"checkbox\" checked=\"checked\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>",
            default => "<p> <input type=\"checkbox\"> YES  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type=\"checkbox\"> NO</p>"
        };
          
        $body .= "
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"1%\" class=\"value no-border\"></td>
                <td width=\"36%\" colspan=\"6\" class=\"value no-border\">
                    <p>
                        If YES, please specify ID No: <u>&nbsp;{$data->solo}</u>
                    </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number sharp-border zero-right-border\" style=\"font-size: 6px;\">41.</td>
                <td width=\"73%\" colspan=\"7\" class=\"key sharp-border zero-left-border\" style=\"vertical-align: top;\">
                    <p>REFERENCES <i style=\"color: red;\">(Person not related by consanguinity or affinity to applicant /appointee)</i></p>
                </td>
                <td width=\"27%\" colspan=\"4\" class=\"value sharp-border zero-right-border zero-bottom-border\" style=\"padding-top: 10px; padding-bottom: 10px;\"></td>
            <tr>
                <td width=\"40%\" colspan=\"4\" class=\"key border-top\"><center>NAME</center></td>
                <td width=\"26%\" colspan=\"1\" class=\"key border-top\"><center>ADDRESS</center></td>
                <td width=\"10%\" colspan=\"3\" class=\"key border-top sharp-right-border\"><center>TEL NO.</center></td>
                <td width=\"2%\" colspan=\"1\" rowspan=\"6\" class=\"value no-border sharp-left-border\"></td>
                <td width=\"24%\" colspan=\"2\" rowspan=\"5\" class=\"value no-border\">
                    <center>
                        <img src=\"".$this->image("idTemplate.png")."\" alt=\"nani\" height=\"4.5cm\" width=\"3.5cm\">
                    </center>
                </td>
                <td width=\"1%\" colspan=\"1\" rowspan=\"6\" class=\"value no-border\"></td>
                </td>
            </tr>";

        $referenceCount = count($data->reference);
        for ($i=0; $i < 3; $i++) {
            if($referenceCount > $i) {
                $reference = $data->reference[$i];

                $body .= "
                <tr>
                    <td width=\"40%\" colspan=\"4\" class=\"value\" height=\"30\">{$reference->name}</td>
                    <td width=\"26%\" colspan=\"1\" class=\"value\" height=\"30\" style=\"font-size: 6px;\">{$reference->address}</td>
                    <td width=\"10%\" colspan=\"3\" class=\"value sharp-right-border\" height=\"30\">{$reference->telephone}</td>
                </tr>";
            }else {
                $body .= "
                <tr>
                    <td width=\"40%\" colspan=\"4\" class=\"value\" height=\"30\"></td>
                    <td width=\"26%\" colspan=\"1\" class=\"value\" height=\"30\" style=\"font-size: 6px;\"></td>
                    <td width=\"10%\" colspan=\"3\" class=\"value sharp-right-border\" height=\"30\"></td>
                </tr>";
            }
        }
        $body .= "
            <tr>
                <td width=\"3%\" class=\"number sharp-border sharp-border zero-right-border zero-bottom-border\" style=\"padding-top: 10px; padding-bottom: 10px; font-size: 6px;\">42.</td>
                <td width=\"73%\" colspan=\"7\" rowspan=\"2\" class=\"key sharp-border zero-right-border zero-bottom-border zero-left-border\" style=\"vertical-align: top; font-size: 8px;\">
                    <p>
                        I declare under oath that I have personally accomplished this Personal Data Sheet which is a true, correct<br>
                        and complete statement pursuant to the provisions of pertinent laws, rules and regulations of the Republic of
                        the Philippines. I authorize the agency head/authorized representative to verify/validate the contents stated
                        herein. I  agree that any misrepresentation made in this document and its attachments shall cause the filing of
                        administrative/criminal case/s against me.
                    </p>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number\"></td>
                <td width=\"27%\" colspan=\"4\" class=\"value sharp-border zero-right-border zero-left-border zero-bottom-border zero-top-border\">
                    <center><p style=\"color: gray;\">PHOTO</p></center>
                </td>
            </tr>
            <tr>
                <td width=\"3%\" class=\"number sharp-border sharp-border zero-right-border zero-top-border zero-bottom-border\"></td>
                <td width=\"71%\" colspan=\"6\" class=\"key sharp-border zero-right-border zero-top-border zero-left-border\"></td>
                <td width=\"2%\" colspan=\"1\" class=\"key sharp-border zero-right-border zero-top-border zero-left-border\" style=\"vertical-align: top;\"></td>

                <td width=\"2%\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-right-border zero-bottom-border\"></td>
                <td width=\"24%\" colspan=\"2\" class=\"value sharp-border zero-right-border zero-bottom-border\"></td>
                <td width=\"1%\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-right-border zero-bottom-border\"></td>
            </tr>

            <tr>
                <td width=\"3%\" height=\"8.25\" class=\"value sharp-border sharp-border zero-right-border zero-bottom-border\"></td>
                <td width=\"71%\" height=\"8.25\" colspan=\"6\" class=\"value sharp-border zero-right-border zero-bottom-border zero-top-border zero-left-border\"></td>
                <td width=\"2%\" height=\"8.25\" colspan=\"1\" class=\"value sharp-border zero-right-border zero-top-border zero-left-border\" style=\"vertical-align: top;\"></td>

                <td width=\"2%\" height=\"8.25\" colspan=\"1\" class=\"value zero-left-border zero-top-border zero-right-border zero-bottom-border\"></td>
                <td width=\"24%\" height=\"8.25\" colspan=\"2\" class=\"value zero-top-border zero-bottom-border sharp-left-border\"></td>
                <td width=\"1%\" height=\"8.25\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-right-border zero-bottom-border\"></td>
            </tr>

            <tr>
                <td width=\"3%\" height=\"25.5\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>
                <td width=\"35%\" height=\"25.5\" colspan=\"2\" class=\"key sharp-border zero-bottom-border\" style=\"font-size: 7px;\">Government Issued ID (i.e.Passport, GSIS, SSS, PRC, Driver's License, etc.)<br>PLEASE INDICATE ID Number and Date of Issuance</td>
                <td width=\"2%\" height=\"25.5\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>
                <td width=\"36%\" colspan=\"4\" rowspan=\"3\" class=\"value sharp-border zero-bottom-border\"></td>

                <td width=\"2%\" height=\"25.5\" colspan=\"1\" class=\"value zero-left-border zero-top-border zero-right-border zero-bottom-border\"></td>
                <td width=\"24%\" height=\"25.5\" colspan=\"2\" class=\"value zero-top-border zero-bottom-border sharp-left-border\"></td>
                <td width=\"1%\" height=\"25.5\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-right-border zero-bottom-border\"></td>
            </tr>
            <tr>
                <td width=\"3%\" height=\"20.25\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>
                <td width=\"35%\" height=\"20.25\" colspan=\"2\" class=\"value value-up-down-border\" style=\"font-size: 8px;\">Government Issued ID: {$data->government_id_type}</td>
                <td width=\"2%\" height=\"20.25\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>

                <td width=\"2%\" height=\"20.25\" colspan=\"1\" class=\"value zero-left-border zero-top-border zero-right-border zero-bottom-border\"></td>
                <td width=\"24%\" height=\"20.25\" colspan=\"2\" class=\"value zero-top-border zero-bottom-border sharp-left-border\"></td>
                <td width=\"1%\" height=\"20.25\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-right-border zero-bottom-border\"></td>
            </tr>

            <tr>
                <td width=\"3%\" height=\"9\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>
                <td width=\"35%\" height=\"21\" colspan=\"2\" rowspan=\"2\" class=\"value value-up-down-border\" style=\"font-size: 8px;\">ID/License/Passport No.: {$data->government_id_number}</td>
                <td width=\"2%\" height=\"9\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>

                <td width=\"2%\" height=\"9\" colspan=\"1\" class=\"value zero-left-border zero-top-border zero-right-border zero-bottom-border\"></td>
                <td width=\"24%\" height=\"9\" colspan=\"2\" class=\"value zero-top-border zero-bottom-border sharp-left-border\"></td>
                <td width=\"1%\" height=\"9\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-right-border zero-bottom-border\"></td>
            </tr>

            <tr>
                <td width=\"3%\" height=\"12\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>
                <td width=\"2%\" height=\"12\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>
                <td width=\"36%\" colspan=\"4\" class=\"key value-up-down-border sharp-left-border sharp-right-border\"><center>Signature (Sign inside the box)</center></td>

                <td width=\"2%\" height=\"12\" colspan=\"1\" class=\"value zero-left-border zero-top-border zero-right-border zero-bottom-border\"></td>
                <td width=\"24%\" height=\"12\" colspan=\"2\" class=\"value zero-top-border zero-bottom-border sharp-left-border \"></td>
                <td width=\"1%\" height=\"12\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-right-border zero-bottom-border\"></td>
            </tr>

            <tr>
                <td width=\"3%\" height=\"10.5\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>
                <td width=\"35%\" height=\"23.25\" colspan=\"2\" rowspan=\"2\" class=\"value value-up-down-border\" style=\"font-size: 8px;\">Date/Place of Issuance: {$data->issued_date}/{$data->issued_place}</td>
                <td width=\"2%\" height=\"10.5\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>
                <td width=\"36%\" height=\"10.5\" colspan=\"4\" class=\"value value-up-down-border sharp-left-border sharp-right-border\" style=\"padding-top: 0px; padding-bottom: 0px;\"><center>".date("d")." ".strtoupper(date("F"))." ".date("Y")."</center></td>

                <td width=\"2%\" height=\"10.5\" colspan=\"1\" class=\"value zero-left-border zero-top-border zero-right-border zero-bottom-border\"></td>
                <td width=\"24%\" height=\"10.5\" colspan=\"2\" class=\"value zero-top-border zero-bottom-border sharp-left-border\"></td>
                <td width=\"1%\" height=\"10.5\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-right-border zero-bottom-border\"></td>
            </tr>

            <tr>
                <td width=\"3%\" height=\"12.75\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>
                <td width=\"2%\" height=\"12.75\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-bottom-border\"></td>
                <td width=\"36%\" height=\"12.75\" colspan=\"4\" class=\"key value-up-down-border sharp-left-border sharp-right-border\" style=\"padding-top: 0px; padding-bottom: 0px;\"><center>Date Accomplished</center></td>

                <td width=\"2%\" height=\"12.75\" colspan=\"1\" class=\"value zero-left-border zero-top-border zero-right-border zero-bottom-border\"></td>
                <td width=\"24%\" height=\"12.75\" colspan=\"2\" class=\"key zero-top-border zero-bottom-border sharp-left-border value-up-down-border \"><center>Right Thumbmark</center></td>
                <td width=\"1%\" height=\"12.75\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-right-border zero-bottom-border\"></td>
            </tr>

            <tr>
                <td width=\"3%\" height=\"8.25\" colspan=\"1\" class=\"value no-border\"></td>
                <td width=\"35%\" height=\"8.25\" colspan=\"2\" class=\"value sharp-border zero-left-border zero-right-border\" style=\"font-size: 8px;\"></td>
                <td width=\"2%\" height=\"8.25\" colspan=\"1\" class=\"value no-border\"></td>
                <td width=\"36%\" height=\"8.25\" colspan=\"4\" class=\"value sharp-border zero-left-border zero-right-border\"></td>

                <td width=\"2%\" height=\"8.25\" colspan=\"1\" class=\"value zero-left-border zero-top-border zero-right-border zero-bottom-border\"></td>
                <td width=\"24%\" height=\"8.25\" colspan=\"2\" class=\"value sharp-border zero-left-border zero-right-border\"></td>
                <td width=\"1%\" height=\"8.25\" colspan=\"1\" class=\"value sharp-border zero-top-border zero-left-border zero-right-border zero-bottom-border\"></td>
            </tr>

            <tr>
                <td width=\"3%\" height=\"28.5\" colspan=\"1\" class=\"value sharp-border zero-right-border zero-bottom-border\"></td>
                <td width=\"99%\" height=\"28.5\" colspan=\"10\" class=\"value sharp-border zero-left-border zero-right-border zero-bottom-border\">
                <center>
                SUBSCRIBED AND SWORN to before me this_________________________________________, affiant exhibiting his/her validly issued government ID as indicated above.
                </center>
                </td>
                <td width=\"1%\" height=\"28.5\" colspan=\"1\" class=\"value sharp-border zero-left-border zero-right-border zero-bottom-border\"></td>
            </tr>

            <tr>
                <td width=\"3%\" height=\"53.25\" colspan=\"1\" class=\"value no-border\"></td>
                <td width=\"12%\" height=\"53.25\" colspan=\"1\" class=\"value no-border\"></td>
                <td width=\"23%\" height=\"53.25\" colspan=\"1\" class=\"value no-border\"></td>
                <td width=\"38%\" height=\"53.25\" colspan=\"5\" class=\"value sharp-border\"></td>
                <td width=\"2%\" height=\"53.25\" colspan=\"1\" class=\"value no-border\"></td>
                <td width=\"8%\" height=\"53.25\" colspan=\"1\" class=\"value no-border\"></td>
                <td width=\"16%\" height=\"53.25\" colspan=\"1\" class=\"value no-border\"></td>
                <td width=\"1%\" height=\"53.25\" colspan=\"1\" class=\"value no-border\"></td>
            </tr>
            <tr>
                <td width=\"38%\" height=\"18\" colspan=\"3\" class=\"value no-border\"></td>

                <td width=\"38%\" height=\"18\" colspan=\"5\" class=\"key sharp-border value-up-down-border\"><center>Person Administering Oath</center></td>
                <td width=\"27%\" height=\"18\" colspan=\"4\" class=\"value no-border\"></td>
            </tr>
            <tr>
                <td width=\"3%\" height=\"1\" colspan=\"1\" class=\"value no-border\"></td>
                <td width=\"103%\" height=\"1\" colspan=\"11\" class=\"value no-border\"></td>
            </tr>
        </table>";

        $isPageBreak = true;

        if(!empty($data->additional_children)){
            if($isPageBreak) {
                $body .="<pagebreak>";
                $isPageBreak = false;
            }

            $body .= "
            <table  cellpadding=\"5\">
                <tr>
                    <td width=\"100%\" colspan=\"2\" class=\"sub-title\" style=\"font-size: 12px;\"><center><b>CHILDREN</b></center></td>
                </tr>
                <tr>
                    <td width=\"50%\" colspan=\"1\" class=\"key border-key\">NAME of CHILDREN  (Write full name and list all)</td>
                    <td width=\"50%\" colspan=\"1\" class=\"key border-key\">DATE OF BIRTH (mm/dd/yyyy) </td>
                </tr>";
            foreach ($data->additional_children as $value) {
                $body .= "<tr>
                <td width=\"50%\" colspan=\"1\" class=\"value border-key\" style=\"text-align: center;\">{$value->name}</td>
                <td width=\"50%\" colspan=\"1\" class=\"value border-key\" style=\"text-align: center;\">".date('m/d/Y',strtotime($value->birth_date))."</td>
                </tr>";
            }
            $body .="</table>";
        }

        if(!empty($data->additional_education)){
            if($isPageBreak) {
                $body .="<pagebreak>";
                $isPageBreak = false;
            }

            $body .= "
            <table  cellpadding=\"5\">
                <tr>
                    <td width=\"100%\" colspan=\"14\" class=\"sub-title\" style=\"font-size: 12px;\"><center><b>EDUCATIONAL BACKGROUND</b></center></td>
                </tr>
                <tr>
                    <td width=\"3%\" colspan=\"1\" rowspan=\"1\" class=\"key zero-right-border\" style=\"border-top: 1px solid black;\"></td>
                    <td width=\"15%\" colspan=\"2\" rowspan=\"3\" class=\"key border-key\" style=\"text-align:center;\">LEVEL</td>
                    <td width=\"27%\" colspan=\"3\" rowspan=\"3\" class=\"key value\" style=\"text-align:center;\">NAME OF SCHOOL<br> (Write in full)</td>
                    <td width=\"20%\" colspan=\"3\" rowspan=\"3\" class=\"key value\" style=\"text-align:center;\">BASIC EDUCATION/DEGREE/COURSE<br>(Write in full) </td>
                    <td width=\"10%\" colspan=\"2\" rowspan=\"2\" class=\"key value middle-border\" style=\"text-align:center;\">PERIOD OF ATTENDANCE</td>
                    <td width=\"7%\" colspan=\"1\" rowspan=\"3\" class=\"key value middle-border\" style=\"text-align:center;\">HIGHEST LEVEL/<br>UNITS EARNED<p style=\"font-size: 6px;\">(if not graduated)</p></td>
                    <td width=\"7%\" colspan=\"1\" rowspan=\"3\" class=\"key value\" style=\"text-align:center; font-size: 7px;\">YEAR GRADUATED</td>
                    <td width=\"8%\" colspan=\"1\" rowspan=\"3\" class=\"key value\" style=\"text-align:center; font-size: 7px;\">SCHOLARSHIP/ ACADEMIC HONORS RECEIVED</td>
                </tr>
                <tr>
                    <td width=\"3%\" colspan=\"1\" rowspan=\"1\" class=\"key zero-right-border\"></td>
                </tr>
                <tr>
                    <td width=\"3%\" colspan=\"1\" rowspan=\"1\" class=\"key zero-right-border\"></td>
                    <td width=\"5%\" colspan=\"1\" rowspan=\"1\" class=\"key value middle-border\" style=\"text-align:center;\">FROM</td>
                    <td width=\"5%\" colspan=\"1\" rowspan=\"1\" class=\"key value middle-border\" style=\"text-align:center;\">TO</td>
                </tr>";

            foreach ($data->additional_education as $value) {
                $body .="
                <tr>
                    <td width=\"18%\" colspan=\"3\" class=\"value border-key\">{$value->level}</td>
                    <td width=\"27%\" colspan=\"3\" class=\"value\">{$value->school_name}</td>
                    <td width=\"20%\" colspan=\"3\" class=\"value\">{$value->course}</td>
                    <td width=\"5%\" colspan=\"1\" class=\"value middle-border\">{$value->attended_from}</td>
                    <td width=\"5%\" colspan=\"1\" class=\"value\">{$value->attended_to}</td>
                    <td width=\"7%\" colspan=\"1\" class=\"value middle-border\">{$value->highest_level}</td>
                    <td width=\"7%\" colspan=\"1\" class=\"value\">{$value->year_graduated}</td>
                    <td width=\"8%\" colspan=\"1\" class=\"value\" style=\"font-size:6px;\">{$value->honors}</td>
                </tr>";
            }
            $body .="</table>";
        }

        if(!empty($data->additional_eligibility)){
            if($isPageBreak) {
                $body .="<pagebreak>";
                $isPageBreak = false;
            }

            $body .= "
            <table  cellpadding=\"5\">
                <tr>
                    <td width=\"100%\" colspan=\"13\" class=\"sub-title\" style=\"font-size: 12px;\"><center><b> CIVIL SERVICE ELIGIBILITY</b></center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number border-key\" style=\"font-size: 6px;\"></td>
                    <td width=\"28%\" rowspan=\"2\" colspan=\"4\" class=\"key border-top\">CAREER SERVICE/ RA 1080 (BOARD/ BAR) UNDER SPECIAL LAWS/ CES/ CSEE BARANGAY ELIGIBILITY / DRIVER'S LICENSE</td>
                    <td width=\"11%\" rowspan=\"2\" colspan=\"1\" class=\"key border-top border-left\"><center>RATING<br>(If Applicable)</center></td>
                    <td width=\"12%\" rowspan=\"2\" colspan=\"2\" class=\"key border-top border-left\"><center>DATE OF EXAMINATION / CONFERMENT</center></td>
                    <td width=\"30%\" rowspan=\"2\" colspan=\"3\" class=\"key border-top border-left\"><center>PLACE OF EXAMINATION / CONFERMENT</center></td>
                    <td width=\"16%\" rowspan=\"1\" colspan=\"2\" class=\"key border-top\"><center>LICENSE (if applicable)</center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number\"></td>
                    <td width=\"9%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>NUMBER</center></td>
                    <td width=\"7%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>Date of Validity</center></td>
                </tr>";
            foreach ($data->additional_eligibility as $value) {
                $body .="<tr>
                    <td width=\"26%\" colspan=\"5\" class=\"value\">{$value->type}</td>
                    <td width=\"11%\" colspan=\"1\" class=\"value\">{$value->rating}</td>
                    <td width=\"12%\" colspan=\"2\" class=\"value\">".date('m/d/Y', strtotime($value->date_conferment))."</td>
                    <td width=\"30%\" colspan=\"3\" class=\"value\">{$value->place_conferment}</td>
                    <td width=\"9%\" colspan=\"1\" class=\"value\" style=\"font-size: 7px;\">{$value->license_number}</td>
                    <td width=\"7%\" colspan=\"1\" class=\"value\" style=\"font-size: 7px;\">".date('m/d/Y',strtotime($value->license_validity))."</td>
                </tr>";
            }
            $body .="</table>";
        }

        if(!empty($data->additional_workExperience)){
            if($isPageBreak) {
                $body .="<pagebreak>";
                $isPageBreak = false;
            }

            $body .= "
            <table  cellpadding=\"5\">
                <tr>
                    <td width=\"100%\" colspan=\"13\" class=\"sub-title\" style=\"font-size: 12px;\"><center><b>WORK EXPERIENCE</b></center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number border-key\" style=\"font-size: 6px;\"></td>
                    <td width=\"13%\" rowspan=\"2\" colspan=\"2\" class=\"key border-top\"><center>INCLUSIVE DATES<br>(mm/dd/yyyy)</center></td>
                    <td width=\"26%\" rowspan=\"3\" colspan=\"3\" class=\"key border-top\"><center>POSITION TITLE<br>(Write in full/Do not abbreviate)</center></td>
                    <td width=\"27%\" rowspan=\"3\" colspan=\"3\" class=\"key border-top\"><center>DEPARTMENT / AGENCY / OFFICE / COMPANY<br>(Write in full/Do not abbreviate)</center></td>
                    <td width=\"8%\" rowspan=\"3\" colspan=\"1\" class=\"key border-top\"><center>MONTHLY SALARY</center></td>
                    <td width=\"8%\" rowspan=\"3\" colspan=\"1\" class=\"key border-top\" style=\"font-size: 7px;\"><center>SALARY/ JOB/ PAY GRADE (if applicable)& STEP  (Format \"00-0\")/ INCREMENT</center></td>
                    <td width=\"9%\" rowspan=\"3\" colspan=\"1\" class=\"key border-top\" style=\"font-size: 8px;\"><center>STATUS OF APPOINTMENT</center></td>
                    <td width=\"7%\" rowspan=\"3\" colspan=\"1\" class=\"key border-top\"><center>GOV'T SERVICE (Y/ N)</center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number\"></td>
                </tr>
                <tr>
                    <td width=\"8%\" rowspan=\"1\" colspan=\"2\" class=\"key border-key\"><center>From</center></td>
                    <td width=\"8%\" rowspan=\"1\" colspan=\"1\" class=\"key border-key\"><center>To</center></td>
                </tr>";
            foreach ($data->additional_workExperience as $value) {
                $body .= "
                <tr>
                    <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"2\" class=\"value\">".($value->date_from != 'N/A'?date('m/d/Y', strtotime($value->date_from)):'N/A')."</td>
                    <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">".($value->date_to != 'PRESENT'?date('m/d/Y', strtotime($value->date_to)):$value->date_to)."</td>
                    <td width=\"26%\" height=\"31\" rowspan=\"1\" colspan=\"3\" class=\"value\">{$value->position}</td>
                    <td width=\"27%\" height=\"31\" rowspan=\"1\" colspan=\"3\" class=\"value\">{$value->company}</td>
                    <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">{$value->salary}</td>
                    <td width=\"8%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">{$value->pay_grade}</td>
                    <td width=\"9%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">{$value->status_of_appointment}</td>
                    <td width=\"7%\" height=\"31\" rowspan=\"1\" colspan=\"1\" class=\"value\">".($value->is_government_service?'Y':'N')."</td>
                </tr>";
            }
            $body .="</table>";
        }

        if(!empty($data->additional_volunteering)){
            if($isPageBreak) {
                $body .="<pagebreak>";
                $isPageBreak = false;
            }

            $body .= "
            <table  cellpadding=\"5\">
                <tr>
                    <td width=\"100%\" colspan=\"11\" class=\"sub-title\" style=\"font-size: 12px;\"><center><b>VOLUNTARY WORK OR INVOLVEMENT IN CIVIC / NON-GOVERNMENT / PEOPLE / VOLUNTARY ORGANIZATION/S</b></center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number border-key\" style=\"font-size: 6px;\"></td>
                    <td width=\"52%\" rowspan=\"2\" colspan=\"3\" class=\"key border-top\"><center>NAME & ADDRESS OF ORGANIZATION<br>(Write in full)</center></td>
                    <td width=\"19%\" rowspan=\"1\" colspan=\"2\" class=\"key border-top border-left\"><center>INCLUSIVE DATES<br>(mm/dd/yyyy)</center></td>
                    <td width=\"9%\" rowspan=\"2\" colspan=\"1\" class=\"key border-top border-left\"><center>NUMBER OF HOURS</center></td>
                    <td width=\"42%\" rowspan=\"2\" colspan=\"4\" class=\"key border-top border-left\"><center>POSITION / NATURE OF WORK</center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number\"></td>
                    <td width=\"10%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>From</center></td>
                    <td width=\"9%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>To</center></td>
                </tr>";

            foreach ($data->additional_volunteering as $value) {
                $body .= "
                <tr>
                    <td width=\"55%\" colspan=\"4\" class=\"value\">{$value->organization}</td>
                    <td width=\"10%\" colspan=\"1\" class=\"value border-left\">".date('m/d/Y', strtotime($value->date_from))."</td>
                    <td width=\"9%\" colspan=\"1\" class=\"value border-left\">".date('m/d/Y', strtotime($value->date_to))."</td>
                    <td width=\"9%\" colspan=\"1\" class=\"value border-left\">{$value->number_of_hours}</td>
                    <td width=\"42%\" colspan=\"4\" class=\"value border-left\">{$value->position} / {$value->nature_of_work}</td>
                </tr>";
            }
            $body .="</table>";
        }

        if(!empty($data->additional_training)){
            if($isPageBreak) {
                $body .="<pagebreak>";
                $isPageBreak = false;
            }

            $body .= "
                <table  cellpadding=\"5\">
                <tr>
                    <td width=\"100%\" colspan=\"11\" class=\"sub-title\" style=\"font-size: 12px;\"><center><b>LEARNING AND DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED</b></center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number border-key\" style=\"font-size: 6px;\"></td>
                    <td width=\"52%\" rowspan=\"3\" colspan=\"3\" class=\"key border-top\"><center>TITLE OF LEARNING AND DEVELOPMENT INTERVENTIONS/TRAINING PROGRAMS<br>(Write in full)</center></td>
                    <td width=\"19%\" rowspan=\"2\" colspan=\"2\" class=\"key border-top border-left\"><center>INCLUSIVE DATES OF ATTENDANCE<br>(mm/dd/yyyy)</center></td>
                    <td width=\"9%\" rowspan=\"3\" colspan=\"1\" class=\"key border-top border-left\"><center>NUMBER OF HOURS</center></td>
                    <td width=\"11%\" rowspan=\"3\" colspan=\"1\" class=\"key border-top border-left\" style=\"font-size: 8px;\"><center>Type of LD(Managerial/ Supervisory/Technical/etc) </center></td>
                    <td width=\"31%\" rowspan=\"3\" colspan=\"3\" class=\"key border-top border-left\"><center> CONDUCTED/ SPONSORED BY<br>(Write in full)</center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number\"></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"1\" colspan=\"1\" class=\"number\"></td>
                    <td width=\"10%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>From</center></td>
                    <td width=\"9%\" rowspan=\"1\" colspan=\"1\" class=\"key border-top\"><center>To</center></td>
                </tr>";

            foreach ($data->additional_training as $value) {
                $body .= "
                <tr>
                    <td width=\"55%\" colspan=\"4\" class=\"value\">{$value->program}</td>
                    <td width=\"10%\" colspan=\"1\" class=\"value border-left\">".date('m/d/Y', strtotime($value->date_from))."</td>
                    <td width=\"9%\" colspan=\"1\" class=\"value border-left\">".date('m/d/Y', strtotime($value->date_to))."</td>
                    <td width=\"9%\" colspan=\"1\" class=\"value border-left\">{$value->number_of_hours}</td>
                    <td width=\"11%\" colspan=\"1\" class=\"value border-left\">{$value->type_of_ld}</td>
                    <td width=\"31%\" colspan=\"3\" class=\"value border-left\">{$value->sponsored_by}</td>
                </tr>";
            }
            $body .="</table>";
        }

        if(!empty($data->additional_skill) || !empty($data->additional_recognition) || !empty($data->additional_membership)){
            if($isPageBreak) {
                $body .="<pagebreak>";
                $isPageBreak = false;
            }

            $body .= "
                <table  cellpadding=\"5\">
                    <tr>
                        <td width=\"100%\" colspan=\"1\" class=\"sub-title\" style=\"font-size: 12px;\"><center><b>OTHER INFORMATION</b></center></td>
                    </tr>";
            if(!empty($data->additional_skill)) {
                $body .= "
                    <tr>
                        <td width=\"100%\" colspan=\"1\" class=\"key border-top border-bottom\"><center>SPECIAL SKILLS and HOBBIES</center></td>
                    </tr>";

                foreach ($data->additional_skill as $value) {
                    $body .= "
                    <tr>
                        <td width=\"100%\" colspan=\"1\" class=\"value\">$value</td>
                    </tr>";
                }
            }

            if(!empty($data->additional_recognition)) {
                $body .= "
                    <tr>
                        <td width=\"100%\" colspan=\"1\" class=\"key border-top border-bottom\"><center>NON-ACADEMIC DISTINCTIONS / RECOGNITION<br>(Write in full)</center></td>
                    </tr>";

                foreach ($data->additional_recognition as $value) {
                    $body .= "
                    <tr>
                        <td width=\"100%\" colspan=\"1\" class=\"value border-left\">$value</td>
                    </tr>";
                }
            }

            if(!empty($data->additional_membership)) {
                $body .= "
                    <tr>
                        <td width=\"100%\" colspan=\"1\" class=\"key border-top border-bottom\"><center>MEMBERSHIP IN ASSOCIATION/ORGANIZATION<br>(Write in full)</center></td>
                    </tr>";

                foreach ($data->additional_membership as $value) {
                    $body .= "
                    <tr>
                        <td width=\"100%\" colspan=\"1\" class=\"value border-left\" style=\"font-size: 7px;\">$value</td>
                    </tr>";
                }
            }

            $body .="</table>";
        }

        if(!empty($data->additional_reference)){
            if($isPageBreak) {
                $body .="<pagebreak>";
                $isPageBreak = false;
            }

            $body .= "
                <table  cellpadding=\"5\">
                    <tr>
                        <td width=\"100%\" colspan=\"3\" class=\"sub-title\" style=\"font-size: 12px;\"><center><b>References</b></center></td>
                    </tr>
                    <tr>
                        <td width=\"40%\" colspan=\"1\" class=\"key border-top\"><center>NAME</center></td>
                        <td width=\"40%\" colspan=\"1\" class=\"key border-top\"><center>ADDRESS</center></td>
                        <td width=\"20%\" colspan=\"1\" class=\"key border-top sharp-right-border\"><center>TEL NO.</center></td>
                    </tr>";

            foreach ($data->additional_reference as $value) {
                $body .= "
                <tr>
                    <td width=\"40%\" colspan=\"1\" class=\"value\" height=\"24\">{$value->name}</td>
                    <td width=\"26%\" colspan=\"1\" class=\"value\" height=\"24\">{$value->address}</td>
                    <td width=\"10%\" colspan=\"1\" class=\"value sharp-right-border\" height=\"24\">{$value->telephone}</td>
                </tr>";
            }
            $body .="</table>";
        }
    
        return $this->applyHtmlTemplate("PDS - $data->last_name", $style, $body, '', $footer); // '' => header
    }

    public function pdf($data){
        $style = "
            table, td, td {
                margin: 0px 0px;
            border-collapse: collapse;
            }
            table {
                width: 100%;
                border: 2px solid black;
            }
            td {
                font-family: Arial, Helvetica, sans-serif;
            }
            .topText {
                position: absolute;
                top : 28px;
                left: 16px;
            }
            .top-text {
                font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
                font-weight: bold;
                font-style: italic;
                font-size: 8px;
            }
            p.title {
                font-size: 14px;
                font-weight: bold;
                text-align: center;
            }
            p.body {
                font-size: 7px;
                font-weight: bold;
                text-align: left;
            }
            p.italic-body {
                font-size: 8px;
                font-weight: bold;
                text-align: left;
                font-style: italic;
            }
            td.light-body {
                font-size: 7px;
                font-weight: 400;
                text-align: left;
            }
            td.cs-id {
                font-size: 8px;
                font-weight: 400;
                text-align: left;
                background-color: rgb(150,150,150);
                border: 1px solid black;
            }
            td.cs-id-text {
                font-size: 6px;
                font-weight: 400;
                text-align: right;
                border: 1px solid black;
            }
            tr.after-title{
                border-bottom: 4px solid black;
            }


            td.sub-title{
                font-size: 13px;
                font-weight: bold;
                text-align: left;
                color: white;
                font-style: italic;
                font-stretch:ultra-condensed;
                padding-top: 1px;
                padding-bottom: 1px;
                background-color: rgb(150,150,150);
            }
            tr.after-sub-title{
                border: 2px solid black;
            }

            td{
                font-family: Arial, Helvetica, sans-serif;
                font-size: 9px;
            }

            .number {
                text-align:left;
                vertical-align: text-top;
                background-color: rgb(234, 234, 234);
                font-size: 8px;
            }

            .key {
                font-size: 12px;
                background-color: rgb(234, 234, 234);
                border-right: 1px solid black;
                padding-top: 1px;
                padding-bottom: 1px;
            }
            .citi-key {
                border-left: 1px solid black;
            }

            .value {
                font-size: 11px;
                border: 1px solid black;
            }
            .valueLight {
                font-size: 11px;
                border: 0px solid rgb(212, 212, 212);
            }
            .zero-value {
                border: 0px solid black;
            }

            .border-key {
                border-top: 1px solid black;
            }

            .zero-right-border {
                border-right: 0px solid black;
            }

            .zero-left-border {
                border-left: 0px solid black;
            }
            .zero-bottom-border {
                border-bottom: 0px solid black;
            }
            .zero-top-border {
                border-top: 0px solid black;
            }
            .border-right {
                border-right: 1px solid black;
            }
            .border-left {
                border-left: 1px solid black;
            }

            .middle-border {
                border-left: 2px solid black;
            }
            .up-down-border {
                border-top: 2px solid black;
                border-bottom: 2px solid black;
            }
            .value-up-down-border {
                border-top: 2px solid black;
                border-bottom: 2px solid black;
            }

            .no-border {
                border: 0px solid black;

            }

            .sharp-border {
                border: 2px solid black;
            }
            .zero-border {
                border-left: 0px solid black;
            }
            .border-top {
                border-top: 1px solid black;
            }
            .border-bottom {
                border-bottom: 1px solid black;
            }

            .bottom-text {
                font-family: Arial, Helvetica, sans-serif;
                font-size: 7px;
                text-align: right;
                margin-top: 0px;
            }
            .sharp-right-border{
                border-right: 2px solid black;
            }
            u {
                text-decoration: none;
                border-bottom: 2px solid black;
            }
        ";

        $body = "
            <table cellpadding=\"5\">
            <tr>
                <td width=\"50%\" colspan=\"3\" rowspan=\"2\" class=\"border-right border-key\">
                    <center>
                        <br>
                        <p class=\"title\">
                            Republic of the Philippines<br>
                            POSITION DESCRIPTION FORM<br>
                            DBM-CSC Form No. 1
                        </p>
                        (Revised  Version No. 1 , s. 2017)
                        <br><br><br><br>
                    </center>
                </td>
                <td width=\"50%\" height=\"27.75\" colspan=\"3\" rowspan=\"1\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>1.  POSITION TITLE (as approved  by authorized agency) with parenthetical title</b>
                </td>
            </tr>
            <tr>
                <td width=\"50%\" height=\"55.5\" colspan=\"3\" rowspan=\"1\" class=\"value zero-bottom-border\">
                    <center><b>{$data->positionName}</b></center>
                </td>
            </tr>
            <tr>
                <td width=\"50%\" colspan=\"3\" rowspan=\"1\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>2. ITEM NUMBER</b>
                </td>
                <td width=\"50%\" colspan=\"3\" rowspan=\"1\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>3. SALARY GRADE</b>
                </td>
            </tr>
            <tr>
                <td width=\"50%\" colspan=\"3\" class=\"value\" height=\"45\">
                    <center><b>{$data->item_number}</b></center>
                </td>
                <td width=\"50%\" colspan=\"3\" class=\"value\"  height=\"45\">
                    <center>{$data->sgOnPrint}</center>
                </td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" class=\"key border-key\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>4. FOR LOCAL GOVERNMENT POSITION, ENUMERATE GOVERNMENTAL UNIT AND CLASS</b>
                </td>
            </tr>
            <tr>
                <td width=\"38%\" height=\"67.5\" colspan=\"2\" class=\"value zero-left-border zero-right-border\"  style=\"padding-left: 100px;\">
                    <input type=\"checkbox\">Province<br>
                    <input type=\"checkbox\">City<br>
                    <input type=\"checkbox\"> Municipality
                </td>
                <td width=\"36%\" height=\"67.5\" colspan=\"2\" class=\"value zero-left-border zero-right-border\" style=\"padding-left: 70px;\">
                    <input type=\"checkbox\">1st Class<br>
                    <input type=\"checkbox\">2nd Class<br>
                    <input type=\"checkbox\"> 3rd Class<br>
                    <input type=\"checkbox\"> 4th Class
                </td>
                <td width=\"26%\" height=\"67.5\" colspan=\"2\" class=\"value zero-left-border zero-right-border\">
                    <input type=\"checkbox\">5th Class<br>
                    <input type=\"checkbox\">6th Class<br>
                    <input type=\"checkbox\">Special
                </td>
            </tr>
            <tr>
                <td width=\"50%\" colspan=\"3\" class=\"key border-key\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>5.  DEPARTMENT, CORPORATION OR AGENCY/<br>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LOCAL GOVERNMENT</b>
                </td>
                <td width=\"50%\" colspan=\"3\" class=\"key border-key\" style=\"padding-top: 0px; padding-bottom: 0px;\" style=\"vertical-align: text-top;\">
                        <b>6.  BUREAU OR OFFICE</b>
                    </td>
            </tr>
            <tr>
                <td width=\"50%\" colspan=\"3\" class=\"value\" height=\"45\">
                    <center><p>{$this->DEPARTMENT_NAME}</p></center>
                </td>
                <td width=\"50%\" colspan=\"3\" class=\"value\"  height=\"45\">
                    <center><p>{$this->OFFICE_NAME}</p></center>
                </td>
            </tr>
            <tr>
                <td width=\"50%\" colspan=\"3\" class=\"key border-key\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>7.  DEPARTMENT / BRANCH / DIVISION</b>
                </td>
                <td width=\"50%\" colspan=\"3\" class=\"key border-key\" style=\"padding-top: 0px; padding-bottom: 0px;\" style=\"vertical-align: text-top;\">
                        <b>8.  WORKSTATION / PLACE OF WORK</b>
                    </td>
            </tr>
            <tr>
                <td width=\"50%\" colspan=\"3\" class=\"value\" height=\"45\">
                    <center><i>{$data->divisionOnPrint}</i></center>
                </td>
                <td width=\"50%\" colspan=\"3\" class=\"value\"  height=\"45\">
                    <center>{$data->place_of_work}</center>
                </td>
            </tr>
            <tr>
                <td width=\"22%\" colspan=\"1\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>9.  PRESENT APPROP ACT</b>
                </td>
                <td width=\"28%\" colspan=\"2\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>10.  PREVIOUS APPROP ACT</b>
                </td>
                <td width=\"24%\" colspan=\"1\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>11.  SALARY AUTHORIZED</b>
                </td>
                <td width=\"26%\" colspan=\"2\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>12.  OTHER COMPENSATION</b>
                </td>
            </tr>
            <tr>
                <td width=\"22%\" height=\"45\" colspan=\"1\" class=\"value zero-right-border \">

                </td>
                <td width=\"28%\" height=\"45\" colspan=\"2\" class=\"value zero-right-border zero-left-border\">

                </td>
                <td width=\"24%\" height=\"45\" colspan=\"1\" class=\"value zero-right-border\">
                    <center>{$data->salaryOnPrint}</center>
                </td>
                <td width=\"26%\" height=\"45\" colspan=\"2\" class=\"value zero-right-border zero-left-border\">

                </td>
            </tr>
            <tr>
                <td width=\"50%\" colspan=\"3\" class=\"key border-key\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>13.  POSITION TITLE OF IMMEDIATE SUPERVISOR</b>
                </td>
                <td width=\"50%\" colspan=\"3\" class=\"key border-key\" style=\"padding-top: 0px; padding-bottom: 0px;\" style=\"vertical-align: text-top;\">
                        <b>14.  POSITION TITLE OF NEXT HIGHER SUPERVISOR</b>
                    </td>
            </tr>
            <tr>
                <td width=\"50%\" colspan=\"3\" class=\"value\" height=\"45\">
                    <center>{$data->immediateSupervisorName}</center>
                </td>
                <td width=\"50%\" colspan=\"3\" class=\"value\"  height=\"45\">
                    <center>{$data->nextSupervisorName}</center>
                </td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" class=\"key border-key\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>15.  POSITION TITLE, AND ITEM OF THOSE DIRECTLY SUPERVISED</b>
                </td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" class=\"value\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><i>(if more than seven (7) list only by their item numbers and titles)</i></center>
                </td>
            </tr>
            <tr>
                <td width=\"50%\" colspan=\"3\" class=\"value\">
                    <center><b>POSITION TITLE</b></center>
                </td>
                <td width=\"50%\" colspan=\"3\" class=\"value\">
                    <center><b>ITEM NUMBER</b></center>
                </td>
            </tr>
            <tr>
                <td width=\"50%\" colspan=\"3\" class=\"value\" height=\"130\" style=\"vertical-align: top;\">
                    {$data->supervisedPositionTitleOnPrint}
                </td>
                <td width=\"50%\" colspan=\"3\" class=\"value\"  height=\"130\" style=\"vertical-align: top;\">
                    {$data->supervisedItemNumberOnPrint}
                </td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" class=\"key border-key\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>16.  MACHINE, EQUIPMENT, TOOLS, ETC., USED REGULARLY IN PERFORMANCE OF WORK</b>
                </td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" class=\"value\" height=\"55\">
                    <p>{$data->equipmentsOnPrint}</p>
                </td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" class=\"key border-key\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>17.  CONTACTS / CLIENTS / STAKEHOLDERS</b>
                </td>
            </tr>
            <tr>
                <td width=\"22%\" height=\"22\" colspan=\"1\" class=\"key border-key\" style=\"border-bottom: 1px solid black; padding-top: 0px; padding-bottom: 0px;\">
                    <b>17a.  Internal</b>
                </td>
                <td width=\"16%\" height=\"22\" colspan=\"1\" class=\"key border-key\" style=\"border-bottom: 1px solid black; padding-top: 0px; padding-bottom: 0px;\">
                    <b>Occasional</b>
                </td>
                <td width=\"12%\" height=\"22\" colspan=\"1\" class=\"key border-key\" style=\"border-bottom: 1px solid black; padding-top: 0px; padding-bottom: 0px;\">
                    <b>Frequent</b>
                </td>
                <td width=\"24%\" height=\"22\" colspan=\"1\" class=\"key border-key\" style=\"border-bottom: 1px solid black; padding-top: 0px; padding-bottom: 0px;\">
                    <b>17b.  External</b>
                </td>
                <td width=\"13%\" height=\"22\" colspan=\"1\" class=\"key border-key\" style=\"border-bottom: 1px solid black; padding-top: 0px; padding-bottom: 0px;\">
                    <b>Occasional</b>
                </td>
                <td width=\"13%\" height=\"22\" colspan=\"1\" class=\"key border-key\" style=\"border-bottom: 1px solid black; padding-top: 0px; padding-bottom: 0px;\">
                    <b>Frequent</b>
                </td>
            </tr>
            <tr>
                <td width=\"22%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p>Executive / Managerial</p></td>";

        if($data->contact_internal_executive == 'Occasional'){
            $body .= "<td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">";
            $body .= "<center><input type=\"checkbox\" checked=\"checked\"></center>";
            $body .= "</td>";

        }else{
            $body .= "<td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">";
            $body .= "<center><input type=\"checkbox\"></center>";
            $body .= "</td>";
        }

        if($data->contact_internal_executive == 'Frequent')
            $body .= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body.= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";


        $body .= "<td width=\"24%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p>General Public</p></td>";
        if($data->contact_external_public == 'Occasional')
            $body .= "
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        if($data->contact_external_public == 'Frequent')
            $body .= "
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        $body .= "
            </tr>
            <tr>
                <td width=\"22%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p>Supervisors</p></td>";

        if($data->contact_internal_supervisor == 'Occasional')
            $body .= "
                <td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        if($data->contact_internal_supervisor == 'Frequent')
            $body .= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        $body.= "<td width=\"24%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p>Other Agencies</p></td>";

        if($data->contact_external_agencies == 'Occasional')
            $body .= "
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        if($data->contact_external_agencies == 'Frequent')
            $body .= "
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        $body .= "
            </tr>
            <tr>
                <td width=\"22%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p>Non-Supervisors</p></td>";

        if($data->contact_internal_non_supervisor == 'Occasional')
            $body .= "
                <td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        if($data->contact_internal_non_supervisor == 'Frequent')
            $body .= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";


        $body .= "
                <td width=\"24%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <p>Others (Please Specify):</p>
                </td>
                <td width=\"26%\" height=\"17\" colspan=\"2\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <p>{$data->contact_external_others}</p>
                </td>
            </tr>
            <tr>
                <td width=\"22%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <p>Staff</p>
                </td>";

        if($data->contact_internal_staff == 'Occasional')
            $body .= "
                <td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        if($data->contact_internal_staff == 'Frequent')
            $body .= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        $body .= "
                <td width=\"24%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p></p></td>
                <td width=\"26%\" height=\"17\" colspan=\"2\" class=\"valueLight border-top border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p></p></td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" class=\"key border-key border-top border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\"><b>18.  WORKING CONDITION</b></td>
            </tr>
            <tr>
                <td width=\"22%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p>Office Work</p></td>";

        if($data->office_work == 'Occasional')
            $body .= "
                <td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        if($data->office_work == 'Frequent')
            $body .= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";


        $body .= "
                <td width=\"24%\" height=\"17\" colspan=\"1\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p>Other/s (Please Specify)</p></td>
                <td width=\"26%\" height=\"17\" colspan=\"2\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <p>{$data->other_work}</p>
                </td>
            </tr>
            <tr>
                <td width=\"22%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <p>Field Work</p>
                </td>";
        if($data->field_work == 'Occasional')
            $body .= "
                <td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        if($data->field_work == 'Frequent')
            $body .= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\" checked=\"checked\"></center>
                </td>";
        else
            $body .= "
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><input type=\"checkbox\"></center>
                </td>";

        $body .= "
                <td width=\"24%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p></p></td>
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p></p></td>
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p></p></td>
            </tr>
            <tr>
                <td width=\"22%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p></p></td>
                <td width=\"16%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p></p></td>
                <td width=\"12%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p></p></td>
                <td width=\"24%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p></p></td>
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p></p></td>
                <td width=\"13%\" height=\"17\" colspan=\"1\" class=\"valueLight border-bottom\" style=\"padding-top: 0px; padding-bottom: 0px;\"><p></p></td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" class=\"key border-key border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>19.  BRIEF DESCRIPTION OF THE GENERAL FUNCTION OF THE UNIT OR SECTION</b>
                </td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" height=\"220.5\" class=\"value border-key border-top\" valign=\"top\" style=\"padding-left: 25px; padding-right: 25px; padding-top: 20px;\">
                <p>{$data->general_function}</p>
                </td>
            </tr>

        </table>
        <div>
            <p class=\"bottom-text\"><i>Page 1 of 2</i></p>
        </div>
        <pagebreak>
        <table cellpading=\"5\">
            <tr>
                <td width=\"100%\" colspan=\"6\" class=\"key border-key border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>20.  BRIEF DESCRIPTION OF THE GENERAL FUNCTION OF THE POSITION (Job Summary)</b>
                </td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" height=\"220.5\" class=\"value border-key border-top\" valign=\"top\" style=\"padding-left: 25px; padding-right: 25px; padding-top: 20px;\">
                <p>{$data->job_summary}</p>
                </td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" class=\"key border-key border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>21.  QUALIFICATION STANDARDS</b>
                </td>
            </tr>
            <tr>
                <td width=\"25%\" colspan=\"1\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><b>21a.  Education</b></center>
                </td>
                <td width=\"30%\" colspan=\"2\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><b>21b.  Experience</b></center>
                </td>
                <td width=\"19%\" colspan=\"1\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><b>21c.  Training</b></center>
                </td>
                <td width=\"26%\" colspan=\"2\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><b>21d.  Eligibility</b></center>
                </td>
            </tr>
            <tr>
                <td width=\"25%\" height=\"97\" colspan=\"1\" class=\"value\">
                    <p>{$data->education}</p>
                </td>
                <td width=\"24%\" height=\"97\" colspan=\"2\" class=\"value\">
                    <p>{$data->experience}</p>
                </td>
                <td width=\"25%\" height=\"97\" colspan=\"1\" class=\"value\">
                    <p>{$data->training}</p>
                </td>
                <td width=\"26%\" height=\"97\" colspan=\"2\" class=\"value\">
                    <p>{$data->eligibility}</p>
                </td>
            </tr>
            <tr>
                <td width =\"64%\" colspan=\"4\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;21e.  Core Competencies</b>
                </td>
                <td width =\"26%\" colspan=\"2\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><b>Competency Level</b></center>
                </td>
            </tr>
            <tr>
                <td width =\"64%\" height=\"97.5\" colspan=\"4\" class=\"value\"  style=\"padding-top: 0px; padding-bottom: 0px;\" valign=\"top\">
                    <i>(Indicate the required Leadership Competencies here)</i><br>
                    <p>{$data->core_compentencies}</p>
                </td>
                <td width =\"26%\" height=\"97.5\" colspan=\"2\" class=\"value\"  style=\"padding-top: 0px; padding-bottom: 0px;\" valign=\"top\">
                    <i>(Indicate the required Competency Level here)</i><br>
                    <p>{$data->core_competency_level}</p>
                </td>
            </tr>
            <tr>
                <td width =\"64%\" colspan=\"4\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>&nbsp;&nbsp;&nbsp;&nbsp;21f.  Leadership Competencies</b>
                </td>
                <td width =\"26%\" colspan=\"2\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><b>Competency Level</b></center>
                </td>
            </tr>
            <tr>
                <td width =\"64%\" height=\"97.5\" colspan=\"4\" class=\"value\"  style=\"padding-top: 0px; padding-bottom: 0px;\" valign=\"top\">
                    <i>(Indicate the required Leadership Competencies here)</i><br>
                    <p>{$data->leadership_competencies}</p>
                </td>
                <td width =\"26%\" height=\"97.5\" colspan=\"2\" class=\"value\"  style=\"padding-top: 0px; padding-bottom: 0px;\" valign=\"top\">
                    <i>(Indicate the required Competency Level here)</i><br>
                    <p>{$data->leadership_compentency_level}</p>
                </td>
            </tr>
            <tr>
                <td width =\"64%\" colspan=\"4\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>22.  STATEMENT OF DUTIES AND RESPONSIBILITIES (Technical Competencies)</b>
                </td>
                <td width =\"26%\" colspan=\"2\" class=\"key border-key\"  style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <center><b>Competency Level</b></center>
                </td>
            </tr>
            <tr>
                <td width =\"22%\" height=\"25.5\" colspan=\"1\" class=\"value\">
                    <center><i>Percentage of Working Time </i></center>
                </td>
                <td width =\"52%\" height=\"25.5\" colspan=\"3\" class=\"value\">
                    <center><i>(State the duties and responsibilities here:) </i></center>
                </td>
                <td width =\"26%\" colspan=\"2\" rowspan=\"2\" class=\"value\" style=\"padding-top: 0px; padding-bottom: 0px;\" valign=\"top\">
                    <i>(Indicate the required Competency Level here)</i><br>
                    <p>{$data->duties_competency_level}</p>
                </td>
            </tr>
            <tr>
                <td width =\"22%\" height=\"75.75\" colspan=\"1\" class=\"value border-bottom\">
                    <p>{$data->percentage_working_time}</p>
                </td>
                <td width =\"52%\" height=\"75.75\" colspan=\"3\" class=\"value border-bottom\">
                    <p>{$data->duties_responsibilities}</p>
                </td>
            </tr>
            <tr>
                <td width=\"100%\" colspan=\"6\" class=\"key border-bottom border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\">
                    <b>23. ACKNOWLEDGMENT AND ACCEPTANCE:</b>
                </td>
            </tr>
            <tr>
                <td width=\"100%\" height=\"45\" colspan=\"6\" class=\"valueLight border-top\" style=\"padding-top: 0px; padding-bottom: 0px;\" valign=\"bottom\">
                    <p style=\"vertical-align: bottom\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I have received a copy of this position description. It has been discussed with me and I have freely chosen to comply with the performance and behavior/conduct expectations contained herein.</p>
                </td>
            </tr>
            <tr>
                <td width=\"50%\" height=\"80\" colspan=\"3\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\" valign=\"bottom\">
                    <center>
                        <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        ".strtoupper($data->employeeName)."
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    </center>
                </td>
                <td width=\"50%\" height=\"80\" colspan=\"3\" class=\"valueLight\" style=\"padding-top: 0px; padding-bottom: 0px;\" valign=\"bottom\">
                    <center>
                        <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        ".strtoupper($data->supervisorName)."
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    </center>
                </td>
            </tr>
            <tr>
                <td width=\"50%\" height=\"45\" colspan=\"3\" class=\"valueLight\" style=\"padding-top: 2px; padding-bottom: 0px;\" valign=\"top\">
                    <center><b>Employee's Name, Date and Signature</b></center>
                </td>
                <td width=\"50%\" height=\"45\" colspan=\"3\" class=\"valueLight\" style=\"padding-top: 2px; padding-bottom: 0px;\" valign=\"top\">
                    <center><b>Supervisor's Name, Date and Signature</b></center>
                </td>
            </tr>
            </table>
            <div>
                <p class=\"bottom-text\"><i>Page 2 of 2</i></p>
            </div>";

        return $this->applyHtmlTemplate("PDF - $data->title", $style, $body);
    }

    public function ce($data){
        $style = "
            body {
                font-family: 'times new roman';
                font-size: 12px;
                padding-left: 10%;
                padding-right: 10%;
            }
            table {
                border-collapse: collapse;
            }
            .table-request {
                width: 100%;
            }
            .table-request th, .table-request td, .table-request table {
                border: 1px solid black;
                text-align: center;
                padding: 2px;
            }
        ";

        $header = "
            <table>
                <tr>
                    <td><img src=\"".$this->image("logo.png")."\" width=\"80\" style=\"vertical-align:middle\"></td>
                    <td style=\"padding-left: 10px;\">
                        <span style=\"font-size: 17px;\">{$this->UPPER_HEADER}</span>
                        <br>
                        <span style=\"font-size: 24px;\">{$this->HEADER}</span>
                    </td>
                </tr>
            </table>
            <br><br>
            <table style=\"width: 100%\">
                <tr>
                    <td style=\"text-align: center\"><u><b>CERTIFICATE OF EMPLOYMENT</b></u></td>
                </tr>
            </table>
        ";

        $footer = "
            <hr>
            <table style=\"width: 100%; font-family: calibri; font-size: 9px\">
                <tr>
                    <td>{$this->ADDRESS}</td>
                    <td style=\"text-align: right\">{$this->CONTACT_NUMBER}</td>
                </tr>
            </table>
        ";

        $employee = $data->employee;

        $body = "
            <br><br><br><br><br><br><br><br><br>
                To Whom It May Concern:
            <br><br>
            This is to certify that <b>{$employee->fullName}</b> is employed by this Department
            as <b>{$employee->position}</b> from <b>{$employee->dateFrom}</b> to <b>{$employee->dateTo}</b>
            under a <b>{$employee->status}</b> appointment.
            <br><br>
            During his term of service, he has obtained the following:
            <br><br>
            <ol type=\"I\">
                <b><i><li><span style=\"margin-left: 5%;\">Service Record</span></li></i></b>
                <br>
                <div style=\"margin-left: 5%;\">
                    <table class=\"table-request\">
                        <tr>
                            <th>POSITION</th>
                            <th>DURATION</th>
                        </tr>
                        <tr>
                            <td colspan=\"2\">See attached Service Record</td>
                        </tr>
                    </table>
                </div>
                <br>
                <b><i><li><span style=\"margin-left: 5%;\">Performance Rating Reports</span></li></i></b>
                <br>
                <div style=\"margin-left: 5%;\">
                    <table>
                        <tr>
                            <td style=\"width: 12%;\">-</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
                <br>
                <b><i><li><span style=\"margin-left: 5%;\">Charges and/or Disciplinary Actions</span></li></i></b>
                <br>
                <div style=\"margin-left: 5%;\">
                    <table class=\"table-request\">
                        <tr>
                            <th style=\"width: 35%;\">NATURE OF CHARGE(S) *indicate dates</th>
                            <th style=\"width: 30%;\">STATUS</th>
                            <th style=\"width: 35%;\">DISCIPLINARY ACTION</th>
                        </tr>
                        <tr>
                            <td>None</td>
                            <td>None</td>
                            <td>None</td>
                        </tr>
                    </table>
                </div>
                <br>
                <b><i><li><span style=\"margin-left: 5%;\">Total Number of Late and Availed Leaves of Absences</span></li></i></b>
                <br>
                <div style=\"margin-left: 5%;\">
                    <table class=\"table-request\">
                        <tr>
                            <td>1</td>
                            <td style=\"text-align: left; padding-left: 2%;\">Late</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td style=\"text-align: left; padding-left: 2%;\">Vacation Leave</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td style=\"text-align: left; padding-left: 2%;\">Sick Leave</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td style=\"text-align: left; padding-left: 2%;\">Special Privilege Leave</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td style=\"text-align: left; padding-left: 2%;\">Forced Leave</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td style=\"text-align: left; padding-left: 2%;\">Paternity/Maternity Leave</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td style=\"text-align: left; padding-left: 2%;\">Parental Leave</td>
                            <td>0</td>
                        </tr>
                    </table>
                </div>
                <br>
                <b><i><li><span style=\"margin-left: 5%;\">State whether clearance is secured - Not Applicable</span></li></i></b>
            </ol>
            This Certification is issued on <b>".date('F d, Y')."</b> for whatever legal purpose it may serve.
            <br><br><br><br>
            <table style=\"width: 100%;\">
                <tr>
                    <td style=\"width: 50%;\"><b>{$data->name1}</b></td>
                    <td style=\"width: 50%;\"><b>{$data->name2}</b></td>
                </tr>
                <tr>
                    <td>{$data->position1}</td>
                    <td>{$data->position2}</td>
                </tr>
                <tr>
                    <td>{$data->division1}</td>
                    <td>{$data->division2}</td>
                </tr>
            </table>
        ";

        return $this->applyHtmlTemplate("Certificate of Employment", $style, $body, $header, $footer);
    }

    public function pea($data){
        $style = "
            body {
                font-family: {$this->BODY_FONT};
            }

            table, td, td {
                margin: 0px 0px;
                border-collapse: collapse;
            }
            table {
                width: 80%;
            }

            .tableName {
                font-size: 9.5px;
            }

            .tableContent {
                font-size: 9px;
                border: 1px solid black;
                width: 100%;
            }
            u {
                text-decoration: none;
                border-bottom: 1px solid black;
            }
            .no-border {
                border: 0px solid black;
            }
            .borderCon {
                border: 1px solid black;
            }

            .border-top {
                border-top: 1x solid black;
            }
            .border-bottom {
                border-bottom: 1px solid black;
            }
            .border-left-right {
                border-left: 1px solid black;
                border-right: 1px solid black;
            }
        ";

        $header = "
            <table cellpading=\"5\" align=\"center\" style=\"font-size: 10px;\">
                <tr>
                    <td width=\"100%\" colspan=\"2\" style=\"font-size: 11px;\" class=\"no-border\">
                        <center><b>".Str::upper($this->HEADER)." EMPLOYEE ALPHALIST (Plantilla)</b></center>
                    </td>
                </tr>
                <tr>
                    <td width=\"100%\" colspan=\"2\" style=\"font-size: 10px;\" class=\"no-border\">
                        <center>as of ".strtoupper(date("d F Y"))."</center>
                    </td>
                </tr>
            </table>
        ";

        $footer = "
            <table cellpading=\"5\" align=\"center\" style=\"font-size: 9px;\">
                <tr>
                    <td width=\"100%\" colspan=\"2\" style=\"font-size: 9px;\" class=\"no-border\">
                        <center>PAGE {PAGENO} TO {nbpg}</center>
                    </td>
                </tr>
            </table>
        ";

        $body = "
            <table cellpadding=\"3\" align=\"center\" class=\"tableContent\">
                <tr>
                    <td width=\"3%\" class=\"borderCon\"><center><b>No.</b></center></td>
                    <td class=\"borderCon\" width=\"25%\"><center><b>Name</b></center></td>
                    <td class=\"borderCon\" width=\"20%\"><center><b>Position</b></center></td>
                    <td width=\"3%\" class=\"borderCon\"><center><b>SG</b></center></td>
                    <td class=\"borderCon\" width=\"18%\"><center><b>Item Number</b></center></td>
                    <td class=\"borderCon\" width=\"13%\"><center><b>Employment<br>Status</b></center></td>
                    <td class=\"borderCon\"><center><b>Date of Orig. Appointment</b></center></td>
                    <td class=\"borderCon\"><center><b>Date of Last Promotion</b></center></td>
                </tr>
        ";

        foreach ($data->data as $key => $value) {
            $i = 1;

            $body.= "
                <tr>
                    <td width=\"3%\" height=\"50\" class=\"borderCon\"></td>
                    <td class=\"borderCon\" valign=\"middle\" style=\"padding-left: 10px;\"><u><b>$key</b></u></td>
                    <td class=\"borderCon\"></td>
                    <td width=\"3%\" class=\"borderCon\"></td>
                    <td class=\"borderCon\"></td>
                    <td class=\"borderCon\"></td>
                    <td class=\"borderCon\"></td>
                    <td class=\"borderCon\"></td>
                </tr>
            ";

            foreach ($value as $vValue) {
                $body.= "
                    <tr>
                        <td width=\"3%\" class=\"borderCon\">$i</td>
                        <td class=\"borderCon\">{$vValue->name}</td>
                        <td class=\"borderCon\">{$vValue->position}</td>
                        <td width=\"3%\" class=\"borderCon\"><center>{$vValue->sg}</center></td>
                        <td class=\"borderCon\">{$vValue->item_number}</td>
                        <td class=\"borderCon\">{$vValue->employmentStatus}</td>
                        <td class=\"borderCon\">{$vValue->dateHired}</td>
                        <td class=\"borderCon\">{$vValue->dateLastPromotion}</td>
                    </tr>
                ";

                $i++;
            }

            $count = $i - 1;

            $body.= "
                <tr>
                    <td colspan=\"6\" height=\"40\" class=\"no-border\" valign=\"middle\" style=\"padding-left: 250px;\"><b>TOTAL : $count</b></td>
                </tr>
            ";
        }

        $body .= "
            </table>
            <table cellpading=\"5\" align=\"center\">
                <tr>
                    <td width=\"100%\" colspan=\"2\" height=\"50\" class=\"no-border\">
                    </td>
                </tr>
                <tr>
                    <td width=\"60%\" style=\"font-size: 11px; padding-left: 40px;\">
                        Prepared by:
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px; padding-left: 40px;\">
                        Certified Correct:
                    </td>
                </tr>
                <tr>
                    <td width=\"60%\"  height=\"50\">

                    </td>
                    <td width=\"40%\"  height=\"50\">

                    </td>
                </tr>
                <tr>
                    <td width=\"60%\" style=\"font-size: 11px;\">
                        <center><b>{$data->prepared}</b></center>
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px;\">
                        <center><b>{$data->supervisor}</b></center>
                    </td>
                </tr>
                <tr>
                    <td width=\"60%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->preparedPosition}</center>
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->supervisorPosition}</center>
                    </td>
                </tr>
            </table>
        ";

        return $this->applyHtmlTemplate("Employee Alphalist - Plantilla", $style, $body, $header, $footer);
    }

    public function jocosea($data){
        $style = "
            body {
                font-family: {$this->BODY_FONT};
            }

            table, td, td {
                margin: 0px 0px;
                border-collapse: collapse;
            }
            table {
                width: 100%;
            }

            .tableName {
                font-size: 9.5px;
            }

            .tableContent {
                font-size: 9px;
                border: 1px solid black;
                width: 100%;
            }
            u {
                text-decoration: none;
                border-bottom: 1px solid black;
            }
            .no-border {
                border: 0px solid black;
            }
            .borderCon {
                border: 1px solid black;
            }

            .border-top {
                border-top: 1x solid black;
            }
            .border-bottom {
                border-bottom: 1px solid black;
            }
            .border-left-right {
                border-left: 1px solid black;
                border-right: 1px solid black;
            }
        ";
       
        $header = "
            <table cellpading=\"5\" style=\"font-size: 10px;\">
                <tr>
                    <td width=\"100%\" colspan=\"2\" style=\"font-size: 11px;\" class=\"no-border\">
                        <b>".Str::upper($this->HEADER)." EMPLOYEE ALPHALIST (JO & COS)</b>
                    </td>
                </tr>
                <tr>
                    <td width=\"100%\" colspan=\"2\" style=\"font-size: 10px;\" class=\"no-border\">
                        AS OF ".strtoupper(date("d-M-Y"))."
                    </td>
                </tr>
            </table>
        ";

        $footer = "
            <table cellpading=\"5\" align=\"center\" style=\"font-size: 10px;\">
                <tr>
                    <td width=\"100%\" colspan=\"2\" style=\"font-size: 8px;\" class=\"no-border\" valign=\"bottom\">
                        PAGE {PAGENO} TO {nbpg}
                    </td>
                </tr>
            </table>
        ";

            
        $body = "
            <table cellpadding=\"5\" align=\"center\" class=\"tableContent\">
                <tr>
                    <td width=\"3%\" class=\"borderCon\"><center><b>NO.</b></center></td>
                    <td width=\"10%\" class=\"borderCon\"><center><b>SURNAME</b></center></td>
                    <td width=\"10%\" class=\"borderCon\"><center><b>FIRST NAME</b></center></td>
                    <td width=\"2%\" class=\"borderCon\"><center><b>M.I</b></center></td>
                    <td width=\"13%\" class=\"borderCon\"><center><b>POSITION</b></center></td>
                    <td width=\"2%\" class=\"borderCon\"><center><b>SEX</b></center></td>
                    <td class=\"borderCon\"><center><b>OFFICE / PROJECT</b></center></td>
                    <td width=\"10%\" class=\"borderCon\"><center><b>REPORTING AT</b></center></td>
                    <td width=\"10%\" class=\"borderCon\"><center><b>ORIGINAL DATE HIRED WITH OTS</b></center></td>
                </tr>
        ";

        $i = 1;
        foreach ($data->data as $value) {
            $body .= "
                <tr>
                    <td width=\"3%\" class=\"borderCon\"><center>$i</center></td>
                    <td class=\"borderCon\"><center>{$value->surname}</center></td>
                    <td class=\"borderCon\"><center>{$value->first_name}</center></td>
                    <td width=\"3%\" class=\"borderCon\"><center>{$value->mi}</center></td>
                    <td class=\"borderCon\"><center>{$value->position}</center></td>
                    <td width=\"5%\" class=\"borderCon\"><center>{$value->sex}</center></td>
                    <td class=\"borderCon\"><center>{$value->office}</center></td>
                    <td class=\"borderCon\"><center>{$value->report_at}</center></td>
                    <td class=\"borderCon\"><center>{$value->dateHired}</center></td>
                </tr>";

            $i++;
        }

        $body .= "
            </table>
            <table cellpading=\"5\" align=\"center\">
                <tr>
                    <td width=\"100%\" colspan=\"2\" height=\"50\" class=\"no-border\">
                    </td>
                </tr>
                <tr>
                    <td width=\"60%\" style=\"font-size: 11px; padding-left: 40px;\">
                        Prepared by:
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px; padding-left: 40px;\">
                        Certified Correct:
                    </td>
                </tr>
                <tr>
                    <td width=\"60%\"  height=\"50\">

                    </td>
                    <td width=\"40%\"  height=\"50\">

                    </td>
                </tr>
                <tr>
                    <td width=\"60%\" style=\"font-size: 11px;\">
                        <center><b>{$data->prepared}</b></center>
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px;\">
                        <center><b>{$data->supervisor}</b></center>
                    </td>
                </tr>
                <tr>
                    <td width=\"60%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->preparedPosition}</center>
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->supervisorPosition}</center>
                    </td>
                </tr>
            </table>
        ";

        return $this->applyHtmlTemplate("Employee Alphalist - JO & COS", $style, $body, $header, $footer);
    }
}
