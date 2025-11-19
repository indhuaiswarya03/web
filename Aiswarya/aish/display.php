<?php
include("connect.php");
if($_POST){
$bookno= $_POST['bookno'];
$booktitle= $_POST['booktitle'];
$bookedition= $_POST['booked'];
$bookpub= $_POST['bookpub'];
$sql= mysqli_query($conn, "INSERT INTO book_details VALUES('$bookno', '$booktitle',
'$bookedition', '$bookpub')");
$query=mysqli_query($conn, "SELECT * FROM book_details"); }
?>
<html>
<head>
<title>Display Book Details</title>
</head>
<body>
<h2 align="center">Book Details</h2><br>
<table align="center" border="1px solid black">
<tr>
<th>Book Number</th>
<th>Title</th>
<th>Edition</th>
<th>Publisher</th>
</tr>
<tr>
<?php
while($row= mysqli_fetch_assoc($query)){
echo "<tr>";
echo "<td>". $row['id'] ."</td>"; //table coloum
name echo "<td>". $row['title'] ."</td>"; echo "<td>".
$row['edition'] ."</td>"; echo "<td>". $row['publisher'] ."</td>";
echo "</tr>";
} ?>
</tr>
</table>
</body>
</html>
