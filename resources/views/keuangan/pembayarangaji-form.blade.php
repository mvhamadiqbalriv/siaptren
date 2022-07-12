<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Distribusi Gaji</h4>
            <button class="close" aria-hidden="true" data-dismiss="modal" type="button">x</button>
        </div>
        <form id="form" action="{{ route('pembayaran-gaji.store') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="form-group">
                            <label for="">Pilih Periode</label>
                            <input type="text" readonly name="periode" class="form-control datepicker">
                        </div>
                    </div>
                </div>
                <div class="row" id="tampil"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btn-proses" type="submit">Simpan</button>
                <button class="btn btn-outline-primary waves-effect" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>