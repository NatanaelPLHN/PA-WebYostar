<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    require"../connection.php";

    // Collect form data
    $name = $_POST["name"];
    $category = $_POST["category"];

    // Process image upload
    $targetDirectory = "../resources/imgs/uploads/"; // Specify your upload directory
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

    // Insert data into the database
    $sql = "INSERT INTO games VALUES ('','$name', '$category', '$targetFile')";
    
    if (mysqli_query($conn, $sql)) {
        // If the insertion is successful, move the uploaded file to the target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "Game added successfully.";
        } else {
            echo "Error moving uploaded file.";
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

        <!-- image field -->
        <label for="image">image:</label>
        <input type="file" id="image" name="image" required>

        <!-- Submit button -->
        <button type="submit">Add Game</button>
    </form>
</body>
</html>
