<?php
// controllers/AdminController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Invoice.php';

class AdminController {

    private function requireAuth() {
        session_start();
        if (empty($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASE_URL . 'admin/login');
            exit;
        }
    }

    public function login() {
        session_start();
        if (!empty($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASE_URL . 'admin/dashboard');
            exit;
        }
        $error = '';
        require __DIR__ . '/../views/admin/login.php';
    }

    public function loginPost() {
        session_start();
        header('Content-Type: application/json');
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
            $_SESSION['admin_logged_in'] = true;
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
        }
        exit;
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ' . BASE_URL . 'admin/login');
        exit;
    }

    public function dashboard() {
        $this->requireAuth();
        $status  = $_GET['status'] ?? '';
        $search  = $_GET['search'] ?? '';
        $sort    = $_GET['sort'] ?? 'uploaded_at';
        $order   = $_GET['order'] ?? 'DESC';

        $invoices = Invoice::getAll(
            in_array($status, ['new', 'noted']) ? $status : null,
            $search,
            $sort,
            $order
        );
        $stats = Invoice::getStats();

        require __DIR__ . '/../views/admin/dashboard.php';
    }

    public function updateStatus() {
        $this->requireAuth();
        header('Content-Type: application/json');

        $ids    = $_POST['ids'] ?? [];
        $status = $_POST['status'] ?? '';

        if (!is_array($ids) || empty($ids) || !in_array($status, ['new', 'noted'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid request.']);
            exit;
        }

        $ids = array_map('intval', $ids);
        $affected = Invoice::bulkUpdateStatus($ids, $status);

        echo json_encode(['success' => true, 'affected' => $affected]);
        exit;
    }

    public function download() {
        $this->requireAuth();
        $id = intval($_GET['id'] ?? 0);
        $invoice = Invoice::getById($id);

        if (!$invoice) {
            http_response_code(404);
            die('File not found.');
        }

        $path = UPLOAD_DIR . $invoice['filename'];
        if (!file_exists($path)) {
            http_response_code(404);
            die('File not found on server.');
        }

        header('Content-Type: ' . $invoice['file_type']);
        header('Content-Disposition: attachment; filename="' . $invoice['original_filename'] . '"');
        header('Content-Length: ' . filesize($path));
        header('Cache-Control: private');
        readfile($path);
        exit;
    }

    public function preview() {
        $this->requireAuth();
        $id = intval($_GET['id'] ?? 0);
        $invoice = Invoice::getById($id);

        if (!$invoice) {
            http_response_code(404);
            die('File not found.');
        }

        $path = UPLOAD_DIR . $invoice['filename'];
        if (!file_exists($path)) {
            http_response_code(404);
            die('File not found on server.');
        }

        header('Content-Type: ' . $invoice['file_type']);
        header('Content-Disposition: inline; filename="' . $invoice['original_filename'] . '"');
        header('Content-Length: ' . filesize($path));
        readfile($path);
        exit;
    }
}
