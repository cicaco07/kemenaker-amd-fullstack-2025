<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public function index()
    {
        $owners = Owner::withCount('pets')->latest()->paginate(10);
        return view('owners.index', compact('owners'));
    }

    public function create()
    {
        return view('owners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
        ]);

        Owner::create($validated);

        return redirect()->route('owners.index')
            ->with('success', 'Data pemilik berhasil ditambahkan!');
    }

    public function show(Owner $owner)
    {
        $owner->load('pets.checkups');
        return view('owners.show', compact('owner'));
    }

    public function edit(Owner $owner)
    {
        return view('owners.edit', compact('owner'));
    }

    public function update(Request $request, Owner $owner)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string',
        ]);

        $owner->update($validated);

        return redirect()->route('owners.index')
            ->with('success', 'Data pemilik berhasil diperbarui!');
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();
        return redirect()->route('owners.index')
            ->with('success', 'Data pemilik berhasil dihapus!');
    }
}
