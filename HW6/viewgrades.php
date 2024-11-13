<!doctype html>
<html lang="en">
<head>
    <div w3-include-html="gradestyles.html"></div>
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
        table, td, th {
            border-collapse: collapse;
        }
        td, th {
            padding: 8px;
            text-align: left;
        }
        tr:nth-child(even) {background-color: #f2f2f2;}
        th {
            background-color: mediumseagreen;
            color: white;
            font-weight: normal;
        }
    </style>

	<meta charset="utf-8">
	<title>Final Grades</title>
</head>
<body>

<p>View final grades for all students here.
    
<?php
    require_once "dbc.php"; //connect to db
    $conn = getDatabaseConnection();

    function calcfinal($conn, $id)
    //not the most elegant way to do this but hardcoding is easier in this case
    {
        $total = 0;
        $hw = 0;
        $quiz = 0;
        $lowest = 6;
        $sql = "SELECT * FROM Scores WHERE studentID = $id;";
        $scores = mysqli_query($conn, $sql);
        if ($scores->num_rows > 0) { //if student has grades entered
            while ($row = mysqli_fetch_array($scores)) {
                $grades[$row['assignmentID']] = $row['grade'];
            }
    
            for ($i = 1; $i <= 5; $i++) {
                $hw += $grades[$i];
            }
            $hw = ($hw / 5) * 0.2;
    
            for ($i = 6; $i <= 10; $i++) {
                if ($grades[$i] < $grades[$lowest])
                    $lowest = $i;
                $quiz += $grades[$i];
            }
            $quiz -= $grades[$lowest];
            $quiz = ($quiz / 4) * 0.1;
    
            $total = $hw + $quiz + ($grades[11] * 0.3) + ($grades[12] * 0.4);
    
            return round($total);
        } else {
            return NULL;
        }
    }
?>

<table><tr>
<th>Student ID</th><th>Name</th><th>Final Grade</th>
</tr>

<?php
    $sql = "SELECT * FROM Students;";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($result)) {
        print "<tr><td>" . $row['studentID'] . 
              "</td><td>" . $row['firstName'] . " " . $row['lastName'] .
              "</td><td>";
        $grade = calcfinal($conn, $row['studentID']);
        if ($grade != NULL) {
            print "$grade%";
        } else {
            print "No grades entered.";
        }
        print "</td></tr>";
    }
?>
</table>
<br>
<a href="entergrades.php"><button class="button">Enter more grades</button></a>

</body>
</html>