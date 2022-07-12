<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" type="button" aria-hidden="true" data-dismiss="modal">x</button>
            <h4 class="modal-title">{{ isset($url) ? 'Edit' : 'Tambah' }}</h4>
        </div>
        <form action="{{ $url ?? route('jadwal.store') }}" method="{{ isset($url) ? 'put' : 'post' }}" id="form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Mata Pelajaran</label>
                            <select name="mata_pelajaran" class="form-control select2" @isset($url) disabled @endisset style="width: 100%" data-placeholder="Pilih Mata Pelajaran">
                                <option></option>
                                @foreach ($mapel as $item)
                                <option value="{{ $item->id }}" {{ isset($data) ? ($data->mapel_id == $item->id ? 'selected' : '') : '' }}>{{ $item->nama_mapel }} ({{ $item->hari }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Pengajar</label>
                            <select name="pengajar" class="form-control select2" @isset($url) disabled @endisset style="width: 100%" data-placeholder="Pilih Pengajar">
                                <option></option>
                                @foreach ($asatidz as $item)
                                <option value="{{ $item->kode_asatidz }}" {{ isset($data) ? ($data->asatidz_id == $item->id ? 'selected' : '') : '' }}>{{ $item->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @isset($url)
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Aktif</label><br>
                            <input type="checkbox" {{ $data->aktif ? 'checked' : '' }} name="aktif" data-plugin="switchery" data-color="#1bb99a">
                        </div>
                    </div>
                    @endisset
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary waves-effect btn-proses" type="submit">Simpan</button>
                <button class="btn btn-outline-primary waves-effect" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>