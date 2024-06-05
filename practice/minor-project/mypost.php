<?php
session_start();
include 'db_connect.php';

$uid = $_SESSION['uid'];
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$query = "SELECT p.uid, p.text, p.score, p.likes, p.createdDate 
          FROM Post p 
          JOIN User u ON p.uid = u.uid
          WHERE p.uid = $uid
          ORDER BY p.createdDate DESC";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My SNS Posts</title>
    <link rel="stylesheet" type="text/css" href="post_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    
</head>
<body>
    <div class="container">
    <div class="header">
            <button onclick="window.location.href='/practice/minor-project/home.php'"><</button>
            <h1>My Posts</h1>
            
        </div>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<p>" . htmlspecialchars($row['text']) . "</p>";
                echo "<p class='meta'>Score: " . htmlspecialchars($row['score']) . " | Posted on: " . htmlspecialchars($row['createdDate']) . " | likes: " . htmlspecialchars($row['likes']) ."</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No posts found.</p>";
        }
        $db->close();
        ?>
    </div>
</body>
</html>
