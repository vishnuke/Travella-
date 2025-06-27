<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AI Recommendations - Travella</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            margin: 0;
            padding: 0;
        }

        .main-content {
            margin: 0 auto;
            padding: 40px 20px;
            max-width: 1000px;
        }

        .ai-recommendations {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .ai-recommendations h2 {
            text-align: center;
            color: #1e88e5;
            margin-bottom: 25px;
        }

        .recommendation {
            background: #f7f9fc;
            padding: 15px 20px;
            border-left: 5px solid #1e88e5;
            margin-bottom: 15px;
            border-radius: 10px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="ai-recommendations">
        <h2><i class="fas fa-lightbulb"></i> AI Travel Recommendations</h2>

        <form method="post">
            <label for="city">Enter a City Name:</label>
            <input type="text" name="city" id="city" required>
            <button type="submit">Get Recommendations</button>
        </form>

        <br>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $city = $_POST['city'];
            $api_url = "http://127.0.0.1:5000/get_recommendations"; // Replace with live URL if deployed

            $postData = json_encode(['user_input' => $city]);

            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);

            if (isset($result['recommendations'])) {
                foreach ($result['recommendations'] as $rec) {
                    echo "<div class='recommendation'>📍 $rec</div>";
                }
            } else {
                echo "<div class='recommendation'>❌ No recommendations found: " . $result['error'] . "</div>";
            }
        }
        ?>
    </div>
</div>

</body>
</html>
