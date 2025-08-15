<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Expense Voyage</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* ===== Global Styles ===== */
        :root {
            --primary: #1e3a8a;  /* Dark blue */
            --secondary: #3b82f6; /* Medium blue */
            --accent: #ffffff;    /* White */
            --dark: #111827;     /* Very dark blue */
            --light: #f8fafc;    /* Light grayish blue */
            --gray: #64748b;     /* Medium gray */
            --white: #ffffff;
            --shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease-in-out;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
                    font-family: Arial, sans-serif;
                    text-align: center;
                }
                
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: white;
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
        h1 {
            font-size: 32px;
            font-weight: normal;
            color: #002147;
            font-weight: bold;
        }
        h1 span {
            color: #0088a9;
            font-weight: bold;
        }
        strong {
            font-weight: bold;
        }
        p {
            margin-bottom: 15px;
        }
        .highlight {
            font-weight: bold;
        }
        .contact {
            font-weight: bold;
            color: #a52a2a;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.7;
            color: var(--dark);
            background-color: var(--light);
            overflow-x: hidden;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* ===== Header Styles ===== */
        .header {
            background: var(--white);
            box-shadow: var(--shadow);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            padding: 15px 0;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
        }
        
        .logo span {
            color: var(--secondary);
        }
        
        .nav {
            display: flex;
            gap: 30px;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--dark);
            text-decoration: none;
            position: relative;
            padding: 5px 0;
            transition: var(--transition);
        }
        
        .nav-link:hover {
            color: var(--primary);
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: var(--transition);
        }
        
        .nav-link:hover::after {
            width: 100%;
        }
        
        .contact-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }
        
        .contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
        }
        
        /* ===== Hero Section ===== */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 60vh;
            display: flex;
            align-items: center;
            text-align: center;
            margin-top: 70px;
        }
        
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            color: var(--white);
        }
        
        .hero-title {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            font-family: 'Playfair Display', serif;
        }
        
        .hero-title span {
            color: var(--secondary);
        }
        
        .hero-text {
            font-size: 18px;
            margin-bottom: 30px;
        }
        
        /* ===== Contact Section ===== */
        .section {
            padding: 60px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
        }
        
        .section-title h2 {
            font-size: 36px;
            font-weight: 700;
            color: var(--primary);
            display: inline-block;
            position: relative;
            font-family: 'Playfair Display', serif;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: var(--secondary);
        }
        
        /* Contact Info */
        .contact-info {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .contact-card {
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
            flex: 1;
            min-width: 200px;
        }
        
        .contact-card:hover {
            transform: translateY(-5px);
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 20px;
        }
        
        .contact-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--primary);
        }
        
        .contact-card p {
            color: var(--gray);
            font-size: 14px;
        }
        
        /* Contact Form */
        .contact-form {
            background: var(--white);
            padding: 40px;
            border-radius: 10px;
            box-shadow: var(--shadow);
            max-width: 800px;
            margin: 0 auto;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--primary);
            font-size: 14px;
        }
        
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-family: inherit;
            font-size: 14px;
            transition: var(--transition);
        }
        
        .form-control:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        }
        
        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }
        
        .submit-btn {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 30px;
            cursor: pointer;
            transition: var(--transition);
            display: block;
            margin: 0 auto;
            box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
        }
        
        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
        }
        
        /* Map Section */
        .map-section {
            padding-bottom: 60px;
        }
        
        .map-container {
            height: 350px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            max-width: 1000px;
            margin: 0 auto;
        }
        
        .map-container iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
        
        /* ===== Compact Footer ===== */
        .footer {
            background: var(--dark);
            color: var(--white);
            padding: 30px 0 15px;
            text-align: center;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .footer-column {
            flex: 1;
            min-width: 200px;
            text-align: left;
        }
        
        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 15px;
            display: inline-block;
        }
        
        .footer-logo span {
            color: var(--secondary);
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 15px;
            font-size: 13px;
        }
        
        .social-links {
            display: flex;
            gap: 12px;
            justify-content: flex-start;
        }
        
        .social-link {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            transition: var(--transition);
            font-size: 14px;
        }
        
        .social-link:hover {
            background: var(--secondary);
            transform: translateY(-3px);
        }
        
        .footer-links h3 {
            font-size: 16px;
            margin-bottom: 15px;
            color: var(--white);
            position: relative;
            padding-bottom: 8px;
        }
        
        .footer-links h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--secondary);
        }
        
        .footer-links ul {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 8px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: var(--transition);
            font-size: 13px;
        }
        
        .footer-links a:hover {
            color: var(--secondary);
            padding-left: 3px;
        }
        
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 15px;
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
        }
        
        /* ===== Responsive Styles ===== */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 36px;
            }
            
            .section-title h2 {
                font-size: 30px;
            }
            
            .contact-info {
                flex-wrap: wrap;
            }
            
            .contact-card {
                min-width: calc(50% - 20px);
            }
        }
        
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
            }
            
            .nav {
                margin: 15px 0;
                gap: 15px;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .hero {
                height: 50vh;
            }
            
            .hero-title {
                font-size: 30px;
            }
            
            .contact-form {
                padding: 25px;
            }
            
            .footer-column {
                min-width: 150px;
            }
        }
        
        @media (max-width: 576px) {
            .hero {
                height: 40vh;
                margin-top: 60px;
            }
            
            .hero-title {
                font-size: 24px;
            }
            
            .section {
                padding: 40px 0;
            }
            
            .section-title h2 {
                font-size: 26px;
            }
            
            .contact-card {
                min-width: 100%;
            }
            
            .footer-content {
                flex-direction: column;
                gap: 20px;
            }
            
            .footer-column {
                text-align: center;
            }
            
            .social-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->

    <header class="header">
        <div class="logo">Expense <span>Voyage</span></div>
        <nav class="nav">
            <a href="index.php">Home</a>
            <div class="dropdown">
                <a href="international.php" class="dropbtn">Tour Packages <i class="fas fa-chevron-down"></i></a>

                </div>
            </div>
            <a href="contact.php">Contact Us</a>
            <a href="about.php">About Us</a>
                        <a href="converter.php">Currency Convert</a>

        </nav>
            <a href="memberform.php"> <button class="contact-btn">Register/Login</button></a>

    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Contact <span>Us</span></h1>
                <p class="hero-text">We're here to help you plan your dream vacation. Reach out to our travel experts for personalized assistance.</p>
            </div>
        </div>
    </section>

    <!-- Contact Info Section -->
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Get In Touch</h2>
            </div>
            
            <div class="contact-info">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3>Phone</h3>
                    <p>+92 331 3145820</p>
                    <p>+92 317 3192197</p>
                </div>
                
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p>info@ExpenseVoyage.com</p>
                    <p>support@ExpenseVoyage.com</p>
                </div>
                
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Address</h3>
                    <p>Defence Main Street</p>
                    <p>Hyderabad, Pakistan</p>
                </div>
                
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Working Hours</h3>
                    <p>Mon-Fri: 9AM - 6PM</p>
                    <p>Sat: 10AM - 4PM</p>
                </div>
            </div>
            
            <div class="section-title">
                <h2>Send Us a Message</h2>
            </div>
            
            <div class="contact-form">
                <form>
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number</label>
                        <input type="tel" id="phone" class="form-control" placeholder="Enter your phone number">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" id="subject" class="form-control" placeholder="What's this about?">
                    </div>
                    
                    <div class="form-group">
                        <label for="message" class="form-label">Your Message</label>
                        <textarea id="message" class="form-control" placeholder="How can we help you?" required></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="section map-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Location</h2>
            </div>
            
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3618.664063991527!2d67.02881431500835!3d24.91462298402871!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb33f90157042d3%3A0x93d609e8bec9a880!2sAptech%20Computer%20Education%20North%20Nazimabad%20Center!5e0!3m2!1sen!2s!4v1623750000000!5m2!1sen!2s" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <a href="index.php" class="footer-logo">Expense <span>Voyage</span></a>
                    <p class="footer-text">Creating unforgettable travel experiences since 2010. We specialize in customized Voyage tailored to your preferences.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <div class="footer-links">
                        <h3>Quick Links</h3>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="international.php">Tour Packages</a></li>
                            <li><a href="contact.php">Contact</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-column">
                    <div class="footer-links">
                        <h3>Tour Categories</h3>
                        <ul>
                            <li><a href="international.php">International Voyage</a></li>
                            <li><a href="beach.php">Beach Holidays</a></li>
                            <li><a href="forest.php">Forest Adventures</a></li>
                            <li><a href="mountain.php">Mountain Treks</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-column">
                    <div class="footer-links">
                        <h3>Contact Info</h3>
                        <ul>
                            <li><i class="fas fa-map-marker-alt"></i> Defence Main Street</li>
                            <li><i class="fas fa-phone-alt"></i> +92 331 3145820</li>
                            <li><i class="fas fa-envelope"></i> info@ExpenseVoyage.com</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; 2025 Expense Voyage & Travels. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function redirectToWhatsApp() {
            const phoneNumber = "+923313145820";
            const message = "Hello, I would like to inquire about your tour packages.";
            const url = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
            window.open(url, '_blank');
        }
    </script>
</body>
</html>