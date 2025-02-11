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
        <div class="row details">
            <div class="col details-heading">
                <h2>
                    About Fly.com
                </h2>
                <p>
                    At Fly.com, we're passionate about connecting people with the world, one flight at a time. Our mission is to make travel accessible and enjoyable for everyone, and we do this by providing a user-friendly platform that simplifies the flight booking process.
                </p>
            </div>
            <div class="col details-heading">
                <h2>
                    Why Choose Fly.com?
                </h2>
                <p>
                    At Fly.com, we're passionate about connecting people with the world, one flight at a time. Our mission is to make travel accessible and enjoyable for everyone, and we do this by providing a user-friendly platform that simplifies the flight booking process.
                </p>
            </div>
        </div>
        <div class="row details">
            <div class="col details-heading">
                <h2>
                    Our Story
                </h2>
                <p>
                    Fly.com was founded by a team of travel enthusiasts who shared a common vision: to create a website that would transform the way people book flights. We've combined our love for travel with our technical expertise to bring you a platform that's as exciting and dynamic as the destinations you can explore.
                </p>
            </div>
            <div class="col details-heading">
                <h2>
                    Join Us on Your Travel Journey
                </h2>
                <p>
                    Whether you're a frequent flyer or planning your first adventure, Fly.com is here to be your trusted travel companion. We're excited to be a part of your journey and look forward to helping you discover the world.

                    Thank you for choosing Fly.com. Let's soar together!
                </p>
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
    body {
        background-image: url("./Assets/flight7.jpg");
        background-size: cover;
    }
    .nav-About,
    .nav-About:hover {
        background-color: #2d3242;
        color: white;
    }

    img {
        width: 100%;
    }

    .body-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 50px;
        flex-direction: column;
    }

    .details {
        width: 1300px;
        padding: 50px;
        margin-bottom: 30px;
    }

    .details img {
        border-radius: 30px;
    }

    .details-heading {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        border: 1px solid #2d3242;
        border-radius: 30px;
        margin: 30px;
        padding: 30px;
    }
</style>