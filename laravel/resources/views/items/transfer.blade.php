<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Item - BFP Inventory System</title>
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
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Top Navigation Bar -->
    <div class="sticky top-0 z-20 bg-gradient-to-r from-red-800 via-red-700 to-red-800 text-white p-4 flex justify-between items-center shadow-xl border-b-2 border-red-900">
        <div class="flex items-center space-x-4">
            <img src="/Img/Icon.png" alt="BFP Icon" class="h-10 w-10 rounded-lg shadow-lg ring-2 ring-white/20">
            <h1 class="text-2xl font-bold tracking-wide">BFP INVENTORY SYSTEM</h1>
        </div>
        <div class="flex items-center space-x-4">
            <i id="sidebarToggle" class="fas fa-bars text-white text-xl cursor-pointer hover:text-blue-200 hover:scale-110 transition-transform duration-200 p-2 rounded-lg hover:bg-white/10"></i>
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
    <div class="flex justify-center p-8">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-[1790px]">
            <!-- Header Section -->
            <div class="p-6 border-b">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">TRANSFER ITEM</h2>
                <p class="text-gray-600">Transfer items between stations</p>
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
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Stations</option>
                            <option value="main" {{ $fromStationId === 'main' ? 'selected' : '' }}>Main Central Station</option>
                            @foreach($stations as $station)
                            <option value="{{ $station->id }}" {{ $fromStationId == $station->id ? 'selected' : '' }}>
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
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                onkeyup="filterItemOptions()">
                            <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                        </div>
                        <select name="item_id" id="item_id" required onchange="updateCurrentStation()" size="8"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 mt-2 hidden">
                            <option value="">Select an item</option>
                            @foreach($items as $item)
                            <option value="{{ $item->id }}" 
                                data-station-id="{{ $item->station_id }}"
                                data-station-name="{{ $item->station ? $item->station->name : 'Main Central Station' }}"
                                data-quantity="{{ $item->quantity_on_hand }}"
                                data-item-text="{{ strtolower($item->name . ' ' . $item->sku . ' ' . ($item->description ?? '')) }}"
                                {{ $selectedItemId == $item->id ? 'selected' : '' }}>
                                {{ $item->name }} ({{ $item->quantity_on_hand }} {{ $item->unit }})
                                @if($item->station)
                                    - Current: {{ $item->station->name }}
                                @else
                                    - Current: Main Central Station
                                @endif
                            </option>
                            @endforeach
                        </select>
                        <div id="item_display" class="mt-2 border border-gray-300 rounded-md max-h-64 overflow-y-auto hidden">
                            <!-- Items will be displayed here -->
                        </div>
                        <div id="currentStationInfo" class="mt-2 p-3 bg-blue-50 border border-blue-200 rounded-md hidden">
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
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select destination station</option>
                            <option value="main">Main Central Station</option>
                            @foreach($stations as $station)
                            <option value="{{ $station->id }}">{{ $station->name }} ({{ $station->code }})</option>
                            @endforeach
                        </select>
                        <div id="transferWarning" class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-md hidden">
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
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('quantity') }}">
                        <p class="text-xs text-gray-500 mt-1">
                            <span id="availableQuantity">Available: -</span>
                        </p>
                        <div id="quantityError" class="mt-2 p-3 bg-red-50 border border-red-200 rounded-md hidden">
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
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('reason') }}</textarea>
                        @error('reason')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 pt-6 border-t">
                        <a href="{{ route('dashboard') }}"
                            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 transition-colors">
                            <i class="fas fa-exchange-alt mr-2"></i>Transfer Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let allItems = [];
        
        // Store all items data
        document.addEventListener('DOMContentLoaded', function() {
            const itemSelect = document.getElementById('item_id');
            allItems = Array.from(itemSelect.options).map(option => ({
                value: option.value,
                text: option.textContent,
                stationId: option.getAttribute('data-station-id'),
                stationName: option.getAttribute('data-station-name'),
                quantity: option.getAttribute('data-quantity'),
                searchText: option.getAttribute('data-item-text')
            }));
            renderItemDisplay();
            updateCurrentStation();
        });

        function filterItemsByStation() {
            const fromStationId = document.getElementById('from_station_id').value;
            const url = new URL(window.location.href);
            url.searchParams.set('from_station_id', fromStationId);
            window.location.href = url.toString();
        }

        function filterItemOptions() {
            const searchTerm = document.getElementById('item_search').value.toLowerCase();
            renderItemDisplay(searchTerm);
        }

        function renderItemDisplay(searchTerm = '') {
            const itemDisplay = document.getElementById('item_display');
            const fromStationId = document.getElementById('from_station_id').value;
            
            // Filter items
            let filteredItems = allItems.filter(item => {
                if (item.value === '') return false;
                
                // Filter by station
                if (fromStationId === 'main') {
                    if (item.stationId !== '' && item.stationId !== null) return false;
                } else if (fromStationId !== '') {
                    if (item.stationId !== fromStationId) return false;
                }
                
                // Filter by search term
                if (searchTerm) {
                    return item.searchText.includes(searchTerm) || item.text.toLowerCase().includes(searchTerm);
                }
                
                return true;
            });

            // Render items
            if (filteredItems.length === 0) {
                itemDisplay.innerHTML = '<div class="p-4 text-center text-gray-500">No items found</div>';
            } else {
                itemDisplay.innerHTML = filteredItems.map(item => `
                    <div class="p-3 border-b border-gray-200 hover:bg-blue-50 cursor-pointer item-option" 
                         data-item-id="${item.value}"
                         data-station-id="${item.stationId}"
                         data-station-name="${item.stationName}"
                         data-quantity="${item.quantity}"
                         onclick="selectItem('${item.value}', '${item.stationId}', '${item.stationName}', '${item.quantity}')">
                        <div class="font-semibold text-gray-800">${item.text}</div>
                    </div>
                `).join('');
            }
            
            itemDisplay.classList.remove('hidden');
        }

        function selectItem(itemId, stationId, stationName, quantity) {
            document.getElementById('item_id').value = itemId;
            document.getElementById('currentStationName').textContent = stationName;
            document.getElementById('availableQuantity').textContent = `Available: ${quantity}`;
            document.getElementById('currentStationInfo').classList.remove('hidden');
            validateTransfer();
            validateQuantity();
        }

        function updateCurrentStation() {
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
        }

        function validateTransfer() {
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
        }

        function validateQuantity() {
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
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCurrentStation();
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

