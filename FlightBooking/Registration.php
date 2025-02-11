<?php
$mysqli = new mysqli("localhost", "root", "", "flightbooking");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$errorMessage = "";
if(isset($_POST['email'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dateofbirth = $_POST['dateofbirth'];
    $mobilenumber = $_POST['mobilenumber'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    session_start();

    if ($CurrentUser = $mysqli->query("SELECT * FROM users WHERE email = '" . $email . "'")) {
        $UserDetails = $CurrentUser->fetch_assoc();
        if(isset($UserDetails)) {
            $errorMessage = "User with <b>".$email."</b> Already Exists!";
        }
        else {
            $query = "INSERT INTO `users` (
                `Name`
                ,`Email`
                ,`DateOfBirth`
                ,`MobileNumber`
                ,`Gender`
                ,`Password`
                )
            VALUES (
                '".$name."'
                ,'".$email."'
                ,'".$dateofbirth."'
                ,'".$mobilenumber."'
                ,'".$gender."'
                ,'".md5($password)."'
                )";
            $mysqli->query($query);
            header('Location: ./Login.php');
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
            <form action="Registration.php" method="post" class="registration-form" id="regitrationForm">
                <img src="./Assets/flight2.jpg" alt="">
                <h2 class="heading">
                    Register
                </h2>
                <?php if ($errorMessage != "") { ?>
                    <div class="alert alert-danger d-flex align-items-center error-alert" role="alert">
                        <div>
                            <?php echo $errorMessage; ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="input-group input-field">
                    <input required type="text" class="form-control" placeholder="Name" id="name" aria-label="Username" aria-describedby="basic-addon1" name="name">
                </div>
                <span id="name-validation"></span>
                <div class="input-group">
                    <input required type="email" class="form-control" placeholder="Email Address" id="email" aria-label="email" aria-describedby="basic-addon1" name="email">
                </div>
                <span id="email-validation"></span>
                <div class="input-group">
                    <input required type="number" class="form-control" placeholder="Mobile Number" id="mobilenumber" aria-label="mobilenumber" aria-describedby="basic-addon1" name="mobilenumber">
                </div>
                <span id="mobilenumber-validation"></span>
                <div class="input-group">
                    <input required type="date" class="form-control" placeholder="Date Of Birth" aria-label="Password" id="dateofbirth" aria-describedby="basic-addon1" name="dateofbirth">
                </div>
                <span id="dateofbirth-validation"></span>
                <div class="input-group dropdown gender-dropdown">
                    <select class="custom-select" id="gender" name="gender">
                        <option value="">Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <span id="gender-validation"></span>
                <div class="input-group">
                    <input required type="password" class="form-control" placeholder="Password" id="password" aria-label="Password" name="password" aria-describedby="basic-addon1">
                </div>
                <span id="password-validation"></span>
                <div class="input-group">
                    <input required type="password" class="form-control" placeholder="Confirm Password" id="confirmpassword" aria-label="Password" aria-describedby="basic-addon1">
                </div>
                <span id="confirmpassword-validation"></span>
                <button type="button" onclick="validate()" class="btn primary action-button">Register</button>
                <a href="./Login.php">
                    <button type="button" class="btn primary-outline action-button">Back to Login</button>
                </a>
            </form>
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
        var name = $('#name').val();
        var email = $('#email').val();
        var dateOfBirth = $('#dateofbirth').val();
        var mobileNumber = $('#mobilenumber').val();
        var gender = $('#gender').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirmpassword').val();
        var isValid = true;
        if (name.length == 0) {
            $('#name-validation').html('Name is required!');
            $('#name-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#name-validation').html('');
        }

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

        if (mobileNumber.length == 0) {
            $('#mobilenumber-validation').html('Mobile Number is required!');
            $('#mobilenumber-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#mobilenumber-validation').html('');
        }

        if (dateOfBirth.length == 0) {
            $('#dateofbirth-validation').html('Date Of Birth is required!');
            $('#dateofbirth-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#dateofbirth-validation').html('');
        }

        if(gender.length == 0) {
            $('#gender-validation').html('Gender is required!');
            $('#gender-validation').addClass('invalid');
            isValid &= false;
        }
        else {
            $('#gender-validation').html('');
        }

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
</script>

<style>
    .body-container {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 30px;
        background-image: url("./Assets/flight2.jpg");
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

    select, select:focus, select:active {
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