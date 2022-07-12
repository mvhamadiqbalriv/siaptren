<div class="modal-dialog {{ !isset($url) ? 'modal-lg' : 'modal-md' }}">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" type="button" aria-hidden="true" data-dismiss="modal">x</button>
            <h4 class="modal-title">{{ isset($url) ? 'Edit Kehadiran' : 'Isi Absensi' }}</h4>
        </div>
        <form action="{{ $url ?? '' }}" method="put" id="form">
            @csrf
            <div class="modal-body">
                @if (isset($url))
                <div class="row parent-{{ $data->id }}">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="text" disabled class="form-control" value="{{ dateFormat($data->tanggal, 'l, d F Y') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Mata Pelajaran</label>
                            <input type="text" disabled class="form-control" value="{{ $data->nama_mapel }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Guru Pengajar</label>
                            <input type="text" disabled class="form-control" value="{{ $data->pengajar }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Santri</label>
                            <input type="text" disabled class="form-control" value="{{ $data->santri }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Kehadiran</label>
                            <div class="d-flex justify-content-start kehadiran" data-id="{{ $data->id }}">
                                <div class="custom-control custom-radio mr-2">
                                    <input type="radio" id="hadir" name="kehadiran" {{ $data->kehadiran == 'H' ? 'checked' : '' }} value="H" class="custom-control-input">
                                    <label for="hadir" class="custom-control-label">Hadir</label>
                                </div>
                                <div class="custom-control custom-radio mr-2">
                                    <input type="radio" id="sakit" name="kehadiran" {{ $data->kehadiran == 'S' ? 'checked' : '' }} value="S" class="custom-control-input">
                                    <label for="sakit" class="custom-control-label">Sakit</label>
                                </div>
                                <div class="custom-control custom-radio mr-2">
                                    <input type="radio" id="izin" name="kehadiran" {{ $data->kehadiran == 'I' ? 'checked' : '' }} value="I" class="custom-control-input">
                                    <label for="izin" class="custom-control-label">Izin</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="alpa" name="kehadiran" {{ $data->kehadiran == 'A' ? 'checked' : '' }} value="A" class="custom-control-input">
                                    <label for="alpa" class="custom-control-label">Alpa</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 {{ !$data->keterangan ? 'd-none' : '' }} keterangan">
                        <div class="form-group">
                            <label for="">Keterangan</label>
                            <textarea name="keterangan" rows="5" class="form-control">{{ $data->keterangan }}</textarea>
                        </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input type="text" name="tanggal" readonly class="form-control">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="">Jadwal</label>
                            <select name="jadwal" class="form-control custom-select">
                                <option selected disabled>Pilih Jadwal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12" id="list"></div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                @isset($url)
                <button class="btn btn-primary waves-effect btn-proses" type="submit">Simpan</button>
                @endisset
                <button class="btn btn-outline-primary waves-effect" type="button" data-dismiss="modal">Tutup</button>
            </div>
        </form>
    </div>
</div>