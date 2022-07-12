<table class="table" style="width: 100%">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama Santri</th>
            <th>Kehadiran</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $santri)
        <tr>
            <td>{{ $santri->kode_santri }}</td>
            <td>{{ $santri->nama_lengkap }}</td>
            <td>
                <select name="kehadiran" id="{{ $santri->kode_santri }}" class="form-control custom-select">
                    <option selected disabled>Pilih Kehadiran</option>
                    <option value="H">Hadir</option>
                    <option value="S">Sakit</option>
                    <option value="I">Izin</option>
                    <option value="A">Alpa</option>
                </select>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center text-danger">Semua santri sudah diabsen</td>
        </tr>
        @endforelse
    </tbody>
</table>
