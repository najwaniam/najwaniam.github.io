<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Tracker Stats Team Esport</title>

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <img src="images/valorant.png" alt="Valorant">
        <h1>Tracker Stats Team Esport</h1>
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

    <section class="hero">
        <div class="hero-content">
            <?php
            $heroImagePath = 'images/hero.png';

            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] == UPLOAD_ERR_OK) {
                $uploadedFileName = $_FILES['hero_image']['name'];
                $uploadedTempFile = $_FILES['hero_image']['tmp_name'];
                $fileExtension = strtolower(pathinfo($uploadedFileName, PATHINFO_EXTENSION));

                $allowedExtensions = ['jpg', 'jpeg', 'png'];

                if (in_array($fileExtension, $allowedExtensions)) {
                    $newHeroImagePath = 'images/hero.' . $fileExtension;

                    if (move_uploaded_file($uploadedTempFile, $newHeroImagePath)) {
                        $heroImagePath = $newHeroImagePath;
                    } else {
                        echo "<p>Error: Tidak dapat menyimpan gambar yang diunggah.</p>";
                    }
                } else {
                    echo "<p>Error: Format file tidak valid. Hanya file JPG, JPEG, dan PNG yang diperbolehkan.</p>";
                }
            }

            echo "<section class='hero' style='background: url(\"$heroImagePath\") no-repeat center center / cover; height: 300px; display: flex; justify-content: center; align-items: center;'>
                    <div class='hero-content'>
                        <h1>Tracker Stats Team Esport</h1>
                        <p>Lacak yang Terbaik, Jadilah yang Terbaik. Temukan Team Terbaik di Dunia Esports</p>
                    </div>
                  </section>";
            ?>
        </div>
    </section>

    <section class="slideshow">
        <h2>Galeri Foto</h2>
        <div class="slideshow-container">
            <?php
            $folder = 'fotoberanda';
            $files = glob($folder . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            
            foreach($files as $index => $file) {
                echo "<div class='mySlides fade'>";
                echo "<img src='$file' alt='Slideshow Image'>";
                echo "</div>";
            }
            ?>

            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
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