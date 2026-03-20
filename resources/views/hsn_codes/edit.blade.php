@extends('layouts.dashboard')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Edit HSN Code</h2>
        </div>

        <form method="POST" action="{{ route('hsn-codes.update', $hsn_code) }}" class="bg-white rounded-lg shadow-sm p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">HSN Code</label>
                    <input name="code" value="{{ old('code', $hsn_code->code) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">GST Rate (%)</label>
                    <input name="gst_rate" type="number" step="0.01" value="{{ old('gst_rate', $hsn_code->gst_rate) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                </div>
            </div>

            <div class="mb-6 w-full">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">{{ old('description', $hsn_code->description) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('hsn-codes.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-md hover:bg-gray-50 text-sm font-medium border border-gray-300 shadow-sm transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium border border-transparent shadow-sm transition-colors">
                    Update HSN Code
                </button>
            </div>
        </form>
    </div>
@endsection
