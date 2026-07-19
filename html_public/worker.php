<?php

include "config/database.php";


if (!isset($_GET['id'])) {

    header("Location: browse.php");
    exit();
}


$id = $_GET['id'];


$query = mysqli_query($conn, "

SELECT

worker_profiles.*,

users.name,

users.avatar,

categories.name AS category

FROM worker_profiles

JOIN users

ON worker_profiles.user_id = users.id

JOIN categories

ON worker_profiles.category_id = categories.id

WHERE worker_profiles.id='$id'

AND worker_profiles.status='Approved'

");

if (mysqli_num_rows($query) == 0) {

    echo "worker not found";
    exit();
}


$worker = mysqli_fetch_assoc($query);

?>


<!DOCTYPE html>
<html>

<head>


    <title>

        <?= htmlspecialchars($worker['name']) ?>

    </title>

    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7f7;
        }

.worker-details {

    width: 100%;

    background: #fff;

    border-radius: 12px;

    box-shadow: 0 5px 15px rgba(0,0,0,.1);

    display: flex;

    align-items: center;

    gap: 20px;

    padding: 20px;

    box-sizing: border-box;

}
.worker-detail {
    flex: 1;
}

.avatar {

    margin=auto;
    width: 80px;
    height: 80px;

    border-radius: 50%;

    background: #eef7f7;

    display: flex;

    justify-content: center;

    align-items: center;

    font-size: 45px;

    flex-shrink: 0;
}
       .worker-info {
            flex: 1;
        }

.worker-info h1 {
    color: #2B7A78;
    margin: 0 0 10px;
    font-size: 24px;
}

.worker-info p {
    font-size: 14px;
    color: #555;
    line-height: 1.5;
    margin: 6px 0;
}

        .worker-info h2 {
            color: #2B7A78;
            margin: 20px 0;
        }

        .available,
        .booked {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .available {
            background: #d8f3f2;
            color: #2B7A78;
        }

        .booked {
            background: #f8d7da;
            color: #b02a37;
        }

.btn {

    display:block;

    text-align:center;

    margin-top:15px;

    padding:10px;

}
        .btn:hover {
            background: #205e5c;
        }

        .worker-detail {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }

       
    </style>

</head>


<body>


    <?php include "includes/navbar.php"; ?>


    <div class="worker-details">


        <div class="avatar">

            <?= htmlspecialchars($worker['avatar']) ?>

        </div>



        <div class="worker-detail">


            <h1>
                <?= htmlspecialchars($worker['name']) ?>
            </h1>


            <p>
                Category:
                <?= htmlspecialchars($worker['category']) ?>
            </p>


            <p>
                <?= nl2br(htmlspecialchars($worker['bio'])) ?>
            </p>


            <h2>
                Rs. 

                <?= $worker['daily_rate']; ?>/day
            </h2>


            <p>

                <strong>Experience:</strong>

                <?= $worker['experience']; ?>

                Years

            </p>

            <p>
                <strong>Status:</strong>

                <?php if ($worker['availability'] == "Available") { ?>

                    <span class="available">Available</span>

                <?php } else { ?>

                    <span class="booked">Busy</span>

                <?php } ?>

            <p>

                <strong>Address:</strong>

                <?= htmlspecialchars($worker['address']) ?>

            </p>

            

    
            </p>



            <?php

            if (!isset($_SESSION['user_id'])) {

                ?>

                <a class="btn" href="login.php">

                    Login to Hire

                </a>

                <?php

            } elseif ($_SESSION['role'] == "client") {

                ?>

                <a class="btn" href="hire_worker.php?id=<?= $worker['id'] ?>">

                    Hire Worker

                </a>

                <?php

            } elseif ($_SESSION['role'] == "worker") {

                ?>

                <button class="btn" disabled>

                    Workers Cannot Hire

                </button>

                <?php

            }
            ?>


        </div>


    </div>


</body>

</html>