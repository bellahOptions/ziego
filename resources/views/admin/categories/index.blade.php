@extends('layouts.admin')
@section('title', 'Categories')

@section('content')
<div class="grid lg:grid-cols-2 gap-6">
    {{-- Create Form --}}
    <div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold mb-4" style="color: var(--brand-dark);">Add Category</h2>
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="form-label">Category Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="e.g. Living Room">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="2" class="form-input" placeholder="Optional description">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="form-label">Parent Category</label>
                    <select name="parent_id" class="form-input">
                        <option value="">None (Top Level)</option>
                        @foreach($categories as $cat)
                            @if(!$cat->parent_id)
                            <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input">
                </div>
                <div>
                    <label class="form-label">Category Image</label>
                    <input type="file" name="image" accept="image/*" class="form-input">
                </div>
                <button type="submit" class="btn-primary btn-sm">Add Category</button>
            </form>
        </div>
    </div>

    {{-- List --}}
    <div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h2 class="font-bold" style="color: var(--brand-dark);">All Categories ({{ $categories->total() }})</h2>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($categories as $category)
                <div class="flex items-center gap-4 p-4">
                    <div class="w-12 h-10 rounded-lg overflow-hidden flex-shrink-0 bg-gray-50">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            @if($category->parent_id)<span class="text-xs text-gray-400">↳ </span>@endif
                            <span class="font-medium text-sm">{{ $category->name }}</span>
                        </div>
                        <div class="text-xs text-gray-400 mt-0.5">
                            {{ $category->products_count }} products
                            @if($category->children_count ?? 0 > 0)· {{ $category->children_count }} subcategories@endif
                        </div>
                    </div>
                    <span class="badge {{ $category->is_active ? 'badge-active' : 'badge-inactive' }}">{{ $category->is_active ? 'Active' : 'Inactive' }}</span>
                    <div class="flex gap-2" x-data="{ editing: false }">
                        <button @click="editing = !editing" class="text-xs font-medium hover:underline" style="color: var(--brand);">Edit</button>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600">Delete</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="p-4">{{ $categories->links() }}</div>
        </div>
    </div>
</div>
@endsection
