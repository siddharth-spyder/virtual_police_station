<?php
require_once 'config.php';
$page_title = 'File Complaint - Virtual Police Station';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $complaint_type = $_POST['complaint_type'];
    $description = trim($_POST['description']);
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    
    // Debug: Check if files are being uploaded
    error_log("FILES array: " . print_r($_FILES, true));
    
    // Handle photo uploads
    $uploaded_photos = [];
    if (isset($_FILES['evidence_photos']) && is_array($_FILES['evidence_photos']['name']) && !empty($_FILES['evidence_photos']['name'][0])) {
        $upload_dir = 'uploads/complaints/';
        
        // Create upload directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0755, true)) {
                error_log("Failed to create upload directory: " . $upload_dir);
                $message = 'Failed to create upload directory. Please contact administrator.';
                $message_type = 'error';
            }
        }
        
        if (is_dir($upload_dir)) {
            foreach ($_FILES['evidence_photos']['tmp_name'] as $key => $tmp_name) {
                if (!empty($tmp_name) && is_uploaded_file($tmp_name)) {
                    $file_name = $_FILES['evidence_photos']['name'][$key];
                    $file_size = $_FILES['evidence_photos']['size'][$key];
                    $file_error = $_FILES['evidence_photos']['error'][$key];
                    
                    // Check for upload errors
                    if ($file_error !== UPLOAD_ERR_OK) {
                        error_log("Upload error for file $file_name: " . $file_error);
                        continue;
                    }
                    
                    // Get actual file type using finfo
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $file_type = finfo_file($finfo, $tmp_name);
                    finfo_close($finfo);
                    
                    error_log("Processing file: $file_name, Type: $file_type, Size: $file_size");
                    
                    // Validate file type
                    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                    if (!in_array($file_type, $allowed_types)) {
                        error_log("Invalid file type: $file_type for file: $file_name");
                        continue; // Skip invalid file types
                    }
                    
                    // Validate file size (5MB limit)
                    if ($file_size > 5 * 1024 * 1024) {
                        error_log("File too large: $file_size bytes for file: $file_name");
                        continue; // Skip files that are too large
                    }
                    
                    // Generate unique filename
                    $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
                    $unique_filename = 'complaint_' . time() . '_' . $key . '.' . strtolower($file_extension);
                    $upload_path = $upload_dir . $unique_filename;
                    
                    // Move uploaded file
                    if (move_uploaded_file($tmp_name, $upload_path)) {
                        $uploaded_photos[] = $upload_path;
                        error_log("Successfully uploaded file: $upload_path");
                    } else {
                        error_log("Failed to move uploaded file: $tmp_name to $upload_path");
                    }
                }
            }
        }
    }
    
    // Debug: Check uploaded photos array
    error_log("Uploaded photos: " . print_r($uploaded_photos, true));
    
    // Convert photos array to JSON
    $photos_json = !empty($uploaded_photos) ? json_encode($uploaded_photos) : null;
    
    // Debug: Check JSON conversion
    error_log("Photos JSON: " . ($photos_json ? $photos_json : 'NULL'));
    
    // Validation
    if (empty($name) || empty($email) || empty($phone) || empty($complaint_type) || empty($description)) {
        $message = 'All fields are required.';
        $message_type = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO complaints (user_id, name, email, phone, complaint_type, description, evidence_photos) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            if ($stmt->execute([$user_id, $name, $email, $phone, $complaint_type, $description, $photos_json])) {
                $complaint_id = $pdo->lastInsertId();
                $photo_count = count($uploaded_photos);
                $photo_text = $photo_count > 0 ? "<br>$photo_count evidence photo(s) uploaded successfully." : "<br>No photos were uploaded.";
                $message = "Complaint filed successfully! Your Complaint ID is: <strong>#VPS" . str_pad($complaint_id, 6, '0', STR_PAD_LEFT) . "</strong><br>Please save this ID for future reference.$photo_text";
                $message_type = 'success';
                
                // Debug: Log final result
                error_log("Complaint created with ID: $complaint_id, Photos JSON: " . ($photos_json ? $photos_json : 'NULL'));
                
                // Clear form data on success
                $_POST = array();
            } else {
                $message = 'Failed to file complaint. Please try again.';
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
            <h2 style="text-align: center; color: var(--primary-maroon); margin-bottom: 2rem;">File a Complaint</h2>
            
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="alert alert-success">
                    Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! Your details have been pre-filled.
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    You are filing as a guest. Consider <a href="register.php" style="color: var(--primary-maroon);">registering</a> to track your complaints easily.
                </div>
            <?php endif; ?>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Full Name *</label>
                    <input type="text" id="name" name="name" class="form-control" required 
                           value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : (isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <input type="email" id="email" name="email" class="form-control" required 
                           value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : (isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number *</label>
                    <input type="tel" id="phone" name="phone" class="form-control" required 
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                </div>
                
                <div class="form-group">
                    <label for="complaint_type">Complaint Type *</label>
                    <select id="complaint_type" name="complaint_type" class="form-control" required>
                        <option value="">Select Complaint Type</option>
                        <option value="Theft" <?php echo (isset($_POST['complaint_type']) && $_POST['complaint_type'] == 'Theft') ? 'selected' : ''; ?>>Theft</option>
                        <option value="Fraud" <?php echo (isset($_POST['complaint_type']) && $_POST['complaint_type'] == 'Fraud') ? 'selected' : ''; ?>>Fraud</option>
                        <option value="Assault" <?php echo (isset($_POST['complaint_type']) && $_POST['complaint_type'] == 'Assault') ? 'selected' : ''; ?>>Assault</option>
                        <option value="Harassment" <?php echo (isset($_POST['complaint_type']) && $_POST['complaint_type'] == 'Harassment') ? 'selected' : ''; ?>>Harassment</option>
                        <option value="Traffic Violation" <?php echo (isset($_POST['complaint_type']) && $_POST['complaint_type'] == 'Traffic Violation') ? 'selected' : ''; ?>>Traffic Violation</option>
                        <option value="Cyber Crime" <?php echo (isset($_POST['complaint_type']) && $_POST['complaint_type'] == 'Cyber Crime') ? 'selected' : ''; ?>>Cyber Crime</option>
                        <option value="Domestic Violence" <?php echo (isset($_POST['complaint_type']) && $_POST['complaint_type'] == 'Domestic Violence') ? 'selected' : ''; ?>>Domestic Violence</option>
                        <option value="Property Dispute" <?php echo (isset($_POST['complaint_type']) && $_POST['complaint_type'] == 'Property Dispute') ? 'selected' : ''; ?>>Property Dispute</option>
                        <option value="Other" <?php echo (isset($_POST['complaint_type']) && $_POST['complaint_type'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description">Complaint Description *</label>
                    <textarea id="description" name="description" class="form-control" rows="6" required 
                              placeholder="Please provide detailed information about your complaint..."><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="evidence_photos">Upload Evidence Photos (Optional)</label>
                    <input type="file" id="evidence_photos" name="evidence_photos[]" class="form-control file-input" 
                           multiple accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" onchange="previewImages(this)">
                    <small style="color: #666; font-size: 0.9em;">
                        You can upload multiple photos (JPG, PNG, GIF, WebP). Maximum 5 photos, 5MB each.
                        <br>Examples: Scene photos, suspect images, damaged property, documents, etc.
                    </small>
                    <div id="image-preview" class="image-preview-container"></div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Submit Complaint</button>
                </div>
            </form>
            
            <div style="text-align: center; margin-top: 1rem;">
                <p style="font-size: 0.9em; color: #666;">
                    <strong>Note:</strong> All complaints are treated confidentially. You will receive updates via the provided contact information.
                </p>
            </div>
        </div>
    </div>
</main>

<script>
function previewImages(input) {
    const previewContainer = document.getElementById('image-preview');
    previewContainer.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        // Check file limit
        if (input.files.length > 5) {
            alert('Maximum 5 photos allowed. Please select fewer files.');
            input.value = '';
            return;
        }
        
        Array.from(input.files).forEach((file, index) => {
            // Check file size (5MB limit)
            if (file.size > 5 * 1024 * 1024) {
                alert(`File "${file.name}" is too large. Maximum size is 5MB.`);
                return;
            }
            
            // Check file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert(`File "${file.name}" is not a supported image format. Please select JPG, PNG, GIF, or WebP files only.`);
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'image-preview-item';
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}">
                    <button type="button" class="image-remove-btn" onclick="removeImage(${index})" title="Remove image">×</button>
                `;
                previewContainer.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });
    } else {
        // Show placeholder when no files selected
        previewContainer.innerHTML = `
            <div class="upload-placeholder">
                <span class="upload-icon">📷</span>
                <span>No photos selected</span>
            </div>
        `;
    }
}

function removeImage(index) {
    const input = document.getElementById('evidence_photos');
    const dt = new DataTransfer();
    
    // Add all files except the one to remove
    Array.from(input.files).forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    input.files = dt.files;
    previewImages(input);
}

// Initialize placeholder on page load
document.addEventListener('DOMContentLoaded', function() {
    const previewContainer = document.getElementById('image-preview');
    previewContainer.innerHTML = `
        <div class="upload-placeholder">
            <span class="upload-icon">📷</span>
            <span>Click "Choose Files" to upload evidence photos</span>
        </div>
    `;
});
</script>

<?php include 'inc/footer.php'; ?>