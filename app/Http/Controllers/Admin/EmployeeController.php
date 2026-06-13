<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('employee_id', 'like', "%{$request->search}%")
                  ->orWhere('position', 'like', "%{$request->search}%");
            });
        }

        $employees = $query->latest()->paginate(20)->withQueryString();
        $departments = Employee::distinct()->pluck('department');

        return view('admin.erm.employees.index', compact('employees', 'departments'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'nullable|email|unique:employees,email',
            'phone'       => 'nullable|string|max:20',
            'department'  => 'required|string|max:100',
            'position'    => 'required|string|max:100',
            'salary'      => 'nullable|numeric|min:0',
            'hire_date'   => 'required|date',
            'address'     => 'nullable|string',
            'notes'       => 'nullable|string',
        ]);

        $data['employee_id'] = 'ZF-EMP-' . str_pad(Employee::withTrashed()->count() + 1, 4, '0', STR_PAD_LEFT);
        $data['status'] = 'active';

        Employee::create($data);
        return back()->with('success', 'Employee added successfully!');
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:100',
            'email'            => 'nullable|email|unique:employees,email,' . $employee->id,
            'phone'            => 'nullable|string|max:20',
            'department'       => 'required|string|max:100',
            'position'         => 'required|string|max:100',
            'salary'           => 'nullable|numeric|min:0',
            'hire_date'        => 'required|date',
            'termination_date' => 'nullable|date',
            'status'           => 'required|in:active,on_leave,terminated',
            'address'          => 'nullable|string',
            'notes'            => 'nullable|string',
        ]);

        $employee->update($data);
        return back()->with('success', 'Employee updated!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return back()->with('success', 'Employee removed.');
    }
}
