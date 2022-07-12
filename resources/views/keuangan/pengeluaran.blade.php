@extends('layouts.master')
@push('css')
    <!-- third party css -->
    <link href="{{ asset('') }}assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />

    <link href="{{ asset('') }}assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-3">
                    <b>Pengeluaran Lainnya</b>
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

    <script src="{{ asset('') }}assets/libs/sweetalert2/sweetalert2.min.js"></script>
@endpush
@push('js')
    {{ $dataTable->scripts() }}

    <script>
        'use strict'

        var pengeluaranJs = function(){
            const indexURL = `{{ route('lainnya.index') }}`,
                tableID = 'pengeluaranlainnya-table'

            $('.add').on('click', function(){
                loader()
                let initFunction = function(){
                    bsDatePicker('[name="tanggal"]', {
                        format: 'dd-mm-yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        zIndexOffset: 999
                    })
                }

                handleAction(`{{ route('lainnya.create') }}`, initFunction)
            })

            $('#pengeluaranlainnya-table').on('click', '.batal', function(){
                fixBootstrapModal()
                Swal.fire({
                    title: 'Batalkan pengeluaran?',
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
                    let id = $(this).data('id')

                    if (res.value) {
                        $.ajax({
                            url: `{{ url('keuangan/pengeluaran/lainnya/batal') }}/${id}`,
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
            })

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

        }()
    </script>
@endpush