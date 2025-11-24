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
    die("No enquiry ID provided.");
}

$id = (int) $_GET['id'];

if (isset($_POST['update'])) {
    $course  = $_POST['course'] ?? '';
    $name    = $_POST['name'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $email   = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    $sql = "UPDATE enquiry 
            SET course='$course',
                name='$name',
                contact='$contact',
                email='$email',
                address='$message'
            WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header('Location: admin_panel.php');
        exit;
    } else {
        $msg = "Error updating record: " . mysqli_error($conn);
    }
}

$fetch = "SELECT * FROM enquiry WHERE id=$id";
$data  = mysqli_query($conn, $fetch);

if (!$data || mysqli_num_rows($data) == 0) {
    die("No record found for this ID.");
}

$row = mysqli_fetch_assoc($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Enquiry</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">

    <div class="topbar">
        <div class="logo-text">Edit Enquiry #<?php echo $row['id']; ?></div>
        <a href="admin_panel.php" class="admin-link">Back to Admin Panel</a>
    </div>

    <div class="card" style="max-width: 650px; margin: 0 auto;">
        <h2>Edit Enquiry</h2>

        <?php if (!empty($msg)): ?>
            <p class="text-center" style="color:#ef4444; margin-bottom:10px;"><?php echo $msg; ?></p>
        <?php endif; ?>

        <form method="POST">
            <select name="course" class="inputp" required>
                <option value="">-- Select Course --</option>
                <option value="Digital Marketing" <?php if($row['course']=='Digital Marketing') echo 'selected'; ?>>Digital Marketing</option>
                <option value="Web Designing" <?php if($row['course']=='Web Designing') echo 'selected'; ?>>Web Designing</option>
                <option value="Web Development" <?php if($row['course']=='Web Development') echo 'selected'; ?>>Web Development</option>
            </select>

            <input type="text" name="name" class="inputp" value="<?php echo $row['name']; ?>" required>

            <input type="text" name="contact" class="inputp" value="<?php echo $row['contact']; ?>" required>

            <input type="email" name="email" class="inputp" value="<?php echo $row['email']; ?>" required>

            <textarea name="message" rows="4" class="inputp" required><?php echo $row['address']; ?></textarea>

            <button type="submit" name="update" class="btn">Update</button>
        </form>
    </div>

</div>

</body>
</html>
