@extends('layouts.admin')

@section('css')
    <!-- Custom styles for this page -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('User') }}</h1>

    <div class="row">
        <div class="col-md-8">
                <!-- Collapsable Card List User -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#listuser" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">List User</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="listuser">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="DataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama User</th>
                                            <th>Email</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($users as $row)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $row->name }}</td>
                                                <td>{{ $row->email }}</td>
                                                <td>
                                                    <a href="{{ route('users.destroy', $row->id) }}" class="btn btn-sm btn-circle btn-danger delete">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach                                    
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

    </div>

@endsection
@section('javascript')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#DataTable').DataTable();
            $('.delete').on('click', function(){
                var deleteUrl = $(this).attr('href');

                swal({
                    title: "Apa kamu yakin?",
                    text: "Sekali dihapus, data tidak dapat dikembalikan!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                '_token': "{{ csrf_token() }}"
                            },
                            success:function(response)
                            {
                                if (response.success) {
                                    swal("Poof! Data telah dihapus!", {
                                        icon: "success",
                                    }).then((willDelete) => {
                                        window.location = "{{ route('users.index') }}";
                                    });
                                } else {
                                    if (response.message) {
                                        swal("Oops! " + response.message, {
                                            icon: "error",
                                        });
                                    } else {
                                        swal("Oops! Gagal menghapus data.", {
                                            icon: "error",
                                        });
                                    }
                                }
                            },
                            error: function(response) {
                                swal("Oops! Gagal menghapus data.", {
                                    icon: "error",
                                });
                            }
                        })
                    } else {
                        swal("Data batal dihapus!");
                    }
                });
                return false;
            })
        });
    </script>
@endsection
