<?php

namespace App\Http\Controllers;

use App\Models\Herb;
use App\Models\HealthCategory;
use App\Models\Symptom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the herb list with optional filters.
     */
    public function index(Request $request)
    {
        if (Auth::guard('practitioner')->check()) {
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
            if ($herbs->isNotEmpty() && Auth::check()) {
                $patient = Auth::user();
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
        if (Auth::check()) {
            $patient = Auth::user();
            if ($patient instanceof \App\Models\Patient) {
                $popularIds = \App\Models\Recommendation::where('patientId', $patient->patientId)
                    ->select('herbsId', DB::raw('count(*) as count'))
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
        $categoryMatchScore = 0;
        if (!empty($selectedSymptoms)) {
            $categoryCounts = \App\Models\Symptom::whereIn('symptomId', $selectedSymptoms)
                ->whereNotNull('categoryId')
                ->select('categoryId', DB::raw('count(*) as count'))
                ->groupBy('categoryId')
                ->orderByDesc('count')
                ->first();
                
            if ($categoryCounts) {
                $detectedCategory = \App\Models\HealthCategory::find($categoryCounts->categoryId);
                $categoryMatchScore = min(100, round(($categoryCounts->count / count($selectedSymptoms)) * 100));
            }
        }

        return view('dashboard', compact('herbs', 'categories', 'symptoms', 'selectedSymptoms', 'popularHerbs', 'detectedCategory', 'categoryMatchScore'));
    }

    /**
     * Display the herb library page for all herbs.
     */
    public function library(Request $request)
    {
        if (auth()->guard('practitioner')->check() && !request()->has('view_as_patient')) {
            return redirect()->route('practitioner.dashboard');
        }

        $search = $request->input('search');
        $selectedCategory = $request->input('category');
        $sort = $request->input('sort', 'alphabetical');

        $query = Herb::with('category');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('herbName', 'like', "%{$search}%")
                    ->orWhere('scientificName', 'like', "%{$search}%")
                    ->orWhere('benefits', 'like', "%{$search}%");
            });
        }

        if ($selectedCategory) {
            $query->where('categoryId', $selectedCategory);
        }

        if ($sort === 'az') {
            $query->orderBy('herbName', 'asc');
        } elseif ($sort === 'za') {
            $query->orderBy('herbName', 'desc');
        } else {
            $query->orderBy('herbName', 'asc');
        }

        $herbs = $query->get();
        $categories = HealthCategory::orderBy('categoryName')->get();

        return view('herb-library', compact('herbs', 'categories', 'search', 'selectedCategory', 'sort'));
    }

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
        if (Auth::check()) {
            $patient = Auth::user();
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

        $backRoute = Auth::user() instanceof \App\Models\Practitioner ? route('practitioner.dashboard') : route('herb.library');

        return view('herb-details', compact('herb', 'popularHerbs', 'backRoute'));
    }

    /**
     * Toggle favourite (heart) for a herb — adds/removes from Recommendations so it shows in Popular for You.
     */
    public function toggleFavourite(Request $request, $herbId)
    {
        $patient = Auth::user();

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

    public function history()
    {
        $patient = Auth::user();
        if (!($patient instanceof \App\Models\Patient)) {
            return redirect()->route('dashboard');
        }

        $history = \App\Models\Recommendation::where('patientId', $patient->patientId)
            ->whereNotNull('symptomId')
            ->with(['herb', 'symptom', 'category'])
            ->latest()
            ->paginate(15);

        // Fetch ALL records (no pagination) for the PDF export
        $allHistory = \App\Models\Recommendation::where('patientId', $patient->patientId)
            ->whereNotNull('symptomId')
            ->with(['herb', 'symptom', 'category'])
            ->latest()
            ->get();

        return view('patient.history', compact('history', 'allHistory'));
    }

    /**
     * Return a standalone print-ready PDF view of all recommendation history.
     */
    public function historyPdf()
    {
        $patient = Auth::user();
        if (!($patient instanceof \App\Models\Patient)) {
            return redirect()->route('dashboard');
        }

        $allHistory = \App\Models\Recommendation::where('patientId', $patient->patientId)
            ->whereNotNull('symptomId')
            ->with(['herb', 'symptom', 'category'])
            ->latest()
            ->get();

        return view('patient.history-pdf', compact('allHistory', 'patient'));
    }

    /**
     * Display the Wellness Tips page.
     */
    public function wellnessTips()
    {
        $patient = Auth::user();
        if (!($patient instanceof \App\Models\Patient)) {
            return redirect()->route('dashboard');
        }

        // Categories with herb counts
        $categories = HealthCategory::withCount('herbs')->get();

        // Personalized herb recommendations from patient history
        $recommendedHerbIds = \App\Models\Recommendation::where('patientId', $patient->patientId)
            ->select('herbsId', DB::raw('count(*) as freq'))
            ->groupBy('herbsId')
            ->orderByDesc('freq')
            ->take(6)
            ->pluck('herbsId');

        if ($recommendedHerbIds->isNotEmpty()) {
            $recommendedHerbs = Herb::whereIn('herbId', $recommendedHerbIds)
                ->with('category')
                ->get();
        } else {
            // Fallback: latest 6 herbs
            $recommendedHerbs = Herb::with('category')
                ->latest()
                ->take(6)
                ->get();
        }

        // Tip of the day — rotates daily
        $wellnessTips = [
            ['tip' => 'Drink warm water with lemon first thing in the morning to kickstart your digestion and hydrate your body.', 'icon' => 'water', 'category' => 'Hydration'],
            ['tip' => 'Add a pinch of turmeric to your meals — it has powerful anti-inflammatory and antioxidant properties.', 'icon' => 'herb', 'category' => 'Nutrition'],
            ['tip' => 'Practice 5 minutes of deep breathing exercises to reduce stress and improve mental clarity.', 'icon' => 'breathe', 'category' => 'Mindfulness'],
            ['tip' => 'Ginger tea before bed can ease digestion and calm the mind for better sleep quality.', 'icon' => 'tea', 'category' => 'Sleep'],
            ['tip' => 'Take a 15-minute walk outdoors daily — sunlight boosts Vitamin D and elevates your mood naturally.', 'icon' => 'walk', 'category' => 'Exercise'],
            ['tip' => 'Chamomile tea in the evening helps reduce anxiety and promotes deeper, more restorative sleep.', 'icon' => 'tea', 'category' => 'Relaxation'],
            ['tip' => 'Eat a handful of mixed nuts daily for healthy fats, protein, and essential minerals like magnesium.', 'icon' => 'food', 'category' => 'Nutrition'],
            ['tip' => 'Apply peppermint oil to your temples to naturally relieve headaches and improve focus.', 'icon' => 'herb', 'category' => 'Natural Remedy'],
            ['tip' => 'Reduce screen time 1 hour before bed to improve melatonin production and sleep onset.', 'icon' => 'sleep', 'category' => 'Sleep Hygiene'],
            ['tip' => 'Include garlic in your cooking regularly — it supports immune function and cardiovascular health.', 'icon' => 'food', 'category' => 'Immunity'],
            ['tip' => 'Try a warm Epsom salt bath once a week to relax muscles and replenish magnesium levels.', 'icon' => 'relax', 'category' => 'Recovery'],
            ['tip' => 'Practice gratitude journaling before bed — write down 3 things you are grateful for each day.', 'icon' => 'journal', 'category' => 'Mental Health'],
        ];
        $tipOfDay = $wellnessTips[date('z') % count($wellnessTips)];

        // Quick wellness habits (static content for the habit checklist)
        $dailyHabits = [
            ['habit' => 'Drink 8 glasses of water', 'icon' => 'water'],
            ['habit' => 'Take your herbal supplement', 'icon' => 'herb'],
            ['habit' => 'Eat fruits and vegetables', 'icon' => 'food'],
            ['habit' => '30 minutes of movement', 'icon' => 'walk'],
            ['habit' => 'Practice mindfulness', 'icon' => 'breathe'],
            ['habit' => 'Sleep 7-8 hours', 'icon' => 'sleep'],
        ];

        $dailyQuoteOptions = [
            ['quote' => 'Small habits every day lead to lasting wellness.', 'author' => 'Wellness Guide'],
            ['quote' => 'A healthy outside starts from the inside.', 'author' => 'Robert Urich'],
            ['quote' => 'Take care of your body, it’s the only place you have to live.', 'author' => 'Jim Rohn'],
            ['quote' => 'Balance is not something you find, it is something you create.', 'author' => 'Jana Kingsford'],
        ];
        $dailyQuote = $dailyQuoteOptions[date('z') % count($dailyQuoteOptions)];

        return view('patient.wellness-tips', compact(
            'categories',
            'recommendedHerbs',
            'tipOfDay',
            'dailyHabits',
            'dailyQuote'
        ));
    }

    public function contact()
    {
        $backRoute = Auth::check() && Auth::user() instanceof \App\Models\Practitioner 
            ? route('practitioner.dashboard') 
            : route('dashboard');
            
        return view('contact', compact('backRoute'));
    }

    /**
     * Display patient's message history and replies.
     */
    public function messages()
    {
        $patient = Auth::user();
        if (!($patient instanceof \App\Models\Patient)) {
            return redirect()->route('dashboard');
        }

        $messages = \App\Models\Message::where('patientId', $patient->patientId)
            ->latest()
            ->paginate(10);

        $practitioners = \App\Models\Practitioner::withCount(['messages' => function($q) { 
                $q->whereNotNull('reply'); 
            }])
            ->orderByDesc('messages_count')
            ->get();

        return view('patient.messages', compact('messages', 'practitioners'));
    }

    /**
     * Mark a message as read by the patient.
     */
    public function markMessageAsRead($id)
    {
        $patient = Auth::user();
        $message = \App\Models\Message::where('messageId', $id)
            ->where('patientId', $patient->patientId)
            ->firstOrFail();

        $message->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Allow patient to send a follow-up reply.
     */
    public function replyToPractitioner(Request $request, $id)
    {
        $patient = Auth::user();
        $message = \App\Models\Message::where('messageId', $id)
            ->where('patientId', $patient->patientId)
            ->firstOrFail();

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        // When a patient replies, we append to the existing message or update it.
        // For simplicity in this current schema, we'll update the main message 
        // and set status back to pending so the practitioner sees it again.
        // Or we could create a new message thread. 
        // The user said "reply again to the message", so let's append or update.
        
        $newMessage = $message->message . "\n\n--- Follow-up Question ---\n" . $validated['message'];
        
        $message->update([
            'message' => $newMessage,
            'status' => 'pending', // Revert to pending for practitioner
            'reply' => null,       // Clear old reply to show it's waiting for a new one
            'is_read' => true,
        ]);

        return back()->with('success', 'Your follow-up question has been sent!');
    }
}
