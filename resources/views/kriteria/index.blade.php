@extends('layouts.admin')

@section('css')
    <!-- Custom styles for this page -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Kriteria') }}</h1>

    <div class="row">

        <div class="col-md-4">
                <!-- Collapsable Card Tambah Kriteria -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#tambahkriteria" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah Kriteria</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="tambahkriteria">
                        <div class="card-body">
                            @if (Session::has('msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Info!</strong> {{ Session::get('msg') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form action="{{ route('kriteria.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="nama">Nama Kriteria</label>
                                    <input type="text" class="form-control @error('nama_kriteria') is-invalid @enderror" name="nama_kriteria">
                            
                                    @error('nama_kriteria')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="kode">Kode Kriteria</label>
                                    <input type="text" class="form-control @error('kode_kriteria') is-invalid @enderror" name="kode_kriteria">
                            
                                    @error('kode_kriteria')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="bobot">Bobot Kriteria</label>
                                    <input type="text" class="form-control @error('bobot') is-invalid @enderror" name="bobot">
                            
                                    @error('bobot')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="atribut">Atribut</label>
                                    <select name="atribut" id="" class="form-control" required>
                                        <option>Cost</option>
                                        <option>Benefit</option>
                                    </select>
                            
                                    @error('atribut')
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
                <!-- Collapsable Card List Kriteria -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#listkriteria" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">List Kriteria</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="listkriteria">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="DataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kriteria</th>
                                            <th>Kode Kriteria</th>
                                            <th>Bobot</th>
                                            <th>Atribut</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($kriteria as $row)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $row->nama_kriteria }}</td>
                                                <td>{{ $row->kode_kriteria }}</td>
                                                <td>{{ $row->bobot }}</td>
                                                <td>{{ $row->atribut }}</td>
                                                <td>
                                                    <a href="{{ route('kriteria.edit', $row->id) }}" class="btn btn-sm btn-circle btn-warning"><i class="fa fa-edit"></i></a>
                                                    <a href="{{ route('kriteria.destroy', $row->id) }}" class="btn btn-sm btn-circle btn-danger delete"><i class="fa fa-trash"></i></a>
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
                                    window.location = "{{ route('kriteria.index') }}";
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
