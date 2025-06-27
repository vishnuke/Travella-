<?php
session_start();
include "../includes/config.php";

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../user/login.php");
    exit();
}

// Fetch unique categories for the filter dropdown
try {
    $categoryStmt = $conn->prepare("SELECT DISTINCT category FROM destinations");
    $categoryStmt->execute();
    $categories = $categoryStmt->get_result()->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $e) {
    die("Database error: " . $e->getMessage());
}

// Fetch destinations based on filters
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
$ratingFilter = isset($_GET['rating']) ? $_GET['rating'] : '';
$trendingFilter = isset($_GET['trending']) ? $_GET['trending'] : '';

$query = "SELECT id, name, latitude, longitude, description, category, rating, is_trending FROM destinations WHERE 1=1";
$params = [];

if ($categoryFilter) {
    $query .= " AND category = ?";
    $params[] = $categoryFilter;
}
if ($ratingFilter) {
    $query .= " AND rating >= ?";
    $params[] = $ratingFilter;
}
if ($trendingFilter === "yes") {
    $query .= " AND is_trending = 1";
}

// Prepare and execute the query
$stmt = $conn->prepare($query);
if (!empty($params)) {
    $types = str_repeat('s', count($params)); // Assume all parameters are strings (adjust if necessary)
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();

// Fetch results
$result = $stmt->get_result();
$destinations = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Destinations | Travella</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: linear-gradient(to right, #87CEEB, #FF7F50); color: #333; }
        .main-content { padding: 20px; }
        .header { background: white; padding: 15px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); border-radius: 10px; }
        .header h1 { font-size: 1.8rem; }
        .logout { text-decoration: none; color: white; padding: 10px 20px; background: #e74c3c; border-radius: 5px; transition: 0.3s; }
        .logout:hover { background: #c0392b; }
        #map { height: 500px; width: 100%; border-radius: 10px; margin-top: 20px; }
        .filter-container { margin-top: 20px; display: flex; gap: 10px; align-items: center; }
        .filter-container select, .filter-container button { padding: 10px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; }
        .filter-container select { background: white; }
        .filter-container button { background: #2d9cdb; color: white; }
        .filter-container button:hover { background: #1b6faa; }
        .destination-table { width: 100%; margin-top: 20px; border-collapse: collapse; }
        .destination-table th, .destination-table td { padding: 12px; text-align: left; border: 1px solid #ddd; }
        .destination-table th { background: #2d9cdb; color: white; }
        .destination-table tr:nth-child(even) { background: #f8f9fa; }
        .destination-table tr:hover { background: #f1f1f1; }
        .footer { margin-top: 30px; padding: 20px; background: #333; color: white; text-align: center; border-radius: 10px; }
    </style>
</head>
<body>

<div class="main-content">
    <div class="header">
        <h1>Explore Destinations</h1>
        <a href="../pages/dashboard.php" class="logout">Back</a>
    </div>

    <div class="filter-container">
        <form method="GET">
            <select name="category">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['category'] ?>" <?= ($category['category'] == $categoryFilter) ? 'selected' : '' ?>><?= ucfirst($category['category']) ?></option>
                <?php endforeach; ?>
            </select>

            <select name="rating">
                <option value="">Minimum Rating</option>
                <option value="3" <?= ($ratingFilter == "3") ? 'selected' : '' ?>>3+</option>
                <option value="4" <?= ($ratingFilter == "4") ? 'selected' : '' ?>>4+</option>
                <option value="5" <?= ($ratingFilter == "5") ? 'selected' : '' ?>>5</option>
            </select>

            <select name="trending">
                <option value="">All Destinations</option>
                <option value="yes" <?= ($trendingFilter == "yes") ? 'selected' : '' ?>>Trending</option>
            </select>

            <button type="submit">Apply Filters</button>
        </form>
    </div>

    <div id="map"></div>

    <table class="destination-table">
        <tr><th>ID</th><th>Name</th><th>Latitude</th><th>Longitude</th><th>Description</th><th>Category</th><th>Rating</th></tr>
        <?php foreach ($destinations as $destination): ?>
            <tr>
                <td><?= $destination['id'] ?></td>
                <td><?= $destination['name'] ?></td>
                <td><?= $destination['latitude'] ?></td>
                <td><?= $destination['longitude'] ?></td>
                <td><?= $destination['description'] ?></td>
                <td><?= ucfirst($destination['category']) ?></td>
                <td><?= $destination['rating'] ?>/5</td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<!-- Leaflet.js & Map Script -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Ensure the map container exists
    var mapContainer = document.getElementById("map");
    if (!mapContainer) {
        console.error("Error: Map container not found!");
        return;
    }

    // Initialize Leaflet map centered on India
    var map = L.map("map").setView([20.5937, 78.9629], 5);

    // Load OpenStreetMap tiles
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap contributors",
    }).addTo(map);

    // Fetch destinations dynamically from PHP
    var destinations = <?php echo json_encode($destinations); ?>;

    // Check if destinations exist
    if (!destinations || destinations.length === 0) {
        console.warn("Warning: No destinations found in the database.");
        return;
    }

    // Loop through destinations and add markers
    destinations.forEach(function (dest) {
        if (dest.latitude && dest.longitude) { // Ensure coordinates exist
            var lat = parseFloat(dest.latitude);
            var lng = parseFloat(dest.longitude);

            if (!isNaN(lat) && !isNaN(lng)) { // Check for valid numbers
                L.marker([lat, lng])
                    .addTo(map)
                    .bindPopup(`<b>${dest.name}</b><br>${dest.description}`);
            } else {
                console.error(`Invalid coordinates for: ${dest.name}`);
            }
        } else {
            console.error(`Missing latitude/longitude for: ${dest.name}`);
        }
    });
});
</script>
</body>
</html>
