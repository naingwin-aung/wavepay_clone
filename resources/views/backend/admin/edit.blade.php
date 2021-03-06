@extends('backend.layouts.app')
@section('title', 'Admin User Edit')
@section('admin_dashboard', 'active')

@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="{{route('admin.update', $admin->id)}}" method="POST" autocomplete="off" id="admin_update" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{$admin->name}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="email" name="email" class="form-control" value="{{$admin->email}}">
                        </div>
                        <div class="form-group">
                            <label for="name">Phone</label>
                            <input type="number" name="phone" class="form-control" value="{{$admin->phone}}">
                        </div>
                        <div class="form-group mb-0">
                            <label for="name">Profile Img For Admin User</label>
                        </div>
                        <input type="file" name="profile_img" id="profile_img">

                        <div class="preview_img">
                            @if ($admin->profile_img)
                                <img src="{{$admin->profile_img_path()}}" alt="">
                            @endif
                        </div>

                        <div class="form-group">
                            <p for="name">Password</p>
                            <input type="password" name="password" class="form-control">
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
    {!! JsValidator::formRequest('App\Http\Requests\UpdateAdminRequest', '#admin_update') !!}
    <script>
        $(document).ready(function() {
            $('#profile_img').on('change', function() {
                let file_length = document.getElementById('profile_img').files.length;
                $('.preview_img').html('');
                for(i = 0; i < file_length ; i++) {
                    $('.preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}" />`)
                }
            })
        })
    </script>
@endsection