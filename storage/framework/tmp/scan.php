<?php
$h = file_get_contents(__DIR__.'/live-home.html');
preg_match_all('#(?:src|href)=["\']([^"\']+)#', $h, $m);
foreach (array_unique($m[1]) as $url) {
    if (stripos($url, 'slider') !== false || stripos($url, 'storage') !== false || stripos($url, '.webp') !== false || stripos($url, '.png') !== false || stripos($url, '.jpg') !== false) {
        echo $url, "\n";
    }
}
