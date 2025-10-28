<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - BFP Inventory System</title>
    <link rel="icon" type="image/x-icon" href="/Img/Icon.png">
    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url('/Font/Montserrat-Bold.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        body {
            font-family: 'Montserrat', sans-serif;
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
    <style>
        body {
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
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Carousel Background -->
    <div class="carousel-container">
        <div class="carousel-image" style="background-image: url('/Img/Carousel1.png');" data-image="1"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel2.png');" data-image="2"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel3.png');" data-image="3"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel4.png');" data-image="4"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel5.png');" data-image="5"></div>
    </div>

    <!-- Top Navigation Bar -->
    <div class="bg-red-800 text-white p-4 flex justify-between items-center">
        <div class="flex items-center space-x-4">
            <img src="/Img/Icon.png" alt="BFP Icon" class="h-8 w-8">
            <h1 class="text-xl font-bold">BFP INVENTORY SYSTEM</h1>
        </div>
        <div class="flex items-center space-x-4">
            <i id="sidebarToggle" class="fas fa-bars text-white cursor-pointer hover:text-blue-200"></i>
        </div>
    </div>

    <!-- Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 right-0 w-64 bg-gray-800 text-white transform translate-x-full transition-transform duration-300 ease-in-out z-50">
        <div class="p-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold">Navigation</h2>
                <button id="sidebarClose" class="text-white hover:text-gray-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded">
                    <i class="fas fa-home mr-2"></i>Dashboard
                </a>
                <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded">
                    <i class="fas fa-truck mr-2"></i>Suppliers
                </a>
                <a href="{{ route('reports.index') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded">
                    <i class="fas fa-chart-bar mr-2"></i>Full Reports
                </a>
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

    <!-- Main Content -->
    <div class="flex justify-center p-8">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-6xl">
            <!-- Header Section -->
            <div class="p-6 border-b">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">User Management</h2>

                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
                @endif

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 bg-blue-100 rounded-full">
                                <i class="fas fa-box text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total Items</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $totalItems }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 p-6 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 bg-green-100 rounded-full">
                                <i class="fas fa-truck text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Suppliers</p>
                                <p class="text-2xl font-bold text-green-600">{{ $totalSuppliers }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 p-6 rounded-lg">
                        <div class="flex items-center">
                            <div class="p-3 bg-purple-100 rounded-full">
                                <i class="fas fa-users text-purple-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Users</p>
                                <p class="text-2xl font-bold text-purple-600">{{ $totalUsers }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Management -->
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">User Management</h3>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <button class="edit-user-email-btn bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 mr-2"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}">
                                        <i class="fas fa-envelope mr-1"></i>Change Email
                                    </button>
                                    <button class="edit-user-password-btn bg-yellow-600 text-white px-3 py-1 rounded text-xs hover:bg-yellow-700 mr-2"
                                        data-id="{{ $user->id }}"
                                        data-name="{{ $user->name }}">
                                        <i class="fas fa-key mr-1"></i>Change Password
                                    </button>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                    <i class="fas fa-users text-4xl mb-4"></i>
                                    <p class="text-lg">No users found</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Change User Email Modal -->
    <div id="userEmailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Change User Email</h3>
                <button onclick="closeUserEmailModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="userEmailForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" id="userEmailUserId">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">User Name</label>
                        <input type="text" id="userEmailUserName" disabled
                            class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                    </div>

                    <div>
                        <label for="user_email" class="block text-sm font-medium text-gray-700 mb-1">New Email *</label>
                        <input type="email" name="email" id="user_email" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeUserEmailModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Change User Password Modal -->
    <div id="userPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Change User Password</h3>
                <button onclick="closeUserPasswordModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="userPasswordForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" id="userPasswordUserId">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">User Name</label>
                        <input type="text" id="userPasswordUserName" disabled
                            class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100">
                    </div>

                    <div>
                        <label for="user_password" class="block text-sm font-medium text-gray-700 mb-1">New Password *</label>
                        <input type="password" name="password" id="user_password" required minlength="8"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>

                    <div>
                        <label for="user_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                        <input type="password" name="password_confirmation" id="user_password_confirmation" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeUserPasswordModal()"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openUserEmailModal(id, name, email) {
            document.getElementById('userEmailModal').classList.remove('hidden');
            document.getElementById('userEmailModal').classList.add('flex');
            document.getElementById('userEmailForm').action = '{{ route("admin.users.update.email", ":id") }}'.replace(':id', id);
            document.getElementById('userEmailUserId').value = id;
            document.getElementById('userEmailUserName').value = name;
            document.getElementById('user_email').value = email;
        }

        function closeUserEmailModal() {
            document.getElementById('userEmailModal').classList.add('hidden');
            document.getElementById('userEmailModal').classList.remove('flex');
        }

        function openUserPasswordModal(id, name) {
            document.getElementById('userPasswordModal').classList.remove('hidden');
            document.getElementById('userPasswordModal').classList.add('flex');
            document.getElementById('userPasswordForm').action = '{{ route("admin.users.update.password", ":id") }}'.replace(':id', id);
            document.getElementById('userPasswordUserId').value = id;
            document.getElementById('userPasswordUserName').value = name;
            document.getElementById('userPasswordForm').reset();
        }

        function closeUserPasswordModal() {
            document.getElementById('userPasswordModal').classList.add('hidden');
            document.getElementById('userPasswordModal').classList.remove('flex');
        }

        // Add event listeners when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Handle user email button clicks
            document.querySelectorAll('.edit-user-email-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const email = this.dataset.email;

                    openUserEmailModal(id, name, email);
                });
            });

            // Handle user password button clicks
            document.querySelectorAll('.edit-user-password-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    openUserPasswordModal(id, name);
                });
            });
        });

        // Sidebar functionality
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('translate-x-full');
            document.getElementById('sidebarOverlay').classList.remove('hidden');
        });

        document.getElementById('sidebarClose').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        });

        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.add('translate-x-full');
            document.getElementById('sidebarOverlay').classList.add('hidden');
        });

        // Close modals when clicking outside
        document.getElementById('userEmailModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUserEmailModal();
            }
        });

        document.getElementById('userPasswordModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUserPasswordModal();
            }
        });

        // Carousel functionality
        let currentImage = 1;
        const totalImages = 5;

        function showImage(imageNumber) {
            // Remove active class from all images
            document.querySelectorAll('.carousel-image').forEach(img => {
                img.classList.remove('active');
            });

            // Add active class to current image
            const currentImg = document.querySelector(`[data-image="${imageNumber}"]`);
            if (currentImg) {
                currentImg.classList.add('active');
            }
        }

        function nextImage() {
            currentImage = currentImage >= totalImages ? 1 : currentImage + 1;
            showImage(currentImage);
        }

        // Initialize carousel
        document.addEventListener('DOMContentLoaded', function() {
            showImage(1); // Show first image
            setInterval(nextImage, 5000); // Change every 5 seconds
        });
    </script>
</body>

</html>