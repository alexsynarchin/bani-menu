<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/assets/site/css/fonts.css">
    <link rel="stylesheet" type="text/css" href="/assets/site/css/bootstrap-short.css">
    <link rel="stylesheet" type="text/css" href="/assets/site/css/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="/assets/site/css/style.css">
    <link href="{{mix('css/app.css', 'assets/site')}}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{URL::asset('images/favicon.png')}}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <title>Ресторан "Вкусняшка"</title>

</head>
<body>
<div id="app">
    <app></app>
</div>
<script src="{{ mix('js/app.js','assets/site') }}?ver=11"></script>
</body>
</html>
