<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include DB connection
include("includes/db.php");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    // Get form data
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $skills = trim($_POST["skills"]);

    // Basic validation
    if (!empty($name) && !empty($email) && !empty($password) && !empty($confirm_password)) {
        if ($password !== $confirm_password) {
            echo "❌ Passwords do not match!";
            exit();
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert into database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, skills) VALUES (?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $email, $hashed_password, $skills);

            if ($stmt->execute()) {
                echo "✅ Registration successful!";
                header("Location: login.html");
                exit();
            } else {
                echo "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Prepare failed: " . $conn->error;
        }
    } else {
        echo "⚠️ All fields are required!";
    }
}
?>
