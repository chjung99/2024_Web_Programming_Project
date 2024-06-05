<?php
session_start();

include 'auth_check.php';

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    setcookie('highestScore', '', time() - 3600, '/');
    header("Location: login_form.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <button onclick="window.location.href='/practice/minor-project/dino.php'">Game Start</button> <br/>
        <button onclick="window.location.href='/practice/minor-project/post.php'">Post</button><br/>
        <button onclick="window.location.href='/practice/minor-project/profile.php'">Edit Profile</button><br/>
        <button onclick="window.location.href='/practice/minor-project/rank.php'">Rank</button><br/>
        <button onclick="window.location.href='/practice/minor-project/friend.php'">Friends</button><br/>
        
        <!-- 로그아웃 버튼 -->
        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
</body>
</html>
