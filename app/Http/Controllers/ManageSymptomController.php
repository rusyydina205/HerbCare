<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Symptom;
use App\Models\HealthCategory;

class ManageSymptomController extends Controller
{
    /**
     * Display listing of symptoms.
     */
    public function symptoms(Request $request)
    {
        $query = Symptom::with('category')->latest('symptomId');
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('symptomName', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        $symptoms = $query->paginate(15)->withQueryString();
        $categories = HealthCategory::all();
        return view('practitioner.symptoms.index', compact('symptoms', 'categories'));
    }

    /**
     * Store a newly created symptom.
     */
    public function symptomsStore(Request $request)
    {
        $validated = $request->validate([
            'symptomName' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categoryId' => 'required|exists:health_categories,categoryId',
        ]);

        Symptom::create($validated);
        return back()->with('success', 'Symptom profile created successfully!');
    }

    /**
     * Update the specified symptom.
     */
    public function symptomsUpdate(Request $request, $id)
    {
        $symptom = Symptom::findOrFail($id);
        $validated = $request->validate([
            'symptomName' => 'required|string|max:255',
            'description' => 'nullable|string',
            'categoryId' => 'required|exists:health_categories,categoryId',
        ]);

        $symptom->update($validated);
        return back()->with('success', 'Symptom profile updated successfully!');
    }

    /**
     * Remove the specified symptom.
     */
    public function symptomsDestroy($id)
    {
        Symptom::destroy($id);
        return back()->with('status', 'symptom-deleted');
    }
}
