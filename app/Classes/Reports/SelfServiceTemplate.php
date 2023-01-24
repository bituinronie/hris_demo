<?php
namespace App\Classes\Reports;

use App\Classes\Template;

class SelfServiceTemplate
{
    use Template {
        Template::__construct as private __templateConstruct;
    }

    public function __construct()
    {
        $this->__templateConstruct(true); // init constructor for TemplateTrait
    }

    public function laf($data){
        $style = "
            table, td, td {
                margin: 0px 0px;
                border-collapse: collapse;
            }
            body {
                font-size: 10px;
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

            .checkbox {
                font-weight: bold;
                text-align: center;
                vertical-align: middle;
            }
        ";

        $body = <<<HTML

            <table>
                <!-- 17 -->
                <tr>
                    <td width="1.43"></td>
                    <td width="1.14"></td>
                    <td width="1.57"></td>
                    <td width=".5"></td>
                    <td width="10.71"></td>
                    <td width="3.00"></td>
                    <td width="6.5"></td>
                    <td width="7.36"></td>
                    <td width="13.86"></td>
                    <td width="2.43"></td>
                    <td width="1.14"></td>
                    <td width="1.57"></td>
                    <td width=".5"></td>
                    <td width="13"></td>
                    <td width="2.57"></td>
                    <td width="8.71"></td>
                    <td width="11.43"></td>
                </tr>
                <tr>
                    <td colspan=17 style="vertical-align: bottom;">
                        <i>
                            Civil Service Form No. 6
                        </i>
                    </td>
                </tr>
                <tr>
                    <td height=20 colspan=17 style="vertical-align: top;">
                        <i>
                            Revised 2020
                        </i>
                    </td>
                </tr>
                <tr>
                    <td height="75" colspan=2>

                    </td>

                    <td colspan=2>
                        <center>
                            <img src="{$this->image("logo.png")}" height="2.5cm" width="2.5cm">
                        </center>
                    </td>

                    <td></td>

                    <td colspan=9 style="text-align: center; vertical-align: middle; padding-left: 20px; padding-right: 20px; font-size: 14px;">
                            {$this->UPPER_HEADER}<br>
                            {$this->DEPARTMENT_NAME}<br>
                            <b>{$this->OFFICE_NAME}</b><br>
                            <p style="font-size: 9px;">{$this->ADDRESS}</p><br>
                    </td>

                    <td colspan=3 style="text-align: center; color: gray; font-size: ">
                            Stamp of Date of Receipt
                    </td>
                </tr>

                <!-- Application Form Part -->
                <tr>
                    <td height=20 colspan=17 style="text-align: center; vertical-align: bottom; font-weight: bold; font-size: 20px; ">
                        APPLICATION FOR LEAVE
                    </td>
                </tr>
                <tr>
                    <td height=30></td>
                    <td class="leftBorder topBorder" style="vertical-align: bottom;">1.</td>

                    <td colspan=4 class="topBorder" style="vertical-align: bottom; text-align: left;">OFFICE/DEPARTMENT</td>

                    <td colspan=2 class="topBorder" style="vertical-align: bottom; text-align: right;">2. NAME:</td>

                    <td colspan=2 class="topBorder" style="vertical-align: bottom; text-align: center;">(Last)</td>

                    <td colspan=5 class="topBorder" style="vertical-align: bottom; text-align: center;">(First)</td>

                    <td colspan=2 class="topBorder rightBorder" style="vertical-align: bottom; text-align: center;">(Middle)</td>
                </tr>
                <tr>
                    <td height=40></td>
                    <td class="leftBorder"></td>

                    <td colspan=4 class="field" style="text-align: left;">{$data->info->office}</td>

                    <td colspan=2></td>

                    <td colspan=2 class="field" style="text-align: center;">{$data->info->lastName}</td>

                    <td colspan=5 class="field" style="text-align: center;">{$data->info->firstName}</td>

                    <td colspan=2 class="field rightBorder" style="text-align: center;">{$data->info->middleName}</td>
                </tr>
                <tr>
                    <td height=30></td>

                    <td class="leftBorder topBorder">3.</td>

                    <td colspan=3 class="topBorder">DATE OF FILING</td>

                    <td colspan=3 class="field topBorder bottomBorder" style="text-align: center;">{$data->info->dateOfFiling}</td>

                    <td class="topBorder" style="text-align: right;">4. POSITION</td>

                    <td colspan=5 class="field topBorder bottomBorder" style="text-align: center;">{$data->info->position}</td>

                    <td class="topBorder"></td>

                    <td class="topBorder" style="padding-right: 10px;">5. SALARY</td>

                    <td class="field bottomBorder rightBorder topBorder" style="text-align: center; font-size: 6px;">{$data->info->salary}</td>
                </tr>
                <tr>
                    <td height=10></td>
                    <td colspan=16 class="leftBorder bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td colspan=17 height=3></td>
                </tr>
                <tr>
                    <td height=30></td>
                    <td colspan=16 class="allBorder" style="text-align: center;">6. DETAILS OF APPLICATION</td>
                </tr>
                <tr>
                    <td colspan=17 height=3></td>
                </tr>
                <tr>
                    <td height=30></td>

                    <td colspan=7 class="leftBorder topBorder">6.A &nbsp;&nbsp;TYPE OF LEAVE TO BE AVAILED OF</td>

                    <td colspan=2 class="topBorder rightBorder"></td>

                    <td colspan=6 class="topBorder leftBorder">6.B &nbsp;&nbsp;DETAILS OF LEAVE</td>

                    <td class="topBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'1'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        
                        <p style="font-size: 8px;"><b>Vacation Leave</b>(Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=5 ><i>In case of Vacation/Special Privilege Leave:</i></td>

                    <td class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'3'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 7.5px;"><b>Mandatory/Forced Leave</b>(Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td width=20 colspan=2 class="allBorder checkbox"></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;Within the Philippines</td>

                    <td colspan=3 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'2'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 8px;"><b>Sick Leave</b>(Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2 class="allBorder checkbox"></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;Abroad (Specify)</td>

                    <td colspan=3 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'21'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 8px;"><b>Maternity Leave</b>(R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=5 ><i>In case of Sick Leave:</i></td>

                    <td class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'8'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 8px;"><b>Paternity Leave</b>(R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2 class="allBorder checkbox"></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;In Hospital (Specify Illness)</td>

                    <td colspan=3 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'5'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 8px;"><b>Special Privilege Leave</b>(Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2 class="allBorder checkbox"></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;Out Patient (Specify Illness)</td>

                    <td colspan=3 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'6'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 8px;"><b>Solo Parent Leave</b>(RA No. 8972 / CSC MC No. 8, s. 2004)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=5><i>In case of Special Leave Benefits for Women:</i></td>

                    <td class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'12'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 8px;"><b>Study Leave</b>(Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;(Specify Illness)</td>

                    <td colspan=3 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'13'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 8px;"><b>10-Day VAWC Leave</b>(RA No. 9262 / CSC MC No. 15, s. 2005)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=5><i>In case of Study Leave:</i></td>

                    <td class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'10'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 8px;"><b>Rehabilitation Privilege</b>(Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2 class="allBorder checkbox"></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;Completion of Master's Degree</td>

                    <td colspan=3 class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'11'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 8px;"><b>Special Leave Benefits for Women</b>(RA No. 9710 / CSC MC No. 25, s. 2010)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2 class="allBorder checkbox"></td>

                    <td colspan=3>&nbsp;&nbsp;&nbsp;&nbsp;BAR/Board Examination Review Other</td>

                    <td colspan=1 class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'7'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 8px;"><b>Special Emergency (Calamity) Leave</b>(CSC MC No. 2, s. 2012, as amended)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2></td>

                    <td><i>&nbsp;&nbsp;&nbsp;&nbsp;purpose:</i></td>

                    <td colspan=3 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=15></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox">{$data->details->type->{'23'}}</td>

                    <td></td>

                    <td colspan=5 style="text-align: left;">
                        <p style="font-size: 8px;"><b>Adoption Leave</b>(R.A. No. 8552)</p>
                    </td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2 class="allBorder checkbox"></td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;Monetization of Leave Credits</td>

                    <td colspan=3 class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=20></td>

                    <td class="leftBorder"></td>

                    <td class="allBorder checkbox"></td>

                    <td></td>

                    <td colspan=2 style="text-align: left; font-size: 8px;">
                        <b><i>Others</i></b>
                    </td>

                    <td colspan=3 class="bottomBorder" style="text-align: center;">{$data->details->others}</td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2 class="allBorder checkbox">{$data->details->type->{'22'}}</td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;Terminal Leave</td>

                    <td colspan=3 class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=10></td>
                    <td colspan=9 class="leftBorder bottomBorder rightBorder"></td>
                    <td colspan=7 class="leftBorder bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=30></td>

                    <td colspan=7 class="leftBorder topBorder">6.C &nbsp;&nbsp; NUMBER OF WORKING DAYS APPLIED FOR</td>

                    <td colspan=2 class="topBorder rightBorder"></td>

                    <td colspan=6 class="topBorder leftBorder">6.D &nbsp;&nbsp; COMMUTATION</td>

                    <td class="topBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=20></td>
                    <td colspan=2 class="leftBorder"></td>

                    <td colspan=6 class="bottomBorder">{$data->details->numberOfWorkingDays}</td>

                    <td width=20 class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2 class="allBorder checkbox">{$data->details->commutation->notRequested}</td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;Not Requested</td>

                    <td colspan=3 class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=20></td>
                    <td colspan=2 class="leftBorder"></td>

                    <td colspan=6>INCLUSIVE DATES</td>

                    <td class="rightBorder"></td>

                    <td class="leftBorder" width=10></td>

                    <td colspan=2 class="allBorder checkbox">{$data->details->commutation->requested}</td>

                    <td>&nbsp;&nbsp;&nbsp;&nbsp;Requested</td>

                    <td colspan=3 class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=20></td>
                    <td colspan=2 class="leftBorder"></td>

                    <td colspan=6 class="bottomBorder">{$data->details->inclusiveDates}</td>

                    <td class="rightBorder"></td>

                    <td colspan=7 class="leftBorder bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=20></td>
                    <td colspan=8 class="leftBorder"></td>

                    <td class="rightBorder"></td>

                    <td colspan=7 style="vertical-align: top; text-align: center;" class="rightBorder">(Signature of Applicant)</td>
                </tr>
                <tr>
                    <td height=10></td>
                    <td colspan=9 class="leftBorder bottomBorder rightBorder"></td>
                    <td colspan=7 class="leftBorder bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td colspan=17 height=3></td>
                </tr>
                <tr>
                    <td height=30></td>
                    <td colspan=16 class="allBorder" style="text-align: center;">7. DETAILS OF ACTION ON APPLICATION</td>
                </tr>
                <tr>
                    <td colspan=17 height=3></td>
                </tr>
                <tr>
                    <td height=30></td>

                    <td colspan=7 class="leftBorder topBorder">7.A &nbsp;&nbsp; CERTIFICATION OF LEAVE CREDITS</td>

                    <td colspan=2 class="topBorder rightBorder"></td>

                    <td colspan=6 class="topBorder leftBorder">7.B &nbsp;&nbsp; RECOMMENDATION</td>

                    <td class="topBorder rightBorder"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan=3 class="leftBorder"></td>
                    <td colspan=2 style="text-align: right;">As of</td>

                    <td colspan=3 class="bottomBorder">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$data->details->certification->asOf}</td>

                    <td class="rightBorder"></td>

                    <td colspan=7 class="rightBorder leftBorder"></td>
                </tr>
                <tr>
                    <td height=5></td>
                    <td colspan=9 class="leftBorder rightBorder"></td>
                    <td colspan=7 class="leftBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=25></td>

                    <td colspan=3 class="leftBorder"></td>
                    <td colspan=2 class="allBorder"></td>
                    <td colspan=2 class="allBorder" style="text-align: center; vertical-align: middle;">Vacation Leave</td>
                    <td class="allBorder" style="text-align: center; vertical-align: middle;">Sick Leave</td>
                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2 class="allBorder checkbox">{$data->details->recommendations->approval}</td>

                    <td style="vertical-align: bottom;">&nbsp;&nbsp;&nbsp;&nbsp;For approval</td>

                    <td colspan=3 class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=25></td>

                    <td colspan=3 class="leftBorder"></td>
                    <td colspan=2 class="allBorder"><i>Total Earned</i></td>
                    <td colspan=2 class="allBorder" style="text-align: center; vertical-align: middle;">{$data->details->certification->earned->vl}</td>
                    <td class="allBorder" style="text-align: center; vertical-align: middle;">{$data->details->certification->earned->sl}</td>
                    <td class="rightBorder"></td>

                    <td class="leftBorder"></td>

                    <td colspan=2 class="allBorder checkbox">{$data->details->recommendations->disapproval}</td>

                    <td style="vertical-align: bottom;">&nbsp;&nbsp;&nbsp;&nbsp;For disapproval due to</td>

                    <td colspan=3 class="bottomBorder rightBorder">{$data->details->recommendations->dueTo}</td>
                </tr>
                <tr>
                    <td height=25></td>

                    <td colspan=3 class="leftBorder"></td>
                    <td colspan=2 class="allBorder"><i>Less this application</i></td>
                    <td colspan=2 class="allBorder" style="text-align: center; vertical-align: middle;">{$data->details->certification->less->vl}</td>
                    <td class="allBorder" style="text-align: center; vertical-align: middle;">{$data->details->certification->less->sl}</td>
                    <td class="rightBorder"></td>

                    <td colspan=3 class="leftBorder"></td>

                    <td colspan=4 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=25></td>

                    <td colspan=3 class="leftBorder"></td>
                    <td colspan=2 class="allBorder"><i>Balance</i></td>
                    <td colspan=2 class="allBorder" style="text-align: center; vertical-align: middle;">{$data->details->certification->balance->vl}</td>
                    <td class="allBorder" style="text-align: center; vertical-align: middle;">{$data->details->certification->balance->sl}</td>
                    <td class="rightBorder"></td>

                    <td colspan=3 class="leftBorder"></td>

                    <td colspan=4 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=20></td>
                    <td colspan=9 class="leftBorder rightBorder"></td>
                    <td colspan=7 class="leftBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=25></td>

                    <td colspan=3 class="leftBorder"></td>
                    <td colspan=5 class="bottomBorder"></td>

                    <td class="rightBorder"></td>

                    <td colspan=3 class="leftBorder"></td>

                    <td colspan=4 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=25></td>

                    <td colspan=3 class="leftBorder"></td>
                    <td colspan=5 style="text-align: center; vertical-align: top;">Authorized Officer</td>

                    <td class="rightBorder"></td>

                    <td colspan=3 class="leftBorder"></td>

                    <td colspan=4 style="text-align: center; vertical-align: top;" class="rightBorder">Authorized Officer</td>
                </tr>
                <tr>
                    <td height=10></td>
                    <td colspan=9 class="leftBorder bottomBorder rightBorder"></td>
                    <td colspan=7 class="leftBorder bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=30></td>

                    <td colspan=7 class="leftBorder topBorder">7.C &nbsp;&nbsp;APPROVED FOR:</td>

                    <td colspan=2 class="topBorder"></td>

                    <td colspan=4 class="topBorder">7.D &nbsp;&nbsp;DISAPPROVED DUE TO:</td>

                    <td colspan=3 class="bottomBorder rightBorder">{$data->reason}</td>
                </tr>
                <tr>
                    <td height=10></td>

                    <td colspan=3 class="leftBorder bottomBorder" style="text-align: center;">{$data->daysWithPay}</td>

                    <td colspan=4 style="text-align: left;">days with pay</td>

                    <td colspan=2></td>

                    <td></td>

                    <td colspan=6 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=10></td>

                    <td colspan=3 class="leftBorder bottomBorder"></td>

                    <td colspan=4 style="text-align: left;">days without pay</td>

                    <td colspan=2></td>

                    <td></td>

                    <td colspan=6 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=10></td>

                    <td colspan=3 class="leftBorder bottomBorder"></td>

                    <td colspan=4 style="text-align: left;">others (Specify)</td>

                    <td colspan=2></td>

                    <td></td>

                    <td colspan=6 class="bottomBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=30></td>

                    <td colspan=16 class="leftBorder rightBorder"></td>
                </tr>
                <tr>
                    <td height=20></td>

                    <td colspan=6 class="leftBorder"></td>

                    <td colspan=7 class="bottomBorder"></td>

                    <td colspan=3 class="rightBorder"></td>
                </tr>
                <tr>
                    <td height=20></td>

                    <td colspan=6 class="leftBorder bottomBorder"></td>

                    <td colspan=7 class="bottomBorder" style="vertical-align: top; text-align: center;">Authorized Official</td>

                    <td colspan=3 class="rightBorder bottomBorder"></td>
                </tr>
            </table>
HTML;

        return $this->applyHtmlTemplate("Leave Application Form", $style, $body);
    }

    public function ll($data){

        $tableRecord = "";
        foreach ($data->leave_ledger as $refdate=>$array_value) {
            $tableRecord.="<tr class=\"no-border-horizontal\">";
            $tableRecord.="<td rowspan=\"" . count($array_value) . "\">".$refdate."</td>";

            $row=1;
            foreach($array_value as $leave_type=>$column) {
                if ($row>1)
                    $tableRecord.="</tr><tr class=\"no-border-horizontal\">";

                if ($leave_type=='earnings') {
                    $tableRecord.="<td> </td><td>".$column['vl_earned']."</td><td> </td><td>".$column['vl_balance']."</td><td>".(isset($column['vl_without_pay'])?$column['vl_without_pay']:" ")."</td><td>".$column['sl_earned']."</td><td> </td><td>".$column['sl_balance']."</td><td>".(isset($column['sl_without_pay'])?$column['sl_without_pay']:" ")."</td><td> </td>";
                } elseif ($leave_type=='VL') {
                    $tableRecord.="<td>".$leave_type."</td><td> </td><td>".$column['with_pay']."</td><td>".$column['vl_balance']."</td><td> </td><td> </td><td> </td><td> </td><td> </td><td>".$column['date_action']."</td>";
                } elseif ($leave_type=='SL') {
                    $tableRecord.="<td>".$leave_type."</td><td> </td><td> </td><td> </td><td> </td><td> </td><td>".$column['with_pay']."</td><td>".$column['sl_balance']."</td><td> </td><td>".$column['date_action']."</td>";
                }

                $row++;
            }

            $tableRecord.="</tr>";
        }

        $style = "
            body {
                font-family: calibri;
                font-size: 14px;
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
            .no-border-horizontal td {
                border-top: 0px;
                border-bottom: 0px;
                padding: 5px;
            }
            .border-top-only td {
                border: 0px;
                border-top: 1px solid black;
            }
        ";

        $body = "
            <div style=\"text-align: center\">
                <b>{$this->UPPER_HEADER}</b><br>
                <b>{$this->DEPARTMENT_NAME}</b><br>
                <b>{$this->OFFICE_NAME}</b>
                <p style=\"font-size: 9px;\">{$this->ADDRESS}</p><br>
            </div>
            <table style=\"width: 100%;\">
                <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td>{$data->name}</td>
                    <td style=\"text-align: right;\">1st Day of Entitlement to Leave Credits</td>
                    <td>:</td>
                    <td>{$data->first_day_entitlements}</td>
                    </tr>
                    <tr>
                    <td>Position</td>
                    <td>:</td>
                    <td>{$data->position}</td>
                    <td style=\"text-align: right;\">Division/Office</td>
                    <td>:</td>
                    <td>{$data->office}</td>
                </tr>
            </table>
            <br><br>
            <table class=\"table-request\">
                <tr>
                    <td style=\"height: 20px;\"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th style=\"width: 9%;\">PERIOD</th>
                    <th style=\"width: 9%;\">PARTICULARS</th>
                    <th colspan=\"4\" style=\"width: 36%;\">VACATION LEAVE</th>
                    <th colspan=\"4\" style=\"width: 36%;\">SICK LEAVE</th>
                    <th rowspan=\"2\" style=\"width: 10%;\">DATE and ACTION TAKEN ON APPLICATION FOR LEAVE</th>
                </tr>
                <tr>
                    <td>(Date)</td>
                    <td>(Type of Leave)</td>
                    <td style=\"width: 9%;\">E<br>A<br>R<br>N<br>E<br>D<br></td>
                    <td style=\"width: 9%;\">ABSENCE, HALF DAY, LATE & UNDERTIME WITH PAY</td>
                    <td style=\"width: 9%;\">B<br>A<br>L<br>A<br>N<br>C<br>E</td>
                    <td style=\"width: 9%;\">ABSENCE, HALF DAY, LATE & UNDERTIME W/OUT PAY</td>

                    <td style=\"width: 9%;\">E<br>A<br>R<br>N<br>E<br>D<br></td>
                    <td style=\"width: 9%;\">ABSENCE WITH PAY</td>
                    <td style=\"width: 9%;\">B<br>A<br>L<br>A<br>N<br>C<br>E</td>
                    <td style=\"width: 9%;\">ABSENCE W/OUT PAY</td>
                </tr>
                ".$tableRecord."<tr class=\"border-top-only\"> <!-- border bottom for table hehe -->
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <table style=\"width: 100%;\">
                <tr>
                    <td><b>END</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td colspan=\"3\"><b>TOTAL = {$data->total}</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <br>
            <table style=\"width: 100%;\">
                <tr style=\"height: 100px;\">
                    <td style='width: 9%;'></td>
                    <td colspan=\"2\">Prepared by:</td>
                </tr>
                <tr>
                    <td style='width: 9%;'></td>
                    <td style='width: 9%;'></td>
                    <td colspan=\"3\">{$data?->preparedBy}</td>
                </tr>
                    <tr style=\"height: 100px;\">
                    <td style='width: 9%;'></td>
                    <td colspan=\"2\">Certified correct:</td>
                </tr>
                <tr>
                    <td style='width: 9%;'></td>
                    <td style='width: 9%;'></td>
                    <td colspan=\"3\"><b>{$data?->certifiedBy}</b></td>
                </tr>
                <tr>
                    <td style='width: 9%;'></td>
                    <td style='width: 9%;'></td>
                    <td colspan=\"3\">{$data?->position2}, {$data?->division2}</td>
                </tr>
            </table>
        ";

        return $this->applyHtmlTemplate("Leave Ledger", $style, $body);
    }

    public function lb($data){
        $style = "
            body {
                font-family: calibri;
                font-size: 17px;
            }
            table {
                border-collapse: collapse;
            }
            .table-report {
                width: 100%;
                font-size: 16px;
            }
            .table-report th, .table-report td, .table-report table {
                border: 1px solid black;
                text-align: center;
                padding: 2px;
                padding-left: 5px;
                padding-right: 5px;
            }
        ";

        $body = "
            <table>
                <tr>
                    <td><img src=\"{$this->image("logo.png")}\" height=\"2.5cm\" width=\"2.5cm\"></td>
                    <td style=\"padding-left: 10px;\">
                        <span style=\"font-size: 17px;\">{$this->UPPER_HEADER}</span><br>
                        <span style=\"font-size: 17px;\">{$this->DEPARTMENT_NAME}</span><br>
                        <span style=\"font-size: 24px;\">{$this->OFFICE_NAME}</span><br>
                        <span style=\"font-size: 9px;\">{$this->ADDRESS}</span>
                    </td>
                </tr>
            </table>
            <br><br>
            <table style=\"width: 100%;\">
                <tr>
                    <td><b>MEMORANDUM</b></td>
                </tr>
                <tr>
                    <td>Attention</td>
                    <td>:</td>
                    <td><b>{$data->employee}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{$data->employeePosition}, {$data->employeeDivision}</td>
                </tr>
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>

                <tr>
                    <td>From</td>
                    <td>:</td>
                    <td><b>{$data->from}</b></td>
                </tr>
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>
                <tr>
                    <td>Subject</td>
                    <td>:</td>
                    <td><b>LEAVE CREDITS</b></td>
                </tr>
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>:</td>
                    <td>" . date('F d, Y') . "</td>
                </tr>
            </table>
            <hr style=\"border-top: 3px double black;\">
            <hr style=\"border-top: 3px double black;\">
            <table>
                <tr>
                    <td style=\"vertical-align: top;\">1.</td>
                    <td style=\"width: 3%;\"></td>
                    <td>For dissemination and guidance in the approval and/or disapproval of leave
                        application, hereunder are the leave credits of {$data->divisionName} and Staff,
                        as of {$data->asOf}:
                    </td>
                </tr>
            </table>
            <table class=\"table-report\">
                <tr>
                    <th style=\"width: 50%;\">NAME</th>
                    <th style=\"width: 16%;\">VACATION LEAVE</th>
                    <th style=\"width: 16%;\">SICK LEAVE</th>
                    <th style=\"width: 18%;\">TOTAL</th>
                </tr>
        ";


        foreach ($data->items as $item) {
            $body .= "
                <tr>
                    <td style=\"text-align: left;\">{$item->fullname}</td>
                    <td>{$item->vl_balance}</td>
                    <td>{$item->sl_balance}</td>
                    <td>{$item->total}</td>
                </tr>
            ";
        }

        $body .= "
            </table>
            <table>
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>
                <tr>
                    <td style=\"vertical-align: top;\">2.</td>
                    <td style=\"width: 3%;\"></td>
                    <td>These leave credits however are subject to review/recomputation in case of
                        separation from the service and/or queries.
                    </td>
                </tr>
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>
                <tr>
                    <td style=\"vertical-align: top;\">3.</td>
                    <td style=\"width: 3%;\"></td>
                    <td>For your information and guidance.
                    </td>
                </tr>
            </table>
            <br><br><br><br><br>
            <b>{$data->supervisor}</b>
            <br />{$data->supervisorDivision}
        ";

        return $this->applyHtmlTemplate("Leave Balance", $style, $body);
    }

    public function clc($data){
        $style = "
            body {
                font-family: calibri;
                font-size: 15px;
                height: 100%;
            }
        ";

        $page_size = count($data->items);
        $page = 1;

        $body = "";
        $spacing = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        foreach ($data->items as $item) {
            $body .= "
                <table style=\"width: 60%; margin-left: auto; margin-right: auto;\">
                    <tr>
                        <td><img src=\"{$this->image("logo.png")}\" height=\"2.5cm\" width=\"2.5cm\"></td>
                        <td style=\"padding-left: 10px;\">
                            <span style=\"font-size: 17px;\">{$this->UPPER_HEADER}</span><br>
                            <span style=\"font-size: 17px;\">{$this->DEPARTMENT_NAME}</span><br>
                            <span style=\"font-size: 18px; font-weight: bold;\">{$this->OFFICE_NAME}</span><br>
                        </td>
                    </tr>
                </table>
                <br><br><br>
                <table style=\"width: 100%;\">
                    <tr>
                        <td style=\"text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                            <span>
                                <u><b>CERTIFICATION OF LEAVE BALANCE</b></u>
                            </span>
                        </td>
                    </tr>
                </table>
                <br><br>
                TO WHOM IT MAY CONCERN:
                <br><br>
                $spacing THIS IS TO CERTIFY that {$item->employee_name}, {$item->employee_position} has a total accumulated leave credits of <b>{$item->vl_sl_total}</b> as of {$data->asOf}.
                <br><br><br>
                <table style=\"width: 80%; margin-left: auto; margin-right: auto;\">
                    <tr>
                        <td style=\"width: 40%; text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                            <span>
                                <u><b>VACATION LEAVE</b></u>
                            </span>
                        </td>
                        <td style=\"width: 40%; text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                            <span>
                                <u><b>SICK LEAVE</b></u>
                            </span>
                        </td>
                        <td style=\"width: 20%; text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                            <span>
                                <u><b>TOTAL</b></u>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"height: 60; text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                                {$item->vl_balance}
                        </td>
                        <td style=\"text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                                {$item->sl_balance}
                        </td>
                        <td style=\"text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                                {$item->vl_sl_total}
                        </td>
                    </tr>
                </table>
                $spacing Further, the total number of leave credits earned by subject personnel has an 
                equivalent value of <b>{$item->totalAmountWord} ({$item->totalAmount})</b> with computations below.
                This certification is being issued for whatever legal purpose this may serve.
                <br><br><br>
                <table style=\"width: 80%; margin-left: auto; margin-right: auto;\">
                    <tr>
                        <td style=\"width: 20%; text-align: center; vertical-align: top; border-left: 0px; border-right: 0px; border-top: 0px;\">
                            <span>
                                <u><b>LEAVE CREDITS</b></u>
                            </span>
                        </td>
                        <td style=\"width: 20%; text-align: center; vertical-align: top; border-left: 0px; border-right: 0px; border-top: 0px;\">
                            <span>
                                <u><b>BASIC PAY</b></u>
                            </span>
                        </td>
                        <td style=\"width: 20%; text-align: center; vertical-align: top; border-left: 0px; border-right: 0px; border-top: 0px;\">
                            <span>
                                <b>
                                    <u>COMMON FACTOR</u><br>
                                    (PER CSC)
                                </b>
                            </span>
                        </td>
                        <td style=\"width: 20%; text-align: center; vertical-align: top; border-left: 0px; border-right: 0px; border-top: 0px;\">
                            <span>
                                <u><b>TOTAL</b></u>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td style=\"height: 80; text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                                {$item->vl_sl_total} days &nbsp;&nbsp;&nbsp;&nbsp;X
                        </td>
                        <td style=\"text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                                {$item->basicPay}
                        </td>
                        <td style=\"text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                                {$item->commonFactor}
                        </td>
                        <td style=\"text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                                {$item->totalAmount}
                        </td>
                    </tr>
                </table>
                $spacing This certification is being issued upon request of <b>MS CESA</b> for the commutation of
                her leave balance in connection with her optional retirement from the government service
                effective 31 Aug 2021, pursuant to OTS Special Order No. 2021-457 dated 13 Sep 2021
                <br><br><br>
                <table style=\"width: 100%;\">
                    <tr>
                        <td style=\"font-size: 14px; width: 50%; text-align: left; vertical-align: bottom; border-left: 0px; border-right: 0px; border-top: 0px;\">
                            <span>
                                Prepared By:<br><br><br><br><br>
                                <b>{$data->prepared}</b><br>
                                {$data->preparedPosition}<br>
                                {$data->preparedDivision}
                            </span>
                        <td style=\"font-size: 14px; width: 50%; text-align: left; vertical-align: bottom; border-left: 0px; border-right: 0px; border-top: 0px;\">
                            <span>
                                Verified By:<br><br><br><br><br>
                                <b>{$data->verified}</b><br>
                                {$data->verifiedPosition}<br>
                                {$data->verifiedDivision}
                            </span>
                        </td>
                    </tr>
                </table>
                <br><br>
                <table style=\"width: 100%;\">
                    <tr>
                        <td style=\"font-size: 10px; text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 1px solid black;\">
                            <span>
                                {$this->ADDRESS}<br>
                                {$this->CONTACT_NUMBER}
                            </span>
                        </td>
                    </tr>
                </table>
                
                ";

            if ($page!=$page_size){
                $body .= "<p style=\"page-break-before: always\">";
                $page++;
            }
        }

        return $this->applyHtmlTemplate("Certification of Leave Credits", $style, $body);
    }

    public function cwp($data){
        $style = "
        body {
            font-family: calibri;
            font-size: 17px;
            height: 100%;
        }
        ";

        $page_size = count($data->items);
        $body = "";
        $page = 1;
        foreach ($data->items as $item) {
            $body .= "
            <table>
                <tr>
                    <td><img src=\"{$this->image("logo.png")}\" height=\"2.5cm\" width=\"2.5cm\"></td>
                    <td style=\"padding-left: 10px;\">
                        <span style=\"font-size: 17px;\">{$this->UPPER_HEADER}</span><br>
                        <span style=\"font-size: 17px;\">{$this->DEPARTMENT_NAME}</span><br>
                        <span style=\"font-size: 24px;\">{$this->OFFICE_NAME}</span><br>
                        <span style=\"font-size: 9px;\">{$this->ADDRESS}</span>
                    </td>
                </tr>
            </table>
            <br><br><br>
            <table style=\"width: 100%;\">
                <tr>
                    <td style=\"text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                        <span>
                            <u><b>C E R T I F I C A T I O N OF LEAVE WITHOUT PAY</b></u>
                        </span>
                    </td>
                </tr>
            </table>
            <br><br><br>
            <b>TO WHOM IT MAY CONCERN:</b>
            <br><br>
            This is to certify that <b>{$item->employee_name}</b>, is a bonifide employee of this Office and
            employed since {$data->dateFrom}-{$data->dateTo} has " . ($item->withoutPay>0?' incurred':'not incurred any') . " Leave Without Pay from {$data->dateFrom} to {$data->dateTo}
            <br><br>
            This certification is being issued upon request of {$item->requestor} for whatever legal
            purpose this may serve.
            <br><br><br><br><br><br>
            " . date('d F Y') . "
            <br><br>
            <b>{$data->supervisor}</b><br>
            {$data->supervisorPosition}, {$data->supervisorDivision}";

            if ($page!=$page_size){
                $body .= "<p style=\"page-break-before: always\">";
                $page++;
            }
        }

        return $this->applyHtmlTemplate("Certification of Leave Without Pay", $style, $body);
    }

    public function sr($data){
        $style = "
        body {
            font-family: calibri;
            font-size: 17px;
        }
        table {
            border-collapse: collapse;
        }
        .table-report {
            width: 100%;
            font-size: 16px;
        }
        .table-report th, .table-report td, .table-report table {
            border: 1px solid black;
            text-align: center;
            padding: 2px;
            padding-left: 5px;
            padding-right: 5px;
        }
        ";

        $body = "
        <table>
            <tr>
                <td><img src=\"{$this->image("logo.png")}\" height=\"2.5cm\" width=\"2.5cm\"></td>
                <td style=\"padding-left: 10px;\">
                    <span style=\"font-size: 17px;\">{$this->UPPER_HEADER}</span><br>
                    <span style=\"font-size: 17px;\">{$this->DEPARTMENT_NAME}</span><br>
                    <span style=\"font-size: 24px;\">{$this->OFFICE_NAME}</span><br>
                    <span style=\"font-size: 9px;\">{$this->ADDRESS}</span>
                </td>
            </tr>
        </table>
        <br><br>
        <table style=\"width: 100%;\">
            <tr>
                <td><b>MEMORANDUM</b></td>
            </tr>
            <tr>
                <td>For</td>
                <td>:</td>
                <td><b>{$data->for}</b></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{$data->forPosition}, {$data->forDivision}</td>
            </tr>
            <tr>
                <td>From</td>
                <td>:</td>
                <td><b>{$data->from}</b></td>
            </tr>
            <tr>
                <td>Subject</td>
                <td>:</td>
                <td><b>SALARY DEDUCTION FROM THE PAYROLL</b></td></tr>
            <tr>
                <td>Date</td>
                <td>:</td>
                <td>" . date('F d, Y') . "</td>
            </tr>
            </table>
            <hr style=\"border-top: 3px double black;\">
            <hr style=\"border-top: 3px double black;\">
            Please effect the salary deduction from the Payroll of the following personnel:
            <br><br>
            <table class=\"table-report\">
                <tr>
                    <th style=\"width: 29%;\">OFFICE / NAME</th>
                    <th style=\"width: 18%;\">VACATION / SICK LEAVE W/O PAY - DATES COVERED</th>
                    <th style=\"width: 18%;\">TARDINESS / UNDERTIME</th>
                    <th style=\"width: 10%;\">TOTAL NUMBER OF DAYS</th>
                    <th style=\"width: 25%;\">REMARKS</th>
                </tr>";
            foreach ($data->items as $key=>$value) {
                $body .= "
                    <tr>
                        <td colspan=\"5\" style=\"text-align: left;\"><b>" . $key . "</b></td>
                    </tr>
                ";

                foreach ($value as $key=>$details) {
                    $body .= "
                        <tr>
                            <td style=\"text-align: left;\">" . $key . "</td>
                            <td style=\"text-align: center;\">" . $details['wop_covered'] . "</td>
                            <td style=\"text-align: center;\">" . $details['tardiness'] . "</td>
                            <td style=\"text-align: right;\">" . $details['days'] . "</td>
                            <td style=\"text-align: left;\">" . $details['remarks'] . "</td>
                        </tr>
                        <tr>
                            <td colspan=\"5\" style=\"height: 15px;\"></td>
                        </tr>
                    ";
                }
            }
            $body .= "</table>
            <br><br><br>
            <b>$data->signed<br>$data->signedDivision</b>
        ";

        return $this->applyHtmlTemplate("Salary Deduction from the Payroll", $style, $body);
    }

    public function mon($data){
        $style = "
        body {
            font-family: calibri;
            font-size: 17px;
        }
        table {
            border-collapse: collapse;
        }
        .table-report {
            width: 100%;
            font-size: 16px;
        }
        .table-report th, .table-report td, .table-report table {
            border: 1px solid black;
            text-align: center;
            padding: 2px;
            padding-left: 5px;
            padding-right: 5px;
        }
        ";

        $body ="
        <table>
            <tr>
                <td><img src=\"{$this->image("logo.png")}\" height=\"2.5cm\" width=\"2.5cm\"></td>
                <td style=\"padding-left: 10px;\">
                    <span style=\"font-size: 17px;\">{$this->UPPER_HEADER}</span><br>
                    <span style=\"font-size: 17px;\">{$this->DEPARTMENT_NAME}</span><br>
                    <span style=\"font-size: 24px;\">{$this->OFFICE_NAME}</span><br>
                    <span style=\"font-size: 9px;\">{$this->ADDRESS}</span>
                </td>
            </tr>
        </table>
        <br><br>

        <table style=\"width: 100%;\">
            <tr>
                <td><b>MEMORANDUM</b></td>
            </tr>
            <tr>
                <td>For</td>
                <td>:</td>
                <td><b>{$data->for}</b></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{$data->forPosition}, {$data->forDivision}</td>
            </tr>
        ";

        if ($data->printType=='FOR_APPROPRIATE_ACTION') {
            $body .= "
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>
                <tr>
                    <td>Through</td>
                    <td>:</td>
                    <td><b>{$data->through}</b></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>{$data->throughPosition}, {$data->throughDivision}</td>
                </tr>
            ";
        }

        $body .= "
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>

                <tr>
                    <td>From</td>
                    <td>:</td>
                    <td><b>" . ($data->printType=='FOR_APPROPRIATE_ACTION'?"CHIEF OF PERSONNEL DIVISION":"DIRECTOR FOR ADMINISTRATIVE SERVICE") . "</b></td>
                </tr>
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>
                <tr>
                    <td>Subject</td>
                    <td>:</td>
                    <td><b>" . ($data->printType=='FOR_APPROPRIATE_ACTION'?"APPLICATIONS FOR MONETIZATION OF LEAVE CREDITS OF EMPLOYEES OF THIS DEPARTMENT":"APPLICATION FOR MONETIZATION OF LEAVE CREDITS EMPLOYEES, THIS DEPARTMENT") . "</b></td>
                </tr>
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>
                <tr>
                    <td>Date</td>
                    <td>:</td>
                    <td>" . date('F d, Y') . "</td>
                </tr>
            </table>
            <hr style=\"border-top: 3px double black;\">
        ";

        if ($data->printType=='FOR_APPROVAL')
            $body .= "
                <table>
                    <tr>
                        <td style=\"vertical-align: top;\">1.</td>
                        <td style=\"width: 3%;\"></td>
                        <td>
                            Transmitted are the letter requests and applications for the monetization of 50% to 80% leave credits of employees of this Department, pursuant to Civil Service Commission Memorandum Circular No. 41, Series of 1998, as follows:
                        </td>
                    </tr>
                </table>
            ";
        else
            $body .= "
                <table>
                    <tr>
                        <td style=\"vertical-align: top;\">1.</td>
                        <td style=\"width: 3%;\"></td>
                        <td>We are transmitting the applications for the monetization of leave credits of employees of this Department, pursuant to Civil Service Commission Memorandum Circular No. 41, Series of 1998, as follows:
                        </td>
                    </tr>
                </table>
            ";

        $body .= "
            <table class=\"table-report\">
                <tr>
                    <th style=\"text-align:center;width:5%\">ID #</th>
                    <th style=\"text-align:center;width:30%\">NAME</th>
                    <th style=\"text-align:center;width:15%\">NO. OF DAYS BEING MONETIZED</th>
                    <th style=\"text-align:center;width:30%\">REMARKS</th>
                </tr>
        ";

        foreach ($data->items as $emp) {
            $body .= "
                <tr>
                    <td style=\"text-align:center;width:5%\">" . $emp['employee_number'] . "</td>
                    <td style=\"text-align:center;width:30%\">" . $emp['employee_name'] . "</td>
                    <td style=\"text-align:center;width:15%\">" . number_format($emp['credit'],3) . "</td>
                    <td style=\"text-align:center;width:30%\">" . $emp['reason'] . "</td>
                </tr>
            ";
        }

        $body .= "</table>";

        if ($data->printType=='FOR_APPROVAL')
            $body .= "
                <table>
                    <tr>
                        <td style=\"height: 20px;\"></td>
                    </tr>
                    <tr>
                        <td style=\"vertical-align: top;\">2.</td>
                        <td style=\"width: 3%;\"></td>
                        <td>The same were found to be in order, thus, approved for funding allocation.
                        </td>
                    </tr>
                    <tr>
                        <td style=\"height: 20px;\"></td>
                    </tr>
                    <tr>
                        <td style=\"vertical-align: top;\">3.</td>
                        <td style=\"width: 3%;\"></td>
                        <td>These applications are being endoresed for the Undersecretary's signature, pursuant to the existing policy on delineation/delegation of authority/functions of this Officer.
                        </td>
                    </tr>
                    <tr>
                        <td style=\"height: 20px;\"></td>
                    </tr>
                    <tr>
                        <td style=\"vertical-align: top;\">4.</td>
                        <td style=\"width: 3%;\"></td>
                        <td>For your consideration, signature and approval.
                        </td>
                    </tr>
                    <tr>
                        <td style=\"height: 20px;\"></td>
                    </tr>
                </table>
            ";
        else
            $body .= "
                <table>
                    <tr>
                        <td style=\"height: 20px;\"></td>
                    </tr>
                    <tr>
                        <td style=\"vertical-align: top;\">2.</td>
                        <td style=\"width: 3%;\"></td>
                        <td>For your information and appropriate action.</td>
                    </tr>
                </table>
            ";

        $body .="
            <br><br><br><br><br>
            <b>{$data->signed}</b>
            <br />{$data->signedPosition}
            <br />{$data->signedDivision} 
        ";

        return $this->applyHtmlTemplate("Monetization", $style, $body);
    }

    public function slr($data){
        $style = "
        body {
            font-family: calibri;
            font-size: 12px;`
            height: 100%;
        }
        table {
            border-collapse: collapse;
        }
        .table-report {
            width: 100%;
            font-size: 12px;
        }
        .table-report th, .table-report td, .table-report table {
            border: 1px solid black;
            text-align: center;
            padding: 2px;
            padding-left: 5px;
            padding-right: 5px;
        }
        ";

        $colspan = $data->status == 'ALL' ? 12 : 11;

        $body = "
            <table class=\"table-report\">
                <thead>
                    <tr>
                        <th colspan=\"$colspan\" style=\"text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\"><b>{$data->title}</b></th>
                    </tr>
                    <tr>
                        <th rowspan=\"2\">ID. #</th>
                        <th rowspan=\"2\">NAME</th>
                        <th rowspan=\"2\">POSITION</th>
                        <th rowspan=\"2\">SALARY GRADE</th>
                        <th rowspan=\"2\">DIVISION/OFFICE</th>
                        <th rowspan=\"2\">SL</th>
                        <th rowspan=\"2\">VL</th>
                        <th rowspan=\"2\">OB</th>
                        <th rowspan=\"2\">CTO</th>
                        <th colspan=\"2\">DATE</th>
        ";

        if ($data->status == 'ALL')
            $body.="    <th rowspan=\"2\">STATUS</th>";

        $body .= "
                    </tr>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                </thead>
                <tbody>
        ";

        foreach ($data->items as $row) {
            $body .= "
                    <tr>
                        <td>" . $row['employee_number'] . "</td>
                        <td>" . $row['employee_name']. "</td>
                        <td>" . $row['position']. "</td>
                        <td>" . $row['salary_grade']. "</td>
                        <td>" . substr($row['place_of_work'],0,strpos($row['place_of_work'],'(')). "</td>
                        <td>" . $row['SL'] . "</td>
                        <td>" . $row['VL'] . "</td>
                        <td>" . $row['OB'] . "</td>
                        <td>" . $row['CTO'] . "</td>
                        <td>" . $row['from'] . "</td>
                        <td>" . $row['to'] . "</td>
            ";

            if ($data->status == 'ALL')
                $body.=("<td>" .  $row['status'] . "</td>");

            $body.="</tr>";
        }
        $body .= "
                <tbody>
            </table>
        ";

        return $this->applyHtmlTemplate($data->title, $style, $body);
    }

    public function sro($data){
        $style = "
        body {
            font-family: calibri;
            font-size: 12px;
            height: 100%;
        }
        table {
            border-collapse: collapse;
        }
        .table-report {
            width: 100%;
            font-size: 12px;
        }
        .table-report th, .table-report td, .table-report table {
            border: 1px solid black;
            text-align: center;
            padding: 2px;
            padding-left: 5px;
            padding-right: 5px;
        }
        ";

        $body = "
        <table class=\"table-report\">
            <thead>
                <tr>
                    <th colspan=\"8\" style=\"text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                        <b>SUMMARY OF EMPLOYEES WITH APPROVED REQUESTS TO RENDER OVERTIME</b>
                    </th>
                </tr>
                <tr>
                    <th rowspan=\"2\">ID. #</th>
                    <th rowspan=\"2\">NAME</th>
                    <th rowspan=\"2\">POSITION</th>
                    <th rowspan=\"2\">SALARY GRADE</th>
                    <th rowspan=\"2\">DIVISION/OFFICE</th>
                    <th rowspan=\"2\">Approved # of Hours</th>
                    <th colspan=\"2\">DATE</th>
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
            <tbody>";
          foreach ($data as $row) {
            $body .= "<tr>
                          <td>" . $row['employee_number'] . "</td>
                          <td>" . $row['employee_name']. "</td>
                          <td>" . $row['position']. "</td>
                          <td>" . $row['salary_grade']. "</td>
                          <td>" . $row['place_of_work']. "</td>
                          <td>" . $row['OT'] . "</td>
                          <td>" . $row['from'] . "</td>
                          <td>" . $row['to'] . "</td>
                      </tr>";
          }
        $body .= "</tbody></table>";

        return $this->applyHtmlTemplate('Summary of Employees with Approved Request to Render Overtime', $style, $body);
    }

    public function snd($data){
        $style = "
        body {
            font-family: calibri;
            font-size: 12px;
            height: 100%;
        }
        table {
            border-collapse: collapse;
        }
        .table-report {
            width: 100%;
            font-size: 12px;
        }
        .table-report th, .table-report td, .table-report table {
            border: 1px solid black;
            text-align: center;
            padding: 2px;
            padding-left: 5px;
            padding-right: 5px;
        }
        ";

        $body = "
        <table class=\"table-report\">
            <thead>
                <tr>
                    <th colspan=\"8\" style=\"text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                        <b>SUMMARY OF EMPLOYEES WITH APPROVED REQUESTS TO RENDER OVERTIME</b>
                    </th>
                </tr>
                <tr>
                    <th rowspan=\"2\">ID. #</th>
                    <th rowspan=\"2\">NAME</th>
                    <th rowspan=\"2\">POSITION</th>
                    <th rowspan=\"2\">SALARY GRADE</th>
                    <th rowspan=\"2\">DIVISION/OFFICE</th>
                    <th rowspan=\"2\">Approved # of Hours</th>
                    <th colspan=\"2\">DATE</th>
                </tr>
                <tr>
                    <th>From</th>
                    <th>To</th>
                </tr>
            </thead>
            <tbody>";
          foreach ($data as $row) {
            $body .= "<tr>
                          <td>" . $row['employee_number'] . "</td>
                          <td>" . $row['employee_name']. "</td>
                          <td>" . $row['position']. "</td>
                          <td>" . $row['salary_grade']. "</td>
                          <td>" . $row['place_of_work']. "</td>
                          <td>" . $row['credit'] . "</td>
                          <td>" . $row['from'] . "</td>
                          <td>" . $row['to'] . "</td>
                      </tr>";
          }
        $body .= "</tbody></table>";

        return $this->applyHtmlTemplate('Summary of Employees With Approved Request for Night Differential Pay', $style, $body);
    }

    public function snl($data){
        $style = "
        body {
            font-family: calibri;
            font-size: 12px;
            height: 100%;
        }
        table {
            border-collapse: collapse;
        }
        .table-report {
            width: 100%;
            font-size: 12px;
        }
        .table-report th, .table-report td, .table-report table {
            border: 1px solid black;
            text-align: center;
            padding: 2px;
            padding-left: 5px;
            padding-right: 5px;
        }
        ";

        $body = "
            <table class=\"table-report\">
                <thead>
                    <tr>
                        <th colspan=\"8\" style=\"text-align: center; vertical-align: middle; border-left: 0px; border-right: 0px; border-top: 0px;\">
                            <b>MONTHLY SUMMARY OF EMPLOYEES WITH NEGATIVE VL AND SL CREDITS</b>
                        </th>
                    </tr>
                    <tr>
                        <th rowspan=\"2\">ID. #</th>
                        <th rowspan=\"2\">NAME</th>
                        <th rowspan=\"2\">POSITION</th>
                        <th rowspan=\"2\">SALARY GRADE</th>
                        <th rowspan=\"2\">DIVISION/OFFICE</th>
                        <th rowspan=\"2\">SL</th>
                        <th rowspan=\"2\">VL</th>
                        <th colspan=\"2\">DATE</th>
                    </tr>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                    </tr>
                </thead>
                <tbody>
        ";
          foreach ($data as $row) {
            $body .= "
                <tr>
                    <td>" . $row['employee_number'] . "</td>
                    <td>" . $row['employee_name']. "</td>
                    <td>" . $row['position']. "</td>
                    <td>" . $row['salary_grade']. "</td>
                    <td>" . $row['place_of_work']. "</td>
                    <td>" . $row['SL'] . "</td>
                    <td>" . $row['VL'] . "</td>
                    <td>" . $row['from'] . "</td>
                    <td>" . $row['to'] . "</td>
                </tr>
            ";
          }
        $body .= "</tbody></table>";

        return $this->applyHtmlTemplate('Monthly Summary of employees with negative VL and SL credits', $style, $body);
    }

    public function aul($data){
        $style = "
        body {
            font-family: calibri;
            font-size: 17px;
        }
        table {
            border-collapse: collapse;
        }
        .table-report {
            width: 100%;
            font-size: 16px;
        }
        .table-report th, .table-report td, .table-report table {
            border: 1px solid black;
            text-align: center;
            padding: 2px;
            padding-left: 5px;
            padding-right: 5px;
        }
        ";

        $body = "
        <table>
            <tr>
                <td><img src=\"{$this->image("logo.png")}\" height=\"2.5cm\" width=\"2.5cm\"></td>
                <td style=\"padding-left: 10px;\">
                    <span style=\"font-size: 17px;\">{$this->UPPER_HEADER}</span><br>
                    <span style=\"font-size: 17px;\">{$this->DEPARTMENT_NAME}</span><br>
                    <span style=\"font-size: 24px;\">{$this->OFFICE_NAME}</span><br>
                    <span style=\"font-size: 9px;\">{$this->ADDRESS}</span>
                </td>
            </tr>
        </table>
        <br><br>
        <table style=\"width: 100%;\">
            <tr>
                <td><b>MEMORANDUM</b></td>
            </tr>
            <tr>
                <td>Attention</td>
                <td>:</td>
                <td><b>{$data->for}</b></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{$data->forPosition}, {$data->forDivision}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>This Department</td>
            </tr>
            <tr>
                <td style=\"height: 20px;\"></td>
            </tr>

            <tr>
                <td>From</td>
                <td>:</td>
                <td><b>CHIEF OF PERSONNEL DIVISION</b></td>
            </tr>
            <tr>
                <td style=\"height: 20px;\"></td>
            </tr>
            <tr>
                <td>Subject</td>
                <td>:</td>
                <td><b>LEAVE CREDITS</b></td>
            </tr>
            <tr>
                <td style=\"height: 20px;\"></td>
            </tr>
            <tr>
                <td>Date</td>
                <td>:</td>
                <td>" . date('d F Y') . "</td>
            </tr>
        </table>
        <hr style=\"border-top: 3px double black;\">
        <table>
            <tr>
                <td style=\"vertical-align: top;\">1.</td>
                <td style=\"width: 3%;\"></td>
                <td>For dissemination and guidance in the approval and/or disapproval of leave
                application, hereunder are the leave credits of {$data->divisionName} and Staff,
                as of {$data->refDate}:
                </td>
            </tr>
        </table>
        <table class=\"table-report\">
            <tr>
              <th style=\"width: 50%;\">NAME</th>
              <th style=\"width: 16%;\">VACATION LEAVE</th>
              <th style=\"width: 16%;\">SICK LEAVE</th>
              <th style=\"width: 18%;\">TOTAL</th>
            </tr>
        ";

        foreach ($data->items as $item) {
            $body .= "<tr>
                <td style=\"text-align: left;\">{$item->fullname}</td>
                <td>{$item->vl_balance}</td>
                <td>{$item->sl_balance}</td>
                <td>{$item->total}</td>
            </tr>";
        }

        $body .= "
            </table>
            <table>
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>
                <tr>
                    <td style=\"vertical-align: top;\">2.</td>
                    <td style=\"width: 3%;\"></td>
                    <td>These leave credits however are subject to review/recomputation in case of
                        separation from the service and/or queries.
                    </td>
                </tr>
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>
                <tr>
                    <td style=\"vertical-align: top;\">3.</td>
                    <td style=\"width: 3%;\"></td>
                    <td>Further, may we reiterate that employee with more that ten (10) days vacation leave credits are required to go on forced leave for five(5) days per year <u>to avoid</u> forfeiture/mandatory deduction of leave credits at the end of the year even if forced leave was not enjoyed/availed of.
                    </td>
                </tr>
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>
                <tr>
                    <td style=\"vertical-align: top;\">4.</td>
                    <td style=\"width: 3%;\"></td>
                    <td>Likewise, employee who availed of monetization resulting to less than ten (10) days vacation leave credits are required to go on forced leave. Hence, disapproval of their forced leave shall not be considered.
                </td>
                </tr>
                <tr>
                    <td style=\"height: 20px;\"></td>
                </tr>
                <tr>
                    <td style=\"vertical-align: top;\">5.</td>
                    <td style=\"width: 3%;\"></td>
                    <td>For your information and guidance.
                    </td>
                </tr>
            </table>
            <br><br><br><br><br>
            <b>{$data->signed}</b>
            <br />{$data->signedDivision}";

        return $this->applyHtmlTemplate('Year-end list of employees unused VL and SL for commutation', $style, $body);
    }
}