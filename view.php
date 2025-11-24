<?php
$conn = mysqli_connect("localhost", "root", "", "project");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$course  = $_POST['course'] ?? '';
$name    = $_POST['name'] ?? '';
$contact = $_POST['contact'] ?? '';
$email   = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

if ($course === '' || $name === '' || $contact === '' || $email === '' || $message === '') {
    die("All fields are required.");
}

$insert = "INSERT INTO enquiry (course, name, contact, email, address)
           VALUES ('$course', '$name', '$contact', '$email', '$message')";

if (!mysqli_query($conn, $insert)) {
    die("Error inserting data: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Enquiry Submitted</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
    <div class="card" style="max-width: 480px; margin: 80px auto;">
        <h2>Thank You! ✅</h2>
        <p class="text-center mt-3">Your enquiry has been successfully submitted.</p>
        <p class="text-center mt-2"><a href="index.php">Back to Home</a></p>
    </div>
</div>

</body>
</html>
