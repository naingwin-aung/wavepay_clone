@extends('frontend.layouts.app')
@section('title', 'Transaction')
@section('subtitle')
    <span class="text-dark">စာရင်း</span>
@endsection

@section('content')
    <div class="transaction">
        <div class="d-flex justify-content-center">
            <div class="col-md-8 p-0">
                @foreach ($transactions as $transaction)
                    <div class="card">
                        <div class="card-body py-3 px-3">
                            <p class="mb-2 font-weight-bold">{{$transaction->created_at->toFormattedDateString()}}</p>
                            <div class="row">
                                <div class="col-1">
                                    @if ($transaction->type == 'expense')
                                        <img src="{{asset('/images/transfer.png')}}" alt="money transfer" class="mt-1" width="25px">
                                    @else 
                                        <img src="{{asset('/images/arrow.png')}}" alt="money transfer" class="mt-2" width="20px">
                                    @endif
                                </div>
                                <div class="col-7 ml-4 px-0">
                                   @if ($transaction->type == 'income')
                                        <p class="mb-1 font-weight-bold">ငွေသွင်း</p>
                                   @else @if ($transaction->type == 'expense')
                                        <p class="mb-1 font-weight-bold">ငွေလွှဲ</p>
                                    @endif
                                   @endif

                                   <p class="mb-1">{{$transaction->type == 'income' ? 'မှ' : 'သို့'}} - <span class="eng_letter">{{$transaction->source ? $transaction->source->phone : ' - '}}</span></p>
                                   <p class="mb-1">လုပ်ငန်းစဥ်အမှတ်- {{$transaction->trx_id}}</p>
                                </div>
                                <div class="col-3 px-0 text-right">
                                    @if ($transaction->type == 'income')
                                        <p><span class="text-primary">+{{number_format($transaction->trx_amount)}} ကျပ်</span></p>
                                   @else @if ($transaction->type == 'expense')
                                        <p><span class="text-danger">-{{number_format($transaction->trx_amount)}} ကျပ်</span></p>
                                    @endif
                                   @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
