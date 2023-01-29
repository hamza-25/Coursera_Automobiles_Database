<?php 
session_start();
if(isset($_POST["submit"])){
    $email = $_POST['email'];
    $userPss = md5($_POST['pass']);
    $storedPss = md5("php123");
    if(strlen($email) > 0 && strlen($userPss) > 0){
        $_SESSION["errors"] = [];
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $_SESSION["errors"][]='must be an email';
        }
        if($storedPss != $userPss){
            $_SESSION["errors"][]='Incorrect password';
        }
        if(count( $_SESSION["errors"])==0){
            $_SESSION['email']= $email;
            return header("Location: index.php");
        }else{
            return header("Location: login.php");
        }
    }else{
        $_SESSION['message'] = 'User name and password are required' ;
       return header("Location: login.php");
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
    <h1>Please Log In</h1>
    <p style="color: red;">
    <?php
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    if(isset( $_SESSION["errors"])){
        foreach( $_SESSION["errors"] as $value){
            echo $value . '<br>';
        }
        unset( $_SESSION["errors"] );
       
    }
    ?>
    </p>
    <form action="" method="post">
        email <input type="text" name="email"><br>
        password <input type="password" name="pass"><br>
        <input type="submit" value="Log In" name="submit">
        <a href="index.php">Cancel</a>
    </form>
    <p>For a password hint, view source and find a password hint in the HTML comments.</p>
    
</body>
</html>