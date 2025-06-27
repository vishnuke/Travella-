<?php
session_start();
include "config.php";
include "functions.php";

// User Registration
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = sanitizeInput($_POST["username"]);
    $email = sanitizeInput($_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $password])) {
        $_SESSION["user_id"] = $conn->lastInsertId();
        header("Location: ../pages/index.php");
        exit();
    } else {
        echo "Registration failed!";
    }
}

// User Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $email = sanitizeInput($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        header("Location: ../pages/index.php");
        exit();
    } else {
        echo "Invalid credentials!";
    }
}

// User Logout
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: ../user/login.php");
    exit();
}
?>
