<?php
session_start();

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $uid = $_SESSION['uid'];

    $fid = $_POST['friendId'];
    $friendNickname = $_POST['friendNickname'];


    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    if (!empty($uid) && !empty($fid) && !empty($friendNickname)) {

        $checkQuery = "SELECT * FROM Friend WHERE uid = ? AND fid = ?";
        $checkStmt = $db->prepare($checkQuery);
        $checkStmt->bind_param("ii", $uid, $fid);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {

            $message = "This user is already your friend.";
        } else {

            $query = "INSERT INTO Friend (uid, fid, friendNickname) VALUES (?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param("iis", $uid, $fid, $friendNickname);

            if ($stmt->execute()) {
                $message = "Friend added successfully.";
            } else {
                $message = "Error: " . $stmt->error;
            }
            
            $stmt->close();
        }

        $checkStmt->close();
    } else {
        $message = "All fields are required.";
    }

    $db->close();
    echo $message;
    header("Location: friend.php");
    exit();
}
?>

