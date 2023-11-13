<?php
    // Include your database connection file
    include("../connection.php"); // Replace with your actual file name

    // Fetch data from the database
    $result = mysqli_query($conn, "SELECT * FROM games");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Games</title>
</head>
<body>
    <h2>Game List</h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Image</th>
            <th>Action</th>
        </tr>

        <?php
        // Loop through the database results and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['category']}</td>";
            echo "<td><img src='{$row['image']}' alt='Game Image' width='100'></td>";
            echo "<td>
                    <a href='edit.php?id={$row['id']}'>Edit</a> | 
                    <a href='delete.php?id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this game?\")'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
    </table>

    <?php
    // Close database connection
    mysqli_close($conn);
    ?>
</body>
</html>
