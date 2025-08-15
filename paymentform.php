<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: loginpage.php');
    exit;
}

// Check if trip_id is provided
if (!isset($_GET['trip_id'])) {
    header('Location: international.php');
    exit;
}

$trip_id = $_GET['trip_id'];

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "project";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get trip details
$trip_stmt = $conn->prepare("SELECT * FROM trips WHERE trip_id = ?");
$trip_stmt->bind_param("i", $trip_id);
$trip_stmt->execute();
$trip_result = $trip_stmt->get_result();

if ($trip_result->num_rows === 0) {
    header('Location: international.php');
    exit;
}

$trip = $trip_result->fetch_assoc();
$trip_stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process payment (in a real app, you'd validate payment details here)
    
    // Record the booking
    $user_id = $_SESSION['user_id'];
    $booking_date = date('Y-m-d H:i:s');
    
    $stmt = $conn->prepare("INSERT INTO booked_trips (user_id, trip_id, booking_date) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $user_id, $trip_id, $booking_date);
    
    if ($stmt->execute()) {
        // Redirect to profile page with success message
        $_SESSION['booking_success'] = true;
        header('Location: userprofile.php');
        exit;
    } else {
        $error = "Error processing your booking. Please try again.";
    }
    
    $stmt->close();
}

$conn->close();
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Payment Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --dark-color: #212529;
            --light-color: #f8f9fa;
            --success-color: #4cc9f0;
            --border-radius: 8px;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7ff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .payment-container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .payment-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            text-align: center;
        }
        
        .payment-header h1 {
            font-size: 1.8rem;
            font-weight: 600;
        }
        
        .payment-body {
            padding: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
            font-size: 0.9rem;
        }
        
        .input-field {
            position: relative;
        }
        
        .input-field input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.5rem;
            border: 1px solid #e0e0e0;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
            background-color: var(--light-color);
        }
        
        .input-field input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.2);
        }
        
        .input-field i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .card-number-group input {
            letter-spacing: 1px;
            font-family: 'Courier New', monospace;
            font-size: 1.1rem;
            padding-left: 3rem;
        }
        
        .card-icons {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            gap: 0.5rem;
        }
        
        .card-icons img {
            height: 20px;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: var(--transition);
        }
        
        .card-icons img.active {
            filter: grayscale(0);
            opacity: 1;
        }
        
        .row {
            display: flex;
            gap: 1rem;
        }
        
        .row .form-group {
            flex: 1;
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-top: 1.5rem;
        }
        
        .checkbox-container input {
            margin-right: 0.75rem;
            width: 18px;
            height: 18px;
            accent-color: var(--primary-color);
            cursor: pointer;
        }
        
        .checkbox-container label {
            font-size: 0.9rem;
            color: #495057;
            cursor: pointer;
            user-select: none;
        }
        
        .submit-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        /* Credit card preview (optional) */
        .card-preview {
            background: linear-gradient(135deg, #3a0ca3, #4361ee);
            color: white;
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
            height: 180px;
            box-shadow: 0 10px 20px rgba(67, 97, 238, 0.2);
            overflow: hidden;
        }
        
        .card-preview::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        
        .card-preview::after {
            content: '';
            position: absolute;
            bottom: -30%;
            right: -20%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }
        
        .card-preview .card-type {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 1.8rem;
        }
        
        .card-preview .card-number {
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            font-size: 1.2rem;
            margin-top: 2.5rem;
            margin-bottom: 1.5rem;
        }
        
        .card-preview .card-details {
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
   <div class="payment-container">
        <div class="payment-header">
            <h1><i class="fas fa-lock"></i> Secure Payment</h1>
        </div>
        
        <div class="payment-body">
            <!-- Add trip details at the top -->
            <div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                <h3 style="margin-bottom: 10px;">Booking: <?php echo htmlspecialchars($trip['trip_name']); ?></h3>
                <p><strong>Destination:</strong> <?php echo htmlspecialchars($trip['destination']); ?></p>
                <p><strong>Price:</strong> $<?php echo htmlspecialchars($trip['budget']); ?></p>
            </div>
                <div class="card-number">•••• •••• •••• 9909</div>
                <div class="card-details">
                    <div>
                        <div class="label">CARDHOLDER NAME</div>
                        <div class="value">John Doe</div>
                    </div>
                    <div>
                        <div class="label">EXPIRES</div>
                        <div class="value">12/25</div>
                    </div>
                </div>
            </div>
            
                        <form method="POST">

                <div class="form-group card-number-group">
                    <label for="cardnumber">Card Number</label>
                    <div class="input-field">
                        <i class="far fa-credit-card"></i>
                        <input type="text" id="cardnumber" placeholder="1234 5678 9012 3456" maxlength="19" value="0125 6780 4567 9909">
                        <div class="card-icons"> 
                            <!-- Visa Logo SVG -->
                            <img src="https://www.pngplay.com/wp-content/uploads/12/Visa-Card-Logo-No-Background.png" alt="Visa" class="active">
                            <!-- Mastercard Logo SVG -->
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRgMyqM7pv04T82nGYoR6hQKa-HsJZ8gCmbXg&s" alt="Mastercard">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="cardname">Cardholder Name</label>
                    <div class="input-field">
                        <i class="far fa-user"></i>
                        <input type="text" id="cardname" placeholder="Name as on card">
                    </div>
                </div>
                
                <div class="row">
                    <div class="form-group">
                        <label for="expiry">Expiry Date</label>
                        <div class="input-field">
                            <i class="far fa-calendar-alt"></i>
                            <input type="text" id="expiry" placeholder="MM/YY">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="cvv">CVV</label>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="text" id="cvv" placeholder="•••" maxlength="3">
                        </div>
                    </div>
                </div>
                
                <div class="checkbox-container">
                    <input type="checkbox" id="savecard" checked>
                    <label for="savecard">Save card details for future payments</label>
                </div>
                

    <button type="submit" class="submit-btn">
                    <i class="fas fa-lock"></i> Pay & Book Now
                </button>        </form>
        </div>
    </div>
    
    <script>
        // Simple card number formatting
        document.getElementById('cardnumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '');
            if (value.length > 0) {
                value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
            }
            e.target.value = value;
        });
        
        // Expiry date formatting
        document.getElementById('expiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>