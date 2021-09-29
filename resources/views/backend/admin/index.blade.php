@extends('backend.layouts.app')
@section('title', 'Admin Users Management')
@section('admin_dashboard', 'active')

@section('content')
<div class="card shadow"  >
    <div class="card-body">
        <table class="table table-bordered" id="datatable" style="width:100%;">
            <thead>
                <th class="text-center">Name</th>
                <th class="text-center">Email</th>
                <th class="text-center">Created At</th>
                <th class="text-center hidden">Updated_at</th>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('script')
    <script>
      $(document).ready(function() {
          $('#datatable').DataTable( {
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
                {data: 'updated_at', name: 'crated_at', class: 'text-center'},
              ],
              columnDefs : [
                {
                  targets : 'hidden',
                  visible : false,
                  searchable : false,
                }
              ]
          } );
      } );
    </script>
@endsection