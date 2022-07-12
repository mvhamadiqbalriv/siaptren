<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" data-dismiss="modal" aria-hidden="true" type="button">x</button>
            <h4 class="modal-title">Detail</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <h5 class="card-title">Profil Alumni</h5>
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
                        <div class="col-4">Tahun Masuk</div>
                        <div class="col-1 pr-0">:</div>
                        <div class="col-7">{{ $data->tahun_masuk }}</div>
                    </div>
                    <div class="row pt-1 pb-1">
                        <div class="col-4">Tahun Lulus</div>
                        <div class="col-1 pr-0">:</div>
                        <div class="col-7">{{ $data->tahun_lulus }}</div>
                    </div>
                    <div class="row pt-1 pb-1">
                        <div class="col-4">Pekerjaan</div>
                        <div class="col-1 pr-0">:</div>
                        <div class="col-7">{{ $data->pekerjaan }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline-primary waves-effect" type="button" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>