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
                    <b>Pembayaran Gaji</b>
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

        var gajiJs = function(){
            const indexURL = `{{ route('pembayaran-gaji.index') }}`,
                tableID = 'pembayarangaji-table'

            $('.add').on('click', function(){
                loader()
                let initFunction = function(){
                    bsDatePicker('[name="periode"]', {
                        format: 'mm-yyyy',
                        autoclose: true,
                        todayHighlight: true,
                        zIndexOffset: 999,
                        minViewMode: 1
                    }, 'changeDate', function(e){
                        const date = e.target.value
                        show(`{{ url('keuangan/pengeluaran/pembayaran-gaji') }}/${date}`)
                    })
                }

                handleAction(`{{ route('pembayaran-gaji.create') }}`, initFunction)
            })

            function show(url){
                loader()
                $.ajax({
                    url,
                    method: 'get',
                    success: function(res){
                        $('#tampil').html(res)
                    },
                    error: function(e){
                        const message = e.responseJSON?.message
                        toastInit('error', message)
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
        }()
    </script>
@endpush