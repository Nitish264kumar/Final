<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch current user info
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Update profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $skills = mysqli_real_escape_string($conn, $_POST['skills']);

    $update = "UPDATE users SET name='$name', email='$email', skills='$skills' WHERE id=$user_id";
    if (mysqli_query($conn, $update)) {
        $_SESSION['name'] = $name; // Update session name
        header("Location: viewprofile.php?updated=1");
        exit();
    } else {
        $error = "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Profile - Work Dekho</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      background: #f1f3f6;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 500px;
      margin: 60px auto;
      background: white;
      padding: 30px 40px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
      border-radius: 12px;
    }

    h2 {
      text-align: center;
      color: #2e8bff;
      margin-bottom: 25px;
    }

    label {
      font-weight: 500;
      display: block;
      margin-bottom: 6px;
      color: #444;
    }

    input[type="text"],
    input[type="email"],
    textarea {
      width: 100%;
      padding: 10px 12px;
      margin-bottom: 18px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }

    textarea {
      resize: vertical;
      min-height: 80px;
    }

    button {
      background-color: #2e8bff;
      color: white;
      padding: 12px;
      border: none;
      width: 100%;
      border-radius: 6px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #216be0;
    }

    .error {
      color: red;
      text-align: center;
      margin-bottom: 15px;
    }

    .back-link {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #2e8bff;
      text-decoration: none;
      font-size: 15px;
    }

    .back-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Edit Your Profile</h2>

    <?php if (isset($error)): ?>
      <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

      <label for="skills">Skills (comma separated)</label>
      <textarea id="skills" name="skills"><?php echo htmlspecialchars($user['skills']); ?></textarea>

      <button type="submit">Update Profile</button>
    </form>

    <a class="back-link" href="dashboard.php">← Back to Dashboard</a>
  </div>
</body>
</html>
