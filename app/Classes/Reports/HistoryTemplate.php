<?php
namespace App\Classes\Reports;

use App\Classes\Template;
use Illuminate\Support\Str;

class HistoryTemplate
{
    use Template;

    public function sr($data)
    {
        $employee = $data->employee;
        $datas = $data->serviceRecords;

        $styles = "
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
            i {
                font-style: normal;
                font-size: 12px;
                word-spacing: normal;
            }
            .tableName {
                font-size: 9.5px;
            }

            .tableContent {
                font-size: 9px;
            }
            u {
                text-decoration: none;
                border-bottom: 1px solid black;
            }
            .bottom-text {
                font-family: {$this->BODY_FONT};
                font-size: 8px;
                text-align: right;
            }
            .all-border {
                border: 1px solid black;
            }
            .corner-border {
                border-left: 1px solid black;
                border-right: 1px solid black;
            }
            .bottom-border {
                border-bottom: 1px solid black;
            }
            ";

        $header = "
            <table>
                <tr>
                    <td width=\"10%\" style=\"padding-right: 15px;\">
                        <img src=\"" . $this->image("logo.png") . "\" alt=\"logo\" width=\"100\" height=\"100\">
                    </td>
                    <td width=\"90%\">
                        <p>
                            $this->UPPER_HEADER<br>
                            <b>$this->HEADER</b><br>
                            <i>$this->ADDRESS<br>
                            $this->CONTACT_NUMBER</i>
                        </p>
                    </td>
                </tr>
            </table>
            <table cellpadding=\"5\" class=\"tableName\">
                <tr>
                    <td width=\"100%\" colspan=\"5\">
                        <center><b style=\"font-size: 15px;\">SERVICE RECORD</b></center>
                    </td>
                </tr>
                <tr>
                    <td width=\"100%\" height=\"24\" colspan=\"5\"></td>
                </tr>
                <tr>
                    <td width=\"10%\" style=\"padding-left: 20px;\">NAME:</td>
                    <td width=\"18%\"><center><b>{$employee->last_name}</b></center></td>
                    <td width=\"17%\"><center><b>{$employee->first_name}</b></center></td>
                    <td width=\"37%\"><center><b>{$employee->middle_name}</b></center></td>
                    <td width=\"18%\" rowspan=\"2\" style=\"padding-left: 30px; \">(If married woman, <br> give full maiden name)</td>
                </tr>
                <tr>
                    <td width=\"10%\"></td>
                    <td width=\"18%\" style=\"border-top: 2.5px solid black;\"><center>(Surname)</center></td>
                    <td width=\"17%\" style=\"border-top: 2.5px solid black;\"><center>(Given Name)</center></td>
                    <td width=\"37%\" style=\"border-top: 2.5px solid black;\"><center>(Middle Name)</center></td>
                </tr>
                <tr>
                    <td width=\"10%\" style=\"padding-left: 20px; padding-top: 20px;\">BIRTH:</td>
                    <td width=\"18%\" style=\"padding-top: 20px;\"><center>{$employee->birth_date}</center></td>
                    <td width=\"54%\" colspan=\"2\" style=\"padding-top: 20px;\"><center>{$employee->birth_place}</center></td>
                    <td width=\"18%\" rowspan=\"3\" style=\"padding-left: 30px; padding-top:20px; \" valign=\"top\">
                        Data herein should be checked from<br>
                        birth or baptisimal certificate or some<br>
                        reliable document.
                    </td>
                </tr>
                <tr>
                    <td width=\"10%\"></td>
                    <td width=\"18%\" style=\"border-top: 2.5px solid black;\"><center>(Date)</center></td>
                    <td width=\"54%\" colspan=\"2\" style=\"border-top: 2.5px solid black;\"><center>(Place)</center></td>
                </tr>
                <tr>
                    <td width=\"82%\" height=\"24\" colspan=\"4\"></td>
                </tr>
                <tr>
                    <td width=\"100%\" height=\"24\" colspan=\"5\">
                        <p>
                            This is to certify that the employee named herein above actually rendered services in this Office as shown by
                            the Service record below each line of which is supported by <br>
                            appointment and other papers actually issued by this Office and approved by the authorities concerned.
                        </p>
                    </td>
                </tr>
            </table>";

        $body = '';

        $pages = count($datas);
        $i = 1;

        // dd($datas);

        foreach ($datas as $serviceRecords) {
            $body .= "
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <table cellpadding=\"5\" class=\"tableContent\">
                    <tr>
                        <td width=\"20%\" colspan=\"2\" class=\"all-border\"><center>SERVICE<br>Inclusive Dates</center></td>
                        <td width=\"20%\" colspan=\"2\" class=\"all-border\"><center>RECORD OF EMNPLOYMENT</center></td>
                        <td width=\"20%\" colspan=\"3\" class=\"all-border\"><center>OFFICE ENTITY / DIVISION</center></td>
                        <td width=\"10%\" colspan=\"1\" class=\"all-border\"><center>I/V</center></td>
                        <td width=\"20%\" colspan=\"2\" class=\"all-border\"><center>SEPERATION</center></td>
                    </tr>
                    <tr>
                        <td class=\"all-border\" width=\"10%\"><center>From</center></td>
                        <td class=\"all-border\" width=\"10%\"><center>To</center></td>

                        <td class=\"all-border\" width=\"15%\"><center>Designation</center></td>
                        <td class=\"all-border\" width=\"10%\"><center>Status</center></td>

                        <td class=\"all-border\" width=\"12%\"><center>Salary</center></td>
                        <td class=\"all-border\" width=\"12%\"><center>Station/Place<br>of Assignment</center></td>
                        <td class=\"all-border\" width=\"6%\"><center>Branch</center></td>

                        <td class=\"all-border\" width=\"10%\"><center>ABSENT Without Pay</center></td>
                        <td class=\"all-border\" width=\"7.5%\"><center>Date</center></td>
                        <td class=\"all-border\" width=\"7.5%\"><center>Cause</center></td>
                    </tr>
                    <tr>
                        <td style=\"padding-bottom: 15px; padding-top: 0px;\" class=\"corner-border\"><center>(1)</center></td>
                        <td style=\"padding-bottom: 15px; padding-top: 0px;\" class=\"corner-border\"><center>(2)</center></td>

                        <td style=\"padding-bottom: 15px; padding-top: 0px;\" class=\"corner-border\"><center>(3)</center></td>
                        <td style=\"padding-bottom: 15px; padding-top: 0px;\" class=\"corner-border\"><center>(4)</center></td>

                        <td style=\"padding-bottom: 15px; padding-top: 0px;\" class=\"corner-border\"><center>(5)</center></td>
                        <td style=\"padding-bottom: 15px; padding-top: 0px;\" class=\"corner-border\"><center>(6)</center></td>
                        <td style=\"padding-bottom: 15px; padding-top: 0px;\" class=\"corner-border\"><center>(7)</center></td>

                        <td style=\"padding-bottom: 15px; padding-top: 0px;\" class=\"corner-border\"><center>(8)</center></td>
                        <td style=\"padding-bottom: 15px; padding-top: 0px;\" class=\"corner-border\"><center>(9)</center></td>
                        <td style=\"padding-bottom: 15px; padding-top: 0px;\" class=\"corner-border\"><center>(10)</center></td>
                    </tr>
                    
            ";

            foreach ($serviceRecords as $serviceRecord) {
                $serviceRecord->awol_at = $serviceRecord->awol_at == '' ? "None" : $serviceRecord->awol_at;

                if ($serviceRecord->cause != '') {
                    $body .= "
                    <tr>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"><center>{$serviceRecord->date}</center></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"><center>{$serviceRecord->cause}</center></td>
                    </tr>";
                }
                else {
                    $body .= "
                    <tr>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"><center>{$serviceRecord->from}</center></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"><center>{$serviceRecord->to}</center></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"><center>{$serviceRecord->designation}</center></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"><center>{$serviceRecord->status}</center></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"><center>{$serviceRecord->salary}</center>/mo</td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"><center>{$serviceRecord->division}</center></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"><center>{$serviceRecord->awol_at}</center></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"><center>{$serviceRecord->date}</center></td>
                        <td class=\"corner-border\" style=\"padding-top: 5px; padding-bottom: 5px;\"><center>{$serviceRecord->cause}</center></td>
                    </tr>";
                }
            }

            $body .= "</table>";
            if ($pages > $i)
                $body .= "<pagebreak>";

            $i++;
        }


        if (!count($datas))
            $body .= '<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>';
        else
            $body .= "
                <table cellpadding=\"5\" class=\"tableContent\">
                    <tr>
                        <td class=\"corner-border bottom-border\" width=\"10%\"></td>
                        <td class=\"corner-border bottom-border\" width=\"10%\"></td>

                        <td class=\"corner-border bottom-border\" width=\"15%\"></td>
                        <td class=\"corner-border bottom-border\" width=\"10%\"></td>

                        <td class=\"corner-border bottom-border\" width=\"12%\"></td>
                        <td class=\"corner-border bottom-border\" width=\"12%\"></td>
                        <td class=\"corner-border bottom-border\" width=\"6%\"></td>

                        <td class=\"corner-border bottom-border\" width=\"10%\"></td>
                        <td class=\"corner-border bottom-border\" width=\"7.5%\"></td>
                        <td class=\"corner-border bottom-border\" width=\"7.5%\"></td>
                    </tr>
                </table>
            ";
        $body .= "
            <table cellpadding=\"5\" class=\"tableContent\">
                <tr>
                    <td width=\"105%\" colspan=\"10\"><p>Issued in compliance with Executive Order No. 54, dated August 10, 1954,
                    and in accordance with Circular No. 58, dated August 10, 1954 0f the system</p></td>
                </tr>
                <tr>
                    <td width=\"20%\" colspan=\"2\"></td>
                    <td width=\"30%\" colspan=\"3\"></td>
                    <td width=\"55%\" colspan=\"5\"><center>CERTIFIED CORRECT</center></td>
                </tr>
                <tr>
                    <td width=\"20%\" height=\"25\" colspan=\"2\"></td>
                    <td width=\"30%\" colspan=\"3\"></td>
                    <td width=\"55%\" colspan=\"5\"></td>
                </tr>
                <tr>
                    <td width=\"20%\" colspan=\"2\" valign=\"bottom\" style=\"padding-bottom:  0px;\"><center><u>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    " . Str::upper(date("F d, Y")) . "
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    </u></center></td>
                    <td width=\"30%\" colspan=\"3\"></td>
                    <td width=\"55%\" colspan=\"5\" valign=\"bottom\" style=\"padding-bottom:  0px;\"><center><b>{$data->supervisorName}</b></center></td>
                </tr>
                <tr>
                    <td width=\"20%\" colspan=\"2\" valign=\"bottom\" style=\"padding-bottom:  0px;\"><center>Date</center></td>
                    <td width=\"30%\" colspan=\"3\"></td>
                    <td width=\"55%\" colspan=\"5\" valign=\"bottom\" style=\"padding-bottom:  0px;\"><center>{$data->supervisorPosition}, {$data->supervisorDivision}</center></td>
                </tr>
            </table>
        ";

        $footer = "<p class=\"bottom-text\">Page {PAGENO} of {nb}</p>";


        return $this->applyHtmlTemplate("SR - $employee->last_name", $styles, $body, $header, $footer);
    }

    public function mu($data)
    {

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
                border: 1.5px solid black;
            }
            u {
                text-decoration: none;
                border-bottom: 1px solid black;
            }
            .no-border {
                border: 0px solid black;
            }
            .borderCon {
                border: 1.5px solid black;
            }
            .borderBody {
                border: .5px solid black;
            }

            .border-top {
                border-top: 1.5px solid black;
            }
            .border-bottom {
                border-bottom: 1.5px solid black;
            }
            .border-left-right {
                border-left: 1.5px solid black;
                border-right: 1.5px solid black;
            }
        ";

        $body = "
            <table cellpading=\"5\" align=\"center\" style=\"font-size: 10px;\">
                <tr>
                    <td width=\"100%\" colspan=\"2\" class=\"no-border\">
                        <center>{$this->UPPER_HEADER}</center>
                    </td>
                </tr>
                <tr>
                    <td width=\"100%\" colspan=\"2\" style=\"font-size: 11px;\" class=\"no-border\">
                        <center><b>{$this->HEADER}</b></center>
                    </td>
                </tr>
                <tr>
                    <td width=\"100%\" colspan=\"2\" style=\"font-size: 10px;\" class=\"no-border\">
                        <center>{$this->ADDRESS}</center>
                    </td>
                </tr>
                <tr>
                    <td width=\"100%\" colspan=\"2\" height=\"30\" class=\"no-border\">
                    </td>
                </tr>
                <tr>
                    <td width=\"100%\" colspan=\"2\" style=\"font-size: 11px;\" class=\"no-border\">
                        <center style=\"line-height: 1.6;\">Manpower Updates<br>
                        As of<br>" . strtoupper(date("d-M-Y")) . "<br>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td width=\"100%\" colspan=\"2\" height=\"30\" class=\"no-border\">
                    </td>
                </tr>
            </table>
        ";

        $body .= "
            <table cellpadding=\"3\" align=\"center\" class=\"tableContent\">
                <tr>
                    <td rowspan=\"3\" width=\"25%\" class=\"borderCon\"></td>

                    <td colspan=\"1\" class=\"borderCon\" style=\"font-size: 6px;\"><center><b>PRESIDENTIAL APOINTEE</b></center></td>

                    <td colspan=\"3\" class=\"borderCon\" style=\"font-size: 6px;\"><center><b>PERMANENT</b></center></td>

                    <td colspan=\"1\" class=\"borderCon\" style=\"font-size: 6px;\"><center><b>CO-TERMINUS WITH THE APPOINTING AUTHORITY</b></center></td>
                    <td colspan=\"1\" class=\"borderCon\" style=\"font-size: 6px;\"><center><b>CO-TERMINUS WITH THE INCUMBENT</b></center></td>


                    <td colspan=\"2\" class=\"borderCon\" style=\"font-size: 6px;\"><center><b>PROBATIONARY</b></center></td>
                    <td colspan=\"2\" class=\"borderCon\" style=\"font-size: 6px;\"><center><b>TEMPORARY</b></center></td>

                    <td colspan=\"1\" class=\"borderCon\" style=\"font-size: 6px;\"><center><b>TECHNICAL ASSISTANT / CONSULTANT</b></center></td>
                    <td colspan=\"1\" class=\"borderCon\" style=\"font-size: 6px;\"><center><b>JOB ORDER</b></center></td>

                    <td colspan=\"2\" class=\"borderCon\" style=\"font-size: 6px;\"><center><b>CONTRACTUAL</b></center></td>
                    <td colspan=\"2\" class=\"borderCon\" style=\"font-size: 6px;\"><center><b>CASUAL</b></center></td>
                </tr>
                <tr>
                    <td colspan=\"16\" class=\"borderCon\"><center><b>L E V E L &nbsp; O F &nbsp; P O S I T I O N S</b></center></td>
                </tr>
                <tr>
                    <td class=\"borderCon\"><center></center></td>

                    <td class=\"borderCon\"><center><b>1st</b></center></td>
                    <td class=\"borderCon\"><center><b>2nd</b></center></td>
                    <td class=\"borderCon\"><center><b>3rd</b></center></td>

                    <td class=\"borderCon\"><center></center></td>
                    <td class=\"borderCon\"><center></center></td>


                    <td class=\"borderCon\"><center><b>1st</b></center></td>
                    <td class=\"borderCon\"><center><b>2nd</b></center></td>

                    <td class=\"borderCon\"><center><b>1st</b></center></td>
                    <td class=\"borderCon\"><center><b>2nd</b></center></td>

                    <td class=\"borderCon\"><center></center></td>
                    <td class=\"borderCon\"><center></center></td>

                    <td class=\"borderCon\"><center><b>1st</b></center></td>
                    <td class=\"borderCon\"><center><b>2nd</b></center></td>

                    <td class=\"borderCon\"><center><b>1st</b></center></td>
                    <td class=\"borderCon\"><center><b>2nd</b></center></td>
                </tr>";
        foreach ($data->data as $key => $value) {
            $body .= "<tr>";
            $body .= "<td class=\"borderCon\">" . Str::upper($key) . "</td>";
            foreach ($value as $number) {
                if ($number != 0)
                    $body .= "<td class=\"borderBody\"><center>$number</center></td>";
                else
                    $body .= "<td class=\"borderBody\"><center></center></td>";
            }

            $body .= "</tr>";
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
                    <td width=\"60%\"  height=\"50\"></td>
                    <td width=\"40%\"  height=\"50\"></td>
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
            </table>";

        return $this->applyHtmlTemplate("Manpower Updates", $style, $body);
    }

    public function mc($data)
    {
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
                font-size: 11px;
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
            th.rotate > div {
                transform:
                translate(25px, 51px);
                rotate(270deg);
            }
        ";

        $header = "
            <table cellpading=\"5\" style=\"font-size: 10px;\">
                <tr>
                    <td width=\"100%\" colspan=\"1\" style=\"font-size: 11px;\" class=\"no-border\">
                        <b>MANPOWER COMPLEMENT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As of " . date("F Y") . "</b>
                    </td>
                </tr>
                <tr>
                    <td width=\"100%\" colspan=\"1\" style=\"font-size: 11px;\" class=\"no-border\">
                    Name of Agency: <b><u>{$this->HEADER}</u></b>
                    </td>
                </tr>
                <tr>
                    <td width=\"100%\" colspan=\"1\" style=\"font-size: 11px;\" class=\"no-border\">
                    REGION/AREA/DISTRICT: &nbsp;&nbsp;&nbsp; <b>{$this->ADDRESS}</b>
                    </td>
                </tr>
            </table>
        ";

        $body = "
            <table cellpadding=\"2\" align=\"center\" class=\"tableContent\">
                <tr>
                    <td width=\"100%\" colspan=\"23\" class=\"borderCon\"><center><b>N U M B E R  &nbsp;O F&nbsp; P E R S O N N E L</b></center></td>
                </tr>
                <tr>
                    <td width=\"3%\" rowspan=\"15\" colspan=\"1\" class=\"borderCon\" style=\"font-size: 10px;\"><center><b>P<br>E<br>R<br>S<br>O<br>N<br>N<br>E<br>L<br><br>C<br>O<br>M<br>P<br>L<br>E<br>M<br>E<br>N<br>T</b></center></td>
                    <td width=\"30%\" height=\"20\" rowspan=\"2\" colspan=\"1\" class=\"borderCon\"  style=\"vertical-align: top;\"><center><b>Level/Classification of Positions</b></center></td>
                    <td width=\"8%\" height=\"10\" colspan=\"2\" class=\"borderCon\"><center><b>Non-Uniformed</b></center></td>
                    <td width=\"8%\" height=\"10\" colspan=\"2\" class=\"borderCon\"><center><b>Uniformed (For PCG)</b></center></td>
                    <td width=\"3%\" rowspan=\"15\" colspan=\"1\" class=\"borderCon\" style=\"font-size: 10px;\"><center><b>P<br>E<br>R<br>S<br>O<br>N<br>N<br>E<br>L<br><br>M<br>O<br>V<br>E<br>M<br>E<br>N<br>T</b></center></td>
                    <td width=\"8%\" height=\"10\" colspan=\"2\" class=\"borderCon\"><center><b>Promoted</b></center></td>
                    <td width=\"8%\" height=\"10\" colspan=\"2\" class=\"borderCon\"><center><b>Detailed</b></center></td>
                    <td width=\"8%\" height=\"10\" colspan=\"2\" class=\"borderCon\"><center><b>Secondment</b></center></td>
                    <td width=\"8%\" height=\"10\" colspan=\"2\" class=\"borderCon\"><center><b>Transferred</b></center></td>
                    <td width=\"8%\" height=\"10\" colspan=\"2\" class=\"borderCon\"><center><b>Retired</b></center></td>
                    <td width=\"8%\" height=\"10\" colspan=\"2\" class=\"borderCon\"><center><b>Resigned</b></center></td>
                    <td width=\"8%\" height=\"10\" colspan=\"2\" class=\"borderCon\"><center><b>Drop from<br>the Rolls</b></center></td>
                    <td width=\"8%\" height=\"10\" colspan=\"2\" class=\"borderCon\"><center><b>Terminated</b></center></td>

                </tr>
                <tr>
                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Male</center></td>
                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Female</center></td>

                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Male</center></td>
                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Female</center></td>

                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Male</center></td>
                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Female</center></td>

                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Male</center></td>
                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Female</center></td>

                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Male</center></td>
                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Female</center></td>

                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Male</center></td>
                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Female</center></td>

                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Male</center></td>
                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Female</center></td>

                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Male</center></td>
                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Female</center></td>

                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Male</center></td>
                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Female</center></td>

                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Male</center></td>
                    <td width=\"4%\" height=\"10\" colspan=\"1\" class=\"borderCon\"><center>Female</center></td>
                </tr>

                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <b>A. CAREER POSITIONS</b><br>
                        <b style=\"font-size: 10px\"> First Level</b><br>
                        <i style=\"font-size: 10px\"> &nbsp; clerical, trades, crafts and custodial service positions</i>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '1st'}->{ 'non-uniformed'}->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '1st'}->{ 'non-uniformed'}->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '1st'}->uniformed->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '1st'}->uniformed->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>
                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <b style=\"font-size: 10px\"> Second Level</b><br>
                        <i style=\"font-size: 10px\"> &nbsp; professional, technical  and scientific positions</i>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '2nd'}->{ 'non-uniformed'}->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '2nd'}->{ 'non-uniformed'}->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '2nd'}->uniformed->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '2nd'}->uniformed->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>
                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <b style=\"font-size: 10px\"> Third Level</b><br>
                        <i style=\"font-size: 10px\"> &nbsp; positions in Careeer Executive Service</i>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '3rd'}->{ 'non-uniformed'}->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '3rd'}->{ 'non-uniformed'}->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '3rd'}->uniformed->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ '3rd'}->uniformed->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>
                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <p style=\"font-size: 10px\"> Non-Executive Positions</p>
                        <i style=\"font-size: 10px\"> &nbsp; career positions excluded from the CES with salary 25 and above (e.g.
                        Scientists, Professors, Foreign Service Officers, Member of the
                        Judiciary and Prosecution Service); third level positions in the LGUs
                        </i>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>
                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <b>A. NON-CAREER POSITIONS</b><br>
                        <b style=\"font-size: 10px\"> Coterminus</b><br>
                        <i style=\"font-size: 10px\"> &nbsp; positions that are subject to the appointing authority's pleasure,
                        co-existent with the tenure, or limited by the duration of the project or subject to the availability of the funds</i>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->coterminus->{ 'non-uniformed'}->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->coterminus->{ 'non-uniformed'}->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->coterminus->uniformed->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->coterminus->uniformed->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>
                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <b style=\"font-size: 10px\"> Casual</b><br>
                        <i style=\"font-size: 10px\"> &nbsp; emergency or seasonal positions submitted to CSC for approval</i>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->casual->{ 'non-uniformed'}->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->casual->{ 'non-uniformed'}->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->casual->uniformed->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->casual->uniformed->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>
                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <b style=\"font-size: 10px\"> Contractual</b><br>
                        <i style=\"font-size: 10px\"> &nbsp; positions with special contracts to undertake a specific work of
                        job are submitted to CSC for approval </i>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->contractual->{ 'non-uniformed'}->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->contractual->{ 'non-uniformed'}->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->contractual->uniformed->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->contractual->uniformed->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>
                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <b style=\"font-size: 10px\"> Elective</b><br>
                        <i style=\"font-size: 10px\"> &nbsp; selected positions in the Local Government Units excluding Barangay Chairman and Councilors </i>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>

                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <b style=\"font-size: 10px\"> Non-Career Executive</b><br>
                        <i style=\"font-size: 10px\"> &nbsp; Secretaries/Officials of cabinet rank who hold their positions
                        at the pleasure of the President; supervisory and executive positions with fixed terms and in office
                        (e.g. Chairman and Member of Commissions and Boards) </i>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->presidential->{ 'non-uniformed'}->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->presidential->{ 'non-uniformed'}->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->presidential->uniformed->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->presidential->uniformed->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>
                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <center><b style=\"font-size: 11px\">SUB TOTAL (Career + Non-Career)</b><br></center>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ 'sub-total'}->{ 'non-uniformed'}->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ 'sub-total'}->{ 'non-uniformed'}->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ 'sub-total'}->uniformed->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->{ 'sub-total'}->uniformed->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>

                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <b>C. CONTRACT OF SERVICE inclusing Consultancy</b>
                        <i style=\"font-size: 10px\"> Secretaries/Officials of cabinet rank who hold their positions
                        at the pleasure of the President; supervisory and executive positions with fixed terms and in office
                        (e.g. Chairman and Member of Commissions and Boards) </i>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->cos->{ 'non-uniformed'}->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->cos->{ 'non-uniformed'}->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->cos->uniformed->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->cos->uniformed->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>

                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <b>D. JOB ORDERS</b>
                        <i style=\"font-size: 10px\"> hiring of workers for piece of work or intermittent job or short
                        duration not exceeding six months and pay is on a daily or hourly basis </i>
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->jo->{ 'non-uniformed'}->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->jo->{ 'non-uniformed'}->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->jo->uniformed->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->jo->uniformed->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>

                <tr>
                    <td width=\"24%\" colspan=\"1\" class=\"borderCon\" style=\"text-align: left; vertical-align: top;\">
                        <b>GRAND TOTAL </b>(Career + Non-Career + COS  + JO)
                    </td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->total->{ 'non-uniformed'}->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->total->{ 'non-uniformed'}->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->total->uniformed->male}</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>{$data->total->uniformed->female}</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>

                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                    <td width=\"4%\" colspan=\"1\" class=\"borderCon\"><center>0</center></td>
                </tr>
            </table>

            <br>

            <table cellpading=\"5\" align=\"center\">
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
                        <center>{$data->preparedPosition}, {$data->preparedDivision}</center>
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->supervisorPosition}, {$data->supervisorDivision}</center>
                    </td>
                </tr>
            </table>
        ";

        return $this->applyHtmlTemplate("Manpower Complement", $style, $body, $header);
    }

    public function ss($data)
    {
        $style = "
            body {
                font-family: {$this->BODY_FONT};
            }

            table, td, td {
                margin: 0px 0px;
                border-collapse: collapse;
            }

            table {
                width: 90%;
                text-align: center;
                margin-left:auto;
                margin-right:auto;
            }

            td {
                border: 1px solid black;
                font-size: 12px;
                padding: 5px 5px;
            }

            td.noBorder {
                border: 0px solid black;
            }

            td.textLeft {
                text-align: left;
            }

            td.textRight {
                text-align: right;
            }

            td.fill {
                background-color: black;
            }

        ";

        $body = "
            <div>
                <table>
                    <tr>
                        <td colspan=\"4\" style=\"font-size: 14px;\">
                            <b>
                                {$this->HEADER}<br>
                                STATISTICAL SUMMARY<br>
                                As of " . date('F d, Y') . "
                            </b>
                        </td>
                    </tr>
                    <tr>
                        <td width=\"40%\" class=\"textLeft\"></td>
                        <td width=\"20%\"><b>AUTHORIZED</b></td>
                        <td width=\"20%\"><b>FILLED</b></td>
                        <td width=\"20%\"><b>VACANT</b></td>
                    </tr>";

        foreach ($data->data as $fundingSource => $column) {

            foreach ($column as $employmentStatus => $subColumn) {

                foreach ($subColumn->data as $position => $stats) {
                    $body .= "
                        <tr>
                            <td width=\"40%\" class=\"textLeft\">$employmentStatus $position</td>
                            <td width=\"20%\">{$stats->authorized}</td>
                            <td width=\"20%\">{$stats->filled}</td>
                            <td width=\"20%\">{$stats->vacant}</td>
                        </tr>
                    ";
                }

                $body .= "
                    <tr>
                        <td width=\"40%\" class=\"textRight\"><b>Sub Total $employmentStatus</b></td>
                        <td width=\"20%\"><b>{$subColumn->total->authorized}</b></td>
                        <td width=\"20%\"><b>{$subColumn->total->filled}</b></td>
                        <td width=\"20%\"><b>{$subColumn->total->vacant}</b></td>
                    </tr>
                ";
            }

            $body .= "
                    <tr>
                        <td colspan=\"4\" height=\"20\" class=\"fill\"></td>
                    </tr>
            ";
        }
        $body .= "
                    <tr>
                        <td width=\"40%\" class=\"textRight\"><b>Grand Total</b></td>
                        <td width=\"20%\"><b>{$data->total->authorized}</b></td>
                        <td width=\"20%\"><b>{$data->total->filled}</b></td>
                        <td width=\"20%\"><b>{$data->total->vacant}</b></td>
                    </tr>

                </table>
            </div>
        ";

        $body .= "<table cellpading=\"5\" align=\"center\" style=\"width: 70%;\">
            <tr>
                <td class=\"noBorder\" width=\"100%\" colspan=\"2\" height=\"50\">
                </td>
            </tr>
            <tr>
                <td class=\"noBorder\" width=\"50%\" style=\"font-size: 11px; padding-left: 40px; text-align: left;\">
                    Prepared by:
                </td>
                <td class=\"noBorder\" width=\"50%\" style=\"font-size: 11px; padding-left: 40px; text-align: left;\">
                    Certified Correct:
                </td>
            </tr>
            <tr>
                <td class=\"noBorder\" width=\"50%\"  height=\"50\">

                </td>
                <td class=\"noBorder\" width=\"50%\"  height=\"50\">

                </td>
            </tr>
            <tr>
                <td class=\"noBorder\" width=\"50%\" style=\"font-size: 11px;\">
                    <center><b>{$data->prepared}</b></center>
                </td>
                <td class=\"noBorder\" width=\"50%\" style=\"font-size: 11px;\">
                    <center><b>{$data->supervisor}</b></center>
                </td>
            </tr>
            <tr>
                <td class=\"noBorder\" width=\"50%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                    <center>{$data->preparedPosition}</center>
                </td>
                <td class=\"noBorder\" width=\"50%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                    <center>{$data->supervisorPosition}</center>
                </td>
            </tr>
            <tr>
                <td class=\"noBorder\" width=\"50%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                    <center>{$data->preparedDivision}</center>
                </td>
                <td class=\"noBorder\" width=\"50%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                    <center>{$data->supervisorDivision}</center>
                </td>
            </tr>
        </table>
            
        ";


        return $this->applyHtmlTemplate("Statistical Summary", $style, $body);
    }
}