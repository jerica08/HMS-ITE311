<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Get the path relative to the public directory
$path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// If the file exists in the public directory, serve it directly
if ($path !== '/' && file_exists(__DIR__ . '/../public' . $path)) {
    return false;
}

// Otherwise, route to index.php
require_once __DIR__ . '/../public/index.php';
