<?php

include "../config/session.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['role'] != "worker") {
    header("Location: dashboard.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: work_requests.php");
    exit();
}

$request_id = (int)$_GET['id'];

$worker_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| Check request belongs to logged in worker
|--------------------------------------------------------------------------
*/

$request = mysqli_query($conn, "
SELECT *
FROM work_requests
WHERE id='$request_id'
AND worker_id='$worker_id'
");

if (mysqli_num_rows($request) == 0) {

    die("Work request not found.");

}

/*
|--------------------------------------------------------------------------
| Accept Request
|--------------------------------------------------------------------------
*/

mysqli_query($conn, "
UPDATE work_requests
SET status='Accepted'
WHERE id='$request_id'
");

$_SESSION['success'] = "Work request accepted successfully.";

header("Location: work_requests.php");
exit();

?>