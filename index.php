<?php
session_start();
require_once "pdo.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>85a7680f</title>
</head>

<body>
    <h1>Welcome to the Automobiles Database</h1>
    <p style="color: green;">
    <?php
    if(isset($_SESSION['insert'])) {
        echo $_SESSION['insert'];
        unset($_SESSION['insert']);
    }
    if(isset($_SESSION['delete'])) {
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }
    if(isset($_SESSION['norow'])) {
        echo $_SESSION['norow'];
        unset($_SESSION['norow']);
    }
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    if(isset($_SESSION['update'])) {
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    }
    
    ?>
    </p>

    <?php if (!isset($_SESSION["email"])) {

    ?>

        <a href="login.php">Please log in</a>
        <p>Attempt to <a href="add.php">add data</a> without logging in</p>

    <?php
    } else {
        $stmt = $conn->query("SELECT * FROM autoss");
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row == false) {
            echo "No rows found<br>";
        }else{
        echo "<table border='1'>";
        echo "<td>make</td>";
        echo "<td>model</td>";
        echo "<td>year</td>";
        echo "<td>mileage</td>";
        echo "<td>action</td>";
        while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
            echo "<tr><td>";
            echo(htmlentities($row['make']));
            echo("</td><td>");
            echo(htmlentities($row['model']));
            echo("</td><td>");
            echo(htmlentities($row['year']));
            echo("</td><td>");
            echo(htmlentities($row['mileage']));
            echo("</td><td>");
            echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
            echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
            echo("</td></tr>");
        }
     
        }

       
    ?>
        <a href="add.php">Add New Entry</a><br>
        <a href="logout.php">Logout</a>
    <?php
    }
    ?>
</body>

</html>