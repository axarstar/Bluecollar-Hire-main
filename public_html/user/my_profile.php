<?php
include "../config/session.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];

// Fetch user's tools
$query = "SELECT * FROM tools WHERE user_id = $user_id ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tools | ToolShare</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7f7;
        }

        .page-header {
            text-align: center;
            margin: 30px 0;
        }

        .page-header h1 {
            color: #2B7A78;
        }

        .page-header p {
            color: #666;
        }

        .tool-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
            padding: 20px;
            width: 1200px;
            margin: 0 auto;
        }

        .tool-card {
            width: 240px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
            transition: .3s;
        }

        .tool-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 18px rgba(43, 122, 120, .2);
        }

        .tool-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 20px rgba(43, 122, 120, .25);
        }

        .tool-card img {
            width: 100%;
            height: 140px;
            object-fit: cover;
        }

        .tool-card h3 {
            margin: 10px;
            font-size: 18px;
            color: #2B7A78;
        }

        .tool-card p {
            margin: 6px 10px;
            font-size: 14px;
            color: #555;
        }

        .status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .status.available {
            background: #d8f3f2;
            color: #2B7A78;
        }

        .status.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status.rented {
            background: #f8d7da;
            color: #b02a37;
        }

        .tool-actions {
            display: flex;
            gap: 8px;
            padding: 10px;
        }

        .edit-btn,
        .delete-btn {
            padding: 8px;
            font-size: 14px;
            border-radius: 5px;
        }

        .edit-btn {
            background: #2B7A78;
        }

        .edit-btn:hover {
            background: #205e5c;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background: #b02a37;
        }

        .empty-state {
            margin: 0 auto;
            background: #fff;
            padding: 50px 100px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .1);
        }

        .add-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 20px;
            background: #2B7A78;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
        }

        .add-btn:hover {
            background: #205e5c;
        }
    </style>
</head>

<body>

    <?php include "includes/navbar.php"; ?>

    <div class="dashboard">

        <div class="page-header">
            <h1>My Tools</h1>
            <p>Manage all the tools you have listed.</p>
        </div>

        <div class="tool-container">

            <?php if (mysqli_num_rows($result) > 0): ?>

                <?php while ($tool = mysqli_fetch_assoc($result)): ?>

                    <div class="tool-card">

                        <img src="../uploads/tools/<?php echo htmlspecialchars($tool['image']); ?>"
                            alt="<?php echo htmlspecialchars($tool['tool_name']); ?>">

                        <h3><?php echo htmlspecialchars($tool['tool_name']); ?></h3>

                        <p>
                            <strong>Category:</strong>
                            <?php echo htmlspecialchars($tool['category']); ?>
                        </p>

                        <p>
                            <strong>Price:</strong>
                            Rs. <?php echo number_format($tool['price_per_day']); ?>/day
                        </p>

                        <p>
                            <strong>Status:</strong>

                            <span class="status <?php echo strtolower($tool['status']); ?>">
                                <?php echo htmlspecialchars($tool['status']); ?>
                            </span>
                        </p>

                        <div class="tool-actions">

                            <a href="edit_tool.php?id=<?php echo $tool['id']; ?>" class="edit-btn">
                                Edit
                            </a>

                            <a href="delete_tool.php?id=<?php echo $tool['id']; ?>"
                                class="delete-btn"
                                onclick="return confirm('Are you sure you want to delete this tool?');">
                                Delete
                            </a>

                        </div>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="empty-state">
                    <h2>No tools added yet.</h2>


                    <a href="add_tool.php" class="add-btn">
                        + Add Tool
                    </a>
                </div>

            <?php endif; ?>

        </div>

    </div>

</body>

</html>