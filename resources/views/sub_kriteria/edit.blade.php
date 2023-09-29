@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Sub Kriteria') }} : {{ $kriteria->nama_kriteria }}</h1>

    <div class="row">

        <div class="col-md-4">
                <!-- Collapsable Card Edit Sub Kriteria -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#editsubkriteria" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Sub Kriteria: -{{ $sub_kriteria->nama_pilihan }}</h6>
                    </a>
                    <!-- Card Content - Collapse -->
                    <div class="collapse show" id="editsubkriteria">
                        <div class="card-body">
                            @if (Session::has('msg'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Info!</strong> {{ Session::get('msg') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form action="{{ route('subkriteria.update', $sub_kriteria->id) }}" method="post">
                                @csrf
                                @method('put')
                                <input type="hidden" name="kriteria_id" value="{{ $kriteria->id }}">
                                <div class="form-group">
                                    <label for="nama">Nama Sub Kriteria</label>
                                    <input type="text" class="form-control @error('nama_pilihan') is-invalid @enderror" name="nama_pilihan" value="{{ $sub_kriteria->nama_pilihan }}">
                            
                                    @error('nama_pilihan')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="bobot">Bobot</label>
                                    <input type="text" class="form-control @error('bobot') is-invalid @enderror" name="bobot" value="{{ $sub_kriteria->bobot }}">
                            
                                    @error('bobot')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button class="btn btn-sm btn-primary">Simpan</button>
                                <a href="{{ route('kriteria.show', $sub_kriteria->kriteria_id) }}" class="btn btn-sm btn-success">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>                
        </div>
    </div>
@endsection