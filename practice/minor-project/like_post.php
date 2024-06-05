<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postId = $_POST['postId'];

    if (isset($postId)) {

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        $query = "UPDATE Post SET likes = likes + 1 WHERE pid = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("i", $postId);

        if ($stmt->execute()) {
            echo "Liked successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $db->close();
    } else {
        echo "Post ID not set.";
    }
}
?>
