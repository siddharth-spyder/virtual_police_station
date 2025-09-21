<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Virtual Police Station'; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="public/logo.png" type="image/png">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-section">
                <a href="<?php echo strpos($_SERVER['PHP_SELF'], 'admin/') !== false ? '../index.php' : 'index.php'; ?>">
                    <img src="<?php echo strpos($_SERVER['PHP_SELF'], 'admin/') !== false ? '../public/logo.png' : 'public/logo.png'; ?>" alt="Virtual Police Station Logo" class="logo">
                </a>
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'admin/') !== false ? '../index.php' : 'index.php'; ?>">Home</a></li>
                    <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'admin/') !== false ? '../complaint.php' : 'complaint.php'; ?>">File Complaint</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'admin/') !== false ? '../dashboard.php' : 'dashboard.php'; ?>">Dashboard</a></li>
                        <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'admin/') !== false ? '../logout.php' : 'logout.php'; ?>">Logout</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'admin/') !== false ? '../login.php' : 'login.php'; ?>">Login</a></li>
                        <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'admin/') !== false ? '../register.php' : 'register.php'; ?>">Register</a></li>
                    <?php endif; ?>
                    <li><a href="admin/admin_login.php">Admin</a></li>
                </ul>
            </nav>
        </div>
    </header>
