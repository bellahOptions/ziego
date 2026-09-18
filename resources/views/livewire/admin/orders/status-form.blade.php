<div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5" x-data="{ status: @entangle('status') }">
    <h2 class="font-bold mb-4 text-sm" style="color: var(--brand-dark);">Update Order Status</h2>

    <div class="flex gap-3">
        <select wire:model="status" class="form-input text-sm">
            @foreach(['pending','confirmed','processing','shipped','delivered','cancelled','refunded'] as $s)
                <option value="{{ $s }}">{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button type="button" wire:click="update" wire:loading.attr="disabled" wire:target="update" class="btn-primary btn-sm">
            <span wire:loading.remove wire:target="update">Update</span>
            <span wire:loading wire:target="update">Updating…</span>
        </button>
    </div>
    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

    <div x-show="status === 'shipped'" x-cloak class="grid sm:grid-cols-3 gap-3 mt-3">
        <div>
            <label class="form-label">Carrier</label>
            <input type="text" wire:model="carrier" placeholder="e.g. GIG Logistics" class="form-input text-sm">
        </div>
        <div>
            <label class="form-label">Tracking Number</label>
            <input type="text" wire:model="trackingNumber" class="form-input text-sm">
        </div>
        <div>
            <label class="form-label">Tracking URL</label>
            <input type="url" wire:model="trackingUrl" placeholder="https://..." class="form-input text-sm">
            @error('trackingUrl')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>
</div>
