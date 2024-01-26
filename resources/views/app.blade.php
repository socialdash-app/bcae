<!doctype html>
<html lang="en" style="overflow:hidden">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, height=device-height, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>Document</title>
    @production
        @vite(['resources/js/app.js','resources/css/app.css'])
    @endproduction
    @env('local')
        <script type="module" src="http://172.18.0.1:5173/@@vite/client"></script>
        <script type="module" src="http://172.18.0.1:5173/resources/js/app.js"></script>
        <link rel="stylesheet" href="http://172.18.0.1:5173/resources/css/app.css"/>
    @endenv
    {{--       <script type="module" src="http://192.168.110.234:5173/@@vite/client"></script>--}}
    {{--       <script type="module" src="http://192.168.110.234:5173/resources/js/app.js"></script>--}}
    {{--       <link rel="stylesheet" href="http://192.168.110.234:5173/resources/css/app.css"/>--}}
    @inertiaHead
</head>

<body>
@inertia
</body>

</html>
