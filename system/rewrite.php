<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

/*
 *---------------------------------------------------------------
 * REWRITE PHP FOR DEVELOPMENT SERVER
 *---------------------------------------------------------------
 *
 * This file handles URL rewriting for the built-in PHP development server.
 * It mimics Apache's mod_rewrite functionality.
 */

// Get the requested URI
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Remove the query string from the URI
if (strpos($uri, '?') !== false) {
    $uri = substr($uri, 0, strpos($uri, '?'));
}

// Remove the leading slash
$uri = ltrim($uri, '/');

// If the URI is empty or points to a file/directory that exists, serve it directly
if ($uri === '' || $uri === '/' || file_exists(__DIR__ . '/../public/' . $uri)) {
    return false; // Let the server handle it normally
}

// For all other requests, route through index.php
$_SERVER['PATH_INFO'] = '/' . $uri;
$_SERVER['SCRIPT_NAME'] = '/index.php';

include __DIR__ . '/../public/index.php';
