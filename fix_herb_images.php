<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$files = File::files(public_path('images'));
$fileMap = [];

foreach ($files as $file) {
    $name = $file->getFilename();
    if (preg_match('/^herb(\d+)/', $name, $matches)) {
        $num = $matches[1];
        $fileMap[$num] = 'images/' . $name;
    }
}

foreach ($fileMap as $num => $path) {
    // Update any herb that has a path starting with images/herb[num]. or images/herb[num] (space)
    $affected = DB::table('herbs')
        ->where('image', 'like', "images/herb{$num}.%")
        ->orWhere('image', 'like', "images/herb{$num} %")
        ->update(['image' => $path]);
    
    if ($affected) {
        echo "Updated herb{$num} to {$path}\n";
    }
}

echo "Done!\n";
