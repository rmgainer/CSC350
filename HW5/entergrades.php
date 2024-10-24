<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Enter Grades</title>
</head>
<body>
    
<?php
    require_once "config.php";
    $query1 = "SELECT * FROM Students ORDER BY lastName";
    $students = mysqli_query($conn, $query1);
    $query2 = "SELECT * FROM Assignments";
    $assignments = mysqli_query($conn, $query2);
?>

<div><p>Please select a student and enter their scores.</p></div>
    <form method = "post" action = "submitgrades.php">
    <table>
        <tr><td><label for="studentID">Select student: </label>
        <td><select name="studentID" id="studentID" required>
        <?php while ($row = mysqli_fetch_array($students)) : ?>
            <option value="<?php print $row['studentID']; ?>">
            <?php print $row['firstName'] . ' ' . $row['lastName']; ?>
            </option>
        <?php endwhile; ?> 
        </select></tr>
        
        <?php while ($row = mysqli_fetch_array($assignments)) : ?>
            <tr><td><?php print $row['assignmentName']; ?>: </td><td><input type='number' name='grades[]' min='0' max='120' required>
        <?php endwhile; ?>
        
        </table>
        <br>
        <input type="submit" value="Enter grades">

    </form>

</body>
</html>