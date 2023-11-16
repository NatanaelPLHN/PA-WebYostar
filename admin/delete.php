<?php
// Include your database connection file
require "../connection.php";
session_start();

if (!isset($_SESSION['login']) || !$_SESSION['isAdmin']) {
    // Redirect to the login page or display an unauthorized message
    header("Location: ../Login/login.php");
    exit();
}

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Construct the DELETE query
    $sql = "DELETE FROM games WHERE id = $id";

    // Execute the DELETE query
    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully.";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request. Please provide an 'id' parameter.";
}

// Close database connection
mysqli_close($conn);
?>
