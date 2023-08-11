<?php
require_once("../authentication/linker.php");
$currentDateTime = date("Y-m-d H:i");
$mastername = "";
$masteremail = "";
session_start();
if(empty($_SESSION['auth'])){
  header("location: ../authentication/login.php");
}else{
  $mst = $_SESSION['auth'];
  $main = "SELECT * FROM users WHERE id = '$mst'";
  $results = mysqli_query($starlink,$main);
    if(mysqli_num_rows($results) == 1){
        $rows = mysqli_fetch_array($results);
        $masterid = $rows['id'];
        $mastername = $rows['fullname'];
        $masteremail= $rows['email'];
        $_SESSION['uemail'] = $masteremail;

//counter
  $maincount = "SELECT * FROM posts WHERE useremail = '$masteremail'";
  $resultx = mysqli_query($starlink,$maincount);
  $allposts = mysqli_num_rows($resultx);
  $majorcount = "SELECT * FROM posts WHERE useremail = '$masteremail' && status = 'Scheduled'";
  $resultxx = mysqli_query($starlink,$majorcount);
  $allsch = mysqli_num_rows($resultxx);
    }
  
}
?>



<?php

$date = $time = $message = $imageName = $messageError = $dateError = $timeError = $imageError = $status = "";

if (isset($_POST['quick'])) {

  if (empty($_POST['message'])) {
    $messageError = "Message required!";
  } else {
    $message = $_POST['message'];
  }

    if (empty($_POST['date'])) {
    $dateError = "Date required!";
  } else {
    $date = $_POST['date'];
  }

  if (empty($_POST['time'])) {
    $timeError = "Time required!";
  } else {
    $time = $_POST['time'];
  }

  if (empty($_FILES['image']['name'] && $_FILES['image']['tmp_name'])) {
    $imageError = "Image required!";
  } else {
    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];

    // Move the uploaded image to a desired location
    $targetDir = "../uploads/";
    $targetPath = $targetDir . basename($imageName);
    move_uploaded_file($imageTmpName, $targetPath);
  }

  if ($messageError == "" || $imageError == "" ) {
    $status = "Published";
    $inserter = "INSERT INTO posts(username,useremail,post_content,post_image,post_time_date,status) VALUES('$mastername', '$masteremail', '$message', '$imageName', '$currentDateTime', '$status')";

    if (mysqli_query($starlink, $inserter)) {
      header("location: ../lib/main.php");
    } else {
      echo ("Failed to send data!!!");
    }

  } else {

    echo"<script> alert('A message or image is required please , feel free to post just a picture without description please..!'); </script>";

  }
}

?>

<?php

$date = $time = $message = $imageName = $messageError = $dateError = $timeError = $imageError = $status = "";

if (isset($_POST['schedule'])) {

  if (empty($_POST['message'])) {
    $messageError = "Message required!";
  } else {
    $message = mysqli_real_escape_string($starlink, $_POST['message']);
  }

    if (empty($_POST['date'])) {
    $dateError = "Date required!";
  } else {
    $date = $_POST['date'];
  }

  if (empty($_POST['time'])) {
    $timeError = "Time required!";
  } else {
    $time = $_POST['time'];
  }

  if (empty($_FILES['image']['name'] && $_FILES['image']['tmp_name'])) {
    $imageError = "Image required!";
  } else {
    $imageName = $_FILES['image']['name'];
    $imageTmpName = $_FILES['image']['tmp_name'];

    // Move the uploaded image to a desired location
    $targetDir = "../uploads/";
    $targetPath = $targetDir . basename($imageName);
    move_uploaded_file($imageTmpName, $targetPath);
  }

  if ($messageError == "" || $imageError == "" ) {
    if($date == "" || $time == ""){
      echo ("<script>alert('Please Select the date and time for your schedule please this is a very essential part , you should fill it..!!!'); </script>");
    }else{
    $dateTime = $date .' '. $time;
     $status = "Scheduled";
    $inserter = "INSERT INTO posts(username,useremail,post_content,post_image,post_time_date,status) VALUES('$mastername', '$masteremail', '$message', '$imageName', '$dateTime', '$status')";

    if (mysqli_query($starlink, $inserter)) {
        header("location: ../lib/main.php");
    } else {

         echo ("Failed to send data!!!");

    }
    }


  } else {
        echo"<script> alert('A message or image is required please , feel free to post just a picture without description please..!'); </script>";
  }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Innovate Social</title>
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/postwidget.css">
    <link rel="stylesheet" href="../style/poster.css">
    <link rel="stylesheet" href="../style/pro.css">
</head>
<style>
  #schedule-container {
    display: none;
  }
</style>
<body>
<table class="main" border="0">
  <!-- main nav bar -->
    <tr class="navbar">
        <td class="navbarline"><h1>Innovate Social</h1></td>
        <td class="navbarout"  colspan="2" align="right">
        <a href="../lib/main.php">
            <button id="refresh">R E F R E S H</button>
          </a>
          <a href="../authentication/logout.php">
            <button id="signout">S I G N - O U T - N O W</button>
          </a>
    
        </td>
    
    </tr>
    <!-- end of navbar -->
    <tr><td colspan="3" id="separate"></td></tr>
    <!-- mainpage -->
    <tr>
    
      <!-- menu component -->
    <td class="menu" rowspan="2">
        <div><h2>Create a new post</h2></div>
        <form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <table class="postcreator" border="0">
          <tr>
            <td colspan="2"><textarea name="message" id="message" cols="28" rows="6" placeholder="What's on your mind ?"></textarea></td>
          </tr>
                   <tr>
            <td colspan="2" class="pick"><b>Pick the image for the post</b></td>
          </tr>
          <tr>
            <td colspan="2">
    <div class="image-uploader">
    <input type="file" id="upload" accept="image/*" name="image">
    <label for="upload" class="upload-icon">&#8679;</label>
    <p class="upload-text">Click to upload an image</p>
    <img src="#" alt="" id="preview" class="image-preview">
    </div>
         </td>
         </tr>
         <tr>
            <td colspan="2" class="pick"><b>Pick  Date and Time for the schedule</b><br></td>
          </tr>
          <tr class="datetime">
            <td>
                <input type="date" name="date" id="date">
            </td>
            <td align="right">
                <input type="time" name="time" id="time">
            </td>
          </tr>
          <tr>
          <td align="left"><br>
          <button id="btn" name="quick">Quick post</button>
          </td>
          <td align="right"><br><button id="btn2" name="schedule">Schedule post</button></td>
          </tr>
        </table>
        </form>
    </td>
<!-- end of menu component -->

<!-- main box  -->
    <td class="mainBox">
        <div><h2>Explore  and get to learn</h2></div>
        <div class="posters" id="posters-container"></div>
        <div id="schedule-container"></div>
    </td>
<!-- end of mainbox -->



<!-- proanalsch -->
      <td class="pro">
        <!-- info  -->
      <table id="proinfo">
        <tr><h2>Profile Info</h2></tr>
        <tr>
            <td style="width:60%"><span class="username"><?php echo $mastername; ?> &nbsp;<img src="../icons/verify.png" id="vr"></span><br><span class="useremail"><?php echo $masteremail; ?></span></td>
            <td style="width:10%"><div class="dpd"><img src="../posts/foto_no_exit.jpeg" alt="bananas images" ></div></td>
        </tr>
        <tr>
          <td colspan="2">
            <img src="../icons/calendar.png" id="vr"> Joined in <span id="dt">12 Dec 2012</span> 
          </td>
        </tr>
      </table>
      <!-- end of info  -->
<br><br>
              <!-- counter  -->
      <table id="analinfo">
        <tr><h2>Analytics Info</h2></tr>
        <tr>
          <td class="count" align="center"><span class="desc">All Posts</span><br> <span class="num"><?php echo $allposts; ?></span></td>
          <td style="width: 5%"></td>
          <td class="count" align="center"><span class="desc">Schedules</span> <br> <span class="num"><?php echo $allsch; ?></span></td>
        </tr>
      </table>
      <!-- end of counter  -->

      <br><br>
              <!-- sch  -->
      <table id="schinfo">
        <tr><h2>Scheduler manager</h2></tr>
        <tr>
          <td><button id="sat" onclick="view()">View Scheduled Posts</button></td>
        </tr>
        <tr>
          <td><br>
          <a href='../job/delete.php?id=<?php echo $masteremail; ?>'>
          <button id="sit" >Clear Scheduled Posts</button>
          </a>
        </td>
        </tr>
      </table>
      <!-- end of sch  -->
      </td>
    </tr>
    <!-- end of mainpage -->
</table>



  <script>
    // JavaScript to display the selected image preview
    const fileInput = document.getElementById('upload');
    const imagePreview = document.getElementById('preview');

    fileInput.addEventListener('change', function() {
      const file = this.files[0];

      if (file) {
        const reader = new FileReader();

        reader.addEventListener('load', function() {
          imagePreview.src = reader.result;
        });

        reader.readAsDataURL(file);
      }
    });
  </script>





<script>
    function updatePosters() {
        var xhr = new XMLHttpRequest();
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                var postersContainer = document.getElementById('posters-container');
                postersContainer.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(function (post) {
                        var content = '<table id="poster" border="0">' +
                            '<tr class="post_header">' +
                            '<td style="width:10%"><div class="dp"><img src="../uploads/user.png" alt="Sorry the image was not loaded successfully...!!!"></div></td>' +
                            '<td style="width:60%"><span class="username">' + post.name + ' &nbsp;<img src="../icons/verify.png" id="vrs"></span><br><span class="useremail">' + post.email + '</span></td>' +
                            '<td style="width:30%" align="right" class="date">' + post.time + '</td>' +
                            '</tr>' +
                            '<tr class="post_content"><td colspan="3" id="postContent">' + post.content + '</td></tr>';
                            
                        if (post.image !== "") {
                            content += '<tr class="post_img"><td colspan="3" id="postImg">' +
                                '<img src="../uploads/' + post.image + '" alt="Sorry the image was not loaded successfully...!!!">' +
                                '</td></tr>';
                        }
                        
                        content += '</table>';
                        postersContainer.innerHTML += content;
                    });
                } else {
                    postersContainer.innerHTML = '<img src="../icons/inbox.png" width="80%">';
                }
            }
        };

        xhr.open('GET', '../job/getter.php', true);
        xhr.send();
    }


    updatePosters();


    setInterval(updatePosters, 1000); 
</script>





//Schedules

<script>
    function updatePosters() {
        var xhr = new XMLHttpRequest();
        
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                var postersContainer = document.getElementById('schedule-container');
                postersContainer.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(function (post) {
                        var content = '<table id="poster" border="0">' +
                            '<tr class="post_header">' +
                            '<td style="width:10%"><div class="dp"><img src="../uploads/user.png" alt="Sorry the image was not loaded successfully...!!!"></div></td>' +
                            '<td style="width:60%"><span class="username">' + post.name + ' &nbsp;<img src="../icons/verify.png" id="vrs"></span><br><span class="useremail">' + post.email + '</span></td>' +
                            '<td style="width:30%" align="right" class="date">' + post.time + '</td>' +
                            '</tr>' +
                            '<tr class="post_content"><td colspan="3" id="postContent">' + post.content + '</td></tr>';
                            
                        if (post.image !== "") {
                            content += '<tr class="post_img"><td colspan="3" id="postImg">' +
                                '<img src="../uploads/' + post.image + '" alt="Sorry the image was not loaded successfully...!!!">' +
                                '</td></tr>';
                        }
                        
                        content += '</table>';
                        postersContainer.innerHTML += content;
                    });
                } else {
                    postersContainer.innerHTML = '<img src="../icons/inbox.png" width="80%">';
                }
            }
        };

        xhr.open('GET', '../job/schedule_list.php', true);
        xhr.send();
    }


    updatePosters();


    setInterval(updatePosters, 1000); 
</script>

<script>
  function view() {
    var condition = true;
    if (condition == true) {
       document.getElementById("posters-container").style.display = "none";
       document.getElementById("schedule-container").style.display = "block";
       var condition = false;
    } else {
       document.getElementById("posters-container").style.display = "block";
       document.getElementById("schedule-container").style.display = "none";
       var condition = false;
    }
  }

</script>
</body>
</html>
