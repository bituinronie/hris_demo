@component('mail::message')
<p style="text-align: left;"><b style="text-align: left;">Hi {{ $fullName }},</b></p>

# REQUEST {{ $requestType }}

Your request for, {{ $requestType }} has been {!! $message !!}. Your approver has acknowledged the following information below:<br>

@component('mail::table')
|                        |                                   |
| ---------------------- | --------------------------------- |
| <b>Type of Request</b> | {{ $requestType }}                |
| <b>Date/s Covered</b>  | {{ $dateCovered }}                |
| <b>Credit</b>          | {{ $credit }}                     |
| <b>Reason</b>          | {{ $reason }}                     |
@endcomponent

<br><br>
<p style="text-align: left;"><b style="text-align: left;">All the best,<br>
{{ config('app.name') }} Team</b></p>
@endcomponent
