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

$user_id = $_SESSION['user_id'];

$message = "";
$message_type = "error";

/*
|--------------------------------------------------------------------------
| Check if worker profile already exists
|--------------------------------------------------------------------------
*/

$checkProfile = mysqli_query($conn, "
SELECT *
FROM worker_profiles
WHERE user_id='$user_id'
");

if (mysqli_num_rows($checkProfile) > 0) {

    $_SESSION['success'] = "You have already created your worker profile.";

    header("Location: dashboard.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| Load Categories
|--------------------------------------------------------------------------
*/

$categories = mysqli_query($conn, "
SELECT *
FROM categories
ORDER BY name ASC
");

/*
|--------------------------------------------------------------------------
| Save Worker Profile
|--------------------------------------------------------------------------
*/

if (isset($_POST['create_profile'])) {

    $category_id = intval($_POST['category']);

    $experience = intval($_POST['experience']);

    $daily_rate = floatval($_POST['daily_rate']);

    $address = mysqli_real_escape_string(
        $conn,
        trim($_POST['address'])
    );

    $bio = mysqli_real_escape_string(
        $conn,
        trim($_POST['bio'])
    );

    $availability = mysqli_real_escape_string(
        $conn,
        $_POST['availability']
    );

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    */

    if (
        empty($category_id) ||
        empty($experience) ||
        empty($daily_rate) ||
        empty($address) ||
        empty($bio)
    ) {

        $message = "Please fill in all fields.";

    } elseif ($experience < 0) {

        $message = "Experience cannot be negative.";

    } elseif ($daily_rate <= 0) {

        $message = "Daily rate must be greater than zero.";

    } else {

        $insert = mysqli_query($conn, "

        INSERT INTO worker_profiles
        (
            user_id,
            category_id,
            experience,
            daily_rate,
            address,
            bio,
            availability,
            status
        )

        VALUES
        (
            '$user_id',
            '$category_id',
            '$experience',
            '$daily_rate',
            '$address',
            '$bio',
            '$availability',
            'Pending'
        )

        ");

        if ($insert) {

            $_SESSION['success'] =
                "Worker profile created successfully. It is now waiting for admin approval.";

            header("Location: dashboard.php");
            exit();

        } else {

            $message = "Database Error : " . mysqli_error($conn);

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Worker Profile</title>

    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
        }

        .form-container {

            width: 100%;
            display: flex;
            justify-content: center;
            padding: 40px 20px;

        }

        form {

            width: 100%;
            max-width: 650px;

            background: #fff;

            padding: 35px;

            border-radius: 12px;

            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);

        }

        h2 {

            text-align: center;

            margin-bottom: 25px;

            color: #2B7A78;

        }

        label {

            display: block;

            margin-bottom: 8px;

            font-weight: bold;

            color: #444;

        }

        input,
        textarea,
        select {

            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 8px;

            margin-bottom: 18px;

            font-size: 15px;

            outline: none;

            box-sizing: border-box;

        }

        input:focus,
        textarea:focus,
        select:focus {

            border-color: #2B7A78;

        }

        textarea {

            min-height: 120px;

            resize: vertical;

        }

        .btn {

            width: 100%;

            padding: 14px;

            border: none;

            background: #2B7A78;

            color: white;

            border-radius: 8px;

            font-size: 16px;

            cursor: pointer;

            transition: .3s;

        }

        .btn:hover {

            background: #205e5c;

        }

        .error {

            background: #f8d7da;

            color: #842029;

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 20px;

        }

        .success {

            background: #d1e7dd;

            color: #0f5132;

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 20px;

        }
    </style>

</head>

<body>

    <?php include "includes/navbar.php"; ?>

    <div class="form-container">

        <form method="POST">

            <h2>Create Worker Profile</h2>

            <?php

            if ($message != "") {

                echo "<div class='$message_type'>$message</div>";

            }

            ?>

            <label>

                Service Category

            </label>

            <select name="category" required>

                <option value="">

                    Select Category

                </option>

                <?php

                while ($cat = mysqli_fetch_assoc($categories)) {

                    ?>

                    <option value="<?= $cat['id'] ?>">

                        <?= htmlspecialchars($cat['name']) ?>

                    </option>

                    <?php

                }

                ?>

            </select>

            <label>

                Years of Experience

            </label>

            <input type="number" name="experience" min="0" required>

            <label>

                Expected Daily Rate (Rs.)

            </label>

            <input type="number" name="daily_rate" min="1" step="0.01" required>

            <label>

                Address

            </label>

            <input type="text" name="address" placeholder="District, Municipality" required>

            <label>

                Short Bio

            </label>

            <textarea name="bio" placeholder="Describe your skills and experience..." required>

</textarea>

            <label>

                Availability

            </label>

            <select name="availability">

                <option value="Available">

                    Available

                </option>

                <option value="Busy">

                    Busy

                </option>

            </select>

            <button type="submit" name="create_profile" class="btn">

                Create Worker Profile

            </button>

        </form>

    </div>

</body>

</html>