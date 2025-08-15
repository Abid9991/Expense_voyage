<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: userprofile.php');
    exit;
}

// Handle logout request
if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();
    // Destroy the session.
    session_destroy();
    // Redirect to login or home page
    header('Location: index.php');
    exit;
}

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "project";

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset('utf8mb4');
} catch (Exception $e) {
    die("DB Connection failed: " . $e->getMessage());
}

$message = '';
$message_type = 'info';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $age = trim($_POST['age'] ?? null);
    $phone = trim($_POST['phone'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    $image_path = '';

    // Handle file upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        
        // Check and create directory if needed
        if (!is_dir($upload_dir)) {
            if (!mkdir($upload_dir, 0755, true)) {
                $message = 'Failed to create upload directory';
                $message_type = 'danger';
            }
        }
        
        // Check if directory is writable
        if (is_dir($upload_dir) && is_writable($upload_dir)) {
            $file_ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
            
            // Validate file extension
            if (in_array($file_ext, $allowed_ext)) {
                $file_name = 'profile_' . $user_id . '_' . time() . '.' . $file_ext;
                $file_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $file_path)) {
                    $image_path = $file_path;
                } else {
                    $message = 'Error moving uploaded file';
                    $message_type = 'danger';
                }
            } else {
                $message = 'Invalid file type. Only JPG, JPEG, PNG & GIF are allowed.';
                $message_type = 'danger';
            }
        } else {
            $message = 'Upload directory is not writable';
            $message_type = 'danger';
        }
    }

    // Only proceed with database update if there were no upload errors
    if (empty($message)) {
        try {
            // Check if profile already exists
            $stmt = $conn->prepare("SELECT profile_id, image_path FROM profiles WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $existing_profile = $result->fetch_assoc();
            $stmt->close();
            
            if ($existing_profile) {
                // Update existing profile
                if (!empty($image_path)) {
                    // Delete old image if it exists
                    if (!empty($existing_profile['image_path']) && file_exists($existing_profile['image_path'])) {
                        unlink($existing_profile['image_path']);
                    }
                    
                    $stmt = $conn->prepare("UPDATE profiles SET first_name = ?, last_name = ?, age = ?, phone = ?, location = ?, bio = ?, image_path = ?, updated_at = NOW() WHERE user_id = ?");
                    $stmt->bind_param("ssissssi", $first_name, $last_name, $age, $phone, $location, $bio, $image_path, $user_id);
                } else {
                    $stmt = $conn->prepare("UPDATE profiles SET first_name = ?, last_name = ?, age = ?, phone = ?, location = ?, bio = ?, updated_at = NOW() WHERE user_id = ?");
                    $stmt->bind_param("ssisssi", $first_name, $last_name, $age, $phone, $location, $bio, $user_id);
                }
            } else {
                // Insert new profile
                $stmt = $conn->prepare("INSERT INTO profiles (user_id, first_name, last_name, age, phone, location, bio, image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ississss", $user_id, $first_name, $last_name, $age, $phone, $location, $bio, $image_path);
            }
            
            $stmt->execute();
            $stmt->close();
            
            $message = 'Profile saved successfully!';
            $message_type = 'success';
        } catch (Exception $e) {
            $message = 'Error saving profile: ' . $e->getMessage();
            $message_type = 'danger';
        }
    }
}

// Get current profile data
$profile = [];
$stmt = $conn->prepare("SELECT * FROM profiles WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $profile = $result->fetch_assoc();
}
$stmt->close();

// Get saved trips
$saved_trips = [];
if (isset($_SESSION['user_id'])) {
    $saved_stmt = $conn->prepare("
        SELECT t.* FROM trips t
        JOIN saved_trips st ON t.trip_id = st.trip_id
        WHERE st.user_id = ?
        ORDER BY st.saved_at DESC
    ");
    $saved_stmt->bind_param("i", $_SESSION['user_id']);
    $saved_stmt->execute();
    $saved_result = $saved_stmt->get_result();
    $saved_trips = $saved_result->fetch_all(MYSQLI_ASSOC);
    $saved_stmt->close();
}


// Get booked trips
$booked_trips = [];
if (isset($_SESSION['user_id'])) {
    $booked_stmt = $conn->prepare("
        SELECT t.*, bt.booking_date FROM trips t
        JOIN booked_trips bt ON t.trip_id = bt.trip_id
        WHERE bt.user_id = ?
        ORDER BY bt.booking_date DESC
    ");
    $booked_stmt->bind_param("i", $_SESSION['user_id']);
    $booked_stmt->execute();
    $booked_result = $booked_stmt->get_result();
    $booked_trips = $booked_result->fetch_all(MYSQLI_ASSOC);
    $booked_stmt->close();
    
    // Check for booking success message
    if (isset($_SESSION['booking_success'])) {
        $message = 'Trip booked successfully!';
        $message_type = 'success';
        unset($_SESSION['booking_success']);
    }
}

// Add this variable to control logout button display
$show_logout = isset($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #1e40af;
            --accent: #3b82f6;
            --light: #f8fafc;
            --dark: #0f172a;
            --gray: #64748b;
            --light-gray: #e2e8f0;
            --success: #10b981;
            --error: #ef4444;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f1f5f9;
            color: var(--dark);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        h1 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .subtitle {
            color: var(--gray);
            font-weight: 400;
            font-size: 1.1rem;
        }
        
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            padding: 3rem;
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
            transition: all 0.4s ease;
        }
        
        .profile-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            padding: 3rem;
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
            display: none;
            animation: fadeIn 0.6s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .section-title {
            font-size: 1.75rem;
            margin-bottom: 2rem;
            color: var(--secondary);
            font-weight: 600;
            position: relative;
            padding-bottom: 0.75rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }
        
        .form-group {
            margin-bottom: 1.75rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
        }
        
        .required::after {
            content: '*';
            color: var(--error);
            margin-left: 4px;
        }
        
        input, textarea, select {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid var(--light-gray);
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: var(--light);
        }
        
        input:focus, textarea:focus, select:focus {
            border-color: var(--accent);
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            background-color: white;
        }
        
        .image-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .image-preview {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--accent);
            margin-bottom: 1.5rem;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .image-preview .placeholder-icon {
            font-size: 3rem;
            color: var(--gray);
        }
        
        .image-upload label {
            background-color: var(--primary);
            color: white;
            padding: 0.85rem 1.75rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }
        
        .image-upload label:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(37, 99, 235, 0.3);
        }
        
        .image-upload input[type="file"] {
            display: none;
        }
        
        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 0.85rem 1.75rem;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            flex: 1;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(37, 99, 235, 0.3);
        }
        
        .btn-secondary {
            background-color: white;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        
        .btn-secondary:hover {
            background-color: var(--light);
            transform: translateY(-2px);
        }
        
        .profile-display {
            text-align: center;
        }
        
        .profile-image {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            margin: 0 auto 2rem;
            background-color: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        
        .profile-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .profile-image .placeholder-icon {
            font-size: 3.5rem;
            color: var(--gray);
        }
        
        .profile-name {
            font-size: 2.25rem;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-weight: 700;
        }
        
        .profile-age {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }
        
        .profile-details {
            text-align: left;
            margin-top: 2.5rem;
            background: var(--light);
            padding: 2rem;
            border-radius: 10px;
        }
        
        .detail-item {
            margin-bottom: 1.25rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid var(--light-gray);
            display: flex;
        }
        
        .detail-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
          header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--light-gray);
        }
        
        h1 {
            font-size: 2rem;
            color: var(--primary);
            font-weight: 600;
        }
        
        .back-btn {
            background-color: var(--primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .back-btn:hover {
            background-color: var(--primary-dark);
        }
        
        
        .detail-label {
            font-weight: 600;
            color: var(--secondary);
            width: 120px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .detail-value {
            color: var(--dark);
            flex: 1;
        }
        
        .edit-profile {
            margin-top: 2rem;
            text-align: center;
        }
        
        .edit-btn {
            background-color: transparent;
            color: var(--primary);
            border: none;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            transition: all 0.3s;
        }
        
        .edit-btn:hover {
            background-color: rgba(37, 99, 235, 0.1);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--error);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        .alert-info {
            background-color: rgba(59, 130, 246, 0.1);
            color: var(--primary);
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        /* Saved Trips Section */
        .trips-section {
            margin-top: 3rem;
        }
        
        .trips-container {
            background: var(--light);
            padding: 1.5rem;
            border-radius: 10px;
        }
        
        .saved-trips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .saved-trip-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .saved-trip-card h3 {
            margin-bottom: 10px;
        }
        
        .remove-trip-btn {
            margin-top: 10px;
            padding: 8px 12px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .remove-trip-btn:hover {
            background: #d32f2f;
        }
        
        .no-trips-message {
            text-align: center;
            color: var(--gray);
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 1.5rem;
            }
            
            .form-container, .profile-container {
                padding: 2rem 1.5rem;
            }
            
            .detail-item {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .detail-label {
                width: 100%;
            }
        }

        .logout-btn {
        position: absolute;
        top: 30px;
        right: 30px;
        background-color: var(--error);
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        transition: all 0.3s;
        box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2);
    }
    
    .logout-btn:hover {
        background-color: #d32f2f;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
    }
    
    @media (max-width: 768px) {
        .logout-btn {
            top: 15px;
            right: 15px;
            padding: 8px 12px;
            font-size: 0.9rem;
        }
    }
</style>



    </style>
</head>
<body>
<?php if ($show_logout): ?>
    <a href="?logout=1" style="position: absolute; top: 20px; right: 20px; background: #dc3545; color: #fff; padding: 8px 16px; border-radius: 4px; text-decoration: none;">Logout</a>
<?php endif; ?>
    <div class="container">


<header>
            <h1><i class="fas fa-users-cog"></i> User Trips Management</h1>
            <a href="index.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </header>
        
        <div class="form-container" id="formContainer">
            <h2 class="section-title">Personal Information</h2>
            
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <form id="profileForm" method="post" action="" enctype="multipart/form-data">
                <div class="image-upload">
                    <div class="image-preview" id="imagePreview">
                        <?php if (!empty($profile['image_path'])): ?>
                            <img src="<?php echo htmlspecialchars($profile['image_path']); ?>" alt="Profile Image">
                        <?php else: ?>
                            <i class="fas fa-user placeholder-icon"></i>
                        <?php endif; ?>
                    </div>
                    <label for="profileImage">
                        <i class="fas fa-camera"></i>
                        Choose Profile Image
                    </label>
                    <input type="file" id="profileImage" name="profile_image" accept="image/*">
                </div>
                
                <div class="form-group">
                    <label for="firstName" class="required">First Name</label>
                    <input type="text" id="firstName" name="first_name" placeholder="Enter your first name" 
                           value="<?php echo htmlspecialchars($profile['first_name'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="lastName" class="required">Last Name</label>
                    <input type="text" id="lastName" name="last_name" placeholder="Enter your last name" 
                           value="<?php echo htmlspecialchars($profile['last_name'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" placeholder="Enter your age" min="1" max="120"
                           value="<?php echo htmlspecialchars($profile['age'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter your phone number"
                           value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" placeholder="Enter your city and country"
                           value="<?php echo htmlspecialchars($profile['location'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="bio">Professional Bio</label>
                    <textarea id="bio" name="bio" rows="4" placeholder="Briefly describe your professional background and skills"><?php 
                        echo htmlspecialchars($profile['bio'] ?? ''); 
                    ?></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-check"></i>
                        <?php echo empty($profile) ? 'Create Profile' : 'Update Profile'; ?>
                    </button>
                </div>
            </form>
        </div>
        
        <div class="profile-container" id="profileContainer">
            <div class="profile-display" id="profileDisplay">
                <div class="profile-image">
                    <?php if (!empty($profile['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($profile['image_path']); ?>" alt="Profile Image">
                    <?php else: ?>
                        <i class="fas fa-user placeholder-icon"></i>
                    <?php endif; ?>
                </div>
                <h3 class="profile-name">
                    <?php echo htmlspecialchars(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? '')); ?>
                </h3>
                <?php if (!empty($profile['age'])): ?>
                    <div class="profile-age"><?php echo htmlspecialchars($profile['age']); ?> years old</div>
                <?php endif; ?>
                
                <div class="profile-details">
                    <?php if (!empty($profile['phone'])): ?>
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-phone"></i>
                                Phone
                            </span>
                            <span class="detail-value"><?php echo htmlspecialchars($profile['phone']); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($profile['location'])): ?>
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-map-marker-alt"></i>
                                Location
                            </span>
                            <span class="detail-value"><?php echo htmlspecialchars($profile['location']); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($profile['bio'])): ?>
                        <div class="detail-item">
                            <span class="detail-label">
                                <i class="fas fa-user-tie"></i>
                                Bio
                            </span>
                            <span class="detail-value"><?php echo htmlspecialchars($profile['bio']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="edit-profile">
                <button class="edit-btn" id="editProfileBtn">
                    <i class="fas fa-edit"></i>
                    Edit Profile
                </button>
            </div>
        </div>

        <!-- Saved Trips Section -->
        <div class="trips-section">
            <h2 class="section-title">Saved Trips</h2>
            <div class="trips-container">
                <?php if (!empty($saved_trips)): ?>
                    <div class="saved-trips-grid">
                        <?php foreach ($saved_trips as $trip): ?>
                            <div class="saved-trip-card">
                                <h3><?php echo htmlspecialchars($trip['trip_name']); ?></h3>
                                <p><strong>Destination:</strong> <?php echo htmlspecialchars($trip['destination']); ?></p>
                                <p><strong>Dates:</strong> <?php echo htmlspecialchars($trip['start_date']); ?> to <?php echo htmlspecialchars($trip['end_date']); ?></p>
                                <p><strong>Budget:</strong> $<?php echo htmlspecialchars($trip['budget']); ?></p>
                                <button class="remove-trip-btn" onclick="unsaveTrip(<?php echo $trip['trip_id']; ?>, this)">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="no-trips-message">You haven't saved any trips yet.</p>
                <?php endif; ?>
            </div>
        </div>
        
<!-- Booked Trips Section -->
<div class="trips-section">
    <h2 class="section-title">Booked Trips</h2>
    <div class="trips-container">
        <?php if (!empty($booked_trips)): ?>
            <div class="saved-trips-grid">
                <?php foreach ($booked_trips as $trip): ?>
                    <div class="saved-trip-card">
                        <h3><?php echo htmlspecialchars($trip['trip_name']); ?></h3>
                        <p><strong>Destination:</strong> <?php echo htmlspecialchars($trip['destination']); ?></p>
                        <p><strong>Dates:</strong> <?php echo htmlspecialchars($trip['start_date']); ?> to <?php echo htmlspecialchars($trip['end_date']); ?></p>
                        <p><strong>Price:</strong> $<?php echo htmlspecialchars($trip['budget']); ?></p>
                        <p><strong>Booked on:</strong> <?php echo date('M j, Y', strtotime($trip['booking_date'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="no-trips-message">You haven't booked any trips yet.</p>
        <?php endif; ?>
    </div>
</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profileImage = document.getElementById('profileImage');
            const imagePreview = document.getElementById('imagePreview');
            const formContainer = document.getElementById('formContainer');
            const profileContainer = document.getElementById('profileContainer');
            const editProfileBtn = document.getElementById('editProfileBtn');
            
            // Show form or profile view based on whether profile exists
            if (<?php echo !empty($profile) ? 'true' : 'false'; ?>) {
                formContainer.style.display = 'none';
                profileContainer.style.display = 'block';
            } else {
                formContainer.style.display = 'block';
                profileContainer.style.display = 'none';
            }
            
            // Handle image preview
            profileImage.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    // Check file size (2MB max)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('File is too large. Maximum size is 2MB.');
                        this.value = '';
                        return;
                    }
                    
                    // Check file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (!validTypes.includes(file.type)) {
                        alert('Only JPEG, PNG, and GIF images are allowed.');
                        this.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    
                    reader.addEventListener('load', function() {
                        imagePreview.innerHTML = `<img src="${this.result}" alt="Profile Preview">`;
                    });
                    
                    reader.readAsDataURL(file);
                }
            });
            
            // Handle edit profile button
            editProfileBtn.addEventListener('click', function() {
                profileContainer.style.display = 'none';
                formContainer.style.display = 'block';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        function unsaveTrip(tripId, button) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'international.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    const tripCard = button.closest('.saved-trip-card');
                    tripCard.parentNode.removeChild(tripCard);
                    
                    // Check if any trips left
                    const tripsGrid = document.querySelector('.saved-trips-grid');
                    if (tripsGrid && tripsGrid.children.length === 0) {
                        const container = document.querySelector('.trips-container');
                        container.innerHTML = '<p class="no-trips-message">You haven\'t saved any trips yet.</p>';
                    }
                }
            };
            xhr.send('action=unsave&trip_id=' + tripId);
        }
    </script>
</body>
</html>