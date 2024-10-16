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
                } else {
                    $upload_message = "Error: Failed to move uploaded file.";
                }
            }
        }
    }

    $sql = "INSERT INTO teams (team_name, win_rate, score, matches, image_path) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdiss", $team_name, $win_rate, $score, $matches, $image_path);

    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input - Tracker Stats Player Esport</title>

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

    <section class="rank">
        <div class="input-form">
            <h2>Form Input Data Tim</h2>
            <form id="teamForm" action="input_form.php" method="post" enctype="multipart/form-data">
                <label for="team_name">Nama Tim:</label>
                <input type="text" id="team_name" name="team_name" required>

                <label for="win_rate">Win Rate (%):</label>
                <input type="number" id="win_rate" name="win_rate" step="0.01" required>

                <label for="score">Skor Tim:</label>
                <input type="number" id="score" name="score" required>

                <label for="matches">Jumlah Kemenangan - Kekalahan (W - L):</label>
                <input type="text" id="matches" name="matches" placeholder="Misalnya: 5 - 1" required>

                <label for="team_image">Upload Gambar Tim (Max 5MB):</label>
                <input type="file" id="team_image" name="team_image" accept="image/jpeg,image/png,image/gif">

                <input type="submit" value="Kirim">
            </form>
            <?php if (!empty($upload_message)): ?>
                <p class="upload-message"><?php echo $upload_message; ?></p>
            <?php endif; ?>
        </div>
    </section>

    <div class="footer-container">
        <footer class="footer">
            <span class="footer-text">&copy; Wiam Wiam Wiam</span>
        </footer>
    </div>  

    <script src="script.js"></script>
</body>

</html>