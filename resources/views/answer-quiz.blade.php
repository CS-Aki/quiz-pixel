<x-layout>
<div class="min-h-screen bg-[radial-gradient(circle_at_top,_#dbeafe,_#f8fafc_35%,_#f8fafc_100%)] py-10 px-4">
    <div class="max-w-6xl mx-auto">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- Left / Main Content --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Progress Section --}}
                <div id="progressSection" class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5 md:p-6">
                    <div class="flex items-center justify-between gap-4 mb-4">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#2979FF]">
                                Quiz Progress
                            </p>
                            <p class="text-sm text-slate-500 mt-1" id="progressLabel">
                                Question 1 of {{ count($questions) }}
                            </p>

                            
                        </div>

                        <div class="text-right">
                            <p class="text-xs text-slate-400">Current Step</p>
                            <p id="questionCounterMini" class="text-lg font-bold text-slate-700">1/{{ count($questions) }}</p>
                        </div>
                    </div>
                    
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div id="progressBar"
                             class="h-3 rounded-full bg-gradient-to-r from-[#2979FF] to-[#42A5F5] transition-all duration-500"
                             style="width: {{ count($questions) > 0 ? round(1 / count($questions) * 100) : 0 }}%">
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="rounded-2xl bg-slate-50 border border-slate-100 px-4 py-4">
                            <p class="text-xs text-slate-400 mb-1">Total Questions</p>
                            <p class="text-lg font-bold text-slate-800">{{ count($questions) }}</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 border border-slate-100 px-4 py-4">
                            <p class="text-xs text-slate-400 mb-1">Quiz Code</p>
                            <p class="text-lg font-bold text-slate-800 tracking-widest">{{ $quiz->code ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Question Card --}}
                <div id="questionCard" class="bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden">
                    <div class="flex items-center justify-between px-6 md:px-8 py-5 border-b border-slate-100 bg-slate-50/70">
                        <div>
                            <span id="questionLabel" class="text-xs font-bold text-[#2979FF] uppercase tracking-[0.25em]">
                                Question 1
                            </span>
                            <p class="text-xs text-slate-400 mt-1">Choose the best answer below</p>
                        </div>

                        <div class="flex items-center gap-3 md:gap-5">
                            <div class="flex items-center gap-2 rounded-2xl bg-white px-3 py-2 border border-slate-100 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-slate-400" viewBox="0 0 24 24">
                                    <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm1 14.93V18h-2v-1.07A4.002 4.002 0 0 1 8 13h2a2 2 0 1 0 2-2c-2.21 0-4-1.79-4-4a4.002 4.002 0 0 1 3-3.87V2h2v1.13A4.002 4.002 0 0 1 16 7h-2a2 2 0 1 0-2 2c2.21 0 4 1.79 4 4a4.002 4.002 0 0 1-3 3.93z"/>
                                </svg>
                                <span id="pointsDisplay" class="text-sm font-semibold text-slate-700">1 pt</span>
                            </div>

                            <div class="flex items-center gap-2 rounded-2xl bg-white px-3 py-2 border border-slate-100 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-slate-400" viewBox="0 0 510 510">
                                    <g fill-opacity=".9">
                                        <path d="M255 0C114.75 0 0 114.75 0 255s114.75 255 255 255 255-114.75 255-255S395.25 0 255 0zm0 459c-112.2 0-204-91.8-204-204S142.8 51 255 51s204 91.8 204 204-91.8 204-204 204z"/>
                                        <path d="M267.75 127.5H229.5v153l132.6 81.6 20.4-33.15-114.75-68.85z"/>
                                    </g>
                                </svg>
                                <span id="timerDisplay" class="font-bold text-slate-700 tabular-nums transition-colors duration-300 w-10 text-center">
                                    30
                                </span>
                                <span class="text-xs text-slate-400">sec</span>
                            </div>
                        </div>
                    </div>

                    <div class="px-6 md:px-8 pt-8 pb-6">
                        <p id="questionText" class="text-lg md:text-xl font-semibold text-slate-800 mb-8 leading-relaxed">
                            Loading question...
                        </p>

                        <div id="choicesContainer" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Injected by JS --}}
                        </div>

                        <div class="mt-6 rounded-2xl bg-blue-50 border border-blue-100 px-4 py-3">
                            <p class="text-sm text-blue-700">
                                <span class="font-semibold">Tip:</span> Read each choice carefully before answering. Once selected, your answer is locked.
                            </p>
                        </div>

                        {{-- Optional small info cards to reduce empty feel --}}
                    </div>

                    <div id="feedbackBanner" class="hidden px-6 md:px-8 py-4 border-t border-slate-100 bg-slate-50/60">
                        <div id="feedbackInner" class="flex items-center gap-3 rounded-2xl px-4 py-4">
                            <div id="feedbackIcon" class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 text-white text-sm font-bold"></div>
                            <p id="feedbackText" class="text-sm font-medium"></p>
                        </div>
                    </div>

                    <div id="nextBtnWrapper" class="hidden px-6 md:px-8 pb-8 pt-2">
                        <button type="button" id="nextBtn"
                            class="w-full py-4 text-sm md:text-base font-semibold text-white bg-gradient-to-r from-[#2979FF] to-[#1565C0] rounded-2xl hover:opacity-95 transition shadow-md">
                            Next Question →
                        </button>
                    </div>
                </div>

                {{-- Summary --}}
                <div id="scoreSummary" class="hidden bg-white rounded-3xl shadow-xl border border-slate-100 px-6 md:px-10 py-10 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-[#2979FF]/10 mb-5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 fill-[#2979FF]" viewBox="0 0 24 24">
                            <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm-1 14.41-3.7-3.71 1.41-1.41L11 13.59l5.29-5.3 1.42 1.42z"/>
                        </svg>
                    </div>

                    <span id="summaryBadge" class="inline-block px-4 py-1.5 rounded-full bg-blue-50 text-[#2979FF] text-xs font-bold uppercase tracking-wider mb-4">
                        Great Work
                    </span>

                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-2">Quiz Complete!</h2>
                    <p id="summaryMessage" class="text-slate-500 text-sm md:text-base mb-8">
                        Here's how you performed in this challenge.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                            <p class="text-3xl font-bold text-[#2979FF]" id="finalScore">0</p>
                            <p class="text-xs text-slate-400 mt-1 uppercase tracking-wide">Total Points</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                            <p class="text-3xl font-bold text-slate-700" id="finalCorrect">0/0</p>
                            <p class="text-xs text-slate-400 mt-1 uppercase tracking-wide">Correct Answers</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-5">
                            <p class="text-3xl font-bold text-emerald-600" id="finalPercent">0%</p>
                            <p class="text-xs text-slate-400 mt-1 uppercase tracking-wide">Accuracy</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
                        <a href="{{ route('to-dashboard') }}"
                           class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-[#2979FF] to-[#1565C0] rounded-2xl hover:opacity-95 transition shadow-md">
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Sidebar --}}
            <div id="quizStats" class="space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2979FF] mb-4">
                        Live Stats
                    </p>

                    <div class="space-y-4">
                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                            <p class="text-xs text-slate-400 mb-1">Current Score</p>
                            <p id="liveScore" class="text-2xl font-bold text-slate-800">0</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                            <p class="text-xs text-slate-400 mb-1">Correct Answers</p>
                            <p id="liveCorrect" class="text-2xl font-bold text-slate-800">0</p>
                        </div>

                        <div class="rounded-2xl bg-slate-50 border border-slate-100 p-4">
                            <p class="text-xs text-slate-400 mb-1">Quiz Code</p>
                            <p class="text-lg font-bold text-slate-800 tracking-widest">{{ $quiz->code ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 max-h-[390px] overflow-y-auto">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#2979FF]">
                            Leaderboard
                        </p>
                        <span class="text-[11px] font-semibold text-slate-400 bg-slate-100 px-2.5 py-1 rounded-full">
                            Top Players
                        </span>
                    </div>

                    <div id="leaderboardList" class="space-y-3">
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.QUIZ_QUESTIONS = @json($questionsJson);
    window.QUIZ_ID = {{ $quiz->id ?? 0 }};
    window.QUIZ_CODE = "{{ $quiz->code ?? '' }}";
    window.INITIAL_LEADERBOARD = @json($leaderboard ?? []);
    window.AUTH_USER_ID = {{ auth()->id() ?? 0 }};
</script>

<script src="https://js.pusher.com/8.4.0/pusher.min.js"></script>
<script>
    window.PUSHER_APP_KEY = "{{ config('broadcasting.connections.pusher.key') }}";
    window.PUSHER_APP_CLUSTER = "{{ config('broadcasting.connections.pusher.options.cluster') }}";
</script>

@vite('resources/js/quiz/answer-quiz.js')
@vite('resources/js/user/logout.js')
</x-layout>