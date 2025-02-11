<?php
include('./Helpers/DBConfig.php');
$errorMessage = "";
if (isset($_POST["Source"])) {
    if ($flights = $mysqli->query("SELECT * FROM `flights` WHERE Source = '" . $_POST["Source"] . "' AND Destination = '" . $_POST["Destination"] . "' AND CONVERT('" . $_POST["Departure"] . "', DATE) = CONVERT(DateTime, DATE)")) {
    }
    if ($_POST["tripType"] == "2") {
        if ($returnFlights = $mysqli->query("SELECT * FROM `flights` WHERE Source = '" . $_POST["Destination"] . "' AND Destination = '" . $_POST["Source"] . "' AND CONVERT('" . $_POST["Return"] . "', DATE) = CONVERT(DateTime, DATE)")) {
        }
    }
}
if ($airports = $mysqli->query("SELECT * FROM `airports`")) {
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Flight</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous">
    </link>
</head>

<body>
    <div class="navigation"></div>
    <div class="body-container">
        <div class="booking-container">
            <img src="./Assets/flight4.jpg" alt="">
            <div class="booking-container-item">
                <button class="btn <?php echo isset($_POST["tripType"]) ? ($_POST["tripType"] == 1 ? 'primary' : 'primary-outline') : 'primary'; ?> trip-type left-button" id="OneWay" onclick="toggleType(1)"> One Way </button>
                <button class="btn <?php echo isset($_POST["tripType"]) ? ($_POST["tripType"] == 1 ? 'primary-outline' : 'primary') : 'primary-outline'; ?> trip-type right-button" id="ReturnTrip" onclick="toggleType(2)"> Return Trip </button>
            </div>
            <form action="BookFlight.php" method="post" id="flightFilterForm">
                <div class="booking-row">
                    <div class="booking-container-item" style="flex-grow: 1;">
                        <div class="source">
                            <p>Source</p>
                            <!-- <div class="input-group">
                                <input type="text" id="source" name="Source" class="form-control" placeholder="Source" aria-label="Source" aria-describedby="basic-addon1">
                            </div> -->
                            <div class="input-group dropdown filter-dropdown">
                                <select class="custom-select" id="source" name="Source">
                                    <option value="">Source</option>
                                    <?php
                                    foreach ($airports as $row) {
                                        if ($row["Id"] == $_POST["Source"]) {
                                    ?>
                                            <option selected value="<?php echo $row["Id"] ?>"><?php echo $row["Name"]; ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?php echo $row["Id"] ?>"><?php echo $row["Name"]; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <span id="source-validation"></span>
                        </div>
                        <div class="destination">
                            <p>Destination</p>
                            <div class="input-group dropdown filter-dropdown">
                                <select class="custom-select" id="destination" name="Destination">
                                    <option value="">Destination</option>
                                    <?php
                                    foreach ($airports as $row) {
                                        if ($row["Id"] == $_POST["Destination"]) {
                                    ?>
                                            <option selected value="<?php echo $row["Id"] ?>"><?php echo $row["Name"]; ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?php echo $row["Id"] ?>"><?php echo $row["Name"]; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- <div class="input-group">
                                <input type="text" id="destination" name="Destination" class="form-control" placeholder="Destination" aria-label="Destination" aria-describedby="basic-addon1">
                            </div> -->
                            <span id="destination-validation"></span>
                        </div>
                    </div>
                    <div class="booking-container-item" style="flex-grow: 1;">
                        <div class="source">
                            <p>Departure</p>
                            <div class="input-group">
                                <input value="<?php echo isset($_POST["Departure"]) ? $_POST["Departure"] : ''; ?>" min="<?= date('Y-m-d'); ?>" type="date" id="departure" name="Departure" class="form-control" placeholder="Departure" aria-label="Departure" aria-describedby="basic-addon1">
                            </div>
                            <span id="departure-validation"></span>
                        </div>
                        <div class="destination">
                            <p>Return</p>
                            <div class="input-group">
                                <input value="<?php echo isset($_POST["Return"]) ? $_POST["Return"] : ''; ?>" min="<?= date('Y-m-d'); ?>" type="date" id="return" name="Return" <?php echo isset($_POST["tripType"]) ? ($_POST["tripType"] == 1 ? "disabled" : "") : "disabled" ?> class="form-control" placeholder="Return" aria-label="Return" aria-describedby="basic-addon1">
                            </div>
                            <span id="return-validation"></span>
                        </div>
                    </div>
                    <div>
                        <div class="source" style="width: 150px;">
                            <p>No Of Seats</p>
                            <div class="input-group">
                                <input value="<?php echo isset($_POST["NoOfSeats"]) ? $_POST["NoOfSeats"] : 0; ?>" type="number" min="1" id="numberOfSeats" name="NoOfSeats" class="form-control" placeholder="Seats" aria-label="Departure" aria-describedby="basic-addon1">
                            </div>
                            <span id="NoofSeats-validation"></span>
                        </div>
                    </div>
                    <button type="button" onclick="validate()" class="btn primary get-flights">Search</button>
                </div>

                <div id="trip" style="display:none">
                    <input name="tripType" value="1" id="tripType">
                </div>
            </form>

            <form action="BookSeat.php" method="post" Id="seatsForm" style="display:none">
                <input name="tripType" value="<?php echo $_POST["tripType"]; ?>" id="tripTypeId">
                <input type="text" name="departureFlightId" value="" Id="departureFlightId">
                <input type="text" name="arrivalFlightId" value="" Id="arrivalFlightId">
                <input type="text" name="seats" value="" Id="seats">
            </form>
        </div>
        <div class="results">
            <div class="result">
                <?php if (isset($_POST["Source"])) { ?>
                    <div class="type-heading">
                        <h1>Departure</h1>
                    </div>
                    <div class="results-container-heading">
                        <div class="result-item">
                            <h5>
                                Airlines
                            </h5>
                        </div>
                        <div class="result-item">
                            <h5>
                                Time
                            </h5>
                        </div>
                        <div class="result-item">
                            <h5>
                                Duration
                            </h5>
                        </div>
                        <div class="result-item">
                            <h5>
                                Price
                            </h5>
                        </div>
                        <div class="result-item">
                            <h5>
                                Action
                            </h5>
                        </div>
                    </div>
                    <?php
                    foreach ($flights as $row) {
                    ?>
                        <div class="results-container">
                            <div class="result-item">
                                <h5>
                                    <?php echo $row["Name"]; ?>
                                </h5>
                            </div>
                            <div class="result-item">
                                <h5>
                                    <?php echo $row["DateTime"]; ?>
                                </h5>
                                <?php echo $row["Source"]; ?>
                            </div>
                            <div class="result-item">
                                <h5>
                                    <?php echo $row["Duration"]; ?>
                                </h5>
                            </div>
                            <div class="result-item">
                                <h5>
                                    $<?php echo $row["Price"]; ?>
                                </h5>
                            </div>
                            <div class="result-item">
                                <button class="btn primary-outline" id="Departure-<?php echo $row['Id']; ?>" onclick="bookSeats(<?php echo $row['Id']; ?>, 'Departure')">Book Tickets</button>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
            </div>
            <div class="result">
                <?php if ($_POST["tripType"] == "2") { ?>
                    <div class="type-heading">
                        <h1>Arrival</h1>
                    </div>
                    <div class="results-container-heading">
                        <div class="result-item">
                            <h5>
                                Airlines
                            </h5>
                        </div>
                        <div class="result-item">
                            <h5>
                                Time
                            </h5>
                        </div>
                        <div class="result-item">
                            <h5>
                                Duration
                            </h5>
                        </div>
                        <div class="result-item">
                            <h5>
                                Price
                            </h5>
                        </div>
                        <div class="result-item">
                            <h5>
                                Action
                            </h5>
                        </div>
                    </div>

                    <?php
                        foreach ($returnFlights as $row) {
                    ?>
                        <div class="results-container">
                            <div class="result-item">
                                <h5>
                                    <?php echo $row["Name"]; ?>
                                </h5>
                            </div>
                            <div class="result-item">
                                <h5>
                                    <?php echo $row["DateTime"]; ?>
                                </h5>
                                <?php echo $row["Source"]; ?>
                            </div>
                            <div class="result-item">
                                <h5>
                                    <?php echo $row["Duration"]; ?>
                                </h5>
                            </div>
                            <div class="result-item">
                                <h5>
                                    $<?php echo $row["Price"]; ?>
                                </h5>
                            </div>
                            <div class="result-item">
                                <button class="btn primary-outline" onclick="bookSeats(<?php echo $row['Id']; ?>, 'Arrival')">Book Tickets</button>
                            </div>
                        </div>
                    <?php
                        }
                    ?>
                <?php
                    }
                ?>

            </div>
        </div>
    </div>
<?php
                }
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<script>
    $('.navigation').load('Navbar.php');
    var isRoundTrip = $('#ReturnTrip').hasClass("primary");
    var departureFlightId = 0;

    function toggleType(type) {
        if (type == 1) {
            $('#OneWay').addClass("primary");
            $('#OneWay').removeClass("primary-outline");
            $('#ReturnTrip').addClass("primary-outline");
            $('#ReturnTrip').removeClass("primary");
            $("#return").prop('disabled', true);
            isRoundTrip = false;
            $('#tripType').val("1");
            console.log($('#tripType'))
        } else {
            $('#OneWay').removeClass("primary");
            $('#OneWay').addClass("primary-outline");
            $('#ReturnTrip').removeClass("primary-outline");
            $('#ReturnTrip').addClass("primary");
            $("#return").prop('disabled', false);
            $('#tripType').val("oneway");
            $('#tripType').val("2");
            isRoundTrip = true;
        }
    }

    function validate() {
        console.log(isRoundTrip);
        var source = $('#source').val();
        var destination = $('#destination').val();
        var departure = $('#departure').val();
        var returnn = $('#return').val();
        var numberOfSeats = $('#numberOfSeats').val();
        var isValid = true;

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

        if (returnn.length == 0 && isRoundTrip) {
            $('#return-validation').html('Return is required!');
            $('#return-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#return-validation').html('');
        }

        if (numberOfSeats.length == 0) {
            $('#NoofSeats-validation').html('Seats are required!');
            $('#NoofSeats-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#NoofSeats-validation').html('');
        }

        if (isValid)
            document.getElementById("flightFilterForm").submit();
    }

    function bookSeats(flightId, type) {
        if (isRoundTrip) {
            if (type == "Departure") {
                $(`#Departure-${flightId}`).addClass("primary");
                if (departureFlightId > 0) {
                    $(`#Departure-${departureFlightId}`).removeClass("primary");
                }
                departureFlightId = flightId;
                $('#departureFlightId').val(flightId);
            } else {
                $('#arrivalFlightId').val(flightId);
                $('#seats').val($('#numberOfSeats').val());
                document.getElementById("seatsForm").submit();
            }
        } else {
            $('#departureFlightId').val(flightId);
            $('#seats').val($('#numberOfSeats').val());
            document.getElementById("seatsForm").submit();
        }
    }
</script>

<style>
    .nav-BookFlight,
    .nav-BookFlight:hover {
        background-color: #2d3242;
        color: white;
    }

    .body-container {
        display: flex;
        align-items: center;
        justify-content: start;
        flex-direction: column;
        padding: 30px;
        background-image: url("./Assets/flight4.jpg");
        min-height: 1000px;
        background-size: cover;
    }

    .booking-container {
        display: flex;
        padding: 30px;
        width: 1000px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        background-color: white;
        border-radius: 10px;
    }

    form {
        width: 100%;
    }

    .booking-container-item {
        display: flex;
        flex-direction: row;
        align-items: start;
        justify-content: center;
        background-color: white;
        /* flex-grow: 1; */
    }

    .source,
    .destination {
        width: 50%;
        padding: 10px;
    }

    .type-heading {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #1b2134;
        color: white;
        width: 1000px;
        padding: 20px;
        margin-top: 30px;
        border-radius: 10px;
    }

    .results {
        display: flex;
        align-items: start;
        flex-direction: row;
    }

    .result {
        margin: 10px;
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

    img {
        width: 100%;
        border-radius: 20px;
        height: 200px;
        margin-bottom: 30px;
    }

    .filter-dropdown {
        width: 100%;
        margin-bottom: 5px;
    }

    .radio {
        margin: 10px;
    }

    .trip-type {
        border-radius: 0px;
    }

    .booking-row {
        display: flex;
        flex-direction: row;
        align-items: start;
    }

    .action-button {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        cursor: pointer;
        margin-bottom: 10px;
    }

    .right-button {
        border-radius: 0px 10px 10px 0px;
    }

    .left-button {
        border-radius: 10px 0px 0px 10px;
    }

    .get-flights {
        height: max-content;
        margin-top: 35px;

    }

    input:focus {
        outline: none;
    }

    a {
        width: 100%;
    }

    p {
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

    .results-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-direction: row;
        /* width: 1000px; */
        margin-top: 10px;
        padding: 20px;
        border: 1px dotted #1b2134;
        border-radius: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        background-color: white;
    }

    .result-item {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .results-container-heading {
        margin-bottom: 20px;
        padding: 10px 30px;
        width: 1000px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-direction: row;
        background-color: #1b2134;
        color: white;
        border-radius: 10px;
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
</style>