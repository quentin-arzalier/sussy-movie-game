<?php

function file_get_contents_utf8($fn) {
    $content = file_get_contents($fn);
    $encoding = mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true);
    return mb_convert_encoding($content, 'UTF-8', $encoding);
}


function get_file_path(array $pathArray): string {
    $path = __DIR__ . DIRECTORY_SEPARATOR . ".."; // Nous sommes dans Helpers/ Donc il faut retourner à la racine
    foreach ($pathArray as $pathItem) {
        $path = $path . DIRECTORY_SEPARATOR . $pathItem;
    }
    return $path;
}