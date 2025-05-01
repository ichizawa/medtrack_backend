<?php
require_once './Auth/auth_check.php';
ob_start();
?>
<link rel="stylesheet" href="assets/css/profile.css">

<div class="container-fluid p-0">
    <!-- Profile Header -->
    <div class="card header-card mb-4">
        <div class="card-body d-flex align-items-center">
            <div class="profile-avatar me-4">
                <img src="assets/img/photo.png" alt="Profile Avatar" class="rounded-circle" width="100" height="100">
            </div>
            <div>
                <h1 class="page-title mb-1">Lowela Relacion</h1>
                <p class="page-subtitle">Administrator</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Personal Information -->
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Personal Information</h5>
                    <form class="profile-form" id="personalInfoForm">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?= htmlspecialchars($profile['first_name'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" value="<?= htmlspecialchars($profile['last_name'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($profile['email'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($profile['phone'] ?? '') ?>">
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Change Password</h5>
                    <form class="profile-form" id="passwordForm">
                        <div class="form-group mb-3">
                            <label for="currentPassword">Current Password</label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword">
                                </div>
                            </div>
                        </div>
                        <div class="password-requirements p-3 mb-3">
                            <h6 class="mb-2">Password Requirements:</h6>
                            <ul class="mb-0">
                                <li>Minimum 8 characters</li>
                                <li>At least one uppercase letter</li>
                                <li>At least one number</li>
                                <li>At least one special character</li>
                            </ul>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    const userId = 1; // Replace this with dynamic ID based on login

    fetch(`/api/profile/${userId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                const profile = data.data;
                document.getElementById('firstName').value = profile.first_name;
                document.getElementById('lastName').value = profile.last_name;
                document.getElementById('email').value = profile.email;
                document.getElementById('phone').value = profile.phone;

                document.querySelector('.page-title').textContent = `${profile.first_name} ${profile.last_name}`;
                // Remove subtitle if 'role' is not available
                // document.querySelector('.page-subtitle').textContent = profile.role;
            } else {
                alert('Profile not found');
            }
        })

        .catch(error => {
            console.error('Fetch error:', error);
            alert('There was an error fetching the profile.');
        });
</script>


<?php
$pageContent = ob_get_clean();
include './Navigations/navbar.php';
?>