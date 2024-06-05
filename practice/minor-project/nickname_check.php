<?php
session_start();
include 'db_connect.php';

$nickname = $_POST['nickname'];


$sql = "SELECT * FROM User WHERE nickname='$nickname'";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    echo "taken";
} else {
    echo "available";
}

$db->close();
?>
