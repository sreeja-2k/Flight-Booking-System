<?php
include('./mail.php');
$mysqli = new mysqli("localhost", "root", "", "flightbooking");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$errorMessage = "";
$checkMail = false;

if (isset($_GET["Code"])) {
    if ($result = $mysqli->query("SELECT * FROM forgotpasswordrequests WHERE Code = '" . $_GET['Code'] . "'")) {
        $NumberOfUsers = $result->num_rows;
        $UserDetails = $result->fetch_assoc();
        if ($NumberOfUsers == 0) {
            $errorMessage = "Invalid Reset Link!";
        }
    }
}

if (isset($_POST["password"])) {
    $query = "UPDATE users SET Password = '" . md5($_POST["password"]) . "' WHERE Id = " . $_POST["UserId"] . "";
    $mysqli->query($query);
    header('Location: ./Login.php');
}

if (isset($_POST["email"])) {
    if ($result = $mysqli->query("SELECT * FROM users WHERE email = '" . $_POST['email'] . "'")) {
        $NumberOfUsers = $result->num_rows;
        $UserDetails = $result->fetch_assoc();
        if ($NumberOfUsers == 0) {
            $errorMessage = "User with this Email is not registered";
        } else {
            $data = $data ?? random_bytes(16);
            assert(strlen($data) == 16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
            $query = "INSERT INTO `forgotpasswordrequests`(`Code`, `UserId`) 
            VALUES ('" . vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)) . "','" . $UserDetails["Id"] . "')";
            $mysqli->query($query);
            $mail->addAddress($_POST['email']);
            $mail->Subject = "Reset Password | Fly.com";
            $mail->Body = '<!doctype html><html lang="en-US"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"><title>Reset Password Email Template</title><meta name="description" content="Reset Password Email Template."><style type="text/css">a:hover{text-decoration:underline!important}</style></head><body marginheight="0" topmargin="0" marginwidth="0" style="margin:0;background-color:#f2f3f8" leftmargin="0"><table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8" style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700);font-family:\'Open Sans\',sans-serif"><tr><td><table style="background-color:#f2f3f8;max-width:670px;margin:0 auto" width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td style="height:80px">&nbsp;</td></tr><tr><td style="text-align:center"><h1>Fly.com</h1></td></tr><tr><td style="height:20px">&nbsp;</td></tr><tr><td><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:670px;background:#fff;border-radius:3px;text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06)"><tr><td style="height:40px">&nbsp;</td></tr><tr><td style="padding:0 35px"><h1 style="color:#1e1e2d;font-weight:500;margin:0;font-size:32px;font-family:Rubik,sans-serif">You have requested to reset your password</h1><span style="display:inline-block;vertical-align:middle;margin:29px 0 26px;border-bottom:1px solid #cecece;width:100px"></span><p style="color:#455056;font-size:15px;line-height:24px;margin:0">We cannot simply send you your old password. A unique link to reset your password has been generated for you. To reset your password, click the following link and follow the instructions.</p><a href=' . $baseURL . 'ForgetPassword.php?Code=' . vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)) . ' style="background:#1b2134;text-decoration:none!important;font-weight:500;margin-top:35px;color:#fff;text-transform:uppercase;font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px">Reset Password</a></td></tr><tr><td style="height:40px">&nbsp;</td></tr></table></td><tr><td style="height:20px">&nbsp;</td></tr></table></td></tr></table></body></html>';
            $mail->send();
            $checkMail = true;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="navigation"></div>
    <div class="body-container">
        <div class="registration-container">
            <?php if ($errorMessage != "") { ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div>
                        <?php echo $errorMessage; ?>
                    </div>
                </div>
            <?php } ?>
            <?php if (isset($_GET["Code"])) { ?>
                <form action="ForgetPassword.php" method="post" class="registration-form" id="regitrationForm">
                    <img src="./Assets/flight2.jpg" alt="">
                    <h2 class="heading">
                        Forgot Password
                    </h2>
                    <div class="input-group">
                        <input required type="password" class="form-control" placeholder="Password" id="password" aria-label="Password" name="password" aria-describedby="basic-addon1">
                    </div>
                    <span id="password-validation"></span>
                    <div class="input-group">
                        <input required type="password" class="form-control" placeholder="Confirm Password" id="confirmpassword" aria-label="Password" aria-describedby="basic-addon1">
                    </div>
                    <span id="confirmpassword-validation"></span>
                    <input type="text" name="UserId" value="<?php echo $UserDetails["UserId"]; ?>" style="display:none">
                    <button type="button" onclick="validate()" class="btn primary action-button">Reset Password</button>
                    <a href="./Login.php">
                        <button type="button" class="btn primary-outline action-button">Back to Login</button>
                    </a>
                </form>
            <?php } else { ?>
                <?php if ($checkMail) { ?>
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <div>
                            Check your mail for reset password link.
                        </div>
                    </div>
                <?php } ?>
                <form action="ForgetPassword.php" method="post" class="registration-form" id="emailForm">
                    <img src="./Assets/flight2.jpg" alt="">
                    <h2 class="heading">
                        Forgot Password
                    </h2>
                    <div class="input-group">
                        <input required type="email" class="form-control" placeholder="Email Address" id="email" aria-label="email" aria-describedby="basic-addon1" name="email">
                    </div>
                    <span id="email-validation"></span>
                    <button type="button" onclick="validateEmail()" class="btn primary action-button">Reset Password</button>
                    <a href="./Login.php">
                        <button type="button" class="btn primary-outline action-button">Back to Login</button>
                    </a>
                </form>
            <?php } ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<script>
    $('.navigation').load('Navbar.php');

    function validate() {
        var password = $('#password').val();
        var confirmPassword = $('#confirmpassword').val();
        var isValid = true;

        if (password.length == 0) {
            $('#password-validation').html('Password is required!');
            $('#password-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#password-validation').html('');
        }

        if (confirmPassword.length == 0) {
            $('#confirmpassword-validation').html('Confirm Password is required!');
            $('#confirmpassword-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#confirmpassword-validation').html('');
        }

        if (password.length != 0 && confirmPassword.length != 0 && password != confirmPassword) {
            $('#confirmpassword-validation').html('Password not matched !');
            $('#confirmpassword-validation').addClass('invalid');
            isValid &= false;
        } else if (password.length != 0 && confirmPassword.length != 0) {
            $('#confirmpassword-validation').html('');
        }

        if (isValid)
            document.getElementById("regitrationForm").submit();
    }

    function validateEmail() {
        var isValid = true;
        var email = $('#email').val();
        if (email.length == 0) {
            $('#email-validation').html('Email is required!');
            $('#email-validation').addClass('invalid');
            isValid &= false;
        } else if (!email.match(
                /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
            )) {
            $('#email-validation').html('Enter a valid Email!');
            $('#email-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#email-validation').html('');
        }


        if (isValid)
            document.getElementById("emailForm").submit();
    }
</script>

<style>
    .body-container {
        display: flex;
        align-items: center;
        justify-content: start;
        flex-direction: column;
        padding: 30px;
        height: 1000px;
    }

    img {
        width: 100%;
        border-radius: 20px;
    }

    .input-field {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .registration-container {
        display: flex;
        padding: 30px;
        width: 500px;
        flex-direction: column;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        background-color: white;
    }

    .registration-form {
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
        width: 100% !important;
        border-radius: 10px;
        border: 1px solid black;
        margin-bottom: 5px;
    }

    .action-button {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 10px;
    }

    .gender-dropdown {
        width: 100%;
        margin-bottom: 5px;
    }

    select,
    select:focus,
    select:active {
        width: 100%;
        text-align: left;
        border: 1px solid #dee2e6 !important;
        padding: 7px;
        border-radius: 5px;
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