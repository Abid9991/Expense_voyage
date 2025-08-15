<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Voyage</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=UnifrakturCook:wght@700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .header {
            background: white;
            padding: 20px 30px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .logo {
            font-size: 50px;
            font-weight: bold;
            color: #001f4d;
            font-family: 'UnifrakturCook', cursive;
            text-align: center;
        }
        .logo span {
            color: #0088a9;
        }
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 25px;
        }
        .nav {
            display: flex;
            gap: 25px;
        }
        .nav a {
            text-decoration: none;
            color: #001f4d;
            font-size: 18px;
            font-weight: 900;
            font-family: 'Verdana', sans-serif;
        }
        .nav a:hover {
            color: #0088a9;
        }
        
        .contact-btn {
            background: #0088a9;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            border-radius: 5px;
        }
        .contact-btn:hover {
            background: #005f73;
        }
        .menu-icon {
            display: none;
            font-size: 24px;
            cursor: pointer;
        }
        .video-container {
            width: 100%;
            height: 100vh;
            overflow: hidden;
            position: relative;
        }
        .video-container video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .content-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
            max-width: 1200px;
            margin: auto;
            gap: 50px;
            flex-wrap: wrap;
        }
        .content-text {
            flex: 1;
            text-align: left;
        }
        .content-text h2 {
            font-size: 36px;
            color: #001f4d;
        }
        .content-text p {
            font-size: 18px;
            color: #333;
            margin-top: 10px;
        }
        .content-image {
            flex: 1;
            text-align: center;
        }
        .content-image img {
            width: 100%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .destinations, .Voyage-packages {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
            flex-wrap: wrap;
        }
        .destination-card, .package-card {
            position: relative;
            width: 300px;
            border-radius: 10px;
            overflow: hidden;
        }
        .destination-card img, .package-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .destination-card .label {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #001f4d;
            color: white;
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 5px;
        }
        .destination-card .title {
            position: absolute;
            bottom: 20px;
            left: 10px;
            color: white;
            font-size: 20px;
            font-weight: bold;
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
        .heading-container {
            text-align: left;
            margin: 40px 60px;
        }
        .subheading {
            font-size: 14px;
            color: #6c757d;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .main-heading {
            font-size: 36px;
            font-weight: bold;
            color: #001f4d;
        }
        .main-heading span {
            color: #0088a9;
        }
        .footer {
            background-color: #001f4d;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .footer-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .footer-logo i {
            font-size: 50px;
            color: #0088a9;
            margin-bottom: 20px;
        }
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-bottom: 20px;
        }
        .footer-column h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .footer-column ul {
            list-style: none;
            padding: 0;
        }
        .footer-column ul li {
            margin: 5px 0;
        }
        .footer-column ul li a {
            color: white;
            text-decoration: none;
        }
        .footer-column ul li a:hover {
            text-decoration: underline;
        }
        .social-icons {
            display: flex;
            gap: 20px;
            margin-bottom: 10px;
        }
        .social-icons a {
            font-size: 24px;
            color: white;
            transition: 0.3s;
        }
        .social-icons a:hover {
            color: #0088a9;
        }
        .footer-text {
            font-size: 14px;
            opacity: 0.8;
        }
        
        /* New styles for profile icon */
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
            .logo {
                font-size: 40px;
            }
            .nav-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .nav {
                flex-direction: column;
                display: none;
                width: 100%;
                padding: 10px 0;
            }
            .nav.active {
                display: flex;
            }
            .menu-icon {
                display: block;
                position: absolute;
                top: 20px;
                right: 20px;
            }
            .contact-btn {
                width: 100%;
                margin-top: 10px;
            }
            .content-wrapper {
                flex-direction: column;
                padding: 20px;
            }
            .content-text, .content-image {
                flex: 1 1 100%;
                text-align: center;
            }
            .destinations, .Voyage-packages {
                flex-direction: column;
                align-items: center;
            }
            .destination-card, .package-card {
                width: 100%;
                margin-bottom: 20px;
            }
            .heading-container {
                margin: 20px;
            }
            .footer-links {
                flex-direction: column;
                gap: 20px;
            }
            
            /* Adjust profile icon for mobile */
            .profile-icon {
                right: 60px;
                top: 20px;
                width: 35px;
                height: 35px;
                font-size: 18px;
            }
        }
        @media (max-width: 480px) {
            .logo {
                font-size: 30px;
            }
            .content-text h2 {
                font-size: 28px;
            }
            .content-text p {
                font-size: 16px;
            }
            .main-heading {
                font-size: 28px;
            }
            .subheading {
                font-size: 12px;
            }
            .footer-logo i {
                font-size: 40px;
            }
            .social-icons a {
                font-size: 20px;
            }
            .footer-text {
                font-size: 12px;
            }
            
            /* Further adjust profile icon for small screens */
            .profile-icon {
                right: 50px;
                width: 30px;
                height: 30px;
                font-size: 16px;
            }
        }
        .contact-btn {
            position: relative;
            background: #0088a9;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .contact-btn:hover {
            background: #005f73;
        }

        .contact-btn::after {
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            background: #001f4d;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }

        .contact-btn:hover::after {
            opacity: 1;
        }

    </style>
    <!-- Add Font Awesome for the user icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <header class="header">
        <div class="logo">Expense <span>Voyage</span></div>
        <!-- Add the profile icon here -->
        <a href="userprofile.php" class="profile-icon">
            <i class="fas fa-user"></i>
        </a>
        <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        <div class="nav-container">
            <nav class="nav">
                <a href="index.php">Home</a>
                <div class="dropdown">
                    <a href="international.php" class="dropbtn">Voyage Packages <i class="fas fa-chevron-down"></i></a>
                </div>
                <a href="contact.php">Contact Us</a>
                <a href="about.php">About Us</a>
                            <a href="converter.php">Currency Convert</a>

            </nav>
           <a href="memberform.php"> <button class="contact-btn">Register/Login</button></a>
        </div>
    </header>
    <div class="video-container">
        <video autoplay loop muted>
            <source src="img/3120322-uhd_3840_2160_24fps.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>
    <a href="about.php" style="text-decoration: none;">
    <div class="content-wrapper">
        <div class="content-text">
            <h2>WELCOME TO <span style="color: #0088a9;">Expense Voyage AND TRAVELS</span></h2>
            <p> Welcome to <span style="font-weight: 600;">Expense Voyage Agency**</span>, your trusted travel partner in Hyderabad, Pakistan! We specialize in crafting unforgettable travel experiences, offering top-notch services for domestic and international Voyage. Whether you're looking for adventure, luxury, or a relaxing getaway, we ensure hassle-free travel with expert guidance and unbeatable deals.  
                At **<span style="font-weight: 600;">Expense Voyage Agency**</span>, we are committed to making your travel dreams come true. We offer customized Voyage packages, visa assistance, ticket booking, hotel reservations, and transport services. With a passion for excellence and customer satisfaction, we guarantee smooth and enjoyable journeys. Explore the world with confidence—travel with Expense Voyage Agency!.</p>
        </div>
        <div class="content-image">
            <img src="img/about.jpg" alt="Expense Voyage Travel Image">
        </div>
    </div></a>
    <div class="heading-container">
        <p class="subheading">CHOOSE YOUR PLACE</p>
        <h2 class="main-heading">INTERNATIONAL <span>PACKAGES</span></h2>
    </div>
    <div class="destinations">
        <div class="destination-card">
            <a href="international.php">
                <img src="img/paris.jpeg" alt="Paris">
                <div class="label">PARIS</div>
                <div class="title">Paris<br><span style="font-size: 14px;">Top Destinations</span></div>
            </a>
        </div>
        <div class="destination-card">
            <a href="international.php">
                <img src="img/dubai.jpeg" alt="Dubai">
                <div class="label">DUBAI</div>
                <div class="title">Dubai<br><span style="font-size: 14px;">Top Destinations</span></div>
            </a>
        </div>
        <div class="destination-card">
            <a href="international.php">
                <img src="img/london.webp" alt="London">
                <div class="label">LONDON</div>
                <div class="title">London<br><span style="font-size: 14px;">Top Destinations</span></div>
            </a>
        </div>
    </div>
    <div class="heading-container">
        <p class="subheading">HOLIDAY PACKAGES</p>
        <h2 class="main-heading">POPULAR <span>Voyage AREAS</span></h2>
    </div>
    <div class="Voyage-packages">
        <div class="package-card">
            <a href="forest.php">
                <img src="img/forest.jpeg" alt="Forest Voyage">
                <div class="package-title">📍 Forest Voyage</div>
            </a>
        </div>
        <div class="package-card">
            <a href="mountain.php">
                <img src="img/mountain.jpeg" alt="Mountain Voyage">
                <div class="package-title">📍 Mountain Voyage</div>
            </a>
        </div>
        <div class="package-card">
            <a href="beach.php">
                <img src="img/beaches.webp" alt="Beaches Voyage">
                <div class="package-title">📍 Beaches Voyage</div>
            </a>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <i class="fas fa-plane-departure"></i>
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="forest.php">Forest</a></li>
                        <li><a href="mountain.php">Mountain</a></li>
                        <li><a href="beach.php">Beach</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Popular Links</h3>
                    <ul>
                        <li><a href="international.php">Paris</a></li>
                        <li><a href="international.php">Dubai</a></li>
                        <li><a href="international.php">London</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </div>
            </div>
            <div class="social-icons">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
            <p class="footer-text">©2025 Expense Voyage and Travels. All rights reserved.</p>
        </div>
    </footer>
    <script src="https://kit.fontawesome.com/your-kit-code.js" crossorigin="anonymous"></script>
    <script>
        function toggleMenu() {
            document.querySelector('.nav').classList.toggle('active');
        }

        function toggleMenu() {
            document.querySelector('.nav').classList.toggle('active');
        }
    </script>
</body>
</html>