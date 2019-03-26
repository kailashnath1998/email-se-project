
function contact() {
    var name = $('#name').val();
    var email = $('#email').val();
    var subject = $('#subject').val();
    var message = $('#message').val();

    var data = {
        name: name,
        email: email,
        subject: subject,
        message: message
    }

    console.log(data);

    $.ajax({
        async: true,
        url: api + '/contact',
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "cache-control": "no-cache",
        },
        processData: false,
        data: JSON.stringify(data),
        success: function (res, textStatus, xmLHttpRequest) {
            if (res['success']) {
                swal(res.message).then(function () {
                    location.href = '/';
                });
            } else {
                swal(res.message || res.error);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            let res = xhr.responseJSON;
            swal(res.message || res.error);
        },
    });
}

$(document).ready(function () {
    // Test for placeholder support

}); 