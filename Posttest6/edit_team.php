<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trackers_stats";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$upload_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $team_name = $_POST["team_name"];
    $win_rate = $_POST["win_rate"];
    $score = $_POST["score"];
    $matches = $_POST["matches"];

    // Image upload handling
    $image_path = null;
    if (isset($_FILES['team_image']) && $_FILES['team_image']['error'] == 0) {
        $file = $_FILES['team_image'];
        $max_size = 5 * 1024 * 1024; // 5 MB
        
        if ($file['size'] > $max_size) {
            $upload_message = "Error: File size exceeds the maximum limit of 5 MB.";
        } else {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($file['type'], $allowed_types)) {
                $upload_message = "Error: Only JPG, PNG, and GIF files are allowed.";
            } else {
                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $new_filename = date('Y-m-d H.i.s') . '.' . $extension;
                $upload_dir = 'uploads/';
                
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $destination = $upload_dir . $new_filename;
                
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $image_path = $destination;
                    $upload_message = "Image uploaded successfully.";

                    // Delete old image if exists
                    $sql = "SELECT image_path FROM teams WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    if ($stmt === false) {
                        die("Error preparing statement: " . $conn->error);
                    }
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $old_image = $result->fetch_assoc();
                    $stmt->close();

                    if ($old_image['image_path'] && file_exists($old_image['image_path'])) {
                        unlink($old_image['image_path']);
                    }
                } else {
                    $upload_message = "Error: Failed to move uploaded file.";
                }
            }
        }
    }

    if ($image_path) {
        $sql = "UPDATE teams SET team_name=?, win_rate=?, score=?, matches=?, image_path=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("sdissi", $team_name, $win_rate, $score, $matches, $image_path, $id);
    } else {
        $sql = "UPDATE teams SET team_name=?, win_rate=?, score=?, matches=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param("sdisi", $team_name, $win_rate, $score, $matches, $id);
    }

    if ($stmt->execute()) {
        echo "Record updated successfully";
        header("Location: view_teams.php");
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
} else {
    $id = $_GET["id"];
    $sql = "SELECT * FROM teams WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team - Tracker Stats Player Esport</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <img src="images/valorant.png" alt="Valorant">
        <h1>Tracker Stats Player Esport</h1>
    </header>

    <nav>
        <div class="hamburger" id="hamburger">
            <i class="fa-solid fa-bars"></i>
        </div>
        <div class="nav-links">
            <a href="index.php">Beranda</a>
            <a href="input_form.php">Tambah Data</a>
            <a href="view_teams.php">Lihat Tim</a>
            <a href="about_me.html">Tentang Saya</a>
        </div>
        <button class="dark-mode-toggle" id="dark-mode-toggle"><i class="fa-solid fa-sun"></i></button>
    </nav>
    <section>
        <h2>Edit Data Tim</h2>
        <form action="edit_team.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            
            <label for="team_name">Nama Tim:</label>
            <input type="text" id="team_name" name="team_name" value="<?php echo $row['team_name']; ?>" required>

            <label for="win_rate">Win Rate (%):</label>
            <input type="number" id="win_rate" name="win_rate" step="0.01" value="<?php echo $row['win_rate']; ?>" required>

            <label for="score">Skor Tim:</label>
            <input type="number" id="score" name="score" value="<?php echo $row['score']; ?>" required>

            <label for="matches">Jumlah Kemenangan - Kekalahan (W - L):</label>
            <input type="text" id="matches" name="matches" value="<?php echo $row['matches']; ?>" required>

            <label for="team_image">Upload Gambar Tim (Max 5MB):</label>
            <input type="file" id="team_image" name="team_image" accept="image/jpeg,image/png,image/gif">

            <?php if (isset($row['image_path']) && $row['image_path']): ?>
                <p>Current image: <img src="<?php echo $row['image_path']; ?>" alt="Current Team Image" style="max-width: 100px; max-height: 100px;"></p>
            <?php endif; ?>

            <input type="submit" value="Update">
        </form>
        <?php if (!empty($upload_message)): ?>
            <p class="upload-message"><?php echo $upload_message; ?></p>
        <?php endif; ?>
    </section>

    <div class="footer-container">
        <footer class="footer">
            <span class="footer-text">&copy; Wiam Wiam Wiam</span>
        </footer>
    </div>

    <script src="script.js"></script>
</body>

</html>