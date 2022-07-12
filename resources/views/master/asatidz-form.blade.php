<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" data-dismiss="modal" aria-hidden="true" type="button">x</button>
            <h4 class="modal-title">{{ isset($url) ? 'Edit' : 'Tambah' }}</h4>
        </div>
        <form action="{{ $url ?? route('asatidz.store') }}" method="{{ isset($url) ? 'put' : 'post' }}" id="form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">NIK</label>
                            <input type="text" name="nik" {{ auth()->user()->hasRole('bendahara') ? 'disabled' : '' }} value="{{ $data->nik ?? '' }}" maxlength="16" placeholder="Nomor Induk Kependudukan" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" {{ auth()->user()->hasRole('bendahara') ? 'disabled' : '' }} onkeyup="this.value=(this.value).toUpperCase()" value="{{ $data->nama_lengkap ?? '' }}" placeholder="Nama Lengkap" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" {{ auth()->user()->hasRole('bendahara') ? 'disabled' : '' }} onkeyup="this.value=(this.value).toUpperCase()" value="{{ $data->tempat_lahir ?? '' }}" placeholder="Tempat Lahir" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Tanggal Lahir</label>
                            <input type="text" name="tanggal_lahir" {{ auth()->user()->hasRole('bendahara') ? 'disabled' : '' }} value="{{ $data->tanggal_lahir ?? '' }}" readonly placeholder="Tanggal Lahir" class="form-control datepicker">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Upah Pertemuan</label>
                            <input type="text" name="upah_pertemuan" onkeyup="this.value=formatRupiah(this.value)" value="{{ isset($data) ? numberFormat($data->upah_pertemuan, 0, 'Rp ') : '' }}" class="form-control">
                        </div>
                    </div>
                    @isset($data)
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Aktif</label><br>
                            <input type="checkbox" {{ $data->aktif ? 'checked' : '' }} {{ auth()->user()->hasRole('bendahara') ? 'disabled' : '' }} name="aktif" data-plugin="switchery" data-color="#1bb99a">
                        </div>
                    </div>
                    @endisset
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary waves-effect btn-proses" type="submit">Simpan</button>
                <button class="btn btn-outline-primary waves-effect" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>