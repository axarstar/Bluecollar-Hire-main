<?php

include "../config/session.php";


$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn, "

SELECT

work_requests.*,

users.name,

users.avatar

FROM work_requests

JOIN users

ON work_requests.client_id = users.id

WHERE work_requests.worker_id='$user_id'

ORDER BY work_requests.id DESC

");

?>


<!DOCTYPE html>
<html>

<head>

    <title>Work Requests</title>

    <link rel="stylesheet" href="../assets/css/style.css">
    <h1 style="text-align:center;margin-top:30px;color:#2B7A78;">
    Work Requests
</h1>
    <style>
        .request-container {
            width: 90%;
            margin: 30px auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .request-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
            transition: .3s;
        }

        .request-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(43, 122, 120, .2);
        }

        .request-card h3 {
            margin-top: 0;
            color: #2B7A78;
        }

        .request-card p {
            margin: 10px 0;
            color: #555;
        }

        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .status.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status.approved {
            background: #d1e7dd;
            color: #146c43;
        }

        .status.rejected {
            background: #f8d7da;
            color: #b02a37;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .approve-btn,
        .reject-btn {
            flex: 1;
            text-align: center;
            text-decoration: none;
            color: #fff;
            padding: 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        .approve-btn {
            background: #2B7A78;
        }

        .approve-btn:hover {
            background: #205e5c;
        }

        .reject-btn {
            background: #dc3545;
        }

        .reject-btn:hover {
            background: #b02a37;
        }
    </style>

</head>


<body><?php include "includes/navbar.php"; ?>



    <div class="request-container">

        <?php

        if (mysqli_num_rows($result) > 0) {

            while ($r = mysqli_fetch_assoc($result)) {

        ?>

                <div class="request-card">

    <div style="font-size:45px;text-align:center;">
        <?= $r['avatar']; ?>
    </div>

    <h3>

        <?= htmlspecialchars($r['name']); ?>

    </h3>

    <p>

        <strong>Location:</strong>

        <?= htmlspecialchars($r['location']); ?>

    </p>

    <p>

        <strong>Phone:</strong>

        <?= htmlspecialchars($r['phone']); ?>

    </p>

    <p>

        <strong>Work Details:</strong><br>

        <?= nl2br(htmlspecialchars($r['work_details'])); ?>

    </p>

    <p>

        <strong>Status:</strong>

        <span class="status <?= strtolower($r['status']); ?>">

            <?= $r['status']; ?>

        </span>

    </p>

    <p>

        <strong>Requested:</strong>

        <?= date("d M Y", strtotime($r['created_at'])); ?>

    </p>

<?php if($r['status']=="Pending"){ ?>

<div class="actions">

<a
href="accept_request.php?id=<?= $r['id']; ?>"
class="approve-btn">

Accept Job

</a>

<a
href="reject_request.php?id=<?= $r['id']; ?>"
class="reject-btn">

Decline Job

</a>

</div>

<?php } ?>

</div>

        <?php

            }
        } else {

            echo "<h3 style='text-align:center;'>No work requests yet.</h3>";
        }

        ?>

    </div>


</body>

</html>