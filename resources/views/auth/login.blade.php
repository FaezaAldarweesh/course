<!DOCTYPE html>
<html lang="en">
@if (Session::has('message'))
        <h1> {{session('message')}} </h1>
    @endif
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <div class="container">
        <div class="left"></div>
        <div class="right">
            <div class="login-container">
                <h2>Login</h2>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="email" name="email" placeholder="Email" required>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <input type="password" name="password" placeholder="Password" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <button type="submit">Login</button>
                </form>
                <div class="form-footer">                                                     
                    {{-- <div>
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember Me</label>
                    </div> --}}
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                @endif                                                              
                </div>
            </div>
        </div>
    </div>
</body>
</html>

