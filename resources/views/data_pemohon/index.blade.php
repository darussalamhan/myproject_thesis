@extends('layouts.admin')

@section('css')
    <!-- Custom styles for this page -->
  <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        /* Ensure that text in the "Aksi" column does not wrap */
        .aksi-column {
            white-space: nowrap;
        }
    </style>
@endsection

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Pemohon') }}</h1>

    <div class="row">

    @if (auth()->user()->isAdmin())
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
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik">
                        
                                @error('nik')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="" class="form-control" required>
                                    <option>Laki-laki</option>
                                    <option>Perempuan</option>
                                </select>
                        
                                @error('jenis_kelamin')
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
                            <div class="form-group">
                                <label for="no_telp">Nomor Telepon</label>
                                <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp">
                        
                                @error('no_telp')
                                    <div class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat">Tahun Pengajuan</label>
                                <input type="text" class="form-control @error('tahun_daftar') is-invalid @enderror" name="tahun_daftar">
                        
                                @error('tahun_daftar')
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
    @endif
        
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
                            <a href="{{ route('pemohon.show') }}" class="btn btn-primary">Lihat Detail Pemohon <i class="fa fa-eye"></i></a><br><br>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="DataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tahun Pengajuan</th>
                                            @if (auth()->user()->isAdmin())                                              
                                                <th>Aksi</th>                                                
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($pemohon as $row)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $row->nama }}</td>
                                                <td>{{ $row->alamat }}</td>
                                                <td>{{ $row->jenis_kelamin }}</td>
                                                <td>{{ $row->tahun_daftar }}</td>
                                            @if (auth()->user()->isAdmin())
                                                <td class="aksi-column">
                                                    <a href="{{ route('pemohon.edit', $row->id) }}" class="btn btn-sm btn-circle btn-warning"><i class="fa fa-edit"></i></a>
                                                    <a href="{{ route('pemohon.destroy', $row->id) }}" class="btn btn-sm btn-circle btn-danger delete"><i class="fa fa-trash"></i></a>                                                        
                                                </td>
                                            @endif
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
