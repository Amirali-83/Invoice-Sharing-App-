<?php
// models/Invoice.php

require_once __DIR__ . '/../config/database.php';

class Invoice {

    public static function create($data) {
        $db = getDB();
        $stmt = $db->prepare("
            INSERT INTO invoices (uploader_name, department_id, team_id, description, filename, original_filename, file_type, file_size)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            'siisssi',
            $data['uploader_name'],
            $data['department_id'],
            $data['team_id'],
            $data['description'],
            $data['filename'],
            $data['original_filename'],
            $data['file_type'],
            $data['file_size']
        );
        $stmt->execute();
        $id = $db->insert_id;
        $stmt->close();
        return $id;
    }

    public static function getAll($status = null, $search = '', $sort = 'uploaded_at', $order = 'DESC') {
        $db = getDB();
        $allowed_sorts = ['uploaded_at', 'uploader_name', 'status', 'file_type'];
        if (!in_array($sort, $allowed_sorts)) $sort = 'uploaded_at';
        $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

        $where = [];
        $params = [];
        $types = '';

        if ($status && in_array($status, ['new', 'noted'])) {
            $where[] = "i.status = ?";
            $params[] = $status;
            $types .= 's';
        }
        if ($search) {
            $where[] = "(i.uploader_name LIKE ? OR i.description LIKE ? OR d.name LIKE ? OR t.name LIKE ?)";
            $like = "%$search%";
            $params = array_merge($params, [$like, $like, $like, $like]);
            $types .= 'ssss';
        }

        $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        $sql = "
            SELECT i.*, d.name AS department_name, t.name AS team_name
            FROM invoices i
            JOIN departments d ON i.department_id = d.id
            JOIN teams t ON i.team_id = t.id
            $whereClause
            ORDER BY i.$sort $order
        ";

        $stmt = $db->prepare($sql);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public static function getById($id) {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT i.*, d.name AS department_name, t.name AS team_name
            FROM invoices i
            JOIN departments d ON i.department_id = d.id
            JOIN teams t ON i.team_id = t.id
            WHERE i.id = ?
        ");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $result;
    }

    public static function updateStatus($id, $status) {
        $db = getDB();
        $noted_at = $status === 'noted' ? date('Y-m-d H:i:s') : null;
        $stmt = $db->prepare("UPDATE invoices SET status = ?, noted_at = ? WHERE id = ?");
        $stmt->bind_param('ssi', $status, $noted_at, $id);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return $affected;
    }

    public static function bulkUpdateStatus($ids, $status) {
        $db = getDB();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $noted_at = $status === 'noted' ? date('Y-m-d H:i:s') : null;
        $types = str_repeat('i', count($ids));
        $stmt = $db->prepare("UPDATE invoices SET status = ?, noted_at = ? WHERE id IN ($placeholders)");
        $stmt->bind_param('ss' . $types, $status, $noted_at, ...$ids);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();
        return $affected;
    }

    public static function getStats() {
        $db = getDB();
        $result = $db->query("
            SELECT
                COUNT(*) AS total,
                SUM(status = 'new') AS new_count,
                SUM(status = 'noted') AS noted_count,
                SUM(file_type = 'application/pdf') AS pdf_count,
                SUM(file_type LIKE 'image/%') AS image_count
            FROM invoices
        ");
        return $result->fetch_assoc();
    }
}
