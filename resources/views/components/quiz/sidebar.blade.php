<nav id="sidebar" class="lg:min-w-[270px] w-max max-lg:min-w-8">
    <div id="sidebar-collapse-menu"
        class="bg-white shadow-lg h-screen fixed top-0 left-0 overflow-auto z-[99] lg:min-w-[250px] lg:w-max max-lg:w-0 max-lg:invisible transition-all duration-500">
        <div class="pt-8 pb-2 px-6 sticky top-0 bg-white min-h-[80px] z-[100]">
            <a href="/" class="outline-0">
                <img src="{{ asset('img/logo.png') }}" alt="logo" class="w-[170px]" />
            </a>
        </div>

        <div class="py-6 px-6">
            <ul class="space-y-2">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route("to-dashboard") }}"
                        class="menu-item text-green-800 text-[15px] font-medium flex items-center cursor-pointer bg-[#DBEAFE] hover:bg-[#DBEAFE] rounded-md px-3 py-3 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-3" viewBox="0 0 24 24">
                            <path d="M19.56 23.253H4.44a4.051 4.051 0 0 1-4.05-4.05v-9.115c0-1.317.648-2.56 1.728-3.315l7.56-5.292a4.062 4.062 0 0 1 4.644 0l7.56 5.292a4.056 4.056 0 0 1 1.728 3.315v9.115a4.051 4.051 0 0 1-4.05 4.05zM12 2.366a2.45 2.45 0 0 0-1.393.443l-7.56 5.292a2.433 2.433 0 0 0-1.037 1.987v9.115c0 1.34 1.09 2.43 2.43 2.43h15.12c1.34 0 2.43-1.09 2.43-2.43v-9.115c0-.788-.389-1.533-1.037-1.987l-7.56-5.292A2.438 2.438 0 0 0 12 2.377z"/>
                            <path d="M16.32 23.253H7.68a.816.816 0 0 1-.81-.81v-5.4c0-2.83 2.3-5.13 5.13-5.13s5.13 2.3 5.13 5.13v5.4c0 .443-.367.81-.81.81zm-7.83-1.62h7.02v-4.59c0-1.933-1.577-3.51-3.51-3.51s-3.51 1.577-3.51 3.51z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- My Quizzes -->
                <li>
                    <a href="javascript:void(0)"
                        class="menu-item text-slate-800 text-[15px] font-medium flex items-center cursor-pointer hover:bg-[#DBEAFE] rounded-md px-3 py-3 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-3" viewBox="0 0 64 64">
                            <path d="M16.4 29.594a2.08 2.08 0 0 1 2.08-2.08h31.2a2.08 2.08 0 1 1 0 4.16h-31.2a2.08 2.08 0 0 1-2.08-2.08zm0 12.48a2.08 2.08 0 0 1 2.08-2.08h12.48a2.08 2.08 0 1 1 0 4.16H18.48a2.08 2.08 0 0 1-2.08-2.08z"/>
                            <path fill-rule="evenodd" d="M.8 18.154c0-8.041 6.519-14.56 14.56-14.56v-1.04a2.08 2.08 0 1 1 4.16 0v1.04h10.4v-1.04a2.08 2.08 0 1 1 4.16 0v1.04h10.4v-1.04a2.08 2.08 0 1 1 4.16 0v1.04c8.041 0 14.56 6.519 14.56 14.56v30.16c0 8.041-6.519 14.56-14.56 14.56H15.36C7.319 62.874.8 56.355.8 48.314zm33.28-10.4h10.4v1.04a2.08 2.08 0 1 0 4.16 0v-1.04c5.744 0 10.4 4.656 10.4 10.4v30.16c0 5.744-4.656 10.4-10.4 10.4H15.36c-5.744 0-10.4-4.656-10.4-10.4v-30.16c0-5.744 4.656-10.4 10.4-10.4v1.04a2.08 2.08 0 1 0 4.16 0v-1.04h10.4v1.04a2.08 2.08 0 1 0 4.16 0z" clip-rule="evenodd"/>
                        </svg>
                        <span>My Quizzes</span>
                    </a>
                </li>

                <!-- Quiz History -->
                <li>
                    <a href="javascript:void(0)"
                        class="menu-item text-slate-800 text-[15px] font-medium flex items-center cursor-pointer hover:bg-[#DBEAFE] rounded-md px-3 py-3 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-3" viewBox="0 0 510 510">
                            <g fill-opacity=".9">
                                <path d="M255 0C114.75 0 0 114.75 0 255s114.75 255 255 255 255-114.75 255-255S395.25 0 255 0zm0 459c-112.2 0-204-91.8-204-204S142.8 51 255 51s204 91.8 204 204-91.8 204-204 204z"/>
                                <path d="M267.75 127.5H229.5v153l132.6 81.6 20.4-33.15-114.75-68.85z"/>
                            </g>
                        </svg>
                        <span>Quiz History</span>
                    </a>
                </li>

                <!-- Leaderboard -->
                <li>
                    <a href="javascript:void(0)"
                        class="menu-item text-slate-800 text-[15px] font-medium flex items-center cursor-pointer hover:bg-[#DBEAFE] rounded-md px-3 py-3 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-3" viewBox="0 0 60.123 60.123">
                            <path d="M57.124 51.893H16.92a3 3 0 1 1 0-6h40.203a3 3 0 0 1 .001 6zm0-18.831H16.92a3 3 0 1 1 0-6h40.203a3 3 0 0 1 .001 6zm0-18.831H16.92a3 3 0 1 1 0-6h40.203a3 3 0 0 1 .001 6z"/>
                            <circle cx="4.029" cy="11.463" r="4.029"/>
                            <circle cx="4.029" cy="30.062" r="4.029"/>
                            <circle cx="4.029" cy="48.661" r="4.029"/>
                        </svg>
                        <span>Leaderboard</span>
                    </a>
                </li>

                <!-- Settings -->
                <li>
                    <a href="javascript:void(0)"
                        class="menu-item text-slate-800 text-[15px] font-medium flex items-center cursor-pointer hover:bg-[#DBEAFE] rounded-md px-3 py-3 transition-all duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-3" viewBox="0 0 64 64">
                            <path d="M61.4 29.9h-6.542a9.377 9.377 0 0 0-18.28 0H2.6a2.1 2.1 0 0 0 0 4.2h33.978a9.377 9.377 0 0 0 18.28 0H61.4a2.1 2.1 0 0 0 0-4.2Zm-15.687 7.287A5.187 5.187 0 1 1 50.9 32a5.187 5.187 0 0 1-5.187 5.187ZM2.6 13.1h5.691a9.377 9.377 0 0 0 18.28 0H61.4a2.1 2.1 0 0 0 0-4.2H26.571a9.377 9.377 0 0 0-18.28 0H2.6a2.1 2.1 0 0 0 0 4.2Zm14.837-7.287A5.187 5.187 0 0 1 22.613 11a5.187 5.187 0 0 1-10.364 0 5.187 5.187 0 0 1 5.187-5.187ZM61.4 50.9H35.895a9.377 9.377 0 0 0-18.28 0H2.6a2.1 2.1 0 0 0 0 4.2h15.015a9.377 9.377 0 0 0 18.28 0H61.4a2.1 2.1 0 0 0 0-4.2Zm-34.65 7.287A5.187 5.187 0 1 1 31.937 53a5.187 5.187 0 0 1-5.187 5.187Z"/>
                        </svg>
                        <span>Settings</span>
                    </a>
                </li>
            </ul>

            <div class="mt-8">
                <div class="bg-[#2979FF] p-4 rounded-md shadow-md max-w-[196px]">
                    <p class="text-white text-sm leading-relaxed">Ready to challenge others? Create your first quiz now!</p>
                    <button type="button"
                        class="py-2 px-4 bg-white hover:bg-gray-100 text-slate-800 text-sm border-0 outline-0 rounded-md cursor-pointer mt-4">
                        Create Quiz
                    </button>
                </div>
            </div>
        </div>
    </div>
</nav>