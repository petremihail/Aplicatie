<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    /**
     * Display a listing of the contracts.
     */
    public function index(Request $request)
    {
        $contracts = Contract::withCount('users')->paginate(10);
        return view('admin.contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new contract.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.contracts.create', compact('users'));
    }

    /**
     * Store a newly created contract in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'terms' => 'nullable|string',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            // Create contract
            $contract = Contract::create([
                'name' => $validated['name'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'description' => $validated['description'] ?? null,
                'terms' => $validated['terms'] ?? null,
            ]);

            // Assign users if provided
            if (isset($validated['user_ids'])) {
                $contract->users()->attach($validated['user_ids']);
            }

            DB::commit();
            return redirect()->route('admin.contracts.index')
                ->with('success', 'Contract created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create contract: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified contract.
     */
    public function show(Contract $contract)
    {
        $contract->load('users');
        return view('admin.contracts.show', compact('contract'));
    }

    /**
     * Show the form for editing the specified contract.
     */
    public function edit(Contract $contract)
    {
        $users = User::all();
        $assignedUsers = $contract->users->pluck('id')->toArray();
        
        return view('admin.contracts.edit', compact('contract', 'users', 'assignedUsers'));
    }

    /**
     * Update the specified contract in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'description' => 'nullable|string',
            'terms' => 'nullable|string',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        DB::beginTransaction();
        try {
            // Update contract
            $contract->update([
                'name' => $validated['name'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'description' => $validated['description'] ?? null,
                'terms' => $validated['terms'] ?? null,
            ]);

            // Update assigned users
            if (isset($validated['user_ids'])) {
                $contract->users()->sync($validated['user_ids']);
            } else {
                $contract->users()->detach();
            }

            DB::commit();
            return redirect()->route('admin.contracts.index')
                ->with('success', 'Contract updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update contract: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified contract from storage.
     */
    public function destroy(Contract $contract)
    {
        // Delete the contract (this will detach users due to the pivot table)
        $contract->delete();

        return redirect()->route('admin.contracts.index')
            ->with('success', 'Contract deleted successfully.');
    }
    
    /**
     * Show form to assign users to the contract.
     */
    public function assignForm(Contract $contract)
    {
        $users = User::all();
        $assignedUsers = $contract->users->pluck('id')->toArray();
        
        return view('admin.contracts.assign', compact('contract', 'users', 'assignedUsers'));
    }

    /**
     * Assign users to the contract.
     */
    public function assignUsers(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $contract->users()->sync($validated['user_ids']);

        return redirect()->route('admin.contracts.show', $contract)
            ->with('success', 'Users assigned to contract successfully.');
    }
}
