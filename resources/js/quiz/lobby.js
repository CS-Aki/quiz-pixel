import $  from "jquery";

let userId = $("#userId").val();
let ownerId = $("#ownerId").val();
console.log("Owner Id = " +ownerId);
const grid = $("#playerGrid");
let count = 0;

function displayPlayers(users){
    $("#playerCount").text(users.length - 1);
    count = users.length - 1;

    users.forEach(user => {
        console.log(user);
        if (user.id == userId || user.id == ownerId){
            return;
        }

        let card = $(`
            <div class="player-card flex flex-col items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl py-4 px-3">
                <input type="hidden" class="otherUserId" value="${user.id}">
                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-sm">MR</div>
                <p class="text-xs font-semibold text-slate-700 text-center truncate w-full">${user.username}</p>
                <span class="text-[10px] font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Ready</span>
            </div>
        `);

        grid.append(card);
    });
}

function addPlayerCard(user){
    const grid = $("#playerGrid");
    $("#playerCount").text(count + 1);

        console.log(user);
        if (user.id == userId){
            return;
        }

        let card = $(`
            <div class="player-card flex flex-col items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl py-4 px-3">
                <input type="hidden" class="otherUserId" value="${user.id}">
                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-sm">MR</div>
                <p class="text-xs font-semibold text-slate-700 text-center truncate w-full">${user.username}</p>
                <span class="text-[10px] font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Ready</span>
            </div>
        `);

        grid.append(card);
}

$(document).ready(function () {
    let quizCode = $('#roomCode').text().trim();
    let playerLimit = $('#playerLimit').text().trim();

    window.Echo.join('join-lobby.' + quizCode)
    // 🔹 Current users when you join
    .here((users) => {
        console.log('Users in lobby:', users);
        displayPlayers(users);
        $('#playerCountLabel').text(users.length - 1 + " / " + playerLimit);
    })

    // 🔹 When someone joins
    .joining((user) => {

        let current = parseInt($('#playerCountLabel').text());
        let count = current + 1;

        if (user.id != ownerId){
            addPlayerCard(user);
        }
        
        $('#playerCountLabel').text(count + " / " + playerLimit);
        $("#playerCount").text(count);
    })

    // 🔹 When someone leaves
    .leaving((user) => {
        console.log('User left:', user);

        let current = parseInt($('#playerCountLabel').text());
        let count = current - 1;
        let card = $(`.otherUserId[value="${user.id}"]`);
        console.log(card);
        
        card.closest('.player-card').remove();

        $('#playerCountLabel').text(count + " / " + playerLimit);
        $("#playerCount").text(count);
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