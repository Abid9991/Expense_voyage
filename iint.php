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

// ==== FETCH TRIPS ====
$result = $conn->query("SELECT * FROM trips ORDER BY trip_id DESC");
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
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin: 40px;
        }
        .tour-card {
            background: #f0f9fd;
            border-top: 4px solid #b3002d;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .tour-card img {
            width: 100%;
            height: 200px;
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
        .more-details {
            display: inline-block;
            background: #002147;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 3px;
            cursor: pointer;
        }
        .tour-packages {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }
        .package-card {
            position: relative;
            width: 300px;
            border-radius: 10px;
            overflow: hidden;
        }
        .package-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .package-title {
            position: absolute;
            bottom: 10px;
            left: 10px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            background: rgba(0, 0, 0, 0.5);
            padding: 5px 10px;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            background-color: #002147;
            color: white;
            padding: 20px;
        }
        .foot-p {
            font-size: medium;
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

        /* Responsive Styles */
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
            }
            .tour-packages {
                flex-direction: column;
                align-items: center;
            }
            .package-card {
                width: 100%;
            }
            .modal-content {
                width: 80%;
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
            .more-details {
                font-size: 12px;
                padding: 8px 12px;
            }
            .modal-content {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">Pleasant <span>Tours</span></div>
        <nav class="nav">
            <a href="index.php">Home</a>
            <div class="dropdown">
                <a href="international.php" class="dropbtn">Tour Packages <i class="fas fa-chevron-down"></i></a>
                <div class="dropdown-content">
                </div>
            </div>
            <a href="contact.php">Contact Us</a>
            <a href="about.php">About Us</a>
        </nav>
        <a href="memberform.php"> <button class="contact-btn">Register/Login</button></a>
    </header>
    
    <div class="heading-container">
        <h2 class="main-heading">INTERNATIONAL <span>TOUR PACKAGES</span></h2>
    </div>
    
    <div class="tour-container">
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
                    <button class="more-details" onclick="showDetails(
                        '<?php echo $row['trip_name']; ?>', 
                        '$<?php echo $row['budget']; ?>', 
                        '<?php echo $row['destination']; ?>', 
                        'Custom Hotel', 
                        'Experience this amazing trip to <?php echo $row['destination']; ?> from <?php echo $row['start_date']; ?> to <?php echo $row['end_date']; ?>.')">
                        More Details
                    </button>
                </div>
            </div>
        <?php } ?>
    </div>
    
    <div class="heading-container">
        <h2 class="main-heading">POPULAR <span>TOUR AREAS</span></h2>
    </div>
    <div class="tour-packages">
        <div class="package-card">
            <a href="forest.php">
                <img src="img/forest.jpeg" alt="Forest Tours">
                <div class="package-title">📍 Forest Tours</div>
            </a>
        </div>
        <div class="package-card">
            <a href="mountain.php">
                <img src="img/mountain.jpeg" alt="Mountain Tours">
                <div class="package-title">📍 Mountain Tours</div>
            </a>
        </div>
        <div class="package-card">
            <a href="beach.php">
                <img src="img/beaches.webp" alt="Beaches Tours">
                <div class="package-title">📍 Beaches Tours</div>
            </a>
        </div>
    </div>
    
    <div class="footer">
        <p class="foot-p">©2025 Pleasant Tour and Travels. All rights reserved.</p>
    </div>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modal-title"></h2>
            <p><strong>Price:</strong> <span id="modal-price"></span></p>
            <p><strong>Visited Places:</strong> <span id="modal-places"></span></p>
            <p><strong>Hotel:</strong> <span id="modal-hotel"></span></p>
            <p><strong>Details:</strong> <span id="modal-details"></span></p>
            <button onclick="downloadTripDetails()" class="more-details">Download Trip Details</button>
        </div>
    </div>

    <script>
        function showDetails(title, price, places, hotel, details) {
            document.getElementById('modal-title').innerText = title;
            document.getElementById('modal-price').innerText = price;
            document.getElementById('modal-places').innerText = places;
            document.getElementById('modal-hotel').innerText = hotel;
            document.getElementById('modal-details').innerText = details;
            document.getElementById('modal').style.display = "flex";
        }

        function closeModal() {
            document.getElementById('modal').style.display = "none";
        }

        function downloadTripDetails() {
            const title = document.getElementById('modal-title').innerText;
            const price = document.getElementById('modal-price').innerText;
            const places = document.getElementById('modal-places').innerText;
            const hotel = document.getElementById('modal-hotel').innerText;
            const details = document.getElementById('modal-details').innerText;

            const content = `Trip Details:\n\nTitle: ${title}\nPrice: ${price}\nVisited Places: ${places}\nHotel: ${hotel}\nDetails: ${details}`;

            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.href = url;
            a.download = `${title.replace(/ /g, '_')}_Trip_Details.pdf`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    </script>
</body>
</html>