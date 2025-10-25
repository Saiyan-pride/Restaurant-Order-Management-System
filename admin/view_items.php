<?php
include "../db.php";
session_start();
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] == "admin") {
        $sql = "select * from food";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo "Error: {$conn->error}";
        }
    }
    if ($_SESSION['user_type'] == "user") {
        echo "user dashboard";
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
    <title>View Menu Items</title>
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
        margin-left: 240px;
        padding: 30px;
    }

    h2 {
        margin-bottom: 20px;
        color: #2c3e50;
        font-size: 22px;
        font-weight: bold;
    }

    .table-container {
        overflow-x: auto;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }

    th {
        background-color: #2c3e50;
        color: white;
        padding: 12px;
        font-size: 14px;
        text-transform: uppercase;
    }

    td {
        padding: 12px;
        font-size: 14px;
        border-bottom: 1px solid #ddd;
        vertical-align: middle;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    img {
        border-radius: 8px;
        border: 2px solid #ccc;
        width: 100px;
        height: 100px;
        object-fit: cover;
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
        <h2>All Menu Items</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Item Name</th>
                        <th>Item Price</th>
                        <th>Item Category</th>
                        <th>Item Stock</th>
                        <th>Update Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><img src="../image/<?php echo $row['image']; ?>"></td>
                            <td><?php echo $row['food_name']; ?></td>
                            <td>&#8377;<?php echo $row['price']; ?></td>
                            <td><?php echo $row['category']; ?></td>
                            <td><?php echo $row['stock']; ?></td>
                            <td>
                                <form action="update_stock.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                    <input type="number" name="stock" class="stock-input" min="0" required>
                                    <button type="submit" class="btn">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>