<!doctype html>
<html lang="en">
<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 16px;
        }
        .button {
            border: none;
            background-color: mediumseagreen;
            color: white;
            font-size: 16px;
            padding: 8px;
            text-align: center;
            transition-duration: 0.4s;
            width: 160px;
        }
        .button:hover {
            background-color: seagreen;
        }
    </style>
    <div w3-include-html="gradestyles.html"></div>
	<meta charset="utf-8">
	<title>Enter Grades</title>
</head>
<body>
    
<?php
    require_once "dbc.php"; //connect to db
    $conn = getDatabaseConnection();

    $query1 = "SELECT * FROM Students ORDER BY lastName";
    $students = mysqli_query($conn, $query1);

    $query2 = "SELECT * FROM Assignments";
    $assignments = mysqli_query($conn, $query2);

    $error = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') { //if form is submitted
        $studentID = $_POST['studentID'];
        foreach ($_POST['grades'] AS $num => $grade) {
            if (is_numeric($grade))
                $grades[$num + 1] = $grade; //since autoinc starts at 1
            else
                $error = true;
        }
        $query = "SELECT * FROM Scores WHERE studentID = $studentID;";
        $result = mysqli_query($conn, $query);
        if ($result->num_rows > 0) { //if student already has grades entered
            foreach ($grades AS $assignmentID => $grade) {
                $sql = "UPDATE Scores SET grade = $grade WHERE studentID = $studentID AND assignmentID = $assignmentID;";  
                if (!($result = mysqli_query($conn, $sql))) {
                    $error = true;
                }
            } 
        } else { //if student does not exist in Scores table
            foreach ($grades AS $assignmentID => $grade) {
                $sql = "INSERT INTO Scores (studentID, assignmentID, grade)
                VALUES ('$studentID', '$assignmentID', '$grade');";
                if (!($result = mysqli_query($conn, $sql))) {
                    $error = true;
                }
            }
        }
        if ($error) {
            print "<p>Something went wrong. Please try again.</p>";
        } else {
            $sql = "SELECT firstName, lastName FROM Students WHERE studentID = $studentID;";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result))
                print "<p>Grades successfully submitted for " . $row['firstName'] . " " . $row['lastName'] . ".</p>";
        }
    }
?>

<div><p>Please select a student to enter or update their scores.</p></div>
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
            <tr><td><?php print $row['assignmentName']; ?>:</td><td><input type='number' name='grades[]' min='0' max='110' required>
        <?php endwhile; ?>
        
        
    </table>
    <br>
    <input type="submit" class="button" value="Enter grades">
    </form>

    <br>

    <form method="post" action="viewgrades.php">
        <input type="submit" class="button" value="See final grades">
    </form>

</body>
</html>