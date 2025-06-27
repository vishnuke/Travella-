<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travella</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header>
    <h1>Travella</h1>
    <nav>
        <a href="../pages/index.php">Home</a>
        <a href="../pages/explore.php">Explore</a>
        <a href="../pages/diary.php">My Diary</a>
        <a href="../pages/recommendations.php">Recommendations</a>
        <a href="../pages/chatbot.php">Chatbot</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="../user/logout.php">Logout</a>
        <?php else: ?>
            <a href="../user/login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
