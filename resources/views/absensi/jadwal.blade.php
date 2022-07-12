@extends('layouts.master')
@push('css')
    <!-- third party css -->
    <link href="{{ asset('') }}assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/select2/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/switchery/switchery.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-2">
                    <b>Jadwal Mata Pelajaran</b>
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

        var jadwalJs = function(){
            const indexURL = `{{ route('jadwal.index') }}`,
                tableID = 'jadwal-table'

            $('.add').on('click', function(){
                loader()
                let initFunction = function(){
                    select2Init()
                }
                handleAction(`{{ route('jadwal.create') }}`, initFunction)
            })

            $('#jadwal-table').on('click', '.edit', function(){
                let id = $(this).data('id'),
                    url = `{{ url('absensi/jadwal') }}/${id}/edit`,
                    initFunction = function(){
                        switchBox()
                        select2Init()
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

            function select2Init(){
                $('.select2').select2({
                    placeholder: $(this).data('placeholder')
                })
            }

            function switchBox(){
                $('[data-plugin="switchery"]').each(function(){
                    new Switchery($(this)[0], $(this).data())
                })
            }
        }()
    </script>
@endpush