<?php
session_start();
include "../includes/config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login page if user is not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the last trip added by the user
$query = "SELECT * FROM trips WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);
$trip = mysqli_fetch_assoc($result);

// If no trip found, redirect to homepage or error page
if (!$trip) {
    header("Location: homepage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Success</title>
    
    <!-- Embedded CSS -->
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Main Container */
        .container {
            background: #ffffff;
            padding: 20px;
            max-width: 400px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Heading */
        h1 {
            font-size: 24px;
            color: #333;
            font-weight: 700;
        }

        /* Trip Details */
        p {
            color: #666;
            font-size: 16px;
            margin-top: 10px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            background: #f0f0f0;
            padding: 12px;
            margin: 8px 0;
            border-radius: 10px;
            font-size: 14px;
            color: #555;
        }

        /* Buttons */
        .button {
            display: inline-block;
            text-decoration: none;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: white;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: 0.3s ease-in-out;
            box-shadow: 0px 4px 6px rgba(255, 126, 95, 0.3);
        }

        .button:hover {
            background: #ff6f4b;
            box-shadow: 0px 6px 12px rgba(255, 126, 95, 0.4);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Trip Created Successfully!</h1>
        <p>Your trip to <strong><?php echo htmlspecialchars($trip['destination']); ?></strong> has been successfully added!</p>
        
        <h3>Trip Details:</h3>
        <ul>
            <li><strong>Destination:</strong> <?php echo htmlspecialchars($trip['destination']); ?></li>
            <li><strong>Start Date:</strong> <?php echo htmlspecialchars($trip['start_date']); ?></li>
            <li><strong>End Date:</strong> <?php echo htmlspecialchars($trip['end_date']); ?></li>
            <li><strong>Description:</strong> <?php echo htmlspecialchars($trip['trip_description']); ?></li>
            <li><strong>Trip Type:</strong> <?php echo htmlspecialchars($trip['trip_type']); ?></li>
        </ul>
        
        <a href="create_new_trip.php" class="button">Create Another Trip</a>
        <a href="dashboard.php" class="button">Go to Dashboard</a>
    </div>
</body>
</html>
