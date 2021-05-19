<?php
header('Content-Type: text/plain');

require_once __DIR__ . '/includes/misc.php';
require_once __DIR__ . '/includes/graphdraw.php';

if (!extension_loaded('gd')) error('PHP GD is required! Uncomment "extension=gd" in Your "php.ini" file!');

// Determine if name of file with adjacency list is given as as parameter
if (isset($argv[1])) {
    // Get filename from parameter
    $filename = $argv[1];
} else {
    // Get filename from STDIN
    echo "> ";
    $filename = input();
}

// Get list from file or directly from user
$adjacency_list = is_file($filename) ? file_get_contents($filename) : $filename;

// If script cannot decode list, exit with error message
$adjacency_list = json_decode($adjacency_list) or error("Failed to decode given adjacency list.");

// Call GraphDraw to create PNG image with graph visualisation
generate_image($adjacency_list, __DIR__ . '/graph.png');
