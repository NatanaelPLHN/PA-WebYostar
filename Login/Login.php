<?php
require('../connection.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // (Sign Up)
    if (isset($_POST['signup'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Query untuk memeriksa sebelumnya apakah email sudah terdaftar atau tidak
        $checkQuery = "SELECT * FROM login WHERE email='$email'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "<script>alert('Email sudah terdaftar, tolong gunakan email lainnya');</script>";
        } else {
            // Query untuk menambahkan data ke database karena email belum terdaftar
            $insertQuery = "INSERT INTO login (username, email, password) VALUES ('$username', '$email', '$password')";
            
            if (mysqli_query($conn, $insertQuery)) {
                echo "<script>alert('Akun berhasil dibuat!');</script>";
            } else {
                echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
            }
        }
    }

    //  (Sign In)
    if (isset($_POST['login'])) {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
    
        // Query untuk memeriksa kecocokan data login
        $query = "SELECT * FROM login WHERE email='$email' AND password='$password'"; 
        $result = mysqli_query($conn, $query);
    
        // Cek apakah ada akun yang di input ada di database
        if (mysqli_num_rows($result) > 0) {
            $userData = mysqli_fetch_assoc($result);
    
            // Cek jenis akun (admin atau user)
            if ($userData['email'] === 'admin@gmail.com' && $userData['password'] === 'admin123') {
                // Jika akun adalah admin, redirect ke halaman admin
                $_SESSION['login'] = true;
                $_SESSION['isAdmin'] = true;
                echo "<script>window.location.href = '../admin/index.php';</script>";
                exit();
            } else {
                // Jika bukan akun admin, redirect ke halaman user
                $_SESSION['login'] = true;
                $_SESSION['isAdmin'] = false;
                echo "<script>window.location.href = '../index.php';</script>";
                exit();
            }
        } else {
            // Jika tidak ada baris data yang sesuai, berarti akun tidak ada di database
            echo "<script>alert('Akun tidak ditemukan');</script>";
        }
    }
}    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <!-- LOGIN FORM -->
    <div class="background"></div>
    <div class="container">
        <div class="item">
            <h2 class="logo">Yostar</h2>
            <div class="text-item">
                <h2>Welcome! <br><span>
                </span></h2>
                <p>KELOMPOK 3</p>
            </div>
        </div>
        <div class="login-section">
            <div class="form-box login">
                <form action="login.php" method="POST">
                    <h2>Sign In</h2>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>

                    <button class="btn" type="submit" name="login">Login In</button>
                    <div class="create-account">
                        <p>Create A New Account? <a href="#" class="register-link">Sign Up</a></p>
                    </div>
                </form>
            </div>
            <div class="form-box register">
                <form action="login.php" method="POST">

                    <h2>Sign Up</h2>

                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-user'></i></span>
                        <input type="text" name="username" required>
                        <label>Username</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-envelope'></i></span>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class='bx bxs-lock-alt' ></i></span>
                        <input type="password" name="password" required>
                        <label>Password</label>
                    </div>
                    <div class="remember-password">
                        <label for=""><input type="checkbox" required>I agree with this statement</label>
                    </div>
                    <button class="btn" type="submit" name="signup">Sign Up</button>
                    <div class="create-account">
                        <p>Already Have An Account? <a href="#" class="login-link">Sign In</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <!-- SIGN UP FORM -->

    <script src="login.js"></script>
</body>
</html>
