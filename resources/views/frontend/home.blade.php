@extends('frontend.layouts.app')
@section('title', 'WavePay Clone')
@section('subtitle', 'WavePay')
    
@section('user_home')
    <div class="px-2 pb-5 my-4 user_home">
        <div class="col-md-5">
            <div class="d-flex justify-conten-between">
                <a href="{{route('user.info')}}">
                    <img src="{{$auth_user->profile_img_path()}}" class="profile_img mr-3" alt="User Image">
                </a>
                <div class="user_info mt-2">
                    <h5 class="font-weight-bold">{{$auth_user->name}}</h5>
                    <h5 id="is_show" class="show toggle_wallet">***** ကျပ် <i class="fas fa-eye-slash ps-show-hide" id="toggle_btn"></i></h5>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-12">
        <div class="card shadow-sm features">
            <div class="card-body pl-1 pr-3">
                <div class="d-flex justify-content-between">
                    <a href="{{route('user.transferForm')}}" class="feature">
                        <img src="{{asset('/images/transfer.png')}}" class="mb-3" alt="">
                        <p class="mb-0">ငွေလွှဲ</p>
                    </a>
                    <a href="{{route('user.transaction')}}" class="feature">
                        <img src="{{asset('/images/transaction.png')}}" class="mb-3" alt="">
                        <p class="mb-0">စာရင်း</p>
                    </a>
                    <a href="{{route('user.topUpPhone')}}" class="feature">
                        <img src="{{asset('/images/topup.png')}}" class="mb-3" alt="">
                        <p class="mb-0">ဖုန်းငွေဖြည့်</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.ps-show-hide', function(e) {
                if($('#is_show').hasClass('show')) {
                    $('.toggle_wallet').html('');
                    $('.toggle_wallet').html('{{$auth_user->wallet ? number_format($auth_user->wallet->amount) : ' - '}} ကျပ် <i class="fas fa-eye ps-show-hide" id="toggle_btn"></i>');
                    $('#is_show').removeClass('show');
                } else if (!$('#is_show').hasClass('show')){   
                    $('.toggle_wallet').html('');
                    $('.toggle_wallet').html('***** ကျပ် <i class="fas fa-eye-slash ps-show-hide" id="toggle_btn"></i>');
                    $('#is_show').addClass('show');
                }
            })
        })
    </script>
@endsection