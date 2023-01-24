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

class PortalRequest extends Notification
{
    use Queueable, ConstantTrait, TokenTrait;

    public $TO_MAIL = [];
    public $REQUEST_TYPE = "";
    public $STATUS = "";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($leaveLedger)
    {
        $this->REQUEST_TYPE = $leaveLedger->requestName;

        $this->STATUS = $leaveLedger->status == 3 ? 'DISAPPROVED' : 'APPROVED';

        // message
        $message = $leaveLedger->status == 3?"<b style=\"color:#b76161;\">DISAPPROVED</b>":
                                    "<b style=\"color:#449a44;\">APPROVED</b>";


        $this->TO_MAIL = [
            'fullName' => $leaveLedger->employee->name,
            'status' => $this->STATUS,
            'dateCovered' => $leaveLedger->from->format($this->visualDateFormat)." - ".$leaveLedger->to->format($this->visualDateFormat),
            'credit' => abs($leaveLedger->credit),
            'requestType' => $leaveLedger->requestName,
            'reason' => $leaveLedger->remarks,
            'message' => $message
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
                ->subject("Request {$this->REQUEST_TYPE} - {$this->STATUS}")
                ->markdown('mail.portalrequest',$this->TO_MAIL);
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
