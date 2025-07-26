<!-- resources/views/auth/forgot_password.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Forgot Password</title>
    <style>
        /* Basic styling */
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { max-width: 400px; margin: auto; }
        input { display: block; width: 100%; margin-bottom: 10px; padding: 8px; }
        button { padding: 10px 20px; }
        .error { color: red; }
        .status { color: green; }
    </style>
</head>
<body>
    <h2>Forgot Password</h2>

    @if(session('status'))
        <p class="status">{{ session('status') }}</p>
    @endif

    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <input type="email" name="email" placeholder="Your registered email" value="{{ old('email') }}" required>
        <button type="submit">Send Password Reset Link</button>
    </form>

    <p><a href="{{ route('login') }}">Back to Login</a></p>
</body>
</html>