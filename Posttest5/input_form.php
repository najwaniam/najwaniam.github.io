<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trackers_stats";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $team_name = $_POST["team_name"];
    $win_rate = $_POST["win_rate"];
    $score = $_POST["score"];
    $matches = $_POST["matches"];

    $sql = "INSERT INTO teams (team_name, win_rate, score, matches) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdis", $team_name, $win_rate, $score, $matches);

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
  <style>
    section {
      max-width: 600px;
      margin: 40px auto;
      padding: 20px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    input[type="submit"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      background: #333;
      color: white;
      border: none;
      cursor: pointer;
    }

    input[type="submit"]:hover {
      background: #555;
    }
  </style>
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
        <a href="view_teams.php">Lihat Tim</a>
    </div>
    <button class="dark-mode-toggle" id="dark-mode-toggle"><i class="fa-solid fa-sun"></i></button>
  </nav>

  <section>
        <h2>Form Input Data Tim</h2>
        <form action="input_form.php" method="post">
            <label for="team_name">Nama Tim:</label>
            <input type="text" id="team_name" name="team_name" required>

            <label for="win_rate">Win Rate (%):</label>
            <input type="number" id="win_rate" name="win_rate" step="0.01" required>

            <label for="score">Skor Tim:</label>
            <input type="number" id="score" name="score" required>

            <label for="matches">Jumlah Kemenangan - Kekalahan (W - L):</label>
            <input type="text" id="matches" name="matches" placeholder="Misalnya: 5 - 1" required>

            <input type="submit" value="Kirim">
        </form>
    </section>

    <div class="footer-container">
        <!-- Footer content remains the same -->
    </div>  

    <script src="script.js"></script>
</body>

</html>