@extends('frontend.layouts.app')

@section('content')
    <div class="user_info">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                @if (session('update_password'))
                    <div class="alert alert-success alert-dismissible fade show p-0" role="alert">
                        <div class="my-3 text-center">
                            {{ session('update_password') }}
                        </div>
                        <button type="button" class="close pt-2" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                 <div class="text-center mb-3">
                     <img src="{{$auth_user->profile_img_path()}}" alt="user Image" class="profile_img mb-2">
                     <p class="font-weight-bold">{{$auth_user->name}}</p>
                 </div>
     
                 <div class="card bordered shadow-sm mb-3">
                     <div class="card-body">
                         <div class="row">
                             <div class="col-6 pr-0">
                                 <p class="mb-0 mr-3 text-right">လက်ကျန်ငွေ</p>
                             </div>
                             <div class="col-6 pl-0">
                                 <p class="mb-0 mr-3 eng_letter">{{$auth_user->wallet ? number_format($auth_user->wallet->amount) : ' - '}} ကျပ်</p>
                             </div>
                         </div>
                     <hr>
                         <div class="row">
                             <div class="col-6 pr-0">
                                 <p class="mb-0 mr-3 text-right">ဖုန်းနံပါတ်</p>
                             </div>
                             <div class="col-6 pl-0">
                                 <p class="mb-0 mr-3 eng_letter" >{{$auth_user->phone}}</p>
                             </div>
                         </div>
                     <hr>
                         <div class="row">
                             <div class="col-6 pr-0">
                                 <p class="mb-0 mr-3 text-right">အီးလ်မေး</p>
                             </div>
                             <div class="col-6 pl-0">
                                 <p class="mb-0 mr-3 eng_letter">{{$auth_user->email}}</p>
                             </div>
                         </div>
                     </div>
                 </div>
             
                 <div class="card mt-2">
                     <div class="card-body">
                         <a href="{{route('user.update_passwordform')}}" class="mb-0"><i class="fas fa-caret-right mr-4"></i> ကိုယ်ရေးအချက်အလက်များ ပြင်ဆင်မည်။</a>
                     </div>
                 </div>
             </div>
        </div>
    </div>
@endsection