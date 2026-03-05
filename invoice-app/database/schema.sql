-- Invoice Sharing Application Database Schema
-- Import this in phpMyAdmin or run via MySQL CLI

CREATE DATABASE IF NOT EXISTS invoice_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE invoice_app;

CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    department_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    uploader_name VARCHAR(150) NOT NULL,
    department_id INT NOT NULL,
    team_id INT NOT NULL,
    description TEXT NOT NULL,
    filename VARCHAR(255) NOT NULL,
    original_filename VARCHAR(255) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    file_size INT NOT NULL,
    status ENUM('new', 'noted') DEFAULT 'new',
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    noted_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (department_id) REFERENCES departments(id),
    FOREIGN KEY (team_id) REFERENCES teams(id)
);

-- Seed departments and teams
INSERT INTO departments (name) VALUES
('Operations'),
('Human Resources'),
('Marketing'),
('Engineering'),
('Sales'),
('Legal'),
('Procurement'),
('Logistics');

INSERT INTO teams (department_id, name) VALUES
(1, 'Operations - Alpha Team'),
(1, 'Operations - Beta Team'),
(2, 'HR - Recruitment'),
(2, 'HR - Payroll'),
(3, 'Marketing - Digital'),
(3, 'Marketing - Events'),
(4, 'Engineering - Frontend'),
(4, 'Engineering - Backend'),
(4, 'Engineering - DevOps'),
(5, 'Sales - Enterprise'),
(5, 'Sales - SMB'),
(6, 'Legal - Compliance'),
(6, 'Legal - Contracts'),
(7, 'Procurement - Vendor Relations'),
(7, 'Procurement - Assets'),
(8, 'Logistics - Domestic'),
(8, 'Logistics - International');
