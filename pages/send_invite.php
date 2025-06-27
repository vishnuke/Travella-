<?php
session_start();
include "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

if (isset($_POST['friend_id'])) {
    $user_id = $_SESSION['user_id'];
    $friend_id = $_POST['friend_id'];

    // Save invite into a database table
    $query = "INSERT INTO trip_invites (user_id, friend_id, status) VALUES ('$user_id', '$friend_id', 'pending')";
    if (mysqli_query($conn, $query)) {
        echo "Invitation sent!";
    } else {
        echo "Failed to send invite!";
    }
}
?>
