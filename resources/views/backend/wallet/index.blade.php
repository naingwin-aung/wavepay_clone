@extends('backend.layouts.app')
@section('title', 'Users Wallet')
@section('wallet_dashboard', 'active')

@section('content')
<div class="mb-4">
  <a href="{{route('wallet.addamount')}}" class="btn_theme"><i class="fas fa-plus-circle"></i> Add Amount</a>
</div>
<div class="card shadow">
    <div class="card-body" style="width: 100%">
        <table class="table table-bordered" id="datatable" style="width:100%;">
            <thead class="text-center">
                <th class="text-center no-sort no-search"></th>
                <th class="text-center no-sort">Account Person</th>
                <th class="text-center">Amount</th>
                <th class="text-center">Created At</th>
                <th class="text-center no-search hidden">Updated_at</th>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('script')
    <script>
      $(document).ready(function() {
            let table = $('#datatable').DataTable( {
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "/wallet/datatable/ssd",
                language : {
                  "processing": "<img src='/images/loading.gif' width='65px'/><p>Loading...</p>",
                  "paginate" : {
                    "previous" : '<i class="fas fa-caret-left"></i>',
                    "next" : '<i class="fas fa-caret-right"></i>',
                  }
                },
                columns : [
                  {data: 'plus-icon', name: 'plus-icon', class: 'text-center'},
                  {data: 'account_person', name: 'account_person', class: 'text-center'},
                  {data: 'amount', name: 'amount', class: 'text-center'},
                  {data: 'created_at', name: 'created_at', class: 'text-center'},
                  {data: 'updated_at', name: 'updated_at', class: 'text-center'},
                ],
                order : [
                  [ 4, "desc" ]
                ],
                columnDefs : [
                  {
                    targets : 'hidden',
                    visible : false,
                    searchable : false,
                  },
                  {
                    targets : 'no-sort',
                    sortable : false,
                  },
                  {
                    targets : 'no-search',
                    searchable : false,
                  },
                  {
                    targets: [0],
                    class : "control"
                  },  
                ]
            });
        })
    </script>
@endsection