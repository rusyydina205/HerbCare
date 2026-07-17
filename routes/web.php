<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PractitionerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact', [DashboardController::class, 'contact'])->name('contact');

// Shared authentication routes (Dashboard and Herb details)
Route::middleware(['auth:web,practitioner', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/herb-library', [DashboardController::class, 'library'])->name('herb.library');
    Route::get('/history', [DashboardController::class, 'history'])->name('patient.history');
    Route::get('/history/pdf', [DashboardController::class, 'historyPdf'])->name('patient.history.pdf');
    Route::get('/messages', [DashboardController::class, 'messages'])->name('patient.messages');
    Route::post('/messages/{id}/read', [DashboardController::class, 'markMessageAsRead'])->name('patient.messages.read');
    Route::post('/messages/{id}/reply', [DashboardController::class, 'replyToPractitioner'])->name('patient.messages.reply');
    Route::get('/herb/{herbId}', [DashboardController::class, 'show'])->name('herb.show');
    Route::post('/herb/{herbId}/favourite', [DashboardController::class, 'toggleFavourite'])->name('herb.favourite');
    Route::get('/wellness-tips', [DashboardController::class, 'wellnessTips'])->name('patient.wellness');
});

Route::middleware('auth:web,practitioner')->group(function () {
    Route::get('/profile', [AccountController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AccountController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AccountController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Practitioner Management Routes
Route::middleware(['auth:practitioner', 'verified', \App\Http\Middleware\EnsureIsPractitioner::class])->prefix('practitioner')->name('practitioner.')->group(function () {
    Route::get('/dashboard', [PractitionerController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [PractitionerController::class, 'analytics'])->name('analytics');
    Route::get('/analytics/data', [PractitionerController::class, 'analyticsData'])->name('analytics.data');
    Route::get('/analytics/report', [PractitionerController::class, 'report'])->name('analytics.report');
    
    // Patients
    Route::get('/patients', [PractitionerController::class, 'patients'])->name('patients.index');
    
    // Herbs
    Route::get('/herbs/create', [PractitionerController::class, 'create'])->name('herbs.create');
    Route::post('/herbs', [PractitionerController::class, 'store'])->name('herbs.store');
    Route::get('/herbs/{id}/edit', [PractitionerController::class, 'edit'])->name('herbs.edit');
    Route::put('/herbs/{id}', [PractitionerController::class, 'update'])->name('herbs.update');
    Route::delete('/herbs/{id}', [PractitionerController::class, 'destroy'])->name('herbs.destroy');

    // Symptoms
    Route::get('/symptoms', [PractitionerController::class, 'symptoms'])->name('symptoms.index');
    Route::post('/symptoms', [PractitionerController::class, 'symptomsStore'])->name('symptoms.store');
    Route::put('/symptoms/{id}', [PractitionerController::class, 'symptomsUpdate'])->name('symptoms.update');
    Route::delete('/symptoms/{id}', [PractitionerController::class, 'symptomsDestroy'])->name('symptoms.destroy');

    // Messages
    Route::get('/messages', [PractitionerController::class, 'messages'])->name('messages.index');
    Route::get('/messages/adriana', function () {
        $messages = \App\Models\Message::latest()->paginate(10);
        return view('practitioner.messages.adriana', compact('messages'));
    })->name('messages.adriana');
    Route::post('/messages/{id}/reply', [PractitionerController::class, 'replyToMessage'])->name('messages.reply');
    Route::patch('/messages/{id}/status', [PractitionerController::class, 'updateMessageStatus'])->name('messages.status');

    // Profile
    Route::get('/profile', [PractitionerController::class, 'profile'])->name('profile');
    Route::post('/profile', [PractitionerController::class, 'profileUpdate'])->name('profile.update');
    Route::delete('/profile', [PractitionerController::class, 'profileDestroy'])->name('profile.destroy');
});

// Contact Submission (For Patients)
Route::post('/contact', function (\Illuminate\Http\Request $request) {
    if (auth()->guard('web')->check()) {
        $patient = auth()->guard('web')->user();
        
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\Message::create([
            'patientId' => $patient->patientId,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);
        
        return back()->with('status', 'message-sent');
    }
    return back()->with('error', 'Only patients can send messages.');
})->name('contact.send');
