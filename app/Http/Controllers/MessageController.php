<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display patient's message history and replies.
     */
    public function messages()
    {
        $patient = auth()->user();
        if (!($patient instanceof \App\Models\Patient)) {
            return redirect()->route('dashboard');
        }

        $messages = \App\Models\Message::where('patientId', $patient->patientId)
            ->latest()
            ->paginate(10);

        return view('patient.messages', compact('messages'));
    }

    /**
     * Mark a message as read by the patient.
     */
    public function markMessageAsRead($id)
    {
        $patient = auth()->user();
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
        $patient = auth()->user();
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
