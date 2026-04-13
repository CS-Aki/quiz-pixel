<x-layout>
<div class="relative bg-[#f7f6f9] h-full min-h-screen">
    <div class="flex items-start">

        <x-quiz.sidebar currentTab="quizzes"/>

        <button id="toggle-sidebar"
            class="lg:hidden w-8 h-8 z-[100] fixed top-[36px] left-[10px] cursor-pointer bg-[#007bff] flex items-center justify-center rounded-full outline-0 transition-all duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" class="w-3 h-3" viewBox="0 0 55.752 55.752">
                <path d="M43.006 23.916a5.36 5.36 0 0 0-.912-.727L20.485 1.581a5.4 5.4 0 0 0-7.637 7.638l18.611 18.609-18.705 18.707a5.398 5.398 0 1 0 7.634 7.635l21.706-21.703a5.35 5.35 0 0 0 .912-.727 5.373 5.373 0 0 0 1.574-3.912 5.363 5.363 0 0 0-1.574-3.912z"/>
            </svg>
        </button>

        <section class="main-content w-full px-8">

            <x-quiz.header :hideHeader="false"/>

            <div class="my-6 px-2 space-y-6">

                {{-- ── Page Header ── --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <a href="{{ route('to-quiz-history') }}" class="text-sm text-slate-400 hover:text-[#2979FF] transition">My Quizzes</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 fill-slate-300" viewBox="0 0 24 24"><path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"/></svg>
                            <span class="text-sm text-slate-700 font-medium">{{ $quiz->title }}</span>
                        </div>
                        <h1 class="text-xl font-bold text-slate-800">Quiz Results</h1>
                        <p class="text-sm text-slate-400 mt-0.5">
                            Code &nbsp;·&nbsp; <span class="font-semibold tracking-widest text-slate-600">{{ $quiz->code }}</span>
                            &nbsp;·&nbsp; {{ now()->format('M j, Y') }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('to-quiz-results-export', ['id' => $quiz->id]) }}"
                            class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold border border-gray-200 text-slate-600 rounded-xl hover:bg-gray-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zm-8 2V5h2v6h1.17L12 13.17 9.83 11H11zm-6 7h14v2H5z"/></svg>
                            Export CSV
                        </a>
                        <a href="{{ route('to-edit-quiz', ['id' => $quiz->id]) }}"
                            class="flex items-center gap-1.5 px-4 py-2 text-sm font-semibold bg-[#2979FF] text-white rounded-xl hover:bg-[#1565C0] transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-white" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zm17.71-10.21a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                            Edit Quiz
                        </a>
                    </div>
                </div>

                {{-- ── Summary Stats ── --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl p-4 shadow-sm flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-[#2979FF]" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Total Players</p>
                            <p id="statTotalPlayers" class="text-xl font-bold text-slate-800">{{ $totalPlayers }}</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-green-600" viewBox="0 0 24 24"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Avg. Score</p>
                            <p id="statAvgScore" class="text-xl font-bold text-slate-800">{{ $avgScore }}%</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-yellow-500" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Highest Score</p>
                            <p id="statHighestScore" class="text-xl font-bold text-slate-800">{{ $highestScore }} pts</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-purple-600" viewBox="0 0 24 24"><path d="M11 17h2v-6h-2v6zm1-15C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 9h2V7h-2v2z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Completion Rate</p>
                            <p class="text-xl font-bold text-slate-800">{{ $completionRate }}%</p>
                        </div>
                    </div>
                </div>

                {{-- ── Two-column: Leaderboard + Right Panel ── --}}
                <div class="grid lg:grid-cols-5 gap-4">

                    {{-- ── Leaderboard (3/5) ── --}}
                    <div class="lg:col-span-3 bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h2 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-yellow-400" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                                Leaderboard
                            </h2>
                            <span class="text-xs text-slate-400">{{ $totalPlayers }} players</span>
                        </div>

                        {{-- Podium Top 3 --}}
                        @if(count($leaderboard) >= 3)
                        <div class="flex items-end justify-center gap-3 px-6 pt-6 pb-4">
                            {{-- 2nd --}}
                            @php $second = $leaderboard[1]; @endphp
                            <div id="podium2nd" class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-sm font-black text-slate-500 border-2 border-slate-300 podium-initials">
                                    {{ strtoupper(substr($second->player_name, 0, 2)) }}
                                </div>
                                <p class="text-xs font-semibold text-slate-700 truncate max-w-[80px] text-center podium-name">{{ $second->player_name }}</p>
                                <p class="text-sm font-black text-slate-800 podium-score">{{ $second->score }} pts</p>
                                <div class="w-full bg-slate-100 rounded-t-lg h-14 flex items-center justify-center">
                                    <span class="text-lg font-black text-slate-400">2</span>
                                </div>
                            </div>

                            {{-- 1st --}}
                            @php $first = $leaderboard[0]; @endphp
                            <div id="podium1st" class="flex-1 flex flex-col items-center gap-1">
                                <span class="text-lg">👑</span>
                                <div class="w-12 h-12 rounded-full bg-yellow-400 flex items-center justify-center text-sm font-black text-white border-2 border-yellow-500 shadow-md podium-initials">
                                    {{ strtoupper(substr($first->player_name, 0, 2)) }}
                                </div>
                                <p class="text-xs font-semibold text-slate-700 truncate max-w-[80px] text-center podium-name">{{ $first->player_name }}</p>
                                <p class="text-sm font-black text-[#2979FF] podium-score">{{ $first->score }} pts</p>
                                <div class="w-full bg-yellow-100 rounded-t-lg h-20 flex items-center justify-center">
                                    <span class="text-2xl font-black text-yellow-500">1</span>
                                </div>
                            </div>

                            {{-- 3rd --}}
                            @php $third = $leaderboard[2]; @endphp
                            <div id="podium3rd" class="flex-1 flex flex-col items-center gap-1">
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-sm font-black text-orange-500 border-2 border-orange-200 podium-initials">
                                    {{ strtoupper(substr($third->player_name, 0, 2)) }}
                                </div>
                                <p class="text-xs font-semibold text-slate-700 truncate max-w-[80px] text-center podium-name">{{ $third->player_name }}</p>
                                <p class="text-sm font-black text-slate-800 podium-score">{{ $third->score }} pts</p>
                                <div class="w-full bg-orange-50 rounded-t-lg h-10 flex items-center justify-center">
                                    <span class="text-base font-black text-orange-400">3</span>
                                </div>
                            </div>
                        @endif

                        {{-- Full rank list --}}
                        <div class="divide-y divide-gray-50">
                            <div class="hidden sm:grid grid-cols-12 px-6 py-2 bg-slate-50 border-t border-gray-100 text-xs font-semibold text-slate-400 uppercase tracking-wide">
                                <div class="col-span-1 text-center">#</div>
                                <div class="col-span-5">Player</div>
                                <div class="col-span-2 text-center">Score</div>
                                <div class="col-span-2 text-center">Correct</div>
                                <div class="col-span-2 text-center">Time</div>
                            </div>

                            <div id="leaderboardList">  {{-- ← add this wrapper --}}
                                @foreach ($leaderboard as $index => $entry)
                                    @php
                                        $rank = $index + 1;
                                        $scorePercent = $entry->total_questions > 0
                                            ? round(($entry->correct_count / $entry->total_questions) * 100)
                                            : 0;
                                        $scoreBg = match(true) {
                                            $scorePercent >= 80 => 'bg-green-100 text-green-700',
                                            $scorePercent >= 50 => 'bg-yellow-100 text-yellow-700',
                                            default             => 'bg-red-100 text-red-600',
                                        };
                                    @endphp
                                    <div class="leaderboard-row grid grid-cols-12 items-center px-6 py-3 hover:bg-slate-50 transition {{ $rank <= 3 ? 'bg-slate-50/50' : '' }}"
                                        data-player-name="{{ strtolower($entry->player_name) }}"
                                        data-score="{{ $entry->score }}">
                                        <div class="col-span-1 text-center lb-rank-cell">
                                            @if($rank === 1) <span>🥇</span>
                                            @elseif($rank === 2) <span>🥈</span>
                                            @elseif($rank === 3) <span>🥉</span>
                                            @else <span class="text-xs text-slate-400">{{ $rank }}</span>
                                            @endif
                                        </div>
                                        <div class="col-span-5 flex items-center gap-2.5 min-w-0">
                                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-[#2979FF] shrink-0 lb-initials">
                                                {{ strtoupper(substr($entry->player_name, 0, 2)) }}
                                            </div>
                                            <p class="text-sm font-semibold text-slate-700 truncate lb-name">{{ $entry->player_name }}</p>
                                        </div>
                                        <div class="col-span-2 text-center lb-score">
                                            <span class="text-sm font-black text-slate-800">{{ $entry->score }}</span>
                                            <span class="text-xs text-slate-400"> pts</span>
                                        </div>
                                        <div class="col-span-2 text-center lb-correct">
                                            <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $scoreBg }}">
                                                {{ $entry->correct_count }}/{{ $entry->total_questions }}
                                            </span>
                                        </div>
                                        <div class="col-span-2 text-center text-xs text-slate-400 font-medium lb-time">
                                            {{ gmdate('i:s', $entry->time_taken_seconds ?? 0) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>  {{-- ← close leaderboardList --}}
                        </div>
                    </div>

                    {{-- ── Right Panel ── --}}
                    <div class="lg:col-span-2 flex flex-col gap-4">

                        {{-- Score Distribution --}}
                        <div class="bg-white rounded-xl shadow-sm p-5">
                            <h2 class="text-sm font-bold text-slate-800 mb-4">Score Distribution</h2>
                            <div class="space-y-2.5">
                                @php
                                    $bands = [
                                        ['label' => '90–100%',   'count' => $scoreBand90,      'color' => 'bg-green-500',  'id' => 'band90'],
                                        ['label' => '70–89%',    'count' => $scoreBand70,      'color' => 'bg-blue-400',   'id' => 'band70'],
                                        ['label' => '50–69%',    'count' => $scoreBand50,      'color' => 'bg-yellow-400', 'id' => 'band50'],
                                        ['label' => 'Below 50%', 'count' => $scoreBandBelow50, 'color' => 'bg-red-400',    'id' => 'bandBelow'],
                                    ];
                                    $maxBand = max(array_column($bands, 'count')) ?: 1;
                                @endphp

                                @foreach($bands as $band)
                                <div class="flex items-center gap-3">
                                    <span class="text-xs text-slate-400 font-medium w-16 shrink-0 text-right">{{ $band['label'] }}</span>
                                    <div class="flex-1 bg-gray-100 rounded-full h-2.5 overflow-hidden">
                                        <div class="{{ $band['color'] }} band-bar h-full rounded-full"
                                            style="width: {{ round(($band['count'] / $maxBand) * 100) }}%"></div>
                                    </div>
                                    <span id="{{ $band['id'] }}" class="text-xs font-bold text-slate-600 w-4 shrink-0">
                                        {{ $band['count'] }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Question Accuracy --}}
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden flex-1">
                            <div class="px-5 py-4 border-b border-gray-100">
                                <h2 class="text-sm font-bold text-slate-800">Question Accuracy</h2>
                                <p class="text-xs text-slate-400 mt-0.5">% of players who answered correctly</p>
                            </div>
                            <div class="divide-y divide-gray-50 max-h-72 overflow-y-auto">
                                @foreach ($questionStats as $qIndex => $qStat)
                                    @php
                                        $pct = $qStat['accuracy'];
                                        $barColor = match(true) {
                                            $pct >= 75 => 'bg-green-500',
                                            $pct >= 50 => 'bg-blue-400',
                                            $pct >= 25 => 'bg-yellow-400',
                                            default    => 'bg-red-400',
                                        };
                                        $textColor = match(true) {
                                            $pct >= 75 => 'text-green-600',
                                            $pct >= 50 => 'text-blue-500',
                                            $pct >= 25 => 'text-yellow-600',
                                            default    => 'text-red-500',
                                        };
                                    @endphp
                                    <div class="px-5 py-3 hover:bg-slate-50 transition cursor-pointer question-row"
                                         data-index="{{ $qIndex + 1 }}"
                                         data-question="{{ $qStat['question'] }}"
                                         data-accuracy="{{ $pct }}"
                                         data-correct-answer="{{ $qStat['correct_answer'] }}"
                                         data-correct-count="{{ $qStat['correct_count'] }}"
                                         data-total="{{ $qStat['total'] }}">
                                        <div class="flex items-center justify-between mb-1.5">
                                            <p class="text-xs font-semibold text-slate-600 truncate pr-4">
                                                <span class="text-slate-400 mr-1">Q{{ $qIndex + 1 }}.</span>{{ $qStat['question'] }}
                                            </p>
                                            <span class="text-xs font-black {{ $textColor }} shrink-0">{{ $pct }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                            <div class="{{ $barColor }} h-full rounded-full" style="width: {{ $pct }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ── All Players Table ── --}}
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center gap-3 justify-between">
                        <div>
                            <h2 class="text-sm font-bold text-slate-800">All Players</h2>
                            <p id="playerCount" class="text-xs text-slate-400 mt-0.5">Showing {{ count($leaderboard) }} players</p>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <!-- Search -->
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" viewBox="0 0 24 24"><path d="M10 2a8 8 0 1 0 4.906 14.32l4.387 4.387 1.414-1.414-4.387-4.387A8 8 0 0 0 10 2zm0 2a6 6 0 1 1 0 12A6 6 0 0 1 10 4z"/></svg>
                                <input type="text" id="playerSearch" placeholder="Search player..."
                                    class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-100 focus:border-[#2979FF] bg-white w-48 transition" />
                            </div>
                            <!-- Sort -->
                            <select id="playerSort"
                                class="text-sm border border-gray-200 rounded-xl px-3 py-2 outline-none focus:ring-2 focus:ring-blue-100 focus:border-[#2979FF] bg-white text-slate-600 transition cursor-pointer">
                                <option value="rank">Rank (Default)</option>
                                <option value="score-high">Score: High → Low</option>
                                <option value="score-low">Score: Low → High</option>
                                <option value="name-asc">Name: A → Z</option>
                                <option value="name-desc">Name: Z → A</option>
                            </select>
                        </div>
                    </div>

                    <div class="hidden sm:grid grid-cols-12 px-6 py-3 bg-slate-50 border-b border-gray-100 text-xs font-semibold text-slate-400 uppercase tracking-wide">
                        <div class="col-span-1 text-center">Rank</div>
                        <div class="col-span-4">Player</div>
                        <div class="col-span-2 text-center">Score</div>
                        <div class="col-span-2 text-center">Correct</div>
                        <div class="col-span-2 text-center">Time Taken</div>
                        <div class="col-span-1 text-center">Detail</div>
                    </div>

                    <div id="playerList" class="divide-y divide-gray-50">
                        @foreach ($leaderboard as $index => $entry)
                            @php
                                $rank = $index + 1;
                                $scorePercent = $entry->total_questions > 0
                                    ? round(($entry->correct_count / $entry->total_questions) * 100)
                                    : 0;
                                $scoreBg = match(true) {
                                    $scorePercent >= 80 => 'bg-green-100 text-green-700',
                                    $scorePercent >= 50 => 'bg-yellow-100 text-yellow-700',
                                    default             => 'bg-red-100 text-red-600',
                                };
                            @endphp
                            <div class="player-row grid grid-cols-12 items-center px-6 py-3 hover:bg-slate-50 transition"
                                 data-name="{{ strtolower($entry->player_name) }}"
                                 data-score="{{ $entry->score }}"
                                 data-rank="{{ $rank }}">
                                <div class="col-span-1 text-center text-xs font-bold text-slate-400">{{ $rank }}</div>
                                <div class="col-span-4 flex items-center gap-2.5 min-w-0">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-[#2979FF] shrink-0">
                                        {{ strtoupper(substr($entry->player_name, 0, 2)) }}
                                    </div>
                                    <p class="text-sm font-semibold text-slate-700 truncate">{{ $entry->player_name }}</p>
                                </div>
                                <div class="col-span-2 text-center">
                                    <span class="text-sm font-black text-slate-800">{{ $entry->score }}</span>
                                    <span class="text-xs text-slate-400"> pts</span>
                                </div>
                                <div class="col-span-2 text-center">
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $scoreBg }}">
                                        {{ $entry->correct_count }}/{{ $entry->total_questions }}
                                    </span>
                                </div>
                                <div class="col-span-2 text-center text-xs text-slate-500 font-medium">
                                    {{ gmdate('i:s', $entry->time_taken_seconds ?? 0) }}
                                </div>
                                <div class="col-span-1 text-center">
                                    <button class="btn-view-player text-xs px-2.5 py-1 border border-gray-200 text-slate-500 rounded-lg hover:bg-gray-50 hover:border-[#2979FF] hover:text-[#2979FF] transition"
                                        data-name="{{ $entry->player_name }}"
                                        data-score="{{ $entry->score }}"
                                        data-rank="{{ $rank }}"
                                        data-correct="{{ $entry->correct_count }}"
                                        data-total="{{ $entry->total_questions }}"
                                        data-time="{{ gmdate('i:s', $entry->time_taken_seconds ?? 0) }}"
                                        data-score-pct="{{ $scorePercent }}"
                                        data-badge-class="{{ $scorePercent >= 70 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}"
                                        data-badge-text="{{ $scorePercent >= 70 ? '🎉 Passed' : '❌ Failed' }}"
                                        data-ring-color="{{ $scorePercent >= 70 ? '#16a34a' : '#dc2626' }}">
                                        View
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div id="playerEmpty" class="hidden py-10 text-center text-slate-400 text-sm">
                        No players match your search.
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>

{{-- ════════════════════════════════════
     Player Detail Modal
════════════════════════════════════ --}}
<div id="playerDetailModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center">
    <div class="modal-backdrop absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-8 z-10">

        <button id="btnClosePlayerModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="flex items-center gap-5 mb-6">
            <div class="relative w-20 h-20 shrink-0">
                <svg class="w-20 h-20 -rotate-90" viewBox="0 0 80 80">
                    <circle cx="40" cy="40" r="32" fill="none" stroke="#e2e8f0" stroke-width="8"/>
                    <circle id="pdScoreRing" cx="40" cy="40" r="32" fill="none" stroke="#2979FF" stroke-width="8"
                        stroke-linecap="round" stroke-dasharray="201" stroke-dashoffset="50"/>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span id="pdScoreText" class="text-lg font-black text-slate-800">—</span>
                </div>
            </div>
            <div>
                <h2 id="pdName" class="text-lg font-bold text-slate-800">—</h2>
                <p id="pdRank" class="text-xs text-slate-400 mt-0.5">—</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-5">
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs text-slate-400 font-medium">Score</p>
                <p id="pdScore" class="text-xl font-bold text-slate-800 mt-1">—</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs text-slate-400 font-medium">Correct Answers</p>
                <p id="pdCorrect" class="text-xl font-bold text-slate-800 mt-1">—</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs text-slate-400 font-medium">Time Taken</p>
                <p id="pdTime" class="text-xl font-bold text-slate-800 mt-1">—</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs text-slate-400 font-medium">Quiz</p>
                <p class="text-sm font-bold text-slate-800 mt-1 truncate">{{ $quiz->title }}</p>
            </div>
        </div>

        <div id="pdBadge" class="w-full py-2.5 rounded-xl text-center text-sm font-bold bg-green-100 text-green-700">
            —
        </div>
    </div>
</div>

{{-- ════════════════════════════════════
     Question Detail Modal
════════════════════════════════════ --}}
<div id="questionDetailModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center">
    <div class="modal-backdrop absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-8 z-10">

        <button id="btnCloseQuestionModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <div class="mb-5">
            <p class="text-xs text-slate-400 font-medium mb-1">Question <span id="qdIndex">—</span></p>
            <h2 id="qdQuestion" class="text-base font-bold text-slate-800 leading-snug">—</h2>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-5">
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs text-slate-400 font-medium">Accuracy</p>
                <p id="qdAccuracy" class="text-xl font-bold text-slate-800 mt-1">—</p>
            </div>
            <div class="bg-slate-50 rounded-xl p-4">
                <p class="text-xs text-slate-400 font-medium">Correct / Total</p>
                <p id="qdCounts" class="text-xl font-bold text-slate-800 mt-1">—</p>
            </div>
        </div>

        <div class="bg-blue-50 rounded-xl px-4 py-3 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-[#2979FF] shrink-0 mt-0.5" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15v-6h2v6h-2zm0-8V7h2v2h-2z"/></svg>
            <div>
                <p class="text-xs font-semibold text-[#2979FF] mb-0.5">Correct Answer</p>
                <p id="qdCorrectAnswer" class="text-sm font-bold text-slate-800">—</p>
            </div>
        </div>
    </div>
</div>

<script>
    window.QuizResultConfig = {
        quizCode: '{{ $quiz->code }}',
        quizId:   '{{ $quiz->id }}',
        totalQuestions: {{ $quiz->questions->count() }},
    };
</script>

@vite('resources/js/quiz/quiz-result.js')
@vite('resources/js/user/logout.js')

</x-layout>