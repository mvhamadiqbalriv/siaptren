@extends('layouts.master')
@push('css')
    <!-- third party css -->
    <link href="{{ asset('') }}assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-2">
                    <b>Absensi Asatidz</b>
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
    <script src="{{ asset('') }}assets/libs/switchery/switchery.min.js"></script>
@endpush
@push('js')
    {{ $dataTable->scripts() }}

    <script>
        'use strict'

        var absensiasatidzJs = function(){
            const indexURL = `{{ route('absensi-asatidz.index') }}`,
                tableID = 'absensiasatidz-table'

            $('.add').on('click', function(){
                loader()
                let initFunction = function(){
                    kehadiran()
                    select2Init()
                }
                handleAction(`{{ route('absensi-asatidz.create') }}`, initFunction)
            })

            $('#absensiasatidz-table').on('click', '.edit', function(){
                let id = $(this).data('id'),
                    url = `{{ url('absensi/data/asatidz') }}/${id}/edit`,
                    initFunction = function(){
                        kehadiran()
                    }

                handleAction(url, initFunction)
            })

            function select2Init(){
                $('.select2').select2({
                    placeholder: 'Pilih Jadwal'
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

            function kehadiran(){
                $('.kehadiran').on('change', function(e){
                    let kehadiran = e.target.value,
                        parent = $(this).parents(`.row`)
                        
                    if (kehadiran == 'I') {
                        parent.children('.keterangan').removeClass('d-none')
                    }else{
                        parent.children('.keterangan').addClass('d-none')
                    }
                })
            }
        }()
    </script>
@endpush