<?php

include "../config/session.php";


if (!isset($_SESSION['user_id'])) {

    header("Location: ../login.php");
    exit();
}


if (!isset($_GET['id'])) {

      header("Location: my_tools.php");
    exit();
}



$id = (int)$_GET['id'];

$user_id = $_SESSION['user_id'];



// Get tool

$result = mysqli_query(
    $conn,

    "SELECT * FROM tools

WHERE id='$id'

AND user_id='$user_id'"

);



if (mysqli_num_rows($result) == 0) {

    die("Tool not found.");
}



$tool = mysqli_fetch_assoc($result);




// Update tool

if (isset($_POST['update_tool'])) {


    $name = mysqli_real_escape_string(
        $conn,
        $_POST['tool_name']
    );


    $category = mysqli_real_escape_string(
        $conn,
        $_POST['category']
    );


    $description = mysqli_real_escape_string(
        $conn,
        $_POST['description']
    );


    $price = mysqli_real_escape_string(
        $conn,
        $_POST['price']
    );



    $image = $tool['image'];



    // Upload new image

    if (!empty($_FILES['image']['name'])) {


        $allowed = [
            "jpg",
            "jpeg",
            "png",
            "webp"
        ];



        $extension = strtolower(
            pathinfo(
                $_FILES['image']['name'],
                PATHINFO_EXTENSION
            )
        );



        if (!in_array($extension, $allowed)) {


            echo "<script>
            alert('Only JPG PNG WEBP allowed');
            </script>";
        } else {


            $new_image = time() . "." . $extension;


            $upload_path = "../uploads/tools/" . $new_image;



            if (move_uploaded_file(
                $_FILES['image']['tmp_name'],
                $upload_path
            )) {


                if (

                    !empty($tool['image']) &&

                    file_exists(
                        "../uploads/tools/" . $tool['image']
                    )

                ) {

                    unlink(
                        "../uploads/tools/" . $tool['image']
                    );
                }



                $image = $new_image;
            }
        }
    }




    mysqli_query(
        $conn,

        "UPDATE tools SET

    tool_name='$name',

    category='$category',

    description='$description',

    price_per_day='$price',

    image='$image'


    WHERE id='$id'

    "

    );



    echo "

    <script>

    alert('Tool updated successfully');

    window.location='my_tools.php';

    </script>

    ";


    exit();
}



?>



<!DOCTYPE html>

<html>

<head>


    <title>Edit Tool</title>


    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <style>
        * {

            box-sizing: border-box;

        }



        html,
        body {

            margin: 0;

            padding: 0;

            min-height: 100%;

            overflow-y: auto;

            overflow-x: hidden;

            font-family: Arial, Helvetica, sans-serif;

            background: #f4f6f6;

        }



        .form-box {


            width: 900px;

            max-width: 95%;

            margin: 50px auto;

            background: white;

            display: flex;

            border-radius: 15px;

            overflow: hidden;

            box-shadow: 0 8px 20px rgba(0, 0, 0, .1);


        }





        .left {


            width: 35%;

            background: #2B7A78;

            color: white;

            display: flex;

            flex-direction: column;

            justify-content: center;

            align-items: center;

            padding: 40px;


        }



        .left img {
            width: 100%;
            max-width: 280px;
            aspect-ratio: 9 / 10;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #fff;
            display: block;
        }


        .left h3 {


            margin-top: 20px;

            text-align: center;


        }




        .right {


            width: 65%;

            padding: 40px;


        }



        .right h2 {


            color: #2B7A78;

            margin-top: 0;


        }




        label {


            display: block;

            margin-top: 15px;

            margin-bottom: 7px;

            font-weight: bold;


        }



        input,
        textarea {


            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 7px;

            font-size: 15px;


        }



        textarea {


            height: 120px;

            resize: none;


        }




        button {


            width: 100%;

            margin-top: 25px;

            padding: 13px;

            background: #2B7A78;

            color: white;

            border: none;

            border-radius: 7px;

            font-size: 16px;

            cursor: pointer;


        }



        button:hover {


            background: #205e5c;


        }

        .tool-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .close-btn {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #2B7A78;
            border-radius: 50%;
            transition: .3s;
            font-size: 20px;
        }

        .close-btn:hover {
            background: #2B7A78;
            color: #fff;
        }





        @media(max-width:768px) {


            .form-box {

                flex-direction: column;

            }



            .left,
            .right {

                width: 100%;

            }



            .left {

                padding: 30px;

            }



            .right {

                padding: 25px;

            }



        }
    </style>


</head>


<body>


    <?php include "includes/navbar.php"; ?>



    <div class="form-box">



        <div class="left">


            <img

                src="../uploads/tools/<?php echo htmlspecialchars($tool['image']); ?>">



            <h3>

                <?php echo htmlspecialchars($tool['tool_name']); ?>

            </h3>



            <p>
                Current Image
            </p>



        </div>





        <div class="right">

            <div class="tool-nav">
                <h2><?php echo htmlspecialchars($tool['tool_name']); ?></h2>

                <a href="dashboard.php" class="close-btn">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            </div>



            <form method="POST" enctype="multipart/form-data">



                <label>
                    Tool Name
                </label>


                <input

                    type="text"

                    name="tool_name"

                    value="<?php echo htmlspecialchars($tool['tool_name']); ?>"

                    required>




                <label>
                    Category
                </label>


                <input

                    type="text"

                    name="category"

                    value="<?php echo htmlspecialchars($tool['category']); ?>"

                    required>





                <label>
                    Description
                </label>
                <textarea name="description" required><?php echo htmlspecialchars($tool['description']); ?></textarea>
                <label>
                    Price Per Day
                </label>
                <input
                    type="number"
                    name="price"
                    value="<?php echo htmlspecialchars($tool['price_per_day']); ?>"
                    required>

                <label>
                    Change Tool Image
                </label>
                <input type="file" name="image" accept="image/*">
                <button name="update_tool">

                    Update Tool

                </button>



            </form>



        </div>



    </div>



</body>

</html>