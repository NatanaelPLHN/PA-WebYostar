<?php
// Include your database connection file
require "../connection.php";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $rating = isset($_POST["rating"]) ? $_POST["rating"] : "";
    $review = isset($_POST["review"]) ? $_POST["review"] : "";
    $game_id = isset($_POST["game_id"]) ? $_POST["game_id"] : "";

    // Insert review into the database
    $sql = "INSERT INTO reviews (rating, review, game_id) VALUES ('$rating', '$review', '$game_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Review added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}

// Check if 'id' is set in the URL parameters
if (isset($_GET['id'])) {
    // Get the 'id' from the URL parameter
    $id = $_GET['id'];
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
    <title>Rating & Review </title>
</head>

<body>

    <h2>Rating and Review Form</h2>

    <form action="" method="post" id="ratingForm">

        <div style="display: flex; flex-direction: row;">
            <label for="rating">Rating:</label>
            <input type="radio" id="star5" name="rating" value="5">
            <label for="star5">5 stars</label>
            <input type="radio" id="star4" name="rating" value="4">
            <label for="star4">4 stars</label>
            <input type="radio" id="star3" name="rating" value="3">
            <label for="star3">3 stars</label>
            <input type="radio" id="star2" name="rating" value="2">
            <label for="star2">2 stars</label>
            <input type="radio" id="star1" name="rating" value="1">
            <label for="star1">1 star</label>
        </div>

        <div>
            <label for="review">Review:</label>
            <input type="text" id="review" name="review" required>
            <!-- <textarea id="review" name="review" placeholder="Write your review here..."></textarea> -->
        </div>

        <input type="hidden" name="game_id" value="<?php echo $id; ?>">

        <button type="submit">Submit</button>

    </form>

</body>

</html>