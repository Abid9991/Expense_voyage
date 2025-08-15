<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Expense Voyage</title>
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
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
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
        
        /* ===== About Section ===== */
        .section {
            padding: 60px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 40px;
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
        
        /* About Content */
        .about-content {
            display: flex;
            align-items: center;
            gap: 40px;
            margin-bottom: 50px;
        }
        
        .about-image {
            flex: 1;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        
        .about-image img {
            width: 100%;
            height: auto;
            display: block;
            transition: var(--transition);
        }
        
        .about-image:hover img {
            transform: scale(1.03);
        }
        
        .about-text {
            flex: 1;
        }
        
        .about-text h3 {
            font-size: 28px;
            color: var(--primary);
            margin-bottom: 20px;
            font-family: 'Playfair Display', serif;
        }
        
        .about-text p {
            color: var(--gray);
            margin-bottom: 15px;
        }
        
        /* Features */
        .features {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 50px;
        }
        
        .feature-card {
            background: var(--white);
            padding: 25px;
            border-radius: 8px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
            flex: 1;
            min-width: 0;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 22px;
        }
        
        .feature-card h3 {
            font-size: 18px;
            margin-bottom: 10px;
            color: var(--primary);
        }
        
        .feature-card p {
            color: var(--gray);
            font-size: 14px;
        }
        
        /* Team Section */
        .team {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .team-member {
            background: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: var(--transition);
            text-align: center;
            flex: 1;
            min-width: 220px;
        }
        
        .team-member:hover {
            transform: translateY(-5px);
        }
        
        .member-image {
            height: 200px;
            overflow: hidden;
        }
        
        .member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }
        
        .team-member:hover .member-image img {
            transform: scale(1.1);
        }
        
        .member-info {
            padding: 15px;
        }
        
        .member-info h3 {
            font-size: 18px;
            color: var(--primary);
            margin-bottom: 5px;
        }
        
        .member-info p {
            color: var(--secondary);
            font-weight: 500;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        
        .social-link {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-size: 14px;
        }
        
        .social-link:hover {
            background: var(--secondary);
            color: var(--white);
        }
        
        /* ===== Compact Footer ===== */
        .footer {
            background: var(--dark);
            color: var(--white);
            padding: 30px 0 15px;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .footer-column {
            flex: 1;
            min-width: 0;
            padding: 0 10px;
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
        
        .footer-social-links {
            display: flex;
            gap: 10px;
        }
        
        .footer-social-link {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            transition: var(--transition);
            font-size: 14px;
        }
        
        .footer-social-link:hover {
            background: var(--secondary);
            transform: translateY(-2px);
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
            text-align: center;
        }
        
        /* ===== Responsive Styles ===== */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 36px;
            }
            
            .section-title h2 {
                font-size: 30px;
            }
            
            .features, .team {
                flex-wrap: wrap;
            }
            
            .feature-card, .team-member {
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
            
            .about-content {
                flex-direction: column;
            }
            
            .footer-content {
                flex-wrap: wrap;
            }
            
            .footer-column {
                min-width: calc(50% - 20px);
                margin-bottom: 20px;
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
            
            .feature-card, .team-member {
                min-width: 100%;
            }
            
            .footer-column {
                min-width: 100%;
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
                <h1 class="hero-title">About <span>Us</span></h1>
                <p class="hero-text">Discover the story behind Expense Voyage and our passion for creating unforgettable travel experiences.</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section">
        <div class="container">
            <div class="about-content">
                <div class="about-image">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Our Team at Work">
                </div>
                <div class="about-text">
                    <h3>Our Story</h3>
                    <p>Founded in 2010, Expense Voyage began with a simple mission: to create extraordinary travel experiences that go beyond the ordinary. What started as a small team of travel enthusiasts has grown into a premier travel agency serving thousands of satisfied customers.</p>
                    <p>We believe that travel should be about more than just visiting places - it's about creating memories that last a lifetime. Our team of expert travel consultants works tirelessly to craft personalized itineraries that match your unique interests and preferences.</p>
                    <p>With offices in Hyderabad and partnerships worldwide, we're proud to offer exceptional service and insider access to destinations across the globe.</p>
                </div>
            </div>
            
            <div class="section-title">
                <h2>Why Choose Us</h2>
            </div>
            
            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                    <h3>Global Expertise</h3>
                    <p>Our team has traveled to over 50 countries, bringing you firsthand knowledge and insider tips for every destination.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3>Personalized Service</h3>
                    <p>We tailor every aspect of your trip to your preferences, ensuring a truly unique experience.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Peace of Mind</h3>
                    <p>24/7 support and comprehensive travel protection give you confidence throughout your journey.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <h3>Award Winning</h3>
                    <p>Recognized as Pakistan's best travel agency for three consecutive years by Travel Excellence Awards.</p>
                </div>
            </div>
            
            <div class="section-title">
                <h2>Meet Our Team</h2>
            </div>
            
            <div class="team">
                <div class="team-member">
                    <div class="member-image">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-1.2.1&auto=format&fit=crop&w=334&q=80" alt="Sarah Johnson">
                    </div>
                    <div class="member-info">
                        <h3>Sarah Johnson</h3>
                        <p>Founder & CEO</p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-image">
                        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=334&q=80" alt="Michael Chen">
                    </div>
                    <div class="member-info">
                        <h3>Michael Chen</h3>
                        <p>Travel Director</p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-image">
                        <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-1.2.1&auto=format&fit=crop&w=334&q=80" alt="Priya Patel">
                    </div>
                    <div class="member-info">
                        <h3>Priya Patel</h3>
                        <p>Customer Experience</p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-image">
                        <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?ixlib=rb-1.2.1&auto=format&fit=crop&w=334&q=80" alt="David Wilson">
                    </div>
                    <div class="member-info">
                        <h3>David Wilson</h3>
                        <p>Operations Manager</p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
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
                    <div class="footer-social-links">
                        <a href="#" class="footer-social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="footer-social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="footer-social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="footer-social-link"><i class="fab fa-linkedin-in"></i></a>
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
                        </ul>
                    </div>
                </div>
                
                <div class="footer-column">
                    <div class="footer-links">
                        <h3>Destinations</h3>
                        <ul>
                            <li><a href="international.php">International</a></li>
                            <li><a href="beach.php">Beach Holidays</a></li>
                            <li><a href="forest.php">Forest Adventures</a></li>
                            <li><a href="mountain.php">Mountain Treks</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-column">
                    <div class="footer-links">
                        <h3>Contact</h3>
                        <ul>
                            <li><i class="fas fa-map-marker-alt"></i> Defence Main Street, Hyderabad</li>
                            <li><i class="fas fa-phone-alt"></i> +92 331 3145820</li>
                            <li><i class="fas fa-envelope"></i> info@ExpenseVoyage.com</li>
                            <li><i class="fas fa-clock"></i> Mon-Fri: 9AM-6PM</li>
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