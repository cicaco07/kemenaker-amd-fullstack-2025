<?php

namespace App\Http\Controllers;

use App\Models\Checkup;
use App\Models\Pet;
use App\Models\Treatment;
use Illuminate\Http\Request;

class CheckupController extends Controller
{
    public function index()
    {
        $checkups = Checkup::with(['pet.owner', 'treatment'])
            ->orderBy('checkup_date', 'desc')
            ->paginate(10);
        return view('checkups.index', compact('checkups'));
    }

    public function create()
    {
        // Ambil semua hewan yang terdaftar
        $pets = Pet::with('owner')
            ->orderBy('name')
            ->get();

        // Ambil semua treatment yang tersedia
        $treatments = Treatment::orderBy('type')
            ->orderBy('name')
            ->get()
            ->groupBy('type'); // Group by type untuk tampilan lebih rapi

        if ($pets->isEmpty()) {
            return redirect()->route('pets.index')
                ->with('error', 'Belum ada hewan terdaftar. Silakan tambah hewan terlebih dahulu.');
        }

        if ($treatments->isEmpty()) {
            return redirect()->route('checkups.index')
                ->with('error', 'Belum ada treatment tersedia. Silakan hubungi administrator.');
        }

        return view('checkups.create', compact('pets', 'treatments'));
    }

    /**
     * Store a newly created checkup
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'treatment_id' => 'required|exists:treatments,id',
            'checkup_date' => 'required|date',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0|max:999.99',
            'temperature' => 'nullable|numeric|min:0|max:50',
            'cost' => 'nullable|numeric|min:0|max:9999999',
        ]);

        $checkup = Checkup::create($validated);

        return redirect()->route('checkups.show', $checkup)
            ->with('success', 'Data pemeriksaan berhasil ditambahkan!');
    }

    /**
     * Display the specified checkup
     */
    public function show(Checkup $checkup)
    {
        $checkup->load(['pet.owner', 'treatment']);

        // Ambil riwayat checkup lain dari hewan yang sama
        $otherCheckups = Checkup::where('pet_id', $checkup->pet_id)
            ->where('id', '!=', $checkup->id)
            ->orderBy('checkup_date', 'desc')
            ->limit(5)
            ->get();

        return view('checkups.show', compact('checkup', 'otherCheckups'));
    }

    /**
     * Show the form for editing the specified checkup
     */
    public function edit(Checkup $checkup)
    {
        $pets = Pet::with('owner')
            ->orderBy('name')
            ->get();

        $treatments = Treatment::orderBy('type')
            ->orderBy('name')
            ->get()
            ->groupBy('type');

        return view('checkups.edit', compact('checkup', 'pets', 'treatments'));
    }

    /**
     * Update the specified checkup
     */
    public function update(Request $request, Checkup $checkup)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'treatment_id' => 'required|exists:treatments,id',
            'checkup_date' => 'required|date',
            'diagnosis' => 'nullable|string',
            'notes' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0|max:999.99',
            'temperature' => 'nullable|numeric|min:0|max:50',
            'cost' => 'nullable|numeric|min:0|max:9999999',
        ]);

        $checkup->update($validated);

        return redirect()->route('checkups.show', $checkup)
            ->with('success', 'Data pemeriksaan berhasil diperbarui!');
    }

    /**
     * Remove the specified checkup
     */
    public function destroy(Checkup $checkup)
    {
        $petId = $checkup->pet_id;
        $checkup->delete();

        return redirect()->route('pets.show', $petId)
            ->with('success', 'Data pemeriksaan berhasil dihapus!');
    }
}
