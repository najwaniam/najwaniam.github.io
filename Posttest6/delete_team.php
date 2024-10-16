<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "trackers_stats";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Get the image path before deleting the record
    $sql = "SELECT image_path FROM teams WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $team = $result->fetch_assoc();
    $stmt->close();

    // Delete the record
    $sql = "DELETE FROM teams WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // If deletion is successful, delete the image file
        if ($team['image_path'] && file_exists($team['image_path'])) {
            unlink($team['image_path']);
        }
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

header("Location: view_teams.php");
exit();
?>