    <!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>You have new conversation</p>
<p>-----</p>
<p>{{ $conversation->toUser->name }} create new conversation for you</p>
<p>Go <a href="{{ asset('/') }}">RMT</a> website to reply you conversation</p>
<p>Or go conversation detail in <a href="{{ asset('conversation/detail?id='.$conversation->id) }}">HERE</a></p>
</body>
</html>