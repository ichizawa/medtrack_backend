<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MedTrack</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/css/topnav.css">
    <style>
        body {
            min-height: 100vh;
            background: #F4F7FE;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #content {
            width: 100%;
            min-height: 100vh;
            margin-left: 250px;
            transition: all 0.3s;
        }

        #content.active {
            margin-left: 0;
        }

        .main-content {
            padding: 20px 30px;
        }

        @media (max-width: 768px) {
            #content {
                margin-left: 0;
            }
            
            .navbar {
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <?php 
        include_once __DIR__ . '/../../conf.php';

        $userid = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE id = $userid";
        $qr = $conn->query($query);
        $user = $qr->fetch_object();

    ?>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- Page Content -->
        <div id="content">
            <!-- Top Navigation -->
            <?php include 'topnav.php'; ?>

            <!-- Main Content -->
            <div class="main-content">
                <?php
                if (isset($pageContent)) {
                    echo $pageContent;
                }
                ?>
            </div>
        </div>

        <!-- Overlay for mobile sidebar -->
        <div class="overlay"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');
            const overlay = document.querySelector('.overlay');
            const sidebarCollapse = document.getElementById('sidebarCollapse');

            if (sidebarCollapse) {
                sidebarCollapse.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    content.classList.toggle('active');
                    overlay.classList.toggle('active');
                });
            }

            // Close sidebar when clicking overlay
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('active');
                content.classList.remove('active');
                overlay.classList.remove('active');
            });

            // Close sidebar on window resize if in mobile view
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    overlay.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
