<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM services WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Posted Services - Work Dekho</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4fa;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 1000px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.05);
    }

    h2 {
      text-align: center;
      color: #2e8bff;
      margin-bottom: 25px;
    }

    .service-card {
      border: 1px solid #ddd;
      border-left: 6px solid #2e8bff;
      padding: 15px 20px;
      margin-bottom: 15px;
      border-radius: 8px;
      background-color: #fdfdfd;
      transition: transform 0.2s;
    }

    .service-card:hover {
      transform: scale(1.01);
    }

    .service-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .service-info {
      font-size: 15px;
      margin-bottom: 6px;
      color: #333;
    }

    .price {
      font-weight: bold;
      color: #28a745;
    }

    .back-btn {
      display: inline-block;
      margin-top: 20px;
      text-align: center;
      padding: 10px 18px;
      background: #2e8bff;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      transition: background 0.3s;
    }

    .back-btn:hover {
      background: #1a6fd9;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Your Posted Services</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <?php while($row = mysqli_fetch_assoc($result)): ?>
        <div class="service-card">
          <div class="service-title"><?php echo htmlspecialchars($row['title']); ?></div>
          <div class="service-info"><?php echo nl2br(htmlspecialchars($row['description'])); ?></div>
          <div class="service-info"><strong>Category:</strong> <?php echo htmlspecialchars($row['category']); ?></div>
          <div class="service-info"><strong>Price:</strong> <span class="price">₹<?php echo number_format($row['price'], 2); ?></span></div>
          <div class="service-info"><strong>Posted On:</strong> <?php echo date("d M Y", strtotime($row['created_at'])); ?></div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="text-align: center; color: #888;">You haven't posted any services yet.</p>
    <?php endif; ?>

    <div style="text-align: center;">
      <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
    </div>
  </div>
</body>
</html>
