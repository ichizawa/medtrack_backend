<?php

use Controllers\Users;
include __DIR__ . '/../../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new Users($conn);
    $result = $user->login($email, $password);

    if ($result) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = 'admin';
        $_SESSION['user_id'] = $result->id;
        header("Location: ../dashboard.php");
        exit();
    } else {
        $error_message = "Invalid email or password!";
    }
    // Static authentication (for demo purposes)
    // if ($email === "admin@medtrack.com" && $password === "admin123") {
    //     $_SESSION['user_logged_in'] = true;
    //     $_SESSION['user_email'] = $email;
    //     $_SESSION['user_role'] = 'admin';
    //     header("Location: ../dashboard.php");
    //     exit();
    // } else {
    //     $error_message = "Invalid email or password!";
    // }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - MedTrack</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <!-- Left side - Illustration -->
        <div class="login-illustration">
        <img src="../assets/img/logo_login.png" alt="Login" class="illustration-image">                                                                                                                    
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <!-- Right side - Login Form -->
        <div class="login-form-container">
            
            <h1 class="login-title">Sign in</h1>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="remember-forgot">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary">Sign in</button>

                <div class="signup-link">
                    No account? <a href="../Auth/register.php">Sign up</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 