<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title">{{ isset($url) ? 'Edit' : 'Tambah' }}</h4>
        </div>
        <form id="form" action="{{ $url ?? route('mata-pelajaran.store') }}" method="{{ isset($url) ? 'put' : 'post' }}">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Mata Pelajaran</label>
                            <input type="text" name="mata_pelajaran" onkeyup="this.value=(this.value).toUpperCase()" value="{{ $data->nama_mapel ?? '' }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Hari</label>
                            <select name="hari" class="form-control custom-select">
                                <option selected disabled>Pilih Hari</option>
                                <option value="AHAD" {{ isset($data) ? ($data->hari == 'AHAD' ? 'selected' : '') : '' }}>AHAD</option>
                                <option value="SENIN" {{ isset($data) ? ($data->hari == 'SENIN' ? 'selected' : '') : '' }}>SENIN</option>
                                <option value="SELASA" {{ isset($data) ? ($data->hari == 'SELASA' ? 'selected' : '') : '' }}>SELASA</option>
                                <option value="RABU" {{ isset($data) ? ($data->hari == 'RABU' ? 'selected' : '') : '' }}>RABU</option>
                                <option value="KAMIS" {{ isset($data) ? ($data->hari == 'KAMIS' ? 'selected' : '') : '' }}>KAMIS</option>
                                <option value="JUM'AT" {{ isset($data) ? ($data->hari == "JUM'AT" ? 'selected' : '') : '' }}>JUM'AT</option>
                                <option value="SABTU" {{ isset($data) ? ($data->hari == 'SABTU' ? 'selected' : '') : '' }}>SABTU</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary waves-effect btn-proses" type="submit">Simpan</button>
                <button class="btn btn-outline-primary waves-effect" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>