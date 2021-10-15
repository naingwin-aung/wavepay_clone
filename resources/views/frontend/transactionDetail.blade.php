@extends('frontend.layouts.app')
@section('title', 'Transfer Detail')
@section('subtitle', 'WavePay')

@section('content')
    <div class="transaction_detail mt-5">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body pb-5">
                        <div class="text-center success mb-4">
                            <img src="{{asset('images/checked.png')}}" alt="check">
                        </div>
                        <div class="text-center mb-4">
                            <h5 class="mb-3">အောင်မြင်ပါတယ်</h5>
                            <h4 class="mb-4"><span class="text-primary">{{number_format($transaction->trx_amount)}}</span> ကျပ်</h4>
                            @if ($transaction->type == 'income')
                                <h5 class="mb-4">မှ</h5>
                            @else
                                <h5 class="mb-4">သို့</h5>
                            @endif
                            <h4 class="font-weight-bold">{{$transaction->source ? str_replace(0, '', $transaction->source->phone) : ' - '}}</h4>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6 pl-3">
                                <p class="mb-0">ငွေပမာဏ</p> 
                            </div>
                            <div class="col-6 text-right">
                                <p class="eng_letter mb-0"><span class="font-weight-bold">{{number_format($transaction->trx_amount)}}</span> ကျပ်</p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-6 pl-3">
                                <p class="mb-0">နေ့စွဲ</p> 
                            </div>
                            <div class="col-6 text-right">
                                <p class="eng_letter mb-0"><span class="font-weight-bold">{{$transaction->created_at->toFormattedDateString()}}</span></p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-6 pl-3">
                                <p class="mb-0">လုပ်ငန်းစဥ်အမှတ်</p> 
                            </div>
                            <div class="col-6 text-right">
                                <p class="eng_letter mb-0"><span class="font-weight-bold trx_id">{{$transaction->trx_id}}</span></p>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <a href="{{route('user.home')}}" class="btn btn_theme">အိုကေ</a>                
                </div>
            </div>
        </div>
    </div>
@endsection