<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Ganti Password</h4>
            <button class="close" type="button" data-dismiss="modal">x</button>
        </div>
        <form action="{{ route('ganti-password') }}" id="form" method="put">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Password Lama</label>
                            <input type="password" name="password_lama" autocomplete="off" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Password Baru</label>
                            <input type="password" name="password" autocomplete="off" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" autocomplete="off" class="form-control">
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