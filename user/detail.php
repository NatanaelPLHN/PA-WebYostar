<?php
include("../connection.php");

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
    <link rel="stylesheet" href="details.css">
    <title>Game Details</title>
</head>

<body>
    <?php
    if ($gameRow = mysqli_fetch_assoc($gameResult)) {
    ?>
        <div class="details-container">
            <h2><?php echo $gameRow['name']; ?> Details</h2>

            <p>Category: <?php echo $gameRow['category']; ?></p>
            <p>Description: <?php echo $gameRow['description']; ?></p>
            <img src="<?php echo $gameRow['thumbnail']; ?>" alt="Game thumbnail" style="max-width: 300px;">
        </div>
        <?php
        $imagePaths = explode(",", $gameRow['images']);
        if (!empty($imagePaths)) {
        ?>
            <div class="carousel-container">
                <div class="carousel-track">
                    <?php
                    foreach ($imagePaths as $imagePath) {
                    ?>
                        <div class="carousel-item">
                            <img src="<?php echo $imagePath; ?>" alt="Game Image">
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <div class="carousel-controls">
                <button id="prevBtn">&lt; Previous</button>
                <a href="../index.php" class="back-btn">Back</a>
                <button id="nextBtn">Next &gt;</button>
            </div>
        <?php
        }
        ?>


        <h3>Reviews:</h3>

        <div class="reviews-section">
            <?php
            while ($reviewRow = mysqli_fetch_assoc($reviewsResult)) {
            ?>
                <div class="review-box">
                    <p class="review-rating">Rating: <?php echo $reviewRow['rating']; ?></p>
                    <p class="review-text">Review: <?php echo $reviewRow['review']; ?></p>
                </div>
            <?php
            }
            ?>
        </div>
    <?php
    } else {
        echo "Error: Game details not found.";
    }
    ?>

    <?php
    mysqli_close($conn);
    ?>

    <script>
        const track = document.querySelector('.carousel-track');
        const items = document.querySelectorAll('.carousel-item');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;

        nextBtn.addEventListener('click', () => {
            if (currentIndex < items.length - 1) {
                currentIndex++;
            } else {
                currentIndex = 0;
            }
            updateCarousel();
        });

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
            } else {
                currentIndex = items.length - 1;
            }
            updateCarousel();
        });

        function updateCarousel() {
            const newPosition = -currentIndex * 100 + '%';
            track.style.transform = 'translateX(' + newPosition + ')';
        }
    </script>
</body>

</html>