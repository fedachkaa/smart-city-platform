<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
<h1>Login</h1>

<form method="POST" action="{{ route('login.post') }}">
    @csrf

    <div>
        <label for="email">Email Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @error('email')
            <p style="color: red;">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
        @error('password')
            <p style="color: red;">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <button type="submit">Login</button>
    </div>

    @if (session('status'))
        <p style="color: green;">{{ session('status') }}</p>
    @endif

    @if ($errors->has('loginError'))
        <p style="color: red;">{{ $errors->first('loginError') }}</p>
    @endif
</form>
</body>
</html>