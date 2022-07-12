@extends('layouts.master')
@push('css')
    <!-- third party css -->
    <link href="{{ asset('') }}assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('') }}assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title mb-3">
                    <b>Daftar Alumni</b>
                </h4>
                <div class="sub-header">
                    @if (auth()->user()->hasRole(['admin', 'pimpinan_pesantren']))
                    <a class="btn btn-sm btn-primary" href="{{ route('alumni.export') }}">Export</a>
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
@endpush
@push('js')
    {{ $dataTable->scripts() }}

    <script>
        'use strict'

        var alumniJs = function(){
            const indexURL = `{{ route('alumni.index') }}`,
                tableID = 'alumni-table'

            $('#alumni-table').on('click', '.action', function(){
                let jenis = $(this).data('jenis'),
                    id = $(this).data('id')

                let url, initFunction = null
                if (jenis == 'edit') {
                    url = `{{ url('master/civitas/alumni') }}/${id}/edit`                    
                }else if (jenis == 'detail') {
                    url = `{{ url('master/civitas/alumni') }}/${id}`
                }else {
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