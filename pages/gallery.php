<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <style>
        /* Global Styles */
        body {
            background-color: #71C9CE;
            color: white;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        /* Container */
        .container {
            max-width: 1100px;
            margin: auto;
            padding: 40px 20px;
        }

        /* Title */
        h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.2rem;
            opacity: 0.7;
        }

        /* Gallery Grid */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        /* Gallery Card */
        .gallery-card {
            background: linear-gradient(145deg,rgba(255, 255, 255, 0.52),rgba(250, 157, 95, 0.59));
            border-radius: 15px;
            padding: 15px;
            box-shadow: 5px 5px 15pxrgb(232, 169, 43), -5px -5px 15px #1e2230;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .gallery-card:hover {
            transform: scale(1.05);
        }

        /* Image */
        .gallery-card img {
            width: 100%;
            border-radius: 12px;
            display: block;
        }

        /* Gallery Info */
        .gallery-info {
            margin-top: 15px;
        }

        .gallery-info h3 {
            font-size: 1.3rem;
            color: #00aaff;
        }

        .gallery-info p {
            font-size: 1rem;
            opacity: 0.8;
        }

        /* Back Button */
        .back-button {
            margin-top: 40px;
        }

        .back-btn {
            background-color: #d85b42;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background-color: #b74a33;
        }
    </style>
</head>
<body>

    <!-- GALLERY PAGE -->
    <section class="gallery">
        <div class="container">
            <h1>Gallery</h1>
            <p>Explore breathtaking travel moments captured by our community.</p>
            
            <div class="gallery-grid">
                <?php
                // Define an array of image paths and captions
                $gallery_images = [
                    ["path" => "../assets/images/gallery1.jpg", "title" => "Serene Mountains", "desc" => "A peaceful morning in the Alps.", "color" => "#b74a33"],
                    ["path" => "../assets/images/gallery2.jpg", "title" => "Sunset Over the Beach", "desc" => "Golden hour at the ocean.", "color" => "#b74a33"],
                    ["path" => "../assets/images/gallery3.jpg", "title" => "Urban City Lights", "desc" => "The city never sleeps.", "color" => "#b74a33"]
                ];
                
                // Loop through images and display them dynamically
                foreach ($gallery_images as $image) {
                    echo '
                    <div class="gallery-card">
                        <img src="' . $image["path"] . '" alt="' . $image["title"] . '">
                        <div class="gallery-info">
                            <h3>' . $image["title"] . '</h3>
                            <p>' . $image["desc"] . '</p>
                        </div>
                    </div>';
                }
                ?>
            </div>

            <!-- BACK BUTTON -->
            <div class="back-button">
                <a href="../index.php" class="back-btn">Back to Home</a>
            </div>
        </div>
    </section>

</body>
</html>
