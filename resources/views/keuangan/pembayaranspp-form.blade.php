<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" type="button" aria-hidden="true" data-dismiss="modal">x</button>
            <h4 class="modal-title">{{ isset($url) ? 'Edit Pembayaran' : 'Tambah Pembayaran' }}</h4>
        </div>
        <form action="{{ $url ?? route('pembayaran-spp.store') }}" method="{{ isset($url) ? 'put' : 'post' }}" id="form">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nama Santri</label>
                            <select name="santri" class="form-control select2" style="width: 100%"></select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Tanggal Pembayaran</label>
                            <input type="text" disabled value="{{ dateFormat('now', 'l, d F Y') }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row tampil d-none">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-proses waves-effect d-none" type="submit">Simpan</button>
                <button class="btn btn-outline-primary waves-effect" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>