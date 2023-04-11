<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            background: #EFEFEF;
        }
    </style>
    <title></title>
</head>
<body>
<main>
    <p><b>Name: </b>{{ data_get($data, 'name') }}</p>
    <p><b>E-Mail: </b>{{ data_get($data, 'email') }}</p>
    <p><b>Message: </b>{{ data_get($data, 'message') }}</p>
    <p><b>Date: </b>{{ date('Y/m/d H:i:s') }}</p>
</main>
</body>
</html>
