<?php

/*
PHP MY ADMIN CODE TO CREATE A DB
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NOT NULL ,
  `password` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`), UNIQUE (`email`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/
// PHPmyAdmin data
  $host = "your host"; // example: localhost
  $dbname = "your databank"; // example: users
  $username_msq = "your phpmyadmin username"; // example: root
  $password_msq = "your phpmyadmin password"; // example: PaSsWoRd1234


  //CODE
  $debug = false;
    //FALSE = No debugs
    //TRUE = Console messages
session_start();

// IF USER ALREADY LOGGED IN
if(isset($_SESSION['user']))
  die("You are already logged in!");
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Login example</title>
   </head>
   <body>


 <?php
// IF login SET
if(isset($_GET['login'])){
  //CHECK input

  //IF INPUT != null
  if(empty($_POST['email']) || empty($_POST['password']))
    die("Please enter ALL user data!" . '<meta http-equiv="refresh" content="1; URL=login.php">');

    // START PDO
  $phpmyadminlogin = "mysql:host=" . $host . ";dbname=" . $dbname;
  $pdo = new PDO($phpmyadminlogin, $username_msq, $password_msq);
  // GET PASSWORD AND EMAIL
  $useremail = $_POST['email'];
  $userpassword = $_POST['password'];

  //CHECK DATA
  if($debug) echo "Get data from MSQL <br>";
  $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
  $result = $statement->execute(array('email' => $useremail));
  $user = $statement->fetch();
  if($debug) echo "Start to Check data <br>";

  if(empty($user)){
    if($debug) echo "User can not find in DB <br>";
    echo '<meta http-equiv="refresh" content="1; URL=login.php">';
    die("<b>Check your E-Mail and Password</b>");
  }



} else {      //IF login not set
  //Send login site
  echo "<form action='?login=1' method='POST'>";
  echo "<br>";
  echo '<input type="email" size="40" maxlength="250" name="email" placeholder="Your E-Mail">';
  echo "<br>";
  echo '<input type="password" size="40" maxlength="250" name="password" placeholder="Your Password">';
  echo "<br>";
  echo '<input type="submit" value="Login">';
  echo "</form>";
}
 ?>
</body>
</html>
