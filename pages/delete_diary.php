<?php
session_start();
include "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['diary_id'])) {
    $diary_id = intval($_POST['diary_id']);
    $user_id = $_SESSION['user_id'];

    // Check if diary exists and belongs to user
    $check_sql = "SELECT image_path FROM diaries WHERE id = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $diary_id, $user_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows === 1) {
        $diary = $check_result->fetch_assoc();

        // Delete image file if exists
        if (!empty($diary['image_path']) && file_exists("../assets/uploads/" . $diary['image_path'])) {
            unlink("../assets/uploads/" . $diary['image_path']);
        }

        // Delete diary entry
        $delete_sql = "DELETE FROM diaries WHERE id = ? AND user_id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("ii", $diary_id, $user_id);
        $delete_stmt->execute();

        $delete_stmt->close();
    }
    $check_stmt->close();
}

header("Location: view_diary.php");
exit();
