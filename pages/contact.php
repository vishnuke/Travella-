<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Travella</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color:#71C9CE;
            color: #333;
        }

        /* Main Section Layout */
        .contact-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 60px 10%;
            min-height: 100vh;
            background-color:#71C9CE;
        }

        /* Left Illustration Panel */
        .left-panel {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .left-panel img {
            width: 100%;
            max-width: 500px;
            height: auto;
        }

        /* Right Text Panel */
        .right-panel {
            flex: 1;
            padding-left: 50px;
        }

        .right-panel h1 {
            font-size: 3rem;
            color: #0e1e64;
            margin-bottom: 20px;
        }

        .right-panel p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .right-panel .learn-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 10px 20px;
            border: 2px solid #b74a33;
            color: #d85b42;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .right-panel .learn-btn:hover {
            background-color: #b74a39;
            color: white;
        }

        /* Contact Information */
        .contact-info {
            font-weight: 600;
            margin-top: 20px;
        }

        .contact-info p {
            margin: 5px 0;
        }

        .contact-info a {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background: linear-gradient(to right,#b74a33,rgba(157, 86, 24, 0.88));
            color: white;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 6px 15px #b74a33(0, 0, 0, 0.15);
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .contact-info a:hover {
            background: linear-gradient(to right,rgb(141, 67, 52),rgb(128, 42, 25));
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-section {
                flex-direction: column;
                text-align: center;
                padding: 40px 20px;
            }

            .right-panel {
                padding-left: 0;
                margin-top: 30px;
            }

            .right-panel h1 {
                font-size: 2rem;
            }

            .right-panel p {
                font-size: 1.1rem;
            }

            .contact-info a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <section class="contact-section">
        <div class="left-panel">
            <img src="../assets/images/contact.png" alt="Contact illustration">
        </div>
        <div class="right-panel">
            <h1>Contact Us</h1>
            <p>Planning your next adventure? We’re here to help you every step of the way.</p>
            <p>Whether you have questions about destinations, bookings, or custom travel packages — our team is just a message away.</p>
            <p>Let’s make your dream journey happen.</p>

            <div class="contact-info">
                <p>📞 <strong>+1 (234) 567-8901</strong></p>
                <p>📧 <strong>support@travella.com</strong></p>
                <a href="../index.php" class="back-btn">← Back to Home</a>
            </div>
        </div>
    </section>

</body>
</html>
