<?php
include('../includes/db_connect.php');
session_start();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id){
    $deleteQuery = "DELETE FROM packages WHERE id=$id";
    if(mysqli_query($conn, $deleteQuery)){
        header("Location: manage_packages.php?msg=deleted");
        exit();
    } else {
        die("Error deleting package: " . mysqli_error($conn));
    }
} else {
    die("Invalid package ID.");
}
?>
