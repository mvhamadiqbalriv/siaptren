<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" type="button" aria-hidden="true" data-dismiss="modal">x</button>
            <h4 class="modal-title">Isi Absensi</h4>
        </div>
        <form action="{{ $url ?? route('absensi-asatidz.store') }}" method="{{ isset($url) ? 'put' : 'post' }}" id="form">
            @csrf
            <div class="modal-body">
                @if (!isset($url))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <div class="alert-body">Absensi Hari {{ dateFormat(now(), 'l, d F Y') }}</div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    @isset($url)
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="text" disabled value="{{ dateFormat($data->tanggal, 'd F Y') }}" class="form-control">
                        </div>
                    </div>
                    @endisset
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Jadwal</label>
                            @if (isset($url))
                            <input type="text" value="{{ $data->jadwal->mapel->nama_mapel }} - {{ $data->asatidz->nama_lengkap }}" disabled class="form-control">
                            @else
                            <select name="jadwal" class="form-control select2 custom-select" style="width: 100%">
                                <option></option>
                                @foreach ($jadwal as $item)
                                <option value="{{ $item->kode_jadwal }}">{{ $item->mapel->nama_mapel }} - {{ $item->asatidz->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Kehadiran</label>
                            <div class="d-flex justify-conten-start kehadiran">
                                <div class="custom-control custom-radio mr-2">
                                    <input type="radio" name="kehadiran" {{ isset($data) ? ($data->kehadiran == 'H' ? 'checked' : '') : '' }} id="hadir" value="H" class="custom-control-input">
                                    <label for="hadir" class="custom-control-label">Hadir</label>
                                </div>
                                <div class="custom-control custom-radio mr-2">
                                    <input type="radio" name="kehadiran" {{ isset($data) ? ($data->kehadiran == 'S' ? 'checked' : '') : '' }} id="sakit" value="S" class="custom-control-input">
                                    <label for="sakit" class="custom-control-label">Sakit</label>
                                </div>
                                <div class="custom-control custom-radio mr-2">
                                    <input type="radio" name="kehadiran" {{ isset($data) ? ($data->kehadiran == 'I' ? 'checked' : '') : '' }} id="izin" value="I" class="custom-control-input">
                                    <label for="izin" class="custom-control-label">Izin</label>
                                </div>
                                <div class="custom-control custom-radio mr-2">
                                    <input type="radio" name="kehadiran" {{ isset($data) ? ($data->kehadiran == 'A' ? 'checked' : '') : '' }} id="alpa" value="A" class="custom-control-input">
                                    <label for="alpa" class="custom-control-label">Tanpa Keterangan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 {{ isset($data) ? ($data->kehadiran == 'I' ? '' : 'd-none') : 'd-none' }} keterangan">
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea name="keterangan" placeholder="Isi Keterangan" rows="5" class="form-control">{{ $data->keterangan ?? '' }}</textarea>
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