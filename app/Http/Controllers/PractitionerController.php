<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Herb;
use App\Models\HealthCategory;
use App\Models\Patient;
use App\Models\Practitioner;
use App\Models\Symptom;
use App\Models\Message;

class PractitionerController extends Controller
{
    /**
     * Practitioner Dashboard Overview (Herbs list + basic stats)
     */
    public function index(Request $request)
    {
        $query = Herb::with(['category', 'symptoms'])->latest('herbId');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('herbName', 'like', '%' . $request->search . '%')
                  ->orWhere('scientificName', 'like', '%' . $request->search . '%');
            });
        }

        $herbs = $query->paginate(10)->withQueryString();
        $totalPatients = Patient::count();
        $totalConsultations = Message::count();
        $recentUsers = Patient::latest()->limit(5)->get();
        $symptomsCount = Symptom::count();
        $newMessagesCount = Message::where('status', 'pending')->count();
        $recentMessages = Message::with('patient')->latest()->limit(3)->get();
        
        $allSymptoms = Symptom::with('category')->get()->groupBy('category.categoryName');
        $allCategories = HealthCategory::all();
        
        $practitioners = Practitioner::withCount(['messages' => function($q) { 
            $q->whereNotNull('reply'); 
        }])->orderByDesc('messages_count')->get();
        
        return view('practitioner.dashboard', compact('herbs', 'totalPatients', 'totalConsultations', 'recentUsers', 'symptomsCount', 'newMessagesCount', 'recentMessages', 'allSymptoms', 'allCategories', 'practitioners'));
    }

    /**
     * Dedicated Analytics Dashboard
     */
    public function analytics()
    {
        $data = $this->getAnalyticsData();
        return view('practitioner.analytics', $data);
    }

    /**
     * API Endpoint for Real-time Analytics Updates
     */
    public function analyticsData()
    {
        return response()->json($this->getAnalyticsData());
    }

    /**
     * Consolidate Analytics Data Logic
     */
    private function getAnalyticsData()
    {
        $totalPatients = Patient::count();

        // Consultations are derived from patient messages.
        $totalConsultations = Message::count();
        $thisMonthConsultations = Message::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $pendingConsultations = Message::where('status', 'pending')->count();

        $months = collect(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']);
        $currentYear = now()->year;
        
        $consultationCounts = collect();
        foreach (range(1, 12) as $m) {
            $consultationCounts->push(Message::whereMonth('created_at', $m)->whereYear('created_at', $currentYear)->count());
        }

        // Top consultation topics by message subject.
        $topTopicsData = Message::selectRaw('subject, COUNT(*) as count')
            ->groupBy('subject')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()
            ->map(fn($item) => ['name' => $item->subject ?: 'General Consultation', 'count' => $item->count]);

        // Top Symptoms
        $topSymptomsData = \App\Models\Recommendation::selectRaw('symptomId, COUNT(*) as count')
            ->whereNotNull('symptomId')->groupBy('symptomId')->orderBy('count', 'desc')->limit(5)->get()
            ->map(fn($item) => ['name' => Symptom::find($item->symptomId)?->symptomName ?? 'Unknown', 'count' => $item->count]);

        // Health Categories
        $categoryData = \App\Models\Recommendation::selectRaw('categoryId, COUNT(*) as count')
            ->whereNotNull('categoryId')->groupBy('categoryId')->get()
            ->map(fn($item) => ['name' => HealthCategory::find($item->categoryId)?->categoryName ?? 'Unknown', 'count' => $item->count]);

        // Top Herbs
        $topHerbsData = \App\Models\Recommendation::selectRaw('herbsId, COUNT(*) as count')
            ->groupBy('herbsId')->orderBy('count', 'desc')->limit(5)->get()
            ->map(fn($item) => ['name' => Herb::find($item->herbsId)?->herbName ?? 'Unknown', 'count' => $item->count]);

        $recentMessages = Message::with('patient')->latest()->limit(5)->get();

        return [
            'totalPatients' => $totalPatients,
            'totalConsultations' => $totalConsultations,
            'thisMonthConsultations' => $thisMonthConsultations,
            'pendingConsultations' => $pendingConsultations,
            'months' => $months,
            'consultationCounts' => $consultationCounts,
            'topicLabels' => $topTopicsData->pluck('name'),
            'topicValues' => $topTopicsData->pluck('count'),
            'topSymptomsLabels' => $topSymptomsData->pluck('name'),
            'topSymptomsValues' => $topSymptomsData->pluck('count'),
            'categoryLabels' => $categoryData->pluck('name'),
            'categoryValues' => $categoryData->pluck('count'),
            'topHerbsLabels' => $topHerbsData->pluck('name'),
            'topHerbsValues' => $topHerbsData->pluck('count'),
            'recentMessages' => $recentMessages,
        ];
    }

    /**
     * Generate Printable Report for Monthly Consultations
     */
    /**
     * Generate Printable Report for Consultations
     */
    public function report(Request $request)
    {
        $currentYear = $request->input('year', now()->year);
        $selectedMonth = $request->input('month'); // Optional: 1-12
        
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        
        $data = [];
        $reportType = 'Annual';
        $title = "Consultation Report - " . $currentYear;

        if ($selectedMonth && $selectedMonth >= 1 && $selectedMonth <= 12) {
            $reportType = 'Monthly';
            $monthName = $months[$selectedMonth - 1];
            $title = "Detailed Consultation Report - {$monthName} {$currentYear}";
            
            // Get number of days in that month
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $currentYear);
            
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $count = Message::whereDay('created_at', $day)
                    ->whereMonth('created_at', $selectedMonth)
                    ->whereYear('created_at', $currentYear)
                    ->count();
                
                $data[] = [
                    'Label' => $monthName . ' ' . str_pad($day, 2, '0', STR_PAD_LEFT),
                    'Date' => "{$currentYear}-" . str_pad($selectedMonth, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT),
                    'Total Consultations' => $count
                ];
            }
        } else {
            foreach (range(1, 12) as $monthNum) {
                $count = Message::whereMonth('created_at', $monthNum)
                    ->whereYear('created_at', $currentYear)
                    ->count();
                
                $data[] = [
                    'Label' => $months[$monthNum - 1],
                    'Year' => $currentYear,
                    'Total Consultations' => $count
                ];
            }
        }

        return view('practitioner.report', compact('data', 'title', 'reportType', 'selectedMonth', 'currentYear'));
    }

    /**
     * Patient Messages Management
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

    public function symptomsDestroy($id)
    {
        Symptom::destroy($id);
        return back()->with('status', 'symptom-deleted');
    }

    /**
     * Patient Messages Management
     */
    public function messages(Request $request)
    {
        $query = Message::with('patient')->latest();

        if ($request->filled('status') && in_array($request->status, ['pending', 'replied', 'resolved'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', '%' . $search . '%')
                  ->orWhere('message', 'like', '%' . $search . '%')
                  ->orWhereHas('patient', fn($p) => $p->where('name', 'like', '%' . $search . '%'));
            });
        }

        $messages = $query->paginate(15)->withQueryString();

        $pendingCount = Message::where('status', 'pending')->count();
        $repliedCount = Message::where('status', 'replied')->count();
        $resolvedCount = Message::where('status', 'resolved')->count();

        return view('practitioner.messages.index', compact('messages', 'pendingCount', 'repliedCount', 'resolvedCount'));
    }

    public function updateMessageStatus(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $request->validate(['status' => 'required|in:pending,replied,resolved']);
        
        $message->update(['status' => $request->status]);
        return back()->with('success', 'Message status updated to ' . $request->status);
    }

    public function replyToMessage(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $validated = $request->validate([
            'reply' => 'required|string',
        ]);

        $message->update([
            'reply' => $validated['reply'],
            'replied_at' => now(),
            'status' => 'replied',
            'is_read' => false, // New reply, so patient hasn't read it yet
        ]);

        return back()->with('success', 'Reply sent successfully!');
    }

    /**
     * Herbs CRUD
     */
    public function create()
    {
        $categories = HealthCategory::all();
        $herb = new Herb(); 
        $allSymptoms = Symptom::with('category')->get()->groupBy('category.categoryName');
        return view('practitioner.herb-form', compact('herb', 'categories', 'allSymptoms'));
    }

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

    public function edit($id)
    {
        $herb = Herb::with('symptoms')->findOrFail($id);
        $categories = HealthCategory::all();
        $allSymptoms = Symptom::with('category')->get()->groupBy('category.categoryName');
        return view('practitioner.herb-form', compact('herb', 'categories', 'allSymptoms'));
    }

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

    public function destroy($id)
    {
        $herb = Herb::findOrFail($id);
        
        // Detach symptoms before deleting
        $herb->symptoms()->detach();
        
        $herb->delete();

        return redirect()->route('practitioner.dashboard')->with('success', 'Herb removed from clinical inventory successfully!');
    }

    /**
     * Patients Directory Management
     */
    public function patients(Request $request)
    {
        $query = Patient::withCount('messages')->latest('patientId');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $patients = $query->paginate(15)->withQueryString();

        return view('practitioner.patients.index', compact('patients'));
    }

    /**
     * Practitioner Profile Management
     */
    public function profile()
    {
        $practitioner = auth()->guard('practitioner')->user();
        return view('practitioner.profile', compact('practitioner'));
    }

    public function profileUpdate(Request $request)
    {
        $practitioner = auth()->guard('practitioner')->user();

        if (!$practitioner instanceof Practitioner) {
            abort(401);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:practitioners,email,' . $practitioner->practitionerId . ',practitionerId',
            'phone' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $practitioner->name = $validated['name'];
        $practitioner->email = $validated['email'];
        if (isset($validated['phone'])) {
            $practitioner->phone = $validated['phone'];
        }

        if (!empty($validated['password'])) {
            $practitioner->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($practitioner->profile_photo) {
                Storage::disk('public')->delete('profile_photos/' . $practitioner->profile_photo);
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('profile_photos', $filename, 'public');
            
            $practitioner->profile_photo = $filename;
        }

        $practitioner->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function profileDestroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password:practitioner'],
        ]);

        $practitioner = auth()->guard('practitioner')->user();

        if (!$practitioner instanceof Practitioner) {
            abort(401);
        }

        auth()->guard('practitioner')->logout();

        $practitioner->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
