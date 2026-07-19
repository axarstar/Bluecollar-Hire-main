<?php
include "config/session.php";

$message = "";
$name = "";
$role = "";
$avatar = "";
$email = "";
$phone = "";
$password = "";
$confirm = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name'] ?? "");
    $role = $_POST['role'] ?? "";
    $avatar = $_POST['avatar'] ?? "";
    $email = trim($_POST['email'] ?? "");
    $phone = trim($_POST['phone'] ?? "");
    $password = $_POST['password'] ?? "";
    $confirm = $_POST['confirm'] ?? "";

    if (
        empty($name) ||
        empty($email) ||
        empty($phone) ||
        empty($password) ||
        empty($confirm) ||
        empty($role) ||
        empty($avatar)
    ) {
        $message = "Please fill all fields.";
    } elseif ($password != $confirm) {
        $message = "Passwords do not match.";
    } else {

        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

        if (mysqli_num_rows($check) > 0) {
            $message = "Email already exists.";
        } elseif (!in_array($role, ['client', 'worker'])) {
            $message = "Invalid account type.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($conn, "INSERT INTO users
(name,email,phone,password,role,avatar)
VALUES
('$name','$email','$phone','$hash','$role','$avatar')");

            header("Location: login.php?registered=1");
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Register | Bluecollar Hire</title>

    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
        }

        .form-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
        }

        .form-container form {
            width: 100%;
            max-width: 420px;
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
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
            outline: none;
            transition: .3s;
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
            font-size: 16px;
            cursor: pointer;
            transition: .3s;
        }

        .primary {
            background: #2b7a78;
            color: #fff;
        }

        .primary:hover {
            background: #2b7a78;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-container p {
            text-align: center;
            margin-top: 20px;
            color: #555;
        }

        .form-container p a {
            color: #0d6efd;
            text-decoration: none;
            font-weight: bold;
        }

        .form-container p a:hover {
            text-decoration: underline;
        }

        @media(max-width:500px) {

            .form-container {
                padding: 30px 15px;
            }

            .form-container form {
                padding: 25px;
            }

        }

        .form-container select {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 18px;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 15px;
    box-sizing: border-box;
    outline: none;
    background: #fff;
}

.form-container select:focus {
    border-color: #2b7a78;
    box-shadow: 0 0 5px rgba(13,110,253,.3);
}
.avatar-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-bottom: 20px;
}

.avatar-grid input {
    display: none;
}

.avatar-grid label {
    cursor: pointer;
}

.avatar-grid span {

    display: flex;
    justify-content: center;
    align-items: center;

    font-size: 40px;

    height: 75px;

    border: 2px solid #ddd;

    border-radius: 12px;

    background: #fff;

    transition: .3s;
}

.avatar-grid span:hover {

    border-color: #2b7a78;

    background: #f3fbfb;
}

.avatar-grid input:checked+span {

    border-color: #2b7a78;

    background: #dff5f4;

    transform: scale(1.05);
}


    </style>

</head>

<body>

    <?php include "includes/navbar.php"; ?>

    <div class="form-container">

        <form method="POST">

            <h2>Create Account</h2>

            <?php
            if ($message != "") {
                echo "<div class='error'>$message</div>";
            }
            ?>

            <input type="text" name="name" placeholder="Full Name">

            <input type="email" name="email" placeholder="Email Address">

            <input type="text" name="phone" placeholder="Phone Number">
            
            <select name="role" required>

    <option value="">Register As</option>

    <option value="client">Client</option>

    <option value="worker">Worker</option>

</select>

    <h3>Choose Your Avatar</h3>

<div class="avatar-grid">

    <label>
        <input type="radio" name="avatar" value="👷" required>
        <span>👷</span>
    </label>

    <label>
        <input type="radio" name="avatar" value="👷‍♀️">
        <span>👷‍♀️</span>
    </label>

    <label>
        <input type="radio" name="avatar" value="👨‍🔧">
        <span>👨‍🔧</span>
    </label>

    <label>
        <input type="radio" name="avatar" value="👩‍🔧">
        <span>👩‍🔧</span>
    </label>

    <label>
        <input type="radio" name="avatar" value="👨‍🏭">
        <span>👨‍🏭</span>
    </label>

    <label>
        <input type="radio" name="avatar" value="👩‍🏭">
        <span>👩‍🏭</span>
    </label>

    <label>
        <input type="radio" name="avatar" value="👨‍🔨">
        <span>👨‍🔨</span>
    </label>

    <label>
        <input type="radio" name="avatar" value="👩‍🔨">
        <span>👩‍🔨</span>
    </label>

    <label>
        <input type="radio" name="avatar" value="🧑‍🔧">
        <span>🧑‍🔧</span>
    </label>

</div>

            <input type="password" name="password" placeholder="Password">

            <input type="password" name="confirm" placeholder="Confirm Password">

            <button name="register" class="btn primary">

                Register

            </button>

            <p>

                Already have an account?

                <a href="login.php">

                    Sign In

                </a>

            </p>

        </form>

    </div>

    <?php include "includes/footer.php"; ?>

</body>

</html>