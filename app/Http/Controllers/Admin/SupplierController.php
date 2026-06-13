<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
        }

        $suppliers = $query->latest()->paginate(20)->withQueryString();

        return view('admin.erm.suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:200',
            'contact_person'    => 'nullable|string|max:100',
            'email'             => 'nullable|email',
            'phone'             => 'required|string|max:20',
            'address'           => 'nullable|string',
            'city'              => 'nullable|string|max:100',
            'state'             => 'nullable|string|max:100',
            'products_supplied' => 'nullable|string',
            'credit_limit'      => 'nullable|numeric|min:0',
            'notes'             => 'nullable|string',
        ]);

        $data['status'] = 'active';
        Supplier::create($data);

        return back()->with('success', 'Supplier added!');
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name'              => 'required|string|max:200',
            'contact_person'    => 'nullable|string|max:100',
            'email'             => 'nullable|email',
            'phone'             => 'required|string|max:20',
            'address'           => 'nullable|string',
            'city'              => 'nullable|string|max:100',
            'state'             => 'nullable|string|max:100',
            'products_supplied' => 'nullable|string',
            'credit_limit'      => 'nullable|numeric|min:0',
            'outstanding_balance' => 'nullable|numeric|min:0',
            'status'            => 'required|in:active,inactive,blacklisted',
            'notes'             => 'nullable|string',
        ]);

        $supplier->update($data);
        return back()->with('success', 'Supplier updated!');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return back()->with('success', 'Supplier removed.');
    }
}
