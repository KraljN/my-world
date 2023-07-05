@component('mail::message')
# Hi, {{$first_name}}

Here is reply on contact message that you submitted on our site<br/>

"{{$text}}"
<br/>

{{$response}}

Best Regards,<br/>
My World Administrator - {{$admin_username}},<br/>
<small>You can reply on this mail if you have more issues about this topic</small>
@endcomponent
