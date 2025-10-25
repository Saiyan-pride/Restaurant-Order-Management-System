<?php
session_start();
include('../db.php'); // update path as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = intval($_POST['order_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $sql = "UPDATE `order` SET status='$status' WHERE id=$order_id";
    if (mysqli_query($conn, $sql)) {
        header("Location: view_order_items.php");
        exit();
    } else {
        echo "Status update failed!";
    }
}
