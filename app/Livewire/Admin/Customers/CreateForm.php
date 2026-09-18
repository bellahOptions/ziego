<?php

namespace App\Livewire\Admin\Customers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class CreateForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $company = '';

    public string $address = '';

    public string $password = '';

    public bool $isActive = true;

    public function generatePassword(): void
    {
        $this->password = Str::password(12, symbols: false);
    }

    public function save()
    {
        $validated = $this->validate([
            'name'     => 'required|string|max:100',
            'email'    => ['required', 'email', Rule::unique('users', 'email')],
            'phone'    => 'nullable|string|max:20',
            'company'  => 'nullable|string|max:100',
            'address'  => 'nullable|string|max:500',
            'password' => 'required|string|min:8',
        ]);

        $customer = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'] ?: null,
            'company'   => $validated['company'] ?: null,
            'address'   => $validated['address'] ?: null,
            'password'  => Hash::make($validated['password']),
            'role'      => 'customer',
            'is_active' => $this->isActive,
            'email_verified_at' => now(),
        ]);

        session()->flash('success', "Customer \"{$customer->name}\" created successfully.");

        return $this->redirect(route('admin.customers.show', $customer));
    }

    public function render()
    {
        return view('livewire.admin.customers.create-form');
    }
}
