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
        
        /* Smooth modal transitions */
        #addStationModal {
            transition: opacity 0.3s ease-out;
        }

        #addStationModalContent {
            transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        }

        .modal-hidden {
            opacity: 0;
            pointer-events: none;
        }

        .modal-visible {
            opacity: 1;
        }

        .modal-content-hidden {
            transform: scale(0.95);
            opacity: 0;
        }

        .modal-content-visible {
            transform: scale(1);
            opacity: 1;
        }

        /* Search functionality styles */
        .search-container {
            position: relative;
            margin-bottom: 15px;
        }

        .search-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-input {
            width: 100%;
            padding: 12px 45px 12px 15px;
            border: 2px solid #d1d5db;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
            background: white;
        }

        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 16px;
            transition: opacity 0.2s;
        }

        .clear-search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
            cursor: pointer;
            opacity: 0;
            transition: all 0.2s;
        }

        .clear-search-icon:hover {
            color: #6b7280;
        }

        .clear-search-icon.visible {
            opacity: 1;
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-height: 200px;
            overflow-y: auto;
            z-index: 100;
            display: none;
        }

        .search-suggestion-item {
            padding: 12px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s;
        }

        .search-suggestion-item:hover {
            background-color: #f0f9ff;
        }

        .search-suggestion-item:last-child {
            border-bottom: none;
        }

        .search-button {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-button:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2);
        }

        .cancel-search-btn {
            background: #6b7280;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cancel-search-btn:hover {
            background: #4b5563;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(107, 114, 128, 0.2);
        }

        .search-results-info {
            margin: 15px 0;
            padding: 12px 16px;
            background: #f0f9ff;
            border-radius: 10px;
            border-left: 4px solid #3b82f6;
            font-size: 14px;
        }

        .equipment-quantity {
            display: inline-block;
            background: #3b82f6;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 8px;
        }

        .station-equipment-count {
            background: #10b981;
            color: white;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            margin-left: 5px;
        }

        .total-quantity-box {
            background: linear-gradient(to bottom right, #e78f8f, #dd7070);
            border-radius: 12px;
            padding: 16px;
            border: 2px solid #dd7070;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            margin-bottom: 20px;
        }

        .total-quantity-value {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .total-quantity-label {
            font-size: 14px;
            color: #ede9fe;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 8px;
        }

        .stations-list-container {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .header-section {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }

        .main-content-container {
            display: flex;
            flex-direction: column;
            height: 100%;
            gap: 20px;
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

    <!-- Add Station Modal -->
    <div id="addStationModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4 modal-hidden">
<div class="bg-white rounded-2xl shadow-2xl w-full max-w-[900px] max-h-[90vh] overflow-y-auto border-2 border-gray-200 modal-content-hidden" id="addStationModalContent">
            <!-- Modal Header -->
            <div class="flex justify-between items-start p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-green-600"></i>ADD NEW STATION
                </h2>
                <button id="closeAddStationModal" class="text-gray-500 hover:text-red-500 transition-colors text-xl p-2 rounded-lg hover:bg-red-50">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body - Form -->
            <div class="p-6">
                <form action="{{ route('stations.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Station Name *</label>
                        <input type="text" name="name" id="name" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('name') }}" placeholder="e.g., Station 1">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-2">Station Code *</label>
                        <input type="text" name="code" id="code" required
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase"
                            value="{{ old('code') }}" placeholder="e.g., ST001" oninput="this.value = this.value.toUpperCase()">
                        <p class="text-xs text-gray-500 mt-1">Unique code for the station (will be converted to uppercase)</p>
                        @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                        <input type="text" name="location" id="location"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('location') }}" placeholder="e.g., City, Province">
                        @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Optional description of the station">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 pt-6 border-t">
                        <button type="button" id="cancelAddStation"
                            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Add Station
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex justify-center p-4 h-[calc(100vh-40px)] overflow-hidden mb-4">
        <div class="w-full max-w-[1280px] flex flex-col h-full main-content-container">
            <!-- Header & Search Section -->
            <div class="header-section">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent flex items-center">
                            <i class="fas fa-building mr-3 text-blue-600"></i>STATIONS
                        </h2>
                        <p class="text-sm text-gray-600 mt-1">Click on a station to view its inventory | Click on "Clear Search" to see all stations</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button id="openAddStationModal" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-4 py-2.5 rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-sm flex items-center gap-2">
                            <i class="fas fa-plus"></i>Add Station
                        </button>
                        
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2.5 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-sm flex items-center gap-2">
                            <i class="fas fa-arrow-left"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
                
                @if(session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-4 py-3 rounded-lg mb-4 shadow-md flex items-center text-sm animate-pulse">
                    <i class="fas fa-check-circle mr-3 text-green-600"></i>{{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 text-red-800 px-4 py-3 rounded-lg mb-4 shadow-md flex items-center text-sm">
                    <i class="fas fa-exclamation-circle mr-3 text-red-600"></i>{{ session('error') }}
                </div>
                @endif
                
                <!-- Total Quantity Box -->
                <div class="total-quantity-box">
                    <div class="total-quantity-value" id="totalQuantityValue">--</div>
                    <div class="total-quantity-label">
                        <i class="fas fa-boxes mr-2"></i>Total Equipment Quantity
                    </div>
                </div>
                
                <!-- Search Section -->
                <div class="search-container">
                    <div class="search-input-wrapper">
                        <div class="relative flex-grow">
                            <input type="text" id="equipmentSearch" class="search-input" placeholder="Search for equipment...">
                            <i class="fas fa-search search-icon" id="searchIcon"></i>
                            <i class="fas fa-times clear-search-icon" id="clearSearchInput"></i>
                            <div id="searchSuggestions" class="search-suggestions"></div>
                        </div>
                        <button id="searchButton" class="search-button">
                            <i class="fas fa-search"></i>Search
                        </button>
                        <button id="cancelSearch" class="cancel-search-btn">
                            <i class="fas fa-times"></i>Clear Search
                        </button>
                    </div>
                    <div id="searchResultsInfo" class="search-results-info" style="display: none;"></div>
                </div>
            </div>

            <!-- Stations List Container -->
            <div class="stations-list-container" id="stationsListContainer">
                @if($stations->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="stationsGrid">
                    @foreach($stations as $station)
                    <div class="station-card bg-gradient-to-br from-blue-50 to-indigo-100 rounded-lg p-4 hover:shadow-xl transition-all duration-300 border border-blue-200 hover:border-blue-400 relative" 
                         data-station-id="{{ $station->id }}"
                         data-items='@json($station->items)'
                         data-original-html="{{ htmlspecialchars($station->name) }}">
                        <a href="{{ route('stations.show', $station) }}" class="block">
                            <div class="flex items-start mb-3">
                                <div class="bg-blue-600 text-white rounded-full p-3 mr-3">
                                    <i class="fas fa-building text-lg"></i>
                                </div>
                                <div class="flex-1 grid grid-cols-1 gap-2">
                                    <div class="flex justify-between items-start">
                                        <h3 class="text-base font-bold text-gray-800">{{ $station->name }}</h3>
                                        <span class="bg-blue-600 text-white px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap station-item-count">
                                            {{ $station->items_count }} items
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-600">
                                        <p class="mb-1.5">
                                            <i class="fas fa-code mr-1.5"></i>Code: {{ $station->code }}
                                        </p>
                                        @if($station->location)
                                        <p class="mb-1.5">
                                            <i class="fas fa-map-marker-alt mr-1.5"></i>{{ $station->location }}
                                        </p>
                                        @endif
                                        @if($station->description)
                                        <p class="text-gray-500 line-clamp-2">{{ $station->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                        <form action="{{ route('stations.destroy', $station) }}" method="POST" class="mt-3"
                            onsubmit="return confirm('Are you sure you want to remove this station? This action cannot be undone if the station has items.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition-all duration-200 shadow text-xs w-full flex items-center justify-center gap-2">
                                <i class="fas fa-trash"></i>Remove Station
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
            
            // Initialize search functionality
            initSearch();
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

        // Add Station Modal functionality
        const addStationModal = document.getElementById('addStationModal');
        const addStationModalContent = document.getElementById('addStationModalContent');
        const openAddStationModalBtn = document.getElementById('openAddStationModal');
        const closeAddStationModalBtn = document.getElementById('closeAddStationModal');
        const cancelAddStationBtn = document.getElementById('cancelAddStation');

        function openAddStationModal() {
            addStationModal.classList.remove('hidden');
            setTimeout(() => {
                addStationModal.classList.remove('modal-hidden');
                addStationModal.classList.add('modal-visible');
                addStationModalContent.classList.remove('modal-content-hidden');
                addStationModalContent.classList.add('modal-content-visible');
            }, 10);
        }

        function closeAddStationModal() {
            addStationModal.classList.remove('modal-visible');
            addStationModal.classList.add('modal-hidden');
            addStationModalContent.classList.remove('modal-content-visible');
            addStationModalContent.classList.add('modal-content-hidden');
            
            setTimeout(() => {
                addStationModal.classList.add('hidden');
            }, 300);
        }

        openAddStationModalBtn.addEventListener('click', openAddStationModal);
        closeAddStationModalBtn.addEventListener('click', closeAddStationModal);
        cancelAddStationBtn.addEventListener('click', closeAddStationModal);

        // Close modal when clicking on background
        addStationModal.addEventListener('click', (e) => {
            if (e.target === addStationModal) {
                closeAddStationModal();
            }
        });

        // Search functionality
        function initSearch() {
            const searchInput = document.getElementById('equipmentSearch');
            const searchButton = document.getElementById('searchButton');
            const searchIcon = document.getElementById('searchIcon');
            const clearSearchInput = document.getElementById('clearSearchInput');
            const searchSuggestions = document.getElementById('searchSuggestions');
            const cancelSearchBtn = document.getElementById('cancelSearch');
            const searchResultsInfo = document.getElementById('searchResultsInfo');
            const stationsGrid = document.getElementById('stationsGrid');
            const totalQuantityValue = document.getElementById('totalQuantityValue');
            
            // Store original stations data
            const originalStations = Array.from(document.querySelectorAll('.station-card')).map(card => {
                return {
                    element: card,
                    name: card.querySelector('h3').textContent,
                    items: JSON.parse(card.getAttribute('data-items')),
                    originalCount: card.querySelector('.station-item-count').textContent,
                    originalHTML: card.getAttribute('data-original-html')
                };
            });
            
            // Extract all equipment names from stations for suggestions
            const allEquipment = [];
            originalStations.forEach(station => {
                station.items.forEach(item => {
                    if (!allEquipment.includes(item.name)) {
                        allEquipment.push(item.name);
                    }
                });
            });
            
            let currentSearchTerm = '';
            
            // Search input event handler for suggestions and icon swapping
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.trim();
                
                // Swap icons based on input
                if (searchTerm.length > 0) {
                    searchIcon.style.opacity = '0';
                    clearSearchInput.classList.add('visible');
                } else {
                    searchIcon.style.opacity = '1';
                    clearSearchInput.classList.remove('visible');
                }
                
                if (searchTerm.length === 0) {
                    searchSuggestions.style.display = 'none';
                    return;
                }
                
                // Show suggestions
                showSuggestions(searchTerm);
            });
            
            // Clear search input icon
            clearSearchInput.addEventListener('click', function() {
                searchInput.value = '';
                searchIcon.style.opacity = '1';
                clearSearchInput.classList.remove('visible');
                searchSuggestions.style.display = 'none';
                searchInput.focus();
            });
            
            // Search button click handler
            searchButton.addEventListener('click', function() {
                const searchTerm = searchInput.value.trim();
                if (searchTerm.length > 0) {
                    performSearch(searchTerm);
                }
            });
            
            // Enter key handler for search
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const searchTerm = searchInput.value.trim();
                    if (searchTerm.length > 0) {
                        performSearch(searchTerm);
                    }
                }
            });
            
            // Show suggestions based on input
            function showSuggestions(searchTerm) {
                const filteredEquipment = allEquipment.filter(equipment => 
                    equipment.toLowerCase().includes(searchTerm.toLowerCase())
                );
                
                if (filteredEquipment.length === 0) {
                    searchSuggestions.style.display = 'none';
                    return;
                }
                
                searchSuggestions.innerHTML = '';
                filteredEquipment.forEach(equipment => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.className = 'search-suggestion-item';
                    suggestionItem.textContent = equipment;
                    suggestionItem.addEventListener('click', function() {
                        // Only autofill the search field, don't perform search
                        searchInput.value = equipment;
                        searchIcon.style.opacity = '0';
                        clearSearchInput.classList.add('visible');
                        searchSuggestions.style.display = 'none';
                        searchInput.focus();
                    });
                    searchSuggestions.appendChild(suggestionItem);
                });
                
                searchSuggestions.style.display = 'block';
            }
            
            // Perform the actual search
            function performSearch(searchTerm) {
        currentSearchTerm = searchTerm;
        searchSuggestions.style.display = 'none';

        let totalQuantity = 0;
        let stationsWithEquipment = 0;

        // Clear current stations grid
        stationsGrid.innerHTML = '';

        // Show only stations that have the searched equipment
        originalStations.forEach(station => {
            const matchingItems = station.items.filter(item =>
                item.name.toLowerCase().includes(searchTerm.toLowerCase())
            );

            if (matchingItems.length > 0) {
                stationsWithEquipment++;

                // Calculate station total for the searched equipment
                let stationTotal = 0;
                matchingItems.forEach(item => {
                    stationTotal += item.quantity_on_hand || 1;
                });

                totalQuantity += stationTotal;

                // Clone the station card
                const cardClone = station.element.cloneNode(true);

                // Update the station's item count to show equipment quantity
                const countBadge = cardClone.querySelector('.station-item-count');
                if (countBadge) {
                    let itemQuantitiesHTML = '';
                    matchingItems.forEach(item => {
                        itemQuantitiesHTML += `
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-gray-800 font-semibold text-sm">${item.name}</span>
                                <span class="text-white font-semibold text-sm ml-2">${item.quantity_on_hand} ${item.unit}</span>
                            </div>
                        `;
                    });
                    countBadge.innerHTML = itemQuantitiesHTML;
                }

                stationsGrid.appendChild(cardClone);
            }
        });

        // Update total quantity display
        updateTotalQuantity(totalQuantity);

        // Show search results info
        searchResultsInfo.innerHTML = stationsWithEquipment > 0
            ? `<strong>Search Results:</strong> Found "${searchTerm}" in ${stationsWithEquipment} station(s)
               <span class="equipment-quantity">Total: ${totalQuantity}</span>`
            : `<strong>No Results:</strong> No stations found with equipment "${searchTerm}"`;

        searchResultsInfo.style.display = 'block';

        if (stationsWithEquipment === 0) {
            stationsGrid.innerHTML = `
                <div class="col-span-full text-center py-16">
                    <i class="fas fa-search text-6xl text-gray-400 mb-4"></i>
                    <p class="text-xl font-bold text-gray-600 mb-2">No stations found with "${searchTerm}"</p>
                    <p class="text-sm text-gray-500">Try searching for different equipment</p>
                </div>
            `;
        }
    }

    function resetSearch() {
        currentSearchTerm = '';
        searchInput.value = '';
        searchSuggestions.style.display = 'none';
        searchResultsInfo.style.display = 'none';
        stationsGrid.innerHTML = '';
        originalStations.forEach(station => {
            stationsGrid.appendChild(station.element.cloneNode(true));
        });
        updateTotalQuantity();
    }

    function updateTotalQuantity(quantity) {
        totalQuantityValue.textContent = quantity !== undefined ? quantity : '--';
    }
            
            // Cancel search button event
            cancelSearchBtn.addEventListener('click', resetSearch);
            
            // Hide suggestions when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                    searchSuggestions.style.display = 'none';
                }
            });
        }
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const badge = document.getElementById('itemsCountBadge');
    const searchForm = document.querySelector('form[action="{{ route('stations.show', $station) }}"]');
    const searchInput = searchForm.querySelector('input[name="search"]');

    // Initial badge: total items
    if (badge) {
        badge.textContent = allItems.length;
    }

    // Update badge on form submit
    searchForm.addEventListener('submit', function() {
        const query = searchInput.value.toLowerCase();
        const filteredItems = allItems.filter(item => item.name.toLowerCase().includes(query));

        if (badge) {
            badge.textContent = filteredItems.length;
        }
    });
});
</script>
</body>
</html>