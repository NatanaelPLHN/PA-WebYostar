<?php
require "../connection.php";

session_start();

if (!isset($_SESSION['login'])) {
    header("Location: ../Login/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = isset($_POST["rating"]) ? $_POST["rating"] : "";
    $review = isset($_POST["review"]) ? $_POST["review"] : "";
    $game_id = isset($_POST["game_id"]) ? $_POST["game_id"] : "";

    $sql = "INSERT INTO reviews (rating, review, game_id) VALUES ('$rating', '$review', '$game_id')";

    if (mysqli_query($conn, $sql)) {
        echo "Review added successfully.";
        header("Location: ../index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
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
    <link rel="stylesheet" href="star.css">
    <title>Rating & Review </title>
</head>

<body>

    <h2>Rating and Review Form</h2>

    <form action="" method="post" id="ratingForm">

        <div style="display: flex; flex-direction: row;">
            <label for="rating">Rating:</label>
            <input type="radio" id="star5" name="rating" value="1">
            <label for="star5">1</label>
            <input type="radio" id="star4" name="rating" value="2">
            <label for="star4">2</label>
            <input type="radio" id="star3" name="rating" value="3">
            <label for="star3">3</label>
            <input type="radio" id="star2" name="rating" value="4">
            <label for="star2">4</label>
            <input type="radio" id="star1" name="rating" value="5">
            <label for="star1">5</label>
        </div>

        <div class="review-section">
            <label for="review">Review:</label>
            <input type="text" id="review" name="review" required>
            <button type="button" onclick="window.location.href='../index.php'">Back</button>
        </div>

        <input type="hidden" name="game_id" value="<?php echo $id; ?>">

        <button type="submit">Submit</button>

    </form>

</body>

</html>