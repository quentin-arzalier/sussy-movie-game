<?php

function file_get_contents_utf8($fn) {
    $content = file_get_contents($fn);
    $encoding = mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true);
    return mb_convert_encoding($content, 'UTF-8', $encoding);
}