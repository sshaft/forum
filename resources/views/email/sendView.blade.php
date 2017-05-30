@component('mail::message')
#Email Verify

Hi. Thank you so much for registerd to my Site!
for our safe we didn't allow user that can't verify her mail, so please click on the button!
<a href="{{route('sendEmailDone',["email" => $user->email,"verifyToken" => $user->verifyToken])}}">click here</a></h1>

@component('mail::panel')
Our Team thanks you!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
