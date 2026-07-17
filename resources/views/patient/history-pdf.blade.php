<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herb Recommendation History</title>
    <style>
        body { font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; color: #1f2937; margin: 0; padding: 0; background: #f8fafc; }
        .page { max-width: 900px; margin: 0 auto; padding: 40px 32px; background: #ffffff; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 24px; }
        .header h1 { font-size: 28px; margin: 0; letter-spacing: 0.08em; text-transform: uppercase; color: #0f2818; }
        .meta { text-align: right; font-size: 13px; color: #4b5563; }
        .meta div { margin-bottom: 4px; }
        .record { border: 1px solid #e5e7eb; border-radius: 28px; padding: 24px; margin-bottom: 20px; background: #f9fafb; }
        .record:last-child { margin-bottom: 0; }
        .record-header { display: flex; justify-content: space-between; flex-wrap: wrap; gap: 16px; align-items: center; }
        .badge { display: inline-flex; align-items: center; justify-content: center; padding: 8px 12px; background: #e0f2fe; color: #0369a1; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; }
        .record-title { margin: 12px 0 8px; font-size: 20px; color: #0f2818; font-weight: 700; }
        .record-subtitle { margin: 0 0 12px; color: #4b5563; font-size: 13px; }
        .record-body { display: grid; grid-template-columns: 1fr; gap: 14px; }
        .field-list { margin: 0; padding: 0; list-style: none; display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; }
        .field-item { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; padding: 12px 14px; }
        .field-label { display: block; font-size: 11px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 6px; }
        .field-value { font-size: 14px; color: #111827; line-height: 1.5; }
        .footer { margin-top: 32px; padding-top: 24px; border-top: 1px solid #e5e7eb; color: #6b7280; font-size: 12px; }
        @media print { .page { box-shadow: none; margin: 0; } .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="page">
        <div class="header">
            <div>
                <h1>HERB RECOMMENDATION HISTORY</h1>
                <p class="record-subtitle">Patient: {{ $patient->name ?? $patient->email ?? 'Patient' }}</p>
            </div>
            <div class="meta">
                <div>Date: {{ now()->format('F j, Y') }}</div>
                <div>Total Entries: {{ $allHistory->count() }}</div>
            </div>
        </div>

        @forelse($allHistory as $item)
            <div class="record">
                <div class="record-header">
                    <span class="badge">{{ $item->category->categoryName ?? 'Herb' }}</span>
                    <div class="meta">
                        <div>{{ $item->updated_at->format('F j, Y h:i A') }}</div>
                        <div>{{ $item->symptom ? 'Symptom: '.$item->symptom->symptomName : 'General Recommendation' }}</div>
                    </div>
                </div>

                <div class="record-title">{{ $item->herbName }}</div>
                <p class="record-subtitle">{{ $item->herb->scientificName ?? 'Traditional Chinese Medicine Herb' }}</p>

                <div class="record-body">
                    <div class="field-item">
                        <span class="field-label">Recommended Herb</span>
                        <span class="field-value">{{ $item->herbName }}</span>
                    </div>
                    <div class="field-item">
                        <span class="field-label">Scientific Name</span>
                        <span class="field-value">{{ $item->herb->scientificName ?? 'N/A' }}</span>
                    </div>
                    <div class="field-item">
                        <span class="field-label">Category</span>
                        <span class="field-value">{{ $item->category->categoryName ?? 'N/A' }}</span>
                    </div>
                    <div class="field-item">
                        <span class="field-label">Source</span>
                        <span class="field-value">Saved from herb recommendation history</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="record">
                <div class="record-title">No recommendation history available</div>
                <p class="record-subtitle">Please use the dashboard to generate herb recommendations before exporting history.</p>
            </div>
        @endforelse

        <div class="footer no-print">
            This PDF is for personal reference only and does not constitute medical advice. Consult a licensed practitioner for personalized treatment.
        </div>
    </div>
</body>
</html>
