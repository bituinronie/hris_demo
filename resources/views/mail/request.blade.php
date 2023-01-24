@component('mail::message')
<p style="text-align: left;"><b style="text-align: left;">Hi {{ $fullName }},</b></p>

# REQUEST {{ $requestType }}

You received a REQUEST from your personnel, Please be informed that a personnel under your office has filed a request for your approval:<br>

@component('mail::table')
|                        |                                   |
| ---------------------- | --------------------------------- |
| <b>Requested by</b>    | {{ $requestBy }}<br>{{ $info }}   |
| <b>Type of Request</b> | {{ $requestType }}                |
| <b>Date/s Covered</b>  | {{ $dateCovered }}                |
| <b>Credit</b>          | {{ $credit }}                     |
| <b>Proof Type</b>      | {{ $proofType }}                  |
| <b>Proof</b>           | {!! $proofButton !!}              |
@endcomponent

<b>NOTE:</b> This request shall be automatically approved if not acted upon within five (5) days. To see further details, login to your {{ config('app.name') }} account <a href="{{ env('APP_URL') }}">here.</a><br><br>

{!! $buttons !!}

<br><br>
<p style="text-align: left;"><b style="text-align: left;">All the best,<br>
{{ config('app.name') }} Team</b></p>
@endcomponent
