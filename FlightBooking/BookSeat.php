<?php
session_start();
include('./Helpers/DBConfig.php');
$errorMessage = "";

$col = array("1", "2", "3", "4", "5", "6");
$row = array("A", "B", "C", "D", "E", "F", "G", "H");

$arrivalSeats = array();
$seats = array();
if (isset($_POST["payment"])) {
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
    $query = "INSERT INTO `tickets` (
        `FlightId`
        ,`UserId`
        ,`Seats`
        ,`Code`
        ,`Price`
        )
    VALUES (
        '" . $_POST["FlightId"] . "'
        ,'" . $_SESSION["Id"] . "'
        ,'" . $_POST["Seats"] . "'
        ,'" . vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)) . "'
        ," . (int)$_POST["Price"] * (int)$_POST["NumberOfSeats"] . "
        )";
    $mysqli->query($query);
    $arrivalTicketDetail = array();
    if ($ticket = $mysqli->query("SELECT LAST_INSERT_ID() as TicketId")) {
        $ticketDetails = $ticket->fetch_assoc();
    }
    if ($_POST["ArrivalSeats"] != "") {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        $query = "INSERT INTO `tickets` (
            `FlightId`
            ,`UserId`
            ,`Seats`
            ,`Code`
            ,`Price`
            )
        VALUES (
            '" . $_POST["ArrivalFlightId"] . "'
            ,'" . $_SESSION["Id"] . "'
            ,'" . $_POST["ArrivalSeats"] . "'
            ,'" . vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)) . "'
            ," . (int)$_POST["ArrivalPrice"] * (int)$_POST["NumberOfSeats"] . "
            )";
        $mysqli->query($query);

        if ($ticket = $mysqli->query("SELECT LAST_INSERT_ID() as TicketId")) {
            $arrivalTicketDetails = $ticket->fetch_assoc();
            header('Location: ./Payment.php?TicketId=' . $ticketDetails['TicketId'] . "," . $arrivalTicketDetails['TicketId']);
        }
    } else {
        header('Location: ./Payment.php?TicketId=' . $ticketDetails['TicketId']);
    }
} else {
    if ($bookedSeats = $mysqli->query("SELECT GROUP_CONCAT(Seats) seats FROM `tickets` WHERE FlightId = " . (int)$_POST['departureFlightId'] . " AND Status = 1")) {
        $result = $bookedSeats->fetch_assoc();
        if ($result) {
            $seats = explode(",", $result['seats']);
        }
    }
    if ($Flights = $mysqli->query("SELECT * FROM `flights` WHERE Id = " . (int)$_POST['departureFlightId'] . "")) {
        $price = $Flights->fetch_assoc()['Price'];
    }
    if ($_POST["tripType"] == "2") {
        if ($arrivalBookedSeats = $mysqli->query("SELECT GROUP_CONCAT(Seats) seats FROM `tickets` WHERE FlightId = " . (int)$_POST['arrivalFlightId'] . " AND Status = 1")) {
            $result1 = $arrivalBookedSeats->fetch_assoc();
            if ($result1) {
                $arrivalSeats = explode(",", $result1['seats']);
            }
        }
        if ($Flights = $mysqli->query("SELECT * FROM `flights` WHERE Id = " . (int)$_POST['arrivalFlightId'] . "")) {
            $arrivalPrice = $Flights->fetch_assoc()['Price'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="navigation"></div>
    <div class="body-container container">
        <div class="no-of-seats seats-count">
            <h4>
                <b>Number Of Seats:</b> <span><?php echo $_POST['seats']; ?></span>
            </h4>
        </div>
        <div class="booking-container">
            <form action="BookSeat.php" method="post" id="bookSeats">
                <div class="seat-booking-container">
                    <div class="seat-heading">
                        <h3>
                            Departure
                        </h3>
                    </div>
                    <div class="seat-booking seat-booking-heading">
                        <div>
                            <h3>

                            </h3>
                        </div>
                        <div>
                            <h3>

                            </h3>
                        </div>
                        <?php
                        foreach ($col as $c) {
                        ?>
                            <div>
                                <h1>
                                    <?php echo $c; ?>
                                </h1>
                            </div>
                            <?php
                            if ($c == "3") { ?>
                                <div>
                                    <pre>        </pre>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
                    <?php
                    foreach ($row as $r) {
                    ?>
                        <div class="seat-booking">
                            <div>
                                <h3>
                                    <?php echo $r; ?>
                                </h3>
                            </div>
                            (W)
                            <?php
                            foreach ($col as $c) {
                            ?>
                                <h1>
                                    <?php if (in_array($r . $c, $seats)) { ?>
                                        <i class="bi bi-file-x-fill" id="<?php echo $r . $c; ?>" style="cursor: not-allowed;"></i>
                                    <?php } else { ?>
                                        <i class="bi bi-file" id="<?php echo $r . $c; ?>" onclick="seatClicked('<?php echo $r . $c; ?>', 'Departure')"></i>
                                    <?php } ?>
                                </h1>
                                <?php if ($c == "3") { ?>
                                    <div>
                                        <pre>        </pre>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            (W)
                        </div>
                    <?php } ?>
                </div>

                <div class="seats-count">
                    <h4>
                        <b>Selected Seats:</b> <span id="selectedSeats">None</span>
                    </h4>
                </div>
                <div id="trip" style="display:none">
                    <input name="Seats" value="" id="seats">
                    <input name="TripType" value="<?php echo $_POST["tripType"]; ?>" id="seats">
                    <input name="ArrivalSeats" value="" id="arrival-seats">
                    <input name="FlightId" value="<?php echo $_POST["departureFlightId"]; ?>" id="flight">
                    <input name="NumberOfSeats" value="<?php echo $_POST['seats']; ?>" id="NumberOfSeats">
                    <input name="ArrivalFlightId" value="<?php echo $_POST["arrivalFlightId"]; ?>" id="flight">
                    <input name="Price" value="<?php echo $price; ?>" id="price">
                    <input name="ArrivalPrice" value="<?php echo $arrivalPrice; ?>" id="price">
                    <input name="payment" value="" id="payment">
                </div>
            </form>
            <?php if (isset($_POST["tripType"]) && $_POST["tripType"] == "2") { ?>
                <div>
                    <div class="seat-booking-container">
                        <div class="seat-heading">
                            <h3>
                                Arrival
                            </h3>
                        </div>
                        <div class="seat-booking seat-booking-heading">
                            <div>
                                <h3>

                                </h3>
                            </div>
                            <div>
                                <h3>

                                </h3>
                            </div>
                            <?php
                            foreach ($col as $c) {
                            ?>
                                <div>
                                    <h1>
                                        <?php echo $c; ?>
                                    </h1>
                                </div>
                                <?php
                                if ($c == "3") { ?>
                                    <div>
                                        <pre>        </pre>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                        <?php
                        foreach ($row as $r) {
                        ?>
                            <div class="seat-booking">
                                <div>
                                    <h3>
                                        <?php echo $r; ?>
                                    </h3>
                                </div>
                                (W)
                                <?php
                                foreach ($col as $c) {
                                ?>
                                    <h1>
                                        <?php if (in_array($r . $c, $arrivalSeats)) { ?>
                                            <i class="bi bi-file-x-fill" id="<?php echo "Arrival-" . $r . $c; ?>" style="cursor: not-allowed;"></i>
                                        <?php } else { ?>
                                            <i class="bi bi-file" id="<?php echo "Arrival-" . $r . $c; ?>" onclick="seatClicked('<?php echo 'Arrival-' . $r . $c; ?>', 'Arrival')"></i>
                                        <?php } ?>
                                    </h1>
                                    <?php if ($c == "3") { ?>
                                        <div>
                                            <pre>        </pre>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                (W)
                            </div>
                        <?php } ?>
                    </div>

                    <div class="seats-count">
                        <h4>
                            <b>Selected Seats:</b> <span id="selectedArrivalSeats">None</span>
                        </h4>
                    </div>
                </div>
        </div>
    <?php } ?>
    <div class="seat-details-container">
        <div class="seat-details">
            <div class="description">
                <h1>
                    <i class="bi bi-file-x-fill"></i>
                </h1>
                <h5>Not Available</h5>
            </div>
            <div class="description">
                <h1>
                    <i class="bi bi-file"></i>
                </h1>
                <h5>Vacant</h5>
            </div>
            <div class="description">
                <h1>
                    <i class="bi bi-file-fill"></i>
                </h1>
                <h5>Selected</h5>
            </div>
        </div>
        <button disabled class="btn primary" onclick="goToPayment()" id="payment-button">Proceed to Payment</button>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<script>
    $('.navigation').load('Navbar.php');
    var selectedSeats = [];
    var selectedArrivalSeats = [];

    function seatClicked(seat, type) {
        if ($(`#${seat}`).hasClass("bi-file-fill")) {
            $(`#${seat}`).removeClass("bi-file-fill");
            $(`#${seat}`).addClass("bi-file");
            if (type == 'Arrival') {
                selectedArrivalSeats = selectedArrivalSeats.filter(item => item !== seat.replace("Arrival-", ""));
            } else {
                selectedSeats = selectedSeats.filter(item => item !== seat);
            }
        } else if (type == 'Arrival' && selectedArrivalSeats.length != $('#NumberOfSeats').val()) {
            $(`#${seat}`).addClass("bi-file-fill");
            $(`#${seat}`).removeClass("bi-file");
            selectedArrivalSeats.push(seat.replace("Arrival-", ""));
        } else if (type == 'Departure' && selectedSeats.length != $('#NumberOfSeats').val()) {
            $(`#${seat}`).addClass("bi-file-fill");
            $(`#${seat}`).removeClass("bi-file");
            selectedSeats.push(seat);
        }
        if (selectedSeats.length == 0) {
            $('#selectedSeats').html("None");
        } else {
            $('#selectedSeats').html(`${selectedSeats.join(",")}`);
        }


        if (selectedArrivalSeats.length == 0) {
            $('#selectedArrivalSeats').html("None");
        } else {
            $('#selectedArrivalSeats').html(`${selectedArrivalSeats.join(",")}`);
        }

        if(selectedSeats.length == selectedArrivalSeats.length && selectedArrivalSeats.length == $('#NumberOfSeats').val()) {
            $('#payment-button').attr("disabled", false);
        }
        else {
            $('#payment-button').attr("disabled", true);
        }
    }

    function goToPayment() {
        // $('#NumberOfSeats').val(selectedSeats.length);
        $('#seats').val(`${selectedSeats.join(",")}`);
        $('#arrival-seats').val(`${selectedArrivalSeats.join(",")}`);
        document.getElementById("bookSeats").submit();
    }
</script>

<style>
    .booking-container {
        display: flex;
        align-items: center;
        justify-content: start;
        margin: 50px;
        flex-direction: row;
        border: 1px solid #1b2134;
        border-radius: 10px;
    }

    .seat-booking {
        width: 50%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .no-of-seats {
        margin-top: 20px;
    }

    .seats-count {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .seat-heading {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        margin: 10px;
        background-color: #1b2134;
        color: white;
        border-radius: 10px;
        margin-bottom: 30px;
    }

    .space {
        width: 40px;
    }

    .seat-booking h3 {
        width: 30px;
    }

    .seat-booking-heading h1 {
        width: 40px;
    }

    .seat-booking-container {
        border: 1px dotted #1b2134;
        padding: 40px;
        border-radius: 20px;
        margin: 50px;
    }

    i {
        cursor: pointer;
    }

    .seat-details {
        display: flex;
        align-items: start;
        justify-content: space-between;
        flex-direction: column;
        margin: 0px 100px;
    }


    .seat-details-container {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: row;
    }

    .description {
        display: flex;
        align-items: center;
        justify-content: start;
        flex-direction: row;
    }

    .description h5 {
        margin-left: 10px;
    }
</style>