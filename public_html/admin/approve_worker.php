<?php

include "../config/session.php";


if ($_SESSION['role'] != "admin") {

    header("Location: ../login.php");
    exit();
}


$id = $_GET['id'];


mysqli_query(
    $conn,

    "UPDATE tools
SET status='approved'
WHERE id='$id'"

);


header("Location: pending_tools.php");

exit();
