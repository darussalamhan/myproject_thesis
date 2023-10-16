@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Hasil Perhitungan') }}</h1>

    {{-- Style Optional --}}
    <style>
        .no-wrap {
            width: 50%;
        }

        /* Add the sticky-cell CSS */
        .sticky-cell {
            position: sticky;
            left: 0;
            background-color: #fff; /* Set the background color as needed */
            text-align: center;
            align-content: center;
        }

        /* Add the max-two-words CSS class */
        .max-two-words {
            max-width: 150px; /* Set the maximum width for two words */
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            text-align: center;
            align-content: center;
        }

        /* Add CSS for the scrollable container */
        .table-container {
            max-height: 450px; /* Set the maximum height for vertical scrolling */
            overflow-y: auto; /* Enable vertical scrolling */
            overflow-x: auto; /* Add if you want horizontal scrolling */
        }

        /* Make the table header sticky to the top */
        .table thead.sticky-cell {
            position: sticky;
            top: 0; /* Stick it to the top */
            background-color: #fff; /* Set the background color as needed */
            z-index: 1; /* Ensure it's above other table cells */
        }

        /* Add a CSS class to the parent div of the button */
        .button-container {
            position: sticky;
            top: 0; /* Stick it to the top */
            height: 5px;
            background-color: #fff; /* Set the background color as needed */
            z-index: 2; /* Ensure it's above other elements */
            margin-bottom: 1px; /* Add margin to create space between button and table */
        }

        /* Make the button stay fixed horizontally */
        .button-container button {
            position: sticky;
            left: 0; /* Stick it to the left */
        }
    </style>

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
                <div class="table-responsive table-container">
                    <table class="table table-bordered">
                        <thead class="sticky-cell">
                            <tr>
                                <th class="no-wrap sticky-cell">Nama Pemohon</th>
                                @foreach ($kriteria as $key => $value)
                                    <th class="no-wrap max-two-words">{{ $value->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pemohon as $pem)
                                <tr>
                                    <td class="no-wrap sticky-cell max-two-words">{{ $pem->nama }}</td>
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
                <div class="table-responsive table-container">
                    <table class="table table-bordered">
                        <thead class="sticky-cell">
                            <tr>
                                <th class="no-wrap sticky-cell">Alternatif / Pemohon</th>
                                @foreach ($kriteria as $key => $value)
                                    <th class="no-wrap max-two-words">{{ $value->kode_kriteria }} | {{ $value->nama_kriteria }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($normalizedScores as $pemohonName => $criteriaScores)
                                <tr>
                                    <td class="no-wrap sticky-cell max-two-words">{{ $pemohonName }}</td>
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
                        <input type="hidden" name="pilih_tahun" value="{{ $nilai->first()->tahun_nilai }}">
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