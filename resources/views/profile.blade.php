@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-3">
                    <b>Profile</b>
                </h4>
                <form action="{{ url('profile') }}" id="form" method="put">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nama Lengkap</label>
                                <input type="text" value="{{ auth()->user()->nama_lengkap }}" name="nama_lengkap" class="form-control-plaintext border-bottom">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" value="{{ auth()->user()->email }}" name="email" class="form-control-plaintext border-bottom">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Nomor Handphone</label>
                                <input type="text" value="{{ auth()->user()->no_hp }}" name="nomor_handphone" class="form-control-plaintext border-bottom">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Username</label>
                                <input type="text" value="{{ auth()->user()->username }}" disabled class="form-control-plaintext border-bottom">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <button class="btn btn-primary btn-proses" type="submit">Simpan</button>
                                <button class="btn btn-outline-primary waves-effect ganti-password" type="button">Ganti Password</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        'use strict'

        var profileJs = function(){
            const form = $('#form')

            form.on('submit', function(e){
                e.preventDefault()

                btnLoader()

                form.find('.invalid-feedback').remove()
                form.find('.is-invalid').removeClass('is-invalid')

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(res){
                        toastInit(res.status, res.message)
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
                            toastInit('error', e.responseJSON?.message)
                        }
                    },
                    complete: function(){
                        btnLoader('Simpan')
                    }
                })
            })

            $('.ganti-password').on('click', function(){
                $.ajax({
                    url: `{{ url('ganti-password') }}`,
                    method: 'get',
                    success: function(res){
                        callModal(res)
                        store('user-table', `{{ url('profile') }}`)
                    },
                    error: function(e){
                        const error = e.responseJSON?.message
                        toastInit('error', error)
                    }
                })
            })
        }()
    </script>
@endpush