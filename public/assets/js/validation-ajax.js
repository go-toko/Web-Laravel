$(function () {
    $("#main_form").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            processData: false,
            dataType: 'json',
            contentType: false,
            beforeSend: function () {
                $(document).find('div.error-text').text('');
                $('#main_form input').removeClass('is-valid is-invalid');
                $('.invalid-feedback').text('');
            },
            success: function (data) {
                if (data.status == 0) {
                    $.each(data.error, function (prefix, val) {
                        var inputElem = $('input[name="' + prefix + '"]');
                        inputElem.addClass('is-invalid');
                        inputElem.next('.invalid-feedback').text(val[0]);
                    });
                    toastr.error(data.msg, 'Error')
                } else {
                    $('#main_form')[0].reset();
                    toastr.success(data.msg, 'Success');
                    document.getElementById('submit').disabled=true;
                    setTimeout(function () {
                        location.reload();
                    }, 2000)
                }
            }
        });
    });
});