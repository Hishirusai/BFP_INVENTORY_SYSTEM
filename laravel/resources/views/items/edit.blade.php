<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item - BFP Inventory System</title>
    <link rel="icon" type="image/x-icon" href="/Img/Icon.png">
    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url('/Font/Montserrat-Bold.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        body {
            font-family: 'Montserrat', sans-se rif;
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
                    <i class="fas fa-cog mr-2"></i>Admin
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
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-4xl">
            <!-- Header Section -->
            <div class="p-6 border-b relative">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">EDIT ITEM</h2>
                        <p class="text-gray-600">Update the details for {{ $item->name }}</p>
                    </div>
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Form Section -->
            <div class="p-6">
                <form action="{{ route('items.update', $item) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Item Name *</label>
                            <input type="text" name="name" id="name" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('name', $item->name) }}">
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU *</label>
                            <input type="text" name="sku" id="sku" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('sku', $item->sku) }}">
                            @error('sku')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $item->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Supplier and Unit -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-2">Supplier</label>
                            <select name="supplier_id" id="supplier_id"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select a supplier</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id', $item->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('supplier_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                            <select name="unit" id="unit" required
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select unit</option>
                                @foreach($units as $unit)
                                <option value="{{ $unit }}" {{ old('unit', $item->unit) == $unit ? 'selected' : '' }}>{{ ucfirst($unit) }}</option>
                                @endforeach
                                <!-- Always include box as an option -->
                                @unless($units->contains('box'))
                                <option value="box" {{ old('unit', $item->unit) == 'box' ? 'selected' : '' }}>Box</option>
                                @endunless
                            </select>
                            @error('unit')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pricing -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="unit_cost" class="block text-sm font-medium text-gray-700 mb-2">Unit Cost</label>
                            <input type="number" name="unit_cost" id="unit_cost" step="0.01" min="0"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('unit_cost', $item->unit_cost) }}" oninput="calculateTotalCost()">
                            @error('unit_cost')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="total_cost" class="block text-sm font-medium text-gray-700 mb-2">Total Cost (Auto-calculated)</label>
                            <input type="number" name="total_cost" id="total_cost" step="0.01" min="0" readonly
                                class="w-full border border-gray-300 rounded-md px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('total_cost', $item->total_cost) }}">
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
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('quantity_on_hand', $item->quantity_on_hand) }}" oninput="calculateTotalCost()">
                            @error('quantity_on_hand')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="reorder_level" class="block text-sm font-medium text-gray-700 mb-2">Reorder Level *</label>
                            <input type="number" name="reorder_level" id="reorder_level" required min="0"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('reorder_level', $item->reorder_level) }}">
                            @error('reorder_level')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="date_acquired" class="block text-sm font-medium text-gray-700 mb-2">Date Acquired</label>
                            <input type="date" name="date_acquired" id="date_acquired"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="{{ old('date_acquired', $item->date_acquired ? $item->date_acquired->format('Y-m-d') : '') }}">
                            @error('date_acquired')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 pt-6 border-t">
                        <a href="{{ route('dashboard') }}"
                            class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            <i class="fas fa-save mr-2"></i>Update Item
                        </button>
                    </div>
                </form>
            </div>
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
            document.querySelectorAll('.carousel-image').forEach(img => img.classList.remove('active'));
            const currentImg = document.querySelector(`[data-image="${imageNumber}"]`);
            if (currentImg) currentImg.classList.add('active');
        }

        function nextImage() {
            currentImage = currentImage >= totalImages ? 1 : currentImage + 1;
            showImage(currentImage);
        }

        document.addEventListener('DOMContentLoaded', function() {
            showImage(1);
            setInterval(nextImage, 5000);
        });

        function calculateTotalCost() {
            const quantity = parseFloat(document.getElementById('quantity_on_hand').value) || 0;
            const unitCost = parseFloat(document.getElementById('unit_cost').value) || 0;
            const totalCost = quantity * unitCost;

            document.getElementById('total_cost').value = totalCost.toFixed(2);
        }

        // Calculate on page load if values exist
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotalCost();
        });
    </script>
</body>

</html>