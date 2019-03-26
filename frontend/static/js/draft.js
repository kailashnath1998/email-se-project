const token = localStorage.getItem('token');

function generate(from, subject, id) {
    return `
    <button type="button" class="btn btn-info btn-lg btn-block" data-toggle="modal" data-target="#${id}">${from}<br><br>${subject}</button>`
}

function generate_modal(from, subject, time, message, to, id) {
    return `
    
    <div class="modal fade" id="${id}" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">View Message</h4>
        </div>
        <div class="modal-body">
          <p>From : ${from}</p>
          <p>To   : ${to}</p>
          <p>Time : ${time}</p>
          <p>Subject : ${subject}</p>
          <p>Message : <br> ${message}</p>
          <br>
          <button type="button" class="btn btn-default" onclick="location.href='/${id}?type=dedit'">Edit and Send</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
    `
}


function recive(category) {

    $.ajax({
        async: true,
        url: api + '/alldraft',
        method: "GET",
        headers: {
            "Authorization": "Bearer " + token
        },
        success: function (res, textStatus, xmLHttpRequest) {
            console.log(res);
            let content = $('#content');
            let modals = $('#modals');
            content.empty();
            modals.empty();
            if (res['success']) {
                res['message'].reverse().forEach(element => {
                    content.append(generate(element.from, element.subject, element.id));
                    modals.append(generate_modal(element.from, element.subject, element.updated_at, element.content, element.to, element.id));
                });
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



async function checkAll() {

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

function refresh() {
    recive('primary');
}

$(document).ready(function () {
    checkAll();
    recive('primary');
});