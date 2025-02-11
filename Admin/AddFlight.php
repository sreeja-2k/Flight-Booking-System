
<?php
include('../Helpers/DBConfig.php');
$errorMessage = "";
if ($airports = $mysqli->query("SELECT * FROM `airports`")) {
}
if (isset($_POST["Source"])) {
    $query = "INSERT INTO `flights` (
        `Name`
        ,`DateTime`
        ,`Duration`
        ,`Source`
        ,`Destination`
        ,`Price`
        )
    VALUES (
         '" . $_POST["Name"] . "'
        ,'" . $_POST["DateTime"] . "'
        ,'" . $_POST["Duration"] . "'
        ,'" . $_POST["Source"] . "'
        ,'" . $_POST["Destination"] . "'
        ,'" . $_POST["Price"] . "'
        )";
    $mysqli->query($query);
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
            <?php if (isset($_POST["Source"])){ ?> 

            
        <div class="alert alert-success" role="alert">
                 Flight Added Sucessfully!
        </div>
            <?php } ?>
            <form action="AddFlight.php" method="post" id="flightFilterForm">
                <h2 class="heading">
                    Add Flight
                </h2>
                <div class="booking-row">
                    <p>Name</p>
                    <div class="input-group" style="margin-bottom: 10px;">
                        <input type="text" id="name" class="form-control" placeholder="Name" aria-label="Username" name="Name" aria-describedby="basic-addon1">
                        <span id="name-validation"></span>
                    </div>
                    <div class="booking-container-item" style="flex-grow: 1;">
                        <div class="source">
                            <p>Source</p>
                            <div class="input-group dropdown filter-dropdown" style="margin-bottom: 10px;">
                                <select class="custom-select" id="source" name="Source">
                                    <option value="">Source</option>
                                    <?php
                                    foreach ($airports as $row) {
                                    ?>
                                        <option value="<?php echo $row["Id"] ?>"><?php echo $row["Name"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <span id="source-validation"></span>
                        </div>
                        <div class="destination">
                            <p>Destination</p>
                            <div class="input-group dropdown filter-dropdown" style="margin-bottom: 10px;">
                                <select class="custom-select" id="destination" name="Destination">
                                    <option value="">Destination</option>
                                    <?php
                                    foreach ($airports as $row) {
                                    ?>
                                        <option value="<?php echo $row["Id"] ?>"><?php echo $row["Name"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <span id="destination-validation"></span>
                        </div>
                    </div>
                    <div class="booking-container-item" style="flex-grow: 1;">
                        <div class="source">
                            <p>Departure Date</p>
                            <div class="input-group" style="margin-bottom: 10px;">
                                <input value="" min="<?= date('Y-m-d'); ?>" type="date" id="departure" name="DateTime" class="form-control" placeholder="Departure" aria-label="Departure" aria-describedby="basic-addon1">
                            </div>
                            <span id="departure-validation"></span>
                        </div>
                    </div>

                    <div class="booking-container-item" style="flex-grow: 1;">
                        <div class="source">
                            <p>Price</p>
                            <div class="input-group" style="margin-bottom: 10px;">
                                <input value="" type="int" id="price" name="Price" class="form-control" placeholder="Departure" aria-label="Departure" aria-describedby="basic-addon1">
                            </div>
                            <span id="price-validation"></span>
                        </div>
                    </div>

                    <div class="booking-container-item" style="flex-grow: 1;">
                        <div class="source">
                            <p>Duration</p>
                            <div class="input-group" style="margin-bottom: 10px;">
                                <input value="" type="text" id="duration" name="Duration" class="form-control" placeholder="Departure" aria-label="Departure" aria-describedby="basic-addon1">
                            </div>
                            <span id="duration-validation"></span>
                        </div>
                    </div>
                    <button type="button" onclick="validate()" class="btn primary get-flights">Add</button>
                </div>
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
        var name = $('#name').val();
        var source = $('#source').val();
        var destination = $('#destination').val();
        var departure = $('#departure').val();
        var duration = $('#duration').val();
        var price = $('#price').val();
        var isValid = true;

        if (name.length == 0) {
            $('#name-validation').html('Name is required!');
            $('#name-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#name-validation').html('');
        }

        if (duration.length == 0) {
            $('#duration-validation').html('Duration is required!');
            $('#duration-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#duration-validation').html('');
        }

        if (price.length == 0) {
            $('#price-validation').html('Price is required!');
            $('#price-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#price-validation').html('');
        }

        if (source.length == 0) {
            $('#source-validation').html('Source is required!');
            $('#source-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#source-validation').html('');
        }

        if (destination.length == 0) {
            $('#destination-validation').html('Destination is required!');
            $('#destination-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#destination-validation').html('');
        }

        if (departure.length == 0) {
            $('#departure-validation').html('Departure is required!');
            $('#departure-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#departure-validation').html('');
        }

        if (isValid)
            document.getElementById("flightFilterForm").submit();
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
        background-image: url(./flight8.jpg);
        background-size: cover;
    }

    img {
        width: 100%;
        border-radius: 20px;
    }

    .login-container {
        display: flex;
        padding: 30px;
        width: 600px;
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
        display: flex;
        align-items: center;
        justify-content: center;
    }

    input {
        width: 100%;
        margin-bottom: 15px;
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

    select,
    select:focus,
    select:active {
        width: 100%;
        text-align: left;
        border: 1px solid black !important;
        padding: 7px;
        border-radius: 5px;
    }

    .booking-form {
        padding: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    input {
        width: 100%;
        margin-bottom: 5px;
        border-radius: 10px;
        border: 1px solid black !important;
    }

    .primary:hover,
    .primary {
        background-color: #1b2134;
        color: white;
    }

    p {
        margin-bottom: 0px;
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
