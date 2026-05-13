<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($files as $file) {
    $filePath = $file[0];
    $content = file_get_contents($filePath);

    // Skip layout files themselves
    if (strpos($filePath, 'resources/views/layouts/') !== false) {
        continue;
    }

    $modified = false;

    // Check if it uses @extends('layouts.app')
    if (preg_match('/@extends\([\'"]layouts\.app[\'"]\)/', $content)) {
        // Extract title
        $title = '';
        if (preg_match('/@section\([\'"]title[\'"],\s*[\'"]([^\'"]+)[\'"]\)/', $content, $m)) {
            $title = $m[1];
            $content = preg_replace('/@section\([\'"]title[\'"],\s*[\'"][^\'"]+[\'"]\)\s*/', '', $content);
        }

        // Replace @extends
        $appLayoutTag = '<x-app-layout' . ($title ? " title=\"$title\"" : "") . '>';
        $content = preg_replace('/@extends\([\'"]layouts\.app[\'"]\)\s*/', $appLayoutTag . "\n", $content);
        
        // Replace @section('content')
        $content = preg_replace('/@section\([\'"]content[\'"]\)\s*/', '', $content);
        
        // Replace @endsection
        // The last @endsection corresponds to content, usually.
        // Or we can just replace @endsection with </x-app-layout> but there might be other sections?
        // Usually, in these files, @endsection is used for content.
        
        // Let's count sections
        // Actually, just find the last @endsection and replace it. Or replace all @endsection if they are for content.
        // Wait, @section('content') might have a matching @endsection.
        
        $modified = true;
    }

    if ($modified) {
        // file_put_contents($filePath, $content);
        // echo "Modified $filePath\n";
    }
}
