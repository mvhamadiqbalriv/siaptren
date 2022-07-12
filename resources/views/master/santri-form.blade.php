<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button class="close" data-dismiss="modal" aria-hidden="true" type="button">x</button>
            <h4 class="modal-title">Edit</h4>
        </div>
        <form id="form" action="{{ route('santri.update', encrypt($data->kode_santri)) }}" method="put">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" onkeyup="this.value=(this.value).toUpperCase()" value="{{ $data->nama_lengkap }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Jenis Kelamin</label>
                            <div class="d-flex justify-content-start">
                                <div class="custom-control custom-radio mr-2">
                                    <input type="radio" name="jenis_kelamin" id="laki" value="L" {{ $data->jenis_kelamin == 'L' ? 'checked' : '' }} class="custom-control-input">
                                    <label for="laki" class="custom-control-label">Laki-laki</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" name="jenis_kelamin" id="perempuan" value="L" {{ $data->jenis_kelamin == 'P' ? 'checked' : '' }} class="custom-control-input">
                                    <label for="perempuan" class="custom-control-label">Perempuan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" onkeyup="this.value=(this.value).toUpperCase()" value="{{ $data->tempat_lahir }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Tanggal Lahir</label>
                            <input type="text" name="tanggal_lahir" readonly value="{{ reverseDate($data->tanggal_lahir) }}" class="form-control datepicker">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Nomor Handphone</label>
                            <input type="text" class="form-control" name="nomor_handphone" value="{{ $data->nomor_handphone }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" value="{{ $data->email }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Alamat</label>
                            <textarea name="alamat" rows="5" class="form-control">{{ $data->alamat }}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Universitas</label>
                            <input type="text" name="universitas" onkeyup="this.value=(this.value).toUpperCase()" value="{{ $data->universitas }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Fakultas</label>
                            <input type="text" name="fakultas" onkeyup="this.value=(this.value).toUpperCase()" value="{{ $data->fakultas }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Program Studi</label>
                            <input type="text" name="program_studi" onkeyup="this.value=(this.value).toUpperCase()" value="{{ $data->prodi }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label for="">Semester</label>
                            <input type="number" name="semester" value="{{ $data->semester }}" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="lulus" class="custom-control-input" name="lulus">
                                <label for="lulus" class="custom-control-label">Tandai sudah lulus</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-none" id="tahun-lulus">
                        <div class="form-group">
                            <label for="">Tahun Lulus</label>
                            <input type="text" name="tahun_lulus" placeholder="Tahun Lulus" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 d-none" id="pekerjaan">
                        <div class="form-group">
                            <label for="">Pekerjaan</label>
                            <input type="text" name="pekerjaan" placeholder="Pekerjaan" class="form-control">
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