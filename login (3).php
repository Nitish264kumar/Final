<?php
session_start();
include("includes/db.php");

// Check if login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Input validation
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in all fields.'); window.location.href='login.html';</script>";
        exit();
    }

    // Prepare and execute SQL query
    $stmt = $conn->prepare("SELECT id, name, email, password, skills FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $email_db, $hashed_password, $skills);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email_db;
            $_SESSION['user_skills'] = $skills;

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid email or password.'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('User not found. Please register.'); window.location.href='register.html';</script>";
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login.html");
    exit();
}
?>
