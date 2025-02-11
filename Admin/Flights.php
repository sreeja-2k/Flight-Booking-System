<?php
session_start();
include('../Helpers/DBConfig.php');
$errorMessage = "";

if (isset($_POST["FlightId"])) {
    $query = "DELETE FROM `flights` WHERE Id = " . $_POST["FlightId"] . "";
    $mysqli->query($query);
}
if ($flights = $mysqli->query("SELECT F.Id, F.Name, F.DateTime, F.Duration, F.Source, F.Destination, F.Price, T.Price AS finalPrice, (SELECT Name FROM `airports` WHERE Id = Source) AS SourceAirport, (SELECT Name FROM `airports` WHERE Id = Destination) AS DestinationAirport FROM `tickets` T RIGHT JOIN `flights` F ON F.Id = T.FlightId WHERE T.Status = 1 OR T.Status IS NULL GROUP BY F.Id, F.Name, F.DateTime, F.Duration, F.Source, F.Destination, F.Price;")) {
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
    <div class="container">
        <div class="body-container">
        <?php if (isset($_POST["FlightId"])){ ?> 

            
<div class="alert alert-danger" role="alert">
         Flight Deleted Successfully!
</div>
    <?php } ?>
            <div class="results-container-heading">
                <h3>
                    Flights
                </h3>
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
                            <?php echo $row["SourceAirport"]; ?>
                        </h5>
                    </div>
                    <div class="result-item">
                        <h5>
                            <i class="bi bi-arrow-right"></i>
                        </h5>
                    </div>
                    <div class="result-item">
                        <h5>
                            <?php echo $row["DestinationAirport"]; ?>
                        </h5>
                    </div>
                    <div class="result-item">
                        <h5>
                            <?php echo $row["DateTime"]; ?>
                        </h5>
                        <?php echo $row["Duration"]; ?>
                    </div>
                    <form action="Flights.php" method="post">
                        <div class="result-item">
                            <?php if ($row["finalPrice"] == null) { ?>
                                <button type="submit" class="btn btn-outline-danger">
                                    Delete
                                </button>
                                <input type="text" name="FlightId" value="<?php echo $row["Id"] ?>" style="display:none">
                            <?php } else { ?>
                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-title="Can't Delete the Flight as the tickets in the flight are already booked.">

                                    <button type="button" disabled class="btn btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                                        Delete
                                    </button>
                                </span>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>

<script>
    $('.navigation').load('Navbar.php');
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>

<style>
    .nav-Flights,
    .nav-Flights:hover {
        background-color: #2d3242;
        color: white;
    }

    .body-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .results-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-direction: row;
        width: 100%;
        margin-top: 10px;
        padding: 20px;
        border: 1px dotted #1b2134;
        border-radius: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        transition: 0.3s;
    }

    .result-item {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .results-container-heading {
        margin-top: 20px;
        padding: 20px 30px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: row;
        background-color: #1b2134;
        color: white;
        border-radius: 10px;
    }

    .icons {
        color: white;
    }

    .logout-button,
    .logout-button:hover {
        color: red;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid red;
    }
</style>