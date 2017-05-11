Hi {{ $full_name }}, <br/><br/>
Click here to reset password <a href="{{ $link = route('resetPassword', $token) }}"> {{ $link }} </a>
<br/><br/>
Regards, <br/>
inSpree Team