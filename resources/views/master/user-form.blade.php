<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ isset($data) ? 'Edit' : 'Tambah' }}</h4>
            <button class="close" type="button" data-dismiss="modal" aria-hidden="true">x</button>
        </div>
        <form action="{{ $url ?? route('user.store') }}" method="{{ isset($data) ? 'put' : 'post' }}" id="form">
            @csrf
            @isset($data)
            <input type="hidden" name="id" value="{{ $data->id }}">
            @endisset
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="{{ $data->nama_lengkap ?? '' }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Jabatan</label>
                            <select name="jabatan" class="form-control custom-select">
                                <option selected disabled>Pilih Jabatan</option>
                                <option {{ isset($data) ? ($data->jabatan == 'Admin' ? 'selected' : '') : '' }} value="Admin">Admin</option>
                                <option {{ isset($data) ? ($data->jabatan == 'Bendahara' ? 'selected' : '') : '' }} value="Bendahara">Bendahara</option>
                                <option {{ isset($data) ? ($data->jabatan == 'Pimpinan Pesantren' ? 'selected' : '') : '' }} value="Pimpinan Pesantren">Pimpinan Pesantren</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" name="email" value="{{ $data->email ?? '' }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">No HP</label>
                            <input type="text" name="no_hp" value="{{ $data->no_hp ?? '' }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Username</label>
                            <input type="text" name="username" {{ isset($data) ? 'disabled' : '' }} autocomplete="off" value="{{ $data->username ?? '' }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Password</label>
                            <input type="text" name="password" autocomplete="off" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Konfirmasi Password</label>
                            <input type="text" name="password_confirmation" autocomplete="off" class="form-control">
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