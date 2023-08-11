<?php
require_once("../authentication/linker.php");

$eError = $uError = $passError = $email = $username = $pass = $errror = "";
if(isset($_POST['up'])){
    
    if(empty($_POST['email'])){
        $eError="Email required!";
        }else{$email=$_POST['email'];}
    
    if(empty($_POST['uname'])){
        $uError="Username required!";
        }else{$username=$_POST['uname'];}
    
    if(empty($_POST['password'])){
        $passError="password required!";
        }else{$pass=$_POST['password'];}


session_start();


    $codes=substr(md5(mt_rand()),0,5);
    $_SESSION['code'] = $codes;
    if($eError==""&&$uError==""&&$passError==""){
    
    $password=password_hash($pass,PASSWORD_DEFAULT);
    $inserter="INSERT INTO users(email,fullname,password) VALUES('$email','$username','$password')";
    
  $selector="SELECT * FROM users WHERE email='$email'";
  $query_selector=mysqli_query($starlink,$selector);
  if(mysqli_num_rows($query_selector)==1){

    $errror="Email Already exists, use another email please!";
    $block = "display:block !important";
    $shakerz = "animation: shaky 0.8s;border: 2px solid red;";

}else{

    if(mysqli_query($starlink,$inserter)){
        header("location: ../lib/main.php");
    }else{

    echo("Failed to send data!!!");
        
    }

}
}else{
        $shakers = "animation: shaky 0.8s;border: 2px solid red;";
        $shakerz = "animation: shake 0.8s;border: 2px solid red;";
        $shaker = "animation: shake 0.8s;border: 2px solid red;";

        $block = "display:block !important";
        $errror = "Sorry all fields should be filled...!";
}
}

?>











<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Innovate Social</title>
    <link rel="stylesheet" href="../style/reglog.css">
</head>

<body>

<div class="wall">
    <center>
        <div class="container">
            <table class="loggo" border="0">
            <tr>
                <!-- <td class="LoGo"><img src="../icons/blackLogo.png" class="log"></td> -->
                <td class="ming">= Innovate Social =</td>
            </tr>
            </table>
            <p class="sign">Create a new Innovate Social to become a member of the IS community.</p>
            <!-- <p class="signin">Learn more about Mingle</p> -->
            <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="inp">
                <table class="inputers">
                    <tr>
                        <td class="inputer">
                            <input type="text" name="email" id="inputer" placeholder="Email " style="<?php echo($shakerz); ?>" onkeyup="verify()" autocomplete="off">
                            <label id="label">Innovate ID</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="inputer">
                            <input type="text" name="uname" id="inputerss" placeholder="eg: Emmanuel Daniel" style="<?php echo($shakers); ?>" onkeyup="verify()" autocomplete="off">
                            <label id="label">Fullname</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="inputer">
                            <input type="password" name="password" id="inputers" placeholder="Required" style="<?php echo($shaker); ?>" onkeyup="verify()" autocomplete="off">
                            <label id="label">Password</label>
                        </td>
                    </tr>
                    <tr><td id="error" style="<?php echo($block); ?>"><img src="../icons/exclamation-mark.png" id="exclamation">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo($errror); ?></td></tr>

                </table>
            </div>
            <div class="sign_in"><button id="sign_in" name="up" type="submit">Sign Up...</button></div>
            </form>
            <!-- <div class="forgot">Forgot Mingle ID or Password?</div> -->
            <div class="regg">You are recommended to use a valid Email to be used incase of password recovery...!</div>
            <div class="create"><a href="login.php">Sign-in to your IS account</a></div>
            </div>
    </center>
</div>


<script src="../js/reg.js" type="text/javascript"></script>
</body>


</html>