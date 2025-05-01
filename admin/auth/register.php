<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // For demo purposes, just redirect to login page
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - MedTrack</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/register.css">
</head>
<body>
    <div class="register-container">
        <!-- Left side - Illustration -->
        <div class="register-illustration">
            <img src="../assets/img/logo_login.png" alt="Register" class="illustration-image">
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <!-- Right side - Register Form -->
        <div class="register-form-container">
            <h1 class="register-title">Create Account</h1>

            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter first name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter last name" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">
                        I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">Create Account</button>

                <div class="signup-link">
                    Already have an account? <a href="../Auth/login.php">Sign in</a>
                </div>
            </form>
            <!-- Social Login Buttons -->
            <div class="social-login text-center mt-4">
                <p>Or sign up with</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="#" class="btn btn-outline-danger">
                        <i class="fab fa-google me-2"></i> Google
                    </a>
                    <a href="#" class="btn btn-outline-primary">
                        <i class="fab fa-facebook-f me-2"></i> Facebook
                    </a>
                    <a href="#" class="btn btn-outline-info">
                        <i class="fab fa-linkedin-in me-2"></i> LinkedIn
                    </a>
                </div>
            </div>

        </div>
    </div>
</body>
</html> 