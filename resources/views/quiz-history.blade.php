<x-layout>
<div class="relative bg-[#f7f6f9] h-full min-h-screen">
    <div class="flex items-start">

        <x-quiz.sidebar currentTab="history"/>

        <button id="toggle-sidebar"
            class="lg:hidden w-8 h-8 z-[100] fixed top-[36px] left-[10px] cursor-pointer bg-[#007bff] flex items-center justify-center rounded-full outline-0 transition-all duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" class="w-3 h-3" viewBox="0 0 55.752 55.752">
                <path d="M43.006 23.916a5.36 5.36 0 0 0-.912-.727L20.485 1.581a5.4 5.4 0 0 0-7.637 7.638l18.611 18.609-18.705 18.707a5.398 5.398 0 1 0 7.634 7.635l21.706-21.703a5.35 5.35 0 0 0 .912-.727 5.373 5.373 0 0 0 1.574-3.912 5.363 5.363 0 0 0-1.574-3.912z"/>
            </svg>
        </button>

        <section class="main-content w-full px-8">

            <!-- Header -->
            <x-quiz.header :hideHeader="false"/>

            <!-- Main Content -->
            <div class="my-8 px-2 space-y-6">

                <!-- Page Title + Summary Bar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-xl font-bold text-slate-800">Quiz History</h1>
                        <p class="text-sm text-slate-400 mt-0.5">A record of all quizzes you've participated in.</p>
                    </div>
                    <!-- Filter + Search -->
                    <div class="flex items-center gap-2">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-slate-400 absolute left-3 top-1/2 -translate-y-1/2" viewBox="0 0 24 24">
                                <path d="M10 2a8 8 0 1 0 4.906 14.32l4.387 4.387 1.414-1.414-4.387-4.387A8 8 0 0 0 10 2zm0 2a6 6 0 1 1 0 12A6 6 0 0 1 10 4z"/>
                            </svg>
                            <input type="text" id="searchInput" placeholder="Search quizzes..."
                                class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl outline-none focus:ring-2 focus:ring-blue-100 focus:border-[#2979FF] bg-white w-48 transition" />
                        </div>
                        <select id="filterStatus"
                            class="text-sm border border-gray-200 rounded-xl px-3 py-2 outline-none focus:ring-2 focus:ring-blue-100 focus:border-[#2979FF] bg-white text-slate-600 transition cursor-pointer">
                            <option value="all">All Results</option>
                            <option value="passed">Passed (≥70%)</option>
                            <option value="failed">Failed (&lt;70%)</option>
                        </select>
                        <select id="filterSort"
                            class="text-sm border border-gray-200 rounded-xl px-3 py-2 outline-none focus:ring-2 focus:ring-blue-100 focus:border-[#2979FF] bg-white text-slate-600 transition cursor-pointer">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="score-high">Score: High to Low</option>
                            <option value="score-low">Score: Low to High</option>
                        </select>
                    </div>
                </div>

                <!-- Summary Stats Strip -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl p-4 shadow-sm flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-[#2979FF]" viewBox="0 0 24 24">
                                <path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Total Quizzes</p>
                            <p class="text-xl font-bold text-slate-800">24</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-green-600" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Avg. Score</p>
                            <p class="text-xl font-bold text-slate-800">82%</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-yellow-500" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Best Score</p>
                            <p class="text-xl font-bold text-slate-800">98%</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-red-500" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Lowest Score</p>
                            <p class="text-xl font-bold text-slate-800">58%</p>
                        </div>
                    </div>
                </div>

                <!-- History Table Card -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="text-sm font-bold text-slate-800">All Quiz Attempts</h2>
                        <span id="resultCount" class="text-xs text-slate-400 font-medium">Showing {{ count($results) }} results</span>
                    </div>

                    <!-- Table Header -->
                    <div class="hidden sm:grid grid-cols-12 px-6 py-3 bg-slate-50 border-b border-gray-100 text-xs font-semibold text-slate-400 uppercase tracking-wide">
                        <div class="col-span-6">Quiz</div>
                        <div class="col-span-2 text-center">Score</div>
                        <div class="col-span-2 text-center">Date</div>
                        <div class="col-span-2 text-center">Details</div>
                    </div>

                    <!-- Rows — all follow: col-span-6 quiz | col-span-2 score | col-span-2 date | col-span-2 details (centered) -->
                   <div id="historyList" class="divide-y divide-gray-50">
                            @foreach ($results as $result)
                                @php
                                    $scorePercentage = $result->total_questions > 0
                                        ? round(($result->correct_count / $result->total_questions) * 100)
                                        : 0;

                                    $questionCount = count($result->quiz->questions);
                                    $quizCode = $result->quiz->code;
                                    $quizTitle = $result->quiz->title;
                                    $quizIcon = strtoupper(substr($quizTitle, 0, 2));
                                    $dateTaken = $result->created_at->format('M j, Y');

                                    if ($scorePercentage >= 80) {
                                        $scoreBadgeClass = 'bg-green-100 text-green-700';
                                        $modalRingColor = '#16a34a';
                                        $modalBadgeClass = 'bg-green-100 text-green-700';
                                        $modalBadgeText = 'Excellent';
                                    } elseif ($scorePercentage >= 70) {
                                        $scoreBadgeClass = 'bg-yellow-100 text-yellow-700';
                                        $modalRingColor = '#eab308';
                                        $modalBadgeClass = 'bg-yellow-100 text-yellow-700';
                                        $modalBadgeText = 'Passed';
                                    } else {
                                        $scoreBadgeClass = 'bg-red-100 text-red-600';
                                        $modalRingColor = '#ef4444';
                                        $modalBadgeClass = 'bg-red-100 text-red-600';
                                        $modalBadgeText = 'Failed — Keep practicing!';
                                    }
                                @endphp

                                <div class="history-row grid grid-cols-12 items-center px-6 py-4 hover:bg-gray-50 transition"
                                    data-name="{{ strtolower($quizTitle) }}"
                                    data-score="{{ $scorePercentage }}"
                                    data-date="{{ $result->created_at }}"
                                >
                                    <div class="col-span-12 sm:col-span-6 flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs shrink-0">
                                            {{ $quizIcon }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-800">{{ $quizTitle }}</p>
                                            <p class="text-xs text-slate-400">{{ $questionCount }} questions · Room: {{ $quizCode }}</p>
                                        </div>
                                    </div>

                                    <div class="col-span-4 sm:col-span-2 text-center">
                                        <span class="text-sm font-bold px-3 py-1 rounded-full {{ $scoreBadgeClass }}">
                                            {{ $scorePercentage }}%
                                        </span>
                                    </div>

                                    <div class="col-span-4 sm:col-span-2 text-center text-xs text-slate-400">
                                        {{ $dateTaken }}
                                    </div>

                                    <div class="col-span-4 sm:col-span-2 flex justify-center">
                                        <button class="w-8 h-8 rounded-lg hover:bg-blue-50 flex items-center justify-center text-slate-400 hover:text-[#2979FF] transition"
                                            onclick="openDetail(this)"
                                            data-title="{{ $quizTitle }}"
                                            data-score="{{ $scorePercentage }}"
                                            data-total="{{ $result->total_questions }}"
                                            data-correct="{{ $result->correct_count }}"
                                            data-room="{{ $quizCode }}"
                                            data-date="{{ $dateTaken }}"
                                            data-rank="{{ $userRanking[$result->quiz_id] ? '#' . $userRanking[$result->quiz_id] : 'N/A' }}"
                                            data-host="{{ $result->quiz->user->first_name . ' ' . $result->quiz->user->last_name?? 'Unknown Host' }}"
                                            data-ring-color="{{ $modalRingColor }}"
                                            data-badge-class="{{ $modalBadgeClass }}"
                                            data-badge-text="{{ $modalBadgeText }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 12.5a5 5 0 1 1 0-10 5 5 0 0 1 0 10zm0-8a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                                        <!-- Empty State -->
                                        <div id="emptyState" class="hidden py-16 flex flex-col items-center text-center">
                                            <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 fill-slate-400" viewBox="0 0 24 24">
                                                    <path d="M10 2a8 8 0 1 0 4.906 14.32l4.387 4.387 1.414-1.414-4.387-4.387A8 8 0 0 0 10 2zm0 2a6 6 0 1 1 0 12A6 6 0 0 1 10 4z"/>
                                                </svg>
                                            </div>
                                            <p class="text-slate-600 font-semibold">No results found</p>
                                            <p class="text-slate-400 text-sm mt-1">Try adjusting your search or filter.</p>
                                        </div>

                                        <!-- Pagination -->
                                        <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                                            <p class="text-xs text-slate-400">Page 1 of 3</p>
                                            <div class="flex items-center gap-1">
                                                <button class="w-8 h-8 rounded-lg border border-gray-200 text-slate-400 hover:border-[#2979FF] hover:text-[#2979FF] flex items-center justify-center transition text-xs">&lt;</button>
                                                <button class="w-8 h-8 rounded-lg bg-[#2979FF] text-white flex items-center justify-center text-xs font-bold">1</button>
                                                <button class="w-8 h-8 rounded-lg border border-gray-200 text-slate-500 hover:border-[#2979FF] hover:text-[#2979FF] flex items-center justify-center transition text-xs">2</button>
                                                <button class="w-8 h-8 rounded-lg border border-gray-200 text-slate-500 hover:border-[#2979FF] hover:text-[#2979FF] flex items-center justify-center transition text-xs">3</button>
                                                <button class="w-8 h-8 rounded-lg border border-gray-200 text-slate-400 hover:border-[#2979FF] hover:text-[#2979FF] flex items-center justify-center transition text-xs">&gt;</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </section>
                        </div>
                    </div>

                <!-- Detail Modal -->
                <div id="detailModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center">
                    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeDetail()"></div>
                    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-8 z-10">

                        <button onclick="closeDetail()"
                            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        <div class="flex items-center gap-5 mb-6">
                            <div class="relative w-20 h-20 shrink-0">
                                <svg class="w-20 h-20 -rotate-90" viewBox="0 0 80 80">
                                    <circle cx="40" cy="40" r="32" fill="none" stroke="#e2e8f0" stroke-width="8"/>
                                    <circle id="scoreRing" cx="40" cy="40" r="32" fill="none" stroke="#2979FF" stroke-width="8"
                                        stroke-linecap="round" stroke-dasharray="201" stroke-dashoffset="50"/>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <span id="modalScore" class="text-lg font-black text-slate-800">90%</span>
                                </div>
                            </div>
                            <div>
                                <h2 id="modalTitle" class="text-lg font-bold text-slate-800">Quiz Title</h2>
                                <p id="modalDate" class="text-xs text-slate-400">Date</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-6">
                            <div class="bg-slate-50 rounded-xl p-4">
                                <p class="text-xs text-slate-400 font-medium">Correct Answers</p>
                                <p id="modalCorrect" class="text-xl font-bold text-slate-800 mt-1">18 / 20</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-4">
                                <p class="text-xs text-slate-400 font-medium">Your Rank</p>
                                <p id="modalRank" class="text-xl font-bold text-slate-800 mt-1">#3</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-4">
                                <p class="text-xs text-slate-400 font-medium">Room Code</p>
                                <p id="modalRoom" class="text-xl font-bold text-slate-800 mt-1 tracking-widest">A3FX</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-4">
                                <p class="text-xs text-slate-400 font-medium">Host</p>
                                <p id="modalHost" class="text-xl font-bold text-slate-800 mt-1">Testing Host</p>
                            </div>
                        </div>

                        <div id="modalBadge" class="w-full py-2.5 rounded-xl text-center text-sm font-bold bg-green-100 text-green-700">
                            🎉 Passed
                        </div>
                    </div>
                </div>

<script>
    const searchInput  = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterSort   = document.getElementById('filterSort');
    const resultCount  = document.getElementById('resultCount');
    const emptyState   = document.getElementById('emptyState');

    function applyFilters() {
        const q      = searchInput.value.toLowerCase();
        const status = filterStatus.value;
        const sort   = filterSort.value;
        let rows     = [...document.querySelectorAll('.history-row')];

        rows.forEach(row => {
            const matchSearch = row.dataset.name.includes(q);
            const score = parseInt(row.dataset.score);
            const matchStatus = status === 'all'
                ? true
                : status === 'passed'
                    ? score >= 70
                    : score < 70;

            row.style.display = (matchSearch && matchStatus) ? '' : 'none';
        });

        const parent  = document.getElementById('historyList');
        const visible = rows.filter(r => r.style.display !== 'none');

        visible.sort((a, b) => {
            if (sort === 'newest')     return new Date(b.dataset.date) - new Date(a.dataset.date);
            if (sort === 'oldest')     return new Date(a.dataset.date) - new Date(b.dataset.date);
            if (sort === 'score-high') return parseInt(b.dataset.score) - parseInt(a.dataset.score);
            if (sort === 'score-low')  return parseInt(a.dataset.score) - parseInt(b.dataset.score);
            return 0;
        });

        visible.forEach(r => parent.appendChild(r));

        const count = visible.length;
        resultCount.textContent = `Showing ${count} result${count !== 1 ? 's' : ''}`;
        emptyState.style.display = count === 0 ? 'flex' : 'none';
    }

    searchInput.addEventListener('input', applyFilters);
    filterStatus.addEventListener('change', applyFilters);
    filterSort.addEventListener('change', applyFilters);

    function openDetail(btn) {
        const score = parseInt(btn.dataset.score);
        const circumference = 201;
        const offset = circumference - (score / 100) * circumference;

        document.getElementById('modalTitle').textContent = btn.dataset.title;
        document.getElementById('modalScore').textContent = score + '%';
        document.getElementById('modalDate').textContent = btn.dataset.date;
        document.getElementById('modalCorrect').textContent = `${btn.dataset.correct} / ${btn.dataset.total}`;
        document.getElementById('modalRank').textContent = btn.dataset.rank;
        document.getElementById('modalRoom').textContent = btn.dataset.room;
        document.getElementById('modalHost').textContent = btn.dataset.host ?? 'Unknown Host';

        const ring = document.getElementById('scoreRing');
        ring.style.strokeDashoffset = offset;
        ring.style.stroke = btn.dataset.ringColor || '#2979FF';

        const badge = document.getElementById('modalBadge');
        badge.className = `w-full py-2.5 rounded-xl text-center text-sm font-bold ${btn.dataset.badgeClass}`;
        badge.textContent = btn.dataset.badgeText;

        document.getElementById('detailModal').classList.remove('hidden');
    }

    function closeDetail() {
        document.getElementById('detailModal').classList.add('hidden');
    }
</script>
@vite('resources/js/user/logout.js')

</x-layout>