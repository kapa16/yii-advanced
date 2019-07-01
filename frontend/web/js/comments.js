if (!window.WebSocket) {
    alert('Need update browser');
}

$('#comments_form').on('beforeSubmit', function (event) {
    const form = event.target;
    const jsonData = JSON.stringify({
        identity: 0,
        taskId: form.dataset.taskId,
        userId: form.dataset.userId,
        comment: form.comment_text.value,
    });
    webSocket.send(jsonData);
    form.comment_text.value = '';
    return false;
});

const form = document.getElementById('comments_form');

const webSocket = new WebSocket('ws://yii.local:8080');


webSocket.addEventListener('open', function (event) {
    const identityData = JSON.stringify({
        identity: 1,
        taskId: form.dataset.taskId,
        userId: form.dataset.userId,
    });
    webSocket.send(identityData);
});

webSocket.addEventListener('message', function (event) {
    "use strict";
    event.preventDefault();
    let comment = JSON.parse(event.data);
    let card = `
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">${comment.author}
                    <span class="label label-success pull-right">${comment.created}</span>
                </div>
                <div class="panel-body">
                    ${comment.text}
                </div>
            </div>
        </div>`;
    let commentsList = document.querySelector('.comments-list');
    commentsList.insertAdjacentHTML('afterbegin', card);
});
