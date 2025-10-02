<?php
// rewrite.php - Simple URL rewrite handler for routing requests

// Get the requested URI path
$requestUri = $_SERVER['REQUEST_URI'];

// Remove query string if exists
$requestPath = parse_url($requestUri, PHP_URL_PATH);

// Define the base directory to handle routing, adjust if needed
$baseDir = '/HMS-ITE311/';

// Remove base directory from path if applicable
if (strpos($requestPath, $baseDir) === 0) {
    $requestPath = substr($requestPath, strlen($baseDir));
}

// Example basic routing logic: route all requests to index.php with the path as a parameter
// You can expand this logic based on needs
$_GET['route'] = $requestPath;

// Include main index file to handle the request routing
require_once __DIR__ . '/../public/index.php';
