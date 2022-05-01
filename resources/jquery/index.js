window.start_load = function () {
    $('body').prepend('<div id="preloader2"></div>')
}
window.end_load = function () {
    $('#preloader2').fadeOut('fast', function () {
        $(this).remove();
    })
}
window.AJAXX = function ($url, $data) {
    $.ajax({
        url: $url,
        method: 'POST',
        data: $data,
        error: err => {
            console.log(err);
        },
        success: function (resp) {
            return resp;
        }
    })
}
window.uni_modal = function ($title = '', $url = '') {
    start_load()
    $.ajax({
        url: $url,
        error: err => {
            console.log()
            alert("An error occured")
        },
        success: function (resp) {
            if (resp) {
                if ($title !== "Delete User") {
                    $('#uni_modal .modal-title').html($title)
                    $('#uni_modal .modal-body').html(resp)
                    $('#uni_modal').modal('show')
                }
                end_load()
            }
        }
    })
}
window._conf = function ($msg = '', $func = '', $params = []) {
    $('#confirm_modal #confirm').attr('onclick', $func + "(" + $params.join(',') + ")")
    $('#confirm_modal .modal-body').html($msg)
    $('#confirm_modal').modal('show')
}
window.alert_toast = function ($msg = 'TEST', $bg = 'success') {
    $('#alert_toast').removeClass('bg-success')
    $('#alert_toast').removeClass('bg-danger')
    $('#alert_toast').removeClass('bg-info')
    $('#alert_toast').removeClass('bg-warning')

    if ($bg == 'success')
        $('#alert_toast').addClass('bg-success')
    if ($bg == 'danger')
        $('#alert_toast').addClass('bg-danger')
    if ($bg == 'info')
        $('#alert_toast').addClass('bg-info')
    if ($bg == 'warning')
        $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    $('#alert_toast').toast({ delay: 3000 }).toast('show');
}
$(document).ready(function () {
    $('#preloader').fadeOut('fast', function () {
        $(this).remove();
    })
})