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

    const quizStateKey = `quiz_state_${window.QUIZ_ID}`;
    window.quizAnswers = {};

    function saveQuizState(extra = {}) {
        const state = {
            currentIndex,
            score,
            correctCount,
            timeLeft,
            answered,
            answers: window.quizAnswers || {},
            ...extra,
            savedAt: Date.now()
        };

        localStorage.setItem(quizStateKey, JSON.stringify(state));
    }

    function loadQuizState() {
        const raw = localStorage.getItem(quizStateKey);

        if (!raw) return null;

        try {
            return JSON.parse(raw);
        } catch (e) {
            localStorage.removeItem(quizStateKey);
            return null;
        }
    }

    function clearQuizState() {
        localStorage.removeItem(quizStateKey);
    }

    renderLeaderboard(window.INITIAL_LEADERBOARD || []);
    setupPusherLeaderboard();

    if (total === 0) {
        $questionText.text('No questions available for this quiz.');
        $choicesContainer.html('');
        return;
    }

    const savedState = loadQuizState();

    if (savedState && savedState.currentIndex < total) {
        currentIndex = savedState.currentIndex ?? 0;
        score = savedState.score ?? 0;
        correctCount = savedState.correctCount ?? 0;
        timeLeft = savedState.timeLeft ?? (questions[currentIndex]?.time || 30);
        answered = savedState.answered ?? false;
        window.quizAnswers = savedState.answers || {};

        loadQuestion(currentIndex, true);
    } else {
        loadQuestion(0, false);
    }

    $nextBtn.on('click', function () {
        stopTimer();

        currentIndex++;
        answered = false;

        saveQuizState({
            currentIndex,
            answered: false,
            timeLeft: questions[currentIndex]?.time || 30
        });

        if (currentIndex < total) {
            loadQuestion(currentIndex, false);
        } else {
            clearQuizState();
            showSummary();
        }
    });

    $(document).on('click', '.choice-option', function () {
        if (answered) return;

        const selected = $(this).data('choice');
        const q = questions[currentIndex];
        handleAnswer(selected, q);
    });

    function loadQuestion(index, restored = false) {
        const q = questions[index];
        const savedAnswer = window.quizAnswers[index] || null;

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

            $choicesContainer.append(`
                <button type="button"
                    class="choice-option text-left flex items-center gap-3 p-4 border-2 border-slate-100 rounded-2xl hover:border-[#2979FF]/40 hover:shadow-md transition-all duration-200 bg-white"
                    data-choice="${choice.label}">
                    <span class="choice-label w-9 h-9 rounded-full border-2 border-slate-300 flex-shrink-0 flex items-center justify-center text-sm font-bold text-slate-500 transition">
                        ${choice.label}
                    </span>
                    <span class="text-sm md:text-base text-slate-700 font-medium">${escapeHtml(choice.text)}</span>
                </button>
            `);
        });

        $feedbackBanner.addClass('hidden');
        $nextBtnWrapper.addClass('hidden');
        $nextBtn.text(index + 1 < total ? 'Next Question →' : 'See Results');

        if (restored && savedAnswer) {
            answered = true;
            stopTimer();
            applySavedAnswerUI(savedAnswer, q);
            $nextBtnWrapper.removeClass('hidden');
            saveQuizState();
            return;
        }

        answered = false;

        const secondsToUse = restored ? (timeLeft || q.time || 30) : (q.time || 30);
        startTimer(secondsToUse);
        saveQuizState({
            answered: false,
            timeLeft: secondsToUse
        });
    }

    function handleAnswer(selected, q) {
        if (answered) return;

        answered = true;
        stopTimer();

        const isCorrect = selected === q.correct;

        if (isCorrect) {
            score += q.points;
            correctCount++;
        }

        window.quizAnswers[currentIndex] = {
            selected,
            correct: q.correct,
            isCorrect,
            timedOut: false
        };

        applySavedAnswerUI(window.quizAnswers[currentIndex], q);

        $('#liveScore').text(score);
        $('#liveCorrect').text(correctCount);
        $nextBtnWrapper.removeClass('hidden');

        saveQuizState({
            answered: true,
            timeLeft: 0
        });

        submitResults();
    }

    function applySavedAnswerUI(savedAnswer, q) {
        $('.choice-option').each(function () {
            const $el = $(this);
            const label = $el.data('choice');

            $el.css('pointer-events', 'none');

            if (label === savedAnswer.correct) {
                $el.removeClass('border-slate-100 hover:border-[#2979FF]/40')
                    .addClass('border-green-400 bg-green-50');
                $el.find('.choice-label')
                    .addClass('bg-green-500 border-green-500 text-white');
            } else if (!savedAnswer.timedOut && label === savedAnswer.selected && !savedAnswer.isCorrect) {
                $el.removeClass('border-slate-100 hover:border-[#2979FF]/40')
                    .addClass('border-red-400 bg-red-50');
                $el.find('.choice-label')
                    .addClass('bg-red-500 border-red-500 text-white');
            }
        });

        $feedbackBanner.removeClass('hidden');

        if (savedAnswer.timedOut) {
            $feedbackInner.attr('class', 'flex items-center gap-3 rounded-2xl px-4 py-4 bg-amber-50 border border-amber-200');
            $feedbackIcon.attr('class', 'w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 bg-amber-500 text-white text-sm font-bold').text('!');
            $feedbackText.attr('class', 'text-sm font-semibold text-amber-700').text(`Time's up! The correct answer was ${savedAnswer.correct}.`);
            return;
        }

        if (savedAnswer.isCorrect) {
            $feedbackInner.attr('class', 'flex items-center gap-3 rounded-2xl px-4 py-4 bg-green-50 border border-green-200');
            $feedbackIcon.attr('class', 'w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 bg-green-500 text-white text-sm font-bold').text('✓');
            $feedbackText.attr('class', 'text-sm font-semibold text-green-700').text(`Correct! +${q.points} point${q.points !== 1 ? 's' : ''}`);
        } else {
            $feedbackInner.attr('class', 'flex items-center gap-3 rounded-2xl px-4 py-4 bg-red-50 border border-red-200');
            $feedbackIcon.attr('class', 'w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 bg-red-500 text-white text-sm font-bold').text('✕');
            $feedbackText.attr('class', 'text-sm font-semibold text-red-700').text(`Incorrect. The correct answer was ${savedAnswer.correct}.`);
        }
    }

    function startTimer(seconds) {
        stopTimer();

        timeLeft = seconds || 30;
        updateTimerDisplay();
        saveQuizState();

        timerInterval = setInterval(function () {
            timeLeft--;
            updateTimerDisplay();
            saveQuizState();

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

        window.quizAnswers[currentIndex] = {
            selected: null,
            correct: q.correct,
            isCorrect: false,
            timedOut: true
        };

        applySavedAnswerUI(window.quizAnswers[currentIndex], q);

        $nextBtnWrapper.removeClass('hidden');

        saveQuizState({
            answered: true,
            timeLeft: 0
        });
    }

    function showSummary() {
        $('#progressSection').addClass('hidden');
        $('#quizStats .bg-white').first().removeClass('hidden');

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
        clearQuizState();
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
                if (response.leaderboard) {
                    renderLeaderboard(response.leaderboard);
                }

                if (total === currentIndex + 1 && answered) {
                    $questionCard.remove();
                    showSummary();
                }

                console.log('Quiz results submitted:', response);
            },
            error: function (xhr) {
                console.warn('Could not submit quiz results:', xhr.responseText);
            }
        });
    }

    function setupPusherLeaderboard() {
        if (typeof Pusher === 'undefined') {
            console.warn('Pusher JS is not loaded.');
            return;
        }

        const pusher = new Pusher(window.PUSHER_APP_KEY, {
            cluster: window.PUSHER_APP_CLUSTER,
            authEndpoint: '/broadcasting/auth',
            forceTLS: true
        });

        const channel = pusher.subscribe(`presence-quiz.${window.QUIZ_ID}`);

        channel.bind('pusher:subscription_succeeded', function (members) {
            console.log('Joined quiz presence channel.', members.count);
        });

        channel.bind('leaderboard.updated', function (data) {
            if (data && data.leaderboard) {
                renderLeaderboard(data.leaderboard);
            }
        });
    }

    function renderLeaderboard(rows) {
        const $list = $('#leaderboardList');
        $list.empty();

        if (!rows || !rows.length) {
            $list.html(`
                <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4 text-sm text-slate-500">
                    No scores yet.
                </div>
            `);
            return;
        }

        rows.forEach(function (player) {
            const rank = Number(player.rank);
            const isTop1 = rank === 1;
            const isTop2 = rank === 2;
            const isTop3 = rank === 3;
            const isMe = Number(player.user_id) === Number(window.AUTH_USER_ID);

            let rowClass = 'bg-slate-50 border border-slate-100';
            let badgeClass = 'bg-slate-400 text-white';
            let scoreClass = 'text-slate-700';

            if (isTop1) {
                rowClass = 'bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-100';
                badgeClass = 'bg-yellow-400 text-white';
                scoreClass = 'text-amber-600';
            } else if (isTop2) {
                badgeClass = 'bg-slate-400 text-white';
            } else if (isTop3) {
                rowClass = 'bg-orange-50 border border-orange-100';
                badgeClass = 'bg-orange-400 text-white';
                scoreClass = 'text-orange-600';
            }

            const meRing = isMe ? ' ring-2 ring-[#2979FF]/30' : '';

            if (rank <= 3) {
                $list.append(`
                    <div class="flex items-center gap-3 p-3 rounded-2xl ${rowClass}${meRing}">
                        <div class="w-10 h-10 rounded-full ${badgeClass} flex items-center justify-center font-bold shadow-sm">
                            ${rank}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-800 truncate">
                                ${escapeHtml(player.name)}${isMe ? ' (You)' : ''}
                            </p>
                            <p class="text-xs text-slate-500">
                                ${player.correct_count} correct answers
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-extrabold ${scoreClass}">${player.score}</p>
                            <p class="text-[10px] uppercase tracking-wide text-slate-400">pts</p>
                        </div>
                    </div>
                `);
            } else {
                $list.append(`
                    <div class="flex items-center gap-3 px-2 py-2 rounded-xl hover:bg-slate-50 transition${meRing}">
                        <span class="w-7 text-center text-sm font-bold text-slate-400">${rank}</span>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-700 truncate">
                                ${escapeHtml(player.name)}${isMe ? ' (You)' : ''}
                            </p>
                        </div>
                        <span class="text-sm font-bold text-slate-600">${player.score}</span>
                    </div>
                `);
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