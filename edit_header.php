<?php
include 'db.php';

if (isset($_POST['update_header'])) {
    $header_title = htmlspecialchars($_POST['header_title']);
    
    // Ensure the query and binding work properly
    $stmt = $conn->prepare("UPDATE footer_header SET title = ? WHERE id = 1");
    if ($stmt) {
        $stmt->bind_param("s", $header_title);
        $stmt->execute();
        $stmt->close();
        // Redirect after successful update
        header("Location: edit_header.php?status=header_updated");
        exit();
    } else {
        echo "Error: Could not prepare the statement.";
    }
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
    <title>Edit Header</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
 body {
    font-family: 'Poppins', sans-serif;
    background: #f8f9fa; /* Background yang lebih terang untuk kesan lebih profesional */
    color: #495057;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

header {
    background-color: #003366; /* Warna biru tua, sama dengan desain user */
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    color: white;
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
    background-color: #007bff; /* Warna biru terang seperti pada halaman user */
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
    background-color: #003366; /* Warna biru tua, konsisten dengan header */
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

nav button {
    color: white;
    font-size: 16px;
    background-color: #00509e; /* Warna biru yang lebih terang dari header */
    padding: 12px 20px;
    border-radius: 8px;
    border: none;
    width: 100%;
    text-align: center;
}

nav button:hover {
    background-color: #003366; /* Ganti warna ketika tombol di-hover */
}

article {
    flex: 1;
    background-color: #ffffff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    width: 70%;
}

article h2 {
    font-size: 28px;
    color: #007bff; /* Warna biru terang seperti pada halaman user */
    margin-bottom: 20px;
}

aside {
    background-color: #f1f1f1;
    border-radius: 12px;
    padding: 20px;
    width: 25%;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    margin-top: 20px;
}

footer {
    background-color: #003366; /* Warna biru tua untuk footer */
    color: white;
    padding: 20px;
    text-align: center;
}

.footer .footer-content {
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

/* Media Queries for responsiveness */
@media (max-width: 1024px) {
    .main-container {
        flex-direction: column;
        gap: 20px;
        padding: 20px;
    }

    nav {
        width: 100%;
        margin-bottom: 20px;
    }

    article {
        width: 100%;
        padding: 20px;
    }

    aside {
        width: 100%;
        margin-top: 20px;
    }
}

@media (max-width: 768px) {
    header h1 {
        font-size: 24px;
    }

    .main-container {
        padding: 15px;
    }

    nav {
        width: 100%;
    }

    article {
        width: 100%;
        padding: 15px;
    }

    aside {
        width: 100%;
        padding: 15px;
    }

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

@media (max-width: 480px) {
    header {
        padding: 15px;
    }

    header h1 {
        font-size: 20px;
    }

    .logo {
        width: 50px;
    }

    nav button {
        font-size: 14px;
        padding: 10px 15px;
    }

    article h2 {
        font-size: 24px;
    }

    article {
        padding: 10px;
    }

    footer {
        padding: 15px;
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
        <button onclick="location.href='index.php'">Dashboard</button>
        <button onclick="location.href='edit_footer.php'" class="btn btn-primary btn-sm mt-2 w-100">Edit Footer</button>
        <form action="index.php" method="get" style="margin-top: 10px;">
            <input type="hidden" name="action" value="logout">
            <button type="submit" class="btn btn-danger btn-sm w-100">Logout</button>
        </form>
    </nav>

    <article>
        <h2>Edit Header</h2>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'header_updated'): ?>
            <div class="alert alert-success">Header updated successfully!</div>
        <?php endif; ?>
        <form action="edit_header.php" method="post">
            <div class="mb-3">
                <label for="header_title" class="form-label">Header Title</label>
                <input type="text" id="header_title" name="header_title" class="form-control" value="<?php echo htmlspecialchars($header_data['title']); ?>" required>
            </div>
            <button type="submit" name="update_header" class="btn btn-success">Update Header</button>
        </form>
    </article>

    <aside>
        <h3>Info</h3>
        <p>Halaman ini digunakan untuk memperbarui informasi header yang tampil pada semua halaman.</p>
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
