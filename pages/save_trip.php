<?php
session_start();
include "../includes/config.php";

$user_id = $_SESSION['user_id'];
$destination = $_POST['destination'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$description = $_POST['description'];  // Ensure this is properly sanitized or validated
$trip_type = $_POST['trip_type'];
$selected_friends = json_decode($_POST['selected_friends'], true);

// Insert trip
$query = "INSERT INTO trips (user_id, destination, start_date, end_date, trip_description, trip_type) 
          VALUES ('$user_id', '$destination', '$start_date', '$end_date', '$description', '$trip_type')";
mysqli_query($conn, $query);

$trip_id = mysqli_insert_id($conn);

// Insert invited friends
foreach ($selected_friends as $friend) {
    $friend_id = $friend['id'];
    mysqli_query($conn, "INSERT INTO trip_invites (trip_id, user_id) VALUES ('$trip_id', '$friend_id')");
}

header("Location: trip_success.php");
?>
