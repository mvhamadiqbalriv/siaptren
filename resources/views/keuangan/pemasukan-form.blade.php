<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title">Tambah</h4>
        </div>
        <form action="{{ route('eksternal.store') }}" method="POST" id="form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="text" readonly name="tanggal" class="form-control datepicker">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nama Pemasukan</label>
                            <input type="text" name="nama_pemasukan" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Jumlah</label>
                            <input type="text" name="jumlah" onkeyup="this.value=formatRupiah(this.value)" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea name="keterangan" rows="5" class="form-control"></textarea>
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