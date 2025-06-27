<?php
include '../includes/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $user_id); // s = string, s = string, i = integer
    $stmt->execute();

    $_SESSION['username'] = $name;
    echo "Profile updated successfully!";
    exit;
}

// GET user details
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']); // i = integer
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #ff5e5e;
            color: white;
            cursor: pointer;
            border: none;
        }
        button:hover {
            background: #e04e4e;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Profile Settings</h2>
    <form id="settingsForm">
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        <button type="submit">Update</button>
    </form>
</div>

</body>
</html>
