<?php 
    session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <title>Tic Tac Toe</title>
    <h1>Tic Tac Toe</h1>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="HandheldFriendly" content="True">
	<title>Tic Tac Toe</title>
	<style>
		/* Button background is blue with a black border*/
		button {
			background-color: #3498db;
			height: 100%;
			width: 100%;
			text-align: center;
			font-size: 20px;
			color: white;
			vertical-align: middle;
			border: 0px;
		}

		/* Styles the table cells to look like a tic-tac-toe grid */
		table td {
			text-align: center;
			vertical-align: middle;
			padding: 0px;
			margin: 0px;
			width: 75px;
			height: 75px;
			font-size: 20px;
			border: 3px solid #040404;
			color: white;
		}

		/* This shows a darker blue background when the mouse hovers over the buttons */
		button:hover,
		input[type="submit"]:hover,
		button:focus,
		input[type="submit"]:focus {
			background-color: #04469d;
			text-decoration: none;
			outline: none;
		}

	</style>
    
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
                        print "><button type='submit' name='$j-$i' value='$whoseturn'>$whoseturn</button>";
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