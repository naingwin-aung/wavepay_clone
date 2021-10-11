@extends('frontend.layouts.app')
@section('title', 'TopUp')
@section('subtitle')
    <span class="text-dark font-weight-bold h5">ဖုန်းငွေဖြည့်</span>
@endsection

@section('content')
    <div class="topup">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <h6 class="text-center mb-3">သင့်ဖုန်းကို bill ထည့်နိုင်သည်။</h6>
                <div>
                    <p class="font-weight-bold">အော်ပရေတာ</p>
                    <div class="d-flex justify-content-between mt-4">
                      <div>
                          <span class="operator mb-0 {{$userPhoneName === 'telenor' ? 'active' : ''}}">Telenor</span>
                      </div>
                      <div>
                          <span class="operator mb-0  {{$userPhoneName === 'ooredoo' ? 'active' : ''}}">Ooredoo</span>
                      </div>
                      <div>
                          <span class="operator mb-0 {{$userPhoneName === 'mpt' ? 'active' : ''}}">MPT</span>
                      </div>
                      <div>
                          <span class="operator mb-0 {{$userPhoneName === 'mytel' ? 'active' : ''}}">Mytel</span>
                      </div>
                    </div>
                </div>
                <hr class="mt-4">
                
                <div class="topup_amount">
                    <h5>ငွေပမာဏထည့်ပါ</h5>
                    <p class="mt-3">လက်ကျန်ငွေ {{$user->wallet ? number_format($user->wallet->amount) : '- '}} ကျပ်</p>

                    <form action="{{route('user.topUp')}}" method="POST" id="topup">
                        @csrf
                        <div class="row">
                            <div class="col-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topup_amount" id="exampleRadios1" value="500">
                                    <label class="form-check-label" for="exampleRadios1">
                                      500
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topup_amount" id="exampleRadios2" value="1000">
                                    <label class="form-check-label" for="exampleRadios2">
                                        1,000
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topup_amount" id="exampleRadios3" value="3000">
                                    <label class="form-check-label" for="exampleRadios3">
                                        3,000
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topup_amount" id="exampleRadios4" value="5000">
                                    <label class="form-check-label" for="exampleRadios4">
                                        5,000
                                    </label>
                                </div>
                            </div>
                            <div class="col-4 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="topup_amount" id="exampleRadios5" value="10000">
                                    <label class="form-check-label" for="exampleRadios5">
                                        10,000
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="number" class="form-control another_amount" name="another_topup" placeholder="အခြားပမာဏ">
                        </div>

                        @include('frontend.layouts.flash')

                        <div class="d-flex justify-content-center mt-5">
                            <button class="btn btn_theme">သေချာပါသည်။</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')

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

