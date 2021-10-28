@extends('frontend.layouts.app')
@section('title', 'Top Up')
@section('subtitle', 'WavePay')

@section('content')
    <div class="topup-phone">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('user.topUp')}}" id="topUp_phone" autocomplete="off">
                            <div class="form-group">
                                <label>@lang('public.top_up_phonenumber')</label>
                                <input type="number" class="form-control" name="bill_phone" value="{{old('bill_phone', $user->phone)}}">
                            </div>
    
                            <button type="submit" class="btn btn-primary btn-block">@lang('public.continue')</button>
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
    {!! JsValidator::formRequest('App\Http\Requests\TopUpPhoneRequest', '#topUp_phone') !!}
@endsection