<?php
session_start();
// ==== DATABASE CONNECTION ====
$host = "localhost";
$user = "root";
$pass = "";
$db = "project";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle save/unsave action
if (isset($_POST['action']) && isset($_POST['trip_id']) && isset($_SESSION['user_id'])) {
    $trip_id = $_POST['trip_id'];
    $user_id = $_SESSION['user_id'];
    
    if ($_POST['action'] == 'save') {
        // Save the trip
        $stmt = $conn->prepare("INSERT INTO saved_trips (user_id, trip_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $trip_id);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['action'] == 'unsave') {
        // Unsave the trip
        $stmt = $conn->prepare("DELETE FROM saved_trips WHERE user_id = ? AND trip_id = ?");
        $stmt->bind_param("ii", $user_id, $trip_id);
        $stmt->execute();
        $stmt->close();
    }
    exit;
}

// ==== FETCH TRIPS ====
$whereClause = "";
if (isset($_POST['filter'])) {
    $budget = $_POST['budget'];
    $destination = $_POST['destination'];
    
    $conditions = [];
    if (!empty($budget)) {
        $conditions[] = "budget <= $budget";
    }
    if (!empty($destination) && $destination != 'all') {
        $conditions[] = "destination = '$destination'";
    }
    
    if (!empty($conditions)) {
        $whereClause = "WHERE " . implode(" AND ", $conditions);
    }
}

$result = $conn->query("SELECT * FROM trips $whereClause ORDER BY trip_id DESC");
$destinations = $conn->query("SELECT DISTINCT destination FROM trips ORDER BY destination");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>International Tour Packages</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .logo {
            font-family: 'Old English Text MT', serif;
            font-size: 32px;
            font-weight: bold;
        }
        .logo span {
            color: #008cba;
        }
        .nav {
            display: flex;
            gap: 30px;
            align-items: center;
        }
        .nav a {
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            color: #002147;
        }
        .contact-btn {
            background: #008cba;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 20px;
        }
        .heading-container {
            text-align: left;
            margin: 40px 60px;
        }
        .main-heading {
            font-size: 36px;
            font-weight: bold;
            color: #001f4d;
        }
        .main-heading span {
            color: #0088a9;
        }
        .tour-container {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin: 40px;
            width: calc(100% - 80px);
        }
        .tour-card {
            background: #f0f9fd;
            border-top: 4px solid #b3002d;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
        }
        .tour-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .tour-info {
            padding: 15px;
        }
        .tour-title {
            font-size: 18px;
            font-weight: bold;
            color: #002147;
            margin-bottom: 10px;
        }
        .tour-description {
            font-size: 14px;
            color: #333;
            margin-bottom: 15px;
        }
        .button-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .save-trip {
            background: #008cba;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            flex: 1;
            min-width: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: all 0.3s ease;
        }
        .save-trip:hover {
            background-color: #0077a3;
        }
        .save-trip.saved {
            background-color: #4CAF50;
        }
        .save-trip.saved:hover {
            background-color: #3e8e41;
        }
        .book-me {
            background: #4CAF50;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            flex: 1;
            min-width: 80px;
        }
        .more-details {
            background: #002147;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            flex: 1;
            min-width: 80px;
        }
        .footer {
            text-align: center;
            background-color: #002147;
            color: white;
            padding: 20px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            width: 50%;
            text-align: center;
            position: relative;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            color: red;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }
        .filter-section {
            display: flex;
            justify-content: flex-end;
            margin: 20px 60px;
        }
        .filter-btn {
            background: #008cba;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .filter-dropdown {
            display: none;
            position: absolute;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 100;
            right: 60px;
            top: 100px;
            width: 300px;
        }
        .filter-dropdown.active {
            display: block;
        }
        .filter-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .filter-group {
            display: flex;
            flex-direction: column;
        }
        .filter-group label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #002147;
        }
        .filter-group input, .filter-group select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        .apply-filter-btn {
            background: #008cba;
            color: white;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .reset-btn {
            background: #b3002d;
            color: white;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .profile-icon {
            position: absolute;
            right: 20px;
            top: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #0088a9;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 20px;
            transition: all 0.3s ease;
        }
        .profile-icon:hover {
            background-color: #005f73;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
            }
            .nav {
                flex-direction: column;
                gap: 10px;
                margin-top: 10px;
            }
            .contact-btn {
                margin-top: 10px;
            }
            .heading-container {
                margin: 20px;
            }
            .tour-container {
                grid-template-columns: 1fr;
                margin: 20px;
                width: calc(100% - 40px);
            }
            .filter-section {
                margin: 20px;
                justify-content: center;
            }
            .filter-dropdown {
                right: 20px;
                left: 20px;
                width: auto;
            }
            .modal-content {
                width: 80%;
            }
            .profile-icon {
                right: 60px;
                width: 35px;
                height: 35px;
                font-size: 18px;
            }
        }

        @media (max-width: 480px) {
            .logo {
                font-size: 24px;
            }
            .nav a {
                font-size: 16px;
            }
            .main-heading {
                font-size: 28px;
            }
            .tour-title {
                font-size: 16px;
            }
            .tour-description {
                font-size: 12px;
            }
            .button-group {
                flex-direction: row;
            }
            .save-trip,
            .book-me,
            .more-details {
                min-width: auto;
                flex: none;
            }
            .modal-content {
                width: 90%;
            }
            .profile-icon {
                right: 50px;
                width: 30px;
                height: 30px;
                font-size: 16px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="logo">Expense <span>Voyage</span></div>
        <a href="userprofile.php" class="profile-icon">
            <i class="fas fa-user"></i>
        </a>
        <nav class="nav">
            <a href="index.php">Home</a>
            <div class="dropdown">
                <a href="international.php" class="dropbtn">Tour Packages <i class="fas fa-chevron-down"></i></a>
                <div class="dropdown-content"></div>
            </div>
            <a href="contact.php">Contact Us</a>
            <a href="about.php">About Us</a>
                        <a href="converter.php">Currency Convert</a>

        </nav>
        <a href="memberform.php"><button class="contact-btn">Register/Login</button></a>
    </header>
    
    <div class="filter-section">
        <button class="filter-btn" id="filterToggle">Filter</button>
        <div class="filter-dropdown" id="filterDropdown">
            <form method="post" class="filter-form">
                <div class="filter-group">
                    <label for="budget">Maximum Budget ($)</label>
                    <input type="number" id="budget" name="budget" placeholder="Enter your max budget" value="<?php echo isset($_POST['budget']) ? $_POST['budget'] : ''; ?>">
                </div>
                <div class="filter-group">
                    <label for="destination">Destination</label>
                    <select id="destination" name="destination">
                        <option value="all">All Destinations</option>
                        <?php while ($dest = $destinations->fetch_assoc()) { ?>
                            <option value="<?php echo $dest['destination']; ?>" <?php echo (isset($_POST['destination']) && $_POST['destination'] == $dest['destination']) ? 'selected' : ''; ?>>
                                <?php echo $dest['destination']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <button type="submit" name="filter" class="apply-filter-btn">Apply Filters</button>
                <button type="button" onclick="window.location.href='international.php'" class="reset-btn">Reset</button>
            </form>
        </div>
    </div>
    
    <div class="heading-container">
        <h2 class="main-heading">INTERNATIONAL <span>TOUR PACKAGES</span></h2>
    </div>
    
    <div class="tour-container">
        <?php if ($result->num_rows > 0) { ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="tour-card">
                    <?php if (!empty($row['trip_image'])) { ?>
                        <img src="uploads/<?php echo $row['trip_image']; ?>" alt="<?php echo $row['trip_name']; ?>">
                    <?php } else { ?>
                        <img src="img/default-tour.jpg" alt="Default Tour Image">
                    <?php } ?>
                    <div class="tour-info">
                        <div class="tour-title"><?php echo $row['trip_name']; ?></div>
                        <div class="tour-description">
                            <p><strong>Destination:</strong> <?php echo $row['destination']; ?></p>
                            <p><strong>Dates:</strong> <?php echo $row['start_date']; ?> to <?php echo $row['end_date']; ?></p>
                            <p><strong>Budget:</strong> $<?php echo $row['budget']; ?></p>
                        </div>
                        <div class="button-group">
                            <?php 
                            $is_saved = false;
                            if (isset($_SESSION['user_id'])) {
                                $check_stmt = $conn->prepare("SELECT save_id FROM saved_trips WHERE user_id = ? AND trip_id = ?");
                                $check_stmt->bind_param("ii", $_SESSION['user_id'], $row['trip_id']);
                                $check_stmt->execute();
                                $is_saved = $check_stmt->get_result()->num_rows > 0;
                                $check_stmt->close();
                            }
                            ?>
                            <button class="save-trip <?php echo $is_saved ? 'saved' : ''; ?>" 
                                    data-trip-id="<?php echo $row['trip_id']; ?>"
                                    onclick="toggleSave(this)">
                                <?php echo $is_saved ? '<i class="fas fa-bookmark"></i> Saved' : '<i class="far fa-bookmark"></i> Save'; ?>
                            </button>
                            <button class="book-me" onclick="handleBookMe(<?php echo $row['trip_id']; ?>)">Book Me</button>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 20px;">
                <p>No trips found matching your criteria. Please try different filters.</p>
            </div>
        <?php } ?>
    </div>
    
    <div class="footer">
        <p class="foot-p">© 2023 Expense Voyage. All rights reserved.</p>
    </div>
    

    
    <script>


        function handleBookMe(tripId) {
    <?php if (!isset($_SESSION['user_id'])): ?>
        window.location.href = 'memberform.php';
        return;
    <?php endif; ?>
    window.location.href = 'paymentform.php?trip_id=' + tripId;
}






 function toggleSave(button) {
    <?php if (!isset($_SESSION['user_id'])): ?>
        window.location.href = 'memberform.php';
        return;
    <?php endif; ?>
    
    const tripId = button.getAttribute('data-trip-id');
    const isSaved = button.classList.contains('saved');
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'international.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status === 200) {
            if (isSaved) {
                button.innerHTML = '<i class="far fa-bookmark"></i> Save';
                button.classList.remove('saved');
            } else {
                button.innerHTML = '<i class="fas fa-bookmark"></i> Saved';
                button.classList.add('saved');
            }
        }
    };
    xhr.send('action=' + (isSaved ? 'unsave' : 'save') + '&trip_id=' + tripId);
}

        document.getElementById('filterToggle').addEventListener('click', function() {
            document.getElementById('filterDropdown').classList.toggle('active');
        });
        
        document.addEventListener('click', function(event) {
            const filterDropdown = document.getElementById('filterDropdown');
            const filterToggle = document.getElementById('filterToggle');
            
            if (!filterDropdown.contains(event.target) && !filterToggle.contains(event.target)) {
                filterDropdown.classList.remove('active');
            }
        });

    // More Details modal and related JS removed as requested
    </script>
</body>
</html>