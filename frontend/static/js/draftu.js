const token = localStorage.getItem('token');


function send() {
    var id = $('#reply1').html();
    var to = $('#to1').val();

    var data = {
        id: id,
        to: to
    }

    console.log(data);

    // if ($('#reply1').val().length)
    //     data['reply'] = $('#reply1').val()

    $.ajax({
        async: true,
        url: api + '/senddraft',
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
                swal(res);
            }

        },
        error: function (xhr, ajaxOptions, thrownError) {
            let res = xhr.responseJSON;
            swal(res.error);
        },
    });
}

function update() {
    var id = $('#reply1').html();
    var subject = $('#subject1').val();
    var message = $('#message1').val();

    var data = {
        id: id,
        subject: subject,
        message: message
    }

    // if ($('#reply1').val().length)
    //     data['reply'] = $('#reply1').val()

    $.ajax({
        async: true,
        url: api + '/draftupdate',
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
                swal(res);
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

function init() {
    let msgID = document.getElementById('reply1').innerHTML;
    // console.log(msgID);
    $.ajax({
        async: true,
        url: api + '/message?id=' + msgID,
        method: "GET",
        headers: {
            "Authorization": "Bearer " + token
        },
        success: function (res, textStatus, xmLHttpRequest) {
            console.log(res);
            if (res['success']) {
                console.log(res);
                document.getElementById('to1').value = res['message']['to'];
                document.getElementById('subject1').value = res['message']['subject'];
                document.getElementById('message1').value = res['message']['content']

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
    console.log($('#reply1').val().length);
    checkAll();
    init();
});