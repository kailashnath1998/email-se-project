const token = localStorage.getItem('token');


function change() {
    var crrpassword = $('#crr1').val();
    var password = $('#pass').val();

    var data = {
        crrpassword: crrpassword,
        password: password
    }

    // if ($('#reply1').val().length)
    //     data['reply'] = $('#reply1').val()

    $.ajax({
        async: true,
        url: api + '/changepassword',
        method: "POST",
        headers: {
            "Authorization": "Bearer " + token,
            "Content-Type": "application/json",
            "cache-control": "no-cache",
        },
        processData: false,
        data: JSON.stringify(data),
        success: function (res, textStatus, xmLHttpRequest) {
            if (res['success']) {
                swal(res.message);
            } else {
                swal(res.message || res.error);
            }

        },
        error: function (xhr, ajaxOptions, thrownError) {
            let res = xhr.responseJSON;
            swal(res.error);
        },
    });
}

function logout() {
    $.ajax({
        async: true,
        url: api + '/user',
        method: "GET",
        headers: {
            "Authorization": "Bearer " + token
        },
        success: function (res, textStatus, xmLHttpRequest) {
        },
        error: function (xhr, ajaxOptions, thrownError) {
        },
    });

    localStorage.removeItem('token');
    location.href = '/login.html';
}


function checkAll() {

    if (!token)
        location.href = '/login.html';


    $.ajax({
        async: true,
        url: api + '/user',
        method: "GET",
        headers: {
            "Authorization": "Bearer " + token
        },
        success: function (res, textStatus, xmLHttpRequest) {
            console.log(res);
            if (res['success']) {
                return;
            } else {
                localStorage.removeItem('token');
                location.href = '/login.html';
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            localStorage.removeItem('token');
            location.href = '/login.html';
        },
    });

}

$(document).ready(function () {
    checkAll();
});