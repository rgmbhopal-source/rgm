-- Database Schema for Contact Inquiry System
-- This would be used in a real PHP/MySQL implementation

CREATE DATABASE IF NOT EXISTS business_solutions;
USE business_solutions;

-- Inquiries Table
CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('New', 'In Progress', 'Resolved') DEFAULT 'New',
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_submitted_at (submitted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Example PHP code for database connection (config.php)
/*
<?php
$host = 'localhost';
$dbname = 'business_solutions';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
*/

-- Example PHP code for inserting inquiry (submit_inquiry.php)
/*
<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $sql = "INSERT INTO inquiries (name, email, phone, subject, message) 
            VALUES (:name, :email, :phone, :subject, :message)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':subject' => $subject,
        ':message' => $message
    ]);
    
    echo json_encode(['success' => true, 'message' => 'Inquiry submitted successfully']);
}
?>
*/

-- Example PHP code for viewing inquiries (get_inquiries.php)
/*
<?php
require_once 'config.php';

$sql = "SELECT * FROM inquiries ORDER BY submitted_at DESC";
$stmt = $pdo->query($sql);
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($inquiries);
?>
*/
