<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::with('owner')->latest()->paginate(10);
        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        $owners = Owner::verified()->orderBy('name')->get();

        if ($owners->isEmpty()) {
            return redirect()->route('pets.index')
                ->with('error', 'Belum ada pemilik dengan nomor telepon terverifikasi. Silakan verifikasi pemilik terlebih dahulu.');
        }

        return view('pets.create', compact('owners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'pet_data' => 'required|string',
        ]);

        try {
            $owner = Owner::findOrFail($request->owner_id);
            if ($owner->phone_verified !== true) {
                throw ValidationException::withMessages([
                    'owner_id' => 'Pemilik yang dipilih belum terverifikasi.'
                ]);
            }

            $input = trim($request->pet_data);
            $parsedData = $this->parseInputData($input);

            if ($owner->hasPet($parsedData['name'], $parsedData['species'])) {
                throw ValidationException::withMessages([
                    'pet_data' => "Pemilik ini sudah memiliki hewan bernama {$parsedData['name']} dengan jenis {$parsedData['species']}."
                ]);
            }

            $registrationCode = $this->generateRegistrationCode($request->owner_id);
            $pet = Pet::create([
                'owner_id' => $request->owner_id,
                'registration_code' => $registrationCode,
                'name' => $parsedData['name'],
                'species' => $parsedData['species'],
                'age' => $parsedData['age'],
                'weight' => $parsedData['weight'],
            ]);

            return redirect()->route('pets.show', $pet)
                ->with('success', "Hewan berhasil ditambahkan dengan kode registrasi: {$registrationCode}");

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['pet_data' => $e->getMessage()]);
        }
    }

    public function show(Pet $pet)
    {
        $pet->load(['owner', 'checkups.treatment']);
        return view('pets.show', compact('pet'));
    }

    public function edit(Pet $pet)
    {
        $owners = Owner::verified()->orderBy('name')->get();
        return view('pets.edit', compact('pet', 'owners'));
    }

    public function update(Request $request, Pet $pet)
    {
        $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'pet_data' => 'required|string',
        ]);

        try {
            $owner = Owner::findOrFail($request->owner_id);
            if (!$owner->phone_verified) {
                throw ValidationException::withMessages([
                    'owner_id' => 'Pemilik yang dipilih belum terverifikasi.'
                ]);
            }

            $parsedData = $this->parseInputData($request->pet_data);

            $duplicate = Pet::where('owner_id', $request->owner_id)
                ->where('name', $parsedData['name'])
                ->where('species', $parsedData['species'])
                ->where('id', '!=', $pet->id)
                ->exists();

            if ($duplicate) {
                throw ValidationException::withMessages([
                    'pet_data' => "Pemilik ini sudah memiliki hewan lain bernama {$parsedData['name']} dengan jenis {$parsedData['species']}."
                ]);
            }

            $pet->update([
                'owner_id' => $request->owner_id,
                'name' => $parsedData['name'],
                'species' => $parsedData['species'],
                'age' => $parsedData['age'],
                'weight' => $parsedData['weight'],
            ]);

            return redirect()->route('pets.show', $pet)
                ->with('success', 'Data hewan berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['pet_data' => $e->getMessage()]);
        }
    }

    public function destroy(Pet $pet)
    {
        $pet->delete();
        return redirect()->route('pets.index')
            ->with('success', 'Data hewan berhasil dihapus!');
    }


    private function parseInputData($input)
    {
        $input = preg_replace('/\s+/', ' ', trim($input));

        $parts = explode(' ', $input);

        if (count($parts) < 4) {
            throw new \Exception('Format input tidak valid. Format: NAMA JENIS USIA BERAT');
        }

        $weight = array_pop($parts);
        $age = array_pop($parts);
        $species = array_pop($parts);
        $name = implode(' ', $parts);

        $parsedAge = $this->parseAge($age);

        $parsedWeight = $this->parseWeight($weight);

        $name = strtoupper($name);
        $species = strtoupper($species);

        return [
            'name' => $name,
            'species' => $species,
            'age' => $parsedAge,
            'weight' => $parsedWeight,
        ];
    }

    private function generateRegistrationCode($ownerId)
    {
        $time = now()->format('Hi');
        $ownerCode = str_pad($ownerId, 4, '0', STR_PAD_LEFT);
        $petSequence = Pet::where('owner_id', $ownerId)->count() + 1;
        $sequenceCode = str_pad($petSequence, 4, '0', STR_PAD_LEFT);

        $code = $time . $ownerCode . $sequenceCode;
        $originalCode = $code;
        $counter = 1;
        while (Pet::where('registration_code', $code)->exists()) {
            $code = $originalCode . $counter;
            $counter++;
        }

        return $code;
    }

    private function parseAge($ageString)
    {
        $ageString = str_replace(' ', '', $ageString);
        if (preg_match('/^(\d+)(tahun|thn|th)?$/i', $ageString, $matches)) {
            return (int) $matches[1];
        }

        throw new \Exception('Format usia tidak valid. Contoh: 2tahun, 2thn, 2th');
    }
    private function parseWeight($weightString)
    {
        $weightString = str_replace(' ', '', $weightString);
        $weightString = preg_replace('/kg$/i', '', $weightString);
        $weightString = str_replace(',', '.', $weightString);
        if (is_numeric($weightString)) {
            return (float) $weightString;
        }

        throw new \Exception('Format berat tidak valid. Contoh: 4.5kg, 4,5kg');
    }
}
