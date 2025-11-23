<form action="{{ route('items.update', $item) }}" method="POST" class="space-y-6" id="editItemForm">
    @csrf
    @method('PUT')

    <!-- Basic Information -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Item Name *</label>
            <input type="text" name="name" id="name" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('name', $item->name) }}">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU *</label>
            <input type="text" name="sku" id="sku" required
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('sku', $item->sku) }}">
            @error('sku')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
        <textarea name="description" id="description" rows="3"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">{{ old('description', $item->description) }}</textarea>
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
            <option value="{{ $station->id }}" {{ old('station_id', $item->station_id) == $station->id ? 'selected' : '' }}>{{ $station->name }} ({{ $station->code }})</option>
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

    <!-- Pricing -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="unit_cost" class="block text-sm font-medium text-gray-700 mb-2">Unit Cost</label>
            <input type="number" name="unit_cost" id="unit_cost" step="0.01" min="0"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('unit_cost', $item->unit_cost) }}">
            @error('unit_cost')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="total_cost" class="block text-sm font-medium text-gray-700 mb-2">Total Cost (Auto-calculated)</label>
            <input type="number" name="total_cost" id="total_cost" step="0.01" min="0" readonly
                class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200"
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
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('quantity_on_hand', $item->quantity_on_hand) }}">
            @error('quantity_on_hand')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="reorder_level" class="block text-sm font-medium text-gray-700 mb-2">Reorder Level *</label>
            <input type="number" name="reorder_level" id="reorder_level" required min="0"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('reorder_level', $item->reorder_level) }}">
            @error('reorder_level')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="date_acquired" class="block text-sm font-medium text-gray-700 mb-2">Date Acquired</label>
            <input type="date" name="date_acquired" id="date_acquired"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                value="{{ old('date_acquired', $item->date_acquired ? $item->date_acquired->format('Y-m-d') : '') }}">
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
                <option value="serviceable" {{ old('condition', $item->condition ?? 'serviceable') == 'serviceable' ? 'selected' : '' }}>Serviceable</option>
                <option value="unserviceable" {{ old('condition', $item->condition) == 'unserviceable' ? 'selected' : '' }}>Unserviceable</option>
            </select>
            @error('condition')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
             <label for="date_expiry" class="block text-sm font-medium text-gray-700 mb-2">Date Expiry (dd/mm/yyyy)</label>
                                <input type="date" id="date_expiry" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('date_expiry', ($item->date_acquired && $item->life_span_years) ? $item->date_acquired->copy()->addYears($item->life_span_years)->format('Y-m-d') : '') }}">
                                <input type="hidden" name="life_span_years" id="life_span_years_hidden" value="{{ old('life_span_years', $item->life_span_years) }}">
                                <p class="text-xs text-gray-500 mt-1">Life span (years) will be computed automatically.</p>
            @error('life_span_years')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
        <button type="button" onclick="closeEditModal()"
            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all duration-200 font-semibold">
            Cancel
        </button>
        <button type="submit" name="apply" value="1"
                            class="px-6 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition-colors">
                            <i class="fas fa-check mr-2"></i>Apply
                        </button>
        <button type="submit"
            class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl font-semibold">
            <i class="fas fa-save mr-2"></i>Update Item
        </button>
    </div>
</form>

<script>
// Initialize the edit form calculations
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners for auto-calculation
    const quantityInput = document.getElementById('quantity_on_hand');
    const unitCostInput = document.getElementById('unit_cost');
    
    if (quantityInput && unitCostInput) {
        quantityInput.addEventListener('input', calculateEditTotalCost);
        unitCostInput.addEventListener('input', calculateEditTotalCost);
    }
    
    // Initial calculation
    calculateEditTotalCost();
});

function calculateEditTotalCost() {
    const quantity = parseFloat(document.getElementById('quantity_on_hand')?.value) || 0;
    const unitCost = parseFloat(document.getElementById('unit_cost')?.value) || 0;
    const totalCostInput = document.getElementById('total_cost');
    
    if (totalCostInput) {
        totalCostInput.value = (quantity * unitCost).toFixed(2);
    }
}

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
