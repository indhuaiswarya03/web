<?php
include("connect.php");
?>
<html>
<head>
<title>Book Details</title>
</head>
<body>
<center>
<h2>Book Details</h2>
<form action="display.php" method="POST">
Book Number: <input type="text" name="bookno"><br><br>
Book Title: <input type="text" name="booktitle"><br><br>
Book Edition: <input type="number" name="booked"><br><br>
Book Publisher: <input type="text" name="bookpub" value=""><br><br>
<input type="submit" name="submit" value="Submit">
</form>
</center>
</body>
</html>
