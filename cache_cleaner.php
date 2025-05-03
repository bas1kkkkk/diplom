<?php

// Функція для очищення старих кеш-файлів (старше 4 днів)
function cleanCache($maxAgeSeconds = 345600) {
    $cacheDir = __DIR__ . '/cache';

    // Перевірка
    if (!is_dir($cacheDir)) {
        return; 
    }

    
    $files = scandir($cacheDir);

    foreach ($files as $file) {
        $filePath = $cacheDir . '/' . $file;

        
        if ($file == '.' || $file == '..') {
            continue;
        }

      
        if (filemtime($filePath) < (time() - $maxAgeSeconds)) {
            
            unlink($filePath);
        }
    }
}

?>
