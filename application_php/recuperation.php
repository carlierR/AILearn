<?php

$file = 'donnee.csv';
$content = file_get_contents('data.csv');
$content = str_replace(',', ';', $content);
file_put_contents($file, $content);
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
} else {
    echo "le fichier n'existe pas";
}
