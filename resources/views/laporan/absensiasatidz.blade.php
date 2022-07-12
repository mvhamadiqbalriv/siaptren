@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-2">
                    <b>Absensi Asatidz</b>
                </h4>
                <div class="sub-header">
                    <form action="" id="form" method="get">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input type="text" value="{{ request('tanggal') }}" required readonly name="tanggal" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-primary waves-effect btn-proses" type="submit">Proses</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @if (!request('tanggal'))
                <div class="alert alert-danger">
                    <div class="alert-body">
                        Pastikan telah memilih tanggal.
                    </div>
                </div>
                @else
                    @if ($data)
                        <div class="table-responsive">
                            <table class="table table-stripped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Lengkap</th>
                                        <th>Kehadiran</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $absensi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $absensi->asatidz->nama_lengkap }}</td>
                                        <td>
                                            @if ($absensi->kehadiran == 'H')
                                            Hadir
                                            @elseif($absensi->kehadiran == 'S')
                                            Sakit
                                            @elseif($absensi->kehadiran == 'I')
                                            Izin
                                            @else
                                            Tanpa Keterangan
                                            @endif
                                        </td>
                                        <td>{{ $absensi->keterangan }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-2">
                                <a href="{{ route('absensi-asatidz.cetak').'?tanggal='.request('tanggal') }}" target="_blank" class="btn btn-primary waves-effect">Cetak Absensi</a>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <div class="alert-body">
                                Tidak ada data absensi.
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        'use strict'

        var absensiAsatidzJs =  function(){
            bsDatePicker($('[name="tanggal"]'),{
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                zIndexOffset: true
            })
        }()
    </script>
@endpush