<?php
session_start();
include "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

if (isset($_POST['invite_id']) && isset($_POST['action'])) {
    $invite_id = $_POST['invite_id'];
    $action = $_POST['action'] == 'accept' ? 'accepted' : 'rejected';

    $query = "UPDATE trip_invites SET status='$action' WHERE id='$invite_id'";
    if (mysqli_query($conn, $query)) {
        echo "Invite $action!";
    } else {
        echo "Error processing invite!";
    }
}
?>
