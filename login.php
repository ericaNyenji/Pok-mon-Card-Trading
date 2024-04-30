<?php
session_start();

//$errors = [];
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$error = false;
if($_POST){
    include_once('storage.php');//This line includes the content of the storage.php file in your current PHP script.
    $stor = new Storage (new JsonIO('users.json'));//It creates an instance of the Storage class, passing an instance of the JsonIO class as a parameter. The JsonIO class is likely responsible for handling input and output operations related to JSON data.

    $user = $stor -> findOne(['username' => $username]);//WE DON'T KNOW THE ID WE ONLY KNOW THE USER
    //var_dump($user);//array(8) { ["username"]=> string(5) "admin" ["email"]=> string(15) "admin@gmail.com" ["password"]=> string(5) "admin" ["isAdmin"]=> bool(true) ["amountOfMoneyInWallet"]=> int(1000) ["noOfCards"]=> int(10) ["cards"]=> array(3) { [0]=> string(7) "pikachu" [1]=> string(6) "Pidgey" [2]=> string(7) "Rattata" } ["id"]=> string(13) "5fcee306a7980" }

    if(!$user){//>>>IF $user IS NOOT ASSIGNED A VALUE
        //error : no such user
        $error = true;//good practice not to tell the user what the actual error was because he/she can guess that yes such a user exist but pswd is wrong...>>thus keep trying
    }else{
        if(!password_verify($password, $user['password'])){
            //error : password mismatch
            $error = true;
        }else{
            //successful login
            $_SESSION['user_id'] = $user['id'];//SESSION START SHOULD ALWAYS BE AT THE BEGINNING OF EVERY PAGE THAT YOU SESSION IN ANY WAY(OTHERWISE THIS WILL NOT BE STORED AND INDEXXX.PHP REDIRECTED ME back TO THE SAME PAGE because i forgot to CONTINUE MY EXISTING SESSION????THAE FIRST SESSION IS AT INDEX.PHP WE CONTINUE IT IN LOGIN.PHP)
            $_SESSION['money']= $user['amountOfMoneyInWallet'];
            $_SESSION['noOfCards'] = count($user['cards']);
            //$_SESSION['admin_id'] = 
            header('location: main.php');
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Login</h2>
    <?php if($error):?>
        <span style= "color:red">Invalid username and/or password!</span><br> <br>
    <?php endif ;?>

    <form action="login.php" method="POST">
        Username: <input type="text" name="username"> <br>
        Password : <input type="password" name="password"> <br>
        <button type="submit">Login</button>
    </form>
    <?php 
    //echo password_hash("example", PASSWORD_DEFAULT); //>>$2y$10$SFU2HvhtCpCohKsWkrqJ/um9wWBg.s7sBWAjRUg5Lxo.7DQFh8p56
    //$hash = password_hash("example", PASSWORD_DEFAULT);
    //echo password_verify("example", $hash) ? "true" : "false"
    ?>
</body>
</html>
