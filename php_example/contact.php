<?php
/**
 * Contact Form Handler - PHP Example
 * This file demonstrates how the contact form would work in a real PHP environment
 */

// Database configuration
$host = 'localhost';
$dbname = 'business_solutions';
$username = 'root';
$password = '';

// Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Handle POST request (form submission)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Get POST data
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');
        
        // Validation
        $errors = [];
        
        if (empty($name)) {
            $errors['name'] = 'Name is required';
        }
        
        if (empty($email)) {
            $errors['email'] = 'Email is required';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Invalid email format';
        }
        
        if (empty($phone)) {
            $errors['phone'] = 'Phone is required';
        }
        
        if (empty($subject)) {
            $errors['subject'] = 'Subject is required';
        }
        
        if (empty($message)) {
            $errors['message'] = 'Message is required';
        }
        
        // If there are validation errors, return them
        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'errors' => $errors
            ]);
            exit;
        }
        
        // Insert into database
        $sql = "INSERT INTO inquiries (name, email, phone, subject, message, status) 
                VALUES (:name, :email, :phone, :subject, :message, 'New')";
        
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':subject' => $subject,
            ':message' => $message
        ]);
        
        if ($result) {
            // Send email notification (optional)
            $to = "admin@businesssolutions.com";
            $emailSubject = "New Inquiry: " . $subject;
            $emailBody = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\n\nMessage:\n$message";
            $headers = "From: noreply@businesssolutions.com\r\n";
            $headers .= "Reply-To: $email\r\n";
            
            // Uncomment to send email
            // mail($to, $emailSubject, $emailBody, $headers);
            
            echo json_encode([
                'success' => true,
                'message' => 'Your inquiry has been submitted successfully. We will get back to you soon.',
                'id' => $pdo->lastInsertId()
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Failed to submit inquiry. Please try again.'
            ]);
        }
    }
    
    // Handle GET request (retrieve inquiries - for admin panel)
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
        // Check for admin authentication (you should implement proper auth)
        // For demo purposes, this is simplified
        
        $filter = $_GET['filter'] ?? 'all';
        
        $sql = "SELECT * FROM inquiries";
        
        if ($filter !== 'all') {
            $sql .= " WHERE status = :status";
        }
        
        $sql .= " ORDER BY submitted_at DESC";
        
        $stmt = $pdo->prepare($sql);
        
        if ($filter !== 'all') {
            $stmt->execute([':status' => $filter]);
        } else {
            $stmt->execute();
        }
        
        $inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'data' => $inquiries
        ]);
    }
    
    // Handle PUT request (update inquiry status)
    elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        
        parse_str(file_get_contents("php://input"), $put_vars);
        
        $id = $put_vars['id'] ?? 0;
        $status = $put_vars['status'] ?? '';
        
        if (!in_array($status, ['New', 'In Progress', 'Resolved'])) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Invalid status'
            ]);
            exit;
        }
        
        $sql = "UPDATE inquiries SET status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
        
        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Status updated successfully' : 'Failed to update status'
        ]);
    }
    
    // Handle DELETE request
    elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        
        parse_str(file_get_contents("php://input"), $delete_vars);
        $id = $delete_vars['id'] ?? 0;
        
        $sql = "DELETE FROM inquiries WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([':id' => $id]);
        
        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Inquiry deleted successfully' : 'Failed to delete inquiry'
        ]);
    }
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
