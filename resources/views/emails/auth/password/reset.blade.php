<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>

<body>
    <h2>Hi {{$name}}!</h2>
    <br/>
    Please click on the below link to reset your password
    <br/>    
    <a href="{{url('/user/reset-password?token=')}}{{$token}}">Reset Password</a>
</body>

</html>
