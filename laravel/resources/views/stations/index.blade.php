<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stations - BFP Inventory System</title>
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

<body class="min-h-screen">

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
                <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-gray-300 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-700 hover:text-white rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 font-semibold">
                    <i class="fas fa-home mr-3"></i>Dashboard
                </a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-3 text-gray-300 hover:bg-gradient-to-r hover:from-green-600 hover:to-emerald-700 hover:text-white rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 font-semibold">
                    <i class="fas fa-users mr-3"></i>Users
                </a>
                <a href="{{ route('stations.index') }}" class="block px-4 py-3 text-gray-300 hover:bg-gradient-to-r hover:from-blue-600 hover:to-cyan-700 hover:text-white rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 font-semibold">
                    <i class="fas fa-building mr-3"></i>Stations
                </a>
                <a href="{{ route('reports.index') }}" class="block px-4 py-3 text-gray-300 hover:bg-gradient-to-r hover:from-purple-600 hover:to-indigo-700 hover:text-white rounded-lg transition-all duration-200 hover:shadow-lg hover:scale-105 font-semibold">
                    <i class="fas fa-chart-bar mr-3"></i>Full Reports
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
                        <div>
                            <h2 class="text-lg font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent flex items-center">
                                <i class="fas fa-building mr-2 text-blue-600"></i>STATIONS
                            </h2>
                            <p class="text-[10px] text-gray-600">Click on a station to view its inventory</p>
                        </div>
                        <a href="{{ route('stations.create') }}"
                            class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-3 py-1.5 rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-[11px]">
                            <i class="fas fa-plus mr-1.5"></i>Add Station
                        </a>
                    </div>
                    @if(session('success'))
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-3 py-1 rounded-lg mb-1 shadow-md flex items-center text-xs animate-pulse">
                        <i class="fas fa-check-circle mr-2 text-green-600"></i>{{ session('success') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 px-3 py-1 rounded-lg mb-1 shadow-md flex items-center text-xs">
                        <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>{{ session('error') }}
                    </div>
                    @endif
                </div>

                <!-- Stations Grid -->
                <div class="overflow-x-auto overflow-y-auto rounded-b-2xl flex-1 min-h-0 p-1.5">
                    @if($stations->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1">
                        @foreach($stations as $station)
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-3 hover:shadow-xl transition-all duration-300 border border-blue-200 hover:border-blue-400 relative">
                            <a href="{{ route('stations.show', $station) }}" class="block">
                                <div class="flex items-start mb-2">
                                    <div class="bg-blue-600 text-white rounded-full p-2 mr-3">
                                        <i class="fas fa-building text-lg"></i>
                                    </div>
                                    <div class="flex-1 grid grid-cols-1 gap-1">
                                        <div class="flex justify-between items-start">
                                            <h3 class="text-sm font-bold text-gray-800">{{ $station->name }}</h3>
                                            <span class="bg-blue-600 text-white px-2 py-1 rounded-full text-[10px] font-bold whitespace-nowrap">
                                                {{ $station->items_count }} items
                                            </span>
                                        </div>
                                        <div class="text-[10px] text-gray-600">
                                            <p class="mb-1">
                                                <i class="fas fa-code mr-1"></i>Code: {{ $station->code }}
                                            </p>
                                            @if($station->location)
                                            <p class="mb-1">
                                                <i class="fas fa-map-marker-alt mr-1"></i>{{ $station->location }}
                                            </p>
                                            @endif
                                            @if($station->description)
                                            <p class="text-gray-500 line-clamp-2">{{ $station->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <form action="{{ route('stations.destroy', $station) }}" method="POST" class="mt-2"
                                onsubmit="return confirm('Are you sure you want to remove this station? This action cannot be undone if the station has items.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition-all duration-200 shadow text-[10px] w-full flex items-center justify-center">
                                    <i class="fas fa-trash mr-1"></i>Remove
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-16">
                        <i class="fas fa-building text-6xl text-gray-400 mb-4"></i>
                        <p class="text-xl font-bold text-gray-600 mb-2">No stations found</p>
                        <p class="text-sm text-gray-500">Stations will appear here once created</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <script>
                    // Carousel functionality
        let currentImage = 1;
        const totalImages = 5;

        function showImage(imageNumber) {
            document.querySelectorAll('.carousel-image').forEach(img => {
                img.classList.remove('active');
            });
            const currentImg = document.querySelector(`[data-image="${imageNumber}"]`);
            if (currentImg) {
                currentImg.classList.add('active');
            }
        }

        function nextImage() {
            currentImage = currentImage >= totalImages ? 1 : currentImage + 1;
            showImage(currentImage);
        }

        document.addEventListener('DOMContentLoaded', function() {
            showImage(1);
            setInterval(nextImage, 5000);
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
        </script>
</body>

</html>