<div class="col-12 table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kehadiran</th>
                <th>Upah Pertemuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandtotal = 0;
            @endphp
            @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->nama_lengkap }}</td>
                <td>{{ $item->absensi_count }}</td>
                <td>{{ numberFormat($item->upah_pertemuan, 0, 'Rp ') }}</td>
                @php
                    $total = $item->upah_pertemuan * $item->absensi_count;
                    $grandtotal += $total;
                @endphp
                <td>{{ numberFormat($total, 0, 'Rp ') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4">GRAND TOTAL</th>
                <th>{{ numberFormat($grandtotal, 0, 'Rp ') }}</th>
            </tr>
        </tfoot>
    </table>
</div>