<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, rgb(30, 235, 242), rgb(218, 185, 253));
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: rgba(73, 72, 72, 0.6);
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        header h1 {
            font-size: 32px;
            margin: 0;
        }

        nav {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 10px 20px;
            position: fixed;
            top: 80px;
            left: 0;
            width: 200px;
            height: 100%;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        nav ul li {
            margin: 0;
        }

        nav ul li a {
            color: white;
            font-size: 16px;
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.2);
            display: inline-block;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }

        .main-content {
            display: flex;
            justify-content: center;
            margin-left: 220px;
            padding: 20px;
            gap: 30px;
            flex-grow: 1;
            flex-wrap: wrap;
        }

        article.about-us {
            text-align: center;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            width: 40%;
        }

        article.about-us h2 {
            font-size: 28px;
            color: rgb(40, 40, 41);
        }

        article.about-us p {
            font-size: 16px;
            line-height: 1.6;
        }

        article.about-us ul {
            list-style-type: none;
            padding: 0;
        }

        article.about-us ul li {
            margin: 10px 0;
        }

        .room-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            width: 40%;
        }

        .room-box {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            padding: 10px;
            text-align: center;
        }

        .room-box img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .room-box p {
            font-size: 16px;
            margin-top: 10px;
            color: rgb(40, 40, 41);
        }

        footer {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            color: white;
            text-align: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>About Us</h1>
    </header>
    <nav>
        <ul>
            <li><a href="index.php"><i class="fas fa-user"></i> Halaman User</a></li>
            <li><a href="login.php"><i class="fas fa-user-shield"></i> Halaman Admin</a></li>
            <li><a href="aboutUs.php"><i class="fas fa-user-shield"></i> About Us</a></li>
        </ul>
    </nav>
    <div class="main-content">
        <article class="about-us">
            <h2>About Our Room Reservation System</h2>
            <p>
                Sistem Peminjaman Ruangan ini dirancang untuk memudahkan pengguna dalam melakukan reservasi ruangan secara online.
                Dengan antarmuka yang sederhana dan responsif, pengguna dapat dengan mudah memilih ruangan, tanggal, dan waktu yang diinginkan.
            </p>
            <p>
                Fitur utama aplikasi meliputi:
            </p>
            <ul>
                <li>Daftar ruangan yang tersedia lengkap dengan gambar.</li>
                <li>Status peminjaman yang transparan dan dapat dilacak.</li>
                <li>Pengelolaan reservasi oleh admin secara efisien.</li>
            </ul>
            <p>
                Kami berkomitmen untuk memberikan solusi terbaik untuk kebutuhan reservasi ruangan Anda.
                Jika ada pertanyaan atau masukan, jangan ragu untuk menghubungi kami.
            </p>
        </article>
        <div class="room-images">
            <div class="room-box">
                <img src="download.jpeg" alt="Ruangan 1">
                <p>Ruangan 1</p>
            </div>
            <div class="room-box">
                <img src="OIP (1).jpeg" alt="Ruangan 2">
                <p>Ruangan 2</p>
            </div>
            <div class="room-box">
                <img src="OIP.jpeg" alt="Ruangan 3">
                <p>Ruangan 3</p>
            </div>
            <div class="room-box">
                <img src="OIP (4).jpeg" alt="Ruangan 4">
                <p>Ruangan 4</p>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Sistem Peminjaman Ruangan. All rights reserved.</p>
    </footer>
</body>
</html>
