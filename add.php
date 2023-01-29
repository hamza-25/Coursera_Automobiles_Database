<?php
require_once "pdo.php";
session_start();
if (!isset($_SESSION['email'])) {
    die("ACCESS DENIED");
}
if (isset($_POST["submit"])) {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $mileage = $_POST['mileage'];
    if (isset($make) && isset($model) && isset($year) && isset($mileage)) {
        $_SESSION["errors"] = [];
        if (!is_numeric($year)) {
            $_SESSION["errors"][] = "All fields are required";
        }
        if (!is_numeric($mileage)) {
            $_SESSION["errors"][] = "mileage must be an integer";
        }
        if (count($_SESSION["errors"]) == 0) {
            $sql= ("INSERT INTO misc.autoss (make,model,year,mileage) values (:ma,:mo,:y,:mi)");
            $stmt= $conn->prepare($sql);
            $stmt->execute([
                ":ma"=>"$make",
                ":mo"=>"$model",
                ":y"=>$year,
                ":mi"=>$mileage
            ]);
            $_SESSION["insert"]="Record added.";
            return header("Location: index.php");
        } else {
            return header("Location: add.php");
        }
    } else {
        $_SESSION["message"] = "All fields are required";
        return header("Location: add.php");
    }
}
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
    <h1>Tracking Automobiles for <?php echo $_SESSION['email']; ?></h1>

    <p style="color: red;">
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        if (isset($_SESSION["errors"])) {
            foreach ($_SESSION["errors"] as $value) {
                echo $value . '<br>';
            }
            unset($_SESSION["errors"]);
        }
        ?>
    </p>

    <form method="post">
        make : <input type="text" name="make"><br>
        model : <input type="text" name="model"><br>
        year : <input type="text" name="year"><br>
        mileage : <input type="text" name="mileage"><br>
        <input type="submit" value="Add" name="submit">
        <button><a href="index.php">Cancel</a></button>

    </form>
</body>

</html>