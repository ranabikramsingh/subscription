<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
     <style>
        .button-container {
            text-align: center;
        }
        .button-container a {
            text-decoration: none;
        }
     </style>

</head>

<body class="antialiased">
    <h2>Welcome to my page</h2>
    <div class="button-container">
        <button><a href="{{ route('subscriptions.list') }}">Create Plan</a></button>
        <button><a href="{{ route('subscriptions.list') }}">Buy Plan</a></button>
    </div>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

</body>


</html>
