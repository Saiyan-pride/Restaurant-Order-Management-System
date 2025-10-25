<?php
include "../db.php";
session_start();

if (isset($_POST['id']) && isset($_POST['stock'])) {
    $id = intval($_POST['id']);
    $stock = intval($_POST['stock']);

    $sql = "UPDATE `food` SET stock = $stock WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: view_items.php?msg=Stock updated successfully");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: view_items.php");
}
