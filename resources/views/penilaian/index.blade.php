@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Penilaian') }}</h1>

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
        }

        /* Add the max-two-words CSS class */
        .max-two-words {
            max-width: 150px; /* Set the maximum width for two words */
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
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

    <!-- Year selection dropdown -->
    <div class="form-group">
        <label for="year">Pilih Tahun Pengajuan:</label>
        <select class="form-control" id="year">
            <option value="-">-</option> <!-- Add this empty option -->
            @foreach($availableYears as $year)
                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
            @endforeach
        </select>
    </div>

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
                <!-- Add the scrollable container div -->
                <form action="{{ route('penilaian.store') }}" method="post">
                    @csrf
                    <!-- Hidden input field to store the selected year -->
                    <input type="hidden" name="selected_year" value="{{ $selectedYear }}">
                    <!-- Add the button-container class to the parent div of the button -->
                    <div class="button-container">
                        <button class="btn btn-sm btn-primary float-left">Simpan & Hitung</button>
                    </div><br><br>
                    <div class="table-responsive table-container">
                        <div>
                            <table class="table">
                                <thead class="sticky-cell">
                                    <tr>
                                        <th class="no-wrap sticky-cell">Nama Pemohon</th>
                                        @foreach ($kriteria as $key => $value)
                                            <th class="no-wrap max-two-words">{{ $value->kode_kriteria }} | {{ $value->nama_kriteria }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pemohon as $pem => $valt)
                                        <tr>
                                            <!-- Apply the max-two-words class to limit cell width -->
                                            <td class="no-wrap sticky-cell max-two-words">{{ $valt->nama }}</td>
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
                        </div>
                        <!-- Add this code below your table -->
                        <div class="d-flex justify-content-center"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to handle year selection change event and update the page
        document.getElementById('year').addEventListener('change', function() {
            var selectedYear = this.value;
            // Redirect to the same page with the selected year as a query parameter
            window.location.href = '{{ route("penilaian.index") }}?year=' + selectedYear;
        });
    </script>

@endsection
