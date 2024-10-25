<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Enter Grades</title>
</head>
<body>
    
<?php
    require_once "config.php"; //connect to db

    $query1 = "SELECT * FROM Students ORDER BY lastName";
    $students = mysqli_query($conn, $query1);

    $query2 = "SELECT * FROM Assignments";
    $assignments = mysqli_query($conn, $query2);

    $error = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { //if form is submitted
        $studentID = $_POST['studentID'];
        foreach ($_POST['grades'] AS $num => $grade) {
            $grades[$num + 1] = $grade; //since autoinc starts at 1
        }
        $query = "SELECT * FROM Scores WHERE studentID = $studentID;";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) { //if student already has grades entered
            //while ($row = mysqli_fetch_array($assignments)) {
            foreach ($grades AS $assignmentID => $grade) {
                $sql = "UPDATE Scores SET grade = $grade WHERE studentID = $studentID AND assignmentID = $assignmentID;";  
                if (!($result = mysqli_query($conn, $sql))) {
                    $error = true;
                }
            } 
        } else { //if student does not exist in Scores table
            //while ($row = mysqli_fetch_array($assignments)) {
            foreach ($grades AS $assignmentID => $grade) {
                $sql = "INSERT INTO Scores (studentID, assignmentID, grade)
                VALUES ('$studentID', '$assignmentID', '$grade');";
                if (!($result = mysqli_query($conn, $sql))) {
                    $error = true;
                }
            }
        }
        if ($error) {
            print "<p>ERROR SOMETHING IS WRONG</p>";
        } else {
            print "<p>Grades successfully submitted.</p>";
        }
    }
?>

<div><p>Please select a student and enter their scores.</p></div>
    <form method = "post" action = "entergrades.php">
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