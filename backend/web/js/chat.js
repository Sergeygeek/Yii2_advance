const websocketPort = wsPort ? wsPort : 8080;
const conn = new WebSocket(`ws://localhost:${websocketPort}`);
const btnSend = document.getElementById('send');
const chatField = document.getElementById('chat-field');

conn.onopen = function (e) {
    console.log('Connection established');
};

conn.onerror = function (e) {
    console.error('Connection fail!');
};

conn.onmessage = function (e) {
    var $el = $('li.messages-menu ul.menu li:first').clone();
    $el.find('p').text(e.data);
    $el.find('h4').text(user);
    $el.prependTo('li.messages-menu ul.menu');

    var cnt = $('li.messages-menu ul.menu li').length;
    $('li.messages-menu span.label-success').text(cnt);
    $('li.messages-menu li.header').text('You have ' + cnt + ' messages');
};

btnSend.addEventListener('click', function (e) {
    e.preventDefault();
    conn.send(chatField.value);
    chatField.value = '';
});