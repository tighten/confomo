<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!--Sorry! :( -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>ConFOMO - Don't forget to meet your friends</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <link href="/css/app.css" rel="stylesheet">

    <script>
        window.Confomo = {
            userId: {{ Auth::check() ? Auth::id() : 'null' }},
            csrfToken: '{{ csrf_token() }}'
        };
    </script>
</head>
<body>
    @include('partials.navbar')

    @yield('content')

    <script src="/js/app.js"></script>
</body>
</html>
