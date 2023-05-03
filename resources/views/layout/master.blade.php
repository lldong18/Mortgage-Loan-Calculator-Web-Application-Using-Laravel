<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <style>
        body {
            font-family: 'Noto Sans', sans-serif;
            background-color: #ededed;
        }

        .table {
            --bs-table-striped-bg: #f7f7f7;
        }

        .table tr:last-child td {
            border-bottom: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="py-5 text-center">
        @yield('header')
    </div>
    @yield('main')
    <div class="text-center small my-5 opacity-50">
        <div>Developed for <b>Info Websight EDM Solutions</b> &reg;</div>
        <div class="mb-3">by <b>Ehsan Marufiazar</b> &ndash; May 3<sup>rd</sup>, 2023</div>
        <div class="small" style="color:gray;">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </div>
    </div>
</div>
</body>
</html>
