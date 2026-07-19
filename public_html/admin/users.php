<?php

include "../config/session.php";


if ($_SESSION['role'] != "admin") {

    header("Location: ../login.php");
    exit();
}


$result = mysqli_query(
    $conn,

    "SELECT * FROM users"

);


?>


<!DOCTYPE html>
<html>

<head>

    <title>Manage Users</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>


<body>


    <h1>
        Manage Users
    </h1>


    <table class="user-table">


        <tr>

            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>

        </tr>


        <?php


        while ($user = mysqli_fetch_assoc($result)) {


        ?>


            <tr>

                <td>
                    <?php echo $user['id']; ?>
                </td>


                <td>
                    <?php echo $user['fullname']; ?>
                </td>


                <td>
                    <?php echo $user['email']; ?>
                </td>


                <td>
                    <?php echo $user['role']; ?>
                </td>


                <td>


                    <a class="edit-btn"
                        href="edit_user.php?id=<?php echo $user['id']; ?>">

                        Edit

                    </a>



                    <a class="delete-btn"
                        href="delete_user.php?id=<?php echo $user['id']; ?>"
                        onclick="return confirm('Delete this user?')">

                        Delete

                    </a>


                </td>


            </tr>


        <?php

        }

        ?>


    </table>


</body>

</html>