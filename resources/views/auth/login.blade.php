@extends('backend.layouts.app_plain')
@section('title', 'Login User')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh">
        <div class="col-md-7">
            <div class="card p-3">
                <div class="card-body">
                    <div class="mb-4 ml-3">
                        <h4 class="text-primary">Login</h4>
                        <p class="text-muted mt-3">Sign in Your Wave Pay Account</p>
                    </div>
                    <form method="POST" action="{{ route('login') }}" autocomplete="off" class="user_login">
                        @csrf

                        <div class="form-group">
                            <label for="phone" class="col-md-4 col-form-label">{{ __('Phone Number') }}</label>

                            <div class="col-md-12">
                                <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 col-form-label">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between ml-3 mt-4">
                            <div class="mt-3">
                                <a href="{{route("register")}}">Create New Account?</a>
                            </div>
                            <div>
                                <button type="submit" class="btn_theme">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
