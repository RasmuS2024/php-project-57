<?php

$excludedDirs = ['vendor', 'node_modules', 'storage', '.git']; // Исключаемые директории
$basePath = __DIR__; // Корень проекта

$dirIterator = new RecursiveDirectoryIterator($basePath, RecursiveDirectoryIterator::SKIP_DOTS);
$filterIterator = new RecursiveCallbackFilterIterator($dirIterator, function ($current) use ($excludedDirs, $basePath) {
    foreach ($excludedDirs as $dir) {
        if (strpos($current->getPathname(), "/$dir/") !== false) {
            return false;
        }
    }
    return true;
});

$iterator = new RecursiveIteratorIterator($filterIterator);
$commentedFiles = [];

foreach ($iterator as $file) {
    if ($file->isFile() && in_array($file->getExtension(), ['php', 'blade.php'])) {
        $path = $file->getPathname();
        $tokens = token_get_all(file_get_contents($path));

        foreach ($tokens as $token) {
            if (is_array($token) && ($token[0] === T_COMMENT || $token[0] === T_DOC_COMMENT)) {
                $commentedFiles[] = $path;
                break; // Прерываем после первого найденного комментария
            }
        }
    }
}

echo "Файлы с комментариями (" . count($commentedFiles) . "):\n";
echo "----------------------------------------\n";
foreach (array_unique($commentedFiles) as $file) {
    echo "- " . str_replace($basePath . '/', '', $file) . "\n";
}
