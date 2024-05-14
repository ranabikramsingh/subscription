<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
  
</head>

<body class="antialiased">
    <h2>Welcome to Login Page</h2>
  
  
    <!-- login.blade.php -->
    <div class="loginForm">
        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
    @if (session('loginerror'))
        <div class="alert alert-danger">
            {{ session('loginerror') }}
        </div>
    @endif


</body>


</html>
