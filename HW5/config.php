<?php
$conn = @mysqli_connect('localhost', 'csc350', 'xampp', 'grades');
if ($conn === false) {
    die("connection failed." . mysqli_connect_error());
}
?>