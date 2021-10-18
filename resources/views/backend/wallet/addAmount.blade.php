@extends('backend.layouts.app')
@section('title', 'Add Amount')
@section('wallet_dashboard', 'active')

@section('content')
<div class="content py-3 table__width">
    <div class="card">
        <div class="card-body">
            @include('backend.layouts.flash')
            <form action="{{route('wallet.addAmountuser')}}" method="POST" id="store">
                @csrf
                @include('backend.layouts.flash')
                <div class="form-group">
                    <label for="">User</label>
                    <select name="user_id" id="" class="form-control user_id">
                        <option value="">--- Please Choose ----</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->name}} ({{$user->phone}})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="">Amount</label>
                    <input type="number" name="amount" class="form-control">
                </div>

                <div class="d-flex justify-content-between">
                    <a href="#" class="btn_back">Back</a>
                    <button type="submit" class="btn_theme">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
{!! JsValidator::formRequest('App\Http\Requests\AddAmountRequest', '#store') !!}

<script>
    $(document).ready(function() {
        $('.user_id').select2({
            theme: 'bootstrap4',
            placeholder: "--- Please Choose ---",
            allowClear: true
        });
    });
</script>
@endsection