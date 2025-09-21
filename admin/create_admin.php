<?php
require_once '../config.php';

// Generate password hash for admin123
$password = 'admin123';
$password_hash = password_hash($password, PASSWORD_DEFAULT);

echo "Password hash for 'admin123': " . $password_hash . "<br>";

// Check if admin user exists and update/create
try {
    $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE username = ?");
    $stmt->execute(['admin']);
    $admin = $stmt->fetch();
    
    if ($admin) {
        // Update existing admin
        $stmt = $pdo->prepare("UPDATE admin_users SET password_hash = ? WHERE username = ?");
        $stmt->execute([$password_hash, 'admin']);
        echo "Admin user updated successfully!<br>";
    } else {
        // Create new admin
        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
        $stmt->execute(['admin', $password_hash]);
        echo "Admin user created successfully!<br>";
    }
    
    echo "<br>You can now login with:<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>