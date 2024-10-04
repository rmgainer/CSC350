<?php session_start(); 
$_SESSION['whoseturn'] = 'X'; ?>
<!doctype html>
<html lang="en">
<head>

</head>
<body>
<?php 
    include 'tic-tac-toe-functions.php'; 

    function printboard($whoseturn) {
        print "<table><form method='post' action='tic-tac-toe.php'>";
        for ($i = 1; $i <= 3; $i++) {
            print "<tr>";
            for ($j = 1; $j <= 3; $j++) {
                print "<td>";
                if ($_SESSION["$j-$i"]) {
                    print $_SESSION["$j-$i"];
                } else {
                    print "<input type='submit' name='$j-$i' value='$whoseturn'>";
                }
                print "</td>";
            }
            print "</tr>";
        }
        print "</form></table>"; 
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        for ($i = 1; $i <= 3; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                if (isset($_POST["$j-$i"])) {
                    $_SESSION["$j-$i"] = $_POST["$j-$i"];
                    if ($_SESSION["$j-$i"] == 'X'){
                        $whoseturn = 'O';
                    } else {
                        $whoseturn = 'X';                 
                    }
                }
            }
        }
    } else {
        $whoseturn = 'X';
    }
    printboard($whoseturn);
?>

</body>
</html>