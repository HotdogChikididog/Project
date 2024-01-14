<?php 

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <title>Edit Homepage - Health Data Hub</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.min.css" rel="stylesheet">

    <!-- Additional styles specific to edit_homepage.php -->
    <style>
        /* Add your additional styles here */
        body, html {
            height: 100%;
            margin: 0;
            font-size: 16px;
        }

        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        .container-fluid {
            padding-top: 56px;
        }

        @media (max-width: 991.98px) {
            .container-fluid {
                padding-top: 0;
            }
        }

        .sidebar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 225px; /* Adjust this value as needed */
            z-index: 1;
            overflow-x: hidden;
            transition: all 0.3s;
            padding-top: 56px;
        }

        @media (max-width: 991.98px) {
            .sidebar-fixed {
                padding-top: 0;
            }
        }

        .main-content {
            margin-left: 225px; /* Adjust this value as needed */
            transition: all 0.3s;
        }

        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body class="grey lighten-3">
    <!--Main Navigation-->
    <header>
        <!-- Navbar -->
        <nav class="navbar fixed-top navbar-expand-lg navbar-light white scrolling-navbar">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="navbar-brand waves-effect" href="#">
                    <strong class="blue-text">Health Data Hub</strong>
                </a>
                <!-- Collapse -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Add your navigation links here if needed -->
                    </ul>
                </div>
                <!-- Sidebar -->
                <div class="sidebar-fixed position-fixed">
                    <a class="logo-wrapper waves-effect">
                        <img src="img/images.jpg" width="150px" height="200px;" class="img-fluid" alt="">
                    </a>
                    <div class="list-group list-group-flush">
                        <a href="dashboard.php" class="list-group-item active waves-effect">
                            <i class="fas fa-chart-pie mr-3"></i>Dashboard
                        </a>
                        <a href="#" class="list-group-item list-group-item-action waves-effect"  data-toggle="modal" data-target="#modalRegisterForm">
                            <i class="fas fa-user mr-3"></i>Add Admin</a>
                        <a href="view_admin.php" class="list-group-item list-group-item-action waves-effect">
                            <i class="fas fa-users"></i> View Admin</a>
                        <a href="#" class="list-group-item list-group-item-action waves-effect" data-toggle="modal" data-target="#modalRegisterForm2">
                            <i class="fas fa-user mr-3"></i>Add User</a>
                        <a href="view_user.php" class="list-group-item list-group-item-action waves-effect">
                            <i class="fas fa-users"></i>  View User</a>
                        <a href="add_document.php" class="list-group-item list-group-item-action waves-effect">
                            <i class="fas fa-file-medical"></i> Add Document</a>
                        <a href="pending_uploads.php" class="list-group-item list-group-item-action waves-effect">
                            <i class="fas fa-file-upload"></i> Pending Uploads</a>
                        <a href="admin_log.php" class="list-group-item list-group-item-action waves-effect">
                            <i class="fas fa-chalkboard-teacher"></i> Admin logged</a>
                        <a href="user_log.php" class="list-group-item list-group-item-action waves-effect">
                            <i class="fas fa-chalkboard-teacher"></i> User logged</a>
                        <!-- Add the link to edit homepage content -->
                        <a href="edit_homepage.php" class="list-group-item list-group-item-action waves-effect">
                            <i class="fas fa-edit"></i> Edit Homepage
                        </a>
                    </div>
                </div>
                <!-- Sidebar -->
            </div>
        </nav>
        <!-- Navbar -->

        <!--Main layout-->
        <main class="pt-5 mx-lg-5">
            <div class="container-fluid mt-5">
                <!-- Heading -->
                <div class="card mb-4 wow fadeIn">
                    <!--Card content-->
                    <div class="card-body d-sm-flex justify-content-between">
                        <h4 class="mb-2 mb-sm-0 pt-1">
                            <a href="dashboard.php">Home Page</a>
                            <span>/</span>
                            <span>Edit Homepage</span>
                        </h4>
                    </div>
                </div>
                <!-- Heading -->

                <!--Grid row-->
                <div class="row wow fadeIn">
                    <!--Grid column-->
                    <div class="col-md-12 mb-4">
                        <!--Card-->
                        <div class="card">
                            <!--Card content-->
                            <div class="card-body">
                                                    <!-- Edit Homepage Form -->
                        <form action="process_edit_homepage.php" method="POST" enctype="multipart/form-data">
                            <!-- Add your form elements here -->
                            <div>
                                <label for="logo">Logo:</label>
                                <input type="file" name="logo" accept="image/*" required>
                            </div>
                            <div>
                                <label for="company_name[value]">Company Name:</label>
                                <input type="text" name="company_name[value]" required>
                                <input type="hidden" name="company_name[name]" value="Company Name">
                                <input type="hidden" name="company_name[slug]" value="<?=$_SESSION['company_name']['slug'] ?? ''?>">
                            </div>
                            <div>
                                <label for="mission_text">Mission:</label>
                                <textarea name="mission_text[value]" rows="4" required></textarea>
                                <input type="hidden" name="mission_text[name]" value="Mission Text">
                                <input type="hidden" name="mission_text[slug]" value="<?=$_SESSION['mission_text']['slug'] ?? ''?>">
                            </div>
                            <div>
                                <label for="vision_text">Vision:</label>
                                <textarea name="vision_text[value]" rows="4" required></textarea>
                                <input type="hidden" name="vision_text[name]" value="Vision Text">
                                <input type="hidden" name="vision_text[slug]" value="<?=$_SESSION['vision_text']['slug'] ?? ''?>">
                            </div>

                            <button type="submit">Save Changes</button>
                        </form>
                        <!-- End Edit Homepage Form -->
                            </div>
                        </div>
                        <!--/.Card-->
                    </div>
                    <!--Grid column-->
                </div>
                <!--Grid row-->
            </div>
        </main>
        <!--Main layout-->

        <!-- Footer -->
        <!-- Add your footer content here if needed -->
        <!-- Footer -->

        <!-- SCRIPTS -->
        <!-- JQuery -->
        <script type="text/javascript" src="js/jquery-3.4.0.min.js"></script>
        <!-- Bootstrap tooltips -->
        <script type="text/javascript" src="js/popper.min.js"></script>
        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="js/mdb.min.js"></script>
        <!-- Additional scripts specific to edit_homepage.php -->
        <script>
            // Add your additional scripts here
        </script>
    </body>
</html>
