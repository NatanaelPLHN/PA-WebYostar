<?php

require "../connection.php";
session_start();

if (!isset($_SESSION['login']) || !$_SESSION['isAdmin']) {
    header("Location: ../Login/login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $category = $_POST["category"];
    $description = $_POST["description"];

    $thumbnailDirectory = "../resources/imgs/thumbnails/"; 
    $thumbnailPath = $thumbnailDirectory . basename($_FILES["thumbnail"]["name"]);

    $imagePaths = [];
    $imageDirectory = "../resources/imgs/images/"; 
    foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
        $imageFile = $imageDirectory . basename($_FILES["images"]["name"][$key]);
        if (move_uploaded_file($tmp_name, $imageFile)) {
            $imagePaths[] = $imageFile;
        } else {
            echo "Error moving uploaded file.";
            exit; 
        }
    }

    $sql = "INSERT INTO games (name, category, description, thumbnail, images) VALUES ('$name', '$category', '$description', '$thumbnailPath', '" . implode(",", $imagePaths) . "')";

    if (mysqli_query($conn, $sql)) {
        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbnailPath)) {
            echo "Game added successfully.";
            header("Location: index.php");
        } else {
            echo "Error moving thumbnail file.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="crete.css">
    <title>Games Input Form</title>
</head>

<body>
    <h2>Add a New Game</h2>
    <form action="" method="post" enctype="multipart/form-data">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required>

        <label for="thumbnail">Thumbnail:</label>
        <input type="file" id="thumbnail" name="thumbnail" required>

        <label for="images">Images:</label>
        <input type="file" id="images" name="images[]" multiple required>

        <button type="submit">Add Game</button>
        <a href="index.php" class="back-to-index-button">
            <button type="button">Back</button>
        </a>
    </form>

</body>

</html>