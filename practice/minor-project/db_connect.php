<?php
$db = mysqli_connect('localhost', 'root', '') or die("unable to connect!"); 

mysqli_select_db($db, 'myweb') or die(mysqli_error($db));
?>