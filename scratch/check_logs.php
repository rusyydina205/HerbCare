<?php
$logFile = __DIR__ . '/../storage/logs/laravel.log';
if (!file_exists($logFile)) {
    echo "Log file does not exist\n";
    exit(1);
}

$lines = file($logFile);
// Search for "local.ERROR" in the last 2000 lines
$errorLines = [];
$totalLines = count($lines);
$startIndex = max(0, $totalLines - 2000);
for ($i = $startIndex; $i < $totalLines; $i++) {
    if (strpos($lines[$i], 'local.ERROR') !== false) {
        // Collect this line and the next 10 lines for stacktrace context
        $errorLines[] = "--- ERROR AT LINE $i ---";
        for ($j = 0; $j < 15 && ($i + $j) < $totalLines; $j++) {
            $errorLines[] = $lines[$i + $j];
        }
    }
}

echo implode("", array_slice($errorLines, -100));
