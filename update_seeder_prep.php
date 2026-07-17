<?php
$file = 'database/seeders/HerbDataSeeder.php';
$content = file_get_contents($file);

$preps = [
    'Jujube Seed (Suan Zao Ren)' => 'Sorting: Select clean, high-quality seeds.. Crushing: Lightly crush the seeds before use to release active compounds.. Decoction: Decoct 9-15g in water, or take as a ground powder before bed.',
    'Pinellia (Ban Xia)' => 'Processing: Must use the processed form (Zhi Ban Xia) to remove toxicity.. Soaking: Soak in warm water if needed.. Boiling: Simmer for 15-20 minutes in a covered pot.',
    'Bupleurum (Chai Hu)' => 'Cleaning: Gently rinse the dried root.. Setup: Add to a formula with other herbs.. Simmering: Simmer gently. Do not overcook as volatile oils may escape.',
    'Fresh Ginger (Sheng Jiang)' => 'Cleaning: Wash the fresh ginger root thoroughly.. Slicing: Slice 3-5 thin pieces.. Steeping: Steep in hot water for 10 minutes or add directly to soup.',
    'Peppermint (Bo He)' => 'Cleaning: Rinse the dried leaves gently.. Preparation: Prepare your main decoction first.. Steeping: Add peppermint and steep for only 5 minutes at the very end of the decoction.',
    'Angelica (Dang Gui)' => 'Slicing: Use pre-sliced dried root.. Soaking: Soak briefly in water.. Decoction: Decoct the roots for 30-40 minutes, often paired with Astragalus.',
    'Sichuan Lovage (Chuan Xiong)' => 'Cleaning: Rinse the root slices.. Setup: Place in a ceramic pot with sufficient water.. Simmering: Simmer for 30-40 minutes to extract the active compounds.',
    'Astragalus (Huang Qi)' => 'Preparation: Use large, high-quality slices.. Setup: Add to soups, broths, or tea formulas.. Cooking: Simmer for at least 1 hour to fully extract the beneficial properties.',
    'Licorice (Gan Cao)' => 'Selection: Use honey-roasted (Zhi Gan Cao) for tonifying, or raw for clearing heat.. Setup: Add 3-6g to your formula.. Brewing: Standard simmering along with other herbs in the formula.',
    'White Peony (Bai Shao)' => 'Cleaning: Rinse the dried root slices.. Setup: Combine with licorice for muscle spasms.. Decoction: Decoct for 30 minutes until the water reduces to a concentrated dose.',
    'Honeysuckle (Jin Yin Hua)' => 'Sorting: Pick out any impurities from the dried flowers.. Setup: Place in a heat-proof cup or teapot.. Steeping: Pour boiling water over the flowers and steep for 10-15 minutes.',
    'Forsythia (Lian Qiao)' => 'Preparation: Use the dried fruit.. Setup: Can be used alone or in a formula like Yin Qiao San.. Brewing: Steep or decoct for 15-20 minutes.',
    'Goji Berry (Gou Qi Zi)' => 'Rinsing: Briefly rinse the berries.. Usage: Can be eaten raw as a snack.. Steeping: Steep in hot water for 10 minutes to make a nourishing tea.',
    'Poria (Fu Ling)' => 'Preparation: Use diced or sliced hard sclerotium.. Soaking: Soak in warm water for 20 minutes before cooking.. Decoction: Decoct for at least 45 minutes as it is hard and takes time to extract.',
    'Hawthorn (Shan Zha)' => 'Cleaning: Rinse the dried berries.. Setup: Place in a pot with water.. Boiling: Boil into a concentrated tea, simmering for 20-30 minutes.',
    'Chrysanthemum (Ju Hua)' => 'Selection: Use high-quality dried flowers.. Setup: Place in a teapot, often combined with Goji berries.. Steeping: Steep with boiling water for 5-10 minutes.',
    'Atractylodes (Bai Zhu)' => 'Processing: Use dry-fried or bran-fried form to increase efficiency.. Setup: Add to the main herbal formula.. Decoction: Decoct for 30 minutes.',
    'Lotus Seed (Lian Zi)' => 'Preparation: Remove the bitter green core if not already done.. Soaking: Soak overnight in water to soften.. Cooking: Cook in sweet soups or congee until tender.',
    'Cyperus (Xiang Fu)' => 'Cleaning: Rinse the rhizome.. Setup: Often paired with Chai Hu or other Qi-regulating herbs.. Decoction: Decoct for 30 minutes.',
    'Perilla Leaf (Su Ye)' => 'Preparation: Use dried leaves.. Setup: Prepare your main decoction first if combining.. Steeping: Add at the end and steep for 10-15 minutes, as it is very fragrant.'
];

foreach ($preps as $herbName => $prepMethod) {
    // Escape single quotes if any
    $prepMethodEscaped = addslashes($prepMethod);
    
    // Find the block for this herb and replace its preparation line
    $pattern = "/('herbName'\s*=>\s*'" . preg_quote($herbName, '/') . "'.*?'preparation'\s*=>\s*)'.*?'/s";
    $replacement = "$1'$prepMethodEscaped'";
    $content = preg_replace($pattern, $replacement, $content);
}

file_put_contents($file, $content);
echo "Seeder file updated.\n";
