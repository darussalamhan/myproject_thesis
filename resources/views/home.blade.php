@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Dashboard') }}</h1>

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <!-- Content Row -->
    <div class="row">
        <!-- Illustrations -->        
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Singkat</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 35rem;" src="{{ asset('img/mentibar.jpg') }}" alt="Kantor Desa Mentibar">
                    <p class="text-muted text-center">Kantor Desa Mentibar</p>
                </div>
                <p>Mentibar merupakan salah satu desa yang ada di kecamatan Paloh, Kabupaten Sambas, provinsi Kalimantan Barat, Indonesia. Desa Mentibar dibentuk pada tahun 2003 dari pemekaran Desa Malek.
                    Dengan luas 28,24 km², terdapat 2 dusun (Tanjung Pandan & Sungai Simpur) dan 12 RT. Total penduduk yang tinggal di desa Mentibar sekitar 2498. (Sumber: <em>Direktorat Jenderal Kependudukan dan Pencatatan Sipil, Kemendagri RI</em>)              
                </p>
            </div>
            <hr>
            <div class="card-body">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="{{ asset('img/svg/undraw_editable_dywm.svg') }}" alt="Logo PKH">
                    <p class="text-muted text-center">Logo PKH</p>
                </div>
                <p>Program Keluarga Harapan yang selanjutnya disebut PKH adalah program pemberian bantuan sosial bersyarat kepada Keluarga Miskin (KM) yang ditetapkan sebagai keluarga penerima manfaat PKH.<br>
                    Sebagai upaya percepatan penanggulangan kemiskinan, sejak tahun 2007 Pemerintah Indone­sia telah melaksanakan PKH. ProgramPerlindungan Sosial yang juga dikenal di dunia internasional dengan istilah Conditional Cash Transfers (CCT) ini terbukti cukup berhasil dalam menanggulangi kemiskinan yang dihadapi di negara-negara tersebut, terutama masalah kemiskinan kronis.<br>                    
                    Sebagai sebuah program bantuan sosial bersyarat, PKH membuka akses keluarga miskin terutama ibu hamil dan anak untuk memanfaatkan berbagai fasilitas layanan kesehatan (faskes) dan fasilitas layanan pendidikan (fasdik) yang tersedia di sekitar mereka.Manfaat PKH juga mulai didorong untuk mencakup penyandang disabilitas dan lanjut usia dengan mempertahankan taraf kesejahteraan sosialnya sesuai dengan amanat konstitusi dan Nawacita Presiden RI.</p>
            </div>
        </div>
    </div>
@endsection
