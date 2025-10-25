<?php
session_start();
include '../db.php';
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['user_type'] == "admin") {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT name FROM user WHERE id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $user_name = $row['name'];
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
    <title>Admin Dashboard</title>
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
        padding: 40px;
    }

    .main h1 {
        font-size: 2rem;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .main p {
        font-size: 1.1rem;
        color: #555;
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
        <h1>Welcome, <?php echo $user_name; ?></h1>
        <p>This is your Admin Dashboard. Use the sidebar to manage items and orders.</p>
    </div>
</body>

</html>