<?php
session_start();
include "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid diary ID.";
    exit();
}

$diary_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM diaries WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $diary_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Diary not found.";
    exit();
}

$diary = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($diary['title']); ?> | Travella</title>
    <link rel="stylesheet" href="../assets/styles.css"> <!-- External CSS (if needed) -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #fceabb, #f8b500);
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 60px auto;
            background: #fffefb;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            animation: fadeIn 0.6s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 10px;
        }
        .meta {
            color: #777;
            font-size: 1rem;
            margin-bottom: 30px;
        }
        .image-container img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 25px;
        }
        .content {
            font-size: 1.15rem;
            line-height: 1.8;
            color: #444;
            white-space: pre-line;
        }
        .back-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background: #ff7e5f;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s;
        }
        .back-btn:hover {
            background: #d85b42;
        }
        .delete-btn {
    background: #ff4d4f;
    color: white;
    border: none;
    padding: 12px 20px;
    margin-left: 10px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.3s;
}
.delete-btn:hover {
    background: #c0392b;
}

    </style>
</head>
<body>
    <div class="container">
        <h1 class="title"><?php echo htmlspecialchars($diary['title']); ?></h1>
        <div class="meta">
            📍 <?php echo htmlspecialchars($diary['location']); ?> | 📅 <?php echo date("F j, Y", strtotime($diary['created_at'])); ?>
        </div>
        <div class="image-container">
            <?php if (!empty($diary['image_path'])): ?>
                <img src="../assets/uploads/<?php echo htmlspecialchars($diary['image_path']); ?>" alt="Diary Image">
            <?php endif; ?>
        </div>
        <div class="content">
            <?php echo htmlspecialchars($diary['content']); ?>
        </div>
        <a href="my_diary.php" class="back-btn">← Back to Diaries</a>
        <!-- Below the Back Button -->
<form action="delete_diary.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this diary?');" style="display:inline;">
    <input type="hidden" name="diary_id" value="<?php echo $diary['id']; ?>">
    <button type="submit" class="delete-btn">🗑 Delete Diary</button>
</form>
<a href="my_diary.php" class="back-btn">← Back to Diaries</a>

    </div>
</body>
</html>
