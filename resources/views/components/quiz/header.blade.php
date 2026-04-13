@props(['hideHeader' => false])

<header class="z-50 bg-[#f7f6f9] sticky top-0 pt-8 border-b border-black">
    <div class="flex flex-wrap items-center w-full relative tracking-wide">
        <div class="flex items-center gap-y-6 max-sm:flex-col z-50 w-full pb-2">

            @if (!$hideHeader)
                <div class="flex items-center gap-4 w-full px-6 bg-white shadow-sm min-h-[48px] sm:mr-20 rounded-md outline-0 border-0">
                    <input type='text' placeholder='Search quizzes...' class="w-full text-sm bg-transparent rounded-sm outline-0" />
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192.904 192.904" class="w-4 cursor-pointer fill-gray-400 ml-auto">
                        <path d="m190.707 180.101-47.078-47.077c11.702-14.072 18.752-32.142 18.752-51.831C162.381 36.423 125.959 0 81.191 0 36.422 0 0 36.423 0 81.193c0 44.767 36.422 81.187 81.191 81.187 19.688 0 37.759-7.049 51.831-18.751l47.079 47.078a7.474 7.474 0 0 0 5.303 2.197 7.498 7.498 0 0 0 5.303-12.803zM15 81.193C15 44.694 44.693 15 81.191 15c36.497 0 66.189 29.694 66.189 66.193 0 36.496-29.692 66.187-66.189 66.187C44.693 147.38 15 117.689 15 81.193z"/>
                    </svg>
                </div>
            @endif

            <!-- Always flush right -->
            <div class="flex items-center gap-4 ml-auto">

                @if (!$hideHeader)
                    <div class="w-px h-10 bg-gray-300"></div>
                    <p class="text-slate-500 text-sm">Hello, {{ Auth::user()->first_name }}</p>
                @endif

                <!-- Profile Dropdown -->
                <div class="dropdown-menu relative flex shrink-0 group">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}"
                            alt="profile-pic"
                            class="w-[38px] h-[38px] rounded-full border-2 border-gray-300 cursor-pointer object-cover" />
                    @else
                        <div class="w-[38px] h-[38px] rounded-full border-2 border-gray-300 cursor-pointer bg-blue-100 flex items-center justify-center text-[#2979FF] text-sm font-bold">
                            {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? '', 0, 1)) }}
                        </div>
                    @endif

                    <!-- Hover bridge -->
                    <div class="absolute w-full h-4 bottom-0 translate-y-full"></div>

                    <div class="dropdown-content hidden group-hover:block shadow-md p-2 bg-white rounded-md absolute top-[48px] right-0 w-56 z-50">
                        <div class="w-full space-y-2">
                            <div class="px-2 py-2 border-b border-gray-100 mb-1">
                                <p class="text-sm font-semibold text-slate-800">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                                <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route("to-profile") }}"
                                class="text-[15px] text-slate-800 font-medium cursor-pointer flex items-center p-2 rounded-md hover:bg-[#DBEAFE] dropdown-item transition duration-300 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-[18px] h-[18px] mr-3 fill-current" viewBox="0 0 512 512">
                                    <path d="M437.02 74.98C388.668 26.63 324.379 0 256 0S123.332 26.629 74.98 74.98C26.63 123.332 0 187.621 0 256s26.629 132.668 74.98 181.02C123.332 485.37 187.621 512 256 512s132.668-26.629 181.02-74.98C485.37 388.668 512 324.379 512 256s-26.629-132.668-74.98-181.02zM111.105 429.297c8.454-72.735 70.989-128.89 144.895-128.89 38.96 0 75.598 15.179 103.156 42.734 23.281 23.285 37.965 53.687 41.742 86.152C361.641 462.172 311.094 482 256 482s-105.637-19.824-144.895-52.703zM256 269.507c-42.871 0-77.754-34.882-77.754-77.753C178.246 148.879 213.13 114 256 114s77.754 34.879 77.754 77.754c0 42.871-34.883 77.754-77.754 77.754zm170.719 134.427a175.9 175.9 0 0 0-46.352-82.004c-18.437-18.438-40.25-32.27-64.039-40.938 28.598-19.394 47.426-52.16 47.426-89.238C363.754 132.34 315.414 84 256 84s-107.754 48.34-107.754 107.754c0 37.098 18.844 69.875 47.465 89.266-21.887 7.976-42.14 20.308-59.566 36.542-25.235 23.5-42.758 53.465-50.883 86.348C50.852 364.242 30 312.512 30 256 30 131.383 131.383 30 256 30s226 101.383 226 226c0 56.523-20.86 108.266-55.281 147.934zm0 0"/>
                                </svg>
                                My Profile
                            </a>

                            <a href="/user-dashboard"
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
                                    class="text-[15px] text-red-500 font-medium cursor-pointer flex items-center p-2 rounded-md hover:bg-red-50 w-full text-left transition duration-300 ease-in-out">
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