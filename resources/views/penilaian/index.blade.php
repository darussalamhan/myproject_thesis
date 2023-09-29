@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Penilaian') }}</h1>

        <div class="card shadow mb-4">
                <!-- Collapsable Card Tambah Penilaian -->
                    <!-- Card Header - Accordion -->
                    <a href="#tambahnilai" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Penilaian Pemohon</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="tambahnilai">
                        <div class="card-body">
                            @if (Session::has('msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Info!</strong> {{ Session::get('msg') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="table-responsive">
                                <form action="{{ route('penilaian.store') }}" method="post">
                                    @csrf
                                    <button class="btn btn-sm btn-primary float-right">Simpan & Hitung</button>
                                    <br><br>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nama Pemohon</th>
                                                @foreach ($kriteria as $key => $value)
                                                    <th>{{ $value->kode_kriteria }} | {{ $value->nama_kriteria }}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($pemohon as $pem => $valt)
                                                <tr>
                                                    <td>{{ $valt->nama }}</td>
                                                    @if (count($valt->nilai) > 0)
                                                        @foreach ($kriteria as $key => $value)
                                                        <td>
                                                            <select name="pemohon_id[{{ $valt->id }}][]" class="form-control">
                                                                @foreach ($value->sub_kriteria as $k_1 => $v_1)
                                                                    <option value="{{ $v_1->id }}" {{ $v_1->id == $valt->nilai[$key]->subkriteria_id ? 'selected' : '' }}>{{ $v_1->nama_pilihan }}</option>
                                                                @endforeach
                                                            </select>                                                            
                                                        </td>
                                                        @endforeach                                                        
                                                    @else
                                                        @foreach ($kriteria as $key => $value)
                                                            <td>
                                                                <select name="pemohon_id[{{ $valt->id }}][]" class="form-control">
                                                                    @foreach ($value->sub_kriteria as $k_1 => $v_1)
                                                                        <option value="{{ $v_1->id }}">{{ $v_1->nama_pilihan }}</option>
                                                                    @endforeach
                                                                </select>                                                            
                                                            </td>
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td>Tidak ada data</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>                
        </div>

@endsection