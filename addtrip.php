<?php
// ==== DATABASE CONNECTION ====
$host = "localhost";
$user = "root";       // MySQL username
$pass = "";           // MySQL password
$db   = "project";    // Database name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ==== ADD TRIP ====
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_trip'])) {
    $trip_name   = $_POST['trip_name'];
    $start_date  = $_POST['start_date'];
    $end_date    = $_POST['end_date'];
    $destination = $_POST['destination'];
    $budget      = $_POST['budget'];

    // Image Upload
    $image_name = "";
    if (!empty($_FILES['trip_image']['name'])) {
        $image_name = time() . "_" . basename($_FILES['trip_image']['name']);
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        move_uploaded_file($_FILES['trip_image']['tmp_name'], $target_dir . $image_name);
    }

    $sql = "INSERT INTO trips (trip_name, start_date, end_date, destination, budget, trip_image)
            VALUES ('$trip_name', '$start_date', '$end_date', '$destination', '$budget', '$image_name')";
    $conn->query($sql);
}

// ==== DELETE TRIP ====
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM trips WHERE trip_id=$id");
}

// ==== UPDATE TRIP ====
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_trip'])) {
    $id = $_POST['trip_id'];
    $trip_name = $_POST['trip_name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $destination = $_POST['destination'];
    $budget = $_POST['budget'];

    // Handle image update
    $image_update = "";
    if (!empty($_FILES['trip_image']['name'])) {
        $image_name = time() . "_" . basename($_FILES['trip_image']['name']);
        $target_dir = "uploads/";
        move_uploaded_file($_FILES['trip_image']['tmp_name'], $target_dir . $image_name);
        $image_update = ", trip_image='$image_name'";
    }

    $sql = "UPDATE trips SET 
            trip_name='$trip_name', 
            start_date='$start_date', 
            end_date='$end_date', 
            destination='$destination', 
            budget='$budget'
            $image_update
            WHERE trip_id=$id";
    $conn->query($sql);
}

// ==== FETCH TRIPS ====
$result = $conn->query("SELECT * FROM trips ORDER BY trip_id DESC");

// ==== FETCH TRIP FOR EDIT ====
$edit_trip = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $edit_result = $conn->query("SELECT * FROM trips WHERE trip_id=$id");
    if ($edit_result->num_rows > 0) {
        $edit_trip = $edit_result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f7fc;
        }
        .form-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }
        .trip-card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
            background: white;
            transition: transform 0.2s;
        }
        .trip-card:hover {
            transform: translateY(-5px);
        }
        .trip-img {
            height: 200px;
            object-fit: cover;
        }
        .btn-primary {
            background-color: #0069d9;
        }
        .btn-edit {
            background-color: #ffc107;
            color: #000;
        }
        h3 {
            font-weight: 600;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
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
            background-color:blue;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
    
    </style>
</head>
<body>
    <header>
            <a href="adminpanel.php" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </header>
<div class="container py-5">
    <div class="row g-4">
        
        <!-- Left Side Form -->
        <div class="col-md-5">
            <div class="form-card">
                <h3 class="mb-4"><?php echo isset($edit_trip) ? 'Edit Trip' : 'Add New Trip'; ?></h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <?php if (isset($edit_trip)): ?>
                        <input type="hidden" name="trip_id" value="<?php echo $edit_trip['trip_id']; ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">Trip Name</label>
                        <input type="text" name="trip_name" class="form-control" 
                               value="<?php echo isset($edit_trip) ? $edit_trip['trip_name'] : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" 
                               value="<?php echo isset($edit_trip) ? $edit_trip['start_date'] : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" 
                               value="<?php echo isset($edit_trip) ? $edit_trip['end_date'] : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Destination</label>
                        <input type="text" name="destination" class="form-control" 
                               value="<?php echo isset($edit_trip) ? $edit_trip['destination'] : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Budget</label>
                        <input type="number" name="budget" class="form-control" step="0.01" 
                               value="<?php echo isset($edit_trip) ? $edit_trip['budget'] : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Trip Image</label>
                        <input type="file" name="trip_image" class="form-control" accept="image/*">
                        <?php if (isset($edit_trip) && !empty($edit_trip['trip_image'])): ?>
                            <small class="text-muted">Current: <?php echo $edit_trip['trip_image']; ?></small>
                        <?php endif; ?>
                    </div>
                    <?php if (isset($edit_trip)): ?>
                        <button type="submit" name="update_trip" class="btn btn-primary w-100">Update Trip</button>
                        <a href="?" class="btn btn-secondary w-100 mt-2">Cancel</a>
                    <?php else: ?>
                        <button type="submit" name="add_trip" class="btn btn-primary w-100">Add Trip</button>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Right Side Trip List -->
        <div class="col-md-7">
            <h3 class="mb-4">Your Trips</h3>
            <div class="row g-4">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="col-md-6">
                        <div class="trip-card">
                            <?php if (!empty($row['trip_image'])) { ?>
                                <img src="uploads/<?php echo $row['trip_image']; ?>" class="w-100 trip-img" alt="Trip Image">
                            <?php } ?>
                            <div class="p-3">
                                <h5 class="card-title"><?php echo $row['trip_name']; ?></h5>
                                <p class="mb-1"><strong>Destination:</strong> <?php echo $row['destination']; ?></p>
                                <p class="mb-1"><strong>Dates:</strong> <?php echo $row['start_date']; ?> to <?php echo $row['end_date']; ?></p>
                                <p class="mb-3"><strong>Budget:</strong> $<?php echo $row['budget']; ?></p>
                                <div class="action-buttons">
                                    <a href="?edit=<?php echo $row['trip_id']; ?>" class="btn btn-edit btn-sm">Edit</a>
                                    <a href="?delete=<?php echo $row['trip_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this trip?');">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
</div>
</body>
</html>