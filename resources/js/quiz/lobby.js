import $  from "jquery";

let userId = $("#userId").val();
let ownerId = $("#ownerId").val();
console.log("Owner Id = " +ownerId);
const grid = $("#playerGrid");
let count = 0;

function displayPlayers(users){
    $("#playerCount").text(users.length - 1);
    
    users.forEach(user => {
        console.log(user.name);
        let first = user.name[0] || "";

        let last = "";
        for (let i = user.name.length - 1; i >= 0; i--) {
            if (/[a-zA-Z]/.test(user.name[i])) {
                last = user.name[i];
                break;
            }
        }

        let iconLabel = (first + last).toUpperCase();
        console.log("Icon label " + iconLabel);
        
        if (user.id == userId){
            return;
        }
        
        if (user.id == ownerId){
            let ownerCard = $(`                              
                    <div class="owner-card flex flex-col items-center gap-2 bg-[#EFF6FF] border border-blue-100 rounded-xl py-4 px-3">
                                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-sm">${iconLabel}</div>
                                <input type="hidden" id="otherUserId" value="${user.id}">
                                <p class="text-xs font-semibold text-slate-700 text-center truncate w-full text-center">${user.username}</p>
                                <span class="text-[10px] font-bold text-green-600  bg-blue-100 px-2 py-0.5 rounded-full">Host</span>
                            </div>
                        `);

            grid.append(ownerCard);
            return;
        }

        let card = $(`
            <div class="player-card flex flex-col items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl py-4 px-3">
                <input type="hidden" class="otherUserId" value="${user.id}">
                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-sm">${iconLabel}</div>
                <p class="text-xs font-semibold text-slate-700 text-center truncate w-full">${user.username}</p>
                <span class="text-[10px] font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Ready</span>
            </div>
        `);

        grid.append(card);
        
    });

    count = $(".player-card").length;
}

function addPlayerCard(user){
    const grid = $("#playerGrid");
    let name = user.name || "";

    let first = name[0] || "";

    let last = "";
    for (let i = name.length - 1; i >= 0; i--) {
        if (/[a-zA-Z]/.test(name[i])) {
            last = name[i];
            break;
        }
    }

    let iconLabel = (first + last).toUpperCase();

    console.log("inside "+ user.id + " " + ownerId);
    if (user.id == userId){
        return;
    }

    if (user.id == ownerId){
        let ownerCard = $(`                              
                <div class="owner-card flex flex-col items-center gap-2 bg-[#EFF6FF] border border-blue-100 rounded-xl py-4 px-3">
                            <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-sm">${iconLabel}</div>
                            <input type="hidden" id="otherUserId" value="${user.id}">
                            <p class="text-xs font-semibold text-slate-700 text-center truncate w-full text-center">${user.username}</p>
                            <span class="text-[10px] font-bold text-green-600  bg-blue-100 px-2 py-0.5 rounded-full">Host</span>
                        </div>
                    `);

        grid.append(ownerCard);
        console.log("Appending owner");
        console.log(grid);
        return;
    }

    let card = $(`
        <div class="player-card flex flex-col items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl py-4 px-3">
            <input type="hidden" class="otherUserId" value="${user.id}">
            <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-sm">${iconLabel}</div>
            <p class="text-xs font-semibold text-slate-700 text-center truncate w-full">${user.username}</p>
            <span class="text-[10px] font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Ready</span>
        </div>
    `);

    grid.append(card);
}

$(document).ready(function () {
    count = $(".player-card").length;

    let quizCode = $('#roomCode').text().trim();
    let playerLimit = $('#playerLimit').text().trim();

    window.Echo.join('join-lobby.' + quizCode)
    // 🔹 Current users when you join
    .here((users) => {
        console.log('Users in lobby:', users);
        displayPlayers(users);
        $('#playerCountLabel').text(count + " / " + playerLimit);
        $("#playerCount").text(count);
    })

    // 🔹 When someone joins
    .joining((user) => {

        let current = parseInt($('#playerCountLabel').text());
        // console.log(user.id + " " + ownerId);

        addPlayerCard(user);
        
        let count = $(".player-card").length;
        // console.log("New joining length " + count);

        $('#playerCountLabel').text(count + " / " + playerLimit);
        $("#playerCount").text(count);
    })

    // 🔹 When someone leaves
    .leaving((user) => {
        console.log('User left:', user);

        let current = parseInt($('#playerCountLabel').text());
        let card = $(`.otherUserId[value="${user.id}"]`);
        let ownerCard = $('.owner-card');
        console.log(user.id + " " + ownerId);
        
        if (user.id == ownerId){
             ownerCard.remove();
             console.log("removing owner card");
        } else {    
            card.closest('.player-card').remove();
        }

        let count = $(".player-card").length;

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