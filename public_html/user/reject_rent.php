<?php

include "../config/session.php";


$id = $_GET['id'];


mysqli_query(
    $conn,

    "UPDATE rentals

SET status='rejected'

WHERE id='$id'"

);


header("Location:rental_requests.php");
