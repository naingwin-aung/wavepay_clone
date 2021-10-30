@extends('frontend.layouts.app')
@section('title', 'TopUp')
@section('subtitle')
    <span class="text-dark font-weight-bold h5">@lang('public.topup')</span>
@endsection

@section('content')
    <div class="topup">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div>
                    <p class="font-weight-bold">@lang('public.operator')</p>
                    <div class="d-flex justify-content-between mt-4">
                      <div>
                          <span class="operator mb-0 {{$billPhoneName === 'telenor' ? 'active' : ''}}" id="operators">@lang('public.telenor')</span>
                      </div>
                      <div>
                          <span class="operator mb-0 {{$billPhoneName === 'ooredoo' ? 'active' : ''}}" id="operators">@lang('public.ooredoo')</span>
                      </div>
                      <div>
                          <span class="operator mb-0 {{$billPhoneName === 'mpt' ? 'active' : ''}}" id="operators">@lang('public.mpt')</span>
                      </div>
                      <div>
                          <span class="operator mb-0 {{$billPhoneName === 'mytel' ? 'active' : ''}}" id="operators">@lang('public.mytel')</span>
                      </div>
                    </div>
                </div>
                <hr class="mt-4">
                
                <div class="topup_amount">
                    <h5>@lang('public.choose_topup')</h5>
                    <p class="mt-2">@lang('public.balance') {{$user->wallet ? number_format($user->wallet->amount) : '- '}} <span>@lang('public.kyat')</span></p>

                    <form action="{{route('user.topUpConfirm')}}" method="GET" id="topup" class="mt-4">
                        <input type="hidden" name="billPhoneName" value="{{$billPhoneName}}">
                        <input type="hidden" name="bill_phone" value="{{$bill_phone}}">
                        <div class="row">
                            <div class="col-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topup_amount" id="exampleRadios1" value="500">
                                    <label class="form-check-label" for="exampleRadios1">
                                      @lang('public.500')
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topup_amount" id="exampleRadios2" value="1000">
                                    <label class="form-check-label" for="exampleRadios2">
                                        @lang('public.1000')
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topup_amount" id="exampleRadios3" value="3000">
                                    <label class="form-check-label" for="exampleRadios3">
                                        @lang('public.3000')
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topup_amount" id="exampleRadios4" value="5000">
                                    <label class="form-check-label" for="exampleRadios4">
                                        @lang('public.5000')
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topup_amount" id="exampleRadios5" value="10000">
                                    <label class="form-check-label" for="exampleRadios5">
                                        @lang('public.10000')
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="number" class="form-control another_amount" name="another_topup_amount" placeholder="@lang('public.other_amount')" value="{{old('another_topup_amount')}}">
                        </div>
                        <p class="mb-2">@lang('public.enter_multiple')</p>

                        @include('frontend.layouts.flash')

                        <div class="d-flex justify-content-center mt-5">
                            <button class="btn btn_theme">@lang('public.continue')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
{!! JsValidator::formRequest('App\Http\Requests\TopUpRequest', '#topup') !!}

<script>
    $(document).ready(function() {
        $("input[type=radio]").click(function() {
           $('.another_amount').val('');
        })

        $('.another_amount').click(function() {
            $('input[type=radio]').prop('checked', false);
        })
    });
</script>
@endsection

