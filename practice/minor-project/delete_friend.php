<?php
session_start();

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $uid = $_SESSION['uid'];
  
    $fid = $_POST['friendId'];
    

    if (!empty($uid) && !empty($fid)) {

        $query = "DELETE FROM Friend WHERE uid = ? AND fid = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ii", $uid, $fid);

        if ($stmt->execute()) {
            $message = "Friend deleted successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        $message = "All fields are required.";
    }
    echo $message;
    $db->close();
}
header("Location: friend.php");
exit();
?>
