# PHP Implementation Setup Guide

This guide explains how to set up the PHP version of the Business Solutions website with MySQL database.

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher / MariaDB
- Apache or Nginx web server
- phpMyAdmin (optional, for database management)

## Installation Steps

### 1. Database Setup

#### Option A: Using phpMyAdmin
1. Open phpMyAdmin in your browser
2. Create a new database named `business_solutions`
3. Click on the database, then go to SQL tab
4. Copy and paste the contents of `../database_schema.sql`
5. Click "Go" to execute

#### Option B: Using MySQL Command Line
```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE business_solutions;

# Use the database
USE business_solutions;

# Import the schema
SOURCE path/to/database_schema.sql;

# Exit MySQL
exit;
```

### 2. Configure Database Connection

Edit the `contact.php` file and update the database credentials:

```php
$host = 'localhost';        // Your MySQL host
$dbname = 'business_solutions';  // Database name
$username = 'root';         // Your MySQL username
$password = '';             // Your MySQL password
```

### 3. Web Server Setup

#### Using XAMPP/WAMP/MAMP
1. Copy all files to your web server's document root:
   - XAMPP: `C:\xampp\htdocs\business-solutions\`
   - WAMP: `C:\wamp64\www\business-solutions\`
   - MAMP: `/Applications/MAMP/htdocs/business-solutions/`

2. Access the site:
   - `http://localhost/business-solutions/contact_form.html`

#### Using PHP Built-in Server (Development Only)
```bash
cd php_example
php -S localhost:8000
```

Access: `http://localhost:8000/contact_form.html`

### 4. File Structure

```
business-solutions/
├── contact.php              # Backend API handler
├── contact_form.html        # Contact form page
├── admin.php               # Admin panel (to be created)
├── config.php              # Database configuration (optional)
└── .htaccess               # Apache configuration (optional)
```

### 5. Test the Setup

1. Open `contact_form.html` in your browser
2. Fill out the contact form
3. Submit the form
4. Check if data is saved in the database:
   ```sql
   SELECT * FROM inquiries;
   ```

## Creating Additional Pages

### Home Page (index.php)
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Business Solutions - Home</title>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <h1>Welcome to Business Solutions</h1>
    <!-- Add content here -->
    
    <?php include 'footer.php'; ?>
</body>
</html>
```

### About Page (about.php)
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - Business Solutions</title>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <h1>About Us</h1>
    <!-- Add content here -->
    
    <?php include 'footer.php'; ?>
</body>
</html>
```

### Admin Panel (admin.php)
```php
<?php
require_once 'config.php';

// Simple authentication (use proper authentication in production)
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

// Fetch all inquiries
$sql = "SELECT * FROM inquiries ORDER BY submitted_at DESC";
$stmt = $pdo->query($sql);
$inquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Inquiries</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:hover { background-color: #f5f5f5; }
    </style>
</head>
<body>
    <h1>Inquiry Management</h1>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Submitted</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inquiries as $inquiry): ?>
            <tr>
                <td><?= htmlspecialchars($inquiry['id']) ?></td>
                <td><?= htmlspecialchars($inquiry['name']) ?></td>
                <td><?= htmlspecialchars($inquiry['email']) ?></td>
                <td><?= htmlspecialchars($inquiry['phone']) ?></td>
                <td><?= htmlspecialchars($inquiry['subject']) ?></td>
                <td><?= substr(htmlspecialchars($inquiry['message']), 0, 50) ?>...</td>
                <td><?= htmlspecialchars($inquiry['status']) ?></td>
                <td><?= htmlspecialchars($inquiry['submitted_at']) ?></td>
                <td>
                    <a href="view.php?id=<?= $inquiry['id'] ?>">View</a> |
                    <a href="delete.php?id=<?= $inquiry['id'] ?>" 
                       onclick="return confirm('Delete this inquiry?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
```

## Security Considerations

### 1. SQL Injection Prevention
✅ Already using prepared statements with PDO

### 2. XSS Prevention
```php
// Always escape output
echo htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
```

### 3. CSRF Protection
Add CSRF tokens to forms:
```php
// Generate token
session_start();
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// In form
<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

// Validate
if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Invalid CSRF token');
}
```

### 4. Admin Authentication
```php
// login.php
session_start();

if ($_POST) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Check credentials (use password_hash in production)
    if ($username === 'admin' && password_verify($password, $hashed_password)) {
        $_SESSION['admin'] = true;
        header('Location: admin.php');
    }
}
```

### 5. Input Validation
```php
// Sanitize inputs
$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
```

### 6. .htaccess Security
```apache
# Prevent directory listing
Options -Indexes

# Protect config files
<Files "config.php">
    Order allow,deny
    Deny from all
</Files>

# Enable HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

## Email Notifications

To enable email notifications when a new inquiry is submitted:

```php
// In contact.php, after successful insertion
$to = "admin@businesssolutions.com";
$subject = "New Inquiry: " . $formData['subject'];
$message = "
Name: {$formData['name']}
Email: {$formData['email']}
Phone: {$formData['phone']}
Subject: {$formData['subject']}

Message:
{$formData['message']}
";

$headers = "From: noreply@businesssolutions.com\r\n";
$headers .= "Reply-To: {$formData['email']}\r\n";

mail($to, $subject, $message, $headers);
```

## Troubleshooting

### Database Connection Errors
- Check MySQL service is running
- Verify database credentials
- Ensure database exists

### Form Not Submitting
- Check PHP error logs
- Verify file permissions
- Enable error reporting: `error_reporting(E_ALL);`

### Email Not Sending
- Configure PHP mail settings in `php.ini`
- Use PHPMailer for better email handling
- Check spam folder

## Production Deployment

1. **Disable error display**
   ```php
   error_reporting(0);
   ini_set('display_errors', 0);
   ```

2. **Use environment variables**
   ```php
   $dbPassword = getenv('DB_PASSWORD');
   ```

3. **Enable HTTPS**
   - Get SSL certificate (Let's Encrypt)
   - Configure web server

4. **Set up backups**
   ```bash
   # Backup database
   mysqldump -u root -p business_solutions > backup.sql
   ```

5. **Monitor logs**
   - Enable error logging
   - Monitor access logs
   - Set up alerts

## Additional Resources

- [PHP PDO Documentation](https://www.php.net/manual/en/book.pdo.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [PHP Security Guide](https://www.php.net/manual/en/security.php)

## Support

For issues or questions, please contact the development team.
