<?php
// Include your database connection file
include("../connection.php");

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    // Get the 'id' from the URL parameter
    $game_id = $_GET['id'];

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
    <title>Game Details</title>
</head>

<body>
    <?php
    // Check if game details are found
    if ($gameRow = mysqli_fetch_assoc($gameResult)) {
    ?>
        <h2><?php echo $gameRow['name']; ?> Details</h2>

        <p>Category: <?php echo $gameRow['category']; ?></p>
        <img src="<?php echo $gameRow['image']; ?>" alt="Game Image" style="max-width: 300px;">

        <h3>Reviews:</h3>

        <?php
        // Loop through reviews and display them
        while ($reviewRow = mysqli_fetch_assoc($reviewsResult)) {
        ?>
            <p>Rating: <?php echo $reviewRow['rating']; ?></p>
            <p>Review: <?php echo $reviewRow['review']; ?></p>
        <?php
        }
        ?>
    <?php
    } else {
        // Handle the case where no game details are found for the specified ID
        echo "Error: Game details not found.";
    }
    ?>

    <?php
    // Close database connection
    mysqli_close($conn);
    ?>
</body>

</html>
