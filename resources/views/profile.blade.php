<x-layout>
<div class="relative bg-[#f7f6f9] h-full min-h-screen">
    <div class="flex items-start">

        <x-quiz.sidebar currentTab="profile"/>

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

                <!-- Profile Banner -->
                <div class="bg-gradient-to-r from-[#2979FF] to-[#29B6F6] rounded-2xl p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-full bg-white/30 flex items-center justify-center text-white text-2xl font-bold shadow-inner overflow-hidden">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-full h-full object-cover rounded-full"/>
                            @else
                                {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? '', 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <h1 class="text-white text-xl font-bold">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
                            <p class="text-blue-100 text-sm mt-0.5">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    <div class="text-blue-100 text-xs">
                        Member since {{ Auth::user()->created_at->format('F Y') }}
                    </div>
                </div>

                <!-- Stats Row -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Quizzes Taken</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $quizzesTaken }}</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Quizzes Created</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $quizzesCreated }}</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Avg. Score</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">{{ $avgScore }}%</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm">
                        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Best Rank</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1">
                            {{ $bestRank ? '#' . $bestRank : 'N/A' }}
                        </p>
                    </div>
                </div>

                <!-- Profile Form + Change Password -->
                <div class="grid lg:grid-cols-2 gap-6">

                    <!-- Edit Profile -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                            <h2 class="text-sm font-bold text-slate-800">Profile Information</h2>
                        </div>
                        <form id="profileForm" class="p-6 space-y-4">
                            @csrf
                            @method('PUT')

                            <!-- Avatar Upload -->
                            <div class="flex items-center gap-4 mb-2">
                                <div id="avatarPreview"
                                    class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-[#2979FF] text-xl font-bold overflow-hidden flex-shrink-0">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="w-full h-full object-cover"/>
                                    @else
                                        {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name ?? '', 0, 1)) }}
                                    @endif
                                </div>
                                <div>
                                    <label for="avatarInput"
                                        class="cursor-pointer inline-flex items-center gap-2 px-4 py-2 text-xs font-semibold text-[#2979FF] border border-[#2979FF] rounded-lg hover:bg-blue-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-[#2979FF]" viewBox="0 0 24 24">
                                            <path d="M5 20h14v-2H5v2zm7-18l-5 5h3v4h4v-4h3L12 2z"/>
                                        </svg>
                                        Upload Photo
                                    </label>
                                    <input type="file" id="avatarInput" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)"/>
                                    <p class="text-xs text-slate-400 mt-1">JPG, PNG up to 2MB</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">First Name</label>
                                    <input type="text" name="first_name" value="{{ Auth::user()->first_name }}"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-slate-800 outline-none focus:ring-2 focus:ring-blue-300 focus:border-[#2979FF] transition"/>
                                    <p class="text-red-500 text-xs mt-1 field-error" id="err_first_name"></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Last Name</label>
                                    <input type="text" name="last_name" value="{{ Auth::user()->last_name }}"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-slate-800 outline-none focus:ring-2 focus:ring-blue-300 focus:border-[#2979FF] transition"/>
                                    <p class="text-red-500 text-xs mt-1 field-error" id="err_last_name"></p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Email Address</label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm text-slate-800 outline-none focus:ring-2 focus:ring-blue-300 focus:border-[#2979FF] transition"/>
                                <p class="text-red-500 text-xs mt-1 field-error" id="err_email"></p>
                            </div>

                            <div id="profileSuccess" class="hidden text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-4 py-2.5">
                                Profile updated successfully!
                            </div>
                            <div id="profileError" class="hidden text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-2.5"></div>

                            <button type="button" onclick="saveProfile()"
                                class="w-full py-2.5 bg-[#2979FF] hover:bg-[#1565C0] text-white text-sm font-semibold rounded-lg transition duration-300">
                                Save Changes
                            </button>
                        </form>
                    </div>

                    <!-- Change Password -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                            <h2 class="text-sm font-bold text-slate-800">Change Password</h2>
                        </div>
                        <div class="p-6 space-y-4">

                            @if(!Auth::user()->password)
                                <div class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-3 mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 fill-yellow-500 flex-shrink-0 mt-0.5" viewBox="0 0 24 24">
                                        <path d="M12 2a10 10 0 1 0 0 20A10 10 0 0 0 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                    </svg>
                                    <p class="text-xs text-yellow-700">You signed in with Google. Set a password to also log in with email.</p>
                                </div>
                            @else
                                <div>
                                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Current Password</label>
                                    <input type="password" id="currentPassword" placeholder="Enter current password"
                                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-300 focus:border-[#2979FF] transition"/>
                                    <p class="text-red-500 text-xs mt-1" id="err_current_password"></p>
                                </div>
                            @endif

                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">New Password</label>
                                <input type="password" id="newPassword" placeholder="Enter new password"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-300 focus:border-[#2979FF] transition"/>
                                <p class="text-red-500 text-xs mt-1" id="err_new_password"></p>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-1">Confirm New Password</label>
                                <input type="password" id="confirmPassword" placeholder="Confirm new password"
                                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-blue-300 focus:border-[#2979FF] transition"/>
                                <p class="text-red-500 text-xs mt-1" id="err_confirm_password"></p>
                            </div>

                            <div id="passwordSuccess" class="hidden text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-4 py-2.5">
                                Password updated successfully!
                            </div>
                            <div id="passwordError" class="hidden text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-2.5"></div>

                            <button type="button" onclick="changePassword()"
                                class="w-full py-2.5 bg-[#2979FF] hover:bg-[#1565C0] text-white text-sm font-semibold rounded-lg transition duration-300">
                                Update Password
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Danger Zone -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                        <h2 class="text-sm font-bold text-slate-800">Danger Zone</h2>
                    </div>
                    <div class="px-6 py-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-slate-800">Delete Account</p>
                            <p class="text-xs text-slate-400 mt-0.5">Permanently delete your account and all associated data. This cannot be undone.</p>
                        </div>
                        <button onclick="document.getElementById('deleteAccountModal').classList.remove('hidden')"
                            class="flex-shrink-0 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold rounded-lg border border-red-200 transition">
                            Delete Account
                        </button>
                    </div>
                </div>

            </div>
        </section>
    </div>
</div>

<!-- Delete Account Confirmation Modal -->
<div id="deleteAccountModal" class="hidden fixed inset-0 z-[200] flex items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
        onclick="document.getElementById('deleteAccountModal').classList.add('hidden')"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-8 z-10">
        <button onclick="document.getElementById('deleteAccountModal').classList.add('hidden')"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div class="mb-6">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-red-600" viewBox="0 0 24 24">
                    <path d="M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Delete Account</h2>
            <p class="text-sm text-slate-500 mt-1">This action is irreversible. All your quizzes, history, and data will be permanently deleted.</p>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Type <span class="font-bold text-red-500">DELETE</span> to confirm</label>
                <input type="text" id="deleteConfirmInput" placeholder="DELETE"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm outline-none focus:ring-2 focus:ring-red-400 transition"/>
            </div>
            <div id="deleteError" class="hidden text-sm text-red-600 bg-red-50 border border-red-200 rounded-lg px-4 py-2.5"></div>
            <button type="button" onclick="deleteAccount()"
                class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg transition duration-300">
                Permanently Delete Account
            </button>
        </div>
    </div>
</div>

<script>
    window.ProfileConfig = {
        csrfToken:       '{{ csrf_token() }}',
        updateUrl:       '{{ route("profile.update") }}',
        passwordUrl:     '{{ route("profile.password") }}',
        destroyUrl:      '{{ route("profile.destroy") }}',
    };
</script>
@vite('resources/js/user/profile.js')
@vite('resources/js/user/profile.js')
@vite('resources/js/user/logout.js')

</x-layout>