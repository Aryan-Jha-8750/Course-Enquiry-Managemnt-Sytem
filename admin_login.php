<?php
session_start();

$err = '';

if (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    header('Location: admin_panel.php');
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin'] = true;
        header('Location: admin_panel.php');
        exit;
    } else {
        $err = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="card auth-card">
        <h2>Admin Login</h2>
        <?php if ($err): ?>
            <p class="text-center" style="color: #ef4444; margin-bottom: 10px;"><?php echo $err; ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" class="inputp" placeholder="Username" required>
            <input type="password" name="password" class="inputp" placeholder="Password" required>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
    </div>
</div>

</body>
</html>
