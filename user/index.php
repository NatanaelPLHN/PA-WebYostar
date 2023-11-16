<?php
    // Include your database connection file
    require("../connection.php"); 

    // Check if the connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch data from the database
    $result = mysqli_query($conn, "SELECT * FROM games");
?>

<!-- Your HTML and PHP code for displaying games here -->

<?php
    // Close the database connection
    mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Games</title>
    <style>
        /* Add some basic styling for cards */
        .game-card {
            border: 1px solid #ddd;
            margin: 10px;
            padding: 10px;
            width: 200px;
            text-align: center;
            float: left;
        }

        .game-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h2>Game List</h2>

    <div>
        <?php
        // Loop through the database results and display them in cards
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="game-card">
                <img src="<?php echo $row['thumbnail']; ?>" alt="Game thumbnail">
                <h3><?php echo $row['name']; ?></h3>
                <p>Category: <?php echo $row['category']; ?></p>
                <p>Description: <?php echo $row['description']; ?></p>
                <p>
                    <a href='../user/review.php?id=<?php echo $row['id']; ?>'>Review</a> |
                    <a href='../user/detail.php?id=<?php echo $row['id']; ?>&game_id=<?php echo $row['id']; ?>'>Detail</a> 
                </p>
            </div>
        <?php
        }
        ?>
    </div>

    <?php
    // Close database connection
    ?>
</body>
</html>