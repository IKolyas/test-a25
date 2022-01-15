<?php
$message =
'<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Письмо от клиента -
        ' . $request->user_name . '
    </title>
</head>
<body>
<p>Имя: ' . $request->user_name . '</p>
<p>Телефон: ' . $request->user_phone . '</p>
<p>E-mail: ' . $request->user_mail . '</p>
</body>
</html>';