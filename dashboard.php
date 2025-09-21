<?php
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Dashboard - Virtual Police Station';
$user_id = $_SESSION['user_id'];

// Get user's complaint statistics
$stmt = $pdo->prepare("SELECT 
    COUNT(*) as total_complaints,
    SUM(CASE WHEN status = 'Pending' THEN 1 ELSE 0 END) as pending,
    SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) as in_progress,
    SUM(CASE WHEN status = 'Resolved' THEN 1 ELSE 0 END) as resolved
    FROM complaints WHERE user_id = ?");
$stmt->execute([$user_id]);
$stats = $stmt->fetch();

// Get recent complaints
$stmt = $pdo->prepare("SELECT id, complaint_type, description, status, timestamp FROM complaints WHERE user_id = ? ORDER BY timestamp DESC LIMIT 10");
$stmt->execute([$user_id]);
$recent_complaints = $stmt->fetchAll();

// Get recent complaints with photo information
$stmt = $pdo->prepare("SELECT id, complaint_type, description, status, timestamp, evidence_photos FROM complaints WHERE user_id = ? ORDER BY timestamp DESC LIMIT 10");
$stmt->execute([$user_id]);
$recent_complaints = $stmt->fetchAll();

include 'inc/header.php';
?>

<main style="padding: 2rem 0;">
    <div class="container">
        <h2 style="color: var(--primary-maroon); margin-bottom: 2rem;">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
        
        <!-- Statistics Cards -->
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h3>Total Complaints</h3>
                <span class="stat-number"><?php echo $stats['total_complaints']; ?></span>
                <p>All complaints filed by you</p>
            </div>
            
            <div class="dashboard-card">
                <h3>Pending</h3>
                <span class="stat-number" style="color: var(--warning-orange);"><?php echo $stats['pending']; ?></span>
                <p>Awaiting review</p>
            </div>
            
            <div class="dashboard-card">
                <h3>In Progress</h3>
                <span class="stat-number" style="color: #17A2B8;"><?php echo $stats['in_progress']; ?></span>
                <p>Currently being processed</p>
            </div>
            
            <div class="dashboard-card">
                <h3>Resolved</h3>
                <span class="stat-number" style="color: var(--success-green);"><?php echo $stats['resolved']; ?></span>
                <p>Successfully resolved</p>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div style="text-align: center; margin: 3rem 0;">
            <a href="complaint.php" class="btn btn-primary">File New Complaint</a>
        </div>
        
        <!-- Recent Complaints -->
        <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <h3 style="color: var(--primary-maroon); margin-bottom: 1.5rem;">Recent Complaints</h3>
            
            <?php if (count($recent_complaints) > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Complaint ID</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Evidence</th>
                                <th>Status</th>
                                <th>Date Filed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_complaints as $complaint): ?>
                                <tr>
                                    <td>#VPS<?php echo str_pad($complaint['id'], 6, '0', STR_PAD_LEFT); ?></td>
                                    <td><?php echo htmlspecialchars($complaint['complaint_type']); ?></td>
                                    <td><?php echo substr(htmlspecialchars($complaint['description']), 0, 100) . '...'; ?></td>
                                    <td>
                                        <?php 
                                        $photos = $complaint['evidence_photos'] ? json_decode($complaint['evidence_photos'], true) : [];
                                        if (!empty($photos)): 
                                        ?>
                                            <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                                <?php foreach (array_slice($photos, 0, 3) as $index => $photo): ?>
                                                    <img src="<?php echo htmlspecialchars($photo); ?>" 
                                                         alt="Evidence <?php echo $index + 1; ?>" 
                                                         style="width: 40px; height: 40px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd; cursor: pointer;"
                                                         onclick="openImageModal('<?php echo htmlspecialchars($photo); ?>')">
                                                <?php endforeach; ?>
                                                <?php if (count($photos) > 3): ?>
                                                    <span style="display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: #f0f0f0; border-radius: 4px; font-size: 0.8rem; color: #666;">
                                                        +<?php echo count($photos) - 3; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php else: ?>
                                            <span style="color: #999; font-size: 0.9rem;">No photos</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $complaint['status'])); ?>">
                                            <?php echo htmlspecialchars($complaint['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($complaint['timestamp'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div style="text-align: center; padding: 2rem;">
                    <p>You haven't filed any complaints yet.</p>
                    <a href="complaint.php" class="btn btn-primary">File Your First Complaint</a>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Contact Information -->
        <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-top: 2rem;">
            <h3 style="color: var(--primary-maroon); margin-bottom: 1rem;">Need Help?</h3>
            <p><strong>Email:</strong> support@virtualpolicestation.tn.gov.in</p>
            <p><strong>Helpline:</strong> 100 (Emergency) | 1077 (Non-Emergency)</p>
            <p><strong>Office Hours:</strong> 24/7 Online | Physical Office: 9:00 AM - 6:00 PM</p>
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
</script>

<?php include 'inc/footer.php'; ?>