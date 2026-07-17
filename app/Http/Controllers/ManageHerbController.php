<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Herb;
use App\Models\HealthCategory;
use App\Models\Symptom;

class ManageHerbController extends Controller
{
    /**
     * Show the form for creating a new herb.
     */
    public function create()
    {
        $categories = HealthCategory::all();
        $herb = new Herb(); 
        $allSymptoms = Symptom::with('category')->get()->groupBy('category.categoryName');
        return view('practitioner.herb-form', compact('herb', 'categories', 'allSymptoms'));
    }

    /**
     * Store a newly created herb.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'herbName' => 'required|string|max:255',
            'scientificName' => 'required|string|max:255',
            'benefits' => 'required|string',
            'preparation' => 'required|string',
            'safety' => 'required|string',
            'categoryId' => 'required|exists:health_categories,categoryId',
            'image' => 'nullable|string',
            'symptoms' => 'nullable|array',
            'symptoms.*' => 'exists:symptoms,symptomId'
        ]);

        if (!$request->has('image') || empty($validated['image'])) {
            $validated['image'] = 'images/default-herb.jpg'; 
        }

        $herb = Herb::create($validated);

        if ($request->has('symptoms')) {
            $symptoms = Symptom::whereIn('symptomId', $request->symptoms)->get();
            $syncData = [];
            foreach ($symptoms as $symptom) {
                $syncData[$symptom->symptomId] = ['categoryId' => $symptom->categoryId];
            }
            $herb->symptoms()->attach($syncData);
        }

        return redirect()->route('practitioner.dashboard')->with('success', 'Herb added successfully!');
    }

    /**
     * Show the form for editing a herb.
     */
    public function edit($id)
    {
        $herb = Herb::with('symptoms')->findOrFail($id);
        $categories = HealthCategory::all();
        $allSymptoms = Symptom::with('category')->get()->groupBy('category.categoryName');
        return view('practitioner.herb-form', compact('herb', 'categories', 'allSymptoms'));
    }

    /**
     * Update the specified herb.
     */
    public function update(Request $request, $id)
    {
        $herb = Herb::findOrFail($id);
        
        $validated = $request->validate([
            'herbName' => 'required|string|max:255',
            'scientificName' => 'required|string|max:255',
            'benefits' => 'required|string',
            'preparation' => 'required|string',
            'safety' => 'required|string',
            'categoryId' => 'required|exists:health_categories,categoryId',
            'image' => 'nullable|string',
            'symptoms' => 'nullable|array',
            'symptoms.*' => 'exists:symptoms,symptomId'
        ]);

        $herb->update($validated);

        if ($request->has('symptoms')) {
            $symptoms = Symptom::whereIn('symptomId', $request->symptoms)->get();
            $syncData = [];
            foreach ($symptoms as $symptom) {
                $syncData[$symptom->symptomId] = ['categoryId' => $symptom->categoryId];
            }
            $herb->symptoms()->sync($syncData);
        } else {
            $herb->symptoms()->detach();
        }

        return redirect()->route('practitioner.dashboard')->with('success', 'Herb updated successfully!');
    }

    /**
     * Remove the specified herb.
     */
    public function destroy($id)
    {
        $herb = Herb::findOrFail($id);
        
        // Detach symptoms before deleting
        $herb->symptoms()->detach();
        
        $herb->delete();

        return redirect()->route('practitioner.dashboard')->with('success', 'Herb removed from clinical inventory successfully!');
    }
}
