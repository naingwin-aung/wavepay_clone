@extends('frontend.layouts.app_plain')
@section('title', 'Register User')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh">
        <div class="col-md-7 my-4">
            <div class="card p-3">
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="text-primary">Register</h4>
                        <p class="text-muted mt-3">Sign Up Your Wave Pay Account</p>
                    </div>
                    <form method="POST" action="{{ route('register') }}" autocomplete="off" class="user_login" id="register">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control">    
                        </div>   
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control">    
                        </div>   
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="number" name="phone" class="form-control">    
                        </div>   
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control">    
                        </div>   
                        <div class="form-group">
                            <label for="name">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">    
                        </div>                        

                        <div class="d-flex justify-content-between ml-3 mt-4">
                            <div class="mt-3">
                                <a href="{{route("login")}}">Already have a account?</a>
                            </div>
                            <div>
                                <button type="submit" class="btn_theme">
                                    {{ __('Register') }}
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
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\RegisterUserRequest', '#register') !!}
@endsection
