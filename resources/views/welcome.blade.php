<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Welcome to OLX</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; background-color: #f5f5f5; }
        h1 { font-size: 2.5em; margin-bottom: 20px; }
        a {
            display: inline-block;
            margin: 10px 20px;
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-size: 1.2em;
        }
        a:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <h1>Welcome to OLX</h1>
    <p>Your trusted platform to buy and sell</p>
    <div>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
        {{-- <a href="{{ route('ads.create') ?? '#' }}">Post Your Ad</a> --}}
        <a href="#">Post Your Ad</a>
    </div>
</body>
</html>