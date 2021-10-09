@extends('frontend.layouts.app')
@section('title', 'Transfer')
@section('subtitle', 'WavePay')

@section('content')
    <div class="transfer">
        <div class="d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('user.transferAmountForm')}}" id="transfer" autocomplete="off">
                            <div class="form-group">
                                <label>ငွေလက်ခံသူ</label>
                                <input type="number" class="form-control" name="to_phone" value="{{old('to_phone')}}><i class="fas fa-user"></i>
                            </div>
    
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
    {!! JsValidator::formRequest('App\Http\Requests\TransferFormRequest', '#transfer') !!}
@endsection