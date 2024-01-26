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
    <title>Before the Coup, After the Election</title>
    <meta name="keywords"
          content="before the coup, after the election, myanmar, 2021 coup, myanmar election">
    <meta itemprop="name" content="Before The Coup, After The Election">
    <meta itemprop="description" content="Data Story from Frontier Myanmar's Social Dash">
    <link rel="canonical" href="https://public.socialdash.app/bcae">
    <link rel="social dash icon" type="image/jpg" href="https://socialdash.app/images/logo.png">
    <link rel="apple-touch-icon" href="https://socialdash.app/images/logo.png">
    @production
        @vite(['resources/js/app.js','resources/css/app.css'])
    @endproduction
    @env('local')
        <script type="module" src="http://192.168.1.111:5173/@@vite/client"></script>
        <script type="module" src="http://192.168.1.111:5173/resources/js/app.js"></script>
        <link rel="stylesheet" href="http://192.168.1.111:5173/resources/css/app.css"/>
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
