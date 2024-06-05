<?php
session_start();
include 'db_connect.php';

$userId = $_POST['userId'];


$sql = "SELECT * FROM User WHERE userId='$userId'";
$result = $db->query($sql);


if ($result->num_rows > 0) {

    echo "taken";
} else {

    echo "available";
}


$db->close();
?>
