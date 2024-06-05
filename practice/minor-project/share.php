<?php
session_start();
include 'db_connect.php';

$uid = $_SESSION['uid'];
$highestScore = $_COOKIE['highestScore'];
$text = $_POST['userText'];
$message = "";

if (isset($uid) && isset($highestScore)) {
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $query = "INSERT INTO Post (uid, text, score) VALUES (?, ?, ?)";
    $stmt = $db->prepare($query);
    
    $stmt->bind_param("isi", $uid, $text, $highestScore);

    if ($stmt->execute()) {
        $message = "Your post has been uploaded successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $db->close();
} else {
    $message = "UID or Highest Score not set.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Result</title>
    <link rel="stylesheet" type="text/css" href="sharephp_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <p><?php echo $message; ?></p>
        <button onclick="window.location.href='mypost.php';">See My Posts</button>
        <button onclick="window.location.href='dino.php';">Resume Game</button>
    </div>
</body>
</html>
