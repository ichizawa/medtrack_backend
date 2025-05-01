<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <!-- Toggle Button for Sidebar -->
        <button type="button" id="sidebarCollapse" class="btn btn-link d-lg-none">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Search Bar -->
        <form class="search-form">
            <div class="position-relative">
                <i class="fas fa-search"></i>
                <input class="form-control" type="search" placeholder="Search here..." aria-label="Search">
            </div>
        </form>

        <!-- Right Side -->
        <div class="d-flex align-items-center ms-auto">
            <!-- Notification Bell -->
            <div class="nav-item dropdown me-3">
                <a href="#" class="nav-link position-relative" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-bell fa-lg"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown">
                    <h6 class="dropdown-header">Notifications</h6>
                    <a class="dropdown-item" href="#">
                        <div class="notification-item">
                            <div class="notification-icon bg-primary">
                                <i class="fas fa-calendar-check text-white"></i>
                            </div>
                            <div class="notification-content">
                                <p class="mb-1">New appointment scheduled</p>
                                <small class="text-muted">5 minutes ago</small>
                            </div>
                        </div>
                    </a>
                    <a class="dropdown-item" href="#">
                        <div class="notification-item">
                            <div class="notification-icon bg-success">
                                <i class="fas fa-user-plus text-white"></i>
                            </div>
                            <div class="notification-content">
                                <p class="mb-1">New patient registered</p>
                                <small class="text-muted">1 hour ago</small>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-center" href="#">View all notifications</a>
                </div>
            </div>

            <!-- User Info -->
            <div class="nav-item dropdown user-info">
                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="assets/img/photo.png" alt="Profile" class="rounded-circle me-2" width="35" height="35">
                    <div class="d-none d-md-block">
                        <div class="fw-bold"><?= $user->first_name . ' ' . $user->last_name ?></div>
                        <div class="text-muted small">Admin</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>Profile</a></li>
                    <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="./Auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav> 