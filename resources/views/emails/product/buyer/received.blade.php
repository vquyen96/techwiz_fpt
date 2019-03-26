<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>The product you purchased has been transferred to the received state <a href="{{ asset('product/'.$product->id) }}"> {{ $product->title }} </a></p>
<p>-----</p>
<p>If you have any questions, please contact <a href="{{ asset('add-ticket') }}"> us </a></p>
</body>
</html>