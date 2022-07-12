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
                <h4 class="header-title mb-2">
                    <b>Daftar Asatidz</b>
                </h4>
                <div class="sub-header">
                    @can('create '. request()->path())
                    <button class="btn btn-sm btn-primary add">Tambah</button>
                    @endcan
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

        var asatidzJs = function(){
            const indexURL = `{{ route('asatidz.index') }}`,
                tableID = 'asatidz-table'

            $('.add').on('click', function(){
                loader()
                handleAction(`{{ route('asatidz.create') }}`)
            })

            $('#asatidz-table').on('click', '.action', function(){
                let jenis = $(this).data('jenis'),
                    id = $(this).data('id')

                let url, initFunction
                if (jenis == 'edit') {
                    initFunction = function(){
                        switchBox()
                    }
                    url = `{{ url('master/civitas/asatidz') }}/${id}/edit`                    
                }else if (jenis == 'upload') {
                    initFunction = function(){
                        upload()
                    }
                    url = `{{ url('master/civitas/asatidz/upload') }}/${id}`                    
                }else if (jenis == 'detail') {
                    url = `{{ url('master/civitas/asatidz') }}/${id}`                    
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

            function switchBox(){
                $('[data-plugin="switchery"]').each(function(){
                    new Switchery($(this)[0], $(this).data())
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
                                btnLoader('Daftar')
                            }
                        })
                    }
                })
            }

            return {
                switchBox
            }
        }()
    </script>
@endpush