<?php
// Include your database connection file
include("../connection.php");

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from the database
$result = mysqli_query($conn, "SELECT * FROM games");
?>

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
    <link rel="stylesheet" href="../resources/css/tombol.css">
    <link rel="stylesheet" href="../resources/css/admin.css">
    <script src="https://kit.fontawesome.com/b061f84e4f.js" crossorigin="anonymous"></script>
</head>

<body>
    <h2>Game List</h2>

    <div class="game-container">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="game-card">
                <img src="<?php echo $row['thumbnail']; ?>" alt="Game thumbnail">
                <h3><?php echo $row['name']; ?></h3>
                <p>Category: <?php echo $row['category']; ?></p>
                <p>Description: <?php echo $row['description']; ?></p>
                <p>
                    <a class="" href='edit.php?id=<?php echo $row['id']; ?>'>Edit</a> |
                    <a class="" href='delete.php?id=<?php echo $row['id']; ?>' onclick='return confirm("Are you sure you want to delete this game?")'>Delete</a> |
                    <a class="" href='lihat-review.php?id=<?php echo $row['id']; ?>'>Lihat Review</a> |
                    <a class="" href='../user/detail.php?id=<?php echo $row['id']; ?>&game_id=<?php echo $row['id']; ?>'>Detail</a>
                </p>
            </div>
        <?php
        }
        ?>
        <div class="game-card add-game-card" onclick="location.href='create.php';">
            <div class="add-game-content">
                <i class="fa-solid fa-plus"></i>
                <p>Click to add a new game</p>
            </div>
        </div>
    </div>
</body>
</html>