@extends('layouts.app')

@section('content')
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm  justify-content-between fixed-top" style="background-color: #272E3F !important">
    <a class="navbar-brand" style="color: #bac1c7">
        <img src="/favicon.ico" width="25" height="25" class="d-inline-block align-top" alt=""> &nbsp;{{ config('app.name', 'ABTC-SORSOGON') }}</a>
    <form class="form-inline" action="/">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Home</button>
    </form>
</nav>
<div class="container" style="margin-top: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="background-color:#e4e5e9; height:140px; position: absolute; bottom:0%; width:100%; border-top:1px solid #ccc8c8;" class="d-none d-sm-block d-sm-none"></div>
<footer class="footer" style="position: absolute; bottom:0%;   width:100%; border-top:1px solid rgba(0,0,0,0.08); background-color: #272E3F !important">
    <span style="font-size: 0.7rem; padding-left:15px; color:#bac1c7">
        ?? {{ now()->year }} Copyright
    </span>
</footer>
@endsection
