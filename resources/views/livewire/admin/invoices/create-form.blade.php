<div class="max-w-4xl space-y-5">
    {{-- Customer --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
        <h2 class="font-bold text-sm uppercase tracking-wider" style="color: var(--brand-dark);">Customer</h2>

        @if($customerId)
            @php($selected = \App\Models\User::find($customerId))
            <div class="flex items-center justify-between p-3 rounded-lg" style="background: var(--cream);">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0" style="background: var(--brand); color: white;">{{ substr($selected->name ?? '?', 0, 1) }}</div>
                    <div>
                        <div class="font-medium text-sm">{{ $selected->name ?? 'Unknown' }}</div>
                        <div class="text-xs text-gray-400">{{ $selected->email ?? '' }}</div>
                    </div>
                </div>
                <button type="button" wire:click="clearCustomer" class="text-xs font-medium text-red-500 hover:text-red-700">Change</button>
            </div>
        @elseif($showNewCustomerForm)
            <div class="p-4 rounded-lg border border-gray-100 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">New Customer</span>
                    <button type="button" wire:click="toggleNewCustomerForm" class="text-xs text-gray-400 hover:text-gray-600">Cancel</button>
                </div>
                <div class="grid sm:grid-cols-2 gap-3">
                    <div>
                        <label class="form-label">Name *</label>
                        <input type="text" wire:model="newCustomerName" class="form-input text-sm">
                        @error('newCustomerName')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Email *</label>
                        <input type="email" wire:model="newCustomerEmail" class="form-input text-sm">
                        @error('newCustomerEmail')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <p class="text-xs text-gray-400">A customer account will be created with a random password. They can request a password reset to log in later.</p>
            </div>
        @else
            <div>
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="customerSearch" class="form-input text-sm" placeholder="Search customers by name or email...">
                </div>
                @if(trim($customerSearch) !== '')
                <div class="mt-2 border border-gray-100 rounded-lg divide-y divide-gray-50 max-h-56 overflow-y-auto">
                    @forelse($this->filteredCustomers as $c)
                    <button type="button" wire:click="selectCustomer({{ $c->id }})" wire:key="cust-{{ $c->id }}" class="w-full text-left px-3 py-2 hover:bg-gray-50 flex items-center justify-between">
                        <span>
                            <span class="text-sm font-medium">{{ $c->name }}</span>
                            <span class="text-xs text-gray-400 block">{{ $c->email }}</span>
                        </span>
                    </button>
                    @empty
                    <div class="px-3 py-3 text-sm text-gray-400">No customers found.</div>
                    @endforelse
                </div>
                @endif
                @error('customerId')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                <button type="button" wire:click="toggleNewCustomerForm" class="text-xs font-medium mt-2 hover:underline" style="color: var(--brand);">+ Add a new customer</button>
            </div>
        @endif
    </div>

    {{-- Shipping --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
        <h2 class="font-bold text-sm uppercase tracking-wider" style="color: var(--brand-dark);">Shipping Details</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Name *</label>
                <input type="text" wire:model="shippingName" class="form-input text-sm">
                @error('shippingName')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="form-label">Phone *</label>
                <input type="text" wire:model="shippingPhone" class="form-input text-sm">
                @error('shippingPhone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="form-label">Email</label>
            <input type="email" wire:model="shippingEmail" class="form-input text-sm">
        </div>
        <div>
            <label class="form-label">Address *</label>
            <textarea wire:model="shippingAddress" rows="2" class="form-input text-sm"></textarea>
            @error('shippingAddress')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">City</label>
                <input type="text" wire:model="shippingCity" class="form-input text-sm">
            </div>
            <div>
                <label class="form-label">State</label>
                <input type="text" wire:model="shippingState" class="form-input text-sm">
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
        <h2 class="font-bold text-sm uppercase tracking-wider" style="color: var(--brand-dark);">Items</h2>

        <div class="relative">
            <input type="text" wire:model.live.debounce.300ms="productSearch" class="form-input text-sm" placeholder="Search products by name or SKU...">
        </div>
        @if(trim($productSearch) !== '')
        <div class="border border-gray-100 rounded-lg divide-y divide-gray-50 max-h-56 overflow-y-auto">
            @forelse($this->filteredProducts as $p)
            <button type="button" wire:click="addItem({{ $p->id }})" wire:key="prod-{{ $p->id }}" class="w-full text-left px-3 py-2 hover:bg-gray-50 flex items-center justify-between" {{ $p->stock < 1 ? 'disabled' : '' }}>
                <span>
                    <span class="text-sm font-medium">{{ $p->name }}</span>
                    <span class="text-xs text-gray-400 block">SKU: {{ $p->sku }} &middot; {{ $p->stock }} in stock</span>
                </span>
                <span class="text-sm font-bold" style="color: var(--brand);">₦{{ number_format($p->current_price) }}</span>
            </button>
            @empty
            <div class="px-3 py-3 text-sm text-gray-400">No products found.</div>
            @endforelse
        </div>
        @endif
        @error('items')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror

        @if(!empty($items))
        <table class="w-full text-sm mt-2">
            <thead>
                <tr class="text-left text-xs uppercase tracking-wider text-gray-400">
                    <th class="pb-2">Product</th>
                    <th class="pb-2 text-center">Qty</th>
                    <th class="pb-2 text-right">Price</th>
                    <th class="pb-2 text-right">Total</th>
                    <th class="pb-2"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $i => $item)
                <tr class="border-t border-gray-50" wire:key="item-{{ $item['product_id'] }}">
                    <td class="py-2">
                        <div class="font-medium">{{ $item['name'] }}</div>
                        @if($item['sku'])<div class="text-xs text-gray-400">SKU: {{ $item['sku'] }}</div>@endif
                    </td>
                    <td class="py-2 text-center">
                        <div class="inline-flex items-center border border-gray-200 rounded-lg overflow-hidden">
                            <button type="button" wire:click="decrementItem({{ $i }})" class="px-2 py-1 hover:bg-gray-50 text-gray-500">−</button>
                            <span class="px-3">{{ $item['qty'] }}</span>
                            <button type="button" wire:click="incrementItem({{ $i }})" class="px-2 py-1 hover:bg-gray-50 text-gray-500">+</button>
                        </div>
                    </td>
                    <td class="py-2 text-right">₦{{ number_format($item['price']) }}</td>
                    <td class="py-2 text-right font-semibold" style="color: var(--brand-dark);">₦{{ number_format($item['price'] * $item['qty']) }}</td>
                    <td class="py-2 text-right">
                        <button type="button" wire:click="removeItem({{ $i }})" class="text-red-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="flex justify-end pt-3 border-t border-gray-100">
            <div class="text-right">
                <div class="text-xs text-gray-400 uppercase tracking-wider">Subtotal</div>
                <div class="text-xl font-bold" style="color: var(--brand);">₦{{ number_format($this->subtotal) }}</div>
            </div>
        </div>
        @endif
    </div>

    {{-- Order settings --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 space-y-4">
        <h2 class="font-bold text-sm uppercase tracking-wider" style="color: var(--brand-dark);">Order Settings</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Order Status</label>
                <select wire:model="orderStatus" class="form-input text-sm">
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="processing">Processing</option>
                </select>
            </div>
            <div>
                <label class="form-label">Invoice Due In (days)</label>
                <input type="number" wire:model="dueInDays" min="1" max="90" class="form-input text-sm">
                @error('dueInDays')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="form-label">Notes</label>
            <textarea wire:model="notes" rows="2" class="form-input text-sm" placeholder="Optional internal notes"></textarea>
        </div>
    </div>

    <div class="flex justify-end gap-3">
        <a href="{{ route('admin.invoices.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">Cancel</a>
        <button type="button" wire:click="save" wire:loading.attr="disabled" wire:target="save" class="btn-primary btn-sm">
            <span wire:loading.remove wire:target="save">Create Invoice</span>
            <span wire:loading wire:target="save">Creating…</span>
        </button>
    </div>
</div>
