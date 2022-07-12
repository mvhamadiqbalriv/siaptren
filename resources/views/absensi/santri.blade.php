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
                <h4 class="header-title mb-2">
                    <b>Absensi Santri</b>
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

        var absensiSantriJs = function(){
            const indexURL = `{{ route('absensi-santri.index') }}`,
                tableID = 'absensisantri-table'

            $('.add').on('click', function(){
                loader()
                let initFunction = function(){
                    tanggal()
                    jadwal()
                }
                handleAction(`{{ route('absensi-santri.create') }}`, initFunction)
            })

            $('#absensisantri-table').on('click', '.edit', function(){
                let id = $(this).data('id'),
                    url = `{{ url('absensi/data/santri') }}/${id}/edit`,
                    initFunction = function(){
                        editKehadiran()
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

            function tanggal(){
                $('[name="tanggal"]').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    zIndexOffset: 999
                }).on('changeDate', function(e){
                    let tanggal = e.currentTarget.value

                    $('#list').html('')
                    $.ajax({
                        url: `{{ url('absensi/data/santri/jadwal') }}/${tanggal}`,
                        method: 'get',
                        success: function(res){
                            let placeholder = res.total ? 'Pilih Jadwal' : 'Tidak ada jadwal'
    
                            $('[name="jadwal"]').html(`<option selected disabled>${placeholder}</option>`)
                            $.each(res.jadwal, function(key, jadwal){
                                $('[name="jadwal"]').append(`<option value="${jadwal.kode_jadwal}">${jadwal.nama_mapel} (${jadwal.nama_lengkap})</option>`)
                            })
                        },
                        error: function(e){
                            toastInit('error', e.responseJSON?.message)
                        }
                    })
                })
            }

            function jadwal(){
                $('[name="jadwal"]').on('change', function(){
                    let kode = $(this).val(),
                        tanggal = $('[name="tanggal"]').val()

                    $.ajax({
                        url: `{{ url('absensi/data/santri/list') }}/${kode}/tanggal/${tanggal}`,
                        method: 'get',
                        success: function(res){
                            $('#list').html(res)
                            kehadiran()
                        },
                        error: function(e){
                            toastInit('error', e.responseJSON?.message)
                        }
                    })
                })
            }

            function kehadiran(){
                $('[name="kehadiran"]').on('change', function(e){
                    let kehadiran = $(this).val()

                    let props = {
                        title: 'Simpan kehadiran ?',
                        type: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Simpan',
                        cancelButtonText: 'Batal'
                    }

                    if (kehadiran == 'I') {
                        props.input = 'textarea'
                        props.inputAttributes = {
                            autocapitalize: 'off',
                            placeholder: 'Isi keterangan',
                            required: true
                        }
                    }         

                    fixBootstrapModal()
                    Swal.fire(props).then((res) => {
                        let select = $(this),
                            id = $(this)[0].id,
                            options = $(this)[0].options

                        let selected = options[options.selectedIndex].text

                        if (res.value) {
                            let keterangan = res.value === true ? null : res.value
                            $.ajax({
                                url: "{{ route('absensi-santri.store') }}",
                                method: "post",
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    tanggal: $('[name="tanggal"]').val(),
                                    jadwal: $('[name="jadwal"]').val(),
                                    kehadiran: select.val(),
                                    keterangan,
                                    id: id
                                },
                                success: function(response){
                                    select.parent().html(response.html)
                                    window.LaravelDataTables[tableID].ajax.reload()
                                },
                                error: function(e){
                                    toastInit('error', e.responseJSON?.message)
                                    $(select.children()[0]).prop('selected', true)
                                }
                            })
                        }else if (res.dismiss) {
                            restoreBootstrapModal()
                            $(select.children()[0]).prop('selected', true)
                        }
                    })
                })
            }

            function editKehadiran(){
                $('.kehadiran').on('change', function(e){
                    let kehadiran = e.target.value,
                        id = $(this).data('id'),
                        parent = $(this).parents(`.parent-${id}`)
                    if (kehadiran == 'I') {
                        parent.children('.keterangan').removeClass('d-none')
                    }else{
                        parent.children('.keterangan').addClass('d-none')
                    }
                })
            }

            // call this before showing SweetAlert:
            function fixBootstrapModal() {
                var modalNode = document.querySelector('.modal[tabindex="-1"]');
                if (!modalNode) return;

                modalNode.removeAttribute('tabindex');
                modalNode.classList.add('js-swal-fixed');
            }

            // call this before hiding SweetAlert (inside done callback):
            function restoreBootstrapModal() {
                var modalNode = document.querySelector('.modal.js-swal-fixed');
                if (!modalNode) return;

                modalNode.setAttribute('tabindex', '-1');
                modalNode.classList.remove('js-swal-fixed');
            }
        }()
    </script>
@endpush