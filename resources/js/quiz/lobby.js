import $  from "jquery";

function displayPlayers(users){

}

$(document).ready(function () {
    let quizCode = $('#roomCode').text().trim();
    let playerLimit = $('#playerLimit').text().trim();

    window.Echo.join('join-lobby.' + quizCode)
    // 🔹 Current users when you join
    .here((users) => {
        console.log('Users in lobby:', users);
        displayPlayers(users);
        $('#playerCountLabel').text(users.length + " / " + playerLimit);
    })

    // 🔹 When someone joins
    .joining((user) => {
        console.log('User joined:', user);

        let current = parseInt($('#playerCountLabel').text());
        let count = current + 1;

        $('#playerCountLabel').text(count + " / " + playerLimit);
    })

    // 🔹 When someone leaves
    .leaving((user) => {
        console.log('User left:', user);

        let current = parseInt($('#playerCountLabel').text());
        let count = current - 1;

        $('#playerCountLabel').text(count + " / " + playerLimit);
    })

    .error((err) => {
        console.log('Subscription error:', err);
    });
    
    // Only broadcast AFTER Echo is subscribed
    $.post('/lobby/' + quizCode + '/join')
    .done(function(res) {
        console.log('Join success:', res);
    })
    .fail(function(err) {
        console.log('Join failed:', err.status, err.responseText); 
    });
});