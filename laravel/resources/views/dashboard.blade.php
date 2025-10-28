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
    </style>
</head>

<body class="min-h-screen">
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
                <a href="{{ route('admin.settings') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded">
                    <i class="fas fa-truck mr-2"></i>Suppliers
                </a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded">
                    <i class="fas fa-users mr-2"></i>Users
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

                <h2 class="text-3xl font-bold text-gray-800 mb-6">BFP INVENTORY MANAGEMENT</h2>

                <!-- Two-column layout: Left for reports (empty), Right for stats -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Left side - Recent Reports -->
                    <div class="bg-gray-50 rounded-lg p-6 border-2 border-dashed border-gray-300 min-h-48 shadow-lg">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-700">Recent Reports</h3>
                            <a href="{{ route('reports.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                View All <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        @if($recentReports->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentReports as $report)
                            <div class="flex items-center justify-between p-3 bg-white rounded border">
                                <div>
                                    <div class="font-medium text-sm">{{ $report->item->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $report->created_at->format('M d, Y H:i') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-sm">
                                        @if($report->type === 'addition')
                                        <span class="text-green-600">+{{ $report->quantity_change }}</span>
                                        @else
                                        <span class="text-red-600">-{{ $report->quantity_change }}</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500">{{ ucfirst($report->type) }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500 text-sm">No recent reports available.</p>
                        @endif
                    </div>

                    <!-- Right side - 2x2 grid of stats cards -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 rounded-lg p-6 border border-blue-200 shadow-lg flex flex-col items-center justify-center min-h-32">
                            <div class="text-4xl font-bold text-blue-600">{{ $itemsCount }}</div>
                            <div class="text-sm text-gray-600">Total Items</div>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-6 border border-yellow-200 shadow-lg flex flex-col items-center justify-center min-h-32">
                            <div class="text-4xl font-bold text-yellow-600">{{ $lowStockItems }}</div>
                            <div class="text-sm text-gray-600">Low Stock</div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-6 border border-green-200 shadow-lg flex flex-col items-center justify-center min-h-32">
                            <div class="text-4xl font-bold text-green-600">{{ $suppliersCount }}</div>
                            <div class="text-sm text-gray-600">Suppliers</div>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-6 border border-purple-200 shadow-lg flex flex-col items-center justify-center min-h-32">
                            <div class="text-4xl font-bold text-purple-600">₱{{ number_format($totalInventoryValue, 2) }}</div>
                            <div class="text-sm text-gray-600">Total Value</div>
                        </div>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="flex flex-wrap justify-between items-center gap-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('items.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition-colors whitespace-nowrap">
                            <i class="fas fa-plus mr-2"></i>Add Item
                        </a>
                        <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap gap-2">
                            <input type="text" name="search" placeholder="Search for an item"
                                value="{{ request('search') }}"
                                class="border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            <select name="unit" class="border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                <option value="">All Units</option>
                                @foreach($units as $unit)
                                <option value="{{ $unit }}" {{ request('unit') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                                <!-- Always include box as an option -->
                                @unless($units->contains('box'))
                                <option value="box" {{ request('unit') == 'box' ? 'selected' : '' }}>box</option>
                                @endunless
                            </select>
                            <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded-r hover:bg-blue-700 transition-colors">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('dashboard') }}" class="bg-gray-600 text-white px-3 py-2 rounded hover:bg-gray-700 transition-colors whitespace-nowrap">
                                <i class="fas fa-times mr-2"></i>Clear
                            </a>
                        </form>
                        <a href="{{ route('items.export') }}" class="bg-purple-600 text-white px-3 py-2 rounded hover:bg-purple-700 transition-colors whitespace-nowrap">
                            <i class="fas fa-download mr-2"></i>Export
                        </a>
                        <a href="{{ route('admin.settings') }}" class="bg-gray-600 text-white px-3 py-2 rounded hover:bg-gray-700 transition-colors whitespace-nowrap">
                            <i class="fas fa-truck mr-2"></i>Supplier
                        </a>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="whitespace-nowrap">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-3 py-2 rounded hover:bg-red-700 transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Inventory Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-blue-600 text-white">
                            <th class="px-6 py-3 text-left text-sm font-medium">Item Name</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Date Acquired</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Quantity</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Unit Cost</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Total Cost</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Supplier</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Item Status</th>
                            <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50">
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <span class="cursor-pointer text-blue-600 hover:underline item-details-link" data-item-id="{{ $item->id }}">{{ $item->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $item->date_acquired ? $item->date_acquired->format('M d, Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $item->quantity_on_hand }} {{ $item->unit }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                ₱{{ number_format($item->unit_cost, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                ₱{{ number_format($item->total_cost, 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $item->supplier ? $item->supplier->name : 'No Supplier' }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    @if($item->status == 'active') bg-green-100 text-green-800
                                    @elseif($item->status == 'low_stock') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex space-x-1">
                                    <a href="{{ route('items.edit', $item) }}" class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 inline-flex items-center">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 inline-flex items-center">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-box-open text-4xl mb-4"></i>
                                <p class="text-lg">No items found</p>
                                <p class="text-sm">Click "Add Item" to get started</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($items->hasPages())
            <div class="p-6 border-t">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} results
                    </div>
                    <div>
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
            @endif

            <!-- Stats Footer - Removed since we moved it to the top -->
        </div>
    </div>

    <!-- Item Details Modal -->
    <div id="itemDetailsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Item Details</h3>
                <button onclick="closeItemDetailsModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="itemDetailsContent">
                <!-- Item details will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        // Add event listeners to item details links
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.item-details-link').forEach(link => {
                link.addEventListener('click', function() {
                    const itemId = this.dataset.itemId;
                    showItemDetails(itemId);
                });
            });
        });

        function showItemDetails(itemId) {
            // Fetch the item details via AJAX
            fetch(`/items/${itemId}/json`)
                .then(response => response.json())
                .then(item => {
                    const content = `
                        <div class="space-y-3">
                            <div>
                                <h4 class="font-bold text-gray-700">Item Name</h4>
                                <p class="text-gray-900">${item.name}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">SKU</h4>
                                <p class="text-gray-900">${item.sku}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Description</h4>
                                <p class="text-gray-900">${item.description || 'N/A'}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Date Acquired</h4>
                                <p class="text-gray-900">${item.date_acquired ? new Date(item.date_acquired).toLocaleDateString() : 'N/A'}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Quantity on Hand</h4>
                                <p class="text-gray-900">${item.quantity_on_hand} ${item.unit}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Unit Cost</h4>
                                <p class="text-gray-900">₱${parseFloat(item.unit_cost).toFixed(2)}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Total Cost</h4>
                                <p class="text-gray-900">₱${parseFloat(item.total_cost).toFixed(2)}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Reorder Level</h4>
                                <p class="text-gray-900">${item.reorder_level}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Status</h4>
                                <p class="text-gray-900">${item.status}</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-700">Supplier</h4>
                                <p class="text-gray-900">${item.supplier ? item.supplier.name : 'N/A'}</p>
                            </div>
                        </div>
                    `;
                    document.getElementById('itemDetailsContent').innerHTML = content;
                    document.getElementById('itemDetailsModal').classList.remove('hidden');
                    document.getElementById('itemDetailsModal').classList.add('flex');
                })
                .catch(error => {
                    console.error('Error fetching item details:', error);
                    // Fallback to showing basic info from the table data
                    alert('Error loading item details. Please try again.');
                });
        }

        function closeItemDetailsModal() {
            document.getElementById('itemDetailsModal').classList.add('hidden');
            document.getElementById('itemDetailsModal').classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('itemDetailsModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeItemDetailsModal();
            }
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