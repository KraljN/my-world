@component('mail::message')
# Hi, {{$first_name}}

You have been registered to My World!<br/>
Please click on button bellow to activate your account

@component('mail::button', ['url' => \Illuminate\Support\Facades\URL::signedRoute('verification.verify', ['id' => $user_id, 'hash' => sha1('email_hash')])])
Activate Account
@endcomponent

My World,<br/>
<small>This is an automatically generated email, please do not reply directly to this email.</small>
@endcomponent
