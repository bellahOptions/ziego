@extends('layouts.admin')
@section('title', '3D Showroom Management')

@section('content')
<div class="grid lg:grid-cols-2 gap-6">
    {{-- Upload Form --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-bold mb-5" style="color: var(--brand-dark);">Upload 3D Model</h2>

        <form action="{{ route('admin.showroom.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="form-label">Model Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="e.g. Modern Living Room">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Room Type</label>
                <select name="room_type" class="form-input">
                    <option value="">Select room type</option>
                    @foreach(['Living Room','Bedroom','Dining Room','Office','Kitchen','Outdoor','Lounge'] as $room)
                        <option value="{{ $room }}" {{ old('room_type') === $room ? 'selected' : '' }}>{{ $room }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-input" placeholder="Brief description of this room setup">{{ old('description') }}</textarea>
            </div>
            <div>
                <label class="form-label">3D Model File (.glb or .gltf) *</label>
                <input type="file" name="model_file" required accept=".glb,.gltf" class="form-input">
                <p class="text-xs text-gray-400 mt-1">Supported: GLB, GLTF. Max: 50MB</p>
                @error('model_file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Thumbnail Image</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-input">
                <p class="text-xs text-gray-400 mt-1">Preview image shown in the model list</p>
            </div>
            <div>
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="form-input">
            </div>
            <div class="flex gap-6">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="accent-color: var(--brand);">
                    <span class="text-sm">Active</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="accent-color: var(--brand);">
                    <span class="text-sm">Featured (shown first)</span>
                </label>
            </div>
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Upload Model
            </button>
        </form>
    </div>

    {{-- Models list --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h2 class="font-bold" style="color: var(--brand-dark);">Uploaded Models ({{ $models->total() }})</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($models as $model)
            <div class="p-4 flex gap-4 items-start">
                <div class="w-20 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-gray-50">
                    @if($model->thumbnail)
                        <img src="{{ $model->thumbnail_url }}" alt="" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center" style="background: var(--brand-pale);">
                            <svg class="w-7 h-7 opacity-30" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9"/></svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-semibold text-sm" style="color: var(--brand-dark);">{{ $model->name }}</span>
                        @if($model->is_featured)<span class="badge badge-confirmed text-xs">Featured</span>@endif
                        <span class="badge {{ $model->is_active ? 'badge-active' : 'badge-inactive' }} text-xs">{{ $model->is_active ? 'Active' : 'Inactive' }}</span>
                    </div>
                    @if($model->room_type)<p class="text-xs mt-0.5" style="color: var(--brand);">{{ $model->room_type }}</p>@endif
                    @if($model->description)<p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $model->description }}</p>@endif
                    <div class="flex gap-3 mt-2">
                        <a href="{{ $model->model_url }}" target="_blank" class="text-xs text-blue-500 hover:underline">Download GLB</a>
                        <form action="{{ route('admin.showroom.destroy', $model) }}" method="POST" onsubmit="return confirm('Delete this model?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-400 hover:text-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            @if($models->isEmpty())
            <div class="text-center py-12 text-gray-400">
                <p class="text-sm">No 3D models uploaded yet.</p>
                <p class="text-xs mt-1">Upload your first GLB/GLTF file to get started.</p>
            </div>
            @endif
        </div>
        <div class="p-4">{{ $models->links() }}</div>
    </div>
</div>
@endsection
