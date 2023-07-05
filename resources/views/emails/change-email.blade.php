@component('mail::message')
# Hi, {{$first_name}}

You changed email<br/>
Please click on button bellow to confirm it!

@component('mail::button', ['url' => \Illuminate\Support\Facades\URL::signedRoute('email.change.confirm', ['id' => $user_id, 'hash' => sha1('email_hash'), 'email' => $new_email])])
    Confirm Mail
@endcomponent

My World,<br/>
<small>This is an automatically generated email, please do not reply directly to this email.</small>
@endcomponent
