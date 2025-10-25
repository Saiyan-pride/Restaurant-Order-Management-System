<?php
session_start();
include('../db.php'); // update path as needed

// Order fetch with JOIN
$sql = "SELECT 
           user.id AS user_id, 
           user.name, 
           user.email, 
           user.address, 
           user.phone,
           food.id AS item_id, 
           food.image, 
           food.food_name AS item_name, 
           food.price, 
           food.category, 
           `order`.id AS order_id, 
           `order`.status 
        FROM `order`
        JOIN `user` ON `order`.customer_id = user.id
        JOIN `food` ON `order`.item_id = food.id
        ORDER BY `order`.id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin: View Orders</title>
    <style>
        * {
            margin: 0;
            padding: 0;
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
        .content {
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
            width: 80px;
            height: 80px;
            object-fit: cover;
        }

        /* Buttons and Select */
        .status-btn {
            background-color: #4a90e2;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s ease;
            font-size: 13px;
            font-weight: bold;
        }

        .status-btn:hover {
            background-color: #357ABD;
        }

        select {
            padding: 6px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-right: 5px;
            font-size: 13px;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

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

    <div class="content">
        <h2>All Orders</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Item ID</th>
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?= $row['order_id']; ?></td>
                        <td><?= $row['user_id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['address']; ?></td>
                        <td><?= $row['phone']; ?></td>
                        <td><?= $row['item_id']; ?></td>
                        <td><img src="../image/<?= $row['image']; ?>" /></td>
                        <td><?= $row['item_name']; ?></td>
                        <td>&#8377;<?= $row['price']; ?></td>
                        <td><?= $row['category']; ?></td>
                        <td><?= ucfirst($row['status']); ?></td>
                        <td>
                            <form action="update_order_items.php" method="post">
                                <input type="hidden" name="order_id" value="<?= $row['order_id']; ?>">
                                <select name="status">
                                    <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="delivered" <?= $row['status'] == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                </select>
                                <input type="submit" class="status-btn" value="Update">
                            </form>
                            <?php if ($row['status'] == 'delivered') { ?>
                                <form action="delete_order.php" method="post" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    <input type="hidden" name="order_id" value="<?= $row['order_id']; ?>">
                                    <button type="submit" class="delete-btn">Delete</button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>