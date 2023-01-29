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
 else {
    $sql = ('SELECT * FROM misc.autoss WHERE autos_id = :id');
    $stmt = $conn->prepare($sql);
    $stmt->execute([":id" => $_GET["autos_id"]]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST["delete"]) && isset($_POST["id"])) {
    $sql = ('SELECT * FROM misc.autoss WHERE autos_id = :id');
    $stmt = $conn->prepare($sql);
    $stmt->execute([":id" => $_POST["id"]]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row){
        $sql = ('DELETE FROM misc.autoss WHERE autos_id = :id  ');
        $stmt = $conn->prepare($sql);
        $stmt->execute([":id"=>$_POST["id"]]);
        $_SESSION['delete'] = "Record deleted";
        return header("Location: index.php");
    }else{
        $_SESSION['id'] = "Bad value for id";
         return header("Location: index.php");
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
    <p>Confirm : Deleting <?= $row['make']?></p>
    <form action="" method="post">
        <input type="hidden" value="<?= $row['autos_id']?>" name="id">
        <input type="submit" value="Delete" name="delete">
    </form>
    <a href="index.php">Cancel</a>
</body>

</html>