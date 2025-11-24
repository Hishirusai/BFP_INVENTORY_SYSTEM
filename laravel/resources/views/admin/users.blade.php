<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - BFP Inventory System</title>
    <link rel="icon" type="image/x-icon" href="/Img/Icon.png">
    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url('/Font/Montserrat-Bold.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'Nebulax';
            src: url('/Font/nebulax.ttf') format('truetype');
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-image: url('/Img/Bg.png');
            background-size: cover;
            background-attachment: fixed;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(153, 0, 0, 0.45);
            z-index: -1;
        }

        /* Carousel Styles */
        .carousel-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            overflow: hidden;
        }

        .carousel-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .carousel-image.active {
            opacity: 0.45;
        }

        /* Custom Scrollbar */
        .overflow-y-auto::-webkit-scrollbar {
            width: 8px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #3b82f6, #2563eb);
            border-radius: 10px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(to bottom, #2563eb, #1d4ed8);
        }

        /* TOAST ANIMATIONS */
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        .toast-enter {
            animation: slideInRight 0.5s ease-out forwards;
        }
        .toast-exit {
            animation: fadeOut 0.5s ease-out forwards;
        }
    </style>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="h-screen overflow-hidden">

    <div id="toast-container" class="fixed bottom-4 right-4 z-[9999] space-y-4 pointer-events-none">
        @if(session('success'))
        <div class="toast-message toast-enter bg-gradient-to-r from-green-500 to-emerald-600 text-white p-4 rounded-lg shadow-xl border-2 border-green-400 flex items-center pointer-events-auto min-w-[300px]" data-duration="5000">
            <i class="fas fa-check-circle mr-3 text-2xl"></i>
            <div>
                <h4 class="font-bold text-sm uppercase">Success</h4>
                <span class="text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-white hover:text-gray-200"><i class="fas fa-times"></i></button>
        </div>
        @endif

        @if(session('error') || $errors->any())
        <div class="toast-message toast-enter bg-gradient-to-r from-red-500 to-rose-600 text-white p-4 rounded-lg shadow-xl border-2 border-red-400 flex items-center pointer-events-auto min-w-[300px]" data-duration="8000">
            <i class="fas fa-exclamation-triangle mr-3 text-2xl"></i>
            <div>
                <h4 class="font-bold text-sm uppercase">Error</h4>
                <span class="text-sm">{{ session('error') ?? 'Please check your password and try again.' }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-auto text-white hover:text-gray-200"><i class="fas fa-times"></i></button>
        </div>
        @endif
    </div>

    <div class="carousel-container">
        <div class="carousel-image" style="background-image: url('/Img/Carousel1.png');" data-image="1"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel2.png');" data-image="2"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel3.png');" data-image="3"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel4.png');" data-image="4"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel5.png');" data-image="5"></div>
    </div>

    <div class="sticky top-0 z-20 bg-gradient-to-r from-red-800 via-red-700 to-red-800 text-white p-2 flex justify-between items-center shadow-xl border-b-2 border-red-900">
        <div class="flex items-center space-x-3">
            <img src="/Img/Icon.png" alt="BFP Icon" class="h-8 w-8 rounded-lg shadow-lg ring-2 ring-white/20">
            <h1 class="text-base font-bold tracking-wide">BFP INVENTORY SYSTEM</h1>
        </div>
        <div class="flex items-center space-x-3">
            <i id="sidebarToggle" class="fas fa-bars text-white text-lg cursor-pointer hover:text-blue-200 hover:scale-110 transition-transform duration-200 p-1.5 rounded-lg hover:bg-white/10"></i>
        </div>
    </div>

    
    <div id="sidebar" class="fixed inset-y-0 right-0 w-64 bg-gradient-to-b from-gray-800 to-gray-900 text-white transform translate-x-full transition-transform duration-300 ease-in-out z-50 shadow-2xl border-l border-gray-700">
        <div class="p-6">
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-gray-700">
                <h2 class="text-xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">Navigation</h2>
                <button id="sidebarClose" class="text-white hover:text-red-400 hover:bg-red-500/20 p-2 rounded-lg transition-all duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <nav class="space-y-3">
                <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-gray-300 hover:bg-gradient-to-r hover:from-blue-600 hover:to-blue-700 hover:text-white rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 font-semibold">
                    <i class="fas fa-home mr-3"></i>Dashboard
                </a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-3 text-gray-300 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-700 hover:text-white rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 font-semibold">
                    <i class="fas fa-users mr-3"></i>Users
                </a>
                <a href="{{ route('stations.index') }}" class="block px-4 py-3 text-gray-300 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-700 hover:text-white rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 font-semibold">
                    <i class="fas fa-users mr-3"></i>Stations
                </a>
                <a href="{{ route('reports.index') }}" class="block px-4 py-3 text-gray-300 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-700 hover:text-white rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 font-semibold">
                    <i class="fas fa-users mr-3"></i>Full Reports
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-gray-300 hover:bg-gradient-to-r hover:from-red-600 hover:to-rose-700 hover:text-white rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 font-semibold">
                        <i class="fas fa-sign-out-alt mr-3"></i>Logout
                    </button>
                </form>
            </nav>
        </div>
    </div>
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

    <div class="flex justify-center p-2 h-[calc(100vh-40px)] overflow-hidden mb-4">
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl w-full max-w-[1280px] border border-white/20 flex flex-col h-full">
            <div class="flex-shrink-0 bg-white/98 backdrop-blur-md shadow-xl border-b border-gray-200 rounded-t-2xl">
                <div class="p-2">
                    <div class="flex items-center justify-between mb-1">
                        <h2 class="text-lg font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent flex items-center">
                            <i class="fas fa-users mr-2 text-blue-600"></i>USERS
                        </h2>
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 py-1.5 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-[11px]">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto overflow-y-auto rounded-b-2xl flex-1 min-h-0">
                <table class="w-full">
                    <thead class="sticky top-0 z-10">
                        <tr class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-600 text-white shadow-lg">
                            <th class="px-3 py-1.5 text-left text-[15px] font-bold uppercase tracking-wider"><i class="fas fa-user mr-1.5 text-[15px]"></i>Name</th>
                            <th class="px-3 py-1.5 text-left text-[15px] font-bold uppercase tracking-wider"><i class="fas fa-envelope mr-1.5 text-[15px]"></i>Email</th>
                            <th class="px-3 py-1.5 text-left text-[15px] font-bold uppercase tracking-wider"><i class="fas fa-cog mr-1.5 text-[15px]"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-colors duration-200 border-b border-gray-100">
                            <td class="px-3 py-2 text-sm text-gray-900 font-semibold">
                                <div class="flex items-center">
                                    @if($user->email == 'bfpadminaccount@gmail.com')
                                        <i class="fas fa-crown text-yellow-500 mr-2 text-lg" title="Super Admin"></i>
                                    @else
                                        <i class="fas fa-user-circle mr-2 text-blue-500"></i>
                                    @endif
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-700"><i class="fas fa-envelope mr-2 text-gray-400"></i>{{ $user->email }}</td>
                            <td class="px-3 py-2 text-xs">
                                <div class="flex space-x-2">
                                    <button class="edit-user-email-btn bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 py-2 rounded-lg text-xs hover:from-blue-600 hover:to-blue-700 inline-flex items-center shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105 font-semibold"
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}">
                                        <i class="fas fa-envelope mr-1"></i>Change Email
                                    </button>
                                    <button class="edit-user-password-btn bg-gradient-to-r from-yellow-500 to-orange-500 text-white px-3 py-2 rounded-lg text-xs hover:from-yellow-600 hover:to-orange-600 inline-flex items-center shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105 font-semibold"
                                        data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                        <i class="fas fa-key mr-1"></i>Change Password
                                    </button>
                                    
                                    @if($user->email != 'bfpadminaccount@gmail.com')
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-3 py-2 rounded-lg text-xs hover:from-red-600 hover:to-rose-700 inline-flex items-center shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105 font-semibold">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-16 text-center"><p class="text-xl font-bold text-gray-600">No users found</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="userEmailModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4 border-2 border-gray-200 transform transition-all duration-300 scale-95" id="emailModalContent">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center"><i class="fas fa-envelope mr-2 text-blue-600"></i>Change User Email</h3>
                <button onclick="closeUserEmailModal()" class="text-gray-500 hover:text-red-600 hover:bg-red-50"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="userEmailForm" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="user_id" id="userEmailUserId">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-bold text-gray-700 mb-2"><i class="fas fa-user mr-2 text-gray-600"></i>User Name</label>
                        <input type="text" id="userEmailUserName" disabled class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 bg-gray-100 font-semibold">
                    </div>
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border-l-4 border-blue-500">
                        <label class="block text-sm font-bold text-gray-700 mb-2"><i class="fas fa-envelope mr-2 text-blue-600"></i>New Email *</label>
                        <input type="email" name="email" id="user_email" required class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                        <label class="block text-sm font-bold text-gray-700 mb-2"><i class="fas fa-user-shield mr-2 text-red-600"></i>Admin Password (Yours) *</label>
                        <input type="password" name="admin_password" required placeholder="Enter YOUR admin password to authorize" class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:ring-red-500 focus:border-red-500">
                        <p class="text-xs text-gray-500 mt-1">This action overrides the user's old credentials.</p>
                        @error('admin_password') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeUserEmailModal()" class="px-4 py-2 border-2 border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 shadow-lg font-semibold">Update Email</button>
                </div>
            </form>
        </div>
    </div>

    <div id="userPasswordModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4 border-2 border-gray-200 transform transition-all duration-300 scale-95" id="passwordModalContent">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                <h3 class="text-2xl font-bold bg-gradient-to-r from-yellow-600 to-orange-600 bg-clip-text text-transparent flex items-center"><i class="fas fa-key mr-2 text-yellow-600"></i>Reset User Password</h3>
                <button onclick="closeUserPasswordModal()" class="text-gray-500 hover:text-red-600 hover:bg-red-50"><i class="fas fa-times text-xl"></i></button>
            </div>
            <form id="userPasswordForm" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="user_id" id="userPasswordUserId">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-bold text-gray-700 mb-2"><i class="fas fa-user mr-2 text-gray-600"></i>User Name</label>
                        <input type="text" id="userPasswordUserName" disabled class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 bg-gray-100 font-semibold">
                    </div>
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 p-4 rounded-lg border-l-4 border-yellow-500">
                        <label class="block text-sm font-bold text-gray-700 mb-2"><i class="fas fa-lock mr-2 text-yellow-600"></i>New Password for User *</label>
                        <input type="password" name="password" id="user_password" required minlength="8" class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:ring-yellow-500 focus:border-yellow-500">
                        <p class="text-xs text-gray-500 mt-1"><i class="fas fa-info-circle mr-1"></i>Minimum 8 characters</p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg border-l-4 border-red-500">
                        <label class="block text-sm font-bold text-gray-700 mb-2"><i class="fas fa-user-shield mr-2 text-red-600"></i>Admin Password (Yours) *</label>
                        <input type="password" name="admin_password" required placeholder="Enter YOUR admin password to authorize" class="w-full border-2 border-gray-300 rounded-lg px-3 py-2 focus:ring-red-500 focus:border-red-500">
                        <p class="text-xs text-gray-500 mt-1">This overrides the user's old password.</p>
                        @error('admin_password') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeUserPasswordModal()" class="px-4 py-2 border-2 border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-semibold">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-yellow-500 to-orange-600 text-white rounded-lg hover:from-yellow-600 hover:to-orange-700 shadow-lg font-semibold">Update Password</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // TOAST LOGIC
            const toasts = document.querySelectorAll('.toast-message');
            toasts.forEach(toast => {
                const duration = toast.getAttribute('data-duration') || 5000;
                setTimeout(() => {
                    toast.classList.remove('toast-enter');
                    toast.classList.add('toast-exit');
                    setTimeout(() => toast.remove(), 500);
                }, duration);
            });

            // CAROUSEL
            let currentImage = 1;
            const totalImages = 5;
            function showImage(n) {
                document.querySelectorAll('.carousel-image').forEach(img => img.classList.remove('active'));
                const img = document.querySelector(`[data-image="${n}"]`);
                if (img) img.classList.add('active');
            }
            function nextImage() {
                currentImage = currentImage >= totalImages ? 1 : currentImage + 1;
                showImage(currentImage);
            }
            showImage(1);
            setInterval(nextImage, 5000);

            // SIDEBAR
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            document.getElementById('sidebarToggle').addEventListener('click', () => {
                sidebar.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
            });
            function closeSidebar() {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
            }
            document.getElementById('sidebarClose').addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            // MODAL LOGIC
            const emailModal = document.getElementById('userEmailModal');
            const emailContent = document.getElementById('emailModalContent');
            const passModal = document.getElementById('userPasswordModal');
            const passContent = document.getElementById('passwordModalContent');

            window.openUserEmailModal = function(id, name, email) {
                document.getElementById('userEmailForm').action = '{{ route("admin.users.update.email", ":id") }}'.replace(':id', id);
                document.getElementById('userEmailForm').reset(); 
                document.getElementById('userEmailUserId').value = id;
                document.getElementById('userEmailUserName').value = name;
                document.getElementById('user_email').value = email;

                emailModal.classList.remove('hidden');
                emailModal.classList.add('flex');
                setTimeout(() => {
                    emailContent.classList.remove('scale-95');
                    emailContent.classList.add('scale-100');
                }, 10);
            }

            window.closeUserEmailModal = function() {
                emailContent.classList.remove('scale-100');
                emailContent.classList.add('scale-95');
                setTimeout(() => {
                    emailModal.classList.add('hidden');
                    emailModal.classList.remove('flex');
                }, 300);
            }

            window.openUserPasswordModal = function(id, name) {
                document.getElementById('userPasswordForm').action = '{{ route("admin.users.update.password", ":id") }}'.replace(':id', id);
                document.getElementById('userPasswordForm').reset(); 
                document.getElementById('userPasswordUserId').value = id;
                document.getElementById('userPasswordUserName').value = name;

                passModal.classList.remove('hidden');
                passModal.classList.add('flex');
                setTimeout(() => {
                    passContent.classList.remove('scale-95');
                    passContent.classList.add('scale-100');
                }, 10);
            }

            window.closeUserPasswordModal = function() {
                passContent.classList.remove('scale-100');
                passContent.classList.add('scale-95');
                setTimeout(() => {
                    passModal.classList.add('hidden');
                    passModal.classList.remove('flex');
                }, 300);
            }

            // LISTENERS
            document.querySelectorAll('.edit-user-email-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    openUserEmailModal(this.dataset.id, this.dataset.name, this.dataset.email);
                });
            });
            document.querySelectorAll('.edit-user-password-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    openUserPasswordModal(this.dataset.id, this.dataset.name);
                });
            });

            // CLOSE OUTSIDE
            emailModal.addEventListener('click', e => { if(e.target === emailModal) closeUserEmailModal(); });
            passModal.addEventListener('click', e => { if(e.target === passModal) closeUserPasswordModal(); });
        });
    </script>
</body>
</html>