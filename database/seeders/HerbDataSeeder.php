<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HealthCategory;
use App\Models\Herb;
use App\Models\Symptom;
use App\Models\HerbSymptom;
use App\Models\Practitioner;
use App\Models\Patient;
use App\Models\Message;
use Illuminate\Support\Facades\Hash;

class HerbDataSeeder extends Seeder
{
    public function run(): void
    {
        // ── Health Categories (Journal-Accurate TCM Domains) ──
        $sleep       = HealthCategory::firstOrCreate(['categoryName' => 'Immune system health']);
        $respiratory = HealthCategory::firstOrCreate(['categoryName' => 'Respiratory health']);
        $mental      = HealthCategory::firstOrCreate(['categoryName' => 'Stress/anxiety health']);
        $digestive   = HealthCategory::firstOrCreate(['categoryName' => 'Digestive health']);
        $menstrual   = HealthCategory::firstOrCreate(['categoryName' => 'Menstrual/productive health']);

        // ── Symptoms ──
        $insomnia   = Symptom::firstOrCreate(['symptomName' => 'Insomnia / Trouble Sleeping'], ['categoryId' => $sleep->categoryId]);
        $restless   = Symptom::firstOrCreate(['symptomName' => 'Mental Restlessness'],   ['categoryId' => $sleep->categoryId]);
        $headache   = Symptom::firstOrCreate(['symptomName' => 'Headache'],              ['categoryId' => $sleep->categoryId]);
        
        $cough      = Symptom::firstOrCreate(['symptomName' => 'Persistent Cough'],      ['categoryId' => $respiratory->categoryId]);
        $sorethroat = Symptom::firstOrCreate(['symptomName' => 'Sore Throat'],           ['categoryId' => $respiratory->categoryId]);
        $fever      = Symptom::firstOrCreate(['symptomName' => 'Fever'],                 ['categoryId' => $respiratory->categoryId]);
        
        $stress     = Symptom::firstOrCreate(['symptomName' => 'Stress & Anxiety'],      ['categoryId' => $mental->categoryId]);
        $mood       = Symptom::firstOrCreate(['symptomName' => 'Irritability'],          ['categoryId' => $mental->categoryId]);
        $fatigue    = Symptom::firstOrCreate(['symptomName' => 'Chronic Fatigue'],       ['categoryId' => $mental->categoryId]);
        
        $bloating   = Symptom::firstOrCreate(['symptomName' => 'Abdominal Bloating'],    ['categoryId' => $digestive->categoryId]);
        $nausea     = Symptom::firstOrCreate(['symptomName' => 'Nausea / Morning Sickness'], ['categoryId' => $digestive->categoryId]);
        $vomiting   = Symptom::firstOrCreate(['symptomName' => 'Vomiting'],              ['categoryId' => $digestive->categoryId]);
        
        $cramps     = Symptom::firstOrCreate(['symptomName' => 'Menstrual Cramps'],      ['categoryId' => $menstrual->categoryId]);
        $irregular  = Symptom::firstOrCreate(['symptomName' => 'Irregular Cycle'],       ['categoryId' => $menstrual->categoryId]);

        // ── 20 Journal-Accurate Herbs ──
        $herbs = [
            [
                'herbName'       => 'Jujube Seed (Suan Zao Ren)',
                'scientificName' => 'Ziziphus jujuba var. spinosa',
                'benefits'       => 'Nourishes the heart blood and calms the Mind (Shen). Primary herb for insomnia due to deficiency.',
                'preparation'    => 'Sorting: Select clean, high-quality seeds.. Crushing: Lightly crush the seeds before use to release active compounds.. Decoction: Decoct 9-15g in water, or take as a ground powder before bed.',
                'safety'         => 'Avoid if there is severe phlegm-heat or diarrhea.',
                'categoryId'     => $sleep->categoryId,
                'image'          => 'images/herb2.jpg',
                'symptoms'       => [$insomnia->symptomId, $restless->symptomId],
            ],
            [
                'herbName'       => 'Pinellia (Ban Xia)',
                'scientificName' => 'Pinellia ternata',
                'benefits'       => 'TCM journal standard for resolving phlegm and stopping nausea. Harmonizes the stomach.',
                'preparation'    => 'Processing: Must use the processed form (Zhi Ban Xia) to remove toxicity.. Soaking: Soak in warm water if needed.. Boiling: Simmer for 15-20 minutes in a covered pot.',
                'safety'         => 'Contraindicated during pregnancy (consult MD). Irritant if unprocessed.',
                'categoryId'     => $digestive->categoryId,
                'image'          => 'images/herb1.jpg',
                'symptoms'       => [$nausea->symptomId, $bloating->symptomId, $vomiting->symptomId],
            ],
            [
                'herbName'       => 'Bupleurum (Chai Hu)',
                'scientificName' => 'Bupleurum chinense',
                'benefits'       => 'Regulates Liver Qi and resolves stagnation. Key for irritability and mood swings.',
                'preparation'    => 'Cleaning: Gently rinse the dried root.. Setup: Add to a formula with other herbs.. Simmering: Simmer gently. Do not overcook as volatile oils may escape.',
                'safety'         => 'Use caution with Yin deficiency or high blood pressure.',
                'categoryId'     => $mental->categoryId,
                'image'          => 'images/herb16.jpg',
                'symptoms'       => [$stress->symptomId, $mood->symptomId],
            ],
            [
                'herbName'       => 'Fresh Ginger (Sheng Jiang)',
                'scientificName' => 'Zingiber officinale',
                'benefits'       => 'Warms the middle burner and effectively stops vomiting/nausea.',
                'preparation'    => 'Cleaning: Wash the fresh ginger root thoroughly.. Slicing: Slice 3-5 thin pieces.. Steeping: Steep in hot water for 10 minutes or add directly to soup.',
                'safety'         => 'Generally safe. Reduce use if suffering from internal heat signs.',
                'categoryId'     => $digestive->categoryId,
                'image'          => 'images/herb4.png',
                'symptoms'       => [$nausea->symptomId, $vomiting->symptomId],
            ],
            [
                'herbName'       => 'Peppermint (Bo He)',
                'scientificName' => 'Mentha haplocalyx',
                'benefits'       => 'Clears exterior wind-heat. Soothes the throat and clears the eyes.',
                'preparation'    => 'Cleaning: Rinse the dried leaves gently.. Preparation: Prepare your main decoction first.. Steeping: Add peppermint and steep for only 5 minutes at the very end of the decoction.',
                'safety'         => 'Can dry up breast milk. Avoid if breastfeeding.',
                'categoryId'     => $respiratory->categoryId,
                'image'          => 'images/herb5.webp',
                'symptoms'       => [$sorethroat->symptomId, $mood->symptomId],
            ],
            [
                'herbName'       => 'Angelica (Dang Gui)',
                'scientificName' => 'Angelica sinensis',
                'benefits'       => 'The "Success of Ladies" herb. Tonifies and invigorates blood, regulating menses.',
                'preparation'    => 'Slicing: Use pre-sliced dried root.. Soaking: Soak briefly in water.. Decoction: Decoct the roots for 30-40 minutes, often paired with Astragalus.',
                'safety'         => 'Avoid during early pregnancy or if there is severe diarrhea.',
                'categoryId'     => $menstrual->categoryId,
                'image'          => 'images/herb8.jpg',
                'symptoms'       => [$irregular->symptomId, $cramps->symptomId],
            ],
            [
                'herbName'       => 'Sichuan Lovage (Chuan Xiong)',
                'scientificName' => 'Ligusticum chuanxiong',
                'benefits'       => 'Moves Blood and Qi. Effective for menstrual headaches and pain.',
                'preparation'    => 'Cleaning: Rinse the root slices.. Setup: Place in a ceramic pot with sufficient water.. Simmering: Simmer for 30-40 minutes to extract the active compounds.',
                'safety'         => 'Avoid if you have heavy menstrual bleeding.',
                'categoryId'     => $menstrual->categoryId,
                'image'          => 'images/herb19.jpg',
                'symptoms'       => [$cramps->symptomId, $headache->symptomId],
            ],
            [
                'herbName'       => 'Astragalus (Huang Qi)',
                'scientificName' => 'Astragalus membranaceus',
                'benefits'       => 'Tonifies the Spleen and Lungs. Boosts "Wei Qi" (Defensive energy).',
                'preparation'    => 'Preparation: Use large, high-quality slices.. Setup: Add to soups, broths, or tea formulas.. Cooking: Simmer for at least 1 hour to fully extract the beneficial properties.',
                'safety'         => 'Avoid during the acute stage of a common cold or flu.',
                'categoryId'     => $digestive->categoryId,
                'image'          => 'images/herb9.webp',
                'symptoms'       => [$bloating->symptomId, $fatigue->symptomId],
            ],
            [
                'herbName'       => 'Licorice (Gan Cao)',
                'scientificName' => 'Glycyrrhiza uralensis',
                'benefits'       => 'Harmonizes all herbs in a formula. Moistens the lungs and stops cough.',
                'preparation'    => 'Selection: Use honey-roasted (Zhi Gan Cao) for tonifying, or raw for clearing heat.. Setup: Add 3-6g to your formula.. Brewing: Standard simmering along with other herbs in the formula.',
                'safety'         => 'Avoid long-term pure use if you have hypertension.',
                'categoryId'     => $respiratory->categoryId,
                'image'          => 'images/herb6 (2).jpg',
                'symptoms'       => [$cough->symptomId],
            ],
            [
                'herbName'       => 'White Peony (Bai Shao)',
                'scientificName' => 'Paeonia lactiflora',
                'benefits'       => 'Nourishes the Liver and preserves Yin. Stops pain and cramps.',
                'preparation'    => 'Cleaning: Rinse the dried root slices.. Setup: Combine with licorice for muscle spasms.. Decoction: Decoct for 30 minutes until the water reduces to a concentrated dose.',
                'safety'         => 'Avoid if there is diarrhea due to cold.',
                'categoryId'     => $menstrual->categoryId,
                'image'          => 'images/herb13.jpg',
                'symptoms'       => [$cramps->symptomId, $mood->symptomId],
            ],
            [
                'herbName'       => 'Honeysuckle (Jin Yin Hua)',
                'scientificName' => 'Lonicera japonica',
                'benefits'       => 'Clears toxic heat. Excellent for inflammatory sore throats.',
                'preparation'    => 'Sorting: Pick out any impurities from the dried flowers.. Setup: Place in a heat-proof cup or teapot.. Steeping: Pour boiling water over the flowers and steep for 10-15 minutes.',
                'safety'         => 'Use with caution if you have a weak/cold stomach.',
                'categoryId'     => $respiratory->categoryId,
                'image'          => 'images/herb17.jpg',
                'symptoms'       => [$sorethroat->symptomId, $fever->symptomId],
            ],
            [
                'herbName'       => 'Forsythia (Lian Qiao)',
                'scientificName' => 'Forsythia suspensa',
                'benefits'       => 'Clears heat and resolves lumps. Often used for respiratory infections.',
                'preparation'    => 'Preparation: Use the dried fruit.. Setup: Can be used alone or in a formula like Yin Qiao San.. Brewing: Steep or decoct for 15-20 minutes.',
                'safety'         => 'Generally safe. Avoid if diarrhea is present.',
                'categoryId'     => $respiratory->categoryId,
                'image'          => 'images/herb18.jpg',
                'symptoms'       => [$sorethroat->symptomId, $cough->symptomId, $fever->symptomId],
            ],
            [
                'herbName'       => 'Goji Berry (Gou Qi Zi)',
                'scientificName' => 'Lycium barbarum',
                'benefits'       => 'Nourishes Liver and Kidney Yin. Improves sleep and eye health.',
                'preparation'    => 'Rinsing: Briefly rinse the berries.. Usage: Can be eaten raw as a snack.. Steeping: Steep in hot water for 10 minutes to make a nourishing tea.',
                'safety'         => 'Generally safe for all. Avoid in acute phlegm-heat stages.',
                'categoryId'     => $sleep->categoryId,
                'image'          => 'images/herb11.webp',
                'symptoms'       => [$insomnia->symptomId],
            ],
            [
                'herbName'       => 'Poria (Fu Ling)',
                'scientificName' => 'Wolfiporia extensa',
                'benefits'       => 'Promotes urination and leaches out dampness. Calms the mind.',
                'preparation'    => 'Preparation: Use diced or sliced hard sclerotium.. Soaking: Soak in warm water for 20 minutes before cooking.. Decoction: Decoct for at least 45 minutes as it is hard and takes time to extract.',
                'safety'         => 'Avoid if there is frequent/profuse pale urination.',
                'categoryId'     => $sleep->categoryId,
                'image'          => 'images/herb10.avif',
                'symptoms'       => [$restless->symptomId, $bloating->symptomId],
            ],
            [
                'herbName'       => 'Hawthorn (Shan Zha)',
                'scientificName' => 'Crataegus pinnatifida',
                'benefits'       => 'Transforms food stagnation (especially meat). Reduces lipids.',
                'preparation'    => 'Cleaning: Rinse the dried berries.. Setup: Place in a pot with water.. Boiling: Boil into a concentrated tea, simmering for 20-30 minutes.',
                'safety'         => 'Consult practitioner if on heart medication.',
                'categoryId'     => $digestive->categoryId,
                'image'          => 'images/herb14.jpg',
                'symptoms'       => [$bloating->symptomId, $nausea->symptomId],
            ],
            [
                'herbName'       => 'Chrysanthemum (Ju Hua)',
                'scientificName' => 'Chrysanthemum morifolium',
                'benefits'       => 'Clears the Liver and Brightens Eyes. Calms Liver fire headaches.',
                'preparation'    => 'Selection: Use high-quality dried flowers.. Setup: Place in a teapot, often combined with Goji berries.. Steeping: Steep with boiling water for 5-10 minutes.',
                'safety'         => 'Avoid if allergic to ragweed/daisies.',
                'categoryId'     => $mental->categoryId,
                'image'          => 'images/herb7.jpg',
                'symptoms'       => [$mood->symptomId, $headache->symptomId],
            ],
            [
                'herbName'       => 'Atractylodes (Bai Zhu)',
                'scientificName' => 'Atractylodes macrocephala',
                'benefits'       => 'Dries dampness and strengthens Spleen. Prevents miscarriage due to weakness.',
                'preparation'    => 'Processing: Use dry-fried or bran-fried form to increase efficiency.. Setup: Add to the main herbal formula.. Decoction: Decoct for 30 minutes.',
                'safety'         => 'Contraindicated with severe Yin deficiency/thirst.',
                'categoryId'     => $digestive->categoryId,
                'image'          => 'images/herb20.webp',
                'symptoms'       => [$nausea->symptomId, $bloating->symptomId],
            ],
            [
                'herbName'       => 'Lotus Seed (Lian Zi)',
                'scientificName' => 'Nelumbo nucifera',
                'benefits'       => 'Binds the essence and calms the Shen (Mind). Stabilizes sleep.',
                'preparation'    => 'Preparation: Remove the bitter green core if not already done.. Soaking: Soak overnight in water to soften.. Cooking: Cook in sweet soups or congee until tender.',
                'safety'         => 'Avoid during acute constipation or hard stool.',
                'categoryId'     => $sleep->categoryId,
                'image'          => 'images/herb15.jpg',
                'symptoms'       => [$insomnia->symptomId],
            ],
            [
                'herbName'       => 'Cyperus (Xiang Fu)',
                'scientificName' => 'Cyperus rotundus',
                'benefits'       => 'The "Commander" of Qi. Regulates menses and relieves emotional stress.',
                'preparation'    => 'Cleaning: Rinse the rhizome.. Setup: Often paired with Chai Hu or other Qi-regulating herbs.. Decoction: Decoct for 30 minutes.',
                'safety'         => 'Use with caution if there is Heat in the Blood.',
                'categoryId'     => $mental->categoryId,
                'image'          => 'images/herb12.jpg',
                'symptoms'       => [$stress->symptomId, $irregular->symptomId],
            ],
            [
                'herbName'       => 'Perilla Leaf (Su Ye)',
                'scientificName' => 'Perilla frutescens',
                'benefits'       => 'Warms the exterior and resolves seafood poisoning. Calms fetal restlessness.',
                'preparation'    => 'Preparation: Use dried leaves.. Setup: Prepare your main decoction first if combining.. Steeping: Add at the end and steep for 10-15 minutes, as it is very fragrant.',
                'safety'         => 'Avoid with profuse sweating due to exterior deficiency.',
                'categoryId'     => $respiratory->categoryId,
                'image'          => 'images/herb3.jpg',
                'symptoms'       => [$cough->symptomId, $nausea->symptomId],
            ],
        ];

        foreach ($herbs as $herbData) {
            $symptomIds = $herbData['symptoms'];
            unset($herbData['symptoms']);

            $herb = Herb::firstOrCreate(['herbName' => $herbData['herbName']], $herbData);

            foreach ($symptomIds as $symptomId) {
                $symptom = Symptom::find($symptomId);
                HerbSymptom::firstOrCreate([
                    'herbId'    => $herb->herbId,
                    'symptomId' => $symptomId,
                ], [
                    'categoryId' => $symptom->categoryId,
                ]);
            }
        }

        // ── Create Practitioners ──
        $practitionersData = [
            [
                'email' => 'alya@gmail.com',
                'name'  => 'alya',
                'phone' => null,
                'password' => Hash::make('password'),
            ],
            [
                'email' => 'cheeyat@gmail.com',
                'name'  => 'CheeYat',
                'phone' => null,
                'password' => Hash::make('password'),
            ],
            [
                'email' => 'hamzah@gmail.com',
                'name'  => 'Dr hamzah',
                'phone' => '01126262850',
                'password' => Hash::make('password'),
            ],
            [
                'email' => 'practitioner@herbcare.com',
                'name'  => 'Kien Fatt Medical Store',
                'phone' => '+60 17-218 5428',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($practitionersData as $pData) {
            Practitioner::updateOrCreate(['email' => $pData['email']], $pData);
        }

        // ── Create Patients ──
        $patientsData = [
            [
                'email' => 'rinazrusy@gmail.com',
                'name'  => 'rusydina',
                'phone' => '0126075622',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'raisha@gmail.com',
                'name'  => 'raisha',
                'phone' => '01126262850',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'aisyah@gmail.com',
                'name'  => 'aisyah',
                'phone' => '0126545622',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'mimie@gmail.com',
                'name'  => 'mimie',
                'phone' => '01126262850',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'athirah@gmail.com',
                'name'  => 'Athirah',
                'phone' => '0165432198',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'athirah12@gmail.com',
                'name'  => 'Athirah',
                'phone' => '0165432199',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'adriana@gmail.com',
                'name'  => 'adriana',
                'phone' => '0107663253',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'putri@gmail.com',
                'name'  => 'putri sara',
                'phone' => '12345678',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'hidayat@gmail.com',
                'name'  => 'hidayat',
                'phone' => '01126262850',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'amiera@gmail.com',
                'name'  => 'amiera',
                'phone' => '0126584633',
                'password' => Hash::make('12345678'),
            ],
            [
                'email' => 'patient@herbcare.com',
                'name'  => 'Sample Patient',
                'phone' => '+60 12-3456789',
                'password' => Hash::make('12345678'),
            ],
        ];

        $createdPatients = [];
        foreach ($patientsData as $pData) {
            $patient = Patient::updateOrCreate(['email' => $pData['email']], $pData);
            $createdPatients[$pData['email']] = $patient->patientId;
        }

        // ── Create Real Messages / Consultations ──
        $messagesData = [
            [
                'patient_email' => 'aisyah@gmail.com',
                'subject' => 'consultation herbs',
                'message' => 'if i bloated what herbs suitable for my stomach',
                'reply'   => "Ginger\nGood for bloating, nausea, and indigestion.\nTry: ginger tea or a few slices in hot water.\nPeppermint\nMay help relax stomach muscles and reduce gas.\nTry: peppermint tea.\nAvoid if you often get acid reflux/heartburn, since it can worsen that.",
                'replied_at' => '2026-05-12 21:38:03',
                'is_read' => 1,
                'status'  => 'resolved',
            ],
            [
                'patient_email' => 'raisha@gmail.com',
                'subject' => 'consultation herbs',
                'message' => 'i get red rashes in my body which herb suitable to use',
                'reply'   => "Turmeric\nHas anti-inflammatory properties; usually taken in food/tea rather than applied directly (it can stain skin).",
                'replied_at' => '2026-05-12 21:37:26',
                'is_read' => 0,
                'status'  => 'replied',
            ],
            [
                'patient_email' => 'adriana@gmail.com',
                'subject' => 'Frequent Headaches',
                'message' => 'i have headache that makes me cannot sleep what i should do and what herbs should take need a guidance too',
                'reply'   => null,
                'replied_at' => null,
                'is_read' => 0,
                'status'  => 'pending',
            ],
            [
                'patient_email' => 'rinazrusy@gmail.com',
                'subject' => 'stomach ache',
                'message' => 'Hi, I often have stomach bloating after meals. May I know which herbs are suitable for improving digestion?',
                'reply'   => 'Ginger and Hawthorn are often recommended to support digestion and reduce bloating. Avoid overeating and oily foods.',
                'replied_at' => '2026-08-02 15:48:12',
                'is_read' => 0,
                'status'  => 'resolved',
            ],
            [
                'patient_email' => 'hidayat@gmail.com',
                'subject' => 'stress consulting',
                'message' => 'i feel stressed and anxious recently. What do you suggest?',
                'reply'   => null,
                'replied_at' => null,
                'is_read' => 0,
                'status'  => 'pending',
            ],
            [
                'patient_email' => 'amiera@gmail.com',
                'subject' => 'herbal for pregnant women',
                'message' => 'Are these all herbal recommendations safe for pregnant women?',
                'reply'   => 'Not all herbs are suitable during pregnancy. Please consult a healthcare professional before using any herbal medicine.',
                'replied_at' => '2026-08-02 15:53:41',
                'is_read' => 0,
                'status'  => 'replied',
            ],
            [
                'patient_email' => 'putri@gmail.com',
                'subject' => 'Menstrual Cramps Relief',
                'message' => 'I experience painful menstrual cramps every month. Which herbs are recommended for pain relief?',
                'reply'   => null,
                'replied_at' => null,
                'is_read' => 0,
                'status'  => 'pending',
            ],
        ];

        foreach ($messagesData as $mData) {
            $patientEmail = $mData['patient_email'];
            unset($mData['patient_email']);
            if (isset($createdPatients[$patientEmail])) {
                $mData['patientId'] = $createdPatients[$patientEmail];
                Message::updateOrCreate([
                    'patientId' => $mData['patientId'],
                    'subject'   => $mData['subject'],
                ], $mData);
            }
        }
    }
}
