@extends('layouts.dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Edit Vendor</h2>
        </div>

        <form method="POST" action="{{ route('vendors.update', $vendor) }}" class="bg-white rounded-lg shadow-sm p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input name="name" value="{{ old('name', $vendor->name) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Person</label>
                    <input name="contact_person" value="{{ old('contact_person', $vendor->contact_person) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input name="email" value="{{ old('email', $vendor->email) }}" type="email"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input name="phone" value="{{ old('phone', $vendor->phone) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">GSTIN</label>
                    <input name="gstin" value="{{ old('gstin', $vendor->gstin) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                        <option value="active" {{ $vendor->status=='active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $vendor->status=='inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mb-6 w-full">
                <label class="block text-sm font-medium text-gray-700">Address</label>
                <textarea name="address" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">{{ old('address', $vendor->address) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('vendors.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-md hover:bg-gray-50 text-sm font-medium border border-gray-300 shadow-sm transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium border border-transparent shadow-sm transition-colors">
                    Update Vendor
                </button>
            </div>
        </form>
    </div>
@endsection
