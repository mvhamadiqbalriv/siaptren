@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-2">
                    <b>Absensi Santri</b>
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
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="">Mata Pelajaran</label>
                                    <select name="mata_pelajaran" class="form-control custom-select" required>
                                        @if ($mapel)
                                        <option selected disabled>Pilih Mata Pelajaran</option>
                                        @foreach ($mapel as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == request('mata_pelajaran') ? 'selected' : '' }}>{{ $item->nama_mapel }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="">Guru Pengajar</label>
                                    <select name="guru_pengajar" class="form-control custom-select" required>
                                        @if ($jadwal)
                                        <option selected disabled>Pilih Guru Pengajar</option>
                                        @foreach ($jadwal as $item)
                                            <option value="{{ $item->asatidz->id }}" {{ $item->asatidz->id == request('guru_pengajar') ? 'selected' : '' }}>{{ $item->asatidz->nama_lengkap }}</option>
                                        @endforeach
                                        @endif
                                    </select>
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
                @if (!request('tanggal') or !request('mata_pelajaran') or !request('guru_pengajar'))
                <div class="alert alert-danger">
                    <div class="alert-body">
                        Pastikan telah memilih tanggal, mata pelajaran dan guru pengajar.
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
                                        <td>{{ $absensi->santri->nama_lengkap }}</td>
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
                                <a href="{{ route('absensi-santri.cetak').'?tanggal='.request('tanggal').'&mata_pelajaran='.request('mata_pelajaran').'&guru_pengajar='.request('guru_pengajar') }}" target="_blank" class="btn btn-primary waves-effect">Cetak Absensi</a>
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

        var laporanAbsensiJs = function(){
            bsDatePicker($('[name="tanggal"]'),{
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                zIndexOffset: true
            }, 'change', function(e){
                const tanggal = e.currentTarget.value

                $('[name="guru_pengajar"]').html('')
                $.ajax({
                    url: `{{ url('laporan/absensi/santri/get-mapel') }}/${tanggal}`,
                    method: 'get',
                    success: function(res){
                        $('[name="mata_pelajaran"]').html(res)
                    },
                    error: function(e){
                        toastInit('error', e.responseJSON?.message)
                    }
                })
            })

            $('[name="mata_pelajaran"]').on('change', function(){
                const id = $(this).val()

                $.ajax({
                    url: `{{ url('laporan/absensi/santri/get-guru') }}/${id}`,
                    method: 'get',
                    success: function(res){
                        $('[name="guru_pengajar"]').html(res)
                    },
                    error: function(e){
                        toastInit('error', e.responseJSON?.message)
                    }
                })
            })
        }()
    </script>
@endpush