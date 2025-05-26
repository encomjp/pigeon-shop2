<?php
// Define the image mappings
$imageMap = [
    "https://img.freepik.com/psd-premium/taube-png-taube-auf-transparentem-hintergrund-png-herunterladen_303714-5904.jpg" => "../assets/images/logo.jpg",
    "https://i.imgur.com/WtWdQ9s.gif" => "../assets/images/background.gif",
    "https://www.allaboutbirds.org/guide/assets/photo/308074031-480px.jpg" => "../assets/images/city-pigeon.jpg",
    "https://nas-national-prod.s3.amazonaws.com/styles/hero_image/s3/Rock-Pigeon_KK_APA_2011_27391_232647_DavidBroadwell.jpg" => "../assets/images/pigeon-portrait.jpg",
    "https://ih1.redbubble.net/image.1810514256.7019/ra,kids_tee,x900,FFFFFF:97ab1c12de,front-pad,750x1000,f8f8f8.jpg" => "../assets/images/tshirt.jpg",
    "https://m.media-amazon.com/images/I/51cGg-0MugL._AC_UL1000_.jpg" => "../assets/images/mug.jpg",
    "https://m.media-amazon.com/images/I/612fc5TOwIL._AC_UF1000,1000_QL80_.jpg" => "../assets/images/keychain.jpg",
    "https://cdn.pixabay.com/photo/2017/07/18/18/24/dove-2516641_1280.jpg" => "../assets/images/photography-course.jpg",
    "https://upload.wikimedia.org/wikipedia/commons/thumb/4/4d/Rock_Pigeon_Columba_livia.jpg/1200px-Rock_Pigeon_Columba_livia.jpg" => "../assets/images/urban-pigeons.jpg"
];

// Define directories to check
$directories = [
    __DIR__ . "/../",
    __DIR__ . "/../pages/",
    __DIR__ . "/../css/",
    __DIR__ . "/../bestellung/",
    __DIR__ . "/../config/"
];

// File extensions to process
$fileExtensions = ['html', 'php', 'css', 'js'];

$count = 0;
$files = [];

// Get all files recursively
foreach ($directories as $directory) {
    if (is_dir($directory)) {
        $directoryIterator = new RecursiveDirectoryIterator($directory);
        $iterator = new RecursiveIteratorIterator($directoryIterator);
        
        foreach ($iterator as $file) {
            $extension = strtolower(pathinfo($file->getPathname(), PATHINFO_EXTENSION));
            if (in_array($extension, $fileExtensions) && $file->isFile()) {
                $files[] = $file->getPathname();
            }
        }
    }
}

// Process each file
foreach ($files as $file) {
    $content = file_get_contents($file);
    $originalContent = $content;
    
    foreach ($imageMap as $oldUrl => $newUrl) {
        // Adjust path based on file location
        $adjustedPath = $newUrl;
        $fileDir = dirname($file);
        $rootDir = __DIR__ . "/../";
        
        // Calculate relative path
        $relativePath = str_replace($rootDir, "", $fileDir);
        if (!empty($relativePath)) {
            $depth = count(explode('/', $relativePath));
            $adjustedPath = str_repeat("../", $depth) . "assets/images/" . basename($newUrl);
        } else {
            $adjustedPath = "assets/images/" . basename($newUrl);
        }
        
        // Replace URLs in quotes (HTML/CSS)
        $content = str_replace('"' . $oldUrl . '"', '"' . $adjustedPath . '"', $content);
        $content = str_replace("'" . $oldUrl . "'", "'" . $adjustedPath . "'", $content);
        
        // Replace URLs in CSS (without quotes)
        $content = str_replace("url(" . $oldUrl . ")", "url(" . $adjustedPath . ")", $content);
        $content = str_replace("url('" . $oldUrl . "')", "url('" . $adjustedPath . "')", $content);
        $content = str_replace('url("' . $oldUrl . '")', 'url("' . $adjustedPath . '")', $content);
    }
    
    // Save the file if changes were made
    if ($content !== $originalContent) {
        file_put_contents($file, $content);
        echo "Updated: " . $file . PHP_EOL;
        $count++;
    }
}

echo "Done! Updated {$count} files.\n";

?>
