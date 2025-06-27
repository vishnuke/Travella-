<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Travella</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(to right, #71C9CE, #A6E3E9);
      color: #333;
      line-height: 1.6;
    }

    .container {
      width: 90%;
      max-width: 1200px;
      margin: auto;
      padding: 40px 20px;
    }

    /* HERO SECTION */
    .hero-section {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      background: rgba(255, 234, 219, 0.85);
      padding: 50px;
      border-radius: 30px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
      backdrop-filter: blur(10px);
      margin-bottom: 60px;
      transition: transform 0.3s ease;
    }

    .hero-section:hover {
      transform: scale(1.01);
    }

    .hero-text {
      max-width: 600px;
      margin-bottom: 20px;
    }

    .hero-text h1 {
      font-size: 3rem;
      color: #2f2f2f;
      animation: slideInLeft 0.8s ease-in-out;
    }

    .hero-text p {
      font-size: 1.25rem;
      color: #444;
      margin: 20px 0;
    }

    .btn {
      background: linear-gradient(to right, #ff7e5f, #feb47b);
      color: white;
      padding: 12px 25px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: background 0.3s ease, transform 0.2s ease;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn:hover {
      background: linear-gradient(to right, #d85b42, #f4785d);
      transform: translateY(-3px);
    }

    .hero-section img {
      max-width: 100%;
      height: auto;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    /* FEATURES SECTION */
    .features {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
    }

    .feature-box {
      background: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .feature-box:hover {
      transform: translateY(-10px);
    }

    .feature-box h3 {
      font-size: 1.75rem;
      color: #ff7e5f;
      margin-bottom: 15px;
    }

    .feature-box p {
      font-size: 1.05rem;
      color: #555;
    }

    /* BACK BUTTON */
    .back-btn {
      background: #d85b42;
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      display: inline-block;
      margin-top: 60px;
      font-weight: bold;
      transition: background 0.3s ease, transform 0.2s ease;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .back-btn:hover {
      background: #b74a33;
      transform: scale(1.05);
    }

    /* Animations */
    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-50px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    @media (max-width: 768px) {
      .hero-section {
        flex-direction: column;
        text-align: center;
      }

      .hero-text {
        margin-bottom: 30px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- HERO SECTION -->
    <div class="hero-section">
      <div class="hero-text">
        <h1>About Travella</h1>
        <p>Your AI-powered travel diary to document journeys, share experiences, and get travel recommendations.</p>
        <a href="register.php" class="btn">Join Travella Today</a>
      </div>
      <div>
        <img src="../assets/images/about.png" alt="Travel Image" width="320" />
      </div>
    </div>

    <!-- FEATURES SECTION -->
    <div class="features">
      <div class="feature-box">
        <h3>AI Recommendations</h3>
        <p>Get personalized travel suggestions based on your preferences.</p>
      </div>
      <div class="feature-box">
        <h3>Interactive Travel Diary</h3>
        <p>Record your journeys, upload photos, and track your travels.</p>
      </div>
      <div class="feature-box">
        <h3>Community Engagement</h3>
        <p>Connect with travelers, share tips, and explore new places together.</p>
      </div>
    </div>

    <!-- BACK BUTTON -->
    <a href="../index.php" class="back-btn">← Back to Home</a>
  </div>
</body>
</html>
