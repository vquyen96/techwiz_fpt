<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>You have new private message</p>
<p>-----</p>
<p>Go <a href="{{ asset('/') }}">RMT</a> website to reply you conversation</p>
<p>Or go conversation detail in <a href="{{ asset('conversation/detail?id='.$private_message->conversation_id) }}">HERE</a></p>
</body>
</html>