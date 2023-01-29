<?php
require_once "pdo.php";
session_start();
if (!isset($_SESSION['email'])) {
    die("ACCESS DENIED");
}
if (empty($_GET["autos_id"])) {
    $_SESSION['id'] = "Bad value for id";
    return header("Location: index.php");
}
$sql = ('SELECT * FROM misc.autoss WHERE autos_id = :id');
$stmt = $conn->prepare($sql);
$stmt->execute([":id" => $_GET["autos_id"]]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    $_SESSION['norow'] = "Bad value for id";
    return header("Location: index.php");
}
if (isset($_POST["submit"])) {
    if (strlen($_POST['make']) > 0 && strlen($_POST['model']) > 0 && strlen($_POST['year']) > 0 && strlen($_POST['mileage']) > 0) {

        $_SESSION["errors"] = [];
        if (!is_numeric($_POST['year'])) {
            $_SESSION["errors"][] = "Year must be an integer";
        }
        if (!is_numeric($_POST['mileage'])) {
            $_SESSION["errors"][] = "mileage must be an integer";
        }
        if (count($_SESSION["errors"]) == 0) {
            $sql = ("UPDATE misc.autoss SET make = :ma,model=:mo,year=:y,mileage=:mi  WHERE autos_id = :autosId");
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ":autosId"=> $_GET["autos_id"],
                ":ma" => $_POST['make'],
                ":mo" => $_POST['model'],
                ":y" => $_POST['year'],
                ":mi" => $_POST['mileage']
            ]);
            $_SESSION["update"] = "Record updated.";
            return header("Location: index.php");
        } else {
            return header("Location: edit.php?autos_id=" . $_GET["autos_id"]);
        }
    } else {
        $_SESSION["messageUpdate"] = "All fields are required";
        return header("Location: edit.php?autos_id=" . $_GET["autos_id"] );
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
    <p style="color: red;">
        <?php
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $value) {
                echo $value . "<br>";
            }
            unset($_SESSION['errors']);
        }
        if (isset($_SESSION['messageUpdate'])) {

            echo $_SESSION['messageUpdate'] . "<br>";

            unset($_SESSION['messageUpdate']);
        }

        ?>
    </p>
    <form method="post">
        make : <input type="text" name="make" value="<?= $row['make'] ?>"><br>
        model : <input type="text" name="model" value="<?= $row['model'] ?>"><br>
        year : <input type="text" name="year" value="<?= $row['year'] ?>"><br>
        mileage : <input type="text" name="mileage" value="<?= $row['mileage'] ?>"><br>
        <input type="submit" value="Save" name="submit">
        <button><a href="index.php">Cancel</a></button>

    </form>
</body>

</html>