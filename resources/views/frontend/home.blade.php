@extends('frontend.layouts.app')

@section('user_home')
    <div class="px-2 my-4 user_home">
        <div class="col-md-5">
            <div class="d-flex justify-conten-between">
                <img src="{{$auth_user->profile_img_path()}}" class="profile_img mr-3" alt="User Image">
                <div class="user_info">
                    <h5 class="font-weight-bold">{{$auth_user->name}}</h5>
                        <h5 id="is_show" class="show toggle_wallet">***** ကျပ်</h5>
                        <i class="fas fa-eye-slash ps-show-hide"></i>
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
                    <div class="feature">
                        <img src="{{asset('/images/transfer.png')}}" class="mb-3" alt="">
                        <p class="mb-0">ငွေလွှဲ</p>
                    </div>
                    <div class="feature">
                        <img src="{{asset('/images/transaction.png')}}" class="mb-3" alt="">
                        <p class="mb-0">စာရင်း</p>
                    </div>
                    <div class="feature">
                        <img src="{{asset('/images/wallet.png')}}" class="mb-3" alt="">
                        <p class="mb-0">ငွေသွင်း/ထုတ်</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('.ps-show-hide').click(function() {
                if($('#is_show').hasClass('show')) {
                    $('.ps-show-hide').removeClass('fa-eye-slash').addClass('fa-eye');
                    $('.toggle_wallet').html('');
                    $('.toggle_wallet').html('{{$auth_user->wallet ? number_format($auth_user->wallet->amount) : ' - '}} ကျပ်');
                    $('#is_show').removeClass('show');
                } else if(!$('#is_show').hasClass('show')) {
                    $('.ps-show-hide').removeClass('fa-eye').addClass('fa-eye-slash');
                    $('.toggle_wallet').html('');
                    $('.toggle_wallet').html('***** ကျပ်');
                    $('#is_show').addClass('show');
                }
            }) 
        })
    </script>
@endsection