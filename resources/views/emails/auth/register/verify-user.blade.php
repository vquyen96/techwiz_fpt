<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>

<body>
    <h2>Hi {{$name}}! Welcome to the site</h2>
    <br/>
    Your registered email is {{$email}} , Please click on the below link to verify your email account
    <br/>    
    <a href="{{url('/user/verify?token=')}}{{$token}}">Verify Email</a>
</body>

</html>
