import $  from "jquery";

let userId = $("#userId").val();

function displayPlayers(users){
    const grid = $("#playerGrid");
    $("#playerCount").text(users.length - 1);
    users.forEach(user => {

        if (user.id == userId){
            return;
        }

        let card = $(`
            <div class="player-card flex flex-col items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl py-4 px-3">
                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-sm">MR</div>
                <p class="text-xs font-semibold text-slate-700 text-center truncate w-full">${user.username}</p>
                <span class="text-[10px] font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Ready</span>
            </div>
        `);

        grid.append(card);
    });
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