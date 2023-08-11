<?php
$username = "";
$email = "";
$password = "";
$confirmationPassword = "";
$message = "";

$usernameErr = "Username is required!";
$emailErr = "";
$passwordErr = "";
$confirmationPasswordErr = "";

$usernameErrDisplay = "none";
$emailErrDisplay = "none";
$passwordErrDisplay = "none";
$confirmationPasswordErrDisplay = "none";
$messageDisplay = "none";
$usernameRegEx = '/^[A-Za-z]{6,}$/';
require_once('inc/connection.php');

date_default_timezone_set('Africa/Nairobi');

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmationPassword = $_POST['confirmpassword'];
    if(!empty($username) && !empty($email) && !empty($password) && !empty($confirmationPassword)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $checkEmailQuery = "SELECT * FROM users WHERE email = ? LIMIT 1";
            $stmt = $connection->prepare($checkEmailQuery);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->num_rows;
            $stmt->close();
            
            if($rows == 0){
                if(preg_match($usernameRegEx, $username)){
                    $checkUsernameQuery = "SELECT * FROM users WHERE username = ? LIMIT 1";
                    $stmt = $connection->prepare($checkUsernameQuery);
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $rows = $result->num_rows;
                    $stmt->close();
                    
                    if($rows == 0){
                        if($password == $confirmationPassword){
                            $date = date('Y-m-d');
                            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                            $insertQuery = "INSERT INTO users (username, email, password, reg_date) VALUES (?, ?, ?, ?)";
                            $stmt = $connection->prepare($insertQuery);
                            $stmt->bind_param("ssss", $username, $email, $hashedPassword, $date);
                            if($stmt->execute()){
                                $message = "Registered Successfully!";
                                $messageDisplay = "block";
                                header('Refresh:3;url=login');
                            }else{
                                $usernameErr = "User registration failed!";
                                $usernameErrDisplay = "block";
                            }
                            $stmt->close();
                        }else{
                            $confirmationPasswordErr = "Passwords do not match!";
                            $confirmationPasswordErrDisplay = "block";
                        }
                    }else{
                        $usernameErr = "Username $username already taken!";
                        $usernameErrDisplay = "block";
                    }
                }else{
                    $usernameErr = "Username should contain letters only 6 or more characters long";
                    $usernameErrDisplay = "block";
                }
            }else{
                $emailErr = "Email $email already registered!";
                $emailErrDisplay = "block";
            }
        }else{
            $emailErr = "Please provide a valid email address";
            $emailErrDisplay = "block";
        }
    }else{
        if(empty($username)){
            $usernameErr = "Username is required!";
            $usernameErrDisplay = "block";
        }
        
        if(empty($email)){
            $emailErr = "Email is required!";
            $emailErrDisplay = "block";
        }
        
        if(empty($password)){
            $passwordErr = "Password is required!";
            $passwordErrDisplay = "block";
        }
        
        if(empty($confirmationPassword)){
            $confirmationPasswordErr = "Confirmation Password is required!";
            $confirmationPasswordErrDisplay = "block";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InnovateSocial - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
         @media (max-width: 768px) {
            #image-container {
                display: none;
            }
        }
        /* Webkit-based browsers (Chrome, Safari) */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 6px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        /* Firefox */
        body {
            scrollbar-width: thin;
        }

        body::-webkit-scrollbar {
            width: 12px;
        }

        body::-webkit-scrollbar-track {
            background-color: #f1f1f1;
        }

        body::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 6px;
        }

        body::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }
        p{
            text-align: justify;
        }
   
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">InnovateSocial</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#"><i class="fas fa-home"></i> Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-info-circle"></i> About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="posts"><i class="fas fa-newspaper"></i> Posts</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login"><i class="fas fa-sign-in-alt"></i> Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-user-plus"></i> Register</a>
            </li>
        </ul>
    </div>
</nav>


<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <!-- Left side content -->
            <h1>Welcome to InnovateSocial</h1>
            <p>Your Gateway to a Connected World. Experience a new era of social networking where you can connect, share, and engage with like-minded individuals. Discover meaningful connections, express your unique voice, and explore a diverse range of content. Join us today and be a part of the next generation of social media.</p>
            <div id="image-container">
                <img src="images/man_2.jpg" alt="InnovateSocial Image" class="img-fluid mt-3">
            </div>

        </div>
        <div class="col-md-6">
            <!-- Right side content -->
            <div class="card">
                <div class="card-header">Register</div>
                <div class="card-body">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" autocomplete="off">
                        <div class="form-group alert alert-success" style="display:<?php echo $messageDisplay?>">
                            <label><?php echo $message ?></label>
                        </div>
                        <div class="form-group">
                            <label for="registerUsername">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Enter username">
                        </div>
                        <div class="form-group alert alert-danger" style="display:<?php echo $usernameErrDisplay?>">
                            <label><?php echo $usernameErr ?></label>
                        </div>
                        <div class="form-group">
                            <label for="registerEmail">Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter email">
                        </div>
                        <div class="form-group alert alert-danger" style="display:<?php echo $emailErrDisplay?>">
                            <label><?php echo $emailErr ?></label>
                        </div>
                        <div class="form-group">
                            <label for="registerPassword">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="form-group alert alert-danger" style="display:<?php echo $passwordErrDisplay?>">
                            <label><?php echo $passwordErr ?></label>
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm password">
                        </div>
                        <div class="form-group alert alert-danger" style="display:<?php echo $confirmationPasswordErrDisplay ?>">
                            <label><?php echo $confirmationPasswordErr ?></label>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Register</button>
                    </form>
                </div>
            </div>
            <div class="mt-3 text-center">
                Already have an account? <a href="login/">Login here</a>
            </div>
        </div>
    </div>
</div>
<footer class="bg-dark text-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h4>About InnovateSocial</h4>
                <p>Discover a new era of social networking. Connect, share, and engage with like-minded individuals. Express your unique voice, explore diverse content, and join us to shape the future of social media</p>
            </div>
            <div class="col-md-6">
                <h4>Contact Us</h4>
                <address>
                    <p>Email: contact@innovatesocial.com</p>
                    <p>Phone: +255764413610</p>
                </address>
            </div>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
