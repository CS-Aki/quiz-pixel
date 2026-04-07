<x-layout>
<div class="relative bg-[#f7f6f9] h-full min-h-screen">
    <div class="flex items-start">
        <x-quiz.sidebar currentTab=""/>

        <section class="main-content w-full px-8">
            <x-quiz.header :hideHeader="true"/>

            <div class="my-6 px-2 max-w-4xl mx-auto">

                <!-- Room Header -->
                <div class="bg-gradient-to-r from-[#2979FF] to-[#29B6F6] rounded-2xl p-6 mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-semibold text-blue-100 uppercase tracking-widest">Quiz Room</span>
                            <span class="flex items-center gap-1.5 text-xs font-semibold bg-white/20 text-white px-2.5 py-0.5 rounded-full">
                                <span class="w-1.5 h-1.5 bg-green-300 rounded-full animate-pulse inline-block"></span>
                                Waiting for host
                            </span>
                        </div>
                        <h1 class="text-white text-xl font-bold">{{ $quiz[0]->title }}</h1>
                        @if ($userStatus === 'owner')
                            <p class="text-blue-100 text-sm mt-0.5">Hosted by <span class="font-semibold text-white">{{ $user->first_name }}</span></p>
                        @endif

                        @if ($userStatus === 'participant')
                            <p class="text-blue-100 text-sm mt-0.5">Hosted by <span class="font-semibold text-white">{{ $userOwner }}</span></p>
                        @endif
                    </div>

                    <!-- Room Code -->
                    <div class="bg-white/15 backdrop-blur rounded-xl px-5 py-3 text-center min-w-[160px]">
                        <p class="text-blue-100 text-xs font-medium mb-1">Room Code</p>
                        <p class="text-white text-3xl font-bold tracking-[0.2em]" id="roomCode">{{ $quiz[0]->code }}</p>
                        <button onclick="copyCode()" class="text-blue-100 text-xs mt-1.5 hover:text-white transition flex items-center gap-1 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 fill-current" viewBox="0 0 24 24">
                                <path d="M16 1H4a2 2 0 0 0-2 2v14h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                            </svg>
                            <span id="copyLabel">Copy code</span>
                        </button>
                    </div>
                </div>

                <!-- Quiz Info Strip -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-4 mb-6 flex flex-wrap gap-6">
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-[#2979FF]" viewBox="0 0 24 24">
                            <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm1 14.93V18h-2v-1.07A4.002 4.002 0 0 1 8 13h2a2 2 0 1 0 2-2c-2.21 0-4-1.79-4-4a4.002 4.002 0 0 1 3-3.87V2h2v1.13A4.002 4.002 0 0 1 16 7h-2a2 2 0 1 0-2 2c2.21 0 4 1.79 4 4a4.002 4.002 0 0 1-3 3.93z"/>
                        </svg>
                        <span><span class="font-semibold text-slate-800">{{ count($quiz[0]->questions) }}</span> questions</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-[#2979FF]" viewBox="0 0 510 510">
                            <g fill-opacity=".9">
                                <path d="M255 0C114.75 0 0 114.75 0 255s114.75 255 255 255 255-114.75 255-255S395.25 0 255 0zm0 459c-112.2 0-204-91.8-204-204S142.8 51 255 51s204 91.8 204 204-91.8 204-204 204z"/>
                                <path d="M267.75 127.5H229.5v153l132.6 81.6 20.4-33.15-114.75-68.85z"/>
                            </g>
                        </svg> --}}
                        {{-- <span><span class="font-semibold text-slate-800">30</span> sec per question</span> --}}
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-[#2979FF]" viewBox="0 0 24 24">
                            <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm-1-6h2v2h-2zm0-8h2v6h-2z"/>
                        </svg> --}}
                        {{-- <span><span class="font-semibold text-slate-800">10</span> pts per question</span> --}}
                    </div>
                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        {{-- <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-[#2979FF]" viewBox="0 0 214.27 214.27">
                            <path d="M196.926 55.171c-.11-5.785-.215-11.25-.215-16.537a7.5 7.5 0 0 0-7.5-7.5c-32.075 0-56.496-9.218-76.852-29.01a7.498 7.498 0 0 0-10.457 0c-20.354 19.792-44.771 29.01-76.844 29.01a7.5 7.5 0 0 0-7.5 7.5c0 5.288-.104 10.755-.215 16.541-1.028 53.836-2.436 127.567 87.331 158.682a7.495 7.495 0 0 0 4.912 0c89.774-31.116 88.368-104.849 87.34-158.686zm-89.795 143.641c-76.987-27.967-75.823-89.232-74.79-143.351.062-3.248.122-6.396.164-9.482 30.04-1.268 54.062-10.371 74.626-28.285 20.566 17.914 44.592 27.018 74.634 28.285.042 3.085.102 6.231.164 9.477 1.032 54.121 2.195 115.388-74.798 143.356z"/>
                        </svg> --}}
                        {{-- <span>Geography</span> --}}
                    </div>
                    <div class="ml-auto flex items-center gap-2 text-sm">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="font-semibold text-slate-800" id="playerCount">4</span>
                        <span class="text-slate-500">players joined</span>
                    </div>
                </div>

                <!-- Players + Waiting -->
                <div class="grid lg:grid-cols-3 gap-6">
                    <!-- Players Grid -->
                    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                            <h2 class="text-sm font-bold text-slate-800">Players in Room</h2>
                            <span class="text-xs text-slate-400" id="playerCountLabel">0 / <span id="playerLimit">{{ $quiz[0]->user_limit }}</span> </span>
                        </div>
                        <div id="playerGrid" class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-5">
                            @if ($userStatus === 'owner')
                                <div class="player-card flex flex-col items-center gap-2 bg-[#EFF6FF] border border-blue-100 rounded-xl py-4 px-3">
                                    <div class="w-12 h-12 rounded-full bg-[#2979FF] flex items-center justify-center text-white font-bold text-sm">KG</div>
                                    <p class="text-xs font-semibold text-slate-700 text-center truncate w-full text-center">{{ $user->username }}</p>
                                    <span class="text-[10px] font-bold text-[#2979FF] bg-blue-100 px-2 py-0.5 rounded-full">Host</span>
                                </div>
                            @endif

                            @if ($userStatus === 'participant')
                                <div class="player-card flex flex-col items-center gap-2 bg-[#EFF6FF] border border-blue-100 rounded-xl py-4 px-3">
                                    <div class="w-12 h-12 rounded-full bg-[#2979FF] flex items-center justify-center text-white font-bold text-sm">KG</div>
                                    <p class="text-xs font-semibold text-slate-700 text-center truncate w-full text-center">{{ $user->username }}</p>
                                    <span class="text-[10px] font-bold text-[#2979FF] bg-blue-100 px-2 py-0.5 rounded-full">Ready</span>
                                </div>
                            @endif

                            <div class="player-card flex flex-col items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl py-4 px-3">
                                <div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center text-white font-bold text-sm">MR</div>
                                <p class="text-xs font-semibold text-slate-700 text-center truncate w-full text-center">Maria</p>
                                <span class="text-[10px] font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Ready</span>
                            </div>

                            {{-- <div class="player-card flex flex-col items-center gap-2 bg-gray-50 border border-gray-100 rounded-xl py-4 px-3">
                                <div class="w-12 h-12 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold text-sm">AL</div>
                                <p class="text-xs font-semibold text-slate-700 text-center truncate w-full text-center">Alex</p>
                                <span class="text-[10px] font-medium text-yellow-600 bg-yellow-50 px-2 py-0.5 rounded-full">Joined</span>
                            </div> --}}

                            {{-- <div class="flex flex-col items-center gap-2 border-2 border-dashed border-gray-200 rounded-xl py-4 px-3">
                                <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-gray-300" viewBox="0 0 24 24">
                                        <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-5.33 0-8 2.67-8 4v2h16v-2c0-1.33-2.67-4-8-4z"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-300 font-medium">Waiting...</p>
                            </div> --}}

                        </div>
                    </div>

                    <!-- Right Panel -->
                    <div class="flex flex-col gap-4">

                        <!-- Your Status Card -->
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Your Status</p>
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-full bg-[#2979FF] flex items-center justify-center text-white font-bold text-sm shrink-0">KG</div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Kang</p>
                                    <p class="text-xs text-[#2979FF] font-semibold">Host</p>
                                </div>
                            </div>
                            {{-- <div class="flex items-center gap-2 bg-green-50 border border-green-100 rounded-xl px-3 py-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-green-500" viewBox="0 0 24 24">
                                    <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                <span class="text-xs font-semibold text-green-700">You're in the room</span>
                            </div> --}}
                        </div>

                        <!-- Host Controls -->
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Host Controls</p>
                            <div class="space-y-2.5">
                                @if ($userStatus === 'owner')
                                    <button onclick="startQuiz()"
                                        class="w-full flex items-center justify-center gap-2 py-3 bg-[#2979FF] text-white text-sm font-bold rounded-xl hover:bg-[#1565C0] transition shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-white" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                        Start Quiz Now
                                    </button>
                                @endif
                                <button class="w-full flex items-center justify-center gap-2 py-2.5 border border-gray-200 text-slate-500 text-sm font-medium rounded-xl hover:bg-gray-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81a3 3 0 0 0 0-6 3 3 0 0 0-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9a3 3 0 0 0 0 6c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92s2.92-1.31 2.92-2.92c0-1.61-1.31-2.92-2.92-2.92z"/>
                                    </svg>
                                    Share Room Link
                                </button>
                                @if ($userStatus === 'owner')
                                    <button class="w-full flex items-center justify-center gap-2 py-2.5 border border-red-100 text-red-400 text-sm font-medium rounded-xl hover:bg-red-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                            <path d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                        </svg>
                                        Close Room
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Waiting Animation -->
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                            <div class="flex items-center justify-center gap-1.5 mb-2">
                                <span class="w-2 h-2 bg-[#2979FF] rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                                <span class="w-2 h-2 bg-[#2979FF] rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                                <span class="w-2 h-2 bg-[#2979FF] rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                            </div>
                            <p class="text-xs text-slate-500 font-medium">Waiting for host to start</p>
                            <p class="text-xs text-slate-400 mt-0.5">This page will update automatically</p>
                        </div>

                    </div>
                </div>

                <!-- Leave Button (for participants) -->
                <div class="mt-4 flex justify-start">
                    <button class="flex items-center gap-2 text-sm text-slate-400 hover:text-red-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M10.09 15.59 11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5a2 2 0 0 0-2 2v4h2V5h14v14H5v-4H3v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2z"/>
                        </svg>
                        Leave Room
                    </button>
                </div>

            </div>
        </section>
    </div>
</div>

<!-- Start Countdown Overlay -->
<div id="countdownOverlay" class="hidden fixed inset-0 z-[300] bg-[#2979FF]/95 flex flex-col items-center justify-center">
    <p class="text-white text-xl font-semibold mb-4 tracking-wide">Get Ready!</p>
    <div class="text-white font-bold text-[120px] leading-none" id="countdownNum">3</div>
    <p class="text-blue-200 text-base mt-4">The quiz is starting...</p>
</div>

<script>
    function copyCode() {
        const code = document.getElementById('roomCode').textContent;
        navigator.clipboard.writeText(code).then(() => {
            const label = document.getElementById('copyLabel');
            label.textContent = 'Copied!';
            setTimeout(() => label.textContent = 'Copy code', 2000);
        });
    }

    function startQuiz() {
        const overlay = document.getElementById('countdownOverlay');
        const num = document.getElementById('countdownNum');
        overlay.classList.remove('hidden');
        let count = 3;
        const interval = setInterval(() => {
            count--;
            if (count === 0) {
                num.textContent = 'GO!';
                clearInterval(interval);
                setTimeout(() => {
                    // redirect to quiz question page
                    // window.location.href = '/quiz/play';
                    overlay.classList.add('hidden');
                }, 800);
            } else {
                num.textContent = count;
            }
        }, 1000);
    }
</script>

@vite('resources/js/quiz/lobby.js')

</x-layout>