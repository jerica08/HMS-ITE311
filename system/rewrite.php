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
 * --------------------------------------------------------------------
 * Rewrite rules for the built-in PHP web server.
 * --------------------------------------------------------------------
 * This file provides rewrite rules for use with the built-in PHP web server.
 * During development, it can be useful to use PHP's built-in web server.
 * This eliminates the need for installing a "real" web server software
 * here on the development machine.
 *
 * Usage:
 *  php -S localhost:8080 -t public/ system/rewrite.php
 */

// Get the file path from the request URI
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// If the file exists as a static file, serve it directly
if ($uri !== '/' && file_exists(__DIR__ . '/../public' . $uri)) {
    return false;
}

// Otherwise, deliver the request to CodeIgniter's front controller
require_once __DIR__ . '/../public/index.php';
