@extends('layouts.master')
@push('css')
    <!-- third party css -->
    <link href="{{ asset('') }}assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />

    <link href="{{ asset('') }}assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-3">
                    <b>Pembayaran SPP</b>
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

    <script src="{{ asset('') }}assets/libs/select2/select2.min.js"></script>
    <script src="{{ asset('') }}assets/libs/sweetalert2/sweetalert2.min.js"></script>
@endpush
@push('js')
    {{ $dataTable->scripts() }}

    <script>
        'use strict'

        var sppJs = function(){
            const indexURL = `{{ route('pembayaran-spp.index') }}`,
                tableID = 'pembayaranspp-table'

            $('.add').on('click', function(){
                loader()
                let initFunction = function(){
                    getSantri()
                }

                handleAction(`{{ route('pembayaran-spp.create') }}`, initFunction)
            })

            $('#pembayaranspp-table').on('click', '.action', function(){
                let jenis = $(this).data('jenis'),
                    id = $(this).data('id')

                let url, initFunction = null
                if (jenis == 'batal') {
                    batal(id)
                    return                 
                }else if (jenis == 'detail') {
                    url = `{{ url('keuangan/pemasukan/pembayaran-spp') }}/${id}`
                }else {
                    return
                }
                handleAction(url, initFunction)

            })

            function batal(id){
                fixBootstrapModal()
                Swal.fire({
                    title: 'Batalkan pembayaran?',
                    type: 'question',
                    input: 'textarea',
                    inputAttributes: {
                        autocapitalize: 'off',
                        placeholder: 'Isi keterangan',
                        required: true
                    },
                    confirmButtonText: 'Ya, Batalkan',
                    showCancelButton: true,
                    cancelButtonText: 'Tutup'
                }).then((res) => {

                    if (res.value) {
                        $.ajax({
                            url: `{{ url('keuangan/pemasukan/pembayaran-spp') }}/${id}`,
                            method: 'put',
                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content'),
                                keterangan: res.value
                            },
                            success: function(res){
                                window.LaravelDataTables[tableID].ajax.reload()
                                toastInit(res.status, res.message)
                            },
                            error: function(e){
                                const message = e.responseJSON?.message
                                toastInit('error', message)
                            }
                        })
                    } else if(res.dismiss) {
                        restoreBootstrapModal()
                    }
                })
            }

            function handleAction(url, initFunction = null){
                loader()
                $.ajax({
                    url,
                    method: 'get',
                    success: function(res){
                        callModal(res)
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

            function getSantri(){
                $('[name="santri"]').select2({
                    ajax: {
                        url: `{{ url('keuangan/pemasukan/pembayaran-spp/santri') }}`,
                        dataType: 'json',
                        delay: 500,
                        data: function(params){
                            var qry = {
                                search: params.term,
                                type: 'public'
                            }

                            return qry
                        }
                    },
                    placeholder: 'Pilih Santri'
                }).on('select2:select', function(e){
                    let id = e.target.value

                    $.ajax({
                        url: `{{ url('keuangan/pemasukan/pembayaran-spp/tunggakan') }}/${id}`,
                        method: 'get',
                        success: function(res){
                            $('.btn-proses').removeClass('d-none')
                            $('.tampil')
                                .removeClass('d-none')
                                .html(res)

                            bsDatePicker('[name="periode_awal"]', {
                                format: 'mm-yyyy',
                                autoclose: true,
                                todayHighlight: true,
                                minViewMode: 1
                            })

                            store(tableID, indexURL)
                        },
                        error: function(e){
                            toastInit('error', e.responseJSON?.message)
                        }
                    })
                })
            }
        }()
    </script>
@endpush