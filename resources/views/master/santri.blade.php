@extends('layouts.master')
@push('css')
    <!-- third party css -->
    <link href="{{ asset('') }}assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-3">
                    <b>Daftar Santri</b>
                </h4>
                <div class="sub-header">
                    @if (auth()->user()->hasRole(['admin', 'pimpinan_pesantren']))
                    <a class="btn btn-sm btn-primary" href="{{ route('santri.export') }}">Export</a>
                    @endif
                </div>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection
@push('vendor')
    <!-- Required datatable js -->
    <script src="{{ asset('') }}assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('') }}assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
     <!-- Responsive examples -->
    <script src="{{ asset('') }}assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="{{ asset('') }}assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script src="{{ asset('') }}assets/libs/switchery/switchery.min.js"></script>
@endpush
@push('js')
    {{ $dataTable->scripts() }}

    <script>
        'use strict'

        var santriJs = function(){
            const indexURL = `{{ route('santri.index') }}`,
                tableID = 'santri-table'

            $('#santri-table').on('click', '.action', function(){
                let jenis = $(this).data('jenis'),
                    id = $(this).data('id')

                let url, initFunction = null
                if (jenis == 'edit') {
                    initFunction = function(){
                        lulus()
                    }
                    url = `{{ url('master/civitas/santri') }}/${id}/edit`                    
                }else if (jenis == 'upload') {
                    initFunction = function(){
                        upload()
                    }
                    url = `{{ url('master/civitas/santri/upload') }}/${id}`                    
                }else if (jenis == 'detail') {
                    url = `{{ url('master/civitas/santri') }}/${id}`
                }else if (jenis == 'verifikasi') {
                    url = `{{ url('master/civitas/santri') }}/${id}?verifikasi=true`
                } else {
                    return false
                }

                handleAction(url, initFunction)
            })

            function handleAction(url, initFunction = null){
                loader()
                $.ajax({
                    url,
                    method: 'get',
                    success: function(res){
                        callModal(res)
                        bsDatePicker('.datepicker', {
                            autoclose: true,
                            todayHighlight: true,
                            zIndexOffset: 999,
                            format: 'dd-mm-yyyy',
                            startView: 2
                        })
                        store(tableID, indexURL)

                        if (initFunction) {
                            initFunction()
                        }
                    },
                    error: function(e){
                        const message = e.responseJSON?.message
                        toastInit('error', message)
                    }
                })
            }

            function upload(){
                const form = $('#upload')
                form.validate({
                    submitHandler: function(_form){

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
                                $('#modal-primer').modal('hide')
                                window.LaravelDataTables[tableID].ajax.reload()

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
                    }
                })
            }

            function lulus(){
                $('[name="lulus"]').on('click', function(e){
                    if (e.target.checked) {
                        $('#tahun-lulus').removeClass('d-none')
                        $('#pekerjaan').removeClass('d-none')
                    } else {
                        $('#tahun-lulus').addClass('d-none')
                        $('#pekerjaan').addClass('d-none')
                    }
                })
            }

            return {
                lulus
            }
        }()
    </script>
@endpush