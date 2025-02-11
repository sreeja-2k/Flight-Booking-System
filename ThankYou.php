<?php
session_start();
include('./Helpers/DBConfig.php');
$errorMessage = "";
if ($ticket = $mysqli->query("SELECT * FROM `tickets` WHERE id IN (" . $_GET["TicketId"] . ")")) {
    $tickets = explode(",", $_GET["TicketId"]);
    $noOfTickets = count($tickets);
    $tickets = $ticket->fetch_assoc();
    if ($noOfTickets == 2) {
        $arrivalTicket = $ticket->fetch_assoc();
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
    <div class="body-container">
        <div class="thankyou-container">
            <h1>
                <i class="bi bi-check-circle-fill"></i>
            </h1>
            <h1>
                Thank You!
            </h1>
            <h4>
                Your Ticket booked successfully!
            </h4>
            <div class="seat-heading" style="width: 100%;">
                <h3>
                    Departure
                </h3>
            </div>
            <h5>
                <b>Seats: </b><?php echo $tickets["Seats"]; ?>
            </h5>
            <h5>
                <b>Ticket Code: </b><?php echo $tickets["Code"]; ?>
            </h5>

            <?php
            if ($noOfTickets == 2) { ?>
                <div class="seat-heading" style="width: 100%;">
                    <h3>
                        Arrival
                    </h3>
                </div>
                <h5>
                    <b>Seats: </b><?php echo $arrivalTicket["Seats"]; ?>
                </h5>
                <h5>
                    <b>Ticket Code: </b><?php echo $arrivalTicket["Code"]; ?>
                </h5>

            <?php } ?>
            <p>Thank you for choosing Fly.com. Let's soar together!</p>
            <div class="action">
                <div>
                    <a href="./ContactUs.php">
                        <button class="btn primary" type="button">Contact Us</button>
                    </a>
                </div>
                <div>
                    <a href="./Faqs.php">
                        <button class="btn primary-outline" type="button">FAQs</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<script>
    $('.navigation').load('Navbar.php');
</script>

<style>
    .body-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 30px;
    }

    .thankyou-container {
        width: 700px;
        border: 1px dotted #1b2134;
        border-radius: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 30px;
    }

    i {
        color: green;
        font-size: 150px;
    }

    .action {
        width: 100%;
        margin-top: 30px;
        padding: 0px 200px;
        display: flex;
        align-items: center;
        justify-content: space-between;
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
    }

    .primary {
        width: 100%;
    }

    h5 {
        margin: 5px 0px;
    }
</style>