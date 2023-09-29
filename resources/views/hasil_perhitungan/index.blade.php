@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Hasil Perhitungan') }}</h1>

    <div class="card shadow mb-4">
        <!-- Collapsable Card Perhitungan -->
        <!-- Card Header - Accordion -->
        <a href="#hasilhitung" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Proses Perhitungan</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="hasilhitung">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Pemohon</th>
                                @foreach ($kriteria as $key => $value)
                                    <th>{{ $value->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pemohon as $pem)
                                <tr>
                                    <td>{{ $pem->nama }}</td>
                                    @foreach ($pem->nilai as $nilaiItem)
                                        <td>{{ $nilaiItem->sub_kriteria->bobot }}</td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td>Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Card Content - Collapse -->
        <div class="collapse show" id="kriteria">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Kriteria</th>
                                <th>Atribut</th>
                                <th>Bobot</th>
                                <th>Normalisasi Bobot</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kriteria as $kriteriaItem)
                                <tr>
                                    <td>{{ $kriteriaItem->nama_kriteria }}</td>
                                    <td>{{ $kriteriaItem->atribut }}</td>
                                    <td>{{ $kriteriaItem->bobot }}</td>
                                    <td>{{ number_format($weights[$kriteriaItem->id], 3) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <!-- Collapsable Card Normalisasi -->
        <!-- Card Header - Accordion -->
        <a href="#normalisasi" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Normalisasi</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="normalisasi">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Alternatif / Pemohon</th>
                                @foreach ($kriteria as $key => $value)
                                    <th>{{ $value->kode_kriteria }} | {{ $value->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($normalizedScores as $pemohonName => $criteriaScores)
                                <tr>
                                    <td>{{ $pemohonName }}</td>
                                    @foreach ($criteriaScores as $kriteriaId => $criteriaScore)
                                        <td>
                                            {{ number_format($criteriaScore, 3) }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <!-- Collapsable Card Perangkingan -->
        <!-- Card Header - Accordion -->
        <a href="#rank" class="d-block card-header py-3" data-toggle="collapse"
            role="button" aria-expanded="true" aria-controls="collapseCardExample">
            <h6 class="m-0 font-weight-bold text-primary">Perangkingan</h6>
        </a>
        <!-- Card Content - Collapse -->
        <div class="collapse show" id="rank">
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
                    <form action="{{ route('hasil.store') }}" method="post">
                        @csrf
                        <button class="btn btn-sm btn-primary float-right">Simpan ke Laporan</button>
                        <br><br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Pemohon</th>
                                    <th>Nilai Vektor S</th>
                                    <th>Nilai Vektor V</th>
                                    <th>Ranking</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp <!-- Initialize $no here -->
                                @php $rankedPemohon = collect($normalizedScores)->sortByDesc(function ($value, $key) use ($vectorV) {
                                    return $vectorV[$key];
                                }); @endphp
                                @foreach ($rankedPemohon as $pemohonName => $criteriaScores)
                                    <tr>
                                        <td>{{ $pemohonName }}</td>
                                        <td>{{ number_format($vectorS[$pemohonName], 3) }}</td>
                                        <td>{{ number_format($vectorV[$pemohonName], 3) }}</td>
                                        <td>{{ $no++ }}</td>
                                    </tr>                                
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>  
            </div>              
        </div>

    </div>

@endsection