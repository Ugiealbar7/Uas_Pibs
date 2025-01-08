<?php
include 'db.php';

session_start();

$reservation_message = "";

$username = isset($_SESSION['username']) ? $_SESSION['username'] : "";

$ruang = isset($_GET['ruang']) ? $_GET['ruang'] : "";

if (isset($_POST['ruang'], $_POST['tanggal'], $_POST['waktu']) && $username) {
    $ruang = $_POST['ruang'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        $stmt = $conn->prepare("INSERT INTO peminjaman (user_id, ruang, tanggal, waktu) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $ruang, $tanggal, $waktu);
        if ($stmt->execute()) {
            $reservation_message = "Peminjaman berhasil ditambahkan!";
        } else {
            $reservation_message = "Terjadi kesalahan saat menambahkan peminjaman.";
        }
        $stmt->close();
    } else {
        $reservation_message = "Error: Username tersebut tidak ditemukan.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, rgb(30, 235, 242), rgb(218, 185, 253));
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            padding-top: 50px;
            padding-bottom: 50px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease-in-out;
        }
        .card:hover {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        .card-body {
            background-color: #fff;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .form-label {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ddd;
            padding: 12px;
            font-size: 16px;
            margin-bottom: 20px;
            transition: border 0.3s ease;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
            outline: none;
        }
        .btn-primary {
            background-color:rgb(25, 0, 255);
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        .btn-primary:hover {
            background-color:rgb(39, 0, 179);
        }
        .alert {
            margin-top: 20px;
            border-radius: 8px;
            font-size: 16px;
        }
        @media (max-width: 768px) {
            .container {
                padding-left: 10px;
                padding-right: 10px;
            }
            .card {
                padding: 15px;
            }
            .card-header {
                font-size: 20px;
            }
            .form-control {
                font-size: 14px;
            }
            .btn-primary {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Formulir Peminjaman Ruangan</h4>
                </div>
                <div class="card-body">
                    <?php if ($reservation_message): ?>
                        <div class="alert alert-info"><?= $reservation_message ?></div>
                    <?php endif; ?>

                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($username) ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="ruang" class="form-label">Nama Ruangan</label>
                            <input type="text" class="form-control" id="ruang" name="ruang" value="<?= htmlspecialchars($ruang) ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu" class="form-label">Waktu</label>
                            <input type="time" class="form-control" id="waktu" name="waktu" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Tambah Peminjaman</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
