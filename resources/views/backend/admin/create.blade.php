@extends('backend.layouts.app')
@section('title', 'Admin User Create')
@section('admin_dashboard', 'active')

@section('content')
    <div class="d-flex justify-content-center create_form">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{route('admin.store')}}" method="POST" autocomplete="off" id="admin_create" enctype="multipart/form-data">
                        @csrf
                        @include('backend.layouts.flash')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">Phone</label>
                            <input type="number" name="phone" class="form-control">
                        </div>
                        <div class="form-group mb-0">
                            <label for="name">Profile Img For Admin User</label>
                        </div>
                        <input type="file" name="profile_img" id="profile_img">

                        <div class="preview_img">
                            
                        </div>

                        <div class="form-group mt-3">
                            <label for="name">Password</label>
                            <input type="password" name="password" class="form-control pswField">
                        </div>
                        <div class="form-group">
                            <label for="name">Confirm Password</label>
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
                            <a href="#" class="btn_back">Back</a>
                            <button type="submit" class="btn_theme">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\StoreAdminRequest', '#admin_create') !!}
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