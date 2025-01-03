<?php
include 'db.php';

$reservation_message = "";

// Handle photo upload for room reservation
if (isset($_POST['upload_photo'])) {
    $reservation_id = $_POST['reservation_id'];
    if ($_FILES['room_photo']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["room_photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (getimagesize($_FILES["room_photo"]["tmp_name"]) !== false) {
            if (move_uploaded_file($_FILES["room_photo"]["tmp_name"], $target_file)) {
                $stmt = $conn->prepare("UPDATE peminjaman SET gambar = ? WHERE id = ?");
                $stmt->bind_param("si", $target_file, $reservation_id);
                $stmt->execute();
                $stmt->close();
                $reservation_message = "Photo updated successfully!";
            } else {
                $reservation_message = "Sorry, there was an error uploading your file.";
            }
        } else {
            $reservation_message = "File is not an image.";
        }
    }
}

// Handle photo deletion
if (isset($_POST['delete_photo'])) {
    $reservation_id = $_POST['reservation_id'];
    
    $stmt = $conn->prepare("SELECT gambar FROM peminjaman WHERE id = ?");
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $stmt->bind_result($gambar);
    $stmt->fetch();
    $stmt->close();

    if ($gambar && file_exists($gambar)) {
        unlink($gambar);

        $stmt = $conn->prepare("UPDATE peminjaman SET gambar = NULL WHERE id = ?");
        $stmt->bind_param("i", $reservation_id);
        $stmt->execute();
        $stmt->close();

        $reservation_message = "Photo deleted successfully!";
    } else {
        $reservation_message = "No photo to delete.";
    }
}
?>

<div class="container mt-3">
    <h2>Update or Delete Photo for Room Reservation</h2>
    <?php if ($reservation_message): ?>
        <div class="alert alert-info"><?= $reservation_message ?></div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pengguna</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $conn->prepare("SELECT * FROM peminjaman");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['ruang']}</td>
                    <td>";
                if ($row['gambar']) {
                    echo "<img src='{$row['gambar']}' width='100' alt='Room Image'>";
                } else {
                    echo "No photo available";
                }
                echo "</td>
                    <td>
                        <form method='post' enctype='multipart/form-data'>
                            <input type='hidden' name='reservation_id' value='{$row['id']}'>
                            <div class='mb-3'>
                                <label for='room_photo' class='form-label'>Update Photo</label>
                                <input type='file' class='form-control' name='room_photo' id='room_photo'>
                            </div>
                            <button type='submit' name='upload_photo' class='btn btn-primary'>Upload Photo</button>
                        </form>
                        <form method='post' style='margin-top:10px;'>
                            <input type='hidden' name='reservation_id' value='{$row['id']}'>
                            <button type='submit' name='delete_photo' class='btn btn-danger'>Delete Photo</button>
                        </form>
                    </td>
                </tr>";
            }
            $stmt->close();
            ?>
        </tbody>
    </table>
</div>
