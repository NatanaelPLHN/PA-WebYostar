<?php

require "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rating = $_POST["rating"];
    $review = $_POST["review"];

    $sql = "INSERT INTO reviews VALUES ('','$rating', '$review')";

    if (mysqli_query($conn, $sql)) {
        echo "Review berhasil ditambah.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
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

        <button type="submit">Submit</button>

    </form>

</body>

</html>