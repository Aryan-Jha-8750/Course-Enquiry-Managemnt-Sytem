<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    die("Access denied. Admin only.");
}

$conn = mysqli_connect("localhost", "root", "", "project");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("No ID provided.");
}

$id = (int) $_GET['id'];

$sql = "DELETE FROM enquiry WHERE id=$id";

if (mysqli_query($conn, $sql)) {
    header('Location: admin_panel.php');
    exit;
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
