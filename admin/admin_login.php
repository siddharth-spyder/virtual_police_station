<?php
require_once '../config.php';
$page_title = 'Admin Login - Virtual Police Station';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $message = 'Please enter both username and password.';
        $message_type = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, username, password_hash FROM admin_users WHERE username = ?");
            $stmt->execute([$username]);
            $admin = $stmt->fetch();
            
            if ($admin && password_verify($password, $admin['password_hash'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];
                
                header('Location: admin_dashboard.php');
                exit;
            } else {
                $message = 'Invalid username or password.';
                $message_type = 'error';
            }
        } catch (PDOException $e) {
            $message = 'Database error. Please try again.';
            $message_type = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../public/logo.png" type="image/png">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-section">
                <a href="../index.php">
                    <img src="../public/logo.png" alt="Virtual Police Station Logo" class="logo">
                </a>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="../index.php">Back to Site</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main style="padding: 2rem 0;">
        <div class="container">
            <div class="form-container">
                <h2 style="text-align: center; color: var(--primary-maroon); margin-bottom: 2rem;">Admin Login</h2>
                
                <?php if ($message): ?>
                    <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" id="username" name="username" class="form-control" required placeholder="Enter username"
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" name="password" class="form-control" required placeholder="Enter password">
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
                    </div>
                </form>
                
                <div style="text-align: center; margin-top: 1rem; font-size: 0.9em; color: #666;">
                    <p><strong>Default credentials:</strong><br>
                    Username: <code>admin</code> | Password: <code>admin123</code></p>
                </div>
            </div>
        </div>
    </main>

    <?php include '../inc/footer.php'; ?>
