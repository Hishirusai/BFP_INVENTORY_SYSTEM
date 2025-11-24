<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BFP INVENTORY SYSTEM</title>
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

        /* Custom Scrollbar - Hidden */
        .overflow-y-auto::-webkit-scrollbar {
            width: 0px;
            display: none;
        }

        .overflow-y-auto {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            display: none;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            display: none;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            display: none;
        }

        .compact-pagination,
        .compact-pagination * {
            font-size: 10px !important;
        }

        .compact-pagination nav {
            display: inline-block !important;
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .compact-pagination nav ul,
        .compact-pagination nav ul.pagination {
            display: inline-flex !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
            gap: 4px !important;
            align-items: baseline !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        .compact-pagination nav ul li,
        .compact-pagination nav ul.pagination li {
            margin: 0 !important;
            padding: 0 !important;
            list-style: none !important;
            display: inline-block !important;
        }

        .compact-pagination nav ul li,
        .compact-pagination nav ul.pagination li {
            background: transparent !important;
            border: none !important;
        }

        .compact-pagination nav ul li a,
        .compact-pagination nav ul li span,
        .compact-pagination nav ul.pagination li a,
        .compact-pagination nav ul.pagination li span,
        .compact-pagination a,
        .compact-pagination span {
            display: inline !important;
            padding: 0px !important;
            font-size: 10px !important;
            line-height: 1.2 !important;
            border-radius: 0 !important;
            text-decoration: none !important;
            border: none !important;
            color: #374151 !important;
            background-color: transparent !important;
            background: transparent !important;
            font-weight: normal !important;
            margin: 0 !important;
            box-sizing: border-box !important;
            vertical-align: baseline !important;
            box-shadow: none !important;
        }

        .compact-pagination nav ul li a,
        .compact-pagination a {
            color: #374151 !important;
        }

        .compact-pagination nav ul li a:hover,
        .compact-pagination nav ul.pagination li a:hover {
            color: #1f2937 !important;
            text-decoration: underline !important;
        }

        .compact-pagination nav ul li.active span,
        .compact-pagination nav ul.pagination li.active span {
            background-color: transparent !important;
            color: #374151 !important;
            padding: 0px !important;
            border-radius: 0 !important;
            font-weight: bold !important;
            text-decoration: none !important;
            border: none !important;
        }

        .compact-pagination nav ul li.disabled span,
        .compact-pagination nav ul.pagination li.disabled span {
            color: #9ca3af !important;
            background-color: transparent !important;
            background: transparent !important;
            cursor: not-allowed !important;
            opacity: 0.5 !important;
            padding: 0px !important;
            text-decoration: none !important;
            border: none !important;
        }

        .compact-pagination .pagination,
        .compact-pagination .page-item,
        .compact-pagination .page-link {
            background: transparent !important;
            border: none !important;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 10px !important;
            color: #374151 !important;
        }

        .compact-pagination .page-item.active .page-link {
            background: transparent !important;
            border: none !important;
            color: #374151 !important;
            font-weight: bold !important;
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

    <div class="flex justify-center p-2 h-[calc(100vh-40px)] overflow-hidden mb-4">
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl w-full max-w-[1280px] border border-white/20 flex flex-col h-full">
            <div class="flex-shrink-0 bg-white/98 backdrop-blur-md shadow-xl border-b border-gray-200 rounded-t-2xl">
                <div class="p-1.5">

                    <div class="flex items-center justify-between mb-1">
                        <h2 class="text-lg font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent flex items-center">
                            <i class="fas fa-building mr-2 text-blue-600"></i>MAIN CENTRAL STATION - Inventory Management
                        </h2>
                        <form method="POST" action="{{ route('logout') }}" class="whitespace-nowrap">
                            @csrf
                            <button type="submit" class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-3 py-1.5 rounded-lg hover:from-red-600 hover:to-rose-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-[11px]">
                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                            </button>
                        </form>
                    </div>

                    <div class="space-y-3">
                        <div class="grid grid-cols-3 gap-2">
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
                                <div class="text-[20px] font-bold text-white group-hover:scale-110 transition-transform duration-300">{{ $unserviceableItems ?? 0 }}</div>
                                <div class="text-[15px] text-red-100 font-semibold uppercase tracking-wide flex items-center justify-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>Unserviceable
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-1">
                            <button id="openAddItemModal" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-2 py-1.5 rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 whitespace-nowrap shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-xs">
    <i class="fas fa-plus mr-1.5"></i>Add Item
</button>
                            <button id="openTransferModal" class="bg-gradient-to-r from-orange-500 to-amber-600 text-white px-2 py-1.5 rounded-lg hover:from-orange-600 hover:to-amber-700 transition-all duration-200 whitespace-nowrap shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-xs">
    <i class="fas fa-exchange-alt mr-1.5"></i>Transfer Item
</button>
                            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-1 flex-1 min-w-[200px]">
                                <input type="text" name="search" placeholder="Search..."
                                    value="{{ request('search') }}"
                                    class="flex-1 border-2 border-gray-300 rounded-l-lg px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs transition-all duration-200 shadow-sm">
                                <select name="unit" class="border-2 border-gray-300 px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-xs transition-all duration-200 shadow-sm bg-white">
                                    <option value="">All Units</option>
                                    @foreach($units as $unit)
                                    <option value="{{ $unit }}" {{ request('unit') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                    @endforeach
                                    @unless($units->contains('box'))
                                    <option value="box" {{ request('unit') == 'box' ? 'selected' : '' }}>box</option>
                                    @endunless
                                </select>
                                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-2.5 py-1.5 rounded-r-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                            <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-gray-500 to-gray-600 text-white px-2.5 py-1.5 rounded-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-200 whitespace-nowrap shadow-lg hover:shadow-xl font-semibold text-xs">
                                <i class="fas fa-times mr-1.5"></i>Clear
                            </a>
                            <a href="{{ route('items.export') }}" class="bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-2.5 py-1.5 rounded-lg hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 whitespace-nowrap shadow-lg hover:shadow-xl hover:scale-105 font-semibold text-xs">
                                <i class="fas fa-download mr-1.5"></i>Export
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto overflow-y-auto flex-1 min-h-0">
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
                            <td class="px-3 py-2 text-gray-900 max-w-[200px] truncate">
                                <span class="cursor-pointer text-blue-600 hover:text-blue-800 hover:underline font-bold text-sm item-details-link transition-colors duration-200" data-item-id="{{ $item->id }}">
                                    {{ $item->name }}
                                </span>
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
                                    $condition = $item->condition ?? 'serviceable';
                                    $isExpiredByDate = false;
                                    if($item->life_span_years && $item->date_acquired) {
                                        $expirationDate = $item->date_acquired->copy()->addYears($item->life_span_years);
                                        $isExpiredByDate = now()->greaterThanOrEqualTo($expirationDate);
                                    }
                                    $isUnserviceable = ($condition === 'unserviceable') || $isExpiredByDate;
                                @endphp
                                <span class="px-3 py-1.5 rounded-full text-[9px] font-bold shadow-sm
                                    @if($isUnserviceable) bg-gradient-to-r from-red-400 to-rose-500 text-white
                                    @else bg-gradient-to-r from-green-400 to-emerald-500 text-white
                                    @endif">
                                    <i class="fas fa-circle text-[5px] mr-1"></i>{{ ucfirst($condition) }}
                                    @if($isExpiredByDate && $condition != 'unserviceable')
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
                            
                            <td class="px-3 py-2 text-[10px] whitespace-nowrap w-[140px]">
                                <div class="flex space-x-1.5">
                                    <button class="edit-item-btn bg-gradient-to-r from-blue-500 to-blue-600 text-white px-2.5 py-1.5 rounded-lg text-[9px] hover:from-blue-600 hover:to-blue-700 inline-flex items-center shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105 font-semibold" 
                                        data-item-id="{{ $item->id }}">
                                        <i class="fas fa-edit mr-1 text-[8px]"></i>Edit
                                    </button>
                                    <button type="button" onclick="openDeleteModal('{{ route('items.destroy', $item) }}')" 
                                        class="bg-gradient-to-r from-red-500 to-rose-600 text-white px-2.5 py-1.5 rounded-lg text-[9px] hover:from-red-600 hover:to-rose-700 inline-flex items-center shadow-md hover:shadow-lg transition-all duration-200 hover:scale-105 font-semibold">
                                        <i class="fas fa-trash mr-1 text-[8px]"></i>Delete
                                    </button>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-16 text-center bg-gradient-to-br from-gray-50 to-gray-100">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
                                    <p class="text-xl font-bold text-gray-600 mb-2">No items found</p>
                                    <p class="text-sm text-gray-500">Click "Add Item" to get started</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($items->hasPages())
            <div class="flex-shrink-0 p-1.5 border-t border-gray-200 bg-gradient-to-r from-gray-100 to-gray-50 compact-pagination rounded-b-2xl">

                <div class="flex items-center justify-between gap-2 h-full">
                    <div class="text-sm text-gray-800 font-bold whitespace-nowrap">
                        <i class="fas fa-list mr-1 text-blue-600 text-sm"></i>Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} results
                    </div>
                    <div class="compact-pagination flex items-center space-x-1">
                        @if ($items->onFirstPage())
                        <span class="relative inline-flex items-center px-2 py-1 text-base font-bold text-gray-500 bg-gray-300 border border-gray-400 cursor-default leading-4 rounded-md shadow">
                            &lt;
                        </span>
                        @else
                        <a href="{{ $items->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-1 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 border border-blue-800 leading-4 rounded-md hover:from-blue-700 hover:to-blue-800 shadow hover:shadow-md transition duration-200">
                            &lt;
                        </a>
                        @endif
                        
                        <div class="px-1.5 py-0.5 text-sm font-bold text-gray-700">
                            {{ $items->currentPage() }} of {{ $items->lastPage() }}
                        </div>

                        @if ($items->hasMorePages())
                        <a href="{{ $items->nextPageUrl() }}" class="relative -ml-px inline-flex items-center px-2 py-1 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 border border-blue-800 leading-4 rounded-md hover:from-blue-700 hover:to-blue-800 shadow hover:shadow-md transition duration-200">
                            &gt;
                        </a>
                        @else
                        <span class="relative -ml-px inline-flex items-center px-2 py-1 text-base font-bold text-gray-500 bg-gray-300 border border-gray-400 cursor-default leading-4 rounded-md shadow">
                            &gt;
                        </span>
                        @endif
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

    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden items-center justify-center z-50 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4 border-2 border-red-100 transform transition-all duration-300 scale-95" id="deleteModalContent">
            
            <div class="text-center mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900">Delete Item?</h3>
                <p class="text-sm text-gray-500 mt-2">Are you sure you want to delete this item? This action cannot be undone.</p>
            </div>
    
            <div class="flex justify-center space-x-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 font-semibold text-sm">
                    Cancel
                </button>
                
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-red-500 to-rose-600 text-white rounded-lg hover:from-red-600 hover:to-rose-700 transition-all duration-200 shadow-lg hover:shadow-xl font-semibold text-sm">
                        <i class="fas fa-trash-alt mr-1.5"></i>Yes, Delete It
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // 1. GLOBAL FUNCTIONS (Define these first so buttons can find them)

        // --- Delete Modal Functions ---
        function openDeleteModal(actionUrl) {
            const deleteModal = document.getElementById('deleteModal');
            const deleteModalContent = document.getElementById('deleteModalContent');
            const deleteForm = document.getElementById('deleteForm');

            if(deleteForm) deleteForm.action = actionUrl;

            if(deleteModal) {
                deleteModal.classList.remove('hidden');
                deleteModal.classList.add('flex');
                setTimeout(() => {
                    if(deleteModalContent) {
                        deleteModalContent.classList.remove('scale-95');
                        deleteModalContent.classList.add('scale-100');
                    }
                }, 10);
            }
        }

        function closeDeleteModal() {
            const deleteModal = document.getElementById('deleteModal');
            const deleteModalContent = document.getElementById('deleteModalContent');

            if(deleteModalContent) {
                deleteModalContent.classList.remove('scale-100');
                deleteModalContent.classList.add('scale-95');
            }
            
            setTimeout(() => {
                if(deleteModal) {
                    deleteModal.classList.add('hidden');
                    deleteModal.classList.remove('flex');
                }
            }, 300);
        }

        // --- Item Details Modal Functions ---
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
                        <div class="space-y-2">
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
            if(modalContent) {
                modalContent.classList.remove('scale-100');
                modalContent.classList.add('scale-95');
            }
            setTimeout(() => {
                if(modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            }, 300);
        }

        // 2. EVENT LISTENERS (Run after HTML is loaded)
        document.addEventListener('DOMContentLoaded', function() {

            // --- Close Modals on Outside Click ---
            const deleteModal = document.getElementById('deleteModal');
            if(deleteModal) {
                deleteModal.addEventListener('click', function(e) {
                    if (e.target === this) closeDeleteModal();
                });
            }

            const itemDetailsModal = document.getElementById('itemDetailsModal');
            if(itemDetailsModal) {
                itemDetailsModal.addEventListener('click', function(e) {
                    if (e.target === this) closeItemDetailsModal();
                });
            }

            // --- Toast Notifications ---
            document.querySelectorAll('.toast-message').forEach(toast => {
                const duration = parseInt(toast.getAttribute('data-duration')) || 5000;
                setTimeout(() => {
                    toast.classList.remove('opacity-0', 'translate-x-10');
                    toast.classList.add('opacity-100', 'translate-x-0');
                }, 50);
                setTimeout(() => {
                    toast.classList.remove('opacity-100', 'translate-x-0');
                    toast.classList.add('opacity-0', 'translate-x-10');
                    setTimeout(() => toast.remove(), 300);
                }, duration);
            });

            // --- Item Details Links ---
            document.querySelectorAll('.item-details-link').forEach(link => {
                link.addEventListener('click', function() {
                    const itemId = this.dataset.itemId;
                    showItemDetails(itemId);
                });
            });

            // --- Sidebar ---
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarClose = document.getElementById('sidebarClose');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => {
                    sidebar.classList.remove('translate-x-full');
                    sidebarOverlay.classList.remove('hidden');
                });
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', () => {
                    sidebar.classList.add('translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', () => {
                    sidebar.classList.add('translate-x-full');
                    sidebarOverlay.classList.add('hidden');
                });
            }

            // --- Carousel ---
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

            showImage(1);
            setInterval(nextImage, 5000);
        });
    </script>

     <!-- Add Item Modal -->
<div id="addItemModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden flex items-center justify-center z-50 transition-opacity duration-300 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-[900px] max-h-[90vh] overflow-y-auto border-2 border-gray-200 transform transition-all duration-300 scale-95" id="addItemModalContent">
        <!-- Modal Header -->
        <div class="flex justify-between items-start p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
            <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center">
                <i class="fas fa-plus-circle mr-2 text-blue-600"></i>ADD NEW ITEM
            </h2>
            <button id="closeAddItemModal" class="text-gray-500 hover:text-red-500 transition-colors text-xl p-2 rounded-lg hover:bg-red-50">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Modal Body (Form) -->
        <div class="p-6">
            <form action="{{ route('items.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Item Name *</label>
                        <input type="text" name="name" id="name" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            value="{{ old('name') }}">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">Product Code *</label>
                        <input type="text" name="sku" id="sku" required
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            value="{{ old('sku') }}">
                        @error('sku')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Station -->
                <div>
                    <label for="station_id" class="block text-sm font-medium text-gray-700 mb-2">Station</label>
                    <select name="station_id" id="station_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="">Main Central Station</option>
                        @foreach($stations as $station)
                        <option value="{{ $station->id }}" {{ old('station_id', $selectedStationId ?? null) == $station->id ? 'selected' : '' }}>{{ $station->name }} ({{ $station->code }})</option>
                        @endforeach
                    </select>
                    @error('station_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Unit -->
                <div>
                    <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                    <select name="unit" id="unit" required
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="">Select unit</option>
                        @foreach($units as $unit)
                        <option value="{{ $unit }}" {{ old('unit') == $unit ? 'selected' : '' }}>{{ ucfirst($unit) }}</option>
                        @endforeach
                        @unless($units->contains('box'))
                        <option value="box" {{ old('unit') == 'box' ? 'selected' : '' }}>Box</option>
                        @endunless
                    </select>
                    @error('unit')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pricing -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="unit_cost" class="block text-sm font-medium text-gray-700 mb-2">Unit Cost</label>
                        <input type="number" name="unit_cost" id="unit_cost" step="0.01" min="0"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            value="{{ old('unit_cost') }}" oninput="calculateTotalCost()">
                        @error('unit_cost')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="total_cost" class="block text-sm font-medium text-gray-700 mb-2">Total Cost (Auto-calculated)</label>
                        <input type="number" name="total_cost" id="total_cost" step="0.01" min="0" readonly
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                            value="{{ old('total_cost') }}">
                        @error('total_cost')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Inventory -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="quantity_on_hand" class="block text-sm font-medium text-gray-700 mb-2">Quantity on Hand *</label>
                        <input type="number" name="quantity_on_hand" id="quantity_on_hand" required min="0"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            value="{{ old('quantity_on_hand') }}" oninput="calculateTotalCost()">
                        @error('quantity_on_hand')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="reorder_level" class="block text-sm font-medium text-gray-700 mb-2">Reorder Level *</label>
                        <input type="number" name="reorder_level" id="reorder_level" required min="0"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            value="{{ old('reorder_level') }}">
                        @error('reorder_level')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_acquired" class="block text-sm font-medium text-gray-700 mb-2">Date Acquired</label>
                        <input type="date" name="date_acquired" id="date_acquired"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            value="{{ old('date_acquired') }}">
                        @error('date_acquired')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Condition and Date Expiry -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
                        <select name="condition" id="condition"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                            <option value="serviceable" {{ old('condition', 'serviceable') == 'serviceable' ? 'selected' : '' }}>Serviceable</option>
                            <option value="unserviceable" {{ old('condition') == 'unserviceable' ? 'selected' : '' }}>Unserviceable</option>
                        </select>
                        @error('condition')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date_expiry" class="block text-sm font-medium text-gray-700 mb-2">Date Expiry (dd/mm/yyyy)</label>
                                <input type="date" id="date_expiry" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('date_expiry', '') }}">
                                <input type="hidden" name="life_span_years" id="life_span_years_hidden" value="{{ old('life_span_years') }}">
                                <p class="text-xs text-gray-500 mt-1">Life span (years) will be computed automatically.</p>
                        @error('life_span_years')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" id="cancelAddItemModal"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 font-semibold">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl font-semibold">
                        <i class="fas fa-save mr-2"></i>Add Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END OF Add Item Modal -->

    <!-- Transfer Item Modal -->
<div id="transferModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden flex items-center justify-center z-50 transition-opacity duration-300 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-[900px] max-h-[90vh] overflow-y-auto border-2 border-gray-200 transform transition-all duration-300 scale-95" id="transferModalContent">
        
        <!-- Modal Header -->
        <div class="flex justify-between items-start p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
            <h2 class="text-2xl font-bold bg-gradient-to-r from-orange-600 to-amber-600 bg-clip-text text-transparent flex items-center">
                <i class="fas fa-exchange-alt mr-2 text-orange-600"></i>TRANSFER ITEM
            </h2>
            <button id="closeTransferModal" class="text-gray-500 hover:text-red-500 transition-colors text-xl p-2 rounded-lg hover:bg-red-50">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Form Section -->
        <div class="p-6">
            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 px-4 py-3 mb-4 rounded">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
            @endif

            <form action="{{ route('items.transfer.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="from_station_id" class="block text-sm font-medium text-gray-700 mb-2">From Station (Filter)</label>
                    <select id="from_station_id" onchange="filterItemsByStation()"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="">All Stations</option>
                        <option value="main" {{ ($fromStationId ?? '') === 'main' ? 'selected' : '' }}>Main Central Station</option>
                        @foreach($stations as $station)
                        <option value="{{ $station->id }}" {{ ($fromStationId ?? '') == $station->id ? 'selected' : '' }}>
                            {{ $station->name }} ({{ $station->code }})
                        </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Select the source station to filter items</p>
                </div>

                <div>
    <label for="item_id" class="block text-sm font-medium text-gray-700 mb-2">Select Item *</label>
    <div class="relative">
        <input type="text" id="item_search" placeholder="Search items..." 
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
            onkeyup="filterItemOptions()" onfocus="showSuggestions()" onblur="hideSuggestions()">
        <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
        
        <!-- Search Suggestions Dropdown -->
        <div id="searchSuggestions" class="absolute left-0 right-0 top-full mt-1 bg-white border border-gray-300 rounded-lg shadow-2xl max-h-64 overflow-y-auto hidden z-[100] transform transition-all duration-200">
            <!-- Suggestions will appear here dynamically -->
        </div>
    </div>
    
    <select name="item_id" id="item_id" required onchange="updateCurrentStation()" size="8"
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 mt-2 hidden">
        <option value="">Select an item</option>
        @foreach($allItemsForTransfer as $item)
        <option value="{{ $item->id }}" 
            data-station-id="{{ $item->station_id }}"
            data-station-name="{{ $item->station ? $item->station->name : 'Main Central Station' }}"
            data-quantity="{{ $item->quantity_on_hand }}"
            data-item-text="{{ strtolower($item->name . ' ' . $item->sku . ' ' . ($item->description ?? '')) }}"
            {{ ($selectedItemId ?? '') == $item->id ? 'selected' : '' }}>
            {{ $item->name }} ({{ $item->quantity_on_hand }} {{ $item->unit }})
            @if($item->station)
                - Current: {{ $item->station->name }}
            @else
                - Current: Main Central Station
            @endif
        </option>
        @endforeach
    </select>
    
    <div id="item_display" class="mt-2 border border-gray-300 rounded-lg max-h-64 overflow-y-auto hidden">
        <!-- Items will be displayed here -->
    </div>
    
    <div id="currentStationInfo" class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-lg hidden">
        <p class="text-sm text-blue-800">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Current Station:</strong> <span id="currentStationName">-</span>
        </p>
    </div>
    @error('item_id')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
    </div>

                <div>
                    <label for="to_station_id" class="block text-sm font-medium text-gray-700 mb-2">Transfer To Station *</label>
                    <select name="to_station_id" id="to_station_id" required onchange="validateTransfer()"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        <option value="">Select destination station</option>
                        <option value="main">Main Central Station</option>
                        @foreach($stations as $station)
                        <option value="{{ $station->id }}">{{ $station->name }} ({{ $station->code }})</option>
                        @endforeach
                    </select>
                    <div id="transferWarning" class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg hidden">
                        <p class="text-sm text-yellow-800">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span id="warningMessage">Cannot transfer to the same station.</span>
                        </p>
                    </div>
                    @error('to_station_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                    <input type="number" name="quantity" id="quantity" required min="1" oninput="validateQuantity()"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                        value="{{ old('quantity') }}">
                    <p class="text-xs text-gray-500 mt-1">
                        <span id="availableQuantity">Available: -</span>
                    </p>
                    <div id="quantityError" class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg hidden">
                        <p class="text-sm text-red-800">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            <span id="quantityErrorMessage">Insufficient quantity available.</span>
                        </p>
                    </div>
                    @error('quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">Reason (Optional)</label>
                    <textarea name="reason" id="reason" rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">{{ old('reason') }}</textarea>
                    @error('reason')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                 <!-- Form Actions -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <button type="button" id="cancelTransferModal"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 font-semibold">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-orange-500 to-amber-600 text-white rounded-lg hover:from-orange-600 hover:to-amber-700 transition-all duration-200 shadow-lg hover:shadow-xl font-semibold">
                        <i class="fas fa-exchange-alt mr-2"></i>Transfer Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END OF Transfer Item Modal -->

<!-- Edit Item Modal -->
<div id="editItemModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden flex items-center justify-center z-50 transition-opacity duration-300 p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-[900px] max-h-[90vh] overflow-y-auto border-2 border-gray-200 transform transition-all duration-300 scale-95" id="editItemModalContent">
        
        <!-- Modal Header -->
        <div class="flex justify-between items-start p-6 border-b border-gray-200 sticky top-0 bg-white z-10">
            <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent flex items-center">
                <i class="fas fa-edit mr-2 text-blue-600"></i>EDIT ITEM
            </h2>
            <button id="closeEditModal" class="text-gray-500 hover:text-red-500 transition-colors text-xl p-2 rounded-lg hover:bg-red-50">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Form Display Area -->
        <div class="p-6">
            <div id="editFormDisplay">
                <!-- Edit form will be loaded here via AJAX -->
            </div>
        </div>
    </div>
</div>
<!-- END OF Edit Item Modal -->

    <script>
   // Updated Modal Script with animations
const openModalBtn = document.getElementById('openAddItemModal');
const modal = document.getElementById('addItemModal');
const modalContent = document.getElementById('addItemModalContent');
const closeModalBtn = document.getElementById('closeAddItemModal');
const cancelBtn = document.getElementById('cancelAddItemModal');

openModalBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
    setTimeout(() => {
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');
    }, 10);
});

function closeAddItemModal() {
    modalContent.classList.remove('scale-100');
    modalContent.classList.add('scale-95');
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

closeModalBtn.addEventListener('click', closeAddItemModal);
cancelBtn.addEventListener('click', closeAddItemModal);

// Close modal on clicking outside
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        closeAddItemModal();
    }
});

// Transfer Modal Script
const openTransferModalBtn = document.getElementById('openTransferModal');
const transferModal = document.getElementById('transferModal');
const transferModalContent = document.getElementById('transferModalContent');
const closeTransferModalBtn = document.getElementById('closeTransferModal');
const cancelTransferModalBtn = document.getElementById('cancelTransferModal');

openTransferModalBtn.addEventListener('click', () => {
    transferModal.classList.remove('hidden');
    setTimeout(() => {
        transferModalContent.classList.remove('scale-95');
        transferModalContent.classList.add('scale-100');
    }, 10);
});

function closeTransferModal() {
    transferModalContent.classList.remove('scale-100');
    transferModalContent.classList.add('scale-95');
    setTimeout(() => {
        transferModal.classList.add('hidden');
    }, 300);
}

closeTransferModalBtn.addEventListener('click', closeTransferModal);
cancelTransferModalBtn.addEventListener('click', closeTransferModal);

// Close modal on clicking outside
transferModal.addEventListener('click', (e) => {
    if (e.target === transferModal) {
        closeTransferModal();
    }
});

// Search suggestions javascript
let searchTimeout;

function showSuggestions() {
    const searchTerm = document.getElementById('item_search').value.toLowerCase();
    if (searchTerm.length > 0) {
        renderSearchSuggestions(searchTerm);
    }
}

function hideSuggestions() {
    // Small delay to allow click events to register
    setTimeout(() => {
        document.getElementById('searchSuggestions').classList.add('hidden');
    }, 200);
}

function renderSearchSuggestions(searchTerm = '') {
    const suggestionsContainer = document.getElementById('searchSuggestions');
    const fromStationId = document.getElementById('from_station_id').value;
    
    // Filter items for suggestions (more lenient filtering)
    let suggestedItems = allItems.filter(item => {
        if (item.value === '') return false;
        
        // Filter by station
        if (fromStationId === 'main') {
            if (item.stationId !== '' && item.stationId !== null) return false;
        } else if (fromStationId !== '') {
            if (item.stationId !== fromStationId) return false;
        }
        
        // More lenient search - match any part of the text
        if (searchTerm) {
            return item.text.toLowerCase().includes(searchTerm) || 
                   item.searchText.includes(searchTerm);
        }
        
        return false;
    }).slice(0, 8); // Limit to 8 suggestions like YouTube

    if (suggestedItems.length === 0) {
        suggestionsContainer.classList.add('hidden');
        return;
    }

    // Render suggestions
    suggestionsContainer.innerHTML = suggestedItems.map(item => `
        <div class="p-3 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0 transition-colors duration-150 suggestion-item"
             onclick="selectSuggestion('${item.value}', '${item.stationId}', '${item.stationName}', '${item.quantity}')">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <div class="font-semibold text-gray-800 text-sm mb-1">${item.text.split(' - Current:')[0]}</div>
                    <div class="text-xs text-gray-500 flex items-center">
                        <i class="fas fa-map-marker-alt mr-1 text-xs"></i>
                        ${item.stationName}
                    </div>
                </div>
                <div class="text-xs font-semibold bg-blue-100 text-blue-800 px-2 py-1 rounded-full ml-2">
                    ${item.quantity} in stock
                </div>
            </div>
        </div>
    `).join('');

    suggestionsContainer.classList.remove('hidden');
}

function selectSuggestion(itemId, stationId, stationName, quantity) {
    // Fill the search input with the selected item name
    const selectedItem = allItems.find(item => item.value === itemId);
    if (selectedItem) {
        document.getElementById('item_search').value = selectedItem.text.split(' - Current:')[0];
    }
    
    // Select the item
    selectItem(itemId, stationId, stationName, quantity);
    
    // Hide suggestions
    document.getElementById('searchSuggestions').classList.add('hidden');
    
    // Also hide the main item display
    document.getElementById('item_display').classList.add('hidden');
}

// Enhanced filterItemOptions function
function filterItemOptions() {
    const searchTerm = document.getElementById('item_search').value.toLowerCase();
    
    // Clear previous timeout
    if (searchTimeout) {
        clearTimeout(searchTimeout);
    }
    
    // Show suggestions after a short delay (like YouTube)
    searchTimeout = setTimeout(() => {
        if (searchTerm.length > 0) {
            renderSearchSuggestions(searchTerm);
            // Also update the main display
            renderItemDisplay(searchTerm);
        } else {
            document.getElementById('searchSuggestions').classList.add('hidden');
            renderItemDisplay('');
        }
    }, 300); // 300ms delay like YouTube
}

// Enhanced selectItem function
function selectItem(itemId, stationId, stationName, quantity) {
    document.getElementById('item_id').value = itemId;
    document.getElementById('currentStationName').textContent = stationName;
    document.getElementById('availableQuantity').textContent = `Available: ${quantity}`;
    document.getElementById('currentStationInfo').classList.remove('hidden');
    
    // Update search field with selected item name
    const selectedItem = allItems.find(item => item.value === itemId);
    if (selectedItem) {
        document.getElementById('item_search').value = selectedItem.text.split(' - Current:')[0];
    }
    
    validateTransfer();
    validateQuantity();
    
    // Hide both displays when item is selected
    document.getElementById('searchSuggestions').classList.add('hidden');
    document.getElementById('item_display').classList.add('hidden');
}

// Keyboard navigation for suggestions
document.getElementById('item_search').addEventListener('keydown', function(e) {
    const suggestions = document.querySelectorAll('.suggestion-item');
    const activeSuggestion = document.querySelector('.suggestion-item.bg-blue-100');
    
    if (e.key === 'ArrowDown') {
        e.preventDefault();
        if (suggestions.length > 0) {
            if (!activeSuggestion) {
                suggestions[0].classList.add('bg-blue-100', 'text-white');
            } else {
                const next = activeSuggestion.nextElementSibling;
                if (next) {
                    activeSuggestion.classList.remove('bg-blue-100', 'text-white');
                    next.classList.add('bg-blue-100', 'text-white');
                }
            }
        }
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        if (suggestions.length > 0) {
            if (!activeSuggestion) {
                suggestions[suggestions.length - 1].classList.add('bg-blue-100', 'text-white');
            } else {
                const prev = activeSuggestion.previousElementSibling;
                if (prev) {
                    activeSuggestion.classList.remove('bg-blue-100', 'text-white');
                    prev.classList.add('bg-blue-100', 'text-white');
                }
            }
        }
    } else if (e.key === 'Enter') {
        e.preventDefault();
        if (activeSuggestion) {
            activeSuggestion.click();
        }
    }
});

// Transfer Modal Data Initialization
let allItems = [];

// Initialize transfer modal data when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing transfer modal data...');
    
    // Get the item select element
    const itemSelect = document.getElementById('item_id');
    
    if (itemSelect) {
        console.log('Found item select with', itemSelect.options.length, 'options');
        
        // Populate allItems array from the select options
        allItems = Array.from(itemSelect.options)
            .filter(option => option.value !== '') // Remove empty option
            .map(option => {
                return {
                    value: option.value,
                    text: option.textContent.trim(),
                    stationId: option.getAttribute('data-station-id') || '',
                    stationName: option.getAttribute('data-station-name') || 'Main Central Station',
                    quantity: option.getAttribute('data-quantity') || '0',
                    searchText: (option.getAttribute('data-item-text') || option.textContent).toLowerCase()
                };
            });
        
        console.log('Loaded', allItems.length, 'items into allItems array');
        
        // Test if we have data
        if (allItems.length > 0) {
            console.log('First item:', allItems[0]);
        } else {
            console.warn('No items found in allItems array');
        }
    } else {
        console.error('item_id select element not found!');
    }
    
    // Also add the missing functions from the original transfer.blade.php
    initializeTransferFunctions();
});

// Add the missing transfer functions
function initializeTransferFunctions() {
    // These functions are referenced in your HTML but not defined
    window.filterItemsByStation = function() {
        const fromStationId = document.getElementById('from_station_id').value;
        console.log('Filtering by station:', fromStationId);
        filterItemOptions(); // Refresh the suggestions
    };

    window.renderItemDisplay = function(searchTerm = '') {
        // This function is referenced but you might not need it with the new suggestions
        console.log('renderItemDisplay called with:', searchTerm);
    };

    window.updateCurrentStation = function() {
        const itemSelect = document.getElementById('item_id');
        const selectedValue = itemSelect.value;
        const selectedOption = Array.from(itemSelect.options).find(opt => opt.value === selectedValue);
        
        if (selectedOption && selectedOption.value) {
            const stationName = selectedOption.getAttribute('data-station-name');
            const quantity = selectedOption.getAttribute('data-quantity');
            document.getElementById('currentStationName').textContent = stationName;
            document.getElementById('availableQuantity').textContent = `Available: ${quantity}`;
            document.getElementById('currentStationInfo').classList.remove('hidden');
            validateTransfer();
            validateQuantity();
        } else {
            document.getElementById('currentStationInfo').classList.add('hidden');
            document.getElementById('availableQuantity').textContent = 'Available: -';
        }
    };

    window.validateTransfer = function() {
        const itemId = document.getElementById('item_id').value;
        const toStationSelect = document.getElementById('to_station_id');
        const transferWarning = document.getElementById('transferWarning');
        const warningMessage = document.getElementById('warningMessage');
        
        if (!itemId || !toStationSelect.value) {
            transferWarning.classList.add('hidden');
            return;
        }

        // Get selected item data
        const selectedItem = allItems.find(item => item.value === itemId);
        if (!selectedItem) {
            transferWarning.classList.add('hidden');
            return;
        }

        const fromStationId = selectedItem.stationId || '';
        const toStationId = toStationSelect.value;
        const fromStationName = selectedItem.stationName || 'Main Central Station';

        // Convert "main" to empty string for comparison
        const normalizedFromStationId = fromStationId === '' || fromStationId === null ? 'main' : fromStationId;
        const normalizedToStationId = toStationId === 'main' ? 'main' : toStationId;

        if (normalizedFromStationId === normalizedToStationId) {
            warningMessage.textContent = `Cannot transfer to the same station (${fromStationName}). Please select a different destination.`;
            transferWarning.classList.remove('hidden');
        } else {
            transferWarning.classList.add('hidden');
        }
    };

    window.validateQuantity = function() {
        const itemId = document.getElementById('item_id').value;
        const quantityInput = document.getElementById('quantity');
        const quantityError = document.getElementById('quantityError');
        const quantityErrorMessage = document.getElementById('quantityErrorMessage');
        
        if (!itemId) {
            quantityError.classList.add('hidden');
            return;
        }

        const selectedItem = allItems.find(item => item.value === itemId);
        if (!selectedItem) {
            quantityError.classList.add('hidden');
            return;
        }

        const availableQty = parseInt(selectedItem.quantity) || 0;
        const requestedQty = parseInt(quantityInput.value) || 0;

        if (requestedQty > availableQty) {
            quantityErrorMessage.textContent = `Insufficient quantity. Available: ${availableQty}, Requested: ${requestedQty}`;
            quantityError.classList.remove('hidden');
        } else {
            quantityError.classList.add('hidden');
        }
    };
}

// Total cost calculation for Add Item modal
function calculateTotalCost() {
    const quantity = parseFloat(document.getElementById('quantity_on_hand').value) || 0;
    const unitCost = parseFloat(document.getElementById('unit_cost').value) || 0;
    document.getElementById('total_cost').value = (quantity * unitCost).toFixed(2);
}

// Initialize total cost calculation when DOM loads
document.addEventListener('DOMContentLoaded', function() {
    calculateTotalCost();
});

// Edit Modal Functions - Complete Version
window.openEditModal = function(itemId) {
    console.log('🟢 openEditModal called with itemId:', itemId);
    
    const modal = document.getElementById('editItemModal');
    const modalContent = document.getElementById('editItemModalContent');
    const formDisplay = document.getElementById('editFormDisplay');
    
    if (!modal) {
        console.error('❌ Edit modal not found!');
        return;
    }
    
    // Show loading state
    formDisplay.innerHTML = `
        <div class="flex justify-center items-center py-12">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
            <span class="ml-3 text-gray-600">Loading item data...</span>
        </div>
    `;
    
    // Show modal with animation
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => {
        if (modalContent) {
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }
    }, 10);
    
    // Load the edit form via AJAX
    fetch(`/items/${itemId}/edit-form`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.text();
        })
        .then(html => {
            formDisplay.innerHTML = html;
            
            // Re-initialize any JavaScript for the loaded form
            initializeEditForm();
        })
        .catch(error => {
            console.error('Error loading edit form:', error);
            formDisplay.innerHTML = `
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">Error loading item data. Please try again.</p>
                        </div>
                    </div>
                </div>
            `;
        });
};

window.closeEditModal = function() {
    const modal = document.getElementById('editItemModal');
    const modalContent = document.getElementById('editItemModalContent');
    
    if (!modal) return;
    
    if (modalContent) {
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
    }
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
};

// Initialize edit form functionality
function initializeEditForm() {
    // Recalculate total cost when quantities change
    const quantityInput = document.getElementById('quantity_on_hand');
    const unitCostInput = document.getElementById('unit_cost');
    
    if (quantityInput && unitCostInput) {
        quantityInput.addEventListener('input', calculateEditTotalCost);
        unitCostInput.addEventListener('input', calculateEditTotalCost);
    }
    
    // Initialize total cost calculation
    calculateEditTotalCost();
}

function calculateEditTotalCost() {
    const quantity = parseFloat(document.getElementById('quantity_on_hand')?.value) || 0;
    const unitCost = parseFloat(document.getElementById('unit_cost')?.value) || 0;
    const totalCostInput = document.getElementById('total_cost');
    
    if (totalCostInput) {
        totalCostInput.value = (quantity * unitCost).toFixed(2);
    }
}

// Event listeners for edit buttons
document.addEventListener('DOMContentLoaded', function() {
    console.log('🔧 Setting up edit button event listeners...');
    
    // Edit buttons
    document.querySelectorAll('.edit-item-btn').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            console.log('✏️ Edit button clicked for item:', itemId);
            window.openEditModal(itemId);
        });
    });
    
    // Close modal button
    const closeEditModalBtn = document.getElementById('closeEditModal');
    if (closeEditModalBtn) {
        closeEditModalBtn.addEventListener('click', window.closeEditModal);
    }
    
    // Close modal when clicking outside
    const editModal = document.getElementById('editItemModal');
    if (editModal) {
        editModal.addEventListener('click', function(e) {
            if (e.target === this) {
                window.closeEditModal();
            }
        });
    }
    
    console.log('✅ Edit modal setup complete');
});

        // Compute life_span_years from date_acquired and date_expiry before submit
        function computeLifeSpanYearsForForm() {
            const dateAcqEl = document.getElementById('date_acquired');
            const dateExpEl = document.getElementById('date_expiry');
            const hiddenEl = document.getElementById('life_span_years_hidden');
            if (!hiddenEl || !dateExpEl) return;

            const dateExp = dateExpEl.value;
            const dateAcq = dateAcqEl ? dateAcqEl.value : '';

            if (dateExp && dateAcq) {
                const acq = new Date(dateAcq);
                const exp = new Date(dateExp);
                let years = exp.getFullYear() - acq.getFullYear();
                if (exp.getMonth() < acq.getMonth() || (exp.getMonth() === acq.getMonth() && exp.getDate() < acq.getDate())) {
                    years--;
                }
                hiddenEl.value = Math.max(0, years);
            } else if (dateExp && !dateAcq) {
                const today = new Date();
                const exp = new Date(dateExp);
                let years = exp.getFullYear() - today.getFullYear();
                if (exp.getMonth() < today.getMonth() || (exp.getMonth() === today.getMonth() && exp.getDate() < today.getDate())) {
                    years--;
                }
                hiddenEl.value = Math.max(0, years);
            } else {
                hiddenEl.value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const dateExpEl = document.getElementById('date_expiry');
            const dateAcqEl = document.getElementById('date_acquired');
            if (dateExpEl) dateExpEl.addEventListener('change', computeLifeSpanYearsForForm);
            if (dateAcqEl) dateAcqEl.addEventListener('change', computeLifeSpanYearsForForm);
            const form = document.querySelector('form');
            if (form) form.addEventListener('submit', computeLifeSpanYearsForForm);
        });

</script>

    </div>
</div>

    
</body>
</html>
