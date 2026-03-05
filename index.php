<?php
// index.php - Front controller / router

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/UploadController.php';
require_once __DIR__ . '/controllers/AdminController.php';

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Strip base folder from URI if running in subfolder e.g. /invoice-app/
$base = trim(parse_url(BASE_URL, PHP_URL_PATH), '/');
if ($base && strpos($uri, $base) === 0) {
    $uri = trim(substr($uri, strlen($base)), '/');
}

$method = $_SERVER['REQUEST_METHOD'];

// ──────────────────────────────────────────────
// Routes
// ──────────────────────────────────────────────

// Uploader
if ($uri === '' || $uri === 'upload') {
    (new UploadController())->index();

} elseif ($uri === 'upload/store' && $method === 'POST') {
    (new UploadController())->store();

} elseif ($uri === 'upload/teams' && $method === 'GET') {
    (new UploadController())->getTeams();

// Admin
} elseif ($uri === 'admin' || $uri === 'admin/login') {
    (new AdminController())->login();

} elseif ($uri === 'admin/login' && $method === 'POST') {
    (new AdminController())->loginPost();

} elseif ($uri === 'admin/login/post' && $method === 'POST') {
    (new AdminController())->loginPost();

} elseif ($uri === 'admin/logout') {
    (new AdminController())->logout();

} elseif ($uri === 'admin/dashboard') {
    (new AdminController())->dashboard();

} elseif ($uri === 'admin/status' && $method === 'POST') {
    (new AdminController())->updateStatus();

} elseif ($uri === 'admin/download') {
    (new AdminController())->download();

} elseif ($uri === 'admin/preview') {
    (new AdminController())->preview();

} else {
    http_response_code(404);
    echo '<!DOCTYPE html><html><body style="font-family:sans-serif;text-align:center;padding:80px">
    <h1>404 Not Found</h1><a href="' . BASE_URL . '">Go Home</a></body></html>';
}
