<?php
$file = 'database/seeders/HerbDataSeeder.php';
$content = file_get_contents($file);

$images = [
    'images/herb1.jpg',
    'images/herb2.jpg',
    'images/herb3.jpg',
    'images/herb4.png',
    'images/herb5.png',
    'images/herb6.jpg',
    'images/herb7.webp',
    'images/herb8.jpg',
    'images/herb9.jpg',
    'images/herb10.jpg',
    'images/herb11.jpg',
    'images/herb12.png',
    'images/herb13.jpg',
    'images/herb14.jpg',
    'images/herb15.jpg',
    'images/herb16.jpg',
    'images/herb17.jpg',
    'images/herb18.jpg',
    'images/herb19.jpg',
    'images/herb10 copy.jpg',
];

$i = 0;
// Replace Unsplash URLs with local asset paths based on position
$content = preg_replace_callback('/\'image\'\s*=>\s*\'https:\/\/images\.unsplash\.com[^\']*\'/', function($matches) use (&$i, $images) {
    if ($i >= count($images)) $i = 0; 
    $img = $images[$i++];
    return "'image'          => '" . $img . "'";
}, $content);

file_put_contents($file, $content);
echo "Seeder updated successfully.\n";
