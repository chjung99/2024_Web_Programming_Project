<?php
include 'db_connect.php';

$query = "INSERT INTO User
        (userId, password, nickname, city, gender)
        VALUES ('{$_POST['userId']}', '{$_POST['password']}', '{$_POST['nickname']}', '{$_POST['city']}', '{$_POST['gender']}')";

mysqli_query($db, $query) or die(mysqli_error($db));
header("Location: login_form.html");
?>