<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_id = $_SESSION['user_id'];
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $description = mysqli_real_escape_string($conn, $_POST['description']);
  $category = mysqli_real_escape_string($conn, $_POST['category']);
  $price = (float) $_POST['price'];

  $sql = "INSERT INTO services (user_id, title, description, category, price) 
          VALUES ('$user_id', '$title', '$description', '$category', '$price')";

  if (mysqli_query($conn, $sql)) {
    echo "<script>alert('Service posted successfully!'); window.location.href='dashboard.php';</script>";
  } else {
    echo "<script>alert('Error posting service. Try again.'); window.history.back();</script>";
  }
} else {
  header("Location: postservice.html");
  exit();
}
?>
