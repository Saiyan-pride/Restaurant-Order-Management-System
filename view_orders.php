<?php
session_start();
include 'db.php'; // Adjust as per your project

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'user') {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            order.id AS order_id,
            user.name AS user_name,
            user.email,
            user.phone,
            user.address,
            food.food_name AS item_name,
            food.price,
            food.image,
            order.status
        FROM `order`
        JOIN `user` ON order.customer_id = user.id
        JOIN `food` ON order.item_id = food.id
        WHERE order.customer_id = $user_id
        ORDER BY order.id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Your Orders</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background-color: #f7f7f7;
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

        /* Main Content */
        .main {
            margin-left: 240px;
            padding: 30px;
        }

        h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .table-container {
            overflow-x: auto;
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
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

        tr:hover {
            background-color: #f5f5f5;
        }

        img {
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #ddd;
        }

        /* Status Badge */
        td:last-child {
            font-weight: bold;
        }

        td:last-child::first-letter {
            text-transform: uppercase;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 180px;
                padding-top: 60px;
            }

            .main {
                margin-left: 190px;
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                display: flex;
                justify-content: center;
                padding: 10px 0;
            }

            .sidebar a {
                display: inline-block;
                margin: 0 10px;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .header {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <a href="logout.php">Log out</a>
    </div>

    <div class="sidebar">
        <a href="user_dashboard.php">User Dashboard</a>
        <a href="view_orders.php">View Orders</a>
    </div>

    <div class="main">
        <div class="table-container">
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Delivery Agent</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) {
                    $address = $row['address'];
                    $agent_sql = "SELECT * FROM `delivery_agents` WHERE area LIKE '%$address%' LIMIT 1";
                    $agent_result = mysqli_query($conn, $agent_sql);
                    $agent_info = mysqli_fetch_assoc($agent_result);
                ?>
                    <tr>
                        <td><?php echo $row['order_id']; ?></td>
                        <td><?php echo $row['user_name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td><?php echo $row['item_name']; ?></td>
                        <td>&#8377;<?php echo $row['price']; ?></td>
                        <td><img src="image/<?php echo $row['image']; ?>" width="60" height="60" /></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                        <td>
                            <?php if ($agent_info) { ?>
                                <?= $agent_info['name']; ?> (<?= $agent_info['phone']; ?>)
                            <?php } else { ?>
                                <p style="font-weight: 100; color:#e74c3c">Not Assigned</p>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>