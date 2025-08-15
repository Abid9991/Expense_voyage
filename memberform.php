<?php
// debug on — helpful while developing
ini_set('display_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

session_start();

// ==== DATABASE CONNECTION ====
$host = "localhost";
$user = "root";
$pass = "";
$db   = "project";

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset('utf8mb4');
} catch (Exception $e) {
    die("DB Connection failed: " . $e->getMessage());
}

$message = '';
$message_type = 'info';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ===== SIGNUP =====
    if (isset($_POST['register'])) {
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name  = trim($_POST['last_name'] ?? '');
        $email      = trim($_POST['email'] ?? '');
        $password   = $_POST['password'] ?? '';

        if ($first_name === '' || $email === '' || $password === '') {
            $message = 'Please fill in the required fields.';
            $message_type = 'warning';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            try {
                $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password_hash) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $first_name, $last_name, $email, $password_hash);
                $stmt->execute();
                $stmt->close();

                $message = 'Account created successfully. You can now log in.';
                $message_type = 'success';
            } catch (mysqli_sql_exception $e) {
                // Duplicate entry for unique email
                if ($e->getCode() == 1062) {
                    $message = 'That email is already registered.';
                    $message_type = 'danger';
                } else {
                    $message = 'Database error: ' . $e->getMessage();
                    $message_type = 'danger';
                }
            }
        }
    }

    // ===== LOGIN =====
    if (isset($_POST['login'])) {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if($email == "admin@gmail.com" && $password == "admin123") {
            header('Location: adminpanel.php');
            exit;
        }

        if ($email === '' || $password === '') {
            $message = 'Enter email and password.';
            $message_type = 'warning';
        } else {
            $stmt = $conn->prepare("SELECT user_id, first_name, last_name, email, password_hash FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows === 1) {
                $stmt->bind_result($user_id, $first_name, $last_name, $email, $hash);
                $stmt->fetch();

                if (password_verify($password, $hash)) {
                    // success — set session and redirect
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['last_name'] = $last_name;
                    $_SESSION['email'] = $email;
                    $stmt->close();
                    $conn->close();
                    header('Location: userprofile.php'); // Changed to redirect to profile.php
                    exit;
                } else {
                    $message = 'Incorrect password.';
                    $message_type = 'danger';
                }
            } else {
                $message = 'No account found with that email.';
                $message_type = 'danger';
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .header {
            padding: 20px 30px;
            box-shadow: 0px 4px 6px rgba(0,0,0,0.1);
            color: #0088a9;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
        }
        .logo { font-size: 50px; font-weight: bold; color: #001f4d; font-family: 'UnifrakturCook', cursive; text-align: center; }
        .logo span { color: #0088a9; }
        .nav-container { display:flex; justify-content:space-between; align-items:center; gap:25px; }
        .nav { display:flex; gap:25px; }
        .nav a { text-decoration:none; color:#001f4d; font-size:18px; font-weight:900; font-family:Verdana, sans-serif; }
        .nav a:hover { color:#0088a9; }
        .contact-btn { background:#0088a9; color:white; padding:10px 20px; border:none; cursor:pointer; font-size:16px; text-transform:uppercase; border-radius:5px; }
        .hero-section { height:50vh; background: url('img/Himalayas Trekking.jpeg') center/cover no-repeat; position:relative; }
        .overlay { position:absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); }
        .hero-content { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center; color:white; }
        .form-container { background:#111; padding:30px; }
        .form-container input { color:white !important; }
        input::placeholder, textarea::placeholder { color:#ffffff !important; }
        .footer { background-color:#001f4d; color:white; padding:40px 20px; text-align:center; }

        /* Add these styles to your existing style section */
.section {
    background-color: #f8f9fa;
    padding: 50px 0;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
}

.row {
    display: flex;
    gap: 20px;
    justify-content: center;
}

.col-md-6 {
    width: 45%;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.bg-light {
    background-color: #ffffff;
}

.bg-white {
    background-color: #ffffff;
}

h3 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
    text-transform: uppercase;
}

.form-control {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    background-color: #f9f9f9;
}

.btn {
    padding: 12px;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    text-transform: uppercase;
}

.btn-primary {
    background-color: #0088a9;
    color: white;
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.w-100 {
    width: 100%;
}

.mb-2 {
    margin-bottom: 10px;
}

.mb-3 {
    margin-bottom: 15px;
}

/* Style for the form headings to match the image */
h3:first-child {
    color: #0088a9;
}

/* Style for the input placeholders */
::placeholder {
    color: #999 !important;
    opacity: 1;
}

/* Remove the dark background from your original style */
.form-container {
    background: transparent;
    padding: 0;
}

.form-container input {
    color: #333 !important;
}


    </style>
</head>
<body>


   
    <div class="hero-section">
        <div class="overlay"></div>
        <div class="hero-content"><h1>SIGNUP OR LOGIN</h1></div>
    </div>

    <section class="section py-5">
        <div class="container">
            <!-- message -->
            <?php if ($message): ?>
                <div class="row mb-3">
                    <div class="col-md-8 mx-auto">
                        <div class="alert alert-<?php echo htmlspecialchars($message_type); ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 p-4 bg-light rounded shadow">
                    <h3 class="mb-3">Become a Member</h3>
                    <form method="post" action="">
                        <input type="text" name="first_name" class="form-control mb-2" placeholder="First Name" required>
                        <input type="text" name="last_name" class="form-control mb-2" placeholder="Last Name">
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                        <button type="submit" name="register" class="btn btn-primary w-100">Create Account</button>
                    </form>
                </div>

                <div class="col-md-6 p-4 bg-white rounded shadow">
                    <h3 class="mb-3">Login</h3>
                    <form method="post" action="">
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                        <button type="submit" name="login" class="btn btn-success w-100">Log In</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <p class="footer-text">©2025 Expense Tour and Travels. All rights reserved.</p>
    </footer>

</body>
</html>
