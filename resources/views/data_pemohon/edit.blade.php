@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Data Pemohon') }}</h1>

    <div class="row">

        <div class="col-md-4">
                <!-- Collapsable Card Edit Data Pemohon -->
                <div class="card shadow mb-4">
                    <!-- Card Header - Accordion -->
                    <a href="#tambahpemohon" class="d-block card-header py-3" data-toggle="collapse"
                        role="button" aria-expanded="true" aria-controls="collapseCardExample">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Data Pemohon: - {{ $pemohon->nama }}</h6>
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
                            <form action="{{ route('pemohon.update', $pemohon->id) }}" method="post">
                                @csrf
                                @method('put')
                                <div class="form-group">
                                    <label for="no">Nomor KK</label>
                                    <input type="text" class="form-control @error('no_kk') is-invalid @enderror" name="no_kk" value="{{ $pemohon->no_kk }}">
                            
                                    @error('no_kk')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $pemohon->nama }}">
                            
                                    @error('nama')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nik">NIK</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ $pemohon->nik }}">
                            
                                    @error('nik')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" id="" class="form-control" required>
                                        <option {{ $pemohon->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        <option {{ $pemohon->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                            
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ $pemohon->alamat }}">
                            
                                    @error('alamat')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="no_telp">Nomor Telepon</label>
                                    <input type="text" class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" value="{{ $pemohon->no_telp }}">
                            
                                    @error('no_telp')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Tahun Pengajuan</label>
                                    <input type="text" class="form-control @error('tahun_daftar') is-invalid @enderror" name="tahun_daftar" value="{{ $pemohon->tahun_daftar }}">
                            
                                    @error('tahun_daftar')
                                        <div class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button class="btn btn-sm btn-primary">Simpan</button>
                                <a href="{{ route('pemohon.index') }}" class="btn btn-sm btn-success">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>                
        </div>
    </div>
@endsection