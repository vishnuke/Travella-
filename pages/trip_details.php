<?php
session_start();
include "../includes/config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if a trip_id is provided
if (isset($_GET['trip_id'])) {
    $trip_id = $_GET['trip_id'];

    // Fetch trip details
    $query = "SELECT * FROM trips WHERE id = '$trip_id' AND user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    $trip = mysqli_fetch_assoc($result);

    if (!$trip) {
        header("Location: dashboard.php");
        exit();
    }

    // Fetch users who accepted the invite
    $invite_query = "SELECT u.username 
                     FROM trip_invites ti
                     JOIN users u ON ti.user_id = u.id
                     WHERE ti.trip_id = '$trip_id'";
    $invite_result = mysqli_query($conn, $invite_query);
    $accepted_users = mysqli_fetch_all($invite_result, MYSQLI_ASSOC);

} else {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Details | Travella</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: linear-gradient(to right, #FEECDC, #FFFBF5); color: #333; }
        .sidebar {
            width: 250px; height: 100vh; background: #ff7e5f; position: fixed; top: 0; left: 0; padding: 20px;
            box-shadow: 2px 0 10px rgba(0,0,0,0.2); text-align: center; color: white;
        }
        .logo { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 20px; border: 3px solid white; }
        .sidebar a {
            display: flex; align-items: center; text-decoration: none; color: white; padding: 12px; margin: 8px 0;
            border-radius: 5px; transition: 0.3s; font-size: 16px;
        }
        .sidebar a:hover, .sidebar a.active { background: rgba(255,255,255,0.2); border-left: 5px solid #fff; transform: scale(1.05); }
        .main-content { margin-left: 270px; padding: 20px; transition: 0.3s; }
        .header {
            background: white; padding: 15px; display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); border-radius: 10px;
        }
        .header h1 { font-size: 1.8rem; }
        .trip-details {
            background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); margin-top: 20px; text-align: center;
        }
        .trip-details img { width: 100%; height: 200px; object-fit: cover; border-radius: 10px; }
        .trip-details h2 { margin-top: 15px; font-size: 2rem; color: #ff7e5f; }
        .trip-details p { font-size: 1rem; color: #555; margin-top: 10px; }
        .button {
            background: #ff7e5f; color: white; padding: 12px 18px; border-radius: 10px; font-size: 14px;
            font-weight: 600; transition: 0.3s ease-in-out; text-decoration: none;
        }
        .button:hover { background: #e06c53; }
        .accepted-users {
            margin-top: 20px; background: #fff; padding: 20px; border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .accepted-users h3 { color: #ff7e5f; margin-bottom: 10px; }
        .user { display: flex; align-items: center; margin-bottom: 10px; font-weight: 500; }
        .footer {
            margin-top: 30px; padding: 20px; background: #333; color: white; text-align: center; border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <img src="../assets/images/logo.png" class="logo" alt="Travella Logo">
    <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="my_diary.php"><i class="fas fa-book"></i> My Travel Diary</a>
    <a href="recommendations.php"><i class="fas fa-lightbulb"></i> AI Recommendations</a>
    <a href="trip_planner.php"><i class="fas fa-map"></i> Trip Planner</a>
    <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
    <a href="../user/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>Trip Details</h1>
        <a href="dashboard.php" class="button">Back to Dashboard</a>
    </div>

    <div class="trip-details">
        <img src="../assets/images/trip_placeholder.jpg" alt="Trip Image">
        <h2><?php echo htmlspecialchars($trip['destination']); ?></h2>
        <p><strong>Start Date:</strong> <?php echo htmlspecialchars($trip['start_date']); ?></p>
        <p><strong>End Date:</strong> <?php echo htmlspecialchars($trip['end_date']); ?></p>
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($trip['trip_description'])); ?></p>
        <p><strong>Trip Type:</strong> <?php echo htmlspecialchars($trip['trip_type']); ?></p>

        <a href="edit_trip.php?trip_id=<?php echo $trip['id']; ?>" class="button">Edit Trip</a>
    </div>

    <div class="accepted-users">
        <h3>Users Who Accepted the Invite</h3>
        <?php if (!empty($accepted_users)): ?>
            <?php foreach ($accepted_users as $user): ?>
                <div class="user">
                    <i class="fas fa-user" style="margin-right:10px;"></i> <?php echo htmlspecialchars($user['username']); ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No users have accepted the invite yet.</p>
        <?php endif; ?>
    </div>

    <div class="footer">
        <p>&copy; 2025 Travella. All Rights Reserved.</p>
    </div>
</div>

</body>
</html>
