@extends('backend.layouts.app')
@section('title', 'Admin Users Management')
@section('admin_dashboard', 'active')

@section('content')
<div class="mb-4">
  <a href="{{route('admin.create')}}" class="btn_theme">Create Admin User</a>
</div>
<div class="card shadow">
    <div class="card-body">
        <table class="table table-bordered" id="datatable" style="width:100%;">
            <thead>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Created At</th>
                <th class="text-center">Action</th>
                <th class="text-center hidden">Updated_at</th>
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
                ajax: "/admin/datatable/ssd",
                language : {
                  "paginate" : {
                    "previous" : '<i class="fas fa-caret-left"></i>',
                    "next" : '<i class="fas fa-caret-right"></i>',
                  }
                },
                columns : [
                  {data: 'name', name: 'name', class: 'text-center'},
                  {data: 'email', name: 'email', class: 'text-center'},
                  {data: 'created_at', name: 'created_at', class: 'text-center'},
                  {data: 'action', name: 'action', class: 'text-center'},
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
                  }
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
                    url : `/admin/${id}`,
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