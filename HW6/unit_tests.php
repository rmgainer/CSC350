<?php
require_once "dbc.php";
require_once "viewgrades.php";
require_once "unitTestingHelper.php";

function create_test_student() {
    $conn = getDatabaseConnection();
    $sql = "INSERT INTO Students (studentID, firstName, lastName)
            VALUES ('1', 'Test', 'Test');";
    mysqli_query($conn, $sql);
}

function delete_test_student() {
    $conn = getDatabaseConnection();
    $sql = "DELETE FROM Scores WHERE studentID = 1;";
    mysqli_query($conn, $sql);
    $sql = "DELETE FROM Students WHERE studentID = 1;";
    mysqli_query($conn, $sql);
}

function test_database_connection() {
    $conn = getDatabaseConnection();
    assertTrue($conn, "Database connection made");
}

function test_calcfinal_is_correct() {
    $conn = getDatabaseConnection();
    $studentID = 1;
    $grades = [1 => 75, 2 => 89, 3 => 103, 4 => 55, 5 => 100, //hws
               6 => 65, 7 => 78, 8 => 99, 9 => 76, 10 => 69, //quizzes
               11 => 86, 12 => 90]; //midterm + final

    foreach ($grades as $assignmentID => $grade) {
        $sql = "INSERT INTO Scores (studentID, assignmentID, grade) 
                VALUES ($studentID, $assignmentID, $grade)";
        mysqli_query($conn, $sql);
    }

    $finalGrade = calcfinal($conn, $studentID);
    assertEqual($finalGrade, 87.0, "Calculation of final grade is correct");
}

function test_calcfinal_with_no_grades() {
    $conn = getDatabaseConnection();
    $studentID = 1;

    $sql = "DELETE FROM Scores WHERE studentID = $studentID;"; //removes grades from test student
    mysqli_query($conn, $sql);

    $finalGrade = calcfinal($conn, $studentID);
    assertEqual($finalGrade, NULL, "Returns null if no grades are entered");
}

function test_no_homeworks() {
    $conn = getDatabaseConnection();
    $studentID = 1;
    $grades = [6 => 65, 7 => 78, 8 => 99, 9 => 76, 10 => 69, //quizzes
               11 => 86, 12 => 90]; //midterm + final
    
    $sql = "DELETE FROM Scores WHERE studentID = $studentID;"; //removes grades from test student
    mysqli_query($conn, $sql);
    foreach($grades as $assignmentID => $grade) {
        $sql = "INSERT INTO Scores (studentID, assignmentID, grade)
                VALUES ($studentID, $assignmentID, $grade);";
        mysqli_query($conn, $sql);
    }
    $finalGrade =  calcfinal($conn, $studentID);
    assertEqual($finalGrade, 70.0, "Calculation is correct with no homeworks");
}

function test_no_quizzes() {
    $conn = getDatabaseConnection();
    $studentID = 1;
    $grades = [1 => 75, 2 => 89, 3 => 103, 4 => 55, 5 => 100, //homeworks
               11 => 86, 12 => 90]; //midterm + final
    
    $sql = "DELETE FROM Scores WHERE studentID = $studentID;"; //removes grades from test student
    mysqli_query($conn, $sql);
    foreach($grades as $assignmentID => $grade) {
        $sql = "INSERT INTO Scores (studentID, assignmentID, grade)
                VALUES ($studentID, $assignmentID, $grade);";
        mysqli_query($conn, $sql);
    }
    $finalGrade =  calcfinal($conn, $studentID);
    assertEqual($finalGrade, 79.0, "Calculation is correct with no quizzes");
}

function test_one_quiz() {
    $conn = getDatabaseConnection();
    $studentID = 1;
    $grades = [1 => 75, 2 => 89, 3 => 103, 4 => 55, 5 => 100, //homeworks
               6 => 30,
               11 => 86, 12 => 90]; //midterm + final
    
    $sql = "DELETE FROM Scores WHERE studentID = $studentID;"; //removes grades from test student
    mysqli_query($conn, $sql);
    foreach($grades as $assignmentID => $grade) {
        $sql = "INSERT INTO Scores (studentID, assignmentID, grade)
                VALUES ($studentID, $assignmentID, $grade);";
        mysqli_query($conn, $sql);
    }
    $finalGrade =  calcfinal($conn, $studentID);
    assertEqual($finalGrade, 87.0, "Calculation is correct with one quiz");
}