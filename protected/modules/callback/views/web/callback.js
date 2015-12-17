function callbackSendForm(form, data, hasError) {
    if (hasError) return false;

    $.ajax({
        url: yupeCallbackSendUrl,
        type: 'POST',
        data: form.serialize(),
        success: function (response) {
            if (response.result) {
                document.getElementById("callback-form").reset();
            }
            $('#callback-link').click();
            $('#notifications').html('<div>' + response.data + '</div>').fadeIn().delay(3000).fadeOut();
        },
        error: function () {
            $('#callback-request').click();
            $('#notifications').html(yupeCallbackErrorMessage).fadeIn().delay(3000).fadeOut();
        }
    });
    return false;
}