<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - BFP Inventory System</title>
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
    </style>
</head>

<body class="h-screen overflow-hidden">
    <!-- Carousel Background -->
    <div class="carousel-container">
        <div class="carousel-image" style="background-image: url('/Img/Carousel1.png');" data-image="1"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel2.png');" data-image="2"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel3.png');" data-image="3"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel4.png');" data-image="4"></div>
        <div class="carousel-image" style="background-image: url('/Img/Carousel5.png');" data-image="5"></div>
    </div>

    <!-- Top Navigation Bar -->
    <div class="sticky top-0 z-20 bg-gradient-to-r from-red-800 via-red-700 to-red-800 text-white p-2 flex justify-between items-center shadow-xl border-b-2 border-red-900">
        <div class="flex items-center space-x-3">
            <img src="/Img/Icon.png" alt="BFP Icon" class="h-8 w-8 rounded-lg shadow-lg ring-2 ring-white/20">
            <h1 class="text-base font-bold tracking-wide">BFP INVENTORY SYSTEM</h1>
        </div>
        <div class="flex items-center space-x-3">
            <i id="sidebarToggle" class="fas fa-bars text-white text-lg cursor-pointer hover:text-blue-200 hover:scale-110 transition-transform duration-200 p-1.5 rounded-lg hover:bg-white/10"></i>
        </div>
    </div>

    <!-- Sidebar -->
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
                <form method="POST" action="{{ route('logout') }}" class="block">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-gray-300 hover:bg-gradient-to-r hover:from-red-600 hover:to-rose-700 hover:text-white rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 font-semibold">
                        <i class="fas fa-sign-out-alt mr-3"></i>Logout
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Sidebar Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

    <!-- Main Content -->
    <div class="flex justify-center p-2 h-[calc(100vh-40px)] overflow-hidden mb-4">
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl w-full max-w-[1280px] border border-white/20 flex flex-col h-full">
            <!-- Header Section - Sticky -->
            <div class="flex-shrink-0 bg-white/98 backdrop-blur-md shadow-xl border-b border-gray-200 rounded-t-2xl">
                <div class="p-1.5">
                    <div class="flex items-center justify-between mb-1">
                        <h2 class="text-lg font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent flex items-center">
                            <i class="fas fa-chart-bar mr-2 text-blue-600"></i>Reports
                        </h2>
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 py-1.5 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-[11px]">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                        </a>
                    </div>

                    @if(session('success'))
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-lg mb-4 shadow-md flex items-center animate-pulse">
                        <i class="fas fa-check-circle mr-2 text-green-600"></i>{{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-lg mb-4 shadow-md flex items-center">
                        <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>{{ session('error') }}
                    </div>
                    @endif

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('reports.index') }}" class="mb-1">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-1">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-2 rounded-lg border-l-2 border-blue-500">
                                <label for="type" class="block text-[10px] font-bold text-gray-700 mb-1 flex items-center">
                                    <i class="fas fa-filter mr-1 text-blue-600"></i>Report Type
                                </label>
                                <select name="type" id="type" class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm bg-white text-xs">
                                    <option value="">All Types</option>
                                    <option value="addition" {{ request('type') == 'addition' ? 'selected' : '' }}>Addition</option>
                                    <option value="decrease" {{ request('type') == 'decrease' ? 'selected' : '' }}>Decrease</option>
                                </select>
                            </div>

                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-2 rounded-lg border-l-2 border-green-500">
                                <label for="item_id" class="block text-[10px] font-bold text-gray-700 mb-1 flex items-center">
                                    <i class="fas fa-box mr-1 text-green-600"></i>Item
                                </label>
                                <select name="item_id" id="item_id" class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 transition-all duration-200 shadow-sm bg-white text-xs">
                                    <option value="">All Items</option>
                                    @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-end gap-1">
                                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-2 py-1 rounded hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow font-semibold text-xs flex-1">
                                    <i class="fas fa-filter mr-1"></i>Filter
                                </button>
                                <a href="{{ route('reports.index') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-2 py-1 rounded hover:from-gray-600 hover:to-gray-700 transition-all duration-200 shadow font-semibold text-xs">
                                    <i class="fas fa-times mr-1"></i>Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Reports Table -->
            <div class="overflow-x-auto overflow-y-auto rounded-b-2xl flex-1 min-h-0">
                <table class="w-full">
                    <thead class="sticky top-0 z-10">
                        <tr class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-600 text-white shadow-lg">
                            <th class="px-3 py-1.5 text-left text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-calendar mr-1.5 text-[10px]"></i>Date
                            </th>
                            <th class="px-3 py-1.5 text-left text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-tag mr-1.5 text-[10px]"></i>Type
                            </th>
                            <th class="px-3 py-1.5 text-left text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-box mr-1.5 text-[10px]"></i>Item
                            </th>
                            <th class="px-3 py-1.5 text-left text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-sort-numeric-up mr-1.5 text-[10px]"></i>Quantity Change
                            </th>
                            <th class="px-3 py-1.5 text-left text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-dollar-sign mr-1.5 text-[10px]"></i>Cost Change
                            </th>
                            <th class="px-3 py-1.5 text-left text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-comment mr-1.5 text-[10px]"></i>Reason
                            </th>
                            <th class="px-3 py-1.5 text-left text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-user mr-1.5 text-[10px]"></i>User
                            </th>
                            <th class="px-3 py-1.5 text-left text-[10px] font-bold uppercase tracking-wider">
                                <i class="fas fa-cog mr-1.5 text-[10px]"></i>Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $index => $report)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-colors duration-200 border-b border-gray-100">
                            <td class="px-3 py-2 text-[9px] text-gray-700">
                                <i class="fas fa-clock mr-2 text-gray-400"></i>{{ $report->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-3 py-2 text-[9px]">
                                <span class="px-3 py-1.5 rounded-full text-[9px] font-bold shadow-sm
                                    @if($report->type == 'addition') bg-gradient-to-r from-green-400 to-emerald-500 text-white
                                    @else bg-gradient-to-r from-red-400 to-rose-500 text-white
                                    @endif">
                                    <i class="fas fa-circle text-[6px] mr-1"></i>{{ ucfirst($report->type) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-[9px] text-gray-900 font-semibold">
                                <i class="fas fa-box-open mr-2 text-blue-500"></i>{{ $report->item->name }}
                            </td>
                            <td class="px-3 py-2 text-[9px] text-gray-900 font-bold">
                                @if($report->type == 'addition')
                                <span class="text-green-600 bg-green-50 px-2 py-1 rounded-full text-[9px]">+{{ $report->quantity_change }}</span>
                                @else
                                <span class="text-red-600 bg-red-50 px-2 py-1 rounded-full text-[9px]">-{{ $report->quantity_change }}</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-[9px] font-bold">
                                @if($report->cost_change > 0)
                                <span class="text-green-700 bg-green-50 px-2 py-1 rounded-full text-[9px]">
                                    <i class="fas fa-arrow-up mr-1"></i>+₱{{ number_format($report->cost_change, 2) }}
                                </span>
                                @else
                                <span class="text-red-700 bg-red-50 px-2 py-1 rounded-full text-[9px]">
                                    <i class="fas fa-arrow-down mr-1"></i>-₱{{ number_format(abs($report->cost_change), 2) }}
                                </span>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-[9px] text-gray-700">
                                <i class="fas fa-comment-alt mr-2 text-gray-400"></i>{{ $report->reason ?? 'N/A' }}
                            </td>
                            <td class="px-3 py-2 text-[9px] text-gray-700">
                                <i class="fas fa-user-circle mr-2 text-gray-400"></i>{{ $report->user->name }}
                            </td>
                            <td class="px-3 py-2 text-xs">
                                <form action="{{ route('reports.destroy', $report) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this report?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-2.5 py-1.5 rounded-lg text-[10px] hover:from-red-600 hover:to-rose-700 inline-flex items-center shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105 font-semibold">
                                        <i class="fas fa-trash mr-1"></i>Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center bg-gradient-to-br from-gray-50 to-gray-100">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-file-alt text-6xl text-gray-400 mb-4"></i>
                                    <p class="text-xl font-bold text-gray-600 mb-2">No reports found</p>
                                    <p class="text-sm text-gray-500">Try adjusting your filters</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reports->hasPages())
            <div class="flex-shrink-0 p-1.5 border-t border-gray-200 bg-gradient-to-r from-gray-100 to-gray-50 compact-pagination mt-2 mb-4 rounded-b-xl">
                <div class="flex items-center justify-between gap-2 h-full">
                    <div class="text-sm text-gray-800 font-bold whitespace-nowrap">
                        <i class="fas fa-list mr-1 text-blue-600 text-sm"></i>Showing {{ $reports->firstItem() }} to {{ $reports->lastItem() }} of {{ $reports->total() }} results
                    </div>
                    <div class="compact-pagination flex items-center space-x-1">
                        @if ($reports->onFirstPage())
                        <span class="relative inline-flex items-center px-2.5 py-1.5 text-base font-bold text-gray-500 bg-gray-300 border border-gray-400 cursor-default leading-4 rounded-md shadow">
                            &lt;
                        </span>
                        @else
                        <a href="{{ $reports->previousPageUrl() }}" class="relative inline-flex items-center px-2.5 py-1.5 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 border border-blue-800 leading-4 rounded-md hover:from-blue-700 hover:to-blue-800 shadow hover:shadow-md transition duration-200">
                            &lt;
                        </a>
                        @endif

                        <div class="px-2 py-1 text-sm font-bold text-gray-700">
                            {{ $reports->currentPage() }} of {{ $reports->lastPage() }}
                        </div>

                        @if ($reports->hasMorePages())
                        <a href="{{ $reports->nextPageUrl() }}" class="relative -ml-px inline-flex items-center px-2.5 py-1.5 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 border border-blue-800 leading-4 rounded-md hover:from-blue-700 hover:to-blue-800 shadow hover:shadow-md transition duration-200">
                            &gt;
                        </a>
                        @else
                        <span class="relative -ml-px inline-flex items-center px-2.5 py-1.5 text-base font-bold text-gray-500 bg-gray-300 border border-gray-400 cursor-default leading-4 rounded-md shadow">
                            &gt;
                        </span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <script>
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