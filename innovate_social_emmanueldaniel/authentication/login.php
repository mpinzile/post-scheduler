<?php
session_start();
if(empty($_SESSION['code'])){
    
}else{
    $blocks = "display:block !important";
    session_destroy();
}
?>





<?php
require_once("../authentication/linker.php");

if (isset($_POST['login'])) {
  $user_email=$_POST['email'];
  $user_password=$_POST['password'];

  $selector="SELECT * FROM users WHERE email='$user_email'";
  $query_selector=mysqli_query($starlink,$selector);
  if(mysqli_num_rows($query_selector)==1){

   $rows=mysqli_fetch_array($query_selector);

       $user_id=$rows['id'];
       $userpassword = $rows['password'];
       
if(password_verify($user_password,$userpassword)){
    $_SESSION['auth'] = $user_id;
    $_SESSION['ids']=$user_id;
    header("location:../lib/main.php");


}else{

    $error="display:block !important";
    $shaker = "animation: shaky 0.8s;border: 2px solid red;";
    $shakers = "animation: shake 0.8s;border: 2px solid red;";

}

  }else{

    $error="display:block !important";
    $shaker = "animation: shaky 0.8s;border: 2px solid red;";
    $shakers = "animation: shake 0.8s;border: 2px solid red;";

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
                <!-- <td class="LoGo"><img src="../icons/blackLogo.PNG" class="log"></td> -->
                <td class="ming">= Innovate Social =</td>
            </tr>


            </table>
            <p class="sign">Sign in with your Innovate ID to activate your IS account.</p>
        
            <div id="success" style="<?php echo($blocks); ?>"><img src="../icons/tick.png" id="tick">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Congratulation, Your Mingle account has been created successfully! You can now login</div>
            <!-- <p class="signin">Learn more about Mingle</p> -->
<form action="" method="post">
            <div class="inp">
                <table class="inputers">
                    <tr>
                        <td class="inputer">
                            <input type="text" name="email" id="inputer" placeholder="Email"  style="<?php echo($shakers); ?>" onkeyup="verified()" autocomplete="off">
                            <label id="label">Innovate ID</label>
                        </td>
                    </tr>
                    <tr>
                        <td class="inputer">
                            <input type="password" name="password" id="inputers" placeholder="Required" style="<?php echo($shaker); ?>" onkeyup="verified()" autocomplete="off">
                            <label id="label">Password</label>
                        </td>
                    </tr>
                    <tr><td id="error" style="<?php echo($error); ?>"><img src="../icons/exclamation-mark.png" id="exclamation">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sorry your credentials didn't match...!</td></tr>
                </table>
            </div>

            <div class="sign_in"><button id="sign_in" name="login">Sign In...</button></div>
</form>
            <div class="forgot">Forgot Innovate Social ID or Password?</div>
            <p class="reg">You can reqister your phone number or IS ID (Email).</p>
            <div class="create"><a href="registration.php">Create a new Innovate Social account</a></div>
            </div>
    </center>
</div>


<script src="../js/reg.js" type="text/javascript"></script>
</body>


</html> 
