<?php
// admin-dashboard.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Travel Website</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a73e8;
            --primary-dark: #0d5bbc;
            --primary-light: #e8f0fe;
            --secondary-color: #f8f9fa;
            --text-dark: #202124;
            --text-medium: #5f6368;
            --text-light: #ffffff;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.1);
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: var(--secondary-color);
            color: var(--text-dark);
            line-height: 1.6;
            min-height: 100vh;
            padding: 0;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 280px;
            background: white;
            box-shadow: var(--shadow-md);
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .sidebar-header h2 {
            color: var(--primary-color);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header h2 i {
            font-size: 1.8rem;
        }

        .nav-menu {
            list-style: none;
            padding: 0 15px;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text-medium);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .nav-link:hover, .nav-link.active {
            background-color: var(--primary-light);
            color: var(--primary-color);
        }

        .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .welcome {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text-dark);
            animation: fadeSlide 1s ease-out forwards;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Dashboard Cards */
        .dashboard-title {
            font-size: 1.5rem;
            margin-bottom: 25px;
            color: var(--text-dark);
            font-weight: 600;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .card-header {
            position: relative;
            height: 180px;
            overflow: hidden;
        }

        .card-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .card:hover .card-header img {
            transform: scale(1.05);
        }

        .card-icon {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255,255,255,0.9);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.5rem;
            box-shadow: var(--shadow-sm);
        }

        .card-content {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .card-content h2 {
            margin-bottom: 12px;
            font-size: 1.4rem;
            color: var(--text-dark);
            font-weight: 600;
        }

        .card-content p {
            font-size: 0.95rem;
            line-height: 1.5;
            color: var(--text-medium);
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .card-footer {
            padding: 0 20px 20px;
        }

        .card-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 0.95rem;
            font-weight: 500;
            transition: var(--transition);
            text-decoration: none;
        }

        .card-btn:hover {
            background: var(--primary-dark);
            box-shadow: var(--shadow-md);
        }

        .card-btn i {
            font-size: 1rem;
        }

        /* Animations */
        @keyframes fadeSlide {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .sidebar {
                width: 240px;
            }
            .main-content {
                margin-left: 240px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: var(--transition);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .card-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-compass"></i> Admin Panel</h2>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link">
                        <i class="fas fa-home"></i> Home Page
                    </a>
                </li>
                <li class="nav-item">
                    <a href="usermanage.php" class="nav-link">
                        <i class="fas fa-users-cog"></i> User Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="addtrip.php" class="nav-link">
                        <i class="fas fa-plus-circle"></i> Add Trip
                    </a>
                </li>
                <li class="nav-item">
                    <a href="admintrips.php" class="nav-link">
                        <i class="fas fa-calendar-alt"></i> Bookings
                    </a>
                </li>

            </ul>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            <div class="header">
                <h1 class="welcome">Welcome back, Admin</h1>
                <div class="user-profile">
                    <div class="user-avatar">A</div>
                </div>
            </div>

            <h2 class="dashboard-title">Dashboard Overview</h2>
            
           <div class="card-container">
    <!-- Home Page Card -->
    <div class="card">
        <div class="card-header">
            <img src="https://images.unsplash.com/photo-1506929562872-bb421503ef21?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="Home Page">
            <div class="card-icon">
                <i class="fas fa-home"></i>
            </div>
        </div>
        <div class="card-content">
            <h2>Home Page</h2>
            <p>Manage the main content, banners, featured destinations, and overall appearance of your travel website's home page.</p>
        </div>
        <div class="card-footer">
            <a href="index.php" class="card-btn">
                <i class="fas fa-arrow-right"></i> Manage Home Page
            </a>
        </div>
    </div>

    <!-- User Management Card -->
    <div class="card">
        <div class="card-header">
            <img src="https://images.unsplash.com/photo-1552581234-26160f608093?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="User Management">
            <div class="card-icon">
                <i class="fas fa-users-cog"></i>
            </div>
        </div>
        <div class="card-content">
            <h2>User Management</h2>
            <p>View, edit, and manage all registered users, their permissions, and access levels on your travel platform.</p>
        </div>
        <div class="card-footer">
            <a href="usermanage.php" class="card-btn">
                <i class="fas fa-arrow-right"></i> Manage Users
            </a>
        </div>
    </div>

    <!-- Add Trip Card -->
    <div class="card">
        <div class="card-header">
            <img src="https://images.unsplash.com/photo-1464037866556-6812c9d1c72e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="Add Trip">
            <div class="card-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
        </div>
        <div class="card-content">
            <h2>Add Trip</h2>
            <p>Create and manage new travel packages, itineraries, pricing, and availability for your customers.</p>
        </div>
        <div class="card-footer">
            <a href="addtrip.php" class="card-btn">
                <i class="fas fa-arrow-right"></i> Add New Trip
            </a>
        </div>
    </div>

    <!-- Bookings Card -->
    <div class="card">
        <div class="card-header">
            <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80" alt="Bookings">
            <div class="card-icon">
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>
        <div class="card-content">
            <h2>Bookings</h2>
            <p>View and manage all user bookings and saved trips. Track reservations, check statuses, and monitor travel plans.</p>
        </div>
        <div class="card-footer">
            <a href="admintrips.php" class="card-btn">
                <i class="fas fa-arrow-right"></i> Manage Bookings
            </a>
        </div>
    </div>
</div>
        </main>
    </div>

    <script>
        // Simple script to handle mobile menu toggle if needed
        document.addEventListener('DOMContentLoaded', function() {
            // You can add mobile menu toggle functionality here if needed
            console.log('Admin dashboard loaded');
        });
    </script>
</body>
</html>