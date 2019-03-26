<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>Your request is expired</p>
<p>-----</p>
<p>Go <a href="{{ asset('/') }}">RMT</a> website to see your request</p>
<p>Or go request detail in <a href="{{ asset('order-product/'.$request->id) }}">HERE</a></p>
</body>
</html>