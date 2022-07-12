<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Abstack - Responsive Bootstrap 4 Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('') }}assets/images/favicon.ico">

    <!-- App css -->
    <link href="{{ asset('') }}assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/pendaftaran.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/jquery-toast/jquery.toast.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/css/override.css" rel="stylesheet" type="text/css" />
    <style>
        .custom-control{
            margin-top: .4rem !important;
        }

        @media (max-width:991px){
            .wrapper{
                padding-top: 100px !important;
            }
        }
    </style>

</head>

<body>

    <!-- Navigation Bar-->
    <header id="topnav">


        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <li class="dropdown notification-list">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                    <li class="dropdown notification-list">
                        <a href="javascript:void(0);" class="nav-link">
                            <button class="btn btn-light waves-effect" type="button">Alur Pendaftaran</button>
                        </a>
                    </li>

                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="index.html" class="logo text-center">
                        <span class="logo-lg">
                            <img src="assets/images/logo-light.png" alt="" height="16">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                        </span>
                        <span class="logo-sm">
                            <!-- <span class="logo-sm-text-dark">U</span> -->
                            <img src="assets/images/logo-sm.png" alt="" height="24">
                        </span>
                    </a>
                </div>

            </div> <!-- end container-fluid-->
        </div>
        <!-- end Topbar -->

    </header>
    <!-- End Navigation Bar-->

    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="header-title"><b>Isi Formulir Pendaftaran</b></h4>
                        <p class="sub-header">
                            Pastikan data yang diinput merupakan data-data yang benar dan sesuai dengan dokumen negara yang berlaku. Bagi yang sudah melakukan pendaftaran silahkan download formulir <a href="javascript:void(0)" data-toggle="modal" data-target="#download">disini</a>.
                        </p>

                        <div class="modal fade" id="download" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="modal-title">
                                            <h4>Download Formulir</h4>
                                            <button class="close" type="button" aria-hidden="true" data-dismiss="modal">x</button>
                                        </div>
                                    </div>
                                    <form action="{{ url('pendaftaran/download-formulir') }}" id="form-download" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="">Alamat Email Terdaftar</label>
                                                        <input type="text" name="email" autocomplete="off" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="alert alert-warning">
                                                        <div class="alert-body">
                                                            Pastikan alamat email merupakan alamat email milik anda yang sebelumnya digunakan untuk pendaftaran.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary btn-proses" type="submit">Download Formulir</button>
                                            <button class="btn btn-outline-primary" data-dismiss="modal" type="button">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <form id="form-daftar" action="{{ route('pendaftaran') }}" method="POST" accept="multipart/form-data">
                            @csrf
                            <h3>A. Data Diri</h3>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="nama_lengkap">Nama Lengkap *</label>
                                        <input class="form-control " id="nama_lengkap" name="nama_lengkap" type="text">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="jenis_kelamin"> Jenis Kelamin *</label>
                                        <div class="d-flex justify-content-start">
                                            <div class="custom-control custom-radio mr-2">
                                                <input type="radio" id="laki" name="jenis_kelamin" class="custom-control-input" value="L">
                                                <label for="laki" class="custom-control-label">Laki-laki</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="perempuan" name="jenis_kelamin" class="custom-control-input" value="P">
                                                <label for="perempuan" class="custom-control-label">Perempuan</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="tempat_lahir">Tempat Lahir *</label>
                                        <input id="tempat_lahir" name="tempat_lahir" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="tanggal_lahir">Tanggal Lahir *</label>
                                        <input id="tanggal_lahir" readonly name="tanggal_lahir" type="text" class="datepicker form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="nomor_handphone">Nomor Handphone *</label>
                                        <input id="nomor_handphone" name="nomor_handphone" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="alamat_email">Alamat Email *</label>
                                        <input id="alamat_email" name="alamat_email" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="control-label" for="alamat">Alamat *</label>
                                        <textarea name="alamat" id="alamat" rows="5" class="form-control "></textarea>
                                    </div>
                                </div>
                            </div>
                            <h3>B. Pendidikan</h3>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="universitas">Universitas *</label>
                                        <input id="universitas" name="universitas" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="fakultas">Fakultas *</label>
                                        <input id="fakultas" name="fakultas" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="program_studi">Program Studi *</label>
                                        <input id="program_studi" name="program_studi" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label" for="semester">Semester *</label>
                                        <input id="semester" name="semester" type="number" class=" form-control">
                                    </div>
                                </div>
                            </div>
                            <h3>C. Data Orangtua/Wali</h3>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="nama_ayah">Nama Ayah *</label>
                                        <input id="nama_ayah" name="nama_ayah" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="pekerjaan_ayah">Pekerjaan Ayah *</label>
                                        <input id="pekerjaan_ayah" name="pekerjaan_ayah" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="nomor_telepon_ayah">Nomor Telepon Ayah</label>
                                        <input id="nomor_telepon_ayah" name="nomor_telepon_ayah" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="nama_ibu">Nama Ibu *</label>
                                        <input id="nama_ibu" name="nama_ibu" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="pekerjaan_ibu">Pekerjaan Ibu *</label>
                                        <input id="pekerjaan_ibu" name="pekerjaan_ibu" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="nomor_telepon_ibu">Nomor Telepon Ibu</label>
                                        <input id="nomor_telepon_ibu" name="nomor_telepon_ibu" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="alamat_orangtua">Alamat Orangtua *</label>
                                        <textarea name="alamat_orangtua" id="alamat_orangtua" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="nama_wali">Nama Wali</label>
                                        <input id="nama_wali" name="nama_wali" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="pekerjaan_wali">Pekerjaan Wali</label>
                                        <input id="pekerjaan_wali" name="pekerjaan_wali" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label" for="nomor_telepon_wali">Nomor Telepon Wali</label>
                                        <input id="nomor_telepon_wali" name="nomor_telepon_wali" type="text" class=" form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="alamat_wali">Alamat Wali</label>
                                        <textarea name="alamat_wali" id="alamat_wali" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <h3>D. Berkas</h3>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class="control-label">KTP</label>
                                        <input type="file" name="ktp" class="form-control-file">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class="control-label">KK</label>
                                        <input type="file" name="kk" class="form-control-file">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="" class="control-label">Foto 3x4</label>
                                        <input type="file" name="foto" class="form-control-file">
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-primary waves-effect btn-proses" type="submit">Daftar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- end container -->
    </div>
    <!-- end wrapper -->

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    {{ date('Y') }} &copy; SIAPtren
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- Vendor js -->
    <script src="{{ asset('') }}assets/js/vendor.min.js"></script>
    <script src="{{ asset('') }}assets/libs/blockUI/jquery.blockUI.js"></script>
    <script src="{{ asset('') }}assets/libs/jquery-validate/jquery.validate.min.js"></script>
    <script src="{{ asset('') }}assets/libs/jquery-toast/jquery.toast.min.js"></script>
    <script src="{{ asset('') }}assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <!-- App js -->
    <script src="{{ asset('') }}assets/js/app.min.js"></script>
    <script>
        'use strict'
        var pendaftaranJs = function(){
            const form = $('#form-daftar')
            form.validate({
                submitHandler: function(_form){
                    $.blockUI({
                        message: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>',
                        css: {
                            backgroundColor: 'transparent',
                            border: 'none'
                        }
                    })

                    btnLoader()
                    form.find('.invalid-feedback').remove()
                    form.find('.is-invalid').removeClass('is-invalid')
                    
                    let data = new FormData(_form)

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: form.attr('action'),
                        method: form.attr('method'),
                        data: data,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function(res){
                            const kode = res.kode
                            setTimeout(() => {
                                window.location.href = `{{ url('pendaftaran/success') }}/${kode}`
                            }, 2000);

                            $.toast({
                                heading: 'Sukses',
                                text: 'Pendaftaran berhasil',
                                position: 'top-right',
                                loaderBg: "#bf441d",
                                icon: 'success',
                                hideAfter: 3e3,
                                stack: 1
                            })
                        },
                        error: function(e){
                            const errors = e.responseJSON?.errors

                            if ($.isEmptyObject(errors) === false) {
                                let no = 0;
                                $.each(errors, function(key, message){
                                    no++;
                                    $(`[name="${key}"]`)
                                        .addClass('is-invalid')
                                        .parents('.form-group')
                                        .append(`<div class="invalid-feedback">${message[0]}</div>`)

                                    if(no == 1) $(`[name="${key}"]`).focus()
                                })
                                $('.invalid-feedback').css('display', 'block')
                            }else{
                                $.toast({
                                    heading: 'Gagal!',
                                    text: e.responseJSON?.message,
                                    position: "top-right",
                                    loaderBg: "#bf441d",
                                    icon: status,
                                    hideAfter: 3e3,
                                    stack: 1
                                })
                            }
                        },
                        complete: function(){
                            btnLoader('Daftar')
                        }
                    })
                }
            })

            $('.datepicker').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                zIndexOffset: 9999,
                startView: 2
            })

            $(document).ajaxStop($.unblockUI);

            function btnLoader(text = null){
                if (text) {
                    $('.btn-proses')
                        .removeAttr('disabled')
                        .text(text)
                } else {
                    $('.btn-proses')
                        .attr('disabled', true)
                        .html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Memproses...`)
                }
            }

            const formDownload = $('#form-download')
            formDownload.validate({
                submitHandler: function(){
                    btnLoader()

                    formDownload.find('.invalid-feedback').remove()
                    formDownload.find('.is-invalid').removeClass('is-invalid')
                    $.ajax({
                        url: formDownload.attr('action'),
                        method: formDownload.attr('method'),
                        data: formDownload.serialize(),
                        success: function(res){
                            $('#download').modal('hide')
                            window.location.href = `{{ url('pendaftaran/download-formulir') }}/${res.id}`
                        },
                        error: function(e){
                            const errors = e.responseJSON?.errors

                            if ($.isEmptyObject(errors) === false) {
                                $.each(errors, function(key, error){
                                    $(`[name="${key}"]`)
                                        .addClass('is-invalid')
                                        .parents('.form-group')
                                        .append(`<div class="invalid-feedback">${error[0]}</div>`)
                                })
                            }else{
                                $.toast({
                                    heading: 'Gagal!',
                                    text: e.responseJSON?.message,
                                    position: "top-right",
                                    loaderBg: "#bf441d",
                                    icon: status,
                                    hideAfter: 3e3,
                                    stack: 1
                                })
                            }
                        },
                        complete: function(){
                            btnLoader('Download Formulir')
                        }
                    })
                }
            })
        }()
    </script>

</body>

</html>
