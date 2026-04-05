<x-layout>
<div class="relative bg-[#f7f6f9] h-full min-h-screen">
    <div class="flex items-start">
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
                            <a href="javascript:void(0)"
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

        <button id="toggle-sidebar"
            class="lg:hidden w-8 h-8 z-[100] fixed top-[36px] left-[10px] cursor-pointer bg-[#007bff] flex items-center justify-center rounded-full outline-0 transition-all duration-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" class="w-3 h-3" viewBox="0 0 55.752 55.752">
                <path d="M43.006 23.916a5.36 5.36 0 0 0-.912-.727L20.485 1.581a5.4 5.4 0 0 0-7.637 7.638l18.611 18.609-18.705 18.707a5.398 5.398 0 1 0 7.634 7.635l21.706-21.703a5.35 5.35 0 0 0 .912-.727 5.373 5.373 0 0 0 1.574-3.912 5.363 5.363 0 0 0-1.574-3.912z"/>
            </svg>
        </button>

        <section class="main-content w-full px-8">
            <!-- Header -->
            <header class="z-50 bg-[#f7f6f9] sticky top-0 pt-8">
                <div class="flex flex-wrap items-center w-full relative tracking-wide">
                    <div class="flex items-center gap-y-6 max-sm:flex-col z-50 w-full pb-2">
                        <div class="flex items-center gap-4 w-full px-6 bg-white shadow-sm min-h-[48px] sm:mr-20 rounded-md outline-0 border-0">
                            <input type='text' placeholder='Search quizzes...' class="w-full text-sm bg-transparent rounded-sm outline-0" />
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904" class="w-4 cursor-pointer fill-gray-400 ml-auto">
                                <path d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z"/>
                            </svg>
                        </div>

                        <div class="flex items-center justify-end gap-6 ml-auto">
                            <div class="w-1 h-10 border-l border-gray-400"></div>

                            <!-- Profile Dropdown -->
                            <div class="dropdown-menu relative flex shrink-0 group">
                                <div class="flex items-center gap-4">
                                    <p class="text-slate-500 text-sm">Hi, {{ Auth::user()->first_name }}</p>
                                    <img src="{{ Auth::user()->avatar ?? 'https://readymadeui.com/team-1.webp' }}"
                                        alt="profile-pic"
                                        class="w-[38px] h-[38px] rounded-full border-2 border-gray-300 cursor-pointer object-cover" />
                                </div>

                                <div class="dropdown-content hidden group-hover:block shadow-md p-2 bg-white rounded-md absolute top-[48px] right-0 w-56">
                                    <div class="w-full space-y-2">
                                        <!-- User Info -->
                                        <div class="px-2 py-2 border-b border-gray-100 mb-1">
                                            <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                                            <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                                        </div>

                                        <a href="javascript:void(0)"
                                            class="text-[15px] text-slate-800 font-medium cursor-pointer flex items-center p-2 rounded-md hover:bg-[#DBEAFE] dropdown-item transition duration-300 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] mr-3 fill-current" viewBox="0 0 512 512">
                                                <path d="M437.02 74.98C388.668 26.63 324.379 0 256 0S123.332 26.629 74.98 74.98C26.63 123.332 0 187.621 0 256s26.629 132.668 74.98 181.02C123.332 485.37 187.621 512 256 512s132.668-26.629 181.02-74.98C485.37 388.668 512 324.379 512 256s-26.629-132.668-74.98-181.02zM111.105 429.297c8.454-72.735 70.989-128.89 144.895-128.89 38.96 0 75.598 15.179 103.156 42.734 23.281 23.285 37.965 53.687 41.742 86.152C361.641 462.172 311.094 482 256 482s-105.637-19.824-144.895-52.703zM256 269.507c-42.871 0-77.754-34.882-77.754-77.753C178.246 148.879 213.13 114 256 114s77.754 34.879 77.754 77.754c0 42.871-34.883 77.754-77.754 77.754zm170.719 134.427a175.9 175.9 0 0 0-46.352-82.004c-18.437-18.438-40.25-32.27-64.039-40.938 28.598-19.394 47.426-52.16 47.426-89.238C363.754 132.34 315.414 84 256 84s-107.754 48.34-107.754 107.754c0 37.098 18.844 69.875 47.465 89.266-21.887 7.976-42.14 20.308-59.566 36.542-25.235 23.5-42.758 53.465-50.883 86.348C50.852 364.242 30 312.512 30 256 30 131.383 131.383 30 256 30s226 101.383 226 226c0 56.523-20.86 108.266-55.281 147.934zm0 0"/>
                                            </svg>
                                            My Profile
                                        </a>

                                        <a href="javascript:void(0)"
                                            class="text-[15px] text-slate-800 font-medium cursor-pointer flex items-center p-2 rounded-md hover:bg-[#DBEAFE] dropdown-item transition duration-300 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-[18px] h-[18px] mr-3 fill-current" viewBox="0 0 24 24">
                                                <path d="M19.56 23.253H4.44a4.051 4.051 0 0 1-4.05-4.05v-9.115c0-1.317.648-2.56 1.728-3.315l7.56-5.292a4.062 4.062 0 0 1 4.644 0l7.56 5.292a4.056 4.056 0 0 1 1.728 3.315v9.115a4.051 4.051 0 0 1-4.05 4.05zM12 2.366a2.45 2.45 0 0 0-1.393.443l-7.56 5.292a2.433 2.433 0 0 0-1.037 1.987v9.115c0 1.34 1.09 2.43 2.43 2.43h15.12c1.34 0 2.43-1.09 2.43-2.43v-9.115c0-.788-.389-1.533-1.037-1.987l-7.56-5.292A2.438 2.438 0 0 0 12 2.377z"/>
                                                <path d="M16.32 23.253H7.68a.816.816 0 0 1-.81-.81v-5.4c0-2.83 2.3-5.13 5.13-5.13s5.13 2.3 5.13 5.13v5.4c0 .443-.367.81-.81.81zm-7.83-1.62h7.02v-4.59c0-1.933-1.577-3.51-3.51-3.51s-3.51 1.577-3.51 3.51z"/>
                                            </svg>
                                            Dashboard
                                        </a>

                                        @if(!Auth::user()->password)
                                        <a href="javascript:void(0)" onclick="document.getElementById('setPasswordModal').classList.remove('hidden')"
                                            class="text-[15px] text-slate-800 font-medium cursor-pointer flex items-center p-2 rounded-md hover:bg-[#DBEAFE] dropdown-item transition duration-300 ease-in-out">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] mr-3 fill-current" viewBox="0 0 24 24">
                                                <path d="M12 1C8.676 1 6 3.676 6 7v1H4v15h16V8h-2V7c0-3.324-2.676-6-6-6zm0 2c2.276 0 4 1.724 4 4v1H8V7c0-2.276 1.724-4 4-4zm0 9a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"/>
                                            </svg>
                                            Set Password
                                        </a>
                                        @endif

                                        <hr class="my-1 -mx-2 border-gray-100" />

                                        <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                            @csrf
                                            <button type="button" id="logoutBtn"
                                                class="text-[15px] text-red-500 font-medium cursor-pointer flex items-center p-2 rounded-md hover:bg-red-50 dropdown-item transition duration-300 ease-in-out w-full text-left">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] mr-3 fill-current" viewBox="0 0 6 6">
                                                    <path d="M3.172.53a.265.266 0 0 0-.262.268v2.127a.265.266 0 0 0 .53 0V.798A.265.266 0 0 0 3.172.53zm1.544.532a.265.266 0 0 0-.026 0 .265.266 0 0 0-.147.47c.459.391.749.973.749 1.626 0 1.18-.944 2.131-2.116 2.131A2.12 2.12 0 0 1 1.06 3.16c0-.65.286-1.228.74-1.62a.265.266 0 1 0-.344-.404A2.667 2.667 0 0 0 .53 3.158a2.66 2.66 0 0 0 2.647 2.663 2.657 2.657 0 0 0 2.645-2.663c0-.812-.363-1.542-.936-2.03a.265.266 0 0 0-.17-.066z"/>
                                                </svg>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <div class="my-8 px-2 space-y-8">

                <!-- Welcome Banner + Quick Actions -->
                <div class="bg-gradient-to-r from-[#2979FF] to-[#00d68f] rounded-2xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-white text-xl font-bold">Welcome back, {{ Auth::user()->first_name }}! 👋</h1>
                        <p class="text-blue-100 text-sm mt-1">What would you like to do today?</p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <button type="button"
                            class="flex items-center gap-2 px-4 py-2.5 bg-white text-[#2979FF] text-sm font-semibold rounded-xl hover:bg-green-50 transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-[#2979FF]" viewBox="0 0 24 24">
                                <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm1-11H11v3H8v2h3v3h2v-3h3v-2h-3z"/>
                            </svg>
                            Join a Quiz Room
                        </button>
                        <button type="button"
                            class="flex items-center gap-2 px-4 py-2.5 bg-[#0D47A1] text-white text-sm font-semibold rounded-xl hover:bg-[#003d28] transition shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-white" viewBox="0 0 24 24">
                                <path d="M18 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2zm-5 13h-2v-2H9v-2h2V9h2v2h2v2h-2z"/>
                            </svg>
                            Create a Quiz
                        </button>
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

</x-layout>