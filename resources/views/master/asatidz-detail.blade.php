<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" data-dismiss="modal" aria-hidden="true" type="button">x</button>
            <h4 class="modal-title">Detail</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <h5 class="card-title">Profil Asatidz</h5>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="row pt-1 pb-1">
                        <div class="col-4">Kode Asatidz</div>
                        <div class="col-1 pr-0">:</div>
                        <div class="col-7">{{ $data->kode_asatidz }}</div>
                    </div>
                    <div class="row pt-1 pb-1">
                        <div class="col-4">Nama Lengkap</div>
                        <div class="col-1 pr-0">:</div>
                        <div class="col-7">{{ $data->nama_lengkap }}</div>
                    </div>
                    <div class="row pt-1 pb-1">
                        <div class="col-4">NIK</div>
                        <div class="col-1 pr-0">:</div>
                        <div class="col-7">{{ $data->nik }}</div>
                    </div>
                    <div class="row pt-1 pb-1">
                        <div class="col-4">Tanggal Lahir</div>
                        <div class="col-1 pr-0">:</div>
                        <div class="col-7">{{ $data->tempat_lahir }}, {{ dateFormat($data->tanggal_lahir, 'd F Y') }}</div>
                    </div>
                    <div class="row pt-1 pb-1">
                        <div class="col-4">Upah Pertemuan</div>
                        <div class="col-1 pr-0">:</div>
                        <div class="col-7">{{ numberFormat($data->upah_pertemuan, 0, 'Rp ') }}</div>
                    </div>
                    <div class="row pt-1 pb-1">
                        <div class="col-4">Status</div>
                        <div class="col-1 pr-0">:</div>
                        <div class="col-7">{{ $data->aktif ? 'Aktif' : 'Non Aktif' }}</div>
                    </div>
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
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline-primary waves-effect" type="button" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>