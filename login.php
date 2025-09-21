<?php
require_once 'config.php';
$page_title = 'Login - Virtual Police Station';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $message = 'Please enter both email and password.';
        $message_type = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, name, email, password_hash FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                
                header('Location: dashboard.php');
                exit;
            } else {
                $message = 'Invalid email or password.';
                $message_type = 'error';
            }
        } catch (PDOException $e) {
            $message = 'Database error. Please try again.';
            $message_type = 'error';
        }
    }
}

include 'inc/header.php';
?>

<main style="padding: 2rem 0;">
    <div class="container">
        <div class="form-container">
            <h2 style="text-align: center; color: var(--primary-maroon); margin-bottom: 2rem;">Login to Your Account</h2>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" class="form-control" required 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
                </div>
            </form>
            
            <div style="text-align: center; margin-top: 1rem;">
                <p>Don't have an account? <a href="register.php" style="color: var(--primary-maroon);">Register here</a></p>
                <p>Want to file a complaint without registering? <a href="complaint.php" style="color: var(--primary-maroon);">File as Guest</a></p>
            </div>
        </div>
    </div>
</main>

<?php include 'inc/footer.php'; ?>