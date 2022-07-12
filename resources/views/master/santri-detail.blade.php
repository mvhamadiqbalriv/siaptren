<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" data-dismiss="modal" aria-hidden="true" type="button">x</button>
            <h4 class="modal-title">{{ isset($url) ? 'Verifikasi' : 'Detail' }}</h4>
        </div>
        <form action="{{ $url ?? '' }}" method="put" id="form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h5 class="card-title">Profil Santri</h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Kode Santri</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->kode_santri }}</div>
                        </div>
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Nama Lengkap</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->nama_lengkap }}</div>
                        </div>
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Jenis Kelamin</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->jenis_kelamin }}</div>
                        </div>
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Tanggal Lahir</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->tempat_lahir }}, {{ dateFormat($data->tanggal_lahir, 'd F Y') }}</div>
                        </div>
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Nomor HP</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->nomor_handphone }}</div>
                        </div>
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Email</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->email }}</div>
                        </div>
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Alamat</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->alamat }}</div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Universitas</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->universitas }}</div>
                        </div>
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Fakultas</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->fakultas }}</div>
                        </div>
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Prodi</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->prodi }}</div>
                        </div>
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Semester</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->semester }}</div>
                        </div>
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Tahun Masuk</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->tahun_masuk }}</div>
                        </div>
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Status</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">{{ $data->status ?? 'Menunggu Verifikasi' }}</div>
                        </div>
                        @if ($data->status)
                        <div class="row pt-1 pb-1">
                            <div class="col-4">Verifikasi</div>
                            <div class="col-1 pr-0">:</div>
                            <div class="col-7">Diverifikasi oleh {{ $data->user_verifikasi }}</div>
                        </div>
                        @endif
                    </div>
                    <div class="col-12 mt-2">
                        <h5 class="card-title">Berkas</h5>
                    </div>
                    @if ($data->pasFoto or $data->kk or $data->ktp)
                        @if ($data->pasFoto)
                        <div class="col-md-4 col-lg-4 col-12">
                            <img src="{{ asset('storage/uploads/'.$data->pasFoto->nama_file) }}" class="img-fluid" alt="">
                        </div>
                        @endif
                        @if ($data->kk)
                        <div class="col-md-4 col-lg-4 col-12">
                            <img src="{{ asset('storage/uploads/'.$data->kk->nama_file) }}" class="img-fluid" alt="">
                        </div>
                        @endif
                        @if ($data->ktp)
                        <div class="col-md-4 col-lg-4 col-12">
                            <img src="{{ asset('storage/uploads/'.$data->ktp->nama_file) }}" class="img-fluid" alt="">
                        </div>
                        @endif
                    @else
                    <div class="col-12 mt-1">
                        <div class="alert alert-danger">
                            <div class="alert-body">Belum ada berkas</div>
                        </div>
                    </div>
                    @endif
                </div>
                @isset($url)
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Data Sudah Lengkap</label>
                            <div class="d-flex justify-content-start">
                                <div class="custom-control custom-radio mr-2">
                                    <input type="radio" name="status" id="ya" class="custom-control-input" value="Y">
                                    <label for="ya" class="custom-control-label">Ya</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="status" id="tidak" class="custom-control-input" value="N">
                                    <label for="tidak" class="custom-control-label">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endisset
            </div>
            <div class="modal-footer">
                @isset($url)
                <button class="btn btn-primary waves-effect btn-proses" type="submit">Simpan</button>
                @endisset
                <button class="btn btn-outline-primary waves-effect" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>