<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Upload Berkas</h4>
            <button class="close" data-dismiss="modal" aria-hidden="true">x</button>
        </div>
        <form action="{{ $url }}" id="upload" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Kode Asatidz</label>
                            <input type="text" disabled value="{{ $data->kode_asatidz }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nama Asatidz</label>
                            <input type="text" disabled value="{{ $data->nama_lengkap }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">KTP</label>
                            <input type="file" name="ktp" accept="image/*" class="form-control-file">
                            <input type="hidden" name="ktp_old" value="{{ $data->ktp->nama_file ?? '' }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">KK</label>
                            <input type="file" name="kk" accept="image/*" class="form-control-file">
                            <input type="hidden" name="kk_old" value="{{ $data->kk->nama_file ?? '' }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Pas Foto (3x4)</label>
                            <input type="file" name="foto" accept="image/*" class="form-control-file">
                            <input type="hidden" name="foto_old" value="{{ $data->pasFoto->nama_file ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-proses" type="submit">Simpan</button>
                <button class="btn btn-outline-primary waves-effect" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>