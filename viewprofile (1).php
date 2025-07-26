<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Profile - Work Dekho</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background-color: #f2f4f8;
    }

    .container {
      max-width: 500px;
      background: white;
      margin: 60px auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.05);
    }

    h2 {
      text-align: center;
      color: #2e8bff;
      margin-bottom: 20px;
    }

    .profile-info {
      font-size: 16px;
      color: #333;
    }

    .profile-info p {
      margin-bottom: 15px;
    }

    .label {
      font-weight: 600;
      color: #666;
    }

    .edit-link,
    .back-link {
      display: inline-block;
      margin-top: 20px;
      text-decoration: none;
      background-color: #2e8bff;
      color: white;
      padding: 10px 16px;
      border-radius: 6px;
      font-weight: 500;
      transition: background 0.3s ease;
    }

    .edit-link:hover,
    .back-link:hover {
      background-color: #1c6ed1;
    }

    .link-wrapper {
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Your Profile</h2>

    <div class="profile-info">
      <p><span class="label">Name:</span> <?php echo htmlspecialchars($user['name']); ?></p>
      <p><span class="label">Email:</span> <?php echo htmlspecialchars($user['email']); ?></p>
      <p><span class="label">Skills:</span> <?php echo htmlspecialchars($user['skills']); ?></p>
    </div>

    <div class="link-wrapper">
      <a href="editprofile.php" class="edit-link">Edit Profile</a>
      <a href="dashboard.php" class="back-link" style="margin-left: 10px;">Back to Dashboard</a>
    </div>
  </div>
</body>
</html>
