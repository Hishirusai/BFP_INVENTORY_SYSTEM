<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $station->name }} - BFP Inventory System</title>
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

        /* Compact Pagination Styles */
        .compact-pagination,
        .compact-pagination * {
            font-size: 10px !important;
        }
        .compact-pagination .page-link {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            color: #374151 !important;
        }
    </style>
</head>

<body class="h-screen overflow-hidden">

    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2 pointer-events-none">
        @if(session('success'))
            <div class="toast-message bg-gradient-to-r from-green-500 to-emerald-600 text-white p-4 rounded-lg shadow-xl border-2 border-green-400 transform transition-all duration-300 opacity-0 translate-x-10 pointer-events-auto" data-duration="8000">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-lg"></i>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="toast-message bg-gradient-to-r from-red-500 to-rose-600 text-white p-4 rounded-lg shadow-xl border-2 border-red-400 transform transition-all duration-300 opacity-0 translate-x-10 pointer-events-auto" data-duration="8000">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-lg"></i>
                    <span class="font-bold text-sm">{{ session('error') }}</span>
                </div>
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

    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

    <div class="flex justify-center p-2 h-auto max-h-[calc(100vh-40px)] overflow-hidden mb-4">
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl w-full max-w-[1280px] border border-white/20 flex flex-col h-auto max-h-full">
            
            <div class="flex-shrink-0 bg-white/98 backdrop-blur-md shadow-xl border-b border-gray-200 rounded-t-2xl">
                <div class="p-1.5">
                    <div class="flex items-center justify-between mb-1">
                        <h2 class="text-lg font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent flex items-center">
                            <i class="fas fa-building mr-2 text-blue-600"></i>{{ $station->name }} - Inventory Management
                        </h2>
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-3 py-1.5 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-[11px]">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                </a>
                    </div>

                    <div class="space-y-3">
                        <div class="grid grid-cols-3 gap-1">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-1 border border-blue-400 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex flex-col items-center justify-center group text-center">
                                <div class="text-[20px] font-bold text-white group-hover:scale-110 transition-transform duration-300">{{ $itemsCount }}</div>
                                <div class="text-[15px] text-blue-100 font-semibold uppercase tracking-wide flex items-center justify-center mt-1">
                                    <i class="fas fa-box mr-1"></i>Items
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg p-1 border border-purple-400 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex flex-col items-center justify-center group text-center">
                                <div class="text-[20px] font-bold text-white group-hover:scale-110 transition-transform duration-330 truncate">₱{{ number_format($totalInventoryValue, 0) }}</div>
                                <div class="text-[15px] text-purple-100 font-semibold uppercase tracking-wide flex items-center justify-center mt-1">
                                    <i class="fas fa-dollar-sign mr-1"></i>Total Value
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-lg p-1 border border-red-400 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 flex flex-col items-center justify-center group text-center">
                                <div class="text-[20px] font-bold text-white group-hover:scale-110 transition-transform duration-300">{{ $unserviceableItems }}</div>
                                <div class="text-[15px] text-red-100 font-semibold uppercase tracking-wide flex items-center justify-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>Unserviceable
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-1">
                            <a href="{{ route('items.create', ['station_id' => $station->id]) }}" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-2 py-1.5 rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 whitespace-nowrap shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-xs">
                                <i class="fas fa-plus mr-1.5"></i>Add Item
                            </a>
                            <form method="GET" action="{{ route('stations.show', $station) }}" class="flex flex-wrap gap-1 flex-1 min-w-[200px]">
                                <input type="text" name="search" placeholder="Search..."
                                    value="{{ request('search') }}"
                                    class="flex-1 border-2 border-gray-300 rounded-l-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs transition-all duration-200 shadow-sm">
                                <select name="unit" class="border-2 border-gray-300 px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs transition-all duration-200 shadow-sm bg-white">
                                    <option value="">All Units</option>
                                    @foreach($units as $unit)
                                    <option value="{{ $unit }}" {{ request('unit') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-2.5 py-1.5 rounded-r-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                            <a href="{{ route('stations.show', $station) }}" class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-2.5 py-1.5 rounded-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-200 whitespace-nowrap shadow-lg hover:shadow-xl font-semibold text-xs">
                                <i class="fas fa-times mr-1.5"></i>Clear
                            </a>
                            <a href="{{ route('items.export', ['station_id' => $station->id]) }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-2.5 py-1.5 rounded-lg hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 whitespace-nowrap shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-xs">
                                <i class="fas fa-download mr-1.5"></i>Export
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto overflow-y-auto flex-initial min-h-0">
                <table class="w-full min-w-[1200px]">
                    <thead class="sticky top-0 z-10">
            <tr class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-600 text-white shadow-lg">
                <th class="px-3 py-2 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                    <i class="fas fa-tag mr-1.5"></i>Item Name
                </th>
                <th class="px-3 py-2 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                    <i class="fas fa-calendar mr-1.5"></i>Date Acquired
                </th>
                <th class="px-3 py-2 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                    <i class="fas fa-boxes mr-1.5"></i>Quantity
                </th>
                <th class="px-3 py-2 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                    <i class="fas fa-dollar-sign mr-1.5"></i>Unit Cost
                </th>
                <th class="px-3 py-2 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                    <i class="fas fa-money-bill-wave mr-1.5"></i>Total Cost
                </th>
                <th class="px-3 py-2 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                    <i class="fas fa-check-circle mr-1.5"></i>Condition
                </th>
                <th class="px-3 py-2 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                    <i class="fas fa-clock mr-1.5"></i>Date Expiry
                </th>
                <th class="px-3 py-2 text-left text-xs font-bold uppercase tracking-wider whitespace-nowrap">
                    <i class="fas fa-cog mr-1.5"></i>Actions
                </th>
            </tr>
            </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-colors duration-200 border-b border-gray-100">
                            <td class="px-3 py-2 text-gray-900">
                                <span class="cursor-pointer text-blue-600 hover:text-blue-800 hover:underline font-bold text-sm item-details-link transition-colors duration-200" data-item-id="{{ $item->id }}">{{ $item->name }}</span>
                            </td>
                            <td class="px-3 py-2 text-[10px] text-gray-700 whitespace-nowrap">
                                <i class="fas fa-calendar-alt mr-2 text-gray-400 text-[9px]"></i>{{ $item->date_acquired ? $item->date_acquired->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-3 py-2 text-[10px] text-gray-900 font-semibold whitespace-nowrap">
                                <i class="fas fa-cubes mr-2 text-blue-500 text-[9px]"></i>{{ $item->quantity_on_hand }} {{ $item->unit }}
                            </td>
                            <td class="px-3 py-2 text-[10px] text-gray-900 font-bold text-green-700 whitespace-nowrap">
                                <i class="fas fa-coins mr-1 text-[9px]"></i>₱{{ number_format($item->unit_cost, 2) }}
                            </td>
                            <td class="px-3 py-2 text-[10px] text-gray-900 font-bold text-purple-700 whitespace-nowrap">
                                <i class="fas fa-money-bill mr-1 text-[9px]"></i>₱{{ number_format($item->total_cost, 2) }}
                            </td>

                            <td class="px-3 py-2 text-[10px] whitespace-nowrap">
                                @php
                                $isUnserviceable = ($item->condition == 'unserviceable') || ($item->isUnserviceableByLifespan());
                                @endphp
                                <span class="px-3 py-1.5 rounded-full text-[9px] font-bold shadow-sm
                                    @if($isUnserviceable) bg-gradient-to-r from-red-400 to-rose-500 text-white
                                    @else bg-gradient-to-r from-green-400 to-emerald-500 text-white
                                    @endif">
                                    <i class="fas fa-circle text-[5px] mr-1"></i>{{ ucfirst($item->condition ?? 'serviceable') }}
                                    @if($isUnserviceable && $item->condition != 'unserviceable')
                                    <i class="fas fa-exclamation-triangle ml-1" title="Unserviceable due to date expiry"></i>
                                    @endif
                                </span>
                            </td>
                            <td class="px-3 py-2 text-[10px] whitespace-nowrap">
    @if($item->life_span_years && $item->date_acquired)
        @php
            // Calculate the expiration date
            $expirationDate = $item->date_acquired->copy()->addYears($item->life_span_years);
            // Check if expired for styling purposes
            $isExpired = now()->greaterThanOrEqualTo($expirationDate);
        @endphp

        <div class="flex items-center">
            {{-- Display the actual Expiration Date --}}
            <span class="font-bold {{ $isExpired ? 'text-red-600' : 'text-gray-700' }}">
                <i class="fas fa-hourglass-end mr-1.5 text-[9px] {{ $isExpired ? 'text-red-500' : 'text-gray-400' }}"></i>
                {{ $expirationDate->format('M d, Y') }}
            </span>
        </div>
    @else
        <span class="text-gray-400 text-[9px]">N/A</span>
    @endif
</td>
                            <td class="px-3 py-2 text-[10px] whitespace-nowrap">
                                <div class="flex space-x-1.5">
                                    <a href="{{ route('items.edit', ['item' => $item->id, 'redirect_to' => route('stations.show', $station->id)]) }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-2.5 py-1.5 rounded-lg text-[9px] hover:from-blue-600 hover:to-blue-700 inline-flex items-center shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105 font-semibold">
                                        <i class="fas fa-edit mr-1 text-[8px]"></i>Edit
                                    </a>
                                    <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-2.5 py-1.5 rounded-lg text-[9px] hover:from-red-600 hover:to-rose-700 inline-flex items-center shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105 font-semibold">
                                            <i class="fas fa-trash mr-1 text-[8px]"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-16 text-center bg-gradient-to-br from-gray-50 to-gray-100">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
                                    <p class="text-xl font-bold text-gray-600 mb-2">No items found in this station</p>
                                    <p class="text-sm text-gray-500">Items will appear here once assigned to this station</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($items->hasPages())
            <div class="flex-shrink-0 p-1.5 border-t border-gray-200 bg-gradient-to-r from-gray-100 to-gray-50 compact-pagination mt-auto rounded-b-xl">
                <div class="flex items-center justify-between gap-2 h-full">
                    <div class="text-sm text-gray-800 font-bold whitespace-nowrap">
                        <i class="fas fa-list mr-1 text-blue-600 text-sm"></i>Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} results
                    </div>
                    <div class="compact-pagination flex items-center space-x-1">
                        {{ $items->links('pagination::simple-tailwind') }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div id="itemDetailsModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-md mx-4 border-2 border-gray-200 transform transition-all duration-300 scale-95" id="modalContent">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                <h3 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>Item Details
                </h3>
                <button onclick="closeItemDetailsModal()" class="text-gray-500 hover:text-red-600 hover:bg-red-50 p-2 rounded-lg transition-all duration-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="itemDetailsContent" class="max-h-[70vh] overflow-y-auto">
                </div>
        </div>
    </div>

    <script>
        // --- Pop Notification Functionality (Added) ---
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toast-message').forEach(toast => {
                const duration = parseInt(toast.getAttribute('data-duration')) || 5000;
                setTimeout(() => {
                    toast.classList.remove('opacity-0', 'translate-x-10');
                    toast.classList.add('opacity-100', 'translate-x-0');
                }, 50); 

                setTimeout(() => {
                    toast.classList.remove('opacity-100', 'translate-x-0');
                    toast.classList.add('opacity-0', 'translate-x-10');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, duration); 
            });
        });

        // Item details modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.item-details-link').forEach(link => {
                link.addEventListener('click', function() {
                    const itemId = this.dataset.itemId;
                    showItemDetails(itemId);
                });
            });
        });

        function showItemDetails(itemId) {
            fetch(`/items/${itemId}/json`)
                .then(response => response.json())
                .then(item => {
                    const statusColors = {
                        'active': 'from-green-400 to-emerald-500',
                        'low_stock': 'from-yellow-400 to-orange-500',
                        'inactive': 'from-red-400 to-rose-500'
                    };
                    const statusColor = statusColors[item.status] || 'from-gray-400 to-gray-500';

                    const content = `
                        <div class="space-y-4">
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border-l-4 border-blue-500">
                                <h4 class="font-bold text-gray-700 mb-2 flex items-center"><i class="fas fa-tag mr-2 text-blue-600"></i>Item Name</h4>
                                <p class="text-gray-900 font-semibold text-lg">${item.name}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-bold text-gray-700 mb-2 flex items-center"><i class="fas fa-barcode mr-2 text-gray-600"></i>SKU</h4>
                                <p class="text-gray-900">${item.sku}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-bold text-gray-700 mb-2 flex items-center"><i class="fas fa-align-left mr-2 text-gray-600"></i>Description</h4>
                                <p class="text-gray-900">${item.description || 'N/A'}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-bold text-gray-700 mb-2 flex items-center"><i class="fas fa-calendar-alt mr-2 text-gray-600"></i>Date Acquired</h4>
                                <p class="text-gray-900">${item.date_acquired ? new Date(item.date_acquired).toLocaleDateString() : 'N/A'}</p>
                            </div>
                            <div class="bg-gradient-to-r from-blue-50 to-cyan-50 p-4 rounded-lg border-l-4 border-blue-500">
                                <h4 class="font-bold text-gray-700 mb-2 flex items-center"><i class="fas fa-boxes mr-2 text-blue-600"></i>Quantity on Hand</h4>
                                <p class="text-gray-900 font-bold text-xl">${item.quantity_on_hand} ${item.unit}</p>
                            </div>
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-lg border-l-4 border-green-500">
                                <h4 class="font-bold text-gray-700 mb-2 flex items-center"><i class="fas fa-coins mr-2 text-green-600"></i>Unit Cost</h4>
                                <p class="text-gray-900 font-bold text-xl text-green-700">₱${parseFloat(item.unit_cost).toFixed(2)}</p>
                            </div>
                            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 p-4 rounded-lg border-l-4 border-purple-500">
                                <h4 class="font-bold text-gray-700 mb-2 flex items-center"><i class="fas fa-money-bill-wave mr-2 text-purple-600"></i>Total Cost</h4>
                                <p class="text-gray-900 font-bold text-xl text-purple-700">₱${parseFloat(item.total_cost).toFixed(2)}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-bold text-gray-700 mb-2 flex items-center"><i class="fas fa-exclamation-circle mr-2 text-gray-600"></i>Reorder Level</h4>
                                <p class="text-gray-900 font-semibold">${item.reorder_level}</p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="font-bold text-gray-700 mb-2 flex items-center"><i class="fas fa-info-circle mr-2 text-gray-600"></i>Status</h4>
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-bold text-white bg-gradient-to-r ${statusColor} shadow-lg">${item.status.charAt(0).toUpperCase() + item.status.slice(1).replace('_', ' ')}</span>
                            </div>
                        </div>
                    `;
                    document.getElementById('itemDetailsContent').innerHTML = content;
                    const modal = document.getElementById('itemDetailsModal');
                    const modalContent = document.getElementById('modalContent');
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                    setTimeout(() => {
                        modalContent.classList.remove('scale-95');
                        modalContent.classList.add('scale-100');
                    }, 10);
                })
                .catch(error => {
                    console.error('Error fetching item details:', error);
                    alert('Error loading item details. Please try again.');
                });
        }

        function closeItemDetailsModal() {
            const modal = document.getElementById('itemDetailsModal');
            const modalContent = document.getElementById('modalContent');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        document.getElementById('itemDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeItemDetailsModal();
            }
        });

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