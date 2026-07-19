<?php

include "../config/session.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$userQuery = mysqli_query($conn, "
SELECT *
FROM users
WHERE id='$user_id'
");

$user = mysqli_fetch_assoc($userQuery);

$worker = null;

if ($user['role'] == "worker") {

    $workerQuery = mysqli_query($conn, "
    SELECT
        worker_profiles.*,
        categories.name AS category_name
    FROM worker_profiles
    LEFT JOIN categories
    ON worker_profiles.category_id = categories.id
    WHERE worker_profiles.user_id='$user_id'
    ");

    if(mysqli_num_rows($workerQuery)>0){
        $worker = mysqli_fetch_assoc($workerQuery);
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Dashboard | Bluecollar Hire</title>

<link rel="stylesheet"
href="../assets/css/style.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, Helvetica, sans-serif;
    background:#f4f6f9;
}

.dashboard{

    width:95%;
    max-width:1300px;

    margin:35px auto;

    display:flex;

    gap:25px;

}

.sidebar{

    width:320px;

}

.profile-card{

    background:#fff;

    border-radius:12px;

    padding:25px;

    box-shadow:0 5px 15px rgba(0,0,0,.08);

    position:sticky;

    top:20px;

}

.avatar{

    width:90px;

    height:90px;

    margin:auto;

    display:flex;

    justify-content:center;

    align-items:center;

    border-radius:50%;

    background:#eef7f7;

    font-size:55px;

}

.profile-card h2{

    text-align:center;

    margin-top:15px;

    color:#2B7A78;

}

.profile-card p{

    margin-top:12px;

    color:#555;

}

.profile-card hr{

    margin:20px 0;

}

.menu a{

    display:block;

    text-decoration:none;

    color:#2B7A78;

    padding:12px 0;

    font-weight:bold;

    transition:.3s;

}

.menu a:hover{

    color:#205e5c;

}

.content{

    flex:1;

}

.welcome{

    background:#fff;

    border-radius:12px;

    padding:30px;

    box-shadow:0 5px 15px rgba(0,0,0,.08);

}

.welcome h1{

    color:#2B7A78;

    margin-bottom:10px;

}

.welcome p{

    color:#666;

    line-height:1.7;

}

.actions{

    display:grid;

    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));

    gap:20px;

    margin-top:30px;

}

.action{

    background:#2B7A78;

    color:#fff;

    text-decoration:none;

    padding:20px;

    text-align:center;

    border-radius:10px;

    transition:.3s;

}

.action:hover{

    background:#205e5c;

}

.summary{

    display:grid;

    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));

    gap:20px;

    margin-top:35px;

}

.box{

    background:#fff;

    border-radius:10px;

    padding:20px;

    box-shadow:0 5px 15px rgba(0,0,0,.08);

}

.box h3{

    color:#2B7A78;

    margin-bottom:15px;

}

.box p{

    margin:8px 0;

    color:#555;

}

.pending{

    color:#e67e22;

    font-weight:bold;

}

.approved{

    color:green;

    font-weight:bold;

}

.rejected{

    color:red;

    font-weight:bold;

}

@media(max-width:900px){

.dashboard{

flex-direction:column;

}

.sidebar{

width:100%;

}

.profile-card{

position:static;

}

}

</style>

</head>

<body>

<?php include "../includes/navbar.php"; ?>

<div class="dashboard">

<div class="sidebar">

    <div class="profile-card">

        <div class="avatar">
            <?= htmlspecialchars($user['avatar']) ?>
        </div>

        <h2>
            <?= htmlspecialchars($user['name']) ?>
        </h2>

        <p>
            <i class="fa-solid fa-envelope"></i>
            <?= htmlspecialchars($user['email']) ?>
        </p>

        <p>
            <i class="fa-solid fa-phone"></i>
            <?= htmlspecialchars($user['phone']) ?>
        </p>

        <p>
            <i class="fa-solid fa-user"></i>
            <?= ucfirst($user['role']) ?>
        </p>

        <hr>

        <div class="menu">

            <?php if($user['role']=="client"){ ?>

                <a href="../browse.php">
                    <i class="fa-solid fa-users"></i>
                    Browse Workers
                </a>

                <a href="../my_requests.php">
                    <i class="fa-solid fa-clipboard-list"></i>
                    My Requests
                </a>

                <a href="profile.php">
                    <i class="fa-solid fa-user-pen"></i>
                    Edit Profile
                </a>

            <?php } ?>



            <?php if($user['role']=="worker"){ ?>

                <?php if($worker==null){ ?>

                    <a href="create_worker_profile.php">
                        <i class="fa-solid fa-id-card"></i>
                        Create Worker Profile
                    </a>

                <?php }else{ ?>

                    <a href="my_profile.php">
                        <i class="fa-solid fa-user"></i>
                        My Profile
                    </a>

                    <a href="work_requests.php">
                        <i class="fa-solid fa-briefcase"></i>
                        Work Requests
                    </a>

                    <a href="edit_profile.php">
                        <i class="fa-solid fa-pen"></i>
                        Edit Worker Profile
                    </a>

                <?php } ?>

            <?php } ?>

            <a href="../logout.php">

                <i class="fa-solid fa-right-from-bracket"></i>

                Logout

            </a>

        </div>

    </div>

</div>

<div class="content">

    <div class="welcome">

        <h1>
            Welcome,
            <?= htmlspecialchars($user['name']) ?> 👋
        </h1>

        <?php if($user['role']=="client"){ ?>

            <p>
                Browse skilled workers, send work requests and manage all your
                hiring requests from one place.
            </p>

            <div class="actions">

                <a class="action" href="../browse.php">
                    <i class="fa-solid fa-users"></i><br><br>
                    Browse Workers
                </a>

                <a class="action" href="../my_requests.php">
                    <i class="fa-solid fa-clipboard-list"></i><br><br>
                    My Requests
                </a>

                <a class="action" href="profile.php">
                    <i class="fa-solid fa-user-pen"></i><br><br>
                    Edit Profile
                </a>

            </div>

            <div class="summary">

                <div class="box">

                    <h3>Account</h3>

                    <p><strong>Role:</strong> Client</p>

                    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

                    <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>

                </div>

                <div class="box">

                    <h3>Quick Tip</h3>

                    <p>
                        Browse workers by category and hire the worker that
                        best matches your work.
                    </p>

                </div>

            </div>

        <?php } ?>



        <?php if($user['role']=="worker"){ ?>

            <?php if($worker==null){ ?>

                <p>
                    Your worker profile has not been created yet.
                    Create it before clients can hire you.
                </p>

                <div class="actions">

                    <a class="action"
                       href="create_worker_profile.php">

                        <i class="fa-solid fa-id-card"></i><br><br>

                        Create Worker Profile

                    </a>

                </div>

            <?php }else{ ?>

                <p>
                    Manage your worker profile and receive work requests from clients.
                </p>

                <div class="actions">

                    <a class="action"
                       href="my_profile.php">

                        <i class="fa-solid fa-user"></i><br><br>

                        My Profile

                    </a>

                    <a class="action"
                       href="work_requests.php">

                        <i class="fa-solid fa-briefcase"></i><br><br>

                        Work Requests

                    </a>

                    <a class="action"
                       href="edit_profile.php">

                        <i class="fa-solid fa-pen"></i><br><br>

                        Edit Profile

                    </a>

                </div>

                <div class="summary">

                    <div class="box">

                        <h3>Profile Information</h3>

                        <p>
                            <strong>Category:</strong>
                            <?= htmlspecialchars($worker['category_name']) ?>
                        </p>

                        <p>
                            <strong>Experience:</strong>
                            <?= $worker['experience'] ?> Years
                        </p>

                        <p>
                            <strong>Daily Rate:</strong>
                            Rs. <?= $worker['daily_rate'] ?>
                        </p>

                    </div>

                    <div class="box">

                        <h3>Availability</h3>

                        <p>

                            <strong>Status:</strong>

                            <?php

                            if($worker['status']=="Approved"){

                                echo "<span class='approved'>Approved</span>";

                            }elseif($worker['status']=="Rejected"){

                                echo "<span class='rejected'>Rejected</span>";

                            }else{

                                echo "<span class='pending'>Pending Approval</span>";

                            }

                            ?>

                        </p>

                        <p>

                            <strong>Work:</strong>

                            <?= htmlspecialchars($worker['availability']) ?>

                        </p>

                        <p>

                            <strong>Address:</strong>

                            <?= htmlspecialchars($worker['address']) ?>

                        </p>

                    </div>

                    <div class="box">

                        <h3>About You</h3>

                        <p>

                            <?= nl2br(htmlspecialchars($worker['bio'])) ?>

                        </p>

                    </div>

                </div>

            <?php } ?>

        <?php } ?>

    </div>

</div>


</div>

</body>

</html>