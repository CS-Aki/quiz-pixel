<x-layout>
<div class="relative bg-[#f7f6f9] h-full min-h-screen">
    <div class="flex items-start">
        <x-quiz.sidebar currentTab="quizzes"/>

        <section class="main-content w-full px-8">
            <x-quiz.header :hideHeader="false"/>

            <div class="my-6 px-2">

                <!-- Top Bar -->
                <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                    <h1 class="text-xl font-bold text-slate-800">My Quizzes</h1>
                    <a href="{{ route("to-create-quiz") }}">
                        <button class="flex items-center gap-2 px-4 py-2.5 bg-[#2979FF] text-white text-sm font-semibold rounded-xl hover:bg-[#1565C0] transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-white" viewBox="0 0 24 24">
                                <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4z"/>
                            </svg>
                            Create Quiz
                        </button>
                    </a>
                </div>

                <!-- Search + Tabs Row -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 mb-6">

                    <!-- Search -->
                    <div class="flex items-center gap-3 bg-white border border-gray-200 rounded-xl px-4 py-2.5 w-full sm:max-w-sm shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-gray-400 shrink-0" viewBox="0 0 192.904 192.904">
                            <path d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z"/>
                        </svg>
                        <input type="text" id="quizSearch" oninput="filterQuizzes()" placeholder="Search your quizzes..."
                            class="w-full text-sm text-slate-700 placeholder-slate-400 bg-transparent outline-none" />
                    </div>

                    <!-- Filter Tabs -->
                    <div class="flex gap-1 bg-white border border-gray-200 rounded-xl p-1 shadow-sm">
                        <button onclick="setFilter('all', this)"
                            class="filter-tab px-4 py-1.5 text-sm font-semibold rounded-lg bg-[#2979FF] text-white transition">
                            All
                        </button>
                        <button onclick="setFilter('active', this)"
                            class="filter-tab px-4 py-1.5 text-sm font-semibold rounded-lg text-slate-500 hover:bg-gray-100 transition">
                            Published
                        </button>
                        <button onclick="setFilter('draft', this)"
                            class="filter-tab px-4 py-1.5 text-sm font-semibold rounded-lg text-slate-500 hover:bg-gray-100 transition">
                            Drafts
                        </button>
                        <button onclick="setFilter('closed', this)"
                            class="filter-tab px-4 py-1.5 text-sm font-semibold rounded-lg text-slate-500 hover:bg-gray-100 transition">
                            Closed
                        </button>
                    </div>
                </div>

                <!-- Quiz Cards Grid -->
                <div id="quizGrid" class="grid lg:grid-cols-3 md:grid-cols-2 gap-4">
                    @foreach ($quizzes as $quiz)
                        @php
                            $questionCount = count($quiz->questions);
                        @endphp
                        @if ($quiz->status == "draft")
                            <div class="quiz-card bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 flex flex-col" data-status="draft" data-title="Pop Culture 2025">
                                <div class="h-1.5 bg-yellow-400"></div>
                                <div class="p-5 flex-1">
                                    <div class="flex items-start justify-between gap-2 mb-3">
                                        <h3 class="text-sm font-bold text-slate-800 leading-snug">{{ $quiz->title }}</h3>
                                        <span class="text-xs font-semibold px-2.5 py-1 bg-yellow-50 text-yellow-700 rounded-full whitespace-nowrap">Draft</span>
                                    </div>
                                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-400 mb-4">
                                        <span>{{ $questionCount }} questions</span>
                                    </div>
                                    <div class="flex divide-x divide-gray-100 border-t border-gray-100 pt-3 -mx-5 px-5">
                                        <div class="flex-1 text-center">
                                            <p class="text-base font-bold text-slate-400">—</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Players</p>
                                        </div>
                                        <div class="flex-1 text-center">
                                            <p class="text-base font-bold text-slate-400">—</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Avg score</p>
                                        </div>
                                        <div class="flex-1 text-center">
                                            <p class="text-base font-bold text-slate-400">—</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Highest score</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2 px-5 pb-4">
                                    <a class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-[#2979FF] text-white text-xs font-semibold rounded-xl hover:bg-[#1565C0] transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-white" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        Publish
                                    </a>
                                    <a href="{{ route('to-edit-quiz', ['id' => $quiz->id]) }}" class="flex items-center justify-center gap-1.5 px-3 py-2 border border-gray-200 text-slate-500 text-xs font-medium rounded-xl hover:bg-gray-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zm17.71-10.21a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        Edit
                                    </a>
                                    <input type="hidden" class="quiz-code" value="{{ $quiz->code }}">
                                    <form action="{{ route('delete-quiz', ['id' => $quiz->id]) }}"
                                        method="POST"
                                        class="delete-quiz-form inline">
                                        @csrf
                                        @method('DELETE')

                                        <button class="delete-quiz-btn flex items-center justify-center px-3 py-2 border border-gray-200 text-slate-400 text-xs rounded-xl hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M9 3v1H4v2h1v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1V4h-5V3zm0 2h6v1H9zm-2 2h10v12H7zm2 2v8h2V9zm4 0v8h2V9z"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        @if ($quiz->status == "published")            
                            <div class="quiz-card bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 flex flex-col" data-status="active" data-title="Tech Trivia 2026">
                                <div class="h-1.5 bg-[#2979FF]"></div>
                                <div class="p-5 flex-1">
                                    <div class="flex items-start justify-between gap-2 mb-3">
                                        <h3 class="text-sm font-bold text-slate-800 leading-snug">{{ $quiz->title }}</h3>
                                        <span class="text-xs font-semibold px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full whitespace-nowrap">Active</span>
                                    </div>
                                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-400 mb-4">
                                        <span>{{ $questionCount }} questions</span>
                                    </div>
                                    <div class="flex divide-x divide-gray-100 border-t border-gray-100 pt-3 -mx-5 px-5">
                                        <div class="flex-1 text-center">
                                            <p class="text-base font-bold text-slate-800">--</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Players</p>
                                        </div>
                                        <div class="flex-1 text-center">
                                            <p class="text-base font-bold text-slate-800">--</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Avg score</p>
                                        </div>
                                        <div class="flex-1 text-center">
                                            <p class="text-base font-bold text-slate-800">--</p>
                                            <p class="text-xs text-slate-400 mt-0.5">Highest score</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2 px-5 pb-4">
                                    <a href="{{ route('to-lobby', ['id' => $quiz->id]) }}" class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-[#2979FF] text-white text-xs font-semibold rounded-xl hover:bg-[#1565C0] transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-white" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        Host
                                    </a>
                                    <a href="{{ route('to-edit-quiz', ['id' => $quiz->id]) }}" class="flex items-center justify-center gap-1.5 px-3 py-2 border border-gray-200 text-slate-500 text-xs font-medium rounded-xl hover:bg-gray-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zm17.71-10.21a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                        Edit
                                    </a>
                                    <a class="getQuizCode flex items-center justify-center gap-1.5 px-3 py-2 border border-gray-200 text-slate-500 text-xs font-medium rounded-xl hover:bg-gray-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81a3 3 0 0 0 0-6 3 3 0 0 0-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9a3 3 0 0 0 0 6c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92s2.92-1.31 2.92-2.92c0-1.61-1.31-2.92-2.92-2.92z"/></svg>
                                        Code
                                    </a>
                                    <input type="hidden" class="quiz-code" value="{{ $quiz->code }}">
                                    <form action="{{ route('delete-quiz', ['id' => $quiz->id]) }}"
                                        method="POST"
                                        class="delete-quiz-form inline">
                                        @csrf
                                        @method('DELETE')

                                        <button class="delete-quiz-btn flex items-center justify-center px-3 py-2 border border-gray-200 text-slate-400 text-xs rounded-xl hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M9 3v1H4v2h1v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1V4h-5V3zm0 2h6v1H9zm-2 2h10v12H7zm2 2v8h2V9zm4 0v8h2V9z"/></svg>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        @endif
                    @endforeach
                    <!-- Card -->
                    {{-- <div class="quiz-card bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 flex flex-col" data-status="active" data-title="World Capitals Quiz">
                        <div class="h-1.5 bg-[#2979FF]"></div>
                        <div class="p-5 flex-1">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <h3 class="text-sm font-bold text-slate-800 leading-snug">World Capitals Quiz</h3>
                                <span class="text-xs font-semibold px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full whitespace-nowrap">Active</span>
                            </div>
                            <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-400 mb-4">
                                <span>15 questions</span>
                                <span>30 sec/q</span>
                                <span>Geography</span>
                            </div>
                            <div class="flex divide-x divide-gray-100 border-t border-gray-100 pt-3 -mx-5 px-5">
                                <div class="flex-1 text-center">
                                    <p class="text-base font-bold text-slate-800">42</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Players</p>
                                </div>
                                <div class="flex-1 text-center">
                                    <p class="text-base font-bold text-slate-800">81%</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Avg score</p>
                                </div>
                                <div class="flex-1 text-center">
                                    <p class="text-base font-bold text-slate-800">91%</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Completion</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 px-5 pb-4">
                            <button class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-[#2979FF] text-white text-xs font-semibold rounded-xl hover:bg-[#1565C0] transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-white" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                Host
                            </button>
                            <button class="flex items-center justify-center gap-1.5 px-3 py-2 border border-gray-200 text-slate-500 text-xs font-medium rounded-xl hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zm17.71-10.21a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                Edit
                            </button>
                            <button class="flex items-center justify-center gap-1.5 px-3 py-2 border border-gray-200 text-slate-500 text-xs font-medium rounded-xl hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81a3 3 0 0 0 0-6 3 3 0 0 0-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9a3 3 0 0 0 0 6c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92s2.92-1.31 2.92-2.92c0-1.61-1.31-2.92-2.92-2.92z"/></svg>
                                Share
                            </button>
                            <button class="flex items-center justify-center px-3 py-2 border border-gray-200 text-slate-400 text-xs rounded-xl hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M9 3v1H4v2h1v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1V4h-5V3zm0 2h6v1H9zm-2 2h10v12H7zm2 2v8h2V9zm4 0v8h2V9z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="quiz-card bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 flex flex-col" data-status="active" data-title="Tech Trivia 2026">
                        <div class="h-1.5 bg-[#2979FF]"></div>
                        <div class="p-5 flex-1">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <h3 class="text-sm font-bold text-slate-800 leading-snug">Tech Trivia 2026</h3>
                                <span class="text-xs font-semibold px-2.5 py-1 bg-blue-50 text-blue-700 rounded-full whitespace-nowrap">Active</span>
                            </div>
                            <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-400 mb-4">
                                <span>20 questions</span>
                                <span>45 sec/q</span>
                                <span>Technology</span>
                            </div>
                            <div class="flex divide-x divide-gray-100 border-t border-gray-100 pt-3 -mx-5 px-5">
                                <div class="flex-1 text-center">
                                    <p class="text-base font-bold text-slate-800">18</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Players</p>
                                </div>
                                <div class="flex-1 text-center">
                                    <p class="text-base font-bold text-slate-800">74%</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Avg score</p>
                                </div>
                                <div class="flex-1 text-center">
                                    <p class="text-base font-bold text-slate-800">83%</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Completion</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 px-5 pb-4">
                            <button class="flex-1 flex items-center justify-center gap-1.5 py-2 bg-[#2979FF] text-white text-xs font-semibold rounded-xl hover:bg-[#1565C0] transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-white" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                Host
                            </button>
                            <button class="flex items-center justify-center gap-1.5 px-3 py-2 border border-gray-200 text-slate-500 text-xs font-medium rounded-xl hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zm17.71-10.21a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                Edit
                            </button>
                            <button class="flex items-center justify-center gap-1.5 px-3 py-2 border border-gray-200 text-slate-500 text-xs font-medium rounded-xl hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81a3 3 0 0 0 0-6 3 3 0 0 0-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9a3 3 0 0 0 0 6c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92s2.92-1.31 2.92-2.92c0-1.61-1.31-2.92-2.92-2.92z"/></svg>
                                Share
                            </button>
                            <button class="flex items-center justify-center px-3 py-2 border border-gray-200 text-slate-400 text-xs rounded-xl hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M9 3v1H4v2h1v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1V4h-5V3zm0 2h6v1H9zm-2 2h10v12H7zm2 2v8h2V9zm4 0v8h2V9z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="quiz-card bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100 flex flex-col" data-status="closed" data-title="PH History Basics">
                        <div class="h-1.5 bg-slate-300"></div>
                        <div class="p-5 flex-1">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <h3 class="text-sm font-bold text-slate-800 leading-snug">PH History Basics</h3>
                                <span class="text-xs font-semibold px-2.5 py-1 bg-slate-100 text-slate-500 rounded-full whitespace-nowrap">Closed</span>
                            </div>
                            <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-400 mb-4">
                                <span>10 questions</span>
                                <span>20 sec/q</span>
                                <span>History</span>
                            </div>
                            <div class="flex divide-x divide-gray-100 border-t border-gray-100 pt-3 -mx-5 px-5">
                                <div class="flex-1 text-center">
                                    <p class="text-base font-bold text-slate-800">91</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Players</p>
                                </div>
                                <div class="flex-1 text-center">
                                    <p class="text-base font-bold text-slate-800">88%</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Avg score</p>
                                </div>
                                <div class="flex-1 text-center">
                                    <p class="text-base font-bold text-slate-800">95%</p>
                                    <p class="text-xs text-slate-400 mt-0.5">Completion</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-2 px-5 pb-4">
                            <button class="flex-1 flex items-center justify-center gap-1.5 py-2 border border-gray-200 text-slate-600 text-xs font-semibold rounded-xl hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M17 12h-5v5h5v-5zM16 1v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5c0-1.1-.89-2-2-2h-1V1h-2zm3 18H5V8h14v11z"/></svg>
                                Results
                            </button>
                            <button class="flex items-center justify-center gap-1.5 px-3 py-2 border border-gray-200 text-slate-500 text-xs font-medium rounded-xl hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M16 1H4a2 2 0 0 0-2 2v14h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/></svg>
                                Duplicate
                            </button>
                            <button class="flex items-center justify-center px-3 py-2 border border-gray-200 text-slate-400 text-xs rounded-xl hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M9 3v1H4v2h1v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1V4h-5V3zm0 2h6v1H9zm-2 2h10v12H7zm2 2v8h2V9zm4 0v8h2V9z"/></svg>
                            </button>
                        </div>
                    </div> --}}

                </div>

                <!-- Empty State (hidden by default) -->
                <div id="emptyState" class="hidden flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 fill-[#2979FF]" viewBox="0 0 24 24">
                            <path d="M11 18h2v-2h-2v2zm1-16A10 10 0 1 0 12 22 10 10 0 0 0 12 2zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm0-14a4 4 0 0 0-4 4h2a2 2 0 0 1 4 0c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5a4 4 0 0 0-4-4z"/>
                        </svg>
                    </div>
                    <p class="text-slate-700 font-semibold text-base">No quizzes found</p>
                    <p class="text-slate-400 text-sm mt-1">Try a different search or filter.</p>
                </div>

            </div>
        </section>
    </div>
</div>

@vite('resources/js/quiz/quiz-list.js');

<script>
    let currentFilter = 'all';

    function setFilter(status, btn) {
        currentFilter = status;
        document.querySelectorAll('.filter-tab').forEach(b => {
            b.classList.remove('bg-[#2979FF]', 'text-white');
            b.classList.add('text-slate-500', 'hover:bg-gray-100');
        });
        btn.classList.add('bg-[#2979FF]', 'text-white');
        btn.classList.remove('text-slate-500', 'hover:bg-gray-100');
        applyFilters();
    }

    function filterQuizzes() {
        applyFilters();
    }

    function applyFilters() {
        const search = document.getElementById('quizSearch').value.toLowerCase();
        const cards = document.querySelectorAll('.quiz-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const status = card.dataset.status;
            const title = card.dataset.title.toLowerCase();
            const matchesFilter = currentFilter === 'all' || status === currentFilter;
            const matchesSearch = title.includes(search);

            if (matchesFilter && matchesSearch) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        document.getElementById('emptyState').classList.toggle('hidden', visibleCount > 0);
    }
</script>

</x-layout>