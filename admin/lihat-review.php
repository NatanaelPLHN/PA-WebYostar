<?php
// Include your database connection file
require "../connection.php";
session_start();

if (!isset($_SESSION['login']) || !$_SESSION['isAdmin']) {
    // Redirect to the login page or display an unauthorized message
    header("Location: ../Login/login.php");
    exit();
}

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the 'id' from the URL parameter
    $game_id = $_GET['id'];
    // Get the 'id' from the URL parameter

    // Fetch game details from the games table
    $gameResult = mysqli_query($conn, "SELECT * FROM games WHERE id = $game_id");
    // Fetch reviews for the specified game from the reviews table
    $reviewsResult = mysqli_query($conn, "SELECT * FROM reviews WHERE game_id = $game_id");
} else {
    // Handle the case where 'id' is not set (you may redirect the user or show an error message)
    echo "Error: Game ID is not set.";
    exit; // or handle the error in another way
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Review</title>
    <link rel="stylesheet" href="../user/details.css">
</head>

<body>

    <div class="reviews-section">
        <h3>Reviews:</h3>
        <?php
        // Loop through reviews and display them
        while ($reviewRow = mysqli_fetch_assoc($reviewsResult)) {
        ?>
            <div class="review-box">
                <p class="review-rating">Rating: <?php echo $reviewRow['rating']; ?></p>
                <p class="review-text">Review: <?php echo $reviewRow['review']; ?></p>
                <a href='delete-review.php?id=<?php echo $reviewRow['id']; ?>' onclick='return confirm("Are you sure you want to delete this game?")'>Delete</a> 

            </div>
        <?php
        }
        ?>
    </div>
</body>

</html>