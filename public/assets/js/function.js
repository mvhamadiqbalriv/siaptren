'use strict'

function callModal(element) {
    $('#modal-primer').html(element)
    $('#modal-primer').modal('show')
}

function loader(props = null, element = null) {
    if (element) {
        element.block(props)
    } else {
        $.blockUI({
            message: '<div class="d-flex justify-content-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>',
            css: {
                backgroundColor: 'transparent',
                border: 'none'
            }
        })
    }
}

function btnLoader(text = null){
    if (text) {
        $('.btn-proses')
            .removeAttr('disabled')
            .text(text)
    } else {
        $('.btn-proses')
            .attr('disabled', true)
            .html(`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Memproses...`)
    }
}

function toastInit(status, message){
    let loaderBg, heading
    if (status == 'success') {
        loaderBg = "#5ba035"
        heading = "Sukses!"
    } else {
        loaderBg = "#bf441d"
        heading = "Gagal!"
    }

    $.toast({
        heading,
        text: message,
        position: "top-right",
        loaderBg,
        icon: status,
        hideAfter: 3e3,
        stack: 1
    })
}

function store(tableID, indexURL){
    const form = $('#form')
    
    form.validate({
        submitHandler: function(){
            btnLoader()
            
            form.find('.invalid-feedback').remove()
            form.find('.is-invalid').removeClass('is-invalid')
            
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(res){
                    $('#modal-primer').modal('hide')
                    if (res.shouldReload || res.reloadURL) {
                        setTimeout(() => {
                            window.location.href = res.reloadURL ?? indexURL
                        }, 3500);
                    } else {
                        window.LaravelDataTables[tableID].ajax.reload()
                    }

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
                complete: function(e){
                    btnLoader('Simpan')
                }
            })
        }
    })
}

function bsDatePicker(selector, options = {}, event = null, callback = null){
    let datePicker = $(selector).datepicker(options)

    if (event) {
        datePicker.on(event, callback)
    }
}

function formatRupiah(value){
    value = value.split(',')
    let number = value[0].replace(/[^\d]/g, '')

    var number_format = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0
    })

    if (number == 0) return '';
    return number_format.format(number)
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

$(document).ajaxStop($.unblockUI);
