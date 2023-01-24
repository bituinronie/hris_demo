@component('mail::message')
<p style="text-align: left;"><b style="text-align: left;">Hi {{ $firstName }},</b></p>

# Password Reset

Here! Your new {{ config('app.name') }} password:<br>

@component('mail::panel')
{{ $newPassword }}
@endcomponent

You can now login your HRMIS account using your <br> username: <b>{{ $username }}</b> and new reset password.<br><br>

<p style="text-align: left;"><b style="text-align: left;">All the best,<br>
{{ config('app.name') }} Team</b></p>
@endcomponent
