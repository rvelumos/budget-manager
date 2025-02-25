<form action="{{ $action }}" method="POST">
    @csrf
    @isset($method)
        @method($method)
    @endisset

    <div class="mb-4">
        <label for="amount" class="block text-gray-700 font-bold">{{ __('messages.amount') }}</label>
        <input
            type="number"
            id="amount"
            name="amount"
            class="w-full p-2 border rounded"
            value="{{ old('amount', $budget->amount ?? '') }}"
            required
        >
        @error('amount')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4 flex items-center justify-between">
        <label for="category_id" class="text-gray-700 font-bold">{{ __('messages.category') }}</label>
        <select
            id="category_id"
            name="category_id"
            class="w-1/2 p-2 border rounded text-right"
        >
            <option value="">None</option>
            @foreach ($categories as $category)
                <option
                    value="{{ $category->id }}"
                    @selected(old('category_id', $budget->category_id ?? '') == $category->id)
                >
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    @error('category_id')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    <div class="mb-4 flex items-center justify-between">
        <label for="period" class="text-gray-700 font-bold">{{ __('messages.period') }}</label>
        <select
            id="period"
            name="period"
            class="w-1/2 p-2 border rounded text-right"
        >
            <option value="weekly" @selected(old('period', $budget->period ?? '') == 'weekly')>Weekly</option>
            <option value="monthly" @selected(old('period', $budget->period ?? '') == 'monthly')>Monthly</option>
            <option value="yearly" @selected(old('period', $budget->period ?? '') == 'yearly')>Yearly</option>
        </select>
    </div>

    @error('period')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    <div class="mb-4 flex items-center justify-between">
        <label for="start_date" class="text-gray-700 font-bold">{{ __('messages.start_date') }}</label>
        <input
            type="date"
            id="start_date"
            name="start_date"
            class="w-1/2 p-2 border rounded text-right"
            value="{{ old('start_date', $budget->start_date ?? '') }}"
            required
        >
    </div>

    @error('start_date')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    <div class="mb-4 flex items-center justify-between">
        <label for="end_date" class="text-gray-700 font-bold">{{ __('messages.end_date') }}</label>
        <input
            type="date"
            id="end_date"
            name="end_date"
            class="w-1/2 p-2 border rounded text-right"
            value="{{ old('end_date', $budget->end_date ?? '') }}"
        >
    </div>

    @error('end_date')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror

    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
        {{ $buttonText }}
    </button>
</form>
