<?php
session_start();
include "../includes/config.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $content = $_POST['description'] ?? ''; // Renamed from 'description' to 'content'
    $location = $_POST['location'] ?? '';
    $user_id = $_SESSION['user_id'];

    // Image upload handling
    $image_path = "";
    if (!empty($_FILES["image"]["name"])) {
        $target_dir = "../assets/uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $allowed_types = ["jpg", "jpeg", "png", "gif"];

        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $image_name; // Store only the filename, not full path
            } else {
                echo "<script>alert('Error uploading image.');</script>";
            }
        } else {
            echo "<script>alert('Invalid image format. Only JPG, JPEG, PNG & GIF allowed.');</script>";
        }
    }

    // Fix SQL query (use MySQLi with `?` placeholders)
    $sql = "INSERT INTO diaries (user_id, title, content, location, image_path) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issss", $user_id, $title, $content, $location, $image_path);
        if ($stmt->execute()) {
            echo "<script>alert('Diary added successfully!'); window.location.href='my_diary.php';</script>";
        } else {
            echo "<script>alert('Error adding diary.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('SQL preparation error: " . $conn->error . "');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Travel Diary | Travella</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .main-content {
            padding: 20px;
        }
        .header {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            padding: 15px;
            text-align: center;
            color: white;
            font-size: 1.5rem;
            border-radius: 8px;
        }
        .form-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            max-width: 650px;
            margin: 20px auto;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        .btn {
            background: #ff7e5f;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
            transition: background 0.3s ease-in-out;
        }
        .btn:hover {
            background: #d85b42;
        }
        #map-container {
            margin: 15px 0;
            padding: 10px;
            background: #eaeaea;
            border-radius: 10px;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        #map {
            height: 300px;
            border-radius: 8px;
        }
        .location-status {
            text-align: center;
            font-size: 1rem;
            font-weight: bold;
            color: #333;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="header">Add New Travel Diary</div>

    <div class="form-container">
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Diary Title</label>
            <input type="text" id="title" name="title" required>

            <label for="date">Date</label>
            <input type="text" id="date" name="date" required>

            <label for="location">Location</label>
            <input type="text" id="location" name="location" required readonly>
            <div id="map-container">
                <div id="map"></div>
                <p class="location-status" id="location-status">Click on the map to select a location.</p>
            </div>

            <label for="image">Upload Image</label>
            <input type="file" name="image" accept="image/*">

            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>

            <button type="submit" class="btn">Save Diary</button>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Initialize Flatpickr
        flatpickr("#date", { 
            dateFormat: "Y-m-d"
        });

        // Initialize Leaflet Map
        var map = L.map('map').setView([20.5937, 78.9629], 5); // Default to India

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        function updateLocation(lat, lon) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    var placeName = data.display_name || `${lat}, ${lon}`;
                    document.getElementById("location").value = placeName;
                    document.getElementById("location-status").innerText = `Selected: ${placeName}`;
                })
                .catch(error => console.error("Error fetching location:", error));
        }

        map.on("click", function (e) {
            var lat = e.latlng.lat;
            var lon = e.latlng.lng;

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lon]).addTo(map);
            updateLocation(lat, lon);
        });
    });
</script>

</body>
</html>
