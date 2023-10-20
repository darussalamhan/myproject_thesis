@extends('layouts.admin')

@section('main-content')
    <h1 class="h3 mb-4 text-gray-800">{{ __('Laporan Perhitungan') }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('laporan.index') }}" method="GET">
                <div class="form-group">
                    <label for="tahun_nilai">Pilih Tahun Penilaian:</label>
                    <select id="tahun_nilai" name="tahun_nilai" class="form-control" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @foreach ($distinctYears as $year)
                            <option value="{{ $year }}" {{ request('tahun_nilai') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            <div class="table-responsive">
                @if ($hasilData->isEmpty()) <!-- Check if $hasilData is empty -->
                    <div class="alert alert-warning">
                        Tidak ada data tersedia untuk laporan.
                    </div>
                @else
                <a href="{{ route('laporan.print', ['tahun_nilai' => request('tahun_nilai')]) }}" class="btn btn-primary {{ $hasilData->isEmpty() ? 'disabled' : '' }}">Unduh</a>
                @if (!auth()->user()->isAdmin())
                    <form action="{{ route('laporan.destroy') }}" method="POST" class="d-inline" id="deleteForm">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="tahun_nilai" value="{{ request('tahun_nilai') }}">
                        <button type="button" class="btn btn-danger" id="deleteButton">Hapus Laporan</button>
                    </form> 
                @endif                               
                    <br><br>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pemohon</th>
                                <th>No KK</th>
                                <th>Alamat</th>
                                <th>Poin Penilaian</th>
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

    <script>
        document.getElementById('deleteButton').addEventListener('click', function() {
            // Show the delete confirmation modal
            $('#deleteConfirmationModal').modal('show');

            // Handle delete operation when the user confirms
            document.getElementById('confirmDeleteButton').addEventListener('click', function() {
                // Set the hidden input value to the selected year before submitting the form
                document.querySelector('input[name="tahun_nilai"]').value = document.getElementById('tahun_nilai').value;
                document.getElementById('deleteForm').submit();

                // Close the modal after form submission
                $('#deleteConfirmationModal').modal('hide');
            });
        });
    </script>

@endsection
