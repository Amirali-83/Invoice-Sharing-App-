<?php
// controllers/UploadController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Invoice.php';
require_once __DIR__ . '/../models/Department.php';

class UploadController {

    public function index() {
        $departments = Department::getAllWithTeams();
        require __DIR__ . '/../views/uploader/upload_form.php';
    }

    public function getTeams() {
        header('Content-Type: application/json');
        $dept_id = intval($_GET['department_id'] ?? 0);
        if (!$dept_id) {
            echo json_encode([]);
            exit;
        }
        $teams = Department::getTeamsByDepartment($dept_id);
        echo json_encode($teams);
        exit;
    }

    public function store() {
        header('Content-Type: application/json');

        // Validate inputs
        $errors = [];

        $uploader_name = trim($_POST['uploader_name'] ?? '');
        $department_id  = intval($_POST['department_id'] ?? 0);
        $team_id        = intval($_POST['team_id'] ?? 0);
        $description    = trim($_POST['description'] ?? '');

        if (empty($uploader_name))  $errors[] = 'Your name is required.';
        if (!$department_id)        $errors[] = 'Please select a department.';
        if (!$team_id)              $errors[] = 'Please select a team.';
        if (empty($description))    $errors[] = 'Invoice description is required.';

        if (!isset($_FILES['invoice_file']) || $_FILES['invoice_file']['error'] === UPLOAD_ERR_NO_FILE) {
            $errors[] = 'Please upload a file.';
        } elseif ($_FILES['invoice_file']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'File upload error. Please try again.';
        } else {
            $file = $_FILES['invoice_file'];

            if ($file['size'] > MAX_FILE_SIZE) {
                $errors[] = 'File size must not exceed 10MB.';
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($mime, ALLOWED_TYPES) || !in_array($ext, ALLOWED_EXTENSIONS)) {
                $errors[] = 'Only JPG, PNG, GIF, WEBP, and PDF files are allowed.';
            }
        }

        if ($errors) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            exit;
        }

        // Save file
        if (!is_dir(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0755, true);
        }

        $file = $_FILES['invoice_file'];
        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $unique_name = uniqid('inv_', true) . '.' . $ext;
        $dest = UPLOAD_DIR . $unique_name;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            echo json_encode(['success' => false, 'errors' => ['Failed to save file. Please try again.']]);
            exit;
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $dest);
        finfo_close($finfo);

        $id = Invoice::create([
            'uploader_name'    => $uploader_name,
            'department_id'    => $department_id,
            'team_id'          => $team_id,
            'description'      => $description,
            'filename'         => $unique_name,
            'original_filename'=> $file['name'],
            'file_type'        => $mime,
            'file_size'        => $file['size'],
        ]);

        echo json_encode(['success' => true, 'id' => $id, 'message' => 'Invoice submitted successfully!']);
        exit;
    }
}
