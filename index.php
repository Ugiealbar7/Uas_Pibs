<?php
include 'db.php'; 

session_start();

$message = '';

if (isset($_POST['submit'])) {
    $ruang = $_POST['ruang'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];

    $check_availability_query = "SELECT * FROM peminjaman WHERE ruang = '$ruang' AND tanggal = '$tanggal' AND waktu = '$waktu' AND status != 'rejected'";
    $result = $conn->query($check_availability_query);

    if ($result->num_rows > 0) {
        $message = "Room is not available at the selected date and time.";
    } else {
        $query = "INSERT INTO peminjaman (ruang, tanggal, waktu, status) VALUES ('$ruang', '$tanggal', '$waktu', 'pending')";
        if ($conn->query($query)) {
            header("Location: index.php?status=success");
            exit;
        } else {
            header("Location: index.php?status=error");
            exit;
        }
    }
}

$footer_query = "SELECT * FROM footer_header WHERE id = 1";
$footer_result = $conn->query($footer_query);
$footer_data = $footer_result->fetch_assoc();

$query = "SELECT title FROM footer_header LIMIT 1";
$result = $conn->query($query);
$header_data = $result->fetch_assoc();

$rooms = ['Ruang A', 'Ruang B', 'Ruang C', 'Ruang D'];

$latest_reservation_query = "SELECT ruang, tanggal, waktu, status FROM peminjaman ORDER BY id DESC LIMIT 1";
$latest_reservation_result = $conn->query($latest_reservation_query);
$latest_reservation = $latest_reservation_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Ruangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #007bff, #6a11cb);
        color: white;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: rgba(0, 0, 0, 0.6);
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    header h1 {
        font-size: 32px;
        margin-left: 10px;
    }

    .logo {
        width: 60px;
        height: auto;
    }

    .main-container {
        display: flex;
        gap: 30px;
        justify-content: space-between;
        flex-wrap: wrap;
        padding: 40px;
    }

    nav {
        width: 220px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        transition: box-shadow 0.3s ease;
    }

    article {
        flex: 1;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        width: 70%;
    }

    aside {
        width: 300px;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    nav:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    nav ul {
        list-style: none;
        padding: 0;
    }

    nav ul li {
        margin-bottom: 20px;
    }

    nav ul li a {
        color: white;
        font-size: 16px;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 8px;
        background-color: rgba(255, 255, 255, 0.2);
        display: block;
        transition: background-color 0.3s;
    }

    nav ul li a:hover {
        background-color: rgba(255, 255, 255, 0.4);
    }

    article h2 {
        font-size: 28px;
        color: #007bff;
        margin-bottom: 20px;
    }

    .room-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .room-item {
        background: rgba(255, 255, 255, 0.3);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .room-item:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .room-image {
        width: 100%;
        height: auto;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .room-item:hover .room-image {
        transform: scale(1.1);
    }

    .room-name {
        font-size: 18px;
        color: #007bff;
        font-weight: bold;
        margin-top: 10px;
    }

    .status-list {
        margin-top: 20px;
        background-color: rgba(255, 255, 255, 0.3);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .footer {
        background-color: rgba(0, 0, 0, 0.7);
        padding: 20px;
        color: white;
        text-align: center;
    }

    .footer .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .footer p {
        margin: 5px;
        font-size: 14px;
    }
</style>
<body>
    <header>
        <img src="https://eventkampus.com/data/sekolah/28-4.jpeg" alt="Logo" class="logo">
        <h1><?php echo $header_data['title']; ?></h1>
    </header>

    <div class="main-container">
        <nav>
            <h3>Menu</h3>
            <ul>
                <li><a href="index.php"><i class="fas fa-user"></i> Halaman User</a></li>
                <li><a href="login.php"><i class="fas fa-user-shield"></i> Halaman Admin</a></li>
            </ul>
        </nav>

        <article>
            <h2>Daftar Ruangan yang Tersedia</h2>
            <p>Silakan pilih ruangan untuk mengajukan peminjaman.</p>

            <div class="room-list">
                <?php 
                $room_images = [
                    'Ruang A' => 'images/ruang_a.jpg',
                    'Ruang B' => 'images/ruang_b.jpg',
                    'Ruang C' => 'images/ruang_c.jpg',
                    'Ruang D' => 'images/ruang_d.png'
                ];

                foreach ($rooms as $room): 
                ?>
                    <div class="room-item">
                        <a href="reservation.php?ruang=<?php echo urlencode($room); ?>" class="room-link">
                            <img src="<?php echo $room_images[$room]; ?>" alt="<?php echo $room; ?>" class="room-image">
                            <div class="room-name"><?php echo $room; ?></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </article>

        <aside>
            <h3>Status Peminjaman Terakhir</h3>
            <div class="status-list">
                <?php if ($latest_reservation): ?>
                    <p><strong>Ruangan:</strong> <?php echo htmlspecialchars($latest_reservation['ruang']); ?></p>
                    <p><strong>Tanggal:</strong> <?php echo htmlspecialchars($latest_reservation['tanggal']); ?></p>
                    <p><strong>Waktu:</strong> <?php echo htmlspecialchars($latest_reservation['waktu']); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($latest_reservation['status']); ?></p>
                <?php else: ?>
                    <p>Belum ada peminjaman ruangan yang dilakukan.</p>
                <?php endif; ?>
            </div>
        </aside>
    </div>

       <footer class="footer">
    <div class="footer-content">
        <div class="social-media">
            <?php if (isset($_SESSION['username'])): ?>
                <p>Twitter: <?php echo htmlspecialchars($_SESSION['username']); ?>@twitter</p>
                <p>Facebook: <?php echo htmlspecialchars($_SESSION['username']);?> @facebook</p>
                <p>Instagram: <?php echo htmlspecialchars($_SESSION['username']);?> @instagram</p>
            <?php else: ?>
                <p>Belum ada pengguna yang login.</p>
            <?php endif; ?>
        </div>
        <div class="copyright">
            <p>© Copyright 2020. All Rights Reserved</p>
        </div>
        <div class="project">
        <p><?php echo htmlspecialchars($footer_data['project']); ?></p>
      </div>
    </div>
</footer>
</body>
</html>
