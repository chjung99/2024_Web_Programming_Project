<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postId = $_POST['postId'];
    $comment = $_POST['comment'];
    $uid = $_SESSION['uid'];

    if (isset($postId) && isset($comment) && isset($uid)) {
        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        $query = "INSERT INTO Comment (pid, uid, text) VALUES ( ?, ?, ?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("iis", $postId, $uid, $comment);

        if ($stmt->execute()) {
            echo "Comment added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $db->close();
    } else {
        echo "All fields are required.";
    }
}
?>
