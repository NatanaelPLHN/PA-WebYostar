<?php
// Include your database connection file
require "../connection.php"; // Replace with your actual file name

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the existing data for the specified ID
    $result = mysqli_query($conn, "SELECT * FROM games WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // Check if the form is submitted for updating
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect updated form data
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        $category = mysqli_real_escape_string($conn, $_POST["category"]);

        // Process image upload if a new image is selected
        if (!empty($_FILES["image"]["name"])) {
            $targetDirectory = "../resources/imgs/uploads/"; // Specify your upload directory
            $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);

            // Update the data in the database
            $updateSql = "UPDATE games SET name='$name', category='$category', image='$targetFile' WHERE id=$id";

            if (mysqli_query($conn, $updateSql) && move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                echo "Record updated successfully.";
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } else {
            // Update the data in the database without changing the image
            $updateSql = "UPDATE games SET name='$name', category='$category' WHERE id=$id";

            if (mysqli_query($conn, $updateSql)) {
                echo "Record updated successfully.";
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game</title>
</head>
<body>
    <h2>Edit Game</h2>

    <form action="" method="post" enctype="multipart/form-data">
        <!-- name field -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>

        <!-- category field -->
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo $row['category']; ?>" required>

        <!-- image field -->
        <label for="image">Image:</label>
        <input type="file" id="image" name="image">
        <p>Current Image: <img src="<?php echo $row['image']; ?>" alt="Current Game Image" width="100"></p>

        <!-- Submit button -->
        <button type="submit">Update Game</button>
    </form>

</body>
</html>

<?php
} else {
    echo "Invalid request. Please provide an 'id' parameter.";
}

// Close database connection
mysqli_close($conn);
?>
