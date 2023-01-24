<?php
namespace App\Classes\Reports;

use App\Classes\Template;

class TimeKeepingTemplate
{
    use Template;

    public function dtr($data)
    {
        $style = "
            body {
                font-family: {$this->BODY_FONT};
                font-size: 12px;
            }
            table, td, tr {
                margin: 0px 0px;
                border-collapse: collapse;
            }
            table {
                width: 100%;
            }
            td {
                font-family: Arial, Helvetica, sans-serif;
            }

            .allBorder {
                border: 1px solid black;
            }

            .leftBorder {
                border-left: 1px solid black;
            }

            .topBorder {
                border-top: 1px solid black;
            }

            .rightBorder {
                border-right: 1px solid black;
            }

            .bottomBorder {
                border-bottom: 1px solid black;
            }
            .field {
                font-weight: bold;
            }
        ";

        $body = <<<HTML
            <table>
                <!-- 15 -->
                <tr>
                    <td width="5.43%"></td><!-- A -->
                    <td width="6.57%"></td><!-- B -->
                    <td width="6%"></td><!-- C -->
                    <td width="6.43%"></td><!-- D -->
                    <td width="6%"></td><!-- E -->
                    <td width="5.29%"></td><!-- F -->
                    <td width="5.57%"></td><!-- G -->
                    <td width="2%"></td><!-- H -->
                    <td width="4.86%"></td><!-- I -->
                    <td width="7.86%"></td><!-- J -->
                    <td width="6%"></td><!-- K -->
                    <td width="6.43%"></td><!-- L -->
                    <td width="6%"></td><!-- M -->
                    <td width="5.29%"></td><!-- N -->
                    <td width="6.71%"></td><!-- O -->
                </tr>
                <tr>
                    <td height="12.75" colspan=3>CIVIL SERVICE FORM NO.48</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan=3>CIVIL SERVICE FORM NO.48</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td height="12.75" style="font-size: 14px;" colspan=4><b>DAILY TIME RECORD</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="font-size: 14px;" colspan=3><b>DAILY TIME RECORD</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td height="12.75" colspan="15"></td>
                </tr>
                <tr>
                    <td height="15">NAME:</td>
                    <td class="bottomBorder" colspan="6" style="font-size: 16px; text-align: center;"><b>{$data->employee->name}</b></td>
                    <td></td>
                    <td>NAME:</td>
                    <td class="bottomBorder" colspan="6" style="font-size: 16px; text-align: center;"><b>{$data->employee->name}</b></td>
                </tr>
                <tr>
                    <td colspan="2" height="15">For the month of:</td>
                    <td class="bottomBorder" colspan="5" style="font-size: 16px; text-align: center;">{$data->employee->forMonth}</td>
                    <td></td>
                    <td colspan="2">For the month of:</td>
                    <td class="bottomBorder" colspan="5" style="font-size: 16px; text-align: center;">{$data->employee->forMonth}</td>
                </tr>
                <tr>
                    <td colspan="4" height="15">Official hours of Arrival (Reg. Days):</td>
                    <td class="bottomBorder" colspan="3" style="font-size: 16px; text-align: center;"></td>
                    <td></td>
                    <td colspan="4">Official hours of Arrival (Reg. Days):</td>
                    <td class="bottomBorder" colspan="3" style="font-size: 16px; text-align: center;"></td>
                </tr>
                <tr>
                    <td colspan="2" height="15">Saturdays:</td>
                    <td class="bottomBorder" colspan="5" style="font-size: 16px; text-align: center;"></td>
                    <td></td>
                    <td colspan="2">Saturdays:</td>
                    <td class="bottomBorder" colspan="5" style="font-size: 16px; text-align: center;"></td>
                </tr>
                <tr>
                    <td height="25.5" colspan="15"></td>
                </tr>
                <tr>
                    <td class="allBorder" rowspan="2" style="text-align: center; vertical-align: middle;">DAYS</td>
                    <td class="allBorder" height="12.75" colspan="2" style="text-align: center; vertical-align:middle;"><b>AM</b></td>
                    <td class="allBorder" colspan="2" style="text-align: center; vertical-align:middle;"><b>PM</b></td>
                    <td class="allBorder" colspan="2" style="text-align: center; vertical-align:middle;"><b>Undertime</b></td>
                    <td></td>
                    <td class="allBorder" rowspan="2" style="text-align: center; vertical-align: middle;">DAYS</td>
                    <td class="allBorder" colspan="2" style="text-align: center; vertical-align:middle;"><b>AM</b></td>
                    <td class="allBorder" colspan="2" style="text-align: center; vertical-align:middle;"><b>PM</b></td>
                    <td class="allBorder" colspan="2" style="text-align: center; vertical-align:middle;"><b>Undertime</b></td>
                </tr>
                <tr>
                    <td class="allBorder" height="12.75" style="text-align: center; vertical-align:middle;">IN</td>
                    <td class="allBorder" style="text-align: center; vertical-align:middle;">OUT</td>
                    <td class="allBorder" style="text-align: center; vertical-align:middle;">IN</td>
                    <td class="allBorder" style="text-align: center; vertical-align:middle;">OUT</td>
                    <td class="allBorder" style="text-align: center; vertical-align:middle;">HRS</td>
                    <td class="allBorder" style="text-align: center; vertical-align:middle;">MIN</td>
                    <td></td>
                    <td class="allBorder" style="text-align: center; vertical-align:middle;">IN</td>
                    <td class="allBorder" style="text-align: center; vertical-align:middle;">OUT</td>
                    <td class="allBorder" style="text-align: center; vertical-align:middle;">IN</td>
                    <td class="allBorder" style="text-align: center; vertical-align:middle;">OUT</td>
                    <td class="allBorder" style="text-align: center; vertical-align:middle;">HRS</td>
                    <td class="allBorder" style="text-align: center; vertical-align:middle;">MIN</td>
                </tr>
        HTML;

        foreach ($data->dtr as $dtr) {
            if ($dtr->remark)
                $body .= <<<HTML
                    <tr>
                        <td class="allBorder" height="12.75" style="text-align: center; vertical-align: middle;">{$dtr->date}</td>
                        <td class="allBorder" colspan="6" style="text-align: center; vertical-align: middle;">{$dtr->remark}</td>
                        <td></td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->date}</td>
                        <td class="allBorder" colspan="6" style="text-align: center; vertical-align: middle;">{$dtr->remark}</td>
                    </tr>
                HTML;
            else
                $body .= <<<HTML
                    <tr>
                        <td class="allBorder" height="12.75" style="text-align: center; vertical-align: middle;">{$dtr->date}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->am_in}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->am_out}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->pm_in}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->pm_out}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->ut_hrs}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->ut_min}</td>
                        <td></td>
                        <td class="allBorder" height="12.75" style="text-align: center; vertical-align: middle;">{$dtr->date}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->am_in}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->am_out}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->pm_in}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->pm_out}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->ut_hrs}</td>
                        <td class="allBorder" style="text-align: center; vertical-align: middle;">{$dtr->ut_min}</td>
                    </tr>
                HTML;
        }

        $body .= <<<HTML
                <tr>
                    <td height="12.75" style="text-align: right;" colspan="4">Total Undertime:</td>
                    <td></td>
                    <td  colspan="2" class="bottomBorder">{$data->totalUndertime}</td>
                    <td></td>
                    <td style="text-align: right;" colspan="4">Total Undertime:</td>
                    <td></td>
                    <td  colspan="2" class="bottomBorder">{$data->totalUndertime}</td>
                </tr>
                <tr>
                    <td height="12.75" colspan="15"></td>
                </tr>
                <tr>
                    <td height="51" colspan="7">
                        <p style="font-size: 12px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I CERTIFY in my honor that the above is true and correct report of the hours of work performed, records of which was made daily at a time of arrival to and departure from the office.
                        </p>
                    </td>
                    <td></td>
                    <td height="51" colspan="7">
                        <p style="font-size: 12px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;I CERTIFY in my honor that the above is true and correct report of the hours of work performed, records of which was made daily at a time of arrival to and departure from the office.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td height="25.5" colspan="15"></td>
                </tr>
                <tr>
                    <td height="12.75"></td>
                    <td colspan="5" class="topBorder" style="text-align: center; vertical-align:middle;">Signature of Employee</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="5" class="topBorder" style="text-align: center; vertical-align:middle;">Signature of Employee</td>
                    <td></td>
                </tr>
                <tr>
                    <td height="25.5" colspan="15"></td>
                </tr>
                <tr>
                    <td height="12.75" colspan="7" style="text-align: center; vertical-align:middle;">Verified as to prescribed office hours.</td>
                    <td></td>
                    <td colspan="7" style="text-align: center; vertical-align:middle;">Verified as to prescribed office hours.</td>
                </tr>
                <tr>
                    <td height="40" colspan="15"></td>
                </tr>
                <tr>
                    <td height="12.75"></td>
                    <td colspan="5" class="topBorder" style="text-align: center; vertical-align:middle;">
                    <p style="font-size: 16px;">
                        <b>{$data->supervisor}</b><br>
                    </p>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan="5" class="topBorder" style="text-align: center; vertical-align:middle;">
                    <p style="font-size: 16px;">
                        <b>{$data->supervisor}</b><br>
                    </p>
                    </td>
                    <td></td>
                </tr>
            </table>
        HTML;

        return $this->applyHtmlTemplate("DTR - {$data->employee->emp_number}", $style, $body);
    }

    public function ts($data)
    {
        // dd($data);
        $style = "
            body {
                font-family: {$this->BODY_FONT};
                width: 100%;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
        ";

        $header = "
            <div style=\"text-align: center;\">
                <p>
                    <span style=\"font-size: 12px;\"><b>SUMMARY OF EMPLOYEE'S TARDINESS</b></span><br>
                    <span>{$data->date->from} - {$data->date->to}</span><br>
                    <span><b><u>{$data->placeOfWork}</u></b></span>
                </p>
            </div>
        ";

        $footer = "
            <div style=\"text-align: center; font-size: 8px;\">
                PAGE {PAGENO} TO {nbpg}
            </div>

        ";

        $body = "
            <br><br><br><br>

            <table>
                <thead>
                    <tr>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 4%; font-size: 11px; \">NO.</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 10%; font-size: 11px; \">I.D. NO.</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 20%; font-size: 11px; \">EMPLOYEE NAME</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 9%; font-size: 11px; \">DATE</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 15%; font-size: 11px; \">SCHEDULE</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 12%; font-size: 11px; \">ARRIVAL</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 13%; font-size: 11px; \">DEPARTURE</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 10%; font-size: 11px; \">LATE</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 10%; font-size: 11px; \">UNDERTIME</th>
                    </tr>
                </thead>
                <tbody>";

        $i = 1;
        foreach ($data->items as $item) {
            $body .= "
                        <tr>
                            <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$i}</td>
                            <td style=\"padding-left: 5px; padding-right: 5px; text-align: left; border: 1px solid black; font-size: 11px;\">{$item->employeeNumber}</td>
                            <td style=\"padding-left: 5px; padding-right: 5px; text-align: left; border: 1px solid black; font-size: 11px;\">{$item->fullName}</td>
                            <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->date}</td>
                            <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->schedule}</td>
                            <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->arrival}</td>
                            <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->departure}</td>
                            <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->late}</td>
                            <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->ut}</td>
                        </tr>";

            $i += 1;

        }

        $body .= "
                </tbody>
            </table>
            
            <br><br><br>
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
                        <center>{$data->preparedPosition}</center>
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->supervisorPosition}</center>
                    </td>
                </tr>
            </table>
        ";

        return $this->applyHtmlTemplate("Employee Tardiness Summary", $style, $body, $header, $footer);
    }

    public function bs($data)
    {
        $style = "
            body {
                font-family: {$this->BODY_FONT};
                width: 100%;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
        ";

        $header = "
            <div style=\"text-align: center;\">
                <p>
                    <span style=\"font-size: 14px;\"><b>LOG IN AND LOG-OUT SUMMARY</b></span><br>
                    <span><b>SECTION/DIVISION: </b><u>{$data->division}</u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>SERVICE/OFFICE: </b><u>{$data->placeOfWork}</u>
                    </span><br>
                    <span><b><u>{$data->date->from} - {$data->date->to}</u></b></span>
                </p>
            </div>
        ";

        $footer = "
            <div style=\"text-align: center; font-size: 8px;\">
                PAGE {PAGENO} TO {nbpg}
            </div>
        ";

        $body = "
            <table>
                <thead>
                    <tr>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 1%; font-size: 11px; \">NO.</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 23%; font-size: 11px; \">EMPLOYEE NAME</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 12%; font-size: 11px; \">REFERENCE DATE</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 12%; font-size: 11px; \">POST DATE</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 12%; font-size: 11px; \">TYPE</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 12%; font-size: 11px; \">NAME</th>
                    </tr>
                </thead>
                <tbody>";

        $i = 1;
        foreach ($data->items as $name => $item) {
            $body .= "
                    <tr>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 4%; font-size: 11px; background-color: #999DA0;\">$i</td>
                        <td colspan=5 style=\"text-align: left; border: 1px solid black; padding-top: 5px; padding-left: 5px; padding-bottom: 5px; width: 20%; font-size: 11px; background-color: #999DA0;\">$name</td>
                    </tr>
                ";

            foreach ($item as $column) {
                $col = (object)$column;

                $body .= "
                        <tr>
                            <td colspan=2 style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 4%; font-size: 11px;\"></td>
                            <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 20%; font-size: 11px;\">{$col->ref_date}</td>
                            <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 20%; font-size: 11px;\">{$col->post_date}</td>
                            <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 20%; font-size: 11px;\">{$col->type}</td>
                            <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 20%; font-size: 11px;\">{$col->name}</td>
                        </tr>
                    ";
            }

            $i += 1;
        }

        $body .= "
                </tbody>
            </table>
            
            <br><br><br><br><br><br><br>
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
                        <center>{$data->preparedPosition}</center>
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->supervisorPosition}</center>
                    </td>
                </tr>
            </table>
        ";

        return $this->applyHtmlTemplate("Log-in and Log-out Summary", $style, $body, $header, $footer);
    }

    public function ma($data)
    {
        $style = "
            body {
                font-family: {$this->BODY_FONT};
                width: 100%;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
        ";

        $header = "
            <div style=\"text-align: center;\">
                <p>
                    <span style=\"font-size: 14px;\"><b>MONTHLY ATTENDANCE REPORT</b></span><br>
                    <span><b>SECTION/DIVISION: </b><u>{$data->division}</u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <b>SERVICE/OFFICE: </b><u>{$data->placeOfWork}</u>
                    </span><br>
                    <span><b>MONTH OF: </b> <u>{$data->date->from} - {$data->date->to}</u></span>
                </p>
            </div>
        ";

        $footer = "
            <div style=\"text-align: center; font-size: 8px;\">
                PAGE {PAGENO} TO {nbpg}
            </div>
        ";

        $body = "
            <br><br><br><br><br>

            <table>
                <thead>
                    <tr>
                        <th rowspan=2 style=\"text-align: left; border: 1px solid black; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; width: 13%; font-size: 8px; \">Name</th>";

        foreach ($data->date->datesDays as $col) {
            $body .= " <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 6px; width: 1%;\">$col</th>";
        }

        $body .= "
                        <th rowspan=2 style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px; width: 5%;\">Leaves This Month</th>
                        <th rowspan=2 style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px; width: 5%;\">No. of Absences</th>
                        <th rowspan=2 style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px; width: 5%;\">No. of Days Present</th>
                        <th colspan=10 style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px; width: 20%;\">Summary</th>
                    </tr>
                    <tr>";

        foreach ($data->date->wordDays as $col) {
            $body .= " <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 6px; width: 2%;\">$col</th>";
        }

        $body .= "
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 7px;\">S</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 7px;\">V</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 7px;\">ML</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 7px;\">PL</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 7px;\">SPL</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 7px;\">M</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 7px;\">P</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 7px;\">O</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 7px;\">A</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 7px;\">OB</th>
                    </tr>
                   
                </thead>
                <tbody>";

        foreach ($data->items as $name => $item) {
            $body .= "
                    <tr>
                        <td style=\"text-align: left; border: 1px solid black; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; font-size: 8px; \">$name</td>
                ";

            foreach ($item->items as $col) {
                $body .= " 
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 6px;\">$col</td>
                    ";
            }

            $body .= "
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->leaves}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->absences}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->present}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->status->S}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->status->V}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->status->ML}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->status->PL}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->status->SPL}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->status->M}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->status->P}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->status->O}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->status->A}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 7px;\">{$item->status->OB}</td>
                    </tr>
                ";
        }

        $body .= "
                </tbody>
            </table>
            
            <br><br><br>
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
                        <center>{$data->preparedPosition}</center>
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->supervisorPosition}</center>
                    </td>
                </tr>
            </table>
        ";

        return $this->applyHtmlTemplate("Monthly Attendance Report", $style, $body, $header, $footer);
    }

    public function ea($data)
    {
        $style = "
            body {
                font-family: {$this->BODY_FONT};
                width: 100%;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
        ";

        $header = "
            <div style=\"text-align: center;\">
                <p>
                    <span style=\"font-size: 14px;\"><b>SUMMARY OF EMPLOYEE'S ABSENCES</b></span><br>
                    <span>{$data->date->from} - {$data->date->to}</span><br>
                    <span><b><u>{$data->placeOfWork}</u></b></span><br>
                </p>
            </div>
        ";

        $footer = "
            <div style=\"text-align: center; font-size: 8px;\">
                PAGE {PAGENO} TO {nbpg}
            </div>
        ";

        $body = "
            <table>
                <thead>
                    <tr>
                        <th rowspan=2 style=\"text-align: center; border: 1px solid black; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; width: 4%; font-size: 8px; \">No.</th>
                        <th rowspan=2 style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 8px; width: 7%;\">I.D. NO.</th>
                        <th rowspan=2 style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 8px; width: 10%;\">EMPLOYEE NAME</th>
                        <th rowspan=2 style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 8px; width: 7%;\">SERVICE/UNIT</th>
                        <th colspan=13 style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 8px; width: 20%;\">DESCRIPTION OF ABSENCE</th>
                    </tr>
                    <tr>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">VL</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">SL</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 8px;\">ML</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 4%; font-size: 8px;\">PL</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 8px;\">SPL</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 5%; font-size: 8px;\">MANDATORY</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">CTO</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">TRAINING</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 5%; font-size: 8px;\">CONFERENCE/MEETING</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 4%; font-size: 8px;\">CALAMITY</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">HOLIDAY</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">LWOP</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">AWOL</th>
                    </tr>
                </thead>
                <tbody>";

        $i = 1;
        foreach ($data->items as $item) {
            $body .= "
                    <tr>
                        <td style=\"text-align: center; border: 1px solid black; padding-left: 10px; padding-top: 5px; padding-bottom: 5px; width: 4%; font-size: 8px; \">$i</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 8px; width: 7%;\">{$item->employeeNumber}</td>
                        <td style=\"text-align: left; border: 1px solid black; padding-top: 5px; padding-left: 10px; padding-bottom: 5px; font-size: 8px; width: 10%;\">{$item->name}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 8px; width: 7%;\">{$item->division}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">{$item->vl}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">{$item->sl}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 8px;\">{$item->ml}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 4%; font-size: 8px;\">{$item->pl}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 2%; font-size: 8px;\">{$item->spl}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 5%; font-size: 8px;\">{$item->mandatory}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">{$item->cto}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">{$item->training}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 5%; font-size: 8px;\">{$item->meeting}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 4%; font-size: 8px;\">{$item->calamity}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">{$item->holiday}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">{$item->lwop}</td>
                        <td style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; width: 3%; font-size: 8px;\">{$item->awol}</td>
                    </tr>
                ";

            $i += 1;
        }

        $body .= "
                </tbody>
            </table>
            
            <br><br><br>
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
                        <center>{$data->preparedPosition}</center>
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->supervisorPosition}</center>
                    </td>
                </tr>
            </table>
        ";

        return $this->applyHtmlTemplate("Summary of Employees Absences", $style, $body, $header, $footer);
    }
}
