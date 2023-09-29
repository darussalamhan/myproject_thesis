@extends('layouts.admin')

@section('css')
    <!-- Custom styles for this page -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Pemohon') }}</h1>

    <div class="row">

        <div class="col-md-4">
                <!-- Collapsable Card Tambah Data Pemohon -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#tambahpemohon" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah Data Pemohon</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="tambahpemohon">
                        <div class="card-body">
                            @if (Session::has('msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Info!</strong> {{ Session::get('msg') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form action="{{ route('pemohon.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="no">Nomor KK</label>
                                    <input type="text" class="form-control @error('no_kk') is-invalid @enderror" name="no_kk">
                            
                                    @error('no_kk')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama">
                            
                                    @error('nama')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat">
                            
                                    @error('alamat')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button class="btn btn-sm btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>                
        </div>

        <div class="col-md-8">
                <!-- Collapsable Card List Data Pemohon -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#listpemohon" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">List Data Pemohon</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="listpemohon">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="DataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nomor KK</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($pemohon as $row)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $row->no_kk }}</td>
                                                <td>{{ $row->nama }}</td>
                                                <td>{{ $row->alamat }}</td>
                                                <td>
                                                    <a href="{{ route('pemohon.edit', $row->id) }}" class="btn btn-sm btn-circle btn-warning"><i class="fa fa-edit"></i></a>
                                                    @if (auth()->user()->isAdmin())
                                                        <a href="{{ route('pemohon.destroy', $row->id) }}" class="btn btn-sm btn-circle btn-danger delete"><i class="fa fa-trash"></i></a>                                                        
                                                    @endif
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
            $('#DataTable').DataTable({
                "language": {
                    "url": "{{ asset('vendor/datatables/id.json') }}"
                }
            });

            $('.delete').on('click', function(){
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
                            url: $(this).attr('href'),
                            type: 'DELETE',
                            data: {
                                '_token': "{{ csrf_token() }}"
                            },
                            success:function()
                            {
                                swal("Poof! Data telah dihapus!", {
                                    icon: "success",
                                }).then((willDelete) => {
                                    window.location = "{{ route('pemohon.index') }}";
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
