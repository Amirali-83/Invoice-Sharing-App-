<?php
// models/Department.php

require_once __DIR__ . '/../config/database.php';

class Department {

    public static function getAll() {
        $db = getDB();
        $result = $db->query("SELECT * FROM departments ORDER BY name ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getTeamsByDepartment($department_id) {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM teams WHERE department_id = ? ORDER BY name ASC");
        $stmt->bind_param('i', $department_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    public static function getAllWithTeams() {
        $db = getDB();
        $result = $db->query("
            SELECT d.id AS dept_id, d.name AS dept_name, t.id AS team_id, t.name AS team_name
            FROM departments d
            LEFT JOIN teams t ON d.id = t.department_id
            ORDER BY d.name, t.name
        ");
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $grouped = [];
        foreach ($rows as $row) {
            if (!isset($grouped[$row['dept_id']])) {
                $grouped[$row['dept_id']] = ['id' => $row['dept_id'], 'name' => $row['dept_name'], 'teams' => []];
            }
            if ($row['team_id']) {
                $grouped[$row['dept_id']]['teams'][] = ['id' => $row['team_id'], 'name' => $row['team_name']];
            }
        }
        return array_values($grouped);
    }
}
