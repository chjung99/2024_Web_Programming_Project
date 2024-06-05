<?php
session_start();
include 'db_connect.php';

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$query = "SELECT p.pid, p.uid, p.text, p.score, p.likes, p.createdDate, u.nickname 
          FROM Post p 
          JOIN User u ON p.uid = u.uid 
          ORDER BY p.createdDate DESC";
$result = $db->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My SNS Posts</title>
    <link rel="stylesheet" type="text/css" href="post_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <script>
        function likePost(postId) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "like_post.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    alert("Liked!");
                    window.location.reload();
                }
            };
            xhr.send("postId=" + postId);
        }

        function commentPost(postId) {
            var comment = prompt("Enter your comment:");
            if (comment) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "comment_post.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        alert("Comment added!");
                        window.location.reload();
                    }
                };
                xhr.send("postId=" + postId + "&comment=" + encodeURIComponent(comment));
            }
        }
        function loadComments(postId) {
        var commentSection = document.getElementById("comment-section-" + postId);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "get_comments.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onload = function() {
            if (xhr.status === 200) {
                var comments = JSON.parse(xhr.responseText);
                var html = "";
                comments.forEach(function(comment) {
                    html += "<div class='comment'>";
                    html += "<p>" + comment.comment + "</p>";
                    html += "<p class='meta'>Nickname: " + comment.nickname + "</p>";
                    html += "<p class='meta'>Commented on: " + comment.createdDate + "</p>";
                    html += "</div>";
                });
                commentSection.innerHTML = html;
            }
        };
        xhr.send("postId=" + postId);
    }
    </script>
</head>
<body>
    <div class="container">
        <div class="header">
            <button onclick="window.location.href='/practice/minor-project/home.php'"><</button>
            <h1>SNS Posts</h1>
            
        </div>
        
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<h3>" ."Nickname: ". htmlspecialchars($row['nickname']) . "</h3>" . "</br></br>";
                echo "<p>" . htmlspecialchars($row['text']) . "</p>";
                echo "<p class='meta'>Score: " . htmlspecialchars($row['score']) . " | Posted on: " . htmlspecialchars($row['createdDate']) . " | Likes: " . htmlspecialchars($row['likes']) . "</p>";
                echo "<button onclick='likePost(" . htmlspecialchars($row['pid']) . ")'>Like</button>";
                echo "<button class='comment' onclick='commentPost(" . htmlspecialchars($row['pid']) . ")'>Comment</button>";
                echo "<div id='comment-section-" . htmlspecialchars($row['pid']) . "' class='comment-section'></div>";
                echo "</div>";
                echo "<script>loadComments(" . htmlspecialchars($row['pid']) . ");</script>";
            }
        } else {
            echo "<p>No posts found.</p>";
        }
        $db->close();
        ?>
    </div>
</body>
</html>


