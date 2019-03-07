var token = localStorage.getItem('token');

function login() {
    var username = $('#email1').val();
    var password = $('#pass1').val();

    var data = {
        username: username,
        password: password
    }

    console.log(data);

    $.ajax({
        async: true,
        url: api + '/login',
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "cache-control": "no-cache",
        },
        processData: false,
        data: JSON.stringify(data),
        success: function (res, textStatus, xmLHttpRequest) {
            if (res['success']) {
                localStorage.setItem('token', res.token);
                location.href = '/index.html'
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            let res = xhr.responseJSON;
            swal(res);
        },
    });

}

function register() {


    var username = $('#userx').val();
    var password = $('#pass2').val();
    var name = $('#name2').val();
    var phoneNumber = $('#pno2').val();

    var data = {
        username: username,
        password: password,
        name: name,
        phoneNumber: phoneNumber
    }

    console.log($('#userx').val());

    $.ajax({
        async: true,
        url: api + '/register',
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "cache-control": "no-cache",
        },
        processData: false,
        data: JSON.stringify(data),
        success: function (res, textStatus, xmLHttpRequest) {
            if (res['success']) {
                swal("Registration Successful Please Login");
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            let res = xhr.responseJSON;
            swal(res.error);
        },
    });


}


function checkAll() {

    if (!token)
        return;

    console.log(token);

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
                location.href = '/index.html'
            } else {
                localStorage.removeItem('token');
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            localStorage.removeItem('token');
        },
    });

}

$(document).ready(function () {
    checkAll();
});