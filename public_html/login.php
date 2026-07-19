<?php

include "config/session.php";

$message = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];


    if (empty($email) || empty($password)) {

        $message = "Please enter email and password.";
    } else {


        $query = mysqli_query(
            $conn,
            "SELECT * FROM users WHERE email='$email'"
        );


        if (mysqli_num_rows($query) == 1) {

            $user = mysqli_fetch_assoc($query);


            if (password_verify($password, $user['password'])) {


                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['avatar'] = $user['avatar'];
                $_SESSION['role'] = $user['role'];


                if ($user['role'] == "admin") {

                    header("Location: admin/dashboard.php");

                } elseif ($user['role'] == "worker") {

                    header("Location: user/dashboard.php");

                } elseif ($user['role'] == "client") {

                    header("Location: user/dashboard.php");

                } else {

                    session_destroy();
                    $message = "Invalid account type.";
                }


                exit();
            } else {

                $message = "Wrong password.";
            }
        } else {

            $message = "Account not found.";
        }
    }
}

?>


<!DOCTYPE html>
<html>

<head>

    <title>Login - Bluecollar Hire</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 30px 20px;
        }

        .form-container form {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .1);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .form-container input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            box-sizing: border-box;
            transition: .3s;
            outline: none;
        }

        .form-container input:focus {
            border-color: #2b7a78;
            box-shadow: 0 0 5px rgba(13, 110, 253, .3);
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background: #2b7a78;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: .3s;
        }

        .btn:hover {
            background: #2b7a78;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .form-container p {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        .form-container p a {
            color: #2b7a78;
            text-decoration: none;
            font-weight: bold;
        }

        .form-container p a:hover {
            text-decoration: underline;
        }

        @media(max-width:500px) {

            .form-container form {
                padding: 25px;
            }

        }
    </style>

</head>


<body>


    <?php include "includes/navbar.php"; ?>


    <div class="form-container">


        <form method="POST">


            <h2>Welcome Back</h2>

            <p style="text-align:center; margin-top:-15px; margin-bottom:25px; color:#666;">
                Sign in to access your account.
            </p>


            <?php

            if ($message != "") {

                echo "<div class='error'>$message</div>";
            }

            ?>


            <input type="email" name="email" placeholder="Enter your email">


            <input type="password" name="password" placeholder="Enter your password">


            <button name="login" class="btn primary">

                Sign In

            </button>


            <p>
                Don't have an account yet?
                <a href="register.php">
                    Create Account
                </a>
            </p>


        </form>


    </div>


    <?php include "includes/footer.php"; ?>


</body>

</html>