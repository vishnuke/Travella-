<?php
session_start();
include "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM diaries WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$diaries = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $diaries[] = $row;
    }
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Travel Diaries | Travella</title>
    <link rel="stylesheet" href="../assets/styles.css"> <!-- Add external CSS -->
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #fefaf2; }
        .container { width: 80%; margin: auto; padding: 20px; }
        .hero-section { display: flex; align-items: center; justify-content: space-between; background: #ffeadb; padding: 40px; border-radius: 20px; }
        .hero-text { width: 50%; }
        .hero-text h1 { font-size: 3rem; color: #333; }
        .hero-text p { font-size: 1.2rem; color: #555; }
        .btn { background: #ff7e5f; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; display: inline-block; transition: 0.3s; }
        .btn:hover { background: #d85b42; }
        .diary-section { margin-top: 40px; }
        .diary-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }
        .diary-item { background: white; padding: 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); }
        .diary-item img { width: 100%; height: auto; border-radius: 8px; }
        .diary-item h3 { font-size: 1.5rem; color: #333; }
        .diary-item p { font-size: 1rem; color: #666; }
        .diary-item .view-btn { background: #ff7e5f; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; display: inline-block; }
        .diary-item .view-btn:hover { background: #d85b42; }
        /* Styling for the back button */
        .back-btn {
            background: #d85b42;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 40px;
        }
        .back-btn:hover {
            background: #b74a33;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero-section">
            <div class="hero-text">
                <h1>Capture Your Memories</h1>
                <p>Step into the world of travel and preserve your unforgettable moments.</p>
                <a href="add_diary.php" class="btn">+ Add New Diary</a>
            </div>
            <div>
                <img src="../assets/images/girl.png" alt="Travel Image" width="300">
            </div>
        </div>
        
        <div class="diary-section">
            <h2>My Travel Diaries</h2>
            <div class="diary-container">
                <?php if (!empty($diaries)): ?>
                    <?php foreach ($diaries as $diary): ?>
                        <div class="diary-item">
                            <h3><?php echo htmlspecialchars($diary['title']); ?></h3>
                            <?php if (!empty($diary['image_path'])): ?>
                                <img src="../assets/uploads/<?php echo htmlspecialchars($diary['image_path']); ?>" alt="Diary Image">
                            <?php endif; ?>
                            <p><?php echo nl2br(htmlspecialchars($diary['content'])); ?></p>
                            <p><strong>Location:</strong> <?php echo htmlspecialchars($diary['location']); ?></p>
                            <a href="view_diary.php?id=<?php echo $diary['id']; ?>" class="view-btn">View Details</a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No diaries found. Start by adding your first travel diary!</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Back Button at the bottom -->
        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>
