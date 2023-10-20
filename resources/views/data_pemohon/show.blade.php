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
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Pemohon') }} : {{ 'Detail Informasi' }}</h1>

        <a href="{{ route('pemohon.index') }}" class="btn btn-sm btn-success">Kembali</a><br><br>

        <div class="col">
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
                                        <th>NIK</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Nomor Telepon</th>
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
                                            <td>{{ $row->no_kk }}</td>
                                            <td>{{ $row->nama }}</td>
                                            <td>{{ $row->nik }}</td>
                                            <td>{{ $row->jenis_kelamin }}</td>
                                            <td>{{ $row->alamat }}</td>
                                            <td>{{ $row->no_telp }}</td>
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
                                    window.location = "{{ route('pemohon.show') }}";
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
