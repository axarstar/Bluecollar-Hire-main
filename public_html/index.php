<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueCollar-Hire</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>


<body>

    <?php include "includes/navbar.php"; ?>

    <section class="hero">

        <div class="hero-text">

            <h1>Find Trusted Skilled Workers<br>Near You</h1>

            <p>
                Connect with experienced plumbers, electricians, carpenters,
                painters, cleaners, mechanics, and other skilled professionals
                for your home or business. Browse verified worker profiles and
                hire with confidence.
            </p>

            <div class="hero-btns">
                <a href="browse.php" class="btn primary">
                    Find Workers
                </a>

                <a href="register.php" class="btn secondary">
                    Join Now
                </a>
            </div>

        </div>

        <div class="hero-image">

            <img src="assets/images/workers.png" alt="Skilled Workers">

        </div>

    </section>


    <section class="features">

        <h2>Why Choose Our Platform?</h2>

        <div class="cards">

            <div class="card">
                <i class="fa-solid fa-user-check"></i>
                <h3>Verified Workers</h3>
                <p>Browse trusted worker profiles approved by the administrator.</p>
            </div>

            <div class="card">
                <i class="fa-solid fa-briefcase"></i>
                <h3>Easy Hiring</h3>
                <p>Find skilled workers by category and send work requests in minutes.</p>
            </div>

            <div class="card">
                <i class="fa-solid fa-location-dot"></i>
                <h3>Local Services</h3>
                <p>Hire skilled professionals available in your area for everyday jobs.</p>
            </div>

        </div>

    </section>


    <?php include "includes/footer.php"; ?>

    <script src="assets/js/script.js"></script>

</body>

</html>