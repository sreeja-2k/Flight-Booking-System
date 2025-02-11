<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="navigation"></div>
    <div class="container">
        <div class="body-container">
            <div class="col-item">
                <img src="./Assets/flight6.jpg" alt="">
            </div>
            <div class="col-item">
                <div class="contact-item">
                    <i class="bi bi-telephone-fill"></i>
                    <b>General Inquiries:</b>
                    <p>Reach us at <a href="">info@fly.com</a><br>and we will get back to you asap.</p>
                </div>
                <div class="contact-item">
                    <i class="bi bi-telephone-fill"></i>
                    <b>Willing to work at Fly.com?</b>
                    <p>Send us an email at <a href="">careers@fly.com</a></p>
                </div>
                <div class="contact-item">
                    <i class="bi bi-telephone-fill"></i>
                    <b>Onboard as an Affiliate:</b>
                    <p>Reach us at <a href="">affiliate@fly.com</a></p>
                </div>
                <div class="social-network">
                    <i class="bi bi-facebook icons"></i>
                    <i class="bi bi-instagram icons"></i>
                    <i class="bi bi-twitter icons"></i>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>

<script>
    $('.navigation').load('Navbar.php');
</script>


<style>
    .nav-Contact,
    .nav-Contact:hover {
        background-color: #2d3242;
        color: white;
    }

    .body-container {
        margin-top: 50px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    img {
        width: 100%;
        height: 500px;
        border-radius: 20px;
    }

    .col-item {
        margin: 20px;
    }

    a {
        color: #1b2134;
    }

    .contact-item {
        margin-bottom: 30px;
    }

    .icons {
        font-size: 30px;
        color: #1b2134;
        margin-right: 20px;
    }

    .social-network {
        display: flex;
        justify-content: center;
    }
</style>