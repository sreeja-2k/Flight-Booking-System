<?php
session_start();
include('./Helpers/DBConfig.php');
$errorMessage = "";
if ($upcoming = $mysqli->query("SELECT *, T.Price AS finalPrice, (SELECT Name FROM `airports` WHERE Id = Source) AS SourceAirport, (SELECT Name FROM `airports` WHERE Id = Destination) AS DestinationAirport FROM `tickets` T JOIN `flights` F ON F.Id = T.FlightId WHERE DateTime > CURDATE() AND UserId = ".$_SESSION['Id']."")) {
}

if ($completed = $mysqli->query("SELECT *, T.Price AS finalPrice, (SELECT Name FROM `airports` WHERE Id = Source) AS SourceAirport, (SELECT Name FROM `airports` WHERE Id = Destination) AS DestinationAirport FROM `tickets` T JOIN `flights` F ON F.Id = T.FlightId WHERE DateTime <= CURDATE()AND UserId = ".$_SESSION['Id']."")) {
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
            <div class="results-container-heading">
                <h3>
                    UpComing
                </h3>
            </div>
            <?php
            foreach ($upcoming as $row) {
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
                    <!-- <div class="result-item">
                        <h5>
                            <?php echo $row["Seats"]; ?>
                        </h5>
                    </div> -->
                    <div class="result-item">
                        <p>
                            <?php echo $row["DateTime"]; ?>
            </p>
                        <?php echo $row["Duration"]; ?>
                    </div>
                    <div class="result-item">
                        <p>
                            <?php echo $row["Code"]; ?>
                        <p>
                        
                    </div>
                    <div class="result-item">
                        <h5>
                            $<?php echo $row["finalPrice"]; ?>
                        </h5>
                    </div>
                </div>

            <?php
            }
            ?>

            <div class="results-container-heading">
                <h3>
                    Completed
                </h3>
            </div>

            <?php
            foreach ($completed as $row) {
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
                        <p>
                            <?php echo $row["DateTime"]; ?>
            </p>
                        <?php echo $row["Duration"]; ?>
                    </div>
                    <div class="result-item">
                        <p>
                            <?php echo $row["Code"]; ?>
                        </p>
                        
                    </div>
                    <div class="result-item">
                        <h5>
                            $<?php echo $row["finalPrice"]; ?>
                        </h5>
                    </div>
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
</script>

<style>
    .nav-MyTrips,
    .nav-MyTrips:hover {
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
        width: 1000px;
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
        width: 1000px;
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
</style>