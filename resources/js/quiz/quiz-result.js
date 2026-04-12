$(function () {
 
    // ── Constant ────────────────────────────────────────────────
    var CIRCUMFERENCE = 201;
 
    // ── Helper: animate SVG score ring ──────────────────────────
    function setRing(ringId, pct, color) {
        var offset = CIRCUMFERENCE - (pct / 100) * CIRCUMFERENCE;
        $('#' + ringId)
            .css('stroke-dashoffset', offset)
            .css('stroke', color || '#2979FF');
    }
 
    // ── Player search + sort ─────────────────────────────────────
    function applyPlayerFilter() {
        var q     = ($('#playerSearch').val() || '').trim().toLowerCase();
        var sort  = $('#playerSort').val();
        var $list = $('#playerList');
 
        // Read name directly from the DOM attribute each time to avoid
        // jQuery's data() cache returning a stale value after first access
        var $rows = $list.find('.player-row');
 
        // 1. Show / hide rows that match the search query
        $rows.each(function () {
            var name = $(this).attr('data-name') || '';
            $(this).toggle(name.toLowerCase().indexOf(q) !== -1);
        });
 
        // 2. Collect only visible rows and sort them
        var visible = $rows.filter(':visible').toArray();
 
        visible.sort(function (a, b) {
            var $a = $(a), $b = $(b);
            switch (sort) {
                case 'rank':
                    return parseInt($a.attr('data-rank'))  - parseInt($b.attr('data-rank'));
                case 'score-high':
                    return parseInt($b.attr('data-score')) - parseInt($a.attr('data-score'));
                case 'score-low':
                    return parseInt($a.attr('data-score')) - parseInt($b.attr('data-score'));
                case 'name-asc':
                    return ($a.attr('data-name') || '').localeCompare($b.attr('data-name') || '');
                case 'name-desc':
                    return ($b.attr('data-name') || '').localeCompare($a.attr('data-name') || '');
                default:
                    return 0;
            }
        });
 
        // 3. Re-append in sorted order
        $.each(visible, function (i, row) { $list.append(row); });
 
        // 4. Update result count label
        var count = visible.length;
        $('#playerCount').text(
            count === 0
                ? 'No players found'
                : 'Showing ' + count + ' player' + (count !== 1 ? 's' : '')
        );
 
        // 5. Toggle empty state
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
 
    // ── Close any open modal on Escape ───────────────────────────
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            $('#playerDetailModal, #questionDetailModal').addClass('hidden');
        }
    });
 
});
