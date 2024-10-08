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
            <a href="about_me.html">Tentang Saya</a>
            <a href="input_form.php">Tambah Data</a>
            <a href="view_teams.php">Lihat Tim</a>
        </div>
        <button class="dark-mode-toggle" id="dark-mode-toggle"><i class="fa-solid fa-sun"></i></button>
    </nav>

    <section class="rank">
        <h2>Data Tim</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tim</th>
                    <th>Win Rate (%)</th>
                    <th>Skor</th>
                    <th>W - L</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $count = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $count . "</td>
                                <td>" . $row["team_name"] . "</td>
                                <td>" . $row["win_rate"] . "%</td>
                                <td>" . $row["score"] . "</td>
                                <td>" . $row["matches"] . "</td>
                                <td>
                                    <a href='edit_team.php?id=" . $row["id"] . "'>Edit</a> |
                                    <a href='delete_team.php?id=" . $row["id"] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                                </td>
                              </tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No teams found</td></tr>";
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