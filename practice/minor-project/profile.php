<?php
session_start();
include 'auth_check.php';

include 'db_connect.php';

$uid = $_SESSION['uid'];

$query = "SELECT userId, nickname, gender, city FROM User WHERE uid='$uid'";
$result = mysqli_query($db, $query) or die(mysqli_error($db));

$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nickname = mysqli_real_escape_string($db, $_POST['nickname']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $city = mysqli_real_escape_string($db, $_POST['city']);

    if (empty($nickname)) {
        $error = "Nickname cannot be empty.";
    } else {
 
        $nicknameQuery = "SELECT uid FROM User WHERE nickname='$nickname' AND uid != '$uid'";
        $nicknameResult = mysqli_query($db, $nicknameQuery) or die(mysqli_error($db));
        if (mysqli_num_rows($nicknameResult) > 0) {
            $error = "Nickname already taken. Please choose another one.";
        } else {
            $updateQuery = "UPDATE User SET nickname='$nickname', gender='$gender', city='$city' WHERE uid='$uid'";
            if (mysqli_query($db, $updateQuery)) {
                $success = "Profile updated successfully.";
                // Refresh user data
                $result = mysqli_query($db, $query) or die(mysqli_error($db));
                $user = mysqli_fetch_assoc($result);
            } else {
                $error = "Failed to update profile. Please try again.";
            }
        }
    }
}
?>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" type="text/css" href="profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    
</head>
<body>
<div class="container">
    <div class="header">
        <button onclick="window.location.href='/practice/minor-project/home.php'"><</button>

    <h1>Edit Profile</h1>
    </div>
    
    <?php if ($user): ?>
        <form method="POST" action="">
            <p>ID: <?php echo htmlspecialchars($user['userId']); ?></p> <br/>
            <p>Nickname:</p> <br/> 
                <input type="text" name="nickname" value="<?php echo htmlspecialchars($user['nickname']); ?>" required>
            <div>
                <label for="gender">Gender:</label><br />
                <select name="gender" id="gender">
                    <option value="male" <?php if ($user['gender'] == 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if ($user['gender'] == 'female') echo 'selected'; ?>>Female</option>
                </select>
            </div>
            <div>
                <label for="city">City:</label><br />
                <select name="city" id="city">
                    <option value="Seoul" <?php if ($user['city'] == 'Seoul') echo 'selected'; ?>>Seoul</option>
                    <option value="Busan" <?php if ($user['city'] == 'Busan') echo 'selected'; ?>>Busan</option>
                    <option value="Incheon" <?php if ($user['city'] == 'Incheon') echo 'selected'; ?>>Incheon</option>
                    <option value="Daegu" <?php if ($user['city'] == 'Daegu') echo 'selected'; ?>>Daegu</option>
                    <option value="Daejeon" <?php if ($user['city'] == 'Daejeon') echo 'selected'; ?>>Daejeon</option>
                    <option value="Gwangju" <?php if ($user['city'] == 'Gwangju') echo 'selected'; ?>>Gwangju</option>
                </select>
            </div>
            <?php if (isset($success)): ?>
        <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
                <button type="submit" value="Save">Save</button>
            </form>
        <?php else: ?>
            <p>User information not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
