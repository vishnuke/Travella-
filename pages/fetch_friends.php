<?php
session_start();
include "../includes/config.php";

$user_id = $_SESSION['user_id']; 

$query = "SELECT id, username FROM users WHERE id != '$user_id'"; 
$result = mysqli_query($conn, $query);

$friends = [];
while ($row = mysqli_fetch_assoc($result)) {
    $friends[] = $row;
}

echo json_encode($friends);
?>
