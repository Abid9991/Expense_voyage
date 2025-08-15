<?php
session_start();

// // Check if user is admin (you'll need to modify this based on your admin check)
// if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
//     header('Location: loginpage.php');
//     exit;
// }

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "project";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle remove saved trip request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_saved'])) {
    $user_id = $_POST['user_id'];
    $trip_id = $_POST['trip_id'];
    
    $stmt = $conn->prepare("DELETE FROM saved_trips WHERE user_id = ? AND trip_id = ?");
    $stmt->bind_param("ii", $user_id, $trip_id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Saved trip removed successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error removing saved trip: " . $conn->error;
        $_SESSION['message_type'] = "error";
    }
    
    $stmt->close();
    header("Location: admintrips.php");
    exit;
}

// Get all users with their saved and booked trips
$users = [];
$user_stmt = $conn->prepare("SELECT user_id, email FROM users");
$user_stmt->execute();
$user_result = $user_stmt->get_result();

while ($user = $user_result->fetch_assoc()) {
    // Get saved trips for this user
    $saved_stmt = $conn->prepare("
        SELECT t.*, st.save_id FROM trips t
        JOIN saved_trips st ON t.trip_id = st.trip_id
        WHERE st.user_id = ?
        ORDER BY st.saved_at DESC
    ");
    $saved_stmt->bind_param("i", $user['user_id']);
    $saved_stmt->execute();
    $user['saved_trips'] = $saved_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $saved_stmt->close();

    // Get booked trips for this user
    $booked_stmt = $conn->prepare("
        SELECT t.*, bt.booking_date FROM trips t
        JOIN booked_trips bt ON t.trip_id = bt.trip_id
        WHERE bt.user_id = ?
        ORDER BY bt.booking_date DESC
    ");
    $booked_stmt->bind_param("i", $user['user_id']);
    $booked_stmt->execute();
    $user['booked_trips'] = $booked_stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $booked_stmt->close();

    $users[] = $user;
}

$user_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Trips</title>
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
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
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
            background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
            color: #000000ff;
            padding: 0.7rem 1.5rem;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(37,99,235,0.12);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
            transition: background 0.3s;
        }
        .back-btn:hover {
            background: linear-gradient(90deg, #1e40af 0%, #2563eb 100%);
            color: #fff;
        }
        
        .user-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .user-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .user-name {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--secondary);
        }
        
        .user-email {
            color: var(--gray);
            font-size: 0.9rem;
        }
        
        .trips-section {
            margin-top: 1.5rem;
        }
        
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .trips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .trip-card {
            background: var(--light);
            border-radius: 6px;
            padding: 1rem;
            border-left: 3px solid var(--accent);
            position: relative;
        }
        
        .trip-card h4 {
            margin-bottom: 0.5rem;
            color: var(--dark);
        }
        
        .trip-meta {
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        .trip-meta p {
            margin-bottom: 0.25rem;
        }
        
        .booking-date {
            font-size: 0.8rem;
            color: var(--success);
            margin-top: 0.5rem;
            font-weight: 500;
        }
        
        .no-trips {
            background: var(--light);
            padding: 1rem;
            border-radius: 6px;
            color: var(--gray);
            text-align: center;
            font-size: 0.9rem;
        }
        
        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--error);
            color: white;
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .remove-btn:hover {
            background: #c53030;
            transform: scale(1.1);
        }
        
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }
        
        .alert-error {
            background-color: rgba(239, 68, 68, 0.1);
            color: var(--error);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .user-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .trips-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-users-cog"></i> User Trips Management</h1>
            <a href="adminpanel.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </header>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                    unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (empty($users)): ?>
            <div class="no-trips">No users found in the system.</div>
        <?php else: ?>
            <?php foreach ($users as $user): ?>
                <div class="user-card">
                    <div class="user-header">
                        <div>
                            <div class="user-email"><?php echo htmlspecialchars($user['email']); ?></div>
                        </div>
                        <div>
                            <span style="font-size: 0.9rem; color: var(--gray);">
                                User ID: <?php echo $user['user_id']; ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="trips-section">
                        <h3 class="section-title">
                            <i class="fas fa-heart"></i> Saved Trips (<?php echo count($user['saved_trips']); ?>)
                        </h3>
                        
                        <?php if (empty($user['saved_trips'])): ?>
                            <div class="no-trips">This user hasn't saved any trips yet.</div>
                        <?php else: ?>
                            <div class="trips-grid">
                                <?php foreach ($user['saved_trips'] as $trip): ?>
                                    <div class="trip-card">
                                        <button class="remove-btn" onclick="removeSavedTrip(<?php echo $user['user_id']; ?>, <?php echo $trip['trip_id']; ?>)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <h4><?php echo htmlspecialchars($trip['trip_name']); ?></h4>
                                        <div class="trip-meta">
                                            <p><strong>Destination:</strong> <?php echo htmlspecialchars($trip['destination']); ?></p>
                                            <p><strong>Dates:</strong> <?php echo htmlspecialchars($trip['start_date']); ?> to <?php echo htmlspecialchars($trip['end_date']); ?></p>
                                            <p><strong>Budget:</strong> $<?php echo htmlspecialchars($trip['budget']); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="trips-section">
                        <h3 class="section-title">
                            <i class="fas fa-calendar-check"></i> Booked Trips (<?php echo count($user['booked_trips']); ?>)
                        </h3>
                        
                        <?php if (empty($user['booked_trips'])): ?>
                            <div class="no-trips">This user hasn't booked any trips yet.</div>
                        <?php else: ?>
                            <div class="trips-grid">
                                <?php foreach ($user['booked_trips'] as $trip): ?>
                                    <div class="trip-card">
                                        <h4><?php echo htmlspecialchars($trip['trip_name']); ?></h4>
                                        <div class="trip-meta">
                                            <p><strong>Destination:</strong> <?php echo htmlspecialchars($trip['destination']); ?></p>
                                            <p><strong>Dates:</strong> <?php echo htmlspecialchars($trip['start_date']); ?> to <?php echo htmlspecialchars($trip['end_date']); ?></p>
                                            <p><strong>Price:</strong> $<?php echo htmlspecialchars($trip['budget']); ?></p>
                                        </div>
                                        <div class="booking-date">
                                            Booked on: <?php echo date('M j, Y H:i', strtotime($trip['booking_date'])); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        function removeSavedTrip(userId, tripId) {
            if (confirm('Are you sure you want to remove this saved trip?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = 'admintrips.php';
                
                const userIdInput = document.createElement('input');
                userIdInput.type = 'hidden';
                userIdInput.name = 'user_id';
                userIdInput.value = userId;
                
                const tripIdInput = document.createElement('input');
                tripIdInput.type = 'hidden';
                tripIdInput.name = 'trip_id';
                tripIdInput.value = tripId;
                
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'remove_saved';
                actionInput.value = '1';
                
                form.appendChild(userIdInput);
                form.appendChild(tripIdInput);
                form.appendChild(actionInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</body>
</html>