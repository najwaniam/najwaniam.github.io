<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trackers_stats";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM teams";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Teams - Tracker Stats Player Esport</title>
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
        <h2>Data Tim</h2>
        <table class="team-table">
            <thead>
                <tr>
                    <th class="center-align">No</th>
                    <th class="center-align">Gambar Tim</th>
                    <th class="center-align">Nama Tim</th>
                    <th class="center-align">Win Rate (%)</th>
                    <th class="center-align">Skor</th>
                    <th class="center-align">W - L</th>
                    <th class="center-align">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $count = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='center-align'>" . $count . "</td>
                                <td class='center-align'>" . ($row["image_path"] ? "<img src='" . $row["image_path"] . "' alt='Team Image' class='team-image'>" : "No Image") . "</td>
                                <td class='center-align'>" . $row["team_name"] . "</td>
                                <td class='center-align'>" . number_format($row["win_rate"], 2) . "%</td>
                                <td class='center-align'>" . $row["score"] . "</td>
                                <td class='center-align'>" . $row["matches"] . "</td>
                                <td class='center-align'>
                                    <a href='edit_team.php?id=" . $row["id"] . "'>Edit</a> |
                                    <a href='delete_team.php?id=" . $row["id"] . "' onclick='return confirm(\"Apakah Yakin Ingin Menghapus?\");'>Delete</a>
                                </td>
                              </tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='7' class='center-align'>No teams found</td></tr>";
                }
                ?>
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

<?php
$conn->close();
?>