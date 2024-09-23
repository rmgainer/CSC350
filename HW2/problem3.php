<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>HW 2 Problem 3</title>
 <style>
    table {
        font-weight: bold;
        text-align: center;
        font-family: "Courier New";  
    }
    td.a {
        color: red;
        width: 20px;
    }
    td.b {
        color: darkcyan;
        width: 20px;
    }
    
</style>   
</head>

<body>

<?php

$size = 9;
$edge = $size - 1;
$center = round($size / 2) - 1;

print "<table>";

for ($i = 0; $i < $size; $i++)
{
    print "<tr>";
    for ($j = 0; $j < $size; $j++)
    {
        print "<td ";
        if (($i == 0 && $j == 0) || ($i == $edge && $j == $edge))
            print "class='a'> / ";
        else if (($i == 0 && $j == $edge) || ($i == $edge && $j == 0))
            print "class='a'> \\ ";
        else if ($i == $center && $j == $center)
            print "class='b'> + ";
        else if ($i == 0)
            print "class='a'> — ";
        else if ($i == $center && $j != 0 && $j != $edge && $j != $center)
            print "class='b'> — ";
        else if ($i == $edge)
            print "class='a'> _ ";
        else if ($j == 0 || $j == $edge)
            print "class='a'> |";
        else if ($j == $center)
            print "class='b'> | ";
        else
            print " ";
        print "</td>";
    }
    print "</tr>";
}
    

?>

</body>
</html>
