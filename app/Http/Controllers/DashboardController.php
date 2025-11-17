<?php

namespace App\Http\Controllers;

use App\Models\Checkup;
use App\Models\Owner;
use App\Models\Pet;
use App\Models\Treatment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalOwners' => Owner::count(),
            'totalPets' => Pet::count(),
            'totalCheckups' => Checkup::count(),
            'totalTreatments' => Treatment::count(),
            'recentCheckups' => Checkup::with(['pet.owner', 'treatment'])
                ->orderBy('checkup_date', 'desc')
                ->take(5)
                ->get(),
            'popularTreatments' => Treatment::withCount('checkups')
                ->orderBy('checkups_count', 'desc')
                ->take(5)
                ->get(),
        ];

        return view('dashboard', $data);
    }
}
