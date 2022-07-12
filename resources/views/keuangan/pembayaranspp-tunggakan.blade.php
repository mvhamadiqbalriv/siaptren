@if ($data)
<div class="col-12">
    <div class="form-group">
        <label for="">Tunggakan</label>
        <input type="text" disabled value="{{ numberFormat($data->tunggakan, 0, 'Rp ') }}" name="tunggakan" class="form-control">
    </div>
</div>
@else    
<div class="col-12">
    <div class="form-group">
        <label for="">Periode Awal Pembayaran</label>
        <input type="text" name="periode_awal" readonly class="form-control datepicker">
    </div>
</div>
@endif
<div class="col-12">
    <div class="form-group">
        <label for="">Jumlah Bayar</label>
        <input type="text" name="jumlah_bayar" onkeyup="this.value=formatRupiah(this.value)" class="form-control">
    </div>
</div>
<div class="col-12">
    <div class="alert alert-warning">
        <div class="alert-body">
            @if ($data)
                Pembayaran terakhir tanggal {{ dateFormat($data->tanggal, 'd F Y') }}
            @else
                Belum ada catatan pembayaran
            @endif
        </div>
    </div>
</div>
