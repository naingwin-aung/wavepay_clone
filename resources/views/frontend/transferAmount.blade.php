@extends('frontend.layouts.app')
@section('title', 'Transfer Amount')
@section('subtitle', 'WavePay')

@section('content')
    <div class="transfer_amount">
        <a href="#" class="btn_back">
            <i class="fas fa-arrow-left mb-4 ml-3"></i>
        </a>
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('user.transferConfirmForm')}}" id="transfer_amount" autocomplete="off" method="GET">
                            <input type="hidden" name="to_phone" value="{{$to_account->phone}}">
                            <div class="form-group">
                                <label>ငွေပမာဏ</label>
                                <input type="number" class="form-control" name="amount" value="{{old('amount')}}">
                            </div>
                            
                            <p class="mb-4">
                                လက်ကျန်ငွေ - <span class="eng_letter text-primary">{{$from_account->wallet ? number_format($from_account->wallet->amount) : ' - '}} ကျပ်</span> 
                            </p>
                            <button type="submit" class="btn btn-primary btn-block">ရှေ့ဆက်ရန်</button>
                        </form>

                        @if ($errors->any())
                            <div class="card mt-3 border-danger">
                                <div class="card-body">
                                    @foreach ($errors->all() as $error)
                                        <div class="text-center">
                                            <p class="mb-0">{{$error}}</p>                                    
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\TransferAmountFormRequest', '#transfer_amount') !!}
@endsection