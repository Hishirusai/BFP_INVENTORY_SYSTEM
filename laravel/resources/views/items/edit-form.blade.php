<form action="{{ route('items.update', $item) }}" method="POST" class="space-y-6" id="editItemForm">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Item Name *</label>
            <input type="text" name="name" id="edit_name" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('name', $item->name) }}">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">Product Code *</label>
            <input type="text" name="sku" id="edit_sku" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('sku', $item->sku) }}">
            @error('sku')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
        <textarea name="description" id="edit_description" rows="3"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">{{ old('description', $item->description) }}</textarea>
        @error('description')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="station_id" class="block text-sm font-medium text-gray-700 mb-2">Station</label>
        <select name="station_id" id="edit_station_id"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            <option value="">Main Central Station</option>
            @foreach($stations as $station)
            <option value="{{ $station->id }}" {{ old('station_id', $item->station_id) == $station->id ? 'selected' : '' }}>{{ $station->name }} ({{ $station->code }})</option>
            @endforeach
        </select>
        @error('station_id')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
        <select name="unit" id="edit_unit" required
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
            <option value="">Select unit</option>
            @foreach($units as $unit)
            <option value="{{ $unit }}" {{ old('unit', $item->unit) == $unit ? 'selected' : '' }}>{{ ucfirst($unit) }}</option>
            @endforeach
            @unless($units->contains('box'))
            <option value="box" {{ old('unit', $item->unit) == 'box' ? 'selected' : '' }}>Box</option>
            @endunless
        </select>
        @error('unit')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="unit_cost" class="block text-sm font-medium text-gray-700 mb-2">Unit Cost</label>
            <input type="number" name="unit_cost" id="edit_unit_cost" step="0.01" min="0"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('unit_cost', $item->unit_cost) }}"
                oninput="calculateEditTotalCost()" 
                onchange="calculateEditTotalCost()">
            @error('unit_cost')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="total_cost" class="block text-sm font-medium text-gray-700 mb-2">Total Cost (Auto-calculated)</label>
            <input type="number" name="total_cost" id="edit_total_cost" step="0.01" min="0" readonly
                class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
                value="{{ old('total_cost', $item->total_cost) }}">
            @error('total_cost')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label for="quantity_on_hand" class="block text-sm font-medium text-gray-700 mb-2">Quantity on Hand *</label>
            <input type="number" name="quantity_on_hand" id="edit_quantity_on_hand" required min="0"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('quantity_on_hand', $item->quantity_on_hand) }}"
                oninput="calculateEditTotalCost()" 
                onchange="calculateEditTotalCost()">
            @error('quantity_on_hand')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="reorder_level" class="block text-sm font-medium text-gray-700 mb-2">Reorder Level *</label>
            <input type="number" name="reorder_level" id="edit_reorder_level" required min="0"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('reorder_level', $item->reorder_level) }}">
            @error('reorder_level')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="date_acquired" class="block text-sm font-medium text-gray-700 mb-2">Date Acquired</label>
            <input type="date" name="date_acquired" id="edit_date_acquired"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('date_acquired', $item->date_acquired ? $item->date_acquired->format('Y-m-d') : '') }}">
            @error('date_acquired')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
            <select name="condition" id="edit_condition"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                <option value="serviceable" {{ old('condition', $item->condition ?? 'serviceable') == 'serviceable' ? 'selected' : '' }}>Serviceable</option>
                <option value="unserviceable" {{ old('condition', $item->condition) == 'unserviceable' ? 'selected' : '' }}>Unserviceable</option>
            </select>
            @error('condition')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="edit_expiry_date" class="block text-sm font-medium text-gray-700 mb-2">Date Expiry (dd/mm/yyyy)</label>
            <input type="date" name="expiry_date" id="edit_expiry_date" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                value="{{ old('expiry_date', $item->expiry_date ? \Carbon\Carbon::parse($item->expiry_date)->format('Y-m-d') : '') }}">
            
            @error('expiry_date')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
        <button type="button" onclick="closeEditModal()"
            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 font-semibold">
            Cancel
        </button>
        <button type="submit"
            class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl font-semibold">
            <i class="fas fa-save mr-2"></i>Update Item
        </button>
    </div>
</form>

<script>
// Cleaned up Script - Only handles Cost Calculation now
function initializeEditFormCalculations() {
    // Add event listeners for auto-calculation
    const quantityInput = document.getElementById('edit_quantity_on_hand');
    const unitCostInput = document.getElementById('edit_unit_cost');
    
    console.log('Initializing edit form calculations...');
    
    if (quantityInput) {
        quantityInput.addEventListener('input', calculateEditTotalCost);
        quantityInput.addEventListener('change', calculateEditTotalCost);
    }
    
    if (unitCostInput) {
        unitCostInput.addEventListener('input', calculateEditTotalCost);
        unitCostInput.addEventListener('change', calculateEditTotalCost);
    }
    
    // Initial calculation
    calculateEditTotalCost();
}

function calculateEditTotalCost() {
    const quantity = parseFloat(document.getElementById('edit_quantity_on_hand')?.value) || 0;
    const unitCost = parseFloat(document.getElementById('edit_unit_cost')?.value) || 0;
    const totalCostInput = document.getElementById('edit_total_cost');
    
    if (totalCostInput) {
        const totalCost = (quantity * unitCost).toFixed(2);
        totalCostInput.value = totalCost;
    }
}

// Initialize everything when the modal content loads
document.addEventListener('DOMContentLoaded', function() {
    initializeEditFormCalculations();
    
    const form = document.getElementById('editItemForm');
    if (form) {
        form.addEventListener('submit', function() {
            calculateEditTotalCost(); // Ensure math is right before submit
        });
    }
});

// Also initialize with a delay for modal loading
setTimeout(initializeEditFormCalculations, 100);
</script>