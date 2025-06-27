<?php
session_start();
include "../includes/config.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch upcoming trips
$today = date("Y-m-d");
$trip_query = "SELECT * FROM trips WHERE user_id = '$user_id' AND start_date >= '$today' ORDER BY start_date ASC LIMIT 1";
$trip_result = mysqli_query($conn, $trip_query);
$upcoming_trip = mysqli_fetch_assoc($trip_result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Travella</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: linear-gradient(to right, #FEECDC, #FFFBF5);
            color: #333;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #ff7e5f;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            color: white;
            transition: width 0.3s;
        }
        .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;  /* Makes the logo round */
            object-fit: cover;   /* Ensures the image fits within the circle */
            margin-bottom: 20px;
            border: 3px solid white; /* Optional: Adds a border for better visibility */
        }
        .sidebar a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            padding: 12px;
            margin: 8px 0;
            border-radius: 5px;
            transition: 0.3s;
            font-size: 16px;
        }
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 5px solid #fff;
            transform: scale(1.05);
        }
        .main-content {
            margin-left: 270px;
            padding: 20px;
            transition: 0.3s;
        }
        .header {
            background: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .header h1 {
            font-size: 1.8rem;
        }
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            min-height: 250px;
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-img {
            width: 100%;
            height: 200px;
            border-radius: 10px;
            object-fit: cover;
            margin-bottom: 10px;
        }
        .card-btn {
            text-decoration: none;
            background: #ff7e5f;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
            transition: 0.3s;
            font-weight: bold;
        }
        .card-btn:hover {
            background: #e06c53;
        }
        .trip-section {
            margin-top: 30px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            padding: 20px;
            background: #333;
            color: white;
            text-align: center;
            border-radius: 10px;
        }

        /* Media queries for responsive layout */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px; /* Decrease the sidebar width on smaller screens */
            }

            .main-content {
                margin-left: 0; /* Remove left margin to allow for sidebar toggle */
            }

            .dashboard-cards {
                grid-template-columns: repeat(1, 1fr); /* Show cards in a single column on small screens */
            }

            #toggleSidebar {
                display: block; /* Make the sidebar toggle button visible on mobile */
                position: absolute;
                top: 20px;
                right: 20px;
                font-size: 30px;
                background: #ff7e5f;
                color: white;
                border: none;
                padding: 10px;
                border-radius: 50%;
                cursor: pointer;
            }

            .sidebar.collapsed {
                width: 0;
                padding: 0;
            }

            .main-content.collapsed {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<button id="toggleSidebar">☰</button>

<div class="sidebar">
    <img src="../assets/images/logo.png" class="logo" alt="Travella Logo">
    <a href="dashboard.php" class="active"><i class="fas fa-home"></i> Dashboard</a>
    <a href="my_diary.php"><i class="fas fa-book"></i> My Travel Diary</a>
    <a href="recommendations.php"><i class="fas fa-lightbulb"></i> AI Recommendations</a>
    <a href="trip_planner.php"><i class="fas fa-map"></i> Trip Planner</a>
    <a href="setting.php"><i class="fas fa-cog"></i> Settings</a>
    <a href="../user/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <a href="../user/logout.php" class="card-btn">Logout</a>
    </div>

    <div class="dashboard-cards">
        <div class="card">
            <img src="../assets/images/travel_diary.jpg" class="card-img">
            <h3>My Travel Diaries</h3>
            <a href="my_diary.php" class="card-btn">View Diaries</a>
        </div>
        <div class="card">
            <img src="../assets/images/ai_recommendation.jpg" class="card-img">
            <h3>AI Recommendations</h3>
            <a href="recommendations.php" class="card-btn">Get Suggestions</a>
        </div>
        <div class="card">
            <img src="../assets/images/explore_places.jpg" class="card-img">
            <h3>Explore New Places</h3>
            <a href="map.php" class="card-btn">Discover</a>
        </div>
    </div>
    <div class="trip-section" id="ai-helper">
    <img src="../assets/images/cb2.jpg" class="card-img">
    <h4>TRAVELLO</h4>
    <a href="chatbot.php" class="card-btn">💬 Chat with AI Assistant</a>
</div>

    <!-- Plan a New Trip Section -->
<div class="trip-section">
    <img src="../assets/images/trip_planner2.jpg" class="card-img">
    <h2>Plan a New Trip</h2>
    <a href="trip_planner.php" class="card-btn">Start Planning</a>
</div>
<!-- AI Chatbot Assistant Section -->

<!-- Upcoming Trip Section -->
<div class="trip-section">
    <h2>Upcoming Trip</h2>
    <?php 
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM trips WHERE user_id = '$user_id' AND start_date >= CURDATE() ORDER BY start_date ASC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $upcoming_trip = mysqli_fetch_assoc($result);

    if ($upcoming_trip): ?>
        <h3><?php echo htmlspecialchars($upcoming_trip['destination']); ?></h3>
        <a href="trip_details.php?trip_id=<?php echo $upcoming_trip['id']; ?>" class="card-btn">View</a>
    <?php else: ?>
        <p>No upcoming trips found. Plan your next trip now!</p>
    <?php endif; ?>
</div>


<div class="footer">
    <p>&copy; 2025 Travella. All Rights Reserved.</p>
</div>
</div>

<script>
document.getElementById('toggleSidebar').addEventListener('click', function () {
    document.querySelector('.sidebar').classList.toggle('collapsed');
    document.querySelector('.main-content').classList.toggle('collapsed');
});
</script>

</body>
</html>
