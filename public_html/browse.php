<?php

include "config/database.php";


$result = mysqli_query(
    $conn,
    "SELECT
worker_profiles.*,
users.name,
users.avatar,
categories.name AS category

FROM worker_profiles

JOIN users
ON worker_profiles.user_id = users.id

JOIN categories
ON worker_profiles.category_id = categories.id

WHERE worker_profiles.status='Approved'"
);


?>


<!DOCTYPE html>
<html>

<head>

    <title>Browse Workers | Bluecollar Hire</title>

    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7f7;
        }

        .dashboard {
            width: 90%;
            margin: 30px auto;
        }

        .dashboard h1 {
            text-align: center;
            color: #2B7A78;
            margin-bottom: 30px;
        }

        /* worker Grid */

        .worker-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        /* worker Card */

        .worker-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .1);
            transition: .3s;
        }

        .worker-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(43, 122, 120, .2);
        }

        /* Image */


        .avatar {

            width: 90px;
            height: 90px;

            margin: 20px auto;

            border-radius: 50%;

            background: #eef7f7;

            display: flex;

            justify-content: center;

            align-items: center;

            font-size: 48px;
        }

        .worker-card h3 {
            margin: 12px;
            font-size: 18px;
            color: #2B7A78;
        }

        .worker-card p {
            margin: 6px 12px;
            font-size: 14px;
            color: #555;
            line-height: 1.4;
        }

        /* View Button */

        .worker-card .btn {
            display: block;
            margin: 15px 12px;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            background: #2B7A78;
            color: #fff;
            border-radius: 6px;
            font-weight: bold;
            transition: .3s;
        }

        .worker-card .btn:hover {
            background: #205e5c;
        }

        /* Responsive */

        @media(max-width:768px) {

            .worker-container {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }

        }
    </style>

</head>


<body>


    <?php include "includes/navbar.php"; ?>


    <div class="dashboard">


        <h1>
            Find Skilled Workers
        </h1>


        <div class="worker-container">


            <?php


            if (mysqli_num_rows($result) > 0) {


                while ($worker = mysqli_fetch_assoc($result)) {


                    ?>


<div class="worker-card">

    <div class="avatar">

        <?= htmlspecialchars($worker['avatar']) ?>

    </div>


    <h3>

        <?= htmlspecialchars($worker['name']) ?>

    </h3>


    <p>

        Category:

        <?= htmlspecialchars($worker['category']) ?>

    </p>


    <p>

        💰 Price:

        Rs. <?= htmlspecialchars($worker['daily_rate']) ?>/day

    </p>


    <p>

        ⭐ Experience:

        <?= htmlspecialchars($worker['experience']) ?> Years

    </p>


    <p>

        🟢 Availability:

        <?= htmlspecialchars($worker['availability']) ?>

    </p>


    <p>

        📍 Address:

        <?= htmlspecialchars($worker['address']) ?>

    </p>


    <a class="btn primary" 
       href="worker.php?id=<?= $worker['id']; ?>">

        View Profile

    </a>


</div>

                    <?php

                }
            } else {


                echo "<h3>No workers available at the moment.</h3>";
            }


            ?>


        </div>


    </div>





</body>

</html>