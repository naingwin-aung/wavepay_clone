@extends('frontend.layouts.app')
@section('title', 'User Change Password')

@section('content')
    <div class="d-flex justify-content-center user_update">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    
                    @include('frontend.layouts.flash')

                    <form action="{{route('user.update_password')}}" method="POST" autocomplete="off" id="update_password" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-0">
                            <label for="name">Profile Img For user User</label>
                        </div>  
                        <input type="file" name="profile_img" id="profile_img">

                        <div class="preview_img">
                            @if ($auth_user->profile_img)
                                <img src="{{$auth_user->profile_img_path()}}" alt="">
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="current">Current Password</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>

                        <div class="form-group">
                            <p for="name">Password</p>
                            <input type="password" name="password" class="form-control pswField">
                        </div>

                        <div class="form-group">
                            <p for="name">Confirm Password</p>
                            <input type="password" name="password_confirmation" class="form-control pswField">
                        </div>

                        <div class="form-group">
                            <div class="form-check" id="toggle_password">
                                <input class="form-check-input" type="checkbox" name="show_password" id="show_password">

                                <label class="form-check-label" for="show_password">
                                    {{ __('Show password') }}
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn_back text-black">Back</a>
                            <button type="submit" class="btn_theme">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\UpdatePasswordRequest', '#update_password') !!}
    <script>
        $(document).ready(function() {
            $('#profile_img').on('change', function() {
                let file_length = document.getElementById('profile_img').files.length;
                $('.preview_img').html('');
                for(i = 0; i < file_length ; i++) {
                    $('.preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" />`)
                }
            })

            $('#toggle_password').on('click', function() {
               let pswField = document.querySelectorAll('.pswField');

               if($('#show_password').is(":checked") == true) {
                    pswField.forEach(pass => {
                       if(pass.type == 'password') {
                           pass.type = 'text';
                       } 
                    });
               } else if($('#show_password').is(":checked") == false) {
                    pswField.forEach(pass => {
                        pass.type = 'password';
                    });
               }
           })
        })
    </script>
@endsection