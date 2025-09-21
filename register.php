<?php
require_once 'config.php';
$page_title = 'Register - Virtual Police Station';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $message = 'All fields are required.';
        $message_type = 'error';
    } elseif ($password !== $confirm_password) {
        $message = 'Passwords do not match.';
        $message_type = 'error';
    } elseif (strlen($password) < 6) {
        $message = 'Password must be at least 6 characters long.';
        $message_type = 'error';
    } else {
        try {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $message = 'Email address already registered.';
                $message_type = 'error';
            } else {
                // Insert new user
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password_hash) VALUES (?, ?, ?, ?)");
                
                if ($stmt->execute([$name, $email, $phone, $password_hash])) {
                    $message = 'Registration successful! You can now login.';
                    $message_type = 'success';
                } else {
                    $message = 'Registration failed. Please try again.';
                    $message_type = 'error';
                }
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
            <h2 style="text-align: center; color: var(--primary-maroon); margin-bottom: 2rem;">Register New Account</h2>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" class="form-control" required 
                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" class="form-control" required 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number *</label>
                    <input type="tel" id="phone" name="phone" class="form-control" required 
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" class="form-control" required minlength="6">
                    <small>Password must be at least 6 characters long.</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password *</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required minlength="6">
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>
                </div>
            </form>
            
            <div style="text-align: center; margin-top: 1rem;">
                <p>Already have an account? <a href="login.php" style="color: var(--primary-maroon);">Login here</a></p>
            </div>
        </div>
    </div>
</main>

<?php include 'inc/footer.php'; ?>