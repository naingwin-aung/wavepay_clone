@extends('frontend.layouts.app')
@section('title', 'TopUp Detail')
@section('subtitle', 'WavePay')

@section('content')
    <div class="topup_detail mt-3">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body pb-5">
                        <div class="text-center success mb-4">
                            <img src="{{asset('images/checked.png')}}" alt="check">
                        </div>
                        <div class="text-center mb-4">
                            <h4 class="mb-4">@lang('public.successful')</h4>
                            <h4 class="mb-3"><span class="text-primary">{{number_format($transaction->bill_amount)}}</span> <span>@lang('public.kyat')</span></h4>
                            <h5 class="mb-3">@lang('public.for')</h5>
                            <h4 class="font-weight-bold">{{str_replace(0, '', $transaction->bill_phonenumber)}}</h4>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6 pl-3">
                                <p class="mb-0">@lang('public.amount')</p>
                            </div>
                            <div class="col-6 text-right">
                                <p class="eng_letter mb-0"><span class="font-weight-bold">{{number_format($transaction->bill_amount)}}</span> <span>@lang('public.kyat')</span></p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6 pl-3">
                                <p class="mb-0">@lang('public.operator')</p>
                            </div>
                            <div class="col-6 text-right">
                                <p class="eng_letter mb-0"><span class="font-weight-bold">{{ucfirst($transaction->operator_name)}}</span></p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-6 pl-3">
                                <p class="mb-0">@lang('public.date')</p> 
                            </div>
                            <div class="col-6 text-right">
                                <p class="eng_letter mb-0"><span class="font-weight-bold">{{$transaction->created_at->toFormattedDateString()}}</span></p>
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-6 pl-3">
                                <p class="mb-0">@lang('public.transaction_id')</p> 
                            </div>
                            <div class="col-6 text-right">
                                <p class="eng_letter mb-0"><span class="font-weight-bold trx_id">{{$transaction->trx_id}}</span></p>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <a href="{{route('user.home')}}" class="btn btn_theme">@lang('public.ok')</a>                
                </div>
            </div>
        </div>
    </div>
@endsection