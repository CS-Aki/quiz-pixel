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
        var q    = $('#playerSearch').val().toLowerCase();
        var sort = $('#playerSort').val();
        var $list = $('#playerList');
        var $rows = $list.find('.player-row');

        // Show / hide by search
        $rows.each(function () {
            var nameMatch = $(this).data('name').toString().toLowerCase().includes(q);
            $(this).toggle(nameMatch);
        });

        // Sort the visible rows
        var $visible = $rows.filter(':visible').toArray();

        $visible.sort(function (a, b) {
            var $a = $(a), $b = $(b);
            if (sort === 'rank')       return parseInt($a.data('rank'))  - parseInt($b.data('rank'));
            if (sort === 'score-high') return parseInt($b.data('score')) - parseInt($a.data('score'));
            if (sort === 'score-low')  return parseInt($a.data('score')) - parseInt($b.data('score'));
            if (sort === 'name')       return $a.data('name').localeCompare($b.data('name'));
            return 0;
        });

        $.each($visible, function (i, row) { $list.append(row); });

        $('#playerEmpty').toggle($visible.length === 0);
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