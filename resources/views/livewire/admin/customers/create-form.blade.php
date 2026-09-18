<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
        <h2 class="font-bold text-sm uppercase tracking-wider" style="color: var(--brand-dark);">Customer Details</h2>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Full Name *</label>
                <input type="text" wire:model="name" class="form-input" placeholder="e.g. John Okafor">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Email Address *</label>
                <input type="email" wire:model="email" class="form-input" placeholder="customer@example.com">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Phone</label>
                <input type="text" wire:model="phone" class="form-input" placeholder="080...">
                @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Company</label>
                <input type="text" wire:model="company" class="form-input" placeholder="Optional">
                @error('company')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="form-label">Address</label>
            <textarea wire:model="address" rows="2" class="form-input" placeholder="Optional"></textarea>
            @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="form-label">Password *</label>
            <div class="flex gap-2">
                <input type="text" wire:model="password" class="form-input" placeholder="Set an initial password">
                <button type="button" wire:click="generatePassword" class="flex-shrink-0 px-4 py-2 rounded-lg text-sm font-semibold border transition-colors hover:bg-gray-50" style="color: var(--brand-dark); border-color: var(--brand);">
                    Generate
                </button>
            </div>
            <p class="text-xs text-gray-400 mt-1">Share this password with the customer — they can change it after logging in.</p>
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" wire:model="isActive" id="isActive" class="rounded" style="accent-color: var(--brand);">
            <label for="isActive" class="text-sm text-gray-600">Account active</label>
        </div>
    </div>

    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">Cancel</a>
        <button type="button" wire:click="save" wire:loading.attr="disabled" wire:target="save" class="btn-primary btn-sm">
            <span wire:loading.remove wire:target="save">Create Customer</span>
            <span wire:loading wire:target="save">Creating…</span>
        </button>
    </div>
</div>
