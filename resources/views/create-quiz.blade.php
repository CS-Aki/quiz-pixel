<x-layout>
<div class="relative bg-[#f7f6f9] h-full min-h-screen">
    <div class="flex items-start">
        <x-quiz.sidebar/>

        <section class="main-content w-full px-8">
            <x-quiz.header :hideHeader="true"/>

            <div class="my-6 px-2">

                <!-- Page Title + Save -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-xl font-bold text-slate-800">Create a Quiz</h1>
                        <p class="text-sm text-slate-400 mt-0.5">Build your quiz content and configure settings.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" id="saveDraftBtn"
                            class="px-4 py-2 text-sm font-medium text-slate-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                            Save as Draft
                        </button>
                        <button type="button"
                            class="px-4 py-2 text-sm font-semibold text-white bg-[#2979FF] rounded-xl hover:bg-[#1565C0] transition shadow-sm">
                            Publish Quiz
                        </button>
                    </div>
                </div>

                <!-- Quiz Title Input -->
                <div class="bg-white rounded-2xl shadow-sm px-6 py-5 mb-6">
                    <input type="text" id="quizTitle" placeholder="Enter quiz title..."
                        class="w-full text-xl font-bold text-slate-800 placeholder-slate-300 outline-none border-b-2 border-transparent focus:border-[#2979FF] pb-2 transition" />
                    <input type="text" id="quizDescription" placeholder="Add a short description (optional)..."
                        class="w-full text-sm text-slate-500 placeholder-slate-300 outline-none mt-3" />
                </div>

                <!-- Tabs -->
                <div class="flex gap-1 bg-white rounded-xl shadow-sm p-1 mb-6 w-fit">
                    <button id="tabContentBtn" 
                        class="tab-btn px-5 py-2 text-sm font-semibold rounded-lg bg-[#2979FF] text-white transition">
                        Quiz Content
                    </button>
                    <button id="tabSettingsBtn"
                        class="tab-btn px-5 py-2 text-sm font-semibold rounded-lg text-slate-500 hover:bg-gray-100 transition">
                        Quiz Settings
                    </button>
                </div>

                <!-- ── TAB: CONTENT ── -->
                <div id="tabContent">

                    <!-- Questions List -->
                    <div id="questionsList" class="space-y-4">

                        <!-- Question Card Template (first one pre-loaded) -->
                        <div class="question-card bg-white rounded-2xl shadow-sm overflow-hidden" data-index="1">
                            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                                <span class="text-xs font-bold text-[#2979FF] uppercase tracking-widest">Question 1</span>
                                <div class="flex items-center gap-3">
                                    <!-- Per-question time override -->
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-slate-400" viewBox="0 0 510 510">
                                            <g fill-opacity=".9"><path d="M255 0C114.75 0 0 114.75 0 255s114.75 255 255 255 255-114.75 255-255S395.25 0 255 0zm0 459c-112.2 0-204-91.8-204-204S142.8 51 255 51s204 91.8 204 204-91.8 204-204 204z"/><path d="M267.75 127.5H229.5v153l132.6 81.6 20.4-33.15-114.75-68.85z"/></g>
                                        </svg>
                                        <input type="number" placeholder="30" min="5" max="300"
                                            class="w-14 text-xs border border-gray-200 rounded-lg px-2 py-1 outline-none focus:ring-2 focus:ring-[#2979FF] text-center" />
                                        <span>sec</span>
                                    </div>
                                    <!-- Per-question points override -->
                                    <div class="flex items-center gap-2 text-xs text-slate-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-slate-400" viewBox="0 0 24 24">
                                            <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm1 14.93V18h-2v-1.07A4.002 4.002 0 0 1 8 13h2a2 2 0 1 0 2-2c-2.21 0-4-1.79-4-4a4.002 4.002 0 0 1 3-3.87V2h2v1.13A4.002 4.002 0 0 1 16 7h-2a2 2 0 1 0-2 2c2.21 0 4 1.79 4 4a4.002 4.002 0 0 1-3 3.93z"/>
                                        </svg>
                                        <input type="number" placeholder="10" min="0"
                                            class="w-14 text-xs border border-gray-200 rounded-lg px-2 py-1 outline-none focus:ring-2 focus:ring-[#2979FF] text-center" />
                                        <span>pts</span>
                                    </div>
                                    <!-- Delete -->
                                    <button class="delete-question-btn text-slate-300 hover:text-red-400 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                            <path d="M9 3v1H4v2h1v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V6h1V4h-5V3zm0 2h6v1H9zm-2 2h10v12H7zm2 2v8h2V9zm4 0v8h2V9z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="question-container px-6 py-5">
                                <!-- Question Text -->
                                <input type="text" placeholder="Type your question here..."
                                    class="question-text w-full text-sm font-medium text-slate-800 placeholder-slate-300 outline-none border-b border-gray-100 focus:border-[#2979FF] pb-2 mb-5 transition" />

                                <!-- Answer Choices -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 choices-container">
                                    <!-- Choice A -->
                                    <div class="flex items-center gap-3 p-3 border-2 border-gray-100 rounded-xl hover:border-[#2979FF]/30 transition group">
                                        <button type="button" 
                                            class="correct-btn w-6 h-6 rounded-full border-2 border-gray-300 flex-shrink-0 flex items-center justify-center transition hover:border-green-400">
                                        </button>
                                        <input type="text" placeholder="Choice A" data-choice="A"
                                            class="choice-item flex-1 text-sm text-slate-700 placeholder-slate-300 outline-none bg-transparent" />
                                    </div>
                                    <!-- Choice B -->
                                    <div class="flex items-center gap-3 p-3 border-2 border-gray-100 rounded-xl hover:border-[#2979FF]/30 transition group">
                                        <button type="button"
                                            class="correct-btn w-6 h-6 rounded-full border-2 border-gray-300 flex-shrink-0 flex items-center justify-center transition hover:border-green-400">
                                        </button>
                                        <input type="text" placeholder="Choice B" data-choice="B"
                                            class="choice-item flex-1 text-sm text-slate-700 placeholder-slate-300 outline-none bg-transparent" />
                                    </div>
                                    <!-- Choice C -->
                                    <div class="flex items-center gap-3 p-3 border-2 border-gray-100 rounded-xl hover:border-[#2979FF]/30 transition group">
                                        <button type="button" 
                                            class="correct-btn w-6 h-6 rounded-full border-2 border-gray-300 flex-shrink-0 flex items-center justify-center transition hover:border-green-400">
                                        </button>
                                        <input type="text" placeholder="Choice C" data-choice="C"
                                            class="choice-item flex-1 text-sm text-slate-700 placeholder-slate-300 outline-none bg-transparent" />
                                    </div>
                                    <!-- Choice D -->
                                    <div class="flex items-center gap-3 p-3 border-2 border-gray-100 rounded-xl hover:border-[#2979FF]/30 transition group">
                                        <button type="button" 
                                            class="correct-btn w-6 h-6 rounded-full border-2 border-gray-300 flex-shrink-0 flex items-center justify-center transition hover:border-green-400">
                                        </button>
                                        <input type="text" placeholder="Choice D" data-choice="D"
                                            class="choice-item flex-1 text-sm text-slate-700 placeholder-slate-300 outline-none bg-transparent" />
                                    </div>
                                </div>

                                <p class="text-xs text-slate-400 mt-3">
                                    <span class="text-green-500 font-semibold">●</span> Click the circle next to the correct answer
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Add Question Button -->
                    <button type="button" id="addQuestionBtn"
                        class="mt-4 w-full py-4 border-2 border-dashed border-[#2979FF]/40 rounded-2xl text-[#2979FF] text-sm font-semibold hover:bg-[#2979FF]/5 hover:border-[#2979FF] transition flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm5 11h-4v4h-2v-4H7v-2h4V7h2v4h4z"/>
                        </svg>
                        Add Question
                    </button>
                </div>

                <!-- ── TAB: SETTINGS ── -->
                <div id="tabSettings" class="hidden space-y-4">

                    <!-- General Settings -->
                    <div class="bg-white rounded-2xl shadow-sm px-6 py-6">
                        <h3 class="text-sm font-bold text-slate-800 mb-5">General Settings</h3>

                        <div class="space-y-5">
                            <!-- Category -->
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Category</label>
                                    <select class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-700 outline-none focus:ring-2 focus:ring-[#2979FF] transition">
                                        <option value="">Select category</option>
                                        <option>General Knowledge</option>
                                        <option>Science & Nature</option>
                                        <option>History</option>
                                        <option>Technology</option>
                                        <option>Mathematics</option>
                                        <option>Pop Culture</option>
                                        <option>Geography</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Difficulty</label>
                                    <select class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm text-slate-700 outline-none focus:ring-2 focus:ring-[#2979FF] transition">
                                        <option>Easy</option>
                                        <option selected>Medium</option>
                                        <option>Hard</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Visibility -->
                            <div>
                                <label class="block text-xs font-semibold text-slate-500 mb-1.5 uppercase tracking-wide">Visibility</label>
                                <div class="flex gap-3">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="visibility" value="public" checked class="accent-[#2979FF]" />
                                        <span class="text-sm text-slate-700">Public</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="visibility" value="private" class="accent-[#2979FF]" />
                                        <span class="text-sm text-slate-700">Private (invite only)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Time Settings -->
                    <div class="bg-white rounded-2xl shadow-sm px-6 py-6">
                        <h3 class="text-sm font-bold text-slate-800 mb-1">Time Settings</h3>
                        <p class="text-xs text-slate-400 mb-5">Set a default time per question. You can override this per question in the Content tab.</p>

                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <div>
                                <p class="text-sm font-medium text-slate-700">Enable Timer</p>
                                <p class="text-xs text-slate-400">Count down per question</p>
                            </div>
                            <button type="button" onclick="toggleSwitch(this)" data-state="on"
                                class="toggle-switch w-11 h-6 rounded-full bg-[#2979FF] relative transition-colors duration-300 flex-shrink-0">
                                <span class="absolute top-1 left-5 w-4 h-4 bg-white rounded-full shadow transition-all duration-300"></span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between py-3">
                            <div>
                                <p class="text-sm font-medium text-slate-700">Default Time per Question</p>
                                <p class="text-xs text-slate-400">Applied to all questions unless overridden</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="number" value="30" min="5" max="300"
                                    class="w-20 text-center px-3 py-2 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#2979FF]" />
                                <span class="text-sm text-slate-500">seconds</span>
                            </div>
                        </div>
                    </div>

                    <!-- Scoring Settings -->
                    <div class="bg-white rounded-2xl shadow-sm px-6 py-6">
                        <h3 class="text-sm font-bold text-slate-800 mb-1">Scoring Settings</h3>
                        <p class="text-xs text-slate-400 mb-5">Set default points per question. You can override this per question in the Content tab.</p>

                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <div>
                                <p class="text-sm font-medium text-slate-700">Default Points per Question</p>
                                <p class="text-xs text-slate-400">Applied to all questions unless overridden</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="number" value="10" min="0"
                                    class="w-20 text-center px-3 py-2 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#2979FF]" />
                                <span class="text-sm text-slate-500">points</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <div>
                                <p class="text-sm font-medium text-slate-700">Bonus for Speed</p>
                                <p class="text-xs text-slate-400">Award extra points for faster answers</p>
                            </div>
                            <button type="button" onclick="toggleSwitch(this)" data-state="off"
                                class="toggle-switch w-11 h-6 rounded-full bg-gray-200 relative transition-colors duration-300 flex-shrink-0">
                                <span class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-all duration-300"></span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between py-3">
                            <div>
                                <p class="text-sm font-medium text-slate-700">Show Score After Each Question</p>
                                <p class="text-xs text-slate-400">Players see their score in real time</p>
                            </div>
                            <button type="button" onclick="toggleSwitch(this)" data-state="on"
                                class="toggle-switch w-11 h-6 rounded-full bg-[#2979FF] relative transition-colors duration-300 flex-shrink-0">
                                <span class="absolute top-1 left-5 w-4 h-4 bg-white rounded-full shadow transition-all duration-300"></span>
                            </button>
                        </div>
                    </div>

                    <!-- Lobby Settings -->
                    <div class="bg-white rounded-2xl shadow-sm px-6 py-6">
                        <h3 class="text-sm font-bold text-slate-800 mb-5">Lobby & Access</h3>

                        <div class="flex items-center justify-between py-3 border-b border-gray-50">
                            <div>
                                <p class="text-sm font-medium text-slate-700">Require Login to Join</p>
                                <p class="text-xs text-slate-400">Players must have an account</p>
                            </div>
                            <button type="button" onclick="toggleSwitch(this)" data-state="off"
                                class="toggle-switch w-11 h-6 rounded-full bg-gray-200 relative transition-colors duration-300 flex-shrink-0">
                                <span class="absolute top-1 left-1 w-4 h-4 bg-white rounded-full shadow transition-all duration-300"></span>
                            </button>
                        </div>

                        <div class="flex items-center justify-between py-3">
                            <div>
                                <p class="text-sm font-medium text-slate-700">Max Players</p>
                                <p class="text-xs text-slate-400">Leave blank for unlimited</p>
                            </div>
                            <input type="number" placeholder="∞" min="1"
                                class="w-20 text-center px-3 py-2 border border-gray-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#2979FF]" />
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>
</div>

@vite('resources/js/quiz/create-quiz.js')
@vite('resources/js/user/logout.js')

</x-layout>