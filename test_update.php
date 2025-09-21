<?php
require_once 'config.php';

// Simple test to check if database updates work
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $complaint_id = $_POST['complaint_id'];
    $new_status = $_POST['status'];
    $remarks = $_POST['remarks'];
    
    echo "<h3>Debug Information:</h3>";
    echo "Complaint ID: " . $complaint_id . "<br>";
    echo "New Status: " . $new_status . "<br>";
    echo "Remarks: " . $remarks . "<br>";
    
    try {
        // First, let's see if the complaint exists
        $stmt = $pdo->prepare("SELECT * FROM complaints WHERE id = ?");
        $stmt->execute([$complaint_id]);
        $complaint = $stmt->fetch();
        
        if ($complaint) {
            echo "<br><strong>Complaint found:</strong><br>";
            echo "Current Status: " . $complaint['status'] . "<br>";
            echo "Current Remarks: " . ($complaint['remarks'] ?? 'NULL') . "<br>";
            
            // Now try to update
            $stmt = $pdo->prepare("UPDATE complaints SET status = ?, remarks = ? WHERE id = ?");
            $result = $stmt->execute([$new_status, $remarks, $complaint_id]);
            
            echo "<br><strong>Update Result:</strong><br>";
            echo "Execute Result: " . ($result ? 'TRUE' : 'FALSE') . "<br>";
            echo "Rows Affected: " . $stmt->rowCount() . "<br>";
            
            // Check if it was actually updated
            $stmt = $pdo->prepare("SELECT * FROM complaints WHERE id = ?");
            $stmt->execute([$complaint_id]);
            $updated_complaint = $stmt->fetch();
            
            echo "<br><strong>After Update:</strong><br>";
            echo "New Status: " . $updated_complaint['status'] . "<br>";
            echo "New Remarks: " . ($updated_complaint['remarks'] ?? 'NULL') . "<br>";
            
        } else {
            echo "<br><strong>ERROR: Complaint not found!</strong><br>";
        }
        
    } catch (PDOException $e) {
        echo "<br><strong>Database Error:</strong> " . $e->getMessage() . "<br>";
    }
}

// Get first complaint for testing
$stmt = $pdo->query("SELECT * FROM complaints LIMIT 1");
$test_complaint = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test Update</title>
</head>
<body>
    <h2>Test Complaint Update</h2>
    
    <?php if ($test_complaint): ?>
        <p><strong>Testing with Complaint ID:</strong> <?php echo $test_complaint['id']; ?></p>
        <p><strong>Current Status:</strong> <?php echo $test_complaint['status']; ?></p>
        <p><strong>Current Remarks:</strong> <?php echo $test_complaint['remarks'] ?? 'NULL'; ?></p>
        
        <form method="POST" action="">
            <input type="hidden" name="complaint_id" value="<?php echo $test_complaint['id']; ?>">
            
            <label>New Status:</label>
            <select name="status">
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Resolved">Resolved</option>
            </select><br><br>
            
            <label>Remarks:</label>
            <input type="text" name="remarks" value="Test update at <?php echo date('Y-m-d H:i:s'); ?>"><br><br>
            
            <button type="submit">Test Update</button>
        </form>
    <?php else: ?>
        <p>No complaints found in database!</p>
    <?php endif; ?>
    
    <br><br>
    <a href="admin/admin_dashboard.php">Back to Admin Dashboard</a>
</body>
</html>