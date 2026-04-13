$(function () {

    var CIRCUMFERENCE = 201;
    var { quizCode, quizId, totalQuestions } = window.QuizResultConfig;

    function setRing(ringId, pct, color) {
        var offset = CIRCUMFERENCE - (pct / 100) * CIRCUMFERENCE;
        $('#' + ringId).css('stroke-dashoffset', offset).css('stroke', color || '#2979FF');
    }

    function scoreBg(pct) {
        if (pct >= 80) return 'bg-green-100 text-green-700';
        if (pct >= 50) return 'bg-yellow-100 text-yellow-700';
        return 'bg-red-100 text-red-600';
    }

    function formatTime(seconds) {
        var s = parseInt(seconds) || 0;
        var m = Math.floor(s / 60);
        var r = s % 60;
        return String(m).padStart(2, '0') + ':' + String(r).padStart(2, '0');
    }

    function initials(name) {
        return (name || '').substring(0, 2).toUpperCase();
    }

    // ── Normalize existing server-rendered rows so they have all needed data attrs ──
    function normalizeExistingRows() {
        $('#playerList .player-row').each(function () {
            var $row = $(this);

            // Server renders data-name as lowercase already, but
            // we need data-correct and data-time-seconds from the View button
            var $btn = $row.find('.btn-view-player');
            if ($btn.length) {
                $row.attr('data-correct',      $btn.data('correct'));
                $row.attr('data-score-pct',    $btn.data('score-pct'));
                $row.attr('data-time-seconds', timeToSeconds($btn.data('time')));
            }
        });
    }

    function timeToSeconds(timeStr) {
        if (!timeStr) return 0;
        var parts = String(timeStr).split(':');
        return (parseInt(parts[0]) * 60) + parseInt(parts[1] || 0);
    }

    // ── Build a new player row HTML ──────────────────────────────
    function buildPlayerRow(entry, rank) {
        var pct        = totalQuestions > 0 ? Math.round((entry.correct_count / totalQuestions) * 100) : 0;
        var bg         = scoreBg(pct);
        var time       = formatTime(entry.time_taken_seconds);
        var ini        = initials(entry.player_name);
        var badgeClass = pct >= 70 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600';
        var badgeText  = pct >= 70 ? '🎉 Passed' : '❌ Failed';
        var ringColor  = pct >= 70 ? '#16a34a' : '#dc2626';

        return `
        <div class="player-row grid grid-cols-12 items-center px-6 py-3 hover:bg-slate-50 transition"
             data-name="${(entry.player_name || '').toLowerCase()}"
             data-score="${entry.score}"
             data-rank="${rank}"
             data-correct="${entry.correct_count}"
             data-score-pct="${pct}"
             data-time-seconds="${entry.time_taken_seconds || 0}">
            <div class="col-span-1 text-center text-xs font-bold text-slate-400 rank-cell">${rank}</div>
            <div class="col-span-4 flex items-center gap-2.5 min-w-0">
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-[#2979FF] shrink-0">${ini}</div>
                <p class="text-sm font-semibold text-slate-700 truncate player-name-cell">${entry.player_name}</p>
            </div>
            <div class="col-span-2 text-center">
                <span class="text-sm font-black text-slate-800">${entry.score}</span>
                <span class="text-xs text-slate-400"> pts</span>
            </div>
            <div class="col-span-2 text-center">
                <span class="text-xs font-semibold px-2 py-0.5 rounded-full ${bg}">
                    ${entry.correct_count}/${totalQuestions}
                </span>
            </div>
            <div class="col-span-2 text-center text-xs text-slate-500 font-medium">${time}</div>
            <div class="col-span-1 text-center">
                <button class="btn-view-player text-xs px-2.5 py-1 border border-gray-200 text-slate-500 rounded-lg hover:bg-gray-50 hover:border-[#2979FF] hover:text-[#2979FF] transition"
                    data-name="${entry.player_name}"
                    data-score="${entry.score}"
                    data-rank="${rank}"
                    data-correct="${entry.correct_count}"
                    data-total="${totalQuestions}"
                    data-time="${time}"
                    data-score-pct="${pct}"
                    data-badge-class="${badgeClass}"
                    data-badge-text="${badgeText}"
                    data-ring-color="${ringColor}">
                    View
                </button>
            </div>
        </div>`;
    }

    // ── Re-rank all rows by score desc ───────────────────────────
    function rebuildLeaderboard() {
        var $list = $('#playerList');
        var rows  = $list.find('.player-row').toArray();

        rows.sort(function (a, b) {
            var scoreDiff = parseInt($(b).attr('data-score')) - parseInt($(a).attr('data-score'));
            if (scoreDiff !== 0) return scoreDiff;
            return parseInt($(a).attr('data-time-seconds') || 0) - parseInt($(b).attr('data-time-seconds') || 0);
        });

        $.each(rows, function (i, row) {
            $(row).attr('data-rank', i + 1);
            $(row).find('.rank-cell').text(i + 1);
            $(row).find('.btn-view-player').attr('data-rank', i + 1);
            $list.append(row);
        });

        updateSummaryStats();
        rebuildPodium();
        rebuildLeaderboardList(rows);  // ← add this
        applyPlayerFilter();
    }

    function rebuildLeaderboardList(sortedRows) {
        var $lb = $('#leaderboardList');
        $lb.empty();

        $.each(sortedRows, function (i, row) {
            var $row      = $(row);
            var rank      = i + 1;
            var name      = $row.find('.player-name-cell').text().trim();
            var score     = $row.attr('data-score');
            var correct   = $row.attr('data-correct');
            var timeStr   = formatTime(parseInt($row.attr('data-time-seconds') || 0));
            var pct       = parseInt($row.attr('data-score-pct') || 0);
            var bg        = scoreBg(pct);
            var highlight = rank <= 3 ? 'bg-slate-50/50' : '';

            var medal = rank === 1 ? '🥇' : rank === 2 ? '🥈' : rank === 3 ? '🥉'
                : `<span class="text-xs text-slate-400">${rank}</span>`;

            $lb.append(`
                <div class="leaderboard-row grid grid-cols-12 items-center px-6 py-3 hover:bg-slate-50 transition ${highlight}"
                    data-player-name="${name.toLowerCase()}"
                    data-score="${score}">
                    <div class="col-span-1 text-center lb-rank-cell">${medal}</div>
                    <div class="col-span-5 flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-[#2979FF] shrink-0 lb-initials">
                            ${initials(name)}
                        </div>
                        <p class="text-sm font-semibold text-slate-700 truncate lb-name">${name}</p>
                    </div>
                    <div class="col-span-2 text-center lb-score">
                        <span class="text-sm font-black text-slate-800">${score}</span>
                        <span class="text-xs text-slate-400"> pts</span>
                    </div>
                    <div class="col-span-2 text-center lb-correct">
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full ${bg}">
                            ${correct}/${totalQuestions}
                        </span>
                    </div>
                    <div class="col-span-2 text-center text-xs text-slate-400 font-medium lb-time">
                        ${timeStr}
                    </div>
                </div>
            `);
        });
    }

    // ── Update stat cards ────────────────────────────────────────
    function updateSummaryStats() {
        var rows   = $('#playerList .player-row').toArray();
        var total  = rows.length;
        var scores = rows.map(r => parseInt($(r).attr('data-score')) || 0);
        var pcts   = rows.map(r => parseInt($(r).attr('data-score-pct')) || 0);

        var avgPct   = total ? Math.round(pcts.reduce((a, b) => a + b, 0) / total) : 0;
        var highest  = total ? Math.max(...scores) : 0;

        $('#statTotalPlayers').text(total);
        $('#statAvgScore').text(avgPct + '%');
        $('#statHighestScore').text(highest + ' pts');

        // Score bands
        var band90 = 0, band70 = 0, band50 = 0, bandBelow = 0;
        pcts.forEach(function (pct) {
            if (pct >= 90)      band90++;
            else if (pct >= 70) band70++;
            else if (pct >= 50) band50++;
            else                bandBelow++;
        });

        var max = Math.max(band90, band70, band50, bandBelow) || 1;

        updateBand('#band90',    band90,    max);
        updateBand('#band70',    band70,    max);
        updateBand('#band50',    band50,    max);
        updateBand('#bandBelow', bandBelow, max);
    }

    function updateBand(spanId, count, max) {
        $(spanId).text(count);
        $(spanId).closest('.flex').find('.band-bar')
            .css('width', Math.round((count / max) * 100) + '%');
    }

    // ── Rebuild podium top 3 ─────────────────────────────────────
    function rebuildPodium() {
        var rows = $('#playerList .player-row').toArray()
            .sort((a, b) => parseInt($(a).attr('data-rank')) - parseInt($(b).attr('data-rank')));

        if (rows.length < 3) return;

        var p = rows.slice(0, 3).map(r => ({
            name:  $(r).find('.player-name-cell').text().trim(),
            score: $(r).attr('data-score'),
        }));

        // 1st
        $('#podium1st .podium-initials').text(initials(p[0].name));
        $('#podium1st .podium-name').text(p[0].name);
        $('#podium1st .podium-score').text(p[0].score + ' pts');
        // 2nd
        $('#podium2nd .podium-initials').text(initials(p[1].name));
        $('#podium2nd .podium-name').text(p[1].name);
        $('#podium2nd .podium-score').text(p[1].score + ' pts');
        // 3rd
        $('#podium3rd .podium-initials').text(initials(p[2].name));
        $('#podium3rd .podium-name').text(p[2].name);
        $('#podium3rd .podium-score').text(p[2].score + ' pts');
    }

    // ── Real-time listener ───────────────────────────────────────
    window.Echo.channel('quiz-results.' + quizCode)
        .listen('.result.submitted', function (e) {
            console.log('Realtime result received:', e);

            var entry = e.result;

            // Find existing row by player name (case-insensitive)
            var nameLower  = (entry.player_name || '').toLowerCase();
            var $existing  = $('#playerList .player-row').filter(function () {
                return $(this).attr('data-name') === nameLower;
            });

            var rank = $existing.length
                ? parseInt($existing.attr('data-rank'))
                : $('#playerList .player-row').length + 1;

            var newRow = buildPlayerRow(entry, rank);

            if ($existing.length) {
                $existing.replaceWith(newRow);
            } else {
                $('#playerList').append(newRow);
            }

            rebuildLeaderboard();
        });

    // ── Player search + sort ─────────────────────────────────────
    function applyPlayerFilter() {
        var q     = ($('#playerSearch').val() || '').trim().toLowerCase();
        var sort  = $('#playerSort').val();
        var $list = $('#playerList');
        var $rows = $list.find('.player-row');

        $rows.each(function () {
            $(this).toggle(($(this).attr('data-name') || '').indexOf(q) !== -1);
        });

        var visible = $rows.filter(':visible').toArray();

        visible.sort(function (a, b) {
            var $a = $(a), $b = $(b);
            switch (sort) {
                case 'rank':       return parseInt($a.attr('data-rank'))  - parseInt($b.attr('data-rank'));
                case 'score-high': return parseInt($b.attr('data-score')) - parseInt($a.attr('data-score'));
                case 'score-low':  return parseInt($a.attr('data-score')) - parseInt($b.attr('data-score'));
                case 'name-asc':   return ($a.attr('data-name') || '').localeCompare($b.attr('data-name') || '');
                case 'name-desc':  return ($b.attr('data-name') || '').localeCompare($a.attr('data-name') || '');
                default:           return 0;
            }
        });

        $.each(visible, function (i, row) { $list.append(row); });

        var count = visible.length;
        $('#playerCount').text(
            count === 0 ? 'No players found' : 'Showing ' + count + ' player' + (count !== 1 ? 's' : '')
        );
        $('#playerEmpty').toggle(count === 0);
    }

    $('#playerSearch').on('input', applyPlayerFilter);
    $('#playerSort').on('change', applyPlayerFilter);

    // ── Player Detail Modal ──────────────────────────────────────
    $(document).on('click', '.btn-view-player', function () {
        var $btn = $(this);
        var pct  = parseInt($btn.data('score-pct'));

        $('#pdName').text($btn.data('name'));
        $('#pdRank').text('Rank #' + $btn.data('rank'));
        $('#pdScore').text($btn.data('score') + ' pts');
        $('#pdCorrect').text($btn.data('correct') + ' / ' + $btn.data('total'));
        $('#pdTime').text($btn.data('time'));
        $('#pdScoreText').text(pct + '%');

        setRing('pdScoreRing', pct, $btn.data('ring-color'));

        $('#pdBadge')
            .attr('class', 'w-full py-2.5 rounded-xl text-center text-sm font-bold ' + $btn.data('badge-class'))
            .text($btn.data('badge-text'));

        $('#playerDetailModal').removeClass('hidden');
    });

    $('#btnClosePlayerModal, #playerDetailModal .modal-backdrop').on('click', function () {
        $('#playerDetailModal').addClass('hidden');
    });

    // ── Question Detail Modal ────────────────────────────────────
    $(document).on('click', '.question-row', function () {
        var $row = $(this);
        $('#qdIndex').text($row.data('index'));
        $('#qdQuestion').text($row.data('question'));
        $('#qdAccuracy').text($row.data('accuracy') + '%');
        $('#qdCounts').text($row.data('correct-count') + ' / ' + $row.data('total'));
        $('#qdCorrectAnswer').text($row.data('correct-answer'));
        $('#questionDetailModal').removeClass('hidden');
    });

    $('#btnCloseQuestionModal, #questionDetailModal .modal-backdrop').on('click', function () {
        $('#questionDetailModal').addClass('hidden');
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            $('#playerDetailModal, #questionDetailModal').addClass('hidden');
        }
    });

    // ── Init: normalize existing rows on page load ───────────────
    normalizeExistingRows();

});