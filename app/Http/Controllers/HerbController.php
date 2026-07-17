<?php

namespace App\Http\Controllers;

use App\Models\Herb;
use Illuminate\Http\Request;

class HerbController extends Controller
{
    /**
     * Display the detail page for a specific herb.
     */
    public function show($id)
    {
        if (auth()->guard('practitioner')->check() && !request()->has('view_as_patient')) {
            return redirect()->route('practitioner.dashboard');
        }

        $herb = Herb::with(['category', 'symptoms'])->findOrFail($id);
        
        // Fetch Favorited Herbs for sidebar
        $popularHerbs = [];
        if (auth()->check()) {
            $patient = auth()->user();
            if ($patient instanceof \App\Models\Patient) {
                $favouriteIds = \App\Models\Recommendation::where('patientId', $patient->patientId)
                    ->whereNull('symptomId')
                    ->latest()
                    ->take(5)
                    ->pluck('herbsId');
                
                if ($favouriteIds->isNotEmpty()) {
                    $popularHerbs = Herb::whereIn('herbId', $favouriteIds)->get();
                }
            }
        }

        $backRoute = auth()->user() instanceof \App\Models\Practitioner ? route('practitioner.dashboard') : route('herb.library');

        return view('herb-details', compact('herb', 'popularHerbs', 'backRoute'));
    }

    /**
     * Toggle favourite (heart) for a herb — adds/removes from Recommendations so it shows in Popular for You.
     */
    public function toggleFavourite(Request $request, $herbId)
    {
        $patient = auth()->user();

        if (!($patient instanceof \App\Models\Patient)) {
            return response()->json(['error' => 'Only patients can favourite herbs.'], 403);
        }

        $herb = \App\Models\Herb::findOrFail($herbId);

        $favourite = \App\Models\Recommendation::where('patientId', $patient->patientId)
            ->where('herbsId', $herbId)
            ->whereNull('symptomId')
            ->first();

        if ($favourite) {
            $favourite->delete();
            return response()->json(['favourited' => false]);
        }

        \App\Models\Recommendation::create([
            'patientId'  => $patient->patientId,
            'herbsId'    => $herbId,
            'symptomId'  => null,
            'herbName'   => $herb->herbName,
            'categoryId' => $herb->categoryId,
        ]);

        return response()->json(['favourited' => true]);
    }
}
