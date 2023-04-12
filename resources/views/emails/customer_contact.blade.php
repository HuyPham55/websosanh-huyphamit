<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
<main>
    <?php
        $buttonStyle = "border-radius:4px;color:#fff;display:inline-block;text-decoration:none;background-color:#2d3748;border-bottom:8px solid #2d3748;border-left:18px solid #2d3748;border-right:18px solid #2d3748;border-top:8px solid #2d3748";
    ?>
    <p style="text-align: center"><b>Name: </b>{{ data_get($data, 'name') }}</p>
    <p style="text-align: center"><b>Message: </b>{{ data_get($data, 'message') }}</p>
    <p style="text-align: center">
        <a href="{{url('/')}}" style="{{$buttonStyle}}">
            {{config('app.name')}}
        </a>
    </p>
</main>
</body>
</html>
