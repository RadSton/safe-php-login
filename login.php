<?php

/*
PHP MY ADMIN CODE TO CREATE A DB
CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NOT NULL ,
  `passwort` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`), UNIQUE (`email`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
*/
// PHPmyAdmin data
  $host = "your host";
  $dbname = "your database";
  $username_msq = "your username";
  $password_msq = "your password";

  //DELAYS
  $siteatsuccessful = "#";
  $delayatsuccessful = "3";
  $delayaterror = "3";

  // MESSAGES
  $alreadyloggedin = "You are already logged in!";
  $enteralldata = "Please enter ALL user data!";
  $loginsuccessful = "Login successful!";
  $checkpassword = "Check password or email!";


  $whensuccess = "save.php"; // When the password is correct GOTO -> this site !

  // site
  $sitetitle = "Login";
  $seeall = true;
  $cssfile = "#";

  //CODE
  $debug = false;
    //FALSE = No debugs
    //TRUE = Console messages







session_start();

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title><?php echo $sitetitle; ?></title>
     <?php if($cssfile != "#") echo '<link rel="stylesheet" href="'. $cssfile . '">' ?>
   </head>
   <body>


 <?php

 // IF USER ALREADY LOGGED IN
 if(isset($_SESSION['user'])) {
   if($seeall == false)   die($alreadyloggedin); else echo $alreadyloggedin;
 }


// IF login SET
if(isset($_GET['login'])){
  //CHECK input

  //IF INPUT != null
  if(empty($_POST['email']) || empty($_POST['password']))
  if($seeall == false)  die($enteralldata . '<meta http-equiv="refresh" content=" ' . $delayaterror . '; URL=login.php">'); else echo $enteralldata . '<meta http-equiv="refresh" content=" ' . $delayaterror . '; URL=login.php">';

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
    echo '<meta http-equiv="refresh" content=" ' . $delayaterror . '; URL=login.php">';
    if($seeall == false) die($checkpassword); else echo $checkpassword;
  } else {
    // CHECK PASSWORD
    if (password_verify($userpassword, $user['passwort'])) {
        $_SESSION['user'] = $user;
        echo  '<meta http-equiv="refresh" content=" ' . $delayatsuccessful . '; URL='. $whensuccess . '.php">';
      if($seeall == false)  die($loginsuccessful); else echo $loginsuccessful;
    } else {
      die($checkpassword);
    }
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

die();
 ?>

</body>
</html>
