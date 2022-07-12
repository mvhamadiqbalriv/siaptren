@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-2">
                    <b>Laporan Distribusi Gaji</b>
                </h4>
                <div class="sub-header">
                    <form action="" id="form" method="get">
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="">Tanggal Awal</label>
                                    <input type="text" value="{{ request('tanggal_awal') }}" required readonly name="tanggal_awal" class="form-control datepicker">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="">Tanggal Akhir</label>
                                    <input type="text" value="{{ request('tanggal_akhir') }}" required readonly name="tanggal_akhir" class="form-control datepicker">
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
                @if ((request()->has('tanggal_awal') and !request('tanggal_awal')) or (request()->has('tanggal_akhir') and !request('tanggal_akhir')))
                <div class="alert alert-danger">
                    <div class="alert-body">Pastikan sudah memilih tanggal awal dan tanggal akhir.</div>
                </div>
                @endif
                @if (request('tanggal_awal') and request('tanggal_akhir'))
                    @if ($data)
                    <div class="table-responsive">
                        <table class="table table-stripped table-bordered">
                            <thead>
                                <tr>
                                    <th width="15">No</th>
                                    <th>Tanggal</th>
                                    <th>Asatidz</th>
                                    <th>Kehadiran</th>
                                    <th>Honor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>{{ $item->asatidz->nama_lengkap }}</td>
                                    <td>{{ $item->jumlah_kehadiran }}</td>
                                    <td>{{ numberFormat($item->jumlah_honor, 0, 'Rp ') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4">GRAND TOTAL</th>
                                    <th>{{ numberFormat($data->sum('jumlah_honor'), 0, 'Rp ') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="mt-2">
                            <a href="{{ route('laporan-gaji.cetak') }}?tanggal_awal={{ request('tanggal_awal') }}&tanggal_akhir={{ request('tanggal_akhir') }}" target="_blank" class="btn btn-primary waves-effect">Cetak Laporan</a>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-danger">
                        <div class="alert-body">Tidak ada data pengeluaran.</div>
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

        var pengeluaranJs = function(){
            bsDatePicker('.datepicker', {
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                zIndexOffset: 999
            })
        }()
    </script>
@endpush