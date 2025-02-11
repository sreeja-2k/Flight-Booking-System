<?php
include('../Helpers/DBConfig.php');
$errorMessage = "";
if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($result = $mysqli->query("SELECT * FROM adminusers WHERE email = '" . $_POST['username'] . "' AND password = '" . md5($_POST['password']) . "'")) {
        $NumberOfUsers = $result->num_rows;
        $UserDetails = $result->fetch_assoc();
        if ($NumberOfUsers == 0) {
            $errorMessage = "Invalid User Name and Password!";
        } else {
            session_start();
            $_SESSION['email'] = $_POST['username'];
            $_SESSION['Id'] = $UserDetails['Id'];
            header('Location: ./AddFlight.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="navigation"></div>
    <div class="body-container">
        <div class="login-container">
            <form action="login.php" method="post" class="login-form" id="loginForm">
                <img src="../Assets/flight1.jpg" alt="">
                <h2 class="heading">
                    Login
                </h2>
                <?php if ($errorMessage != "") { ?>
                    <div class="alert alert-danger d-flex align-items-center error-alert" role="alert">
                        <div>
                            <?php echo $errorMessage; ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="input-group">
                    <input type="text" id="username" class="form-control" placeholder="Username" aria-label="Username" name="username" aria-describedby="basic-addon1">
                </div>
                <span id="username-validation"></span>
                <div class="input-group">
                    <input type="password" id="password" required class="form-control" placeholder="Password" aria-label="Password" name="password" aria-describedby="basic-addon1">
                </div>
                <span id="password-validation"></span>
                <p><a class="link-opacity-100" href="./ForgetPassword.php">Forgot Password?</a></p>
                <button type="button" onclick="validate()" class="btn primary action-button">Login</button>
                <!-- <p>
                    (or)
                </p> -->
                <a href="../Login.php">
                    <button type="button" class="btn primary-outline action-button">User Login</button>
                </a>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </div>
</body>

</html>

<script>
    $('.navigation').load('Navbar.php');

    function validate() {
        var email = $('#username').val();
        var password = $('#password').val();
        var isValid = true;

        if (email.length == 0) {
            $('#username-validation').html('Email is required!');
            $('#username-validation').addClass('invalid');
            isValid &= false;
        } else if (!email.match(
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            )) {
            $('#username-validation').html('Enter a valid Email!');
            $('#username-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#username-validation').html('');
        }

        if (password.length == 0) {
            $('#password-validation').html('Password is required!');
            $('#password-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#password-validation').html('');
        }

        if (isValid)
            document.getElementById("loginForm").submit();
    }
</script>

<style>
    .body-container {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0px;
        margin: 0px;
        background-image: url("../Assets/flight1.jpg");
        height: 1000px;
    }

    img {
        width: 100%;
        border-radius: 20px;
    }

    .login-container {
        display: flex;
        padding: 30px;
        width: 800px;
        flex-direction: column;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        background-color: white;
    }

    .login-form {
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .heading {
        margin: 30px;
    }

    input {
        width: 100%;
        margin-bottom: 5px;
        border-radius: 10px;
        border: 1px solid black;
    }

    .action-button {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 10px;
    }

    input:focus {
        outline: none;
    }

    a {
        width: 100%;
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

    .valid {
        color: green;
        width: 100%;
        margin-bottom: 20px;
    }

    .invalid {
        color: red;
        width: 100%;
        margin-bottom: 10px;
    }

    .error-alert {
        width: 100%;
    }
</style>