<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Herb;
use App\Models\HealthCategory;
use App\Models\Patient;
use App\Models\Symptom;
use App\Models\Message;

class AnalyticsController extends Controller
{
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
            'recentPatients' => \App\Models\Patient::latest()->limit(5)->get(),
        ];
    }

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
}
