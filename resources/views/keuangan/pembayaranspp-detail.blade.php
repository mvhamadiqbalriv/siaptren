<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Detail</h4>
            <button class="close" type="button" data-dismiss="modal" aria-hidden="true">x</button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Tanggal Input</label>
                        <input type="text" disabled class="form-control-plaintext border-bottom" value="{{ $data->created_at }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">User Input</label>
                        <input type="text" disabled class="form-control-plaintext border-bottom" value="{{ $data->user }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Kode Pembayaran</label>
                        <input type="text" disabled class="form-control-plaintext border-bottom" value="{{ $data->kode_pembayaran }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="text" disabled class="form-control-plaintext border-bottom" value="{{ dateFormat($data->tanggal, 'd F Y') }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Santri</label>
                        <input type="text" disabled class="form-control-plaintext border-bottom" value="{{ $data->santri->nama_lengkap }}">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Jumlah Bayar</label>
                        <input type="text" class="form-control-plaintext border-bottom" value="{{ numberFormat($data->jumlah, 0, 'Rp ') }}">
                    </div>
                </div>
                @if ($data->batal)
                <div class="col-12">
                    <div class="alert alert-danger">
                        <div class="alert-body">
                            Dibatalkan oleh {{ $data->user_batal }} pada {{ $data->updated_at }}
                            <p>Keterangan : {{ $data->keterangan_batal }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline-primary waves-effect" type="button" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>