<!DOCTYPE html>
<html>
<head>
    <title>Record Table</title>
    <link rel="stylesheet" type="text/css" href="rank.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
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
    <div class="container">
        <div class ="header">
        <div>
        <button onclick="window.location.href='/practice/minor-project/home.php'"><</button>
    </div>
    <h2>Rank</h2>
    
    </div>
    <table>
        <tr>
            <th>Rank</th>
            <th>Nickname</th>
            <th>Score</th>
            <th>Created Date</th>
        </tr>
        <?php
        include 'db_connect.php';
        $sql = "SELECT * FROM Record r JOIN User u ON r.uid = u.uid ORDER BY score DESC";
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            $rank = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $rank++ . "</td>";
                echo "<td>" . $row["nickname"] . "</td>";
                echo "<td>" . $row["score"] . "</td>";
                echo "<td>" . $row["createdDate"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    </div>
</body>
</html>
