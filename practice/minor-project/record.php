<?php
session_start();
include 'db_connect.php';

$uid = $_SESSION['uid'];
$highestScore = $_COOKIE['highestScore'];


$query = "SELECT score FROM Record WHERE uid = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['score'] < $highestScore) {
        $updateQuery = "UPDATE Record SET score = ? WHERE uid = ?";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bind_param("ii", $highestScore, $uid);
        
        if ($updateStmt->execute()) {
            echo "Score updated successfully.";
        } else {
            echo "Failed to update score.";
        }
        $updateStmt->close();
    }
} else {
    $insertQuery = "INSERT INTO Record (uid, score) VALUES (?, ?)";
    $insertStmt = $db->prepare($insertQuery);
    $insertStmt->bind_param("ii", $uid, $highestScore);
    
    if ($insertStmt->execute()) {
        echo "Score inserted successfully.";
    } else {
        echo "Failed to insert score.";
    }
    $insertStmt->close();
}

$stmt->close();
$db->close();
?>