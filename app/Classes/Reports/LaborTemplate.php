<?php
namespace App\Classes\Reports;

use App\Classes\Template;

class LaborTemplate
{
    use Template;

    public function awardSummary($data)
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
                    <span style=\"font-size: 12px;\"><b>SUMMARY OF AWARDS</b></span><br>
                </p>
            </div>
        ";

        $footer = "
            <div style=\"text-align: center; font-size: 8px;\">
                PAGE {PAGENO} TO {nbpg}
            </div>

        ";

        $body = "
            <br><br>
            <table>
                <thead>
                    <tr>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"2%\">#</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"20%\">NAME</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"8%\">DATE AWARDED</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"10%\">TYPE</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"10%\">ACTIVITY</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"10%\">REMARKS</th>
                    </tr>
                </thead>
                <tbody>";

        $i = 1;
        foreach ($data->items as $item) {
            $body .= "
                <tr>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$i}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: left; border: 1px solid black; font-size: 11px;\">{$item->name}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: left; border: 1px solid black; font-size: 11px;\">{$item->date_awarded}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->type}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->activity}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->remarks}</td>
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
                        Noted by:
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
                        <center><b>{$data->noted}</b></center>
                    </td>
                </tr>
                <tr>
                    <td width=\"60%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->preparedPosition}</center>
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->notedPosition}</center>
                    </td>
                </tr>
            </table>
        ";

        return $this->applyHtmlTemplate("Summary of Awards", $style, $body, $header, $footer);
    }

    public function offenseSummary($data)
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
                    <span style=\"font-size: 12px;\"><b>SUMMARY OF OFFENSES</b></span><br>
                </p>
            </div>
        ";

        $footer = "
            <div style=\"text-align: center; font-size: 8px;\">
                PAGE {PAGENO} TO {nbpg}
            </div>

        ";

        $body = "
            <br><br>
            <table>
                <thead>
                    <tr>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"2%\">#</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"20%\">NAME</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"8%\">RECEIVED DATE</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"10%\">TYPE</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"10%\">OFFENSE</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"10%\">CORRECTIVE ACTION TAKEN</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"10%\">STATUS</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"10%\">REMARKS</th>
                        <th style=\"text-align: center; border: 1px solid black; padding-top: 5px; padding-bottom: 5px; font-size: 11px; \" width=\"10%\">MEMO DATE</th>
                    </tr>
                </thead>
                <tbody>";

        $i = 1;
        foreach ($data->items as $item) {
            $body .= "
                <tr>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$i}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: left; border: 1px solid black; font-size: 11px;\">{$item->name}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: left; border: 1px solid black; font-size: 11px;\">{$item->received_date}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->type}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->offense}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->corrective_action_taken}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->status}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->remarks}</td>
                    <td style=\"padding-left: 5px; padding-right: 5px; text-align: center; border: 1px solid black; font-size: 11px;\">{$item->memo_date}</td>
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
                        Noted by:
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
                        <center><b>{$data->noted}</b></center>
                    </td>
                </tr>
                <tr>
                    <td width=\"60%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->preparedPosition}</center>
                    </td>
                    <td width=\"40%\" style=\"font-size: 11px; padding-top: 0px;\" valign=\"top\">
                        <center>{$data->notedPosition}</center>
                    </td>
                </tr>
            </table>
        ";

        return $this->applyHtmlTemplate("Summary of Offenses", $style, $body, $header, $footer);
    }
}