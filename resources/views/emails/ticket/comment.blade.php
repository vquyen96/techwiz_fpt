<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>You have new ticket comment</p>
<p>-----</p>
<p>Go <a href="{{ asset('/') }}">RMT</a> website to reply you ticket</p>
<p>Or go ticket detail in <a href="{{ asset('ticket?id='.$ticket->id) }}">HERE</a></p>
</body>
</html>