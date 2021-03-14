<?php
$login = false;
if($_SERVER["REQUEST_METHOD"] == "POST") {
  include 'dbconn.php';
  $username = $_POST["name"];
  $password = $_POST["pass"];
  
  $sql = "SELECT * from registration where name='$username'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if ($num == 1) {
    while($row = mysqli_fetch_assoc($result)){
      
      $new_pass = $row['pswd'];
      
      if(password_verify($password, $new_pass)) {
          $escapedPW = mysqli_real_escape_string($conn, $_REQUEST['pswd']);

          if (isset($_REQUEST['remember']))
            $escapedRemember = mysqli_real_escape_string($conn, $_REQUEST['remember']);
                            
            $cookie_time = 60 * 60 * 24 * 30;          // 30 days
            $cookie_time_Onset = $cookie_time+ time();
            if (isset($escapedRemember)) {
              setcookie("name", $usernameVal, $cookie_time_Onset);
              setcookie("pass", $escapedPW, $cookie_time_Onset);  
            } 
            else {
              $cookie_time_fromOffset=time() -$cookie_time;
              setcookie("name", '', $cookie_time_fromOffset );
              setcookie("pass", '', $cookie_time_fromOffset);          
            }
        
        $login = true;
        session_start();
        $_SESSION['loggedin'] = true;
        $_SESSION['name'] = $username;
        header("location: index.php");   
      }
      else {
          echo "<script> alert('Invalid Credentials'); </script>";
      }
    }
  }
  else {
      echo "<script> alert('Invalid Credentials'); </script>";
  }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up Form Women Express</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="register.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign up</h2>
                        <form action="login.php" method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="your_name" placeholder="Your Name"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="your_pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember" <?php if(isset($_COOKIE['uname'])){echo "checked='checked'"; } ?> name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                        <div class="social-login">
                            <span class="social-label">Or login with</span>
                            <ul class="socials">
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-facebook"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-twitter"></i></a></li>
                                <li><a href="#"><i class="display-flex-center zmdi zmdi-google"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>