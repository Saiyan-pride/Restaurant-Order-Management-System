<?php
include "../db.php";
$msg = "";
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] == "admin") {
        if (isset($_POST['click'])) {
            $image = $_FILES['image']['name'];
            $temp_location = $_FILES['image']['tmp_name'];
            $tar_location = "../image/";
            $name = $_POST['name'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $stock = $_POST['stock'];

            $sql = "insert into food(id, image, food_name, price, category, stock)
                    values(null, '$image', '$name', '$price', '$category', '$stock')";

            try {
                $result = mysqli_query($conn, $sql);
                if ($result != null) {
                    move_uploaded_file($temp_location, $tar_location . $image);

                    $msg = "<div class='msg success'>Item added successfully!</div>";
                }
            } catch (mysqli_sql_exception) {
                $msg = "<div class='msg error'>Unable to add the item</div>";
            }
        }
    }
    if ($_SESSION['user_type'] == "user") {
        header("Location: ../user_dashboard.php");
    }
} else {
    header("Location: ../login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Menu Items</title>
</head>
<style type="text/css">
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        background-color: #f4f6f8;
    }

    /* Header */
    .header {
        padding: 20px 40px;
        background: linear-gradient(135deg, #2c3e50, #34495e);
        color: white;
        text-align: right;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .header a {
        text-decoration: none;
        color: white;
        padding: 10px 18px;
        background-color: #e74c3c;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s ease;
    }

    .header a:hover {
        background-color: #c0392b;
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 220px;
        background: #2c3e50;
        color: white;
        padding-top: 70px;
        box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
    }

    .sidebar a {
        text-decoration: none;
        display: block;
        padding: 18px 20px;
        margin: 5px 15px;
        border-radius: 6px;
        font-weight: 500;
        color: white;
        transition: 0.3s ease;
        text-align: center;
    }

    .sidebar a:hover {
        background-color: #34495e;
        transform: translateX(5px);
    }

    .sidebar hr {
        border: none;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        margin: 10px 0;
    }

    /* Main content */
    .main {
        margin-left: 440px;
        padding: 40px;
    }

    .main form {
        background: #fff;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
        width: 400px;
    }

    .main input[type="text"],
    .main input[type="number"],
    .main input[type="file"] {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 8px;
        outline: none;
        font-size: 14px;
        transition: 0.3s;
        background: #fafafa;
    }

    .main input:focus {
        border-color: #4a90e2;
        box-shadow: 0px 0px 8px rgba(74, 144, 226, 0.5);
        background: #fff;
    }

    .btn {
        width: 100%;
        padding: 12px;
        background: #4a90e2 !important;
        color: #fff;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn:hover {
        background: #357ABD !important;
    }

    /* Messages */
    .msg {
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-weight: bold;
        text-align: center;
    }

    .msg.success {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .msg.error {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<body>
    <div class="header">
        <a href="../logout.php">Log out</a>
    </div>
    <div class="sidebar">
        <a href="admin_dashboard.php">Admin Dashboard</a>
        <hr>
        <a href="add_items.php">Add Menu Items</a>
        <hr>
        <a href="view_items.php">View Menu Items</a>
        <hr>
        <a href="view_order_items.php">View Order Items</a>
    </div>
    <div class="main">
        <?php if ($msg != "") echo $msg; ?>

        <form action="add_items.php" method="post" enctype="multipart/form-data">
            <h2 style="margin-bottom: 20px; text-align:center; color:#2c3e50;">Add Menu Item</h2>
            <label>Upload image of item:</label>
            <input type="file" name="image" required>

            <label>Name of item:</label>
            <input type="text" name="name" required>

            <label>Price of item:</label>
            <input type="number" name="price" required>

            <label>Item category:</label>
            <input type="text" name="category" required>

            <label>Item Stock:</label>
            <input type="number" name="stock" required>

            <input type="submit" name="click" class="btn" value="Add item">
        </form>
    </div>
</body>

</html>