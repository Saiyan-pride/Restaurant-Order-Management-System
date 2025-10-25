<?php
session_start();
include('db.php'); // database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if the user type is 'user'
if ($_SESSION['user_type'] != 'user') {
    header('Location: admin_dashboard.php');
    exit();
}

// Retrieve GET parameters
if (isset($_GET['user_id']) && isset($_GET['menu_id'])) {
    $user_id = intval($_GET['user_id']);
    $item_id = intval($_GET['menu_id']);
    $status = 'pending';

    // Insert order
    $sql = "INSERT INTO `order` (customer_id, item_id, status) VALUES ($user_id, $item_id, '$status')";
    $result = mysqli_query($conn, $sql);

    $sql_update_stock = "UPDATE `food` SET stock = stock - 1 WHERE id = $item_id";
    mysqli_query($conn, $sql_update_stock);

    if ($result) {
        $message = urlencode('Order added successfully');
        header("Location: index.php?added_message=$message");
        exit();
    } else {
        $message = urlencode('Error: Could not add order');
        header("Location: index.php?added_message=$message");
        exit();
    }
}
