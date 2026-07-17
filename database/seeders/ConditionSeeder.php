<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Condition;
use App\Models\Symptom;
use App\Models\Herb;

class ConditionSeeder extends Seeder
{
    public function run(): void
    {
        // Example TCM Patterns (Conditions)
        $windHeat = Condition::create([
            'name' => 'Wind-Heat (Exterior Syndrome)',
            'description' => 'A common TCM pattern characterized by fever, sore throat, and aversion to wind.',
        ]);

        $heatToxin = Condition::create([
            'name' => 'Heat Toxin (Inflammation)',
            'description' => 'Internal heat buildup causing swelling, redness, and specialized inflammation.',
        ]);

        // Map Symptoms (assuming these exist based on names)
        $fever = Symptom::where('symptomName', 'LIKE', '%Fever%')->first();
        $soreThroat = Symptom::where('symptomName', 'LIKE', '%Sore Throat%')->first();
        $cough = Symptom::where('symptomName', 'LIKE', '%Cough%')->first();

        if ($windHeat && $fever && $soreThroat) {
            $windHeat->symptoms()->sync([$fever->symptomId, $soreThroat->symptomId]);
        }

        // Map Herbs (finding some common ones)
        $jinYinHua = Herb::where('herbName', 'LIKE', '%Jin Yin Hua%')->orWhere('herbName', 'LIKE', '%Honeysuckle%')->first();
        $lianQiao = Herb::where('herbName', 'LIKE', '%Lian Qiao%')->orWhere('herbName', 'LIKE', '%Forsythia%')->first();

        if ($windHeat && $jinYinHua) {
            $windHeat->herbs()->attach($jinYinHua->herbId);
        }
        if ($windHeat && $lianQiao) {
            $windHeat->herbs()->attach($lianQiao->herbId);
        }
    }
}
