<x-layout>
<div class="relative bg-[#f7f6f9] h-full min-h-screen">
    <div class="flex items-start">

        <x-quiz.sidebar/>

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
            <div class="my-8 px-2 space-y-8">

                <!-- Welcome Banner + Quick Actions -->
                <div class="bg-gradient-to-r from-[#2979FF] to-[#29B6F6] rounded-2xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-white text-xl font-bold">Welcome back, {{ Auth::user()->first_name }}! 👋</h1>
                        <p class="text-blue-100 text-sm mt-1">What would you like to do today?</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button type="button"
                            class="flex items-center gap-2 px-4 py-2.5 bg-white text-[#2979FF] text-sm font-semibold rounded-xl hover:bg-blue-50 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-[#2979FF]" viewBox="0 0 24 24">
                                <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm1-11H11v3H8v2h3v3h2v-3h3v-2h-3z"/>
                            </svg>
                            Join a Quiz Room
                        </button>
                        <a href="{{ route("to-create-quiz") }}"
                            class="flex items-center gap-2 px-4 py-2.5 bg-[#0D47A1] text-white text-sm font-semibold rounded-xl hover:bg-[#1565C0] transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-white" viewBox="0 0 24 24">
                                <path d="M18 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-5 13h-2v-2H9v-2h2V9h2v2h2v2h-2z"/>
                            </svg>
                            Create a Quiz
                        </a>
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Quizzes Taken</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">24</p>
                        <p class="text-xs text-blue-500 mt-1">+3 this week</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Quizzes Created</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">8</p>
                        <p class="text-xs text-blue-500 mt-1">+1 this week</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Avg. Score</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">82%</p>
                        <p class="text-xs text-blue-500 mt-1">↑ 4% vs last week</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Best Rank</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">#2</p>
                        <p class="text-xs text-slate-400 mt-1">All time</p>
                    </div>
                </div>

                <!-- Bottom Two Columns -->
                <div class="grid lg:grid-cols-2 gap-6">

                    <!-- Quiz History -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                            <h2 class="text-sm font-bold text-slate-800">Quiz History</h2>
                            <a href="javascript:void(0)" class="text-xs text-[#2979FF] font-medium hover:underline">View all</a>
                        </div>
                        <div class="divide-y divide-gray-50">
                            <!-- Row -->
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs">GK</div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">General Knowledge</p>
                                        <p class="text-xs text-slate-400">April 3, 2026</p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold px-3 py-1 bg-green-100 text-green-700 rounded-full">90%</span>
                            </div>
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold text-xs">SC</div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">Science & Nature</p>
                                        <p class="text-xs text-slate-400">April 1, 2026</p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full">74%</span>
                            </div>
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold text-xs">HX</div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">History Trivia</p>
                                        <p class="text-xs text-slate-400">March 29, 2026</p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold px-3 py-1 bg-green-100 text-green-700 rounded-full">88%</span>
                            </div>
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold text-xs">MT</div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-800">Math Challenge</p>
                                        <p class="text-xs text-slate-400">March 27, 2026</p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold px-3 py-1 bg-red-100 text-red-700 rounded-full">58%</span>
                            </div>
                        </div>
                    </div>

                    <!-- My Created Quizzes -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                            <h2 class="text-sm font-bold text-slate-800">My Created Quizzes</h2>
                            <a href="javascript:void(0)" class="text-xs text-[#2979FF] font-medium hover:underline">View all</a>
                        </div>
                        <div class="divide-y divide-gray-50">
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">World Capitals Quiz</p>
                                    <p class="text-xs text-slate-400">15 questions · 42 players</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-semibold px-3 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                                    <button class="text-slate-400 hover:text-[#2979FF] transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zm17.71-10.21a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">Tech Trivia 2026</p>
                                    <p class="text-xs text-slate-400">20 questions · 18 players</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-semibold px-3 py-1 bg-green-100 text-green-700 rounded-full">Active</span>
                                    <button class="text-slate-400 hover:text-[#2979FF] transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zm17.71-10.21a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">PH History Basics</p>
                                    <p class="text-xs text-slate-400">10 questions · 91 players</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-semibold px-3 py-1 bg-slate-100 text-slate-500 rounded-full">Closed</span>
                                    <button class="text-slate-400 hover:text-[#2979FF] transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zm17.71-10.21a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                                <div>
                                    <p class="text-sm font-medium text-slate-800">Pop Culture 2025</p>
                                    <p class="text-xs text-slate-400">12 questions · 5 players</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-semibold px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full">Draft</span>
                                    <button class="text-slate-400 hover:text-[#2979FF] transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M3 17.25V21h3.75l11-11.03-3.75-3.75L3 17.25zm17.71-10.21a1 1 0 0 0 0-1.41l-2.34-2.34a1 1 0 0 0-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
</div>

@if(!Auth::user()->password)
    <div id="setPasswordModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
            onclick="document.getElementById('setPasswordModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-8 z-10">
            <button onclick="document.getElementById('setPasswordModal').classList.add('hidden')"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <div class="mb-6">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-green-600" viewBox="0 0 24 24">
                        <path d="M12 1C8.676 1 6 3.676 6 7v1H4v15h16V8h-2V7c0-3.324-2.676-6-6-6zm0 2c2.276 0 4 1.724 4 4v1H8V7c0-2.276 1.724-4 4-4zm0 9a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-800">Set Your Password</h2>
                <p class="text-sm text-slate-500 mt-1">Create a password so you can also log in with your email.</p>
            </div>
            <form class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">New Password</label>
                    <input type="password" id="modalPassword" placeholder="Enter new password"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-green-500 transition" />
                    <p id="modalPasswordError" class="text-red-500 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Confirm Password</label>
                    <input type="password" id="modalPasswordConfirm" placeholder="Confirm your password"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-green-500 transition" />
                    <p id="modalPasswordConfirmError" class="text-red-500 text-xs mt-1"></p>
                </div>
                <button type="button" id="savePasswordBtn"
                    class="w-full py-2.5 bg-[#2979FF] hover:bg-[#1565C0] text-white text-sm font-semibold rounded-lg transition duration-300 mt-2">
                    Save Password
                </button>
            </form>
        </div>
    </div>
@endif

@vite('resources/js/user/logout.js')

</x-layout>