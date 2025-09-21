<?php
require_once '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

$page_title = 'Admin Dashboard - Virtual Police Station';

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $complaint_id = $_POST['complaint_id'];
    $new_status = $_POST['status'];
    $remarks = trim($_POST['remarks']);
    
    try {
        $stmt = $pdo->prepare("UPDATE complaints SET status = ?, remarks = ?, updated_at = NOW() WHERE id = ?");
        $result = $stmt->execute([$new_status, $remarks, $complaint_id]);
        
        if ($result && $stmt->rowCount() > 0) {
            $success_message = "Complaint #VPS" . str_pad($complaint_id, 6, '0', STR_PAD_LEFT) . " status updated to: " . $new_status;
        } else {
            $error_message = "Failed to update complaint status.";
        }
    } catch (PDOException $e) {
        $error_message = "Database error: " . $e->getMessage();
    }
}

// Get complaint statistics
$stmt = $pdo->query("SELECT 
    COUNT(*) as total_complaints,
    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) as in_progress,
    SUM(CASE WHEN status = 'Resolved' THEN 1 ELSE 0 END) as resolved
    FROM complaints");
$stats = $stmt->fetch();

// Get all complaints with photo information
$stmt = $pdo->query("SELECT c.*, u.name as user_name 
    FROM complaints c 
    LEFT JOIN users u ON c.user_id = u.id 
    ORDER BY c.timestamp DESC");
$complaints = $stmt->fetchAll();
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
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="../index.php">Back to Site</a></li>
                    <li><a href="admin_logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main style="padding: 2rem 0;">
        <div class="container">
            <h2 style="color: var(--primary-maroon); margin-bottom: 2rem;">Admin Dashboard</h2>
            
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-error"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <!-- Statistics Cards -->
            <div class="dashboard-grid">
                <div class="dashboard-card">
                    <h3>Total Complaints</h3>
                    <span class="stat-number"><?php echo $stats['total_complaints']; ?></span>
                    <p>All complaints in system</p>
                </div>
                
                <div class="dashboard-card">
                    <h3>Pending</h3>
                    <span class="stat-number" style="color: var(--warning-orange);"><?php echo $stats['pending']; ?></span>
                    <p>Require attention</p>
                </div>
                
                <div class="dashboard-card">
                    <h3>In Progress</h3>
                    <span class="stat-number" style="color: #17A2B8;"><?php echo $stats['in_progress']; ?></span>
                    <p>Being processed</p>
                </div>
                
                <div class="dashboard-card">
                    <h3>Resolved</h3>
                    <span class="stat-number" style="color: var(--success-green);"><?php echo $stats['resolved']; ?></span>
                    <p>Successfully resolved</p>
                </div>
            </div>
            
            <!-- All Complaints -->
            <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-top: 2rem;">
                <h3 style="color: var(--primary-maroon); margin-bottom: 1.5rem;">All Complaints</h3>
                
                <?php if (count($complaints) > 0): ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Complainant</th>
                                    <th>Contact</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Evidence</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($complaints as $complaint): ?>
                                    <tr>
                                        <td>#VPS<?php echo str_pad($complaint['id'], 6, '0', STR_PAD_LEFT); ?></td>
                                        <td>
                                            <?php echo htmlspecialchars($complaint['name']); ?>
                                            <?php if ($complaint['user_name']): ?>
                                                <br><small>(Registered User)</small>
                                            <?php else: ?>
                                                <br><small>(Guest)</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo htmlspecialchars($complaint['email']); ?><br>
                                            <?php echo htmlspecialchars($complaint['phone']); ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($complaint['complaint_type']); ?></td>
                                        <td style="max-width: 200px;">
                                            <?php echo substr(htmlspecialchars($complaint['description']), 0, 100) . '...'; ?>
                                        </td>
                                        <td>
                                            <?php 
                                            $photos = $complaint['evidence_photos'] ? json_decode($complaint['evidence_photos'], true) : [];
                                            if (!empty($photos)): 
                                            ?>
                                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
                                                    <?php foreach (array_slice($photos, 0, 2) as $index => $photo): ?>
                                                        <div style="position: relative;">
                                                            <img src="<?php echo htmlspecialchars('../' . $photo); ?>" 
                                                                 alt="Evidence <?php echo $index + 1; ?>" 
                                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 2px solid #ddd; cursor: pointer; transition: transform 0.2s ease;"
                                                                 onclick="openImageModal('<?php echo htmlspecialchars('../' . $photo); ?>')"
                                                                 onmouseover="this.style.transform='scale(1.1)'"
                                                                 onmouseout="this.style.transform='scale(1)'">
                                                            <div style="position: absolute; bottom: -5px; right: -5px; background: var(--primary-maroon); color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: bold;">
                                                                <?php echo $index + 1; ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                    <?php if (count($photos) > 2): ?>
                                                        <span style="display: flex; align-items: center; justify-content: center; width: 50px; height: 50px; background: var(--primary-maroon); color: white; border-radius: 6px; font-size: 0.9rem; font-weight: bold;">
                                                            +<?php echo count($photos) - 2; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                <div style="font-size: 0.8rem; color: #666; margin-top: 0.25rem;">
                                                    <?php echo count($photos); ?> photo<?php echo count($photos) > 1 ? 's' : ''; ?>
                                                </div>
                                            <?php else: ?>
                                                <span style="color: #999; font-size: 0.9rem;">No evidence</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $complaint['status'])); ?>">
                                                <?php echo htmlspecialchars($complaint['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($complaint['timestamp'])); ?></td>
                                        <td>
                                            <button onclick="showUpdateForm(<?php echo $complaint['id']; ?>)" 
                                                    class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.3rem 0.8rem;">
                                                Update
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <!-- Hidden update form for each complaint -->
                                    <tr id="update-form-<?php echo $complaint['id']; ?>" style="display: none;">
                                        <td colspan="9" style="background-color: #f8f9fa;">
                                            <form method="POST" action="" style="padding: 1rem;">
                                                <input type="hidden" name="complaint_id" value="<?php echo $complaint['id']; ?>">
                                                <div style="margin-bottom: 1rem; padding: 0.5rem; background: #e9ecef; border-radius: 4px;">
                                                    <strong>Updating Complaint #VPS<?php echo str_pad($complaint['id'], 6, '0', STR_PAD_LEFT); ?></strong>
                                                    <br><small>Current Status: <?php echo htmlspecialchars($complaint['status']); ?></small>
                                                </div>
                                                
                                                <?php 
                                                $photos = $complaint['evidence_photos'] ? json_decode($complaint['evidence_photos'], true) : [];
                                                if (!empty($photos)): 
                                                ?>
                                                    <div style="margin-bottom: 1rem;">
                                                        <strong>Evidence Photos:</strong>
                                                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(80px, 1fr)); gap: 0.5rem; margin-top: 0.5rem; max-width: 400px;">
                                                            <?php foreach ($photos as $index => $photo): ?>
                                                                <div style="position: relative;">
                                                                    <img src="<?php echo htmlspecialchars('../' . $photo); ?>" 
                                                                         alt="Evidence <?php echo $index + 1; ?>" 
                                                                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 6px; border: 2px solid #ddd; cursor: pointer; transition: transform 0.2s ease;"
                                                                         onclick="openImageModal('<?php echo htmlspecialchars('../' . $photo); ?>')"
                                                                         onmouseover="this.style.transform='scale(1.05)'"
                                                                         onmouseout="this.style.transform='scale(1)'">
                                                                    <div style="position: absolute; bottom: -5px; right: -5px; background: var(--primary-maroon); color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; font-weight: bold;">
                                                                        <?php echo $index + 1; ?>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <div style="display: flex; gap: 1rem; align-items: end; flex-wrap: wrap;">
                                                    <div>
                                                        <label>Status:</label>
                                                        <select name="status" class="form-control" required style="min-width: 120px;">
                                                            <option value="Pending" <?php echo $complaint['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                            <option value="In Progress" <?php echo $complaint['status'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                                            <option value="Resolved" <?php echo $complaint['status'] == 'Resolved' ? 'selected' : ''; ?>>Resolved</option>
                                                        </select>
                                                    </div>
                                                    <div style="flex: 1;">
                                                        <label>Remarks:</label>
                                                        <input type="text" name="remarks" class="form-control" style="min-width: 200px;"
                                                               placeholder="Add remarks..." 
                                                               value="<?php echo htmlspecialchars($complaint['remarks'] ?? ''); ?>">
                                                    </div>
                                                    <div>
                                                        <input type="submit" name="update_status" value="Update" class="btn btn-primary" style="margin-right: 0.5rem;">
                                                        <button type="button" onclick="hideUpdateForm(<?php echo $complaint['id']; ?>)" 
                                                                class="btn btn-secondary">Cancel</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div style="text-align: center; padding: 2rem;">
                        <p>No complaints found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <!-- Image Modal -->
    <div id="imageModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); cursor: pointer;" onclick="closeImageModal()">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); max-width: 90%; max-height: 90%;">
            <img id="modalImage" src="" alt="Evidence Photo" style="max-width: 100%; max-height: 100%; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.5);">
            <button onclick="closeImageModal()" style="position: absolute; top: -10px; right: -10px; background: var(--error-red); color: white; border: none; border-radius: 50%; width: 30px; height: 30px; cursor: pointer; font-size: 18px; display: flex; align-items: center; justify-content: center;">×</button>
        </div>
    </div>

    <script>
        function showUpdateForm(id) {
            document.getElementById('update-form-' + id).style.display = 'table-row';
        }
        
        function hideUpdateForm(id) {
            document.getElementById('update-form-' + id).style.display = 'none';
        }
        
        function openImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
        
        // Auto-hide success/error messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>

    <?php include '../inc/footer.php'; ?>