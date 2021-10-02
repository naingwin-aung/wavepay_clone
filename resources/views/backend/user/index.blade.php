@extends('backend.layouts.app')
@section('title', 'Users Management')
@section('user_dashboard', 'active')

@section('content')
<div class="mb-4">
  <a href="{{route('user.create')}}" class="btn_theme">Create User</a>
</div>
<div class="card shadow">
    <div class="card-body" style="width: 100%">
        <table class="table table-bordered" id="datatable" style="width:100%;">
            <thead class="text-center">
                <th class="text-center no-sort no-search"></th>
                <th class="text-center no-sort">User Profile</th>
                <th class="text-center no-sort">Email</th>
                <th class="text-center no-sort">Phone</th>
                <th class="text-center no-sort no-search">User Agent</th>
                <th class="text-center">Created At</th>
                <th class="text-center no-sort no-search">Action</th>
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
                ajax: "/user/datatable/ssd",
                language : {
                  "processing": "<img src='/images/loading.gif' width='65px'/><p>Loading...</p>",
                  "paginate" : {
                    "previous" : '<i class="fas fa-caret-left"></i>',
                    "next" : '<i class="fas fa-caret-right"></i>',
                  }
                },
                columns : [
                  {data: 'plus-icon', name: 'plus-icon', class: 'text-center'},
                  {data: 'profile', name: 'profile', class: 'text-center'},
                  {data: 'email', name: 'email', class: 'text-center'},
                  {data: 'phone', name: 'phone', class: 'text-center'},
                  {data: 'user_agent', name: 'user_agent', class: 'text-center'},
                  {data: 'created_at', name: 'created_at', class: 'text-center'},
                  {data: 'action', name: 'action', class: 'text-center'},
                  {data: 'updated_at', name: 'updated_at', class: 'text-center'},
                ],
                order : [
                  [ 7, "desc" ]
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

            $(document).on('click', '.delete_btn', function(e) {
              e.preventDefault();
              swal({
                text: "Are you sure? You want to delete this user!",
                icon: "info",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                  let id = $(this).data('id');
                  $.ajax({
                    url : `/user/${id}`,
                    method : 'DELETE',
                  }).done(function(res) {
                      table.ajax.reload();
                  })
                }
              });
            })
        })
    </script>
@endsection