Для востановления пароля перейдите по ссылке ниже: <br>
<a href="{{ $link = url('recovery', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}">{{ $link }}</a>