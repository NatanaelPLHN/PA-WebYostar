<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    require "../connection.php";

    // Collect form data
    $name = $_POST["name"];
    $category = $_POST["category"];
    $description = $_POST["description"];

    // Process thumbnail upload
    $thumbnailDirectory = "../resources/imgs/thumbnails/"; // Specify thumbnail upload directory
    $thumbnailPath = $thumbnailDirectory . basename($_FILES["thumbnail"]["name"]);
    
    // Handle multiple image uploads
    $imagePaths = [];
    $imageDirectory = "../resources/imgs/images/"; // Specify images upload directory
    foreach ($_FILES["images"]["tmp_name"] as $key => $tmp_name) {
        $imageFile = $imageDirectory . basename($_FILES["images"]["name"][$key]);
        if (move_uploaded_file($tmp_name, $imageFile)) {
            $imagePaths[] = $imageFile;
        } else {
            echo "Error moving uploaded file.";
            exit; // Exit the script if an error occurs
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO games (name, category, description, thumbnail, images) VALUES ('$name', '$category', '$description', '$thumbnailPath', '" . implode(",", $imagePaths) . "')";

    if (mysqli_query($conn, $sql)) {
        // If the insertion is successful, move the uploaded files to their respective directories
        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $thumbnailPath)) {
            echo "Game added successfully.";
        } else {
            echo "Error moving thumbnail file.";
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close database connection
    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Games Input Form</title>
</head>
<body>
    <h2>Add a New Game</h2>
    <form action="" method="post" enctype="multipart/form-data">

        <!-- name field -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <!-- category field -->
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required>

        <!-- description field -->
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required>

        <!-- thumbnail field -->
        <label for="thumbnail">Thumbnail:</label>
        <input type="file" id="thumbnail" name="thumbnail" required>
        
        <!-- images field -->
        <label for="images">Images:</label>
        <input type="file" id="images" name="images[]" multiple required>


        <!-- Submit button -->
        <button type="submit">Add Game</button>
    </form>
</body>
</html>