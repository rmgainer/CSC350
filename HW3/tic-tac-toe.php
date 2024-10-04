<?php 
    session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <title>Tic Tac Toe</title>
    <h1>Tic Tac Toe</h1>
</head>
<body>
<?php 
    include 'tic-tac-toe-functions.php'; 

    $count = 0;
    $whoseturn = 'X';

    function printboard($whoseturn, $gameover) {
        if (!$gameover) {
            print "<p>Turn: " . $whoseturn . "</p>";
        }
        print "<table><form method='post' action='tic-tac-toe.php'>";
        for ($i = 1; $i <= 3; $i++) {
            print "<tr>";
            for ($j = 1; $j <= 3; $j++) {
                print "<td";
                if ($_SESSION["$j-$i"]) {
                    if ($_SESSION["$j-$i"] == 'X') {
                        print " style='background-color:green;'>";
                    } else {
                        print " style='background-color:red;'>";
                    }
                    print $_SESSION["$j-$i"];
                } else {
                    if (!$gameover) {
                        print "><input type='submit' name='$j-$i' value='$whoseturn'>";
                    } else {
                        print " ";
                    }
                }
                print "</td>";
            }
            print "</tr>";
        }
        print "</form></table>";
    }

    function restart($whoseturn) {
        $gameover = true;
        printboard($whoseturn, true);
        $_SESSION = array();
        session_destroy();
        print "<p><form method='post' action='tic-tac-toe.php'>
               <input type='submit' value='Play again'></form></p>";
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        for ($i = 1; $i <= 3; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                if (isset($_POST["$j-$i"])) {
                    $_SESSION["$j-$i"] = $_POST["$j-$i"];
                    if ($_SESSION["$j-$i"] == 'X'){
                        $whoseturn = 'O';
                    }
                }
                if (isset($_SESSION["$j-$i"])) {
                    $count++;
                }
            }
        }
    }

    $winner = whoIsWinner();
    if ($winner != null) {
        print "<p>The winner is " . $winner . "!!</p>";
        restart($whoseturn);
    } else if ($count == 9) {
        print "<p>It's a draw.</p>";
        restart($whoseturn);
    } else {
        printboard($whoseturn, false);
    }

?>

</body>
</html>