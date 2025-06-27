<?php
include "config.php"; // Include database connection

// Function to sanitize user input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Function to check if a user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to upload an image
function uploadImage($file, $uploadDir = "../assets/uploads/") {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($file['tmp_name']);
        if (in_array($fileType, $allowedTypes)) {
            $fileName = time() . "_" . basename($file["name"]);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($file["tmp_name"], $targetPath)) {
                return "assets/uploads/" . $fileName;
            }
        }
    }
    return false;
}
?>
