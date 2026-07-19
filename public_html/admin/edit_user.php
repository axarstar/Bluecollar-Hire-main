<?php

include "../config/session.php";


$id = $_GET['id'];


$data = mysqli_query(
    $conn,

    "SELECT * FROM users WHERE id='$id'"

);


$user = mysqli_fetch_assoc($data);



if (isset($_POST['update'])) {


    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $role = $_POST['role'];



    mysqli_query(
        $conn,

        "UPDATE users SET

fullname='$name',
email='$email',
role='$role'

WHERE id='$id'"

    );



    header("Location: users.php");

    exit();
}


?>


<!DOCTYPE html>
<html>

<head>

    <title>Edit User</title>

    <link rel="stylesheet" href="../assets/css/style.css">

</head>


<body>


    <div class="form-container">


        <form method="POST">


            <h2>Edit User</h2>


            <input
                type="text"
                name="fullname"
                value="<?php echo $user['fullname']; ?>">



            <input
                type="email"
                name="email"
                value="<?php echo $user['email']; ?>">



            <select name="role">


                <option value="user">
                    User
                </option>


                <option value="admin">
                    Admin
                </option>


            </select>


            <button
                class="btn primary"
                name="update">

                Update

            </button>


        </form>


    </div>


</body>

</html>