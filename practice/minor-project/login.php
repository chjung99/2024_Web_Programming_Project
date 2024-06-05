<?php
session_start();
include 'db_connect.php';

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userId = $_POST['userId'];
    $password = $_POST['password'];


    $query = "SELECT uid, userId, password FROM User WHERE userId = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();


    $row = $result->fetch_assoc();

    if ($result->num_rows == 1 && $password == $row['password']) {

        $_SESSION['uid'] = $row['uid'];
        $response['success'] = true;
        $response['message'] = "Login successful.";
    } else {

        $response['success'] = false;
        $response['message'] = "Invalid username or password.";
    }

    $stmt->close();
} else {

    $response['success'] = false;
    $response['message'] = "Invalid request.";
}


header('Content-Type: application/json');
echo json_encode($response);
?>
