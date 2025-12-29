<?php
// Detect protocol (http or https)
if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
    $protocol = $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ? 'https://' : 'http://';
} elseif (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}


// Host (localhost, domain.com, etc.)
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Project folder relative to web root
$projectFolder = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\', '/', __DIR__ . '/..'));

// URL base (for <a>, <img>, CSS, etc.)
$base_path = rtrim($protocol . $host . $projectFolder, '/') . '/';

// Filesystem root (for file_exists, require, include, etc.)
$project_root = rtrim(realpath(__DIR__ . '/..'), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;