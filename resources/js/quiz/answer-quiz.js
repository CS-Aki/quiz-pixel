$(function () {
    let currentIndex = 0;
    let score = 0;
    let correctCount = 0;
    let timerInterval = null;
    let timeLeft = 0;
    let answered = false;

    const questions = window.QUIZ_QUESTIONS || [];
    const total = questions.length;

    const $progressBar = $('#progressBar');
    const $progressLabel = $('#progressLabel');
    const $questionLabel = $('#questionLabel');
    const $questionText = $('#questionText');
    const $choicesContainer = $('#choicesContainer');
    const $pointsDisplay = $('#pointsDisplay');
    const $timerDisplay = $('#timerDisplay');
    const $feedbackBanner = $('#feedbackBanner');
    const $feedbackInner = $('#feedbackInner');
    const $feedbackIcon = $('#feedbackIcon');
    const $feedbackText = $('#feedbackText');
    const $nextBtnWrapper = $('#nextBtnWrapper');
    const $nextBtn = $('#nextBtn');
    const $questionCard = $('#questionCard');
    const $scoreSummary = $('#scoreSummary');
    const $finalScore = $('#finalScore');
    const $finalCorrect = $('#finalCorrect');
    const $finalPercent = $('#finalPercent');
    const $summaryMessage = $('#summaryMessage');
    const $summaryBadge = $('#summaryBadge');

    if (total === 0) {
        $questionText.text('No questions available for this quiz.');
        $choicesContainer.html('');
        $('#quizStats').addClass('hidden');
        return;
    }

    loadQuestion(0);

    $nextBtn.on('click', function () {
        currentIndex++;

        if (currentIndex < total) {
            loadQuestion(currentIndex);
        } else {
            showSummary();
        }
    });

    function loadQuestion(index) {
        answered = false;

        const q = questions[index];

        $questionLabel.text(`Question ${index + 1}`);
        $progressLabel.text(`Question ${index + 1} of ${total}`);
        $pointsDisplay.text(`${q.points} pt${q.points !== 1 ? 's' : ''}`);
        $('#questionCounterMini').text(`${index + 1}/${total}`);
        $('#liveScore').text(score);
        $('#liveCorrect').text(correctCount);

        const pct = Math.round(((index + 1) / total) * 100);
        $progressBar.css('width', `${pct}%`);

        $questionText.text(q.text);

        $choicesContainer.empty();

        $.each(q.choices, function (_, choice) {
            if (!choice.text) return;

            const choiceHtml = `
                <button type="button"
                    class="choice-option text-left flex items-center gap-3 p-4 border-2 border-slate-100 rounded-2xl hover:border-[#2979FF]/40 hover:shadow-md transition-all duration-200 bg-white"
                    data-choice="${choice.label}">
                    <span class="choice-label w-9 h-9 rounded-full border-2 border-slate-300 flex-shrink-0 flex items-center justify-center text-sm font-bold text-slate-500 transition">
                        ${choice.label}
                    </span>
                    <span class="text-sm md:text-base text-slate-700 font-medium">
                        ${escapeHtml(choice.text)}
                    </span>
                </button>
            `;

            $choicesContainer.append(choiceHtml);
        });

        $feedbackBanner.addClass('hidden');
        $nextBtnWrapper.addClass('hidden');

        $nextBtn.text(index + 1 < total ? 'Next Question →' : 'See Results');

        startTimer(q.time);
    }

    $(document).on('click', '.choice-option', function () {
        if (answered) return;

        const selected = $(this).data('choice');
        const q = questions[currentIndex];

        handleAnswer(selected, q);
    });

    function handleAnswer(selected, q) {
        if (answered) return;

        answered = true;
        stopTimer();

        const isCorrect = selected === q.correct;

        if (isCorrect) {
            score += q.points;
            correctCount++;
        }

        $('.choice-option').each(function () {
            const $el = $(this);
            const label = $el.data('choice');

            $el.css('pointer-events', 'none');

            if (label === q.correct) {
                $el.removeClass('border-slate-100 hover:border-[#2979FF]/40')
                   .addClass('border-green-400 bg-green-50');
                $el.find('.choice-label')
                   .addClass('bg-green-500 border-green-500 text-white');
            } else if (label === selected && !isCorrect) {
                $el.removeClass('border-slate-100 hover:border-[#2979FF]/40')
                   .addClass('border-red-400 bg-red-50');
                $el.find('.choice-label')
                   .addClass('bg-red-500 border-red-500 text-white');
            }
        });

        $feedbackBanner.removeClass('hidden');

        if (isCorrect) {
            $feedbackInner.attr('class', 'flex items-center gap-3 rounded-2xl px-4 py-4 bg-green-50 border border-green-200');
            $feedbackIcon.attr('class', 'w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 bg-green-500 text-white text-sm font-bold');
            $feedbackIcon.text('✓');
            $feedbackText.attr('class', 'text-sm font-semibold text-green-700');
            $feedbackText.text(`Correct! +${q.points} point${q.points !== 1 ? 's' : ''}`);
        } else {
            $feedbackInner.attr('class', 'flex items-center gap-3 rounded-2xl px-4 py-4 bg-red-50 border border-red-200');
            $feedbackIcon.attr('class', 'w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 bg-red-500 text-white text-sm font-bold');
            $feedbackIcon.text('✕');
            $feedbackText.attr('class', 'text-sm font-semibold text-red-700');
            $feedbackText.text(`Incorrect. The correct answer was ${q.correct}.`);
        }

        $('#liveScore').text(score);
        $('#liveCorrect').text(correctCount);

        $nextBtnWrapper.removeClass('hidden');
    }

    function startTimer(seconds) {
        stopTimer();
        timeLeft = seconds || 30;
        updateTimerDisplay();

        timerInterval = setInterval(function () {
            timeLeft--;
            updateTimerDisplay();

            if (timeLeft <= 0) {
                stopTimer();
                if (!answered) {
                    timeUp();
                }
            }
        }, 1000);
    }

    function stopTimer() {
        clearInterval(timerInterval);
        timerInterval = null;
    }

    function updateTimerDisplay() {
        $timerDisplay.text(timeLeft);
        $timerDisplay.removeClass('text-slate-700 text-amber-500 text-red-500');

        if (timeLeft > 10) {
            $timerDisplay.addClass('text-slate-700');
        } else if (timeLeft > 5) {
            $timerDisplay.addClass('text-amber-500');
        } else {
            $timerDisplay.addClass('text-red-500');
        }
    }

    function timeUp() {
        answered = true;
        const q = questions[currentIndex];

        $('.choice-option').each(function () {
            const $el = $(this);
            $el.css('pointer-events', 'none');

            if ($el.data('choice') === q.correct) {
                $el.removeClass('border-slate-100 hover:border-[#2979FF]/40')
                   .addClass('border-green-400 bg-green-50');
                $el.find('.choice-label')
                   .addClass('bg-green-500 border-green-500 text-white');
            }
        });

        $feedbackBanner.removeClass('hidden');
        $feedbackInner.attr('class', 'flex items-center gap-3 rounded-2xl px-4 py-4 bg-amber-50 border border-amber-200');
        $feedbackIcon.attr('class', 'w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500 text-white text-sm font-bold');
        $feedbackIcon.text('!');
        $feedbackText.attr('class', 'text-sm font-semibold text-amber-700');
        $feedbackText.text(`Time's up! The correct answer was ${q.correct}.`);

        $nextBtnWrapper.removeClass('hidden');
    }

    function showSummary() {
        $questionCard.addClass('hidden');
        $('#progressSection').addClass('hidden');
        $('#quizStats').addClass('hidden');

        const percent = total > 0 ? Math.round((correctCount / total) * 100) : 0;

        $finalScore.text(score);
        $finalCorrect.text(`${correctCount}/${total}`);
        $finalPercent.text(`${percent}%`);

        if (percent >= 80) {
            $summaryBadge.text('Excellent');
            $summaryMessage.text('Amazing work. You really know this quiz.');
        } else if (percent >= 50) {
            $summaryBadge.text('Good Job');
            $summaryMessage.text('Nice effort. You got a solid score.');
        } else {
            $summaryBadge.text('Keep Practicing');
            $summaryMessage.text('You can review and try again for a better result.');
        }

        $scoreSummary.removeClass('hidden');

        submitResults();
    }

    function submitResults() {
        $.ajax({
            url: `/quiz/${window.QUIZ_ID}/submit`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                quiz_id: window.QUIZ_ID,
                quiz_code: window.QUIZ_CODE,
                score: score,
                correct_count: correctCount,
                total_questions: total
            },
            success: function (response) {
                console.log('Quiz results submitted:', response);
            },
            error: function (xhr) {
                console.warn('Could not submit quiz results:', xhr.responseText);
            }
        });
    }

    function escapeHtml(text) {
        return String(text)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }
});