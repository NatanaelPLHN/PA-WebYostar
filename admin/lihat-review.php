<?php
require "../connection.php";
session_start();

if (!isset($_SESSION['login']) || !$_SESSION['isAdmin']) {
    header("Location: ../Login/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $game_id = $_GET['id'];

    $gameResult = mysqli_query($conn, "SELECT * FROM games WHERE id = $game_id");
    $reviewsResult = mysqli_query($conn, "SELECT * FROM reviews WHERE game_id = $game_id");
} else {
    echo "Error: Game ID is not set.";
    exit; 
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