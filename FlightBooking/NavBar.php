<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nav Bar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid navbar-container">
            <h5>
                Fly.com
            </h5>
            <div>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link navbar-item nav-Home" aria-current="page" href="./Home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navbar-item nav-About" aria-current="page" href="./About.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navbar-item nav-Faqs" aria-current="page" href="./Faqs.php">Faqs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link navbar-item nav-BookFlight" aria-current="page" href="./BookFlight.php">
                            Book Flights
                        </a>
                    </li>
                    <?php
                    if (isset($_SESSION['email'])) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link navbar-item nav-MyTrips" aria-current="page" href="./MyTrips.php">
                                My Trips
                            </a>
                        </li>
                    <?php } ?>
                    <li class="nav-item">
                        <a class="nav-link navbar-item nav-Contact" aria-current="page" href="./ContactUs.php">Contact Us</a>
                    </li>
                    <?php
                    if (!isset($_SESSION['email'])) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link navbar-item nav-active" href="./Login.php">Login/Register</a>
                        </li>
                    <?php } ?>
                    <?php
                    if (isset($_SESSION['email'])) {
                    ?>
                        <li class="nav-item">
                            <a class="nav-link navbar-item logout-button" aria-current="page" href="./Logout.php">
                                Logout
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

<!-- <footer class="py-3 my-4">
    <p class="text-center text-muted">© 2023 Fly.com, Inc</p>
</footer> -->

</html>

<style>
    .navbar {
        background-color: #1b2134;
        color: white;
        padding: 20px;
    }

    .navbar-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .nav-active,
    .nav-active:hover {
        background-color: #2d3242;
        color: white;
    }

    .navbar-item,
    .navbar-item:hover {
        color: white;
    }

    li {
        margin: 0px 10px;
    }

    h5 {
        margin: 0px;
    }

    .primary:hover,
    .primary {
        background-color: #1b2134;
        color: white;
    }

    .primary-outline:hover {
        background-color: #1b2134;
        color: white;
    }

    .primary-outline {
        border: 1px solid #1b2134;
    }

    footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        text-align: center;
    }

    .logout-button, .logout-button:hover {
        color: red;
        border: 1px solid red;
    }
</style>