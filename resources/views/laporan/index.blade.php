@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Laporan Perhitungan') }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                @if ($hasilData->isEmpty()) <!-- Check if $hasilData is empty -->
                    <div class="alert alert-warning">
                        Tidak ada data tersedia untuk laporan.
                    </div>
                @else
                    <a href="{{ route('laporan.print') }}" class="btn btn-primary {{ $hasilData->isEmpty() ? 'disabled' : '' }}">Unduh</a>
                    <br><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pemohon</th>
                                <th>No KK</th>
                                <th>Alamat</th>
                                <th>Nilai Vektor V</th>
                                <th>Ranking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hasilData as $index => $hasil)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $hasil->pemohon->nama }}</td>
                                    <td>{{ $hasil->pemohon->no_kk }}</td>
                                    <td>{{ $hasil->pemohon->alamat }}</td>
                                    <td>{{ number_format($hasil->hasil, 3) }}</td>
                                    <td>{{ $loop->iteration }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
