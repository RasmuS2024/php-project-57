<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Сброс пароля</title>
</head>
<body>
    <h1>Сброс пароля</h1>
    <p>Вы получили это письмо, потому что был запрошен сброс пароля для вашей учетной записи.</p>
    
    <p>Ссылка для сброса пароля:</p>
    <a href="{{ url('password/reset/'.$token) }}">Сбросить пароль</a>
    
    <p>Если вы не запрашивали сброс пароля, проигнорируйте это письмо.</p>
    <p>Ссылка действительна в течение {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} минут.</p>
</body>
</html>
