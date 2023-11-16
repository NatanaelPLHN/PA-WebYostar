<?php
// Include your database connection file
require("connection.php");

session_start();

// if (!isset($_SESSION['email'])) {
//     header("Location: login.php");
//     exit();
// }

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from the database
$resultgame = mysqli_query($conn, "SELECT * FROM games");

$username = "Not logged in"; // Default value

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    // Query to fetch the username from the login table based on the user's email
    $result = mysqli_query($conn, "SELECT username FROM login WHERE email='$email'");

    if ($result && mysqli_num_rows($result) > 0) {
        // User found, fetch the username
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="resources/css/style.css">
    <script src="script.js"></script>
</head>

<body>

    <header class="fixed-navbar">
        <div class="menuToggle"></div>
        <div class="sidebar">
            <ul>
                <li class="logo" style="--bg:#333;">
                    <a href="#">
                        <div class="icons"><img src="resources/imgs/assets/yostar.png"></div>
                        <div class="text">YOSTAR</div>
                    </a>
                </li>
                <div class="Menulist">
                    <li style="--bg:#3da9fc;" class="active">
                        <a href="#home">
                            <div class="icon"><img src="resources/imgs/assets/house-solid.svg"></div>
                            <div class="text">HOME</div>
                        </a>
                    </li>
                    <li style="--bg:#f25f4c;">
                        <a href="#about">
                            <div class="icon"><img src="resources/imgs/assets/address-card-solid.svg"></div>
                            <div class="text">ABOUT</div>
                        </a>
                    </li>
                    <li style="--bg:#e53170;">
                        <a href="#game-list">
                            <div class="icon"><img src="resources/imgs/assets/gamepad-solid.svg"></div>
                            <div class="text">GAME</div>
                        </a>
                    </li>
                    <li style="--bg:#a786df;">
                        <a href="#reviews">
                            <div class="icon"><img src="resources/imgs/assets/star-solid.svg"></div>
                            <div class="text">REVIEW</div>
                        </a>
                    </li>
                </div>
                <div class="bottom">
                    <li style="--bg:#333;">
                        <a href="#">
                            <div class="icons">
                                <div class="imgBx">
                                    <img src="resources/imgs/assets/Arona_resultgame.png">
                                </div>
                            </div>
                            <div class="text">
                                <?php
                                    if (isset($_SESSION['login'])) {
                                        echo "Welcome, " . $username;
                                    } else {
                                        echo "$username";
                                    }
                                ?>
                            </div>
                        </a>
                    </li>
                    <li style="--bg:#333;">
                        <?php
                        if (isset($_SESSION['login'])) {
                            echo '<a href="Login/logout.php"><div class="icon"><img src="resources/imgs/assets/right-from-bracket-solid.svg"></div> </a>';
                        } else {
                            echo '<a href="login/Login.php"><div class="icon"><img src="resources/imgs/assets/right-from-bracket-solid.svg"></div> </a>';
                        }
                        ?>
                        </a>
                    </li>
                </div>
            </ul>
        </div>
    </header>

    <section class="landing-page" id="home">
        <div class="container">
            <h1>Welcome to YOSTAR</h1>
            <p>Explore the world of gaming and entertainment with YOSTAR. Join us for an exciting journey filled with games, reviews, and much more!</p>
            <a href="#" class="cta-button">Get Started</a>
        </div>
    </section>

    <!-- <section class="image-gallery" id="about">
        <div class="container">
            <h2>Explore Our Gallery</h2>
            <div class="gallery">
                <img src="resources/imgs/assets/23.png" alt="Image 1">
                <img src="resources/imgs/assets/24.png" alt="Image 2">
                <img src="resources/imgs/assets/25.png" alt="Image 3">
                <img src="resources/imgs/assets/26.png" alt="Image 3">
                <img src="resources/imgs/assets/27.png" alt="Image 3">
            </div>
        </div>
    </section> -->

    <section id="game-list">
        <div class="container">
            <h2>Game List</h2>
            <?php
            // Loop through the database resultgames and display them in cards
            while ($row = mysqli_fetch_assoc($resultgame)) {
            ?>
                <div class="game-list">
                    <div class="game-entry">
                        <img src="PAWEB/<?php echo $row['thumbnail']; ?>" alt="<?php echo $row['name']; ?>">
                        <h3><?php echo $row['name']; ?></h3>
                        <p>Description: <?php echo $row['description']; ?></p>
                        <p>
                            <a href='user/review.php?id=<?php echo $row['id']; ?>'>Review</a> |
                            <a href='user/detail.php?id=<?php echo $row['id']; ?>&game_id=<?php echo $row['id']; ?>'>Detail</a>
                        </p>
                    </div>
                <?php
            }
                ?>
                </div>
        </div>
    </section>

    <!-- <section id="reviews">
        <div class="container">
            <h2>Game Reviews</h2>
            <div class="review-list">
                <div class="review-entry">
                    <h3>User123's Review</h3>
                    <p>This game is fantastic! The graphics are amazing, and the gameplay is addictive. I highly recommend it!</p>
                </div>
                <div class="review-entry">
                    <h3>Gamer42's Review</h3>
                    <p>I enjoyed playing this game. The storyline is engaging, and the characters are well-developed.</p>
                </div>
                <div class="review-entry">
                    <h3>Gamer46's Review</h3>
                    <p>I enjoyed playing this game. The storyline is engaging, and the characters are well-developed.</p>
                </div>
                <div class="review-entry">
                    <h3>Gamer46's Review</h3>
                    <p>I enjoyed playing this game. The storyline is engaging, and the characters are well-developed.</p>
                </div>
            </div>
        </div>
    </section> -->

    <script>
        let menuToggle = document.querySelector('.menuToggle');
        let sidebar = document.querySelector('.sidebar');
        menuToggle.onclick = function() {
            menuToggle.classList.toggle('active');
            sidebar.classList.toggle('active');
        }

        let Menulist = document.querySelectorAll('.Menulist li');

        function activelink() {
            Menulist.forEach((item) =>
                item.classList.remove('active'));
            this.classList.add('active')
        }
        Menulist.forEach((item) =>
            item.addEventListener('click', activelink))
    </script>


</body>

</html>