<?php

namespace App\Notifications;

use App\Traits\TokenTrait;
use Illuminate\Support\Str;
use App\Traits\ConstantTrait;
use Illuminate\Bus\Queueable;
use Spatie\Permission\Models\Permission;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Request extends Notification
{
    use Queueable, ConstantTrait, TokenTrait;

    public $TO_MAIL = [];
    public $REQUEST_TYPE = "";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($leaveLedger, $toNotify)
    {
        $this->REQUEST_TYPE = $leaveLedger->requestName;

        // button urls & displays
        $btnStyle = " color: #FFF; border: 1px solid #FEFEFE; padding: 10px 30px; margin: 10px 10px; text-decoration: none;";

        $proofButton = $leaveLedger->proofUrl?
                            "<a href={$leaveLedger->proofUrl} style=\"background: #1976D2; $btnStyle\"> Link </a>":"No attachment";

        $token = $this->generateToken(
            Permission::whereName('portal request')->first()->id,
            $toNotify->user->id,
            [
                'requestId' => $leaveLedger->id
            ]
        );

        $approveUrl = url("/#/request_approval_uri?type=approve&token=$token");
        $disapproveUrl = url("/#/request_approval_uri?type=disapprove&token=$token");

        $buttons = "<span style=\"text-align: center; width: 100%; display: inline-block; margin: 5px 5px;\">
                            <a href=$approveUrl style=\"background: #449a44; $btnStyle\"> Approve </a><br><br>
                            <a href=$disapproveUrl style=\"background: #b76161; $btnStyle\"> Disapprove </a>
                        </span>";

        $this->TO_MAIL = [
            'fullName' => $toNotify->name,
            'requestBy' => $leaveLedger->employee->name,
            'info' => $leaveLedger->employee->designationName && $leaveLedger->employee->division ?
                    Str::upper("{$leaveLedger->employee->designationName}/{$leaveLedger->employee->division}"):null,
            'dateCovered' => $leaveLedger->from->format($this->visualDateFormat)." - ".$leaveLedger->to->format($this->visualDateFormat),
            'credit' => abs($leaveLedger->credit),
            'requestType' => $leaveLedger->requestName,
            'buttons' => $buttons,
            'proofType' => $leaveLedger->proof_type,
            'proofButton' => $proofButton
        ];

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->subject("Request {$this->REQUEST_TYPE}")
                ->markdown('mail.request',$this->TO_MAIL);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable    
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
