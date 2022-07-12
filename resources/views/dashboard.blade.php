@extends('layouts.master')

@push('css')
    
@endpush

@section('content')
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="fe-user-plus float-right"></i>
                <h5 class="text-muted text-uppercase mb-3 mt-0">Pendaftar</h5>
                <h3 class="mb-3" data-plugin="counterup">{{ $data['civitas']['pendaftar'] }}</h3>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="fe-users float-right"></i>
                <h5 class="text-muted text-uppercase mb-3 mt-0">Santri</h5>
                <h3 class="mb-3"><span data-plugin="counterup">{{ $data['civitas']['santri'] }}</span></h3>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="fe-user-check float-right"></i>
                <h5 class="text-muted text-uppercase mb-3 mt-0">Alumni</h5>
                <h3 class="mb-3"><span data-plugin="counterup">{{ $data['civitas']['alumni'] }}</span></h3>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="fe-user float-right"></i>
                <h5 class="text-muted text-uppercase mb-3 mt-0">Asatidz</h5>
                <h3 class="mb-3" data-plugin="counterup">{{ $data['civitas']['asatidz'] }}</h3>
            </div>
        </div>
    </div>

    @if (auth()->user()->hasRole(['bendahara', 'pimpinan_pesantren']))
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-12">
            <div class="card-box tilebox-one">
                <i class="fe-download float-right"></i>
                <h5 class="text-muted text-uppercae mb-3 mt-0">Pemasukan</h5>
                <h3 class="mb-3">{{ numberFormat($data['keuangan']['pemasukan'], 0) }}</h3>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-12">
            <div class="card-box tilebox-one">
                <i class="fe-upload float-right"></i>
                <h5 class="text-muted text-uppercae mb-3 mt-0">Pengeluaran</h5>
                <h3 class="mb-3">{{ numberFormat($data['keuangan']['pengeluaran'], 0) }}</h3>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-4 col-12">
            <div class="card-box tilebox-one">
                <i class="fe-credit-card float-right"></i>
                <h5 class="text-muted text-uppercae mb-3 mt-0">Saldo</h5>
                <h3 class="mb-3">{{ numberFormat($data['keuangan']['saldo'], 0) }}</h3>
            </div>
        </div>
    </div>
    @endif

@endsection

@push('js')
    <!-- Init js -->
    {{-- <script src="{{ asset('') }}assets/js/pages/dashboard.init.js"></script> --}}
@endpush