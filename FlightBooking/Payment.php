<?php
session_start();
include('./mail.php');
include('./Helpers/DBConfig.php');
$errorMessage = "";

if (isset($_POST["TicketId"])) {
    $query = "UPDATE `tickets` SET Status = 1 WHERE Id IN (" . $_POST["TicketId"] . ")";
    $mysqli->query($query);
    $mail->Subject = "Thank you for choosing Fly.com!";
    $mail->Body = '<!doctype html><html lang="en-US"><head><meta content="text/html; charset=utf-8" http-equiv="Content-Type"><title>Reset Password Email Template</title><meta name="description" content="Reset Password Email Template."><style type="text/css">a:hover{text-decoration:underline!important}</style></head><body marginheight="0" topmargin="0" marginwidth="0" style="margin:0;background-color:#f2f3f8" leftmargin="0"><table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"><td><table style="background-color:#f2f3f8;max-width:670px;margin:0 auto" width="100%" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td style="height:80px">&nbsp;</td></tr><tr><td style="text-align:center"><h1>Fly.com</h1></td></tr><tr><td style="height:20px">&nbsp;</td></tr><tr><td><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:670px;background:#fff;border-radius:3px;text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06)"><tr><td style="height:40px">&nbsp;</td></tr><tr><td style="padding:0 35px"><svg xmlns="http://www.w3.org/2000/svg" style="color:green" width="150" height="150" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg><h1 style="color:#1e1e2d;font-weight:500;margin:0;font-size:32px;font-family:Rubik,sans-serif">Thank you for Choosing Fly.com.</h1><h1>Let\'s soar together!</h1><a href="'.$baseURL.'MyTrips.php" style="background:#1b2134;text-decoration:none!important;font-weight:500;margin-top:35px;color:#fff;text-transform:uppercase;font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px">You can Find your Tickets here</a></td></tr><tr><td style="height:40px">&nbsp;</td></tr></table></td><tr><td style="height:20px">&nbsp;</td></tr></table></td></table></body></html>';
    $mail->addAddress($_SESSION['email']);
    $mail->send();
    header('Location: ./ThankYou.php?TicketId=' . $_POST['TicketId']);
}
$arrivalTicketPrice = 0;
if (isset($_GET["TicketId"])) {
    $tickets = explode(",", $_GET["TicketId"]);
    $noOfTickets = count($tickets);

    if ($ticketDetails = $mysqli->query("SELECT *, T.Price AS finalPrice, (SELECT Name FROM `airports` WHERE Id = Source) AS SourceAirport, (SELECT Name FROM `airports` WHERE Id = Destination) AS DestinationAirport  FROM `tickets` T JOIN `flights` F ON f.Id = T.FlightId WHERE T.Id IN (" . $_GET['TicketId'] . ")")) {
        $ticket = $ticketDetails->fetch_assoc();
        $ticketPrice = $ticket["finalPrice"];
        if ($noOfTickets == 2) {
            $arrivalTicket = $ticketDetails->fetch_assoc();
            $arrivalTicketPrice = $arrivalTicket["finalPrice"];
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
</head>

<body>
    <div class="navigation"></div>
    <div class="body-container">
        <div class="ticketDetails">
            <div class="ticket-heading background-primary">
                <h3>
                    Ticket Details
                </h3>
            </div>
            <div class="details-containers">
                <div class="ticketDetails-container">
                    <div class="ticket-heading">
                        <h3>
                            Departure
                        </h3>
                    </div>
                    <div class="ticket-detail">
                        <h5>Price: </h5> <span>$<?php echo $ticket["finalPrice"]; ?></span>
                    </div>
                    <div class="ticket-detail">
                        <h5>Source: </h5> <span><?php echo $ticket["SourceAirport"]; ?></span>
                    </div>
                    <div class="ticket-detail">
                        <h5>Destination: </h5> <span><?php echo $ticket["DestinationAirport"]; ?></span>
                    </div>
                    <div class="ticket-detail">
                        <h5>Date Of Journey: </h5> <span><?php echo $ticket["DateTime"]; ?></span>
                    </div>
                </div>
                <?php if ($noOfTickets == 2) { ?>
                    <div class="ticketDetails-container">
                        <div class="ticket-heading">
                            <h3>
                                Arrival
                            </h3>
                        </div>
                        <div class="ticket-detail">
                            <h5>Price: </h5> <span>$<?php echo $arrivalTicket["finalPrice"]; ?></span>
                        </div>
                        <div class="ticket-detail">
                            <h5>Source: </h5> <span><?php echo $arrivalTicket["SourceAirport"]; ?></span>
                        </div>
                        <div class="ticket-detail">
                            <h5>Destination: </h5> <span><?php echo $arrivalTicket["DestinationAirport"]; ?></span>
                        </div>
                        <div class="ticket-detail">
                            <h5>Date Of Journey: </h5> <span><?php echo $arrivalTicket["DateTime"]; ?></span>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="ticket-heading-price">
                <h3>
                    Total Amount:
                    <?php echo $ticketPrice + $arrivalTicketPrice; ?>
                </h3>
            </div>
        </div>
        <div class="payment-container">
            <form action="Payment.php" method="post" class="login-form" id="paymentForm">
                <h2 class="heading">
                    Payment
                </h2>
                <div class="input-group input-item">
                    <div class="input-div">
                        <input required name="cardNumber" id="cardNumber" type="number" minlength="16" maxlength="16" class="form-control" placeholder="Card Number" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <span id="cardNumber-validation"></span>
                </div>
                <div class="input-group input-item">
                    <div class="input-div">
                        <input type="text" name="cardHolderName" id="cardHolderName" class="form-control" placeholder="Card Holder Name" aria-label="CardHolderName" aria-describedby="basic-addon1">
                    </div>
                    <span id="cardHolderName-validation"></span>
                </div>
                <div class="row">
                    <div class="input-group input-item col">
                        <div>
                            <input type="text" maxlength="7" name="expiry" id="expiry" class="form-control" placeholder="MM/YYYY" aria-label="Expiry" aria-describedby="basic-addon1">
                        </div>
                        <span id="expiry-validation"></span>
                    </div>
                    <div class="input-group input-item col">
                        <div class="">
                            <input type="number" name="cvv" id="cvv" class="form-control" placeholder="CVV" aria-label="CVV" aria-describedby="basic-addon1">
                        </div>
                        <span id="cvv-validation"></span>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="button" onclick="validate()" class="btn primary action-button input-item">Pay</button>
                </div>
                <div id="trip" style="display:none">
                    <input name="TicketId" value="<?php echo $_GET["TicketId"]; ?>" id="seats">
                </div>
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
        var cardNumber = $('#cardNumber').val();
        var cardHolderName = $('#cardHolderName').val();
        var expiry = $('#expiry').val();
        var cvv = $('#cvv').val();
        var isValid = true;
        if (cardNumber.length == 0) {
            $('#cardNumber-validation').html('Name is required!');
            $('#cardNumber-validation').addClass('invalid');
            isValid &= false;
        } else if (cardNumber.length != 16) {
            $('#cardNumber-validation').html('Card Number must be 16 digit!');
            $('#cardNumber-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#cardNumber-validation').html('');
        }

        if (cardHolderName.length == 0) {
            $('#cardHolderName-validation').html('Card Holder Name is required!');
            $('#cardHolderName-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#cardHolderName-validation').html('');
        }

        const d = new Date();
        if (expiry.length == 0) {
            $('#expiry-validation').html('Expiry is required!');
            $('#expiry-validation').addClass('invalid');
            isValid &= false;
        } else if (expiry.length != 7 || !expiry.includes("/")) {
            $('#expiry-validation').html('Expiry is invalid!');
            $('#expiry-validation').addClass('invalid');
            isValid &= false;
        } else if (parseInt(expiry.split("/")[0]) < d.getMonth() + 1 || parseInt(expiry.split("/")[1]) < d.getFullYear()) {
            $('#expiry-validation').html('Expiry is invalid!');
            $('#expiry-validation').addClass('invalid');
            isValid &= false;
            console.log('Expiry is invalid!')
        } else {
            $('#expiry-validation').html('');
        }

        if (cvv.length == 0) {
            $('#cvv-validation').html('CVV is required!');
            $('#cvv-validation').addClass('invalid');
            isValid &= false;
        } else if (cvv.length != 3) {
            $('#cvv-validation').html('CVV be 3 digit!');
            $('#cvv-validation').addClass('invalid');
            isValid &= false;
        } else {
            $('#cvv-validation').html('');
        }

        if (isValid)
            document.getElementById("paymentForm").submit();
    }
</script>

<style>
    .nav-About,
    .nav-About:hover {
        background-color: #2d3242;
        color: white;
    }

    .body-container {
        display: flex;
        align-items: center;
        justify-content: start;
        flex-direction: column;
        padding: 30px;
        background-image: url("./Assets/C4.jpg");
        height: 1000px;
        background-size: cover;
    }

    .payment-container {
        display: flex;
        padding: 30px;
        width: 500px;
        flex-direction: column;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        background-color: white;
        border-radius: 10px;
    }

    .ticketDetails-container {
        display: flex;
        padding: 30px;
        width: 500px;
        flex-direction: column;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
        margin: 10px;
        background-color: white;
        border-radius: 10px;
    }

    .input-div {
        width: 100%;
    }

    .heading {
        justify-content: center;
        display: flex;
    }

    .input-item {
        margin-bottom: 5px;
        width: 100%;
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

    .ticket-detail {
        display: flex;
        flex-direction: row;
        padding: 5px;
    }

    .ticketDetails {
        display: flex;
        flex-direction: column;
        padding: 5px;
        margin: 20px;
    }

    .ticket-heading {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        margin: 10px;
        background-color: #1b2134;
        color: white;
        border-radius: 10px;
    }

    .ticket-heading-price {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        margin: 10px;
        color: white;
    }

    .details-containers {
        display: flex;
        flex-direction: row;
    }

    .background-primary {
        background-color: #1b2134;
        border-radius: 5px;
        color: white;
    }
</style>