<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>If you have received the goods, please let us know at <a href="{{ asset('product/'.$product->id) }}"> RMT </a></p>
<p>-----</p>
<p>If you have not received the goods, please contact the <a href="{{ asset('product/'.$product->id) }}"></a> buyer.</p>
<p>Or contact <a href="{{ asset('add-ticket') }}"></a> us </p>
</body>
</html>