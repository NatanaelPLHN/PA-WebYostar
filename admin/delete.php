<?php
require "../connection.php";
session_start();

if (!isset($_SESSION['login']) || !$_SESSION['isAdmin']) {
    header("Location: ../Login/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM games WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully.";
        header("Location: index.php");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request. Please provide an 'id' parameter.";
}

mysqli_close($conn);
?>
