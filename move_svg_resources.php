<?php

$originPath = '.../heroicons-0.4.2/optimized';
$destPath = __DIR__.'/resources/svg';

$move = function ($styleDirectory, $svgPrefix) use ($originPath, $destPath) {
    $it = new DirectoryIterator("$originPath/$styleDirectory");
    foreach ($it as $file) {
        copy($file->getPathname(), "$destPath/$svgPrefix".$file->getFilename());
    }
};

$move('outline', 'o-');
$move('solid', 's-');
