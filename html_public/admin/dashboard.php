<?php

include "../config/session.php";


if (!isset($_SESSION['user_id']) || $_SESSION['role'] != "admin") {

    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>


<body>


    <nav>

        <div class="logo">
            ToolShare Admin
        </div>


        <ul>

            <li>
                <a href="dashboard.php">
                    Dashboard
                </a>
            </li>


            <li>
                <a href="pending_tools.php">
                    Pending Tools
                </a>
            </li>


            <li>
                <a href="users.php">
                    Users
                </a>
            </li>


            <li>
                <a href="../logout.php">
                    Logout
                </a>
            </li>


        </ul>

    </nav>



    <div class="dashboard">


        <h1>
            Welcome Admin
        </h1>


        <div class="dashboard-card">


            <h2>
                Manage ToolShare
            </h2>


            <p>
                Approve tools and manage users from here.
            </p>


            <a class="btn primary"
                href="pending_tools.php">

                Review Tools

            </a>


        </div>


    </div>


</body>

</html>