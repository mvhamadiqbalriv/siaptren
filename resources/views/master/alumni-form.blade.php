<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Edit Alumni</h4>
            <button class="close" type="button" aria-hidden="true" data-dismiss="modal">x</button>
        </div>
        <form action="{{ route('alumni.update', encrypt($data->kode_santri)) }}" method="put" id="form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nama Alumni</label>
                            <input type="text" value="{{$data->nama_lengkap}}" disabled class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nomor Handphone</label>
                            <input type="text" value="{{$data->nomor_handphone}}" name="nomor_handphone" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" value="{{$data->email}}" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="alamat" rows="5" class="form-control">{{$data->alamat}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Pekerjaan</label>
                            <input type="text" value="{{$data->pekerjaan}}" name="pekerjaan" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-proses" type="submit">Simpan</button>
                <button class="btn btn-outline-primary" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>