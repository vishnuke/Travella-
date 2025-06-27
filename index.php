<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travella - Explore the World</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #A6E3E9, #71C9CE);
            color: #333;
            text-align: center;
        }

        /* Navbar */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 40px;
        }
        .nav-links a {
            text-decoration: none;
            font-weight: bold;
            color: black;
            margin: 0 15px;
            font-size: 1rem;
            transition: 0.3s;
        }
        .nav-links a:hover {
            color: #ff5e5e;
        }

        .btn {
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            border: none;
            border-radius: 25px;
            background: #ff5e5e;
            color: white;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #e04c4c;
        }

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 80vh;
            padding: 20px;
            position: relative;
        }
        .hero-content {
            text-align: left;
            max-width: 50%;
        }
        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }
        .hero-image img {
            width: 400px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="logo"><img src="assets/images/logo.png" alt="Travella Logo" width="50"></div>
    <div class="nav-links">
        <a href="pages/about.php">About</a>
        <a href="pages/gallery.php">Gallery</a>
        <a href="pages/contact.php">Contact</a>
    </div>
    <a href="user/register.php" class="btn">Join Now</a>
</div>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Explore The World with Travella</h1>
        <p>Discover, document, and explore unique places with AI-powered recommendations.</p>
        <p></p>
        <a href="pages/dashboard.php" class="btn">Start Exploring</a>
    </div>
    <div class="hero-image">
        <img src="assets/images/travel-image2.png" alt="Travel Illustration">
    </div>
</section>

</body>
</html>
