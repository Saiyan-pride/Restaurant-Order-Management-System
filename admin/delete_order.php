<?php
include "../db.php";
session_start();

if ($_SESSION['user_type'] == "admin" && isset($_POST['order_id'])) {
    $order_id = intval($_POST['order_id']);

    $sql = "DELETE FROM `order` WHERE id = $order_id";
    if (mysqli_query($conn, $sql)) {
        header("Location: view_order_items.php?msg=Order deleted successfully");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: ../login.php");
}
