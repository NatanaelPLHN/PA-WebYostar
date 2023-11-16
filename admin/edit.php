<?php
// Include your database connection file
require "../connection.php";
session_start();

if (!isset($_SESSION['login']) || !$_SESSION['isAdmin']) {
    // Redirect to the login page or display an unauthorized message
    header("Location: ../Login/login.php");
    exit();
}

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
        $description = mysqli_real_escape_string($conn, $_POST["description"]);

        // Process thumbnail upload if a new thumbnail is selected
        if (!empty($_FILES["thumbnail"]["name"])) {
            $targetDirectory = "../resources/imgs/thumbnails/"; // Specify your upload directory
            $targetFile = $targetDirectory . basename($_FILES["thumbnail"]["name"]);

            // Update the data in the database
            $updateSql = "UPDATE games SET name='$name', category='$category', description='$description', thumbnail='$targetFile' WHERE id=$id";

            if (mysqli_query($conn, $updateSql) && move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile)) {
                echo "Record updated successfully.";
                header("Location: index.php");
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } else {
            // Update the data in the database without changing the thumbnail
            $updateSql = "UPDATE games SET name='$name', category='$category', description='$description' WHERE id=$id";

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
        <link rel="stylesheet" href="crete.css">

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

            <!-- description field -->
            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required>

            <!-- thumbnail field -->
            <label for="thumbnail">Thumbnail:</label>
            <input type="file" id="thumbnail" name="thumbnail">
            <p>Current thumbnail: <img src="<?php echo $row['thumbnail']; ?>" alt="Current Game thumbnail" width="100"></p>

            <!-- images field -->
            <!-- <label for="images">Images:</label> -->
            <!-- <input type="file" id="images" name="images[]" multiple required> -->


            <!-- Submit button -->
            <button type="submit">Update Game</button>
            <a href="index.php" class="back-to-index-button">
                <button type="button">Back</button>
            </a>
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