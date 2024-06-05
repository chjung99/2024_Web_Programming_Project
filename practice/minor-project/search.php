<!DOCTYPE html>
<html>
<head>
    <title>User Search Results</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>User Search Results</h2>
    <?php
    include 'db_connect.php';

    $searchTerm = $_GET["searchTerm"];

    $sql = "SELECT userId, nickname, gender, city FROM User WHERE userId = ? OR nickname = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Nickname</th><th>Gender</th><th>City</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["userId"] . "</td>";
            echo "<td>" . $row["nickname"] . "</td>";
            echo "<td>" . $row["gender"] . "</td>";
            echo "<td>" . $row["city"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No users found";
    }
    $conn->close();
    ?>
</body>
</html>
