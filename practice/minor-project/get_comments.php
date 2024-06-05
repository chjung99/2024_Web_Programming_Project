<?php
session_start();
include 'db_connect.php';

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}


$postId = $_POST['postId'];

$query = "SELECT u.nickname, c.uid, c.pid, c.text, c.createdDate
          FROM Comment c JOIN User u
          ON c.uid = u.uid
          WHERE c.pid = $postId
          ORDER BY c.createdDate ASC";

$result = $db->query($query);

$comments = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $comment = array(
            'nickname' => $row['nickname'],
            'comment' => $row['text'],
            'createdDate' => $row['createdDate']
        );
        $comments[] = $comment;
    }
}


echo json_encode($comments);

$db->close();
?>
