<?php
session_start();
include 'db.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header("Location: crud_admin.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, rgb(30, 235, 242), rgb(218, 185, 253));
    background-size: 400% 400%;
    animation: gradientAnimation 5s ease infinite;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

@keyframes gradientAnimation {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.login-container {
    background-color: rgba(255, 255, 255, 0.9);
    padding: 40px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    width: 100%;
    max-width: 400px;
    text-align: center;
    position: relative;
    z-index: 1;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease-in-out;
}

.login-container h2 {
    color:rgb(47, 0, 255);
    margin-bottom: 20px;
    font-size: 28px;
    font-weight: bold;
}

.login-container input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 16px;
    box-sizing: border-box;
    background-color: #f9f9f9;
    transition: border 0.3s ease;
}

.login-container input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

.login-container button {
    background: linear-gradient(135deg, #007bff, #6a11cb);
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    width: 100%;
    transition: background 0.3s ease;
    font-size: 16px;
    margin-top: 10px;
}

.login-container button:hover {
    background: linear-gradient(135deg, #0056b3, #4b00c8);
}

.error-message {
    color: red;
    margin-top: 20px;
    font-size: 14px;
}

@media (max-width: 768px) {
    .login-container {
        width: 90%;
        padding: 20px;
    }

    .login-container h2 {
        font-size: 20px;
    }

    .login-container input {
        font-size: 14px;
        padding: 10px;
    }

    .login-container button {
        padding: 10px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .login-container h2 {
        font-size: 18px;
    }

    .login-container input {
        font-size: 12px;
        padding: 8px;
    }

    .login-container button {
        padding: 8px;
        font-size: 12px;
    }
}

    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="submit">Login</button>
        </form>
        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>$error_message</p>";
        }
        ?>
    </div>

</body>
</html>