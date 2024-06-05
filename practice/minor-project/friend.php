<!DOCTYPE html>
<html>
<head>
    <title>User Search</title>
    <link rel="stylesheet" type="text/css" href="friend.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">

</head>
<body>
    <div class="container">
    <div class="header">
    <div>
        <button onclick="window.location.href='/practice/minor-project/home.php'"><</button>
        
    </div>
    <h2>User Search</h2>
    
    
</div>
    <form method="GET">
        <label for="searchTerm">Enter Nickname or ID:</label>
        <input type="text" id="searchTerm" name="searchTerm">
        <button type="submit">Search</button>
    </form>
    <?php
    session_start();
    include 'db_connect.php';

    if (isset($_GET["searchTerm"])) {

        $searchTerm = $_GET["searchTerm"];
        $currentUserId = $_SESSION['uid'];


        $sql = "SELECT u.uid, u.userId, u.nickname, u.gender, u.city 
                FROM User u 
                LEFT JOIN Friend f ON u.uid = f.fid AND f.uid = ? 
                WHERE (u.userId = ? OR u.nickname = ?) AND f.fid IS NULL AND u.uid != ?";
        $stmt = $db->prepare($sql);
        $searchTermLike = $searchTerm;
        $stmt->bind_param("issi", $currentUserId, $searchTerm, $searchTermLike, $currentUserId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            echo "<table>";
            echo "<tr>";
            echo "<th style='color: white;'>ID</th>";
            echo "<th style='color: white;'>Nickname</th>";
            echo "<th style='color: white;'>Gender</th>";
            echo "<th style='color: white;'>City</th>";
            echo "<th style='color: white;'>Add to Friends</th>";
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["userId"] . "</td>";
                echo "<td>" . $row["nickname"] . "</td>";
                echo "<td>" . $row["gender"] . "</td>";
                echo "<td>" . $row["city"] . "</td>";
                echo '<td>
                        <form action="add_friend.php" method="POST" style="display:inline;">
                            <input type="hidden" name="friendId" value="' . $row["uid"] . '">
                            <input type="hidden" name="friendNickname" value="' . $row["nickname"] . '">
                            <button type="submit">Add to Friends</button>
                        </form>
                      </td>';
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No users found" . "<br/>";
        }

        
    }

    echo "<h2>Friends List</h2>";
    // $sql = "SELECT fid, friendNickname, createdDate FROM Friend WHERE uid = ?";
    $sql = "SELECT r.uid, r.score, f.fid, f.friendNickname, f.createdDate FROM Friend f LEFT JOIN Record r ON f.fid = r.uid WHERE f.uid = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $_SESSION['uid']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        echo "<table>";
        echo "<tr>";
        echo "<th style='color: white;'>Nickname</th>";
        echo "<th style='color: white;'>Score</th>";
        echo "<th style='color: white;'>Became Friends At</th>";
        echo "<th style='color: white;'>Delete</th>";
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["friendNickname"] . "</td>";
            
            echo "<td>" . $row["score"] . "</td>";
            echo "<td>" . $row["createdDate"] . "</td>";
            echo '<td>
                    <form action="delete_friend.php" method="POST" style="display:inline;">
                        <input type="hidden" name="friendId" value="' . $row["fid"] . '">
                        <button type="submit">Delete</button>
                    </form>
                  </td>';
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No friends found.";
    }
    $db->close();
    ?>
    </div>
</body>
</html>
