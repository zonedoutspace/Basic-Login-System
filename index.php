<?php

    require 'class/users.class.php';
    require 'class/config.php';
    $user = new User($HOST, $USER, $PASS, $DATABASE);

    if(isset($_POST['login'])){
        $username = addslashes($_POST['username']);
        $pass = addslashes($_POST['password']);
        $ip = $_SERVER['REMOTE_ADDR'];
        $user->postLogin($username, $pass, $ip);
    }

    if(isset($_POST['register'])){
        $username = addslashes($_POST['username']);
        $pass = addslashes($_POST['password']);
        $email = addslashes($_POST['email']);
        $ip = $_SERVER['REMOTE_ADDR'];
        $user->postRegister($username, $pass, $email, $ip);
    }

    if(isset($_GET['logout'])){
        $user->getLogout($LOGINPAGE);
    }


?>
<!DOCTYPE html>
<html>
    <head>
        <title>CMS Login</title>
    </head>
    <body>
        <?php
           if($_SESSION["AUTH"]) {
               echo "<p>Username: ".$_SESSION['username']."</p> \n";
               echo "<p><a href=\"?logout\">Logout</a></p> \n";
            } else {
        ?>
        <form method="POST">
            <label>Username: <input type="text" name="username"/></label>
            <label>Password: <input type="password" name="password" /></label>
            <input name="login" type="submit" value="Login" />
        </form>
        <form method="POST">
            <label>Username: <input type="text" name="username"/></label>
            <label>Password: <input type="password" name="password" /></label>
            <label>Email: <input type="email" name="email" /></label>
            <input name="register" type="submit" value="Register" />
        </form>
        <?php } ?>
    </body>
</html>