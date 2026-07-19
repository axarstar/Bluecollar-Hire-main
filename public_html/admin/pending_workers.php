<?php

include "../config/session.php";


if ($_SESSION['role'] != "admin") {

    header("Location: ../login.php");
    exit();
}


$result = mysqli_query(
    $conn,

    "SELECT tools.*, users.fullname
FROM tools
JOIN users
ON tools.user_id=users.id
WHERE tools.status='pending'"

);


?>


<!DOCTYPE html>
<html>

<head>

    <title>Pending Tools</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>


<body>


    <h1>
        Pending Tools
    </h1>


    <div class="tool-container">


        <?php


        while ($tool = mysqli_fetch_assoc($result)) {


        ?>


            <div class="tool-card">


                <img src="../uploads/tools/<?php echo $tool['image']; ?>">


                <h3>
                    <?php echo $tool['tool_name']; ?>
                </h3>


                <p>
                    Owner:
                    <?php echo $tool['fullname']; ?>
                </p>


                <p>
                    Rs.
                    <?php echo $tool['price_per_day']; ?>/day
                </p>



                <a class="btn primary"
                    href="approve_tool.php?id=<?php echo $tool['id']; ?>">

                    Approve

                </a>



                <a class="delete-btn"
                    href="reject_tool.php?id=<?php echo $tool['id']; ?>">

                    Reject

                </a>


            </div>


        <?php

        }

        ?>


    </div>


</body>

</html>