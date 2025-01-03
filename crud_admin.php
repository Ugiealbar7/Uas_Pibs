<?php
include 'db.php';

session_start();
session_destroy();

$page_name = $title = $content = "";
$page_id = 0;
$reservation_message = "";

if (isset($_POST['add_page'])) {
    $page_name = htmlspecialchars($_POST['page_name']);
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    $stmt = $conn->prepare("INSERT INTO pages (page_name, title, content) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $page_name, $title, $content);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?status=success");
    exit();
}

if (isset($_POST['edit'])) {
    $page_id = $_POST['id'];
    $stmt = $conn->prepare("SELECT * FROM pages WHERE id = ?");
    $stmt->bind_param("i", $page_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $page_name = $row['page_name'];
    $title = $row['title'];
    $content = $row['content'];
    $stmt->close();
}

if (isset($_POST['update'])) {
    $page_id = $_POST['id'];
    $page_name = htmlspecialchars($_POST['page_name']);
    $title = htmlspecialchars($_POST['title']);
    $content = htmlspecialchars($_POST['content']);

    $stmt = $conn->prepare("UPDATE pages SET page_name = ?, title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("sssi", $page_name, $title, $content, $page_id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?status=updated");
    exit();
}

if (isset($_POST['delete'])) {
    $page_id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM pages WHERE id = ?");
    $stmt->bind_param("i", $page_id);
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?status=deleted");
    exit();
}

if (isset($_POST['action']) && isset($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE peminjaman SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $reservation_id);
    $stmt->execute();
    $stmt->close();
    $reservation_message = "Reservation status updated to " . ucfirst($status) . ".";
}

if (isset($_POST['delete_reservation'])) {
    $reservation_id = $_POST['reservation_id'];

    $stmt = $conn->prepare("DELETE FROM peminjaman WHERE id = ?");
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $stmt->close();
    $reservation_message = "Reservation has been deleted.";
}

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$footer_query = "SELECT * FROM footer_header WHERE id = 1";
$footer_result = $conn->query($footer_query);
$footer_data = $footer_result->fetch_assoc();

$query = "SELECT title FROM footer_header LIMIT 1";
$result = $conn->query($query);
$header_data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Peminjaman Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #007bff, #6a11cb);
        color: white;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
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

    .navbar {
        background-color: #007bff;
        color: white;
    }

    .main-container {
        display: flex;
        gap: 30px;
        justify-content: space-between;
        flex-wrap: wrap;
        padding: 40px;
        flex: 1;
    }

    nav {
        width: 220px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        transition: box-shadow 0.3s ease;
    }

    nav button {
        color: white;
        font-size: 16px;
        background-color: rgba(255, 255, 255, 0.2);
        padding: 12px 20px;
        border-radius: 8px;
        border: none;
        width: 100%;
        text-align: center;
    }

    nav button:hover {
        background-color: rgba(255, 255, 255, 0.4);
    }

    article {
        flex: 1;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        width: 70%;
    }

    article h2 {
        font-size: 28px;
        color: #007bff;
        margin-bottom: 20px;
    }

    aside {
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 20px;
        width: 25%;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        margin-top: 20px;
    }

    .footer .footer-content {
     background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
}

.footer .social-media {
    text-align: left;
    flex: 1;
}

.footer .copyright {
    text-align: center;
    flex: 1;
}

.footer .project {
    text-align: right;
    flex: 1;
}

.footer p {
    margin: 5px;
    font-size: 14px;
}

@media (max-width: 768px) {
    .footer .footer-content {
        flex-direction: column;
        align-items: center;
    }
    .footer .social-media,
    .footer .copyright,
    .footer .project {
        text-align: center;
        margin: 5px 0;
    }
}
</style>

</head>
<body>

<header>
        <img src="https://eventkampus.com/data/sekolah/28-4.jpeg" alt="Logo" class="logo">
        <h1><?php echo $header_data['title']; ?></h1>
    </header>

<div class="main-container">
<nav>
    <button>Dashboard</button>
    <form action="index.php" method="get" style="margin-top: 10px;">
        <input type="hidden" name="action" value="logout">
        <button type="submit" class="btn btn-danger btn-sm w-100">Logout</button>
    </form>
</nav>



    <article>
        <h2>Daftar Peminjaman Ruangan</h2>

        <?php if ($reservation_message): ?>
            <div class="alert alert-success"><?= $reservation_message ?></div>
        <?php endif; ?>

        <h3>Manage Reservations</h3>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Ruangan</th>
                    <th>Nama Pengaju</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $conn->prepare("SELECT p.id, p.ruang, p.tanggal, p.waktu, p.status, u.username
                FROM peminjaman p
                JOIN users u ON p.user_id = u.id");

                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['ruang']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['tanggal']}</td>
                        <td>{$row['waktu']}</td>
                        <td>{$row['status']}</td>
                        <td>
                            <form method='post' class='d-inline'>
                                <input type='hidden' name='reservation_id' value='{$row['id']}'>
                                <select name='status' class='form-select form-select-sm d-inline w-auto'>
                                    <option value='pending' ".($row['status'] === 'pending' ? 'selected' : '').">Pending</option>
                                    <option value='approved' ".($row['status'] === 'approved' ? 'selected' : '').">Approved</option>
                                    <option value='rejected' ".($row['status'] === 'rejected' ? 'selected' : '').">Rejected</option>
                                </select>
                                <button type='submit' name='action' class='btn btn-success btn-sm'>Update</button>
                            </form>
                            <form method='post' class='d-inline'>
                                <input type='hidden' name='reservation_id' value='{$row['id']}'>
                                <button type='submit' name='delete_reservation' class='btn btn-danger btn-sm'>Delete</button>
                            </form>
                        </td>
                    </tr>";
                }
                $stmt->close();
                ?>
            </tbody>
        </table>
    </article>

    <aside>
        <h3>Info</h3>
        <p>Anda dapat mengelola reservasi ruangan melalui tabel ini. Perbarui status, hapus reservasi, atau tambahkan yang baru sesuai kebutuhan.</p>
    </aside>

</div>
<footer class="footer">
<div class="footer-content">
    <div class="social-media">
        <p>&copy; <?php echo $footer_data['social_media']; ?></p>
    </div>
    <div class="copyright">
        <p>&copy; <?php echo $footer_data['copyright']; ?></p>
    </div>
    <div class="project">
        <p>&copy; <?php echo $footer_data['project']; ?></p>
    </div>
</div>
</footer>
</body>
</html>
