<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beranda - Tracker Stats Player Esport</title>

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
    <h1>Tracker Stats Player Esport</h1>
  </header>

  <nav>
    <div class="hamburger" id="hamburger">
      <i class="fa-solid fa-bars"></i>
    </div>
    <div class="nav-links">
      <a href="index.php">Beranda</a>
      <a href="about_me.html">Tentang Saya</a>
      <a href="input_form.php">Tambah Data</a>
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
                  <h1>Tracker Stats Player Esport</h1>
                  <p>Lacak yang Terbaik, Jadilah yang Terbaik. Temukan Pemain Terbaik di Dunia Esports</p>
              </div>
            </section>";
      ?>
    </div>
  </section>

  <section class="rank">
    <h2>Data Tim yang Dikirim</h2>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Tim</th>
          <th>Win Rate (%)</th>
          <th>Skor</th>
          <th>W - L</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>Bubblegun</td>
          <td>83.3%</td>
          <td>500</td>
          <td>5 - 1</td>
        </tr>
        <tr>
          <td>2</td>
          <td>XERXIA</td>
          <td>83.3%</td>
          <td>500</td>
          <td>5 - 1</td>
        </tr>
        <tr>
          <td>3</td>
          <td>LA FAMILIA</td>
          <td>83.3%</td>
          <td>500</td>
          <td>5 - 1</td>
        </tr>
        <tr>
          <td>4</td>
          <td>ARF Team</td>
          <td>83.3%</td>
          <td>500</td>
          <td>5 - 1</td>
        </tr>
        <tr>
          <td>5</td>
          <td>FPT Flash</td>
          <td>66.7%</td>
          <td>400</td>
          <td>4 - 2</td>
        </tr>
        <tr>
          <td>6</td>
          <td>AiM FortissyGod</td>
          <td>66.7%</td>
          <td>400</td>
          <td>4 - 2</td>
        </tr>
        <tr>
          <td>7</td>
          <td>THE OVERDOGS</td>
          <td>66.7%</td>
          <td>400</td>
          <td>4 - 2</td>
        </tr>
        <tr>
          <td>8</td>
          <td>Team NKT</td>
          <td>80.0%</td>
          <td>400</td>
          <td>4 - 1</td>
        </tr>
        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
          <tr>
            <td>9</td>
            <td><?php echo htmlspecialchars($_POST['team_name']); ?></td>
            <td><?php echo htmlspecialchars($_POST['win_rate']); ?>%</td>
            <td><?php echo htmlspecialchars($_POST['score']); ?></td>
            <td><?php echo htmlspecialchars($_POST['matches']); ?></td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </section>

  <div class="footer-container">
    <footer class="footer">
      <span class="footer-text">&copy; Wiam Wiam Wiam</span>
    </footer>
  </div>

  <script src="script.js"></script>
</body>

</html>