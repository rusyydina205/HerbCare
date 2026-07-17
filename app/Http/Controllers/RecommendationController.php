<?php

namespace App\Http\Controllers;

use App\Models\Herb;
use App\Models\HealthCategory;
use App\Models\Symptom;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    /**
     * Display the herb list with optional filters.
     */
    public function index(Request $request)
    {
        if (auth()->guard('practitioner')->check()) {
            return redirect()->route('practitioner.dashboard');
        }

        $categories = HealthCategory::all();
        $symptoms   = Symptom::with('category')->get()->groupBy(function($symptom) {
            return $symptom->category->categoryName ?? 'General';
        });

        $selectedSymptoms = $request->input('symptoms', []);
        if (is_string($selectedSymptoms)) {
            $selectedSymptoms = explode(',', $selectedSymptoms);
        }

        $query = Herb::with(['category', 'symptoms']);

        $isFiltering = $request->filled('category') || !empty($selectedSymptoms);

        // Filter by Category
        if ($request->filled('category')) {
            $query->where('categoryId', $request->category);
        }

        // Advanced Multi-Symptom Matching
        if (!empty($selectedSymptoms)) {
            $query->whereHas('symptoms', function ($q) use ($selectedSymptoms) {
                $q->whereIn('symptoms.symptomId', $selectedSymptoms);
            });
        }

        if ($isFiltering) {
            $herbs = $query->get();
        } else {
            $herbs = $query->orderBy('herbName')->take(9)->get();
        }

        // Calculate relevance/confidence score for display
        if (!empty($selectedSymptoms)) {
            $totalSelected = count($selectedSymptoms);
            $herbs->each(function($herb) use ($selectedSymptoms, $totalSelected) {
                $matchCount = $herb->symptoms->whereIn('symptomId', $selectedSymptoms)->count();
                $herb->relevance = $totalSelected > 0 ? min(100, round(($matchCount / $totalSelected) * 100)) : 0;
            });
            
            $herbs = $herbs->sortByDesc('relevance')->values()->take(9);

            // LOG HISTORY: Save top 3 recommendations for the patient
            if ($herbs->isNotEmpty() && auth()->check()) {
                $patient = auth()->user();
                if ($patient instanceof \App\Models\Patient) {
                    foreach ($herbs->take(3) as $h) {
                        \App\Models\Recommendation::updateOrCreate(
                            [
                                'patientId' => $patient->patientId,
                                'herbsId'   => $h->herbId,
                                'symptomId' => $selectedSymptoms[0] ?? 0,
                            ],
                            [
                                'herbName'   => $h->herbName,
                                'categoryId' => $h->categoryId,
                                'updated_at' => now(),
                            ]
                        );
                    }
                }
            }
        } elseif ($isFiltering) {
            $herbs = $herbs->take(9);
        }

        // Fetch Most Popular Herbs for this Patient
        $popularHerbs = [];
        if (auth()->check()) {
            $patient = auth()->user();
            if ($patient instanceof \App\Models\Patient) {
                $popularIds = \App\Models\Recommendation::where('patientId', $patient->patientId)
                    ->select('herbsId', \DB::raw('count(*) as count'))
                    ->groupBy('herbsId')
                    ->orderByDesc('count')
                    ->take(4)
                    ->pluck('herbsId');
                
                if ($popularIds->isNotEmpty()) {
                    $popularHerbs = Herb::whereIn('herbId', $popularIds)->with('category')->get();
                }
            }
        }

        $detectedCategory = null;
        if (!empty($selectedSymptoms)) {
            $categoryCounts = \App\Models\Symptom::whereIn('symptomId', $selectedSymptoms)
                ->whereNotNull('categoryId')
                ->select('categoryId', \DB::raw('count(*) as count'))
                ->groupBy('categoryId')
                ->orderByDesc('count')
                ->first();
                
            if ($categoryCounts) {
                $detectedCategory = \App\Models\HealthCategory::find($categoryCounts->categoryId);
            }
        }

        return view('dashboard', compact('herbs', 'categories', 'symptoms', 'selectedSymptoms', 'popularHerbs', 'detectedCategory'));
    }
}
