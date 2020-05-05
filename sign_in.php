
<?php
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
?>

<?php
include('lib/common.php');

if ($showQueries) {
  array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
}

//Note: known issue with _POST always empty using PHPStorm built-in web server: Use *AMP server instead
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $enteredUsername = mysqli_real_escape_string($db, $_POST['username']);
  $enteredPassword = mysqli_real_escape_string($db, $_POST['password']);
  console_log($enteredUsername);

  if (empty($enteredUsername)) {
    array_push($error_msg,  "Please enter an email address.");
  }

  if (empty($enteredPassword)) {
    array_push($error_msg,  "Please enter a password.");
  }

  if (!empty($enteredUsername) && !empty($enteredPassword)) {

    $query = "SELECT password FROM User WHERE Username='$enteredUsername'";
    $result = mysqli_query($db, $query);
    include('lib/show_queries.php');
    $count = mysqli_num_rows($result);

    if (!empty($result) && ($count > 0)) {
      $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $storedPassword = $row['password'];

      $options = [
        'cost' => 8,
      ];
      //convert the plaintext passwords to their respective hashses
      // 'michael123' = $2y$08$kr5P80A7RyA0FDPUa8cB2eaf0EqbUay0nYspuajgHRRXM9SgzNgZO
      $storedHash = password_hash($storedPassword, PASSWORD_DEFAULT, $options);   //may not want this if $storedPassword are stored as hashes (don't rehash a hash)
      $enteredHash = password_hash($enteredPassword, PASSWORD_DEFAULT, $options);

      if ($showQueries) {
        array_push($query_msg, "Plaintext entered password: " . $enteredPassword);
        //Note: because of salt, the entered and stored password hashes will appear different each time
        array_push($query_msg, "Entered Hash:" . $enteredHash);
        array_push($query_msg, "Stored Hash:  " . $storedHash . NEWLINE);  //note: change to storedHash if tables store the plaintext password value
        //unsafe, but left as a learning tool uncomment if you want to log passwords with hash values
        //error_log('email: '. $enteredUsername  . ' password: '. $enteredPassword . ' hash:'. $enteredHash);
      }

      //depends on if you are storing the hash $storedHash or plaintext $storedPassword 
      if (password_verify($enteredPassword, $storedHash)) {
        array_push($query_msg, "Password is Valid! ");
        $_SESSION['Username'] = $enteredUsername;
        array_push($query_msg, "logging in... ");
        header(REFRESH_TIME . 'url=Cart.html');    //to view the password hashes and login success/failure

      } else {
        array_push($error_msg, "Login failed: " . $enteredUsername . NEWLINE);
        array_push($error_msg, "To demo enter: " . NEWLINE . "user1" . NEWLINE . "pass1");
      }
    } else {
      array_push($error_msg, "The username entered does not exist: " . $enteredUsername);
    }
  }
}
?>

















<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gold For Code</title>
  <link rel="stylesheet" type="text/css" href="resources/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--   NO BOOTSTRAP FOR THIS ASSIGNMENT
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js'></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  -->
  <script src="total.js"></script>
</head>

<body>

  <!--header  please copy to your page-->
  <div class="header">
    <img id="GFC" src="resources/Gold_for_Code.jpg" alt="Gold For Code">
  </div>

  <!--please pay attention to the "active" page when you copy navbar to your page-->
  <nav class="navbar">
    <a href="index.html">Home</a>
    <a href="productspage.html">Products</a>
    <a href="about.html">About</a>
    <a href="faq.html">FAQ</a>
    <a href="contact_us.html">Contact US</a>

    <div class="navbar-right">
      <div class="dropdown">
        <button class="dropbtn">
          <i class="fa fa-fw fa-user"></i> Sign In <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
          <a href="sign_in.html">Sign In</a>
          <a href="register.html">Sign Up</a>
          <a onclick="signout()" href="sign_in.html">Sign Out</a>
          <a href="account.html">Account</a>
        </div>
      </div>
      <a href="Cart.html"><i class="fa fa-shopping-cart"></i> Cart</a>
    </div>
  </nav>

  <div class="form-container">





    <form class="form" action="sign_in.php" method="post" enctype="multipart/form-data">
      <h2><b>Sign In</b></h2>
      <p>New to Gold For Code? <a href="./register.html" class="account"> Create an account.</a></p>
      <div class="login_form_row">
        <label for="email"><b>Username</b></label><br>
        <input type="text" placeholder="Enter Username" name="username" id="username" class="login_input" maxlength="30" size="30" required /><br><br>
      </div>
      <div class="login_form_row">
        <label for="psw"><b>Password</b></label><br>
        <input type="password" placeholder="Enter Password" name="password" id="password" class="login_input" maxlength="30" size="30" required />
      </div>
      <p><a href="./forget_psw.html">Forget password?</a></p><br>
      <input type="checkbox" checked="unchecked" name="remember"> Keep me signed in. <br>
      <p>By signing in to your account,you agree to our <a href="privacy.html">Privacy Policy</a>and <a href="terms_and_conditions.html">Terms & Conditions.</a></p>
      <!-- <button type="button" class="form-button" id="submit" onclick="validate()">Sign In</button> -->
      <input type="submit" value="Sign In" class="form-button login" />
    </form>
    <?php include("lib/error.php"); ?>

    <div class="clear"></div>
  </div>


  </div>







  <footer class="footer-distributed">

    <div class="footer-left">
      <img src="resources/Gold_for_Code.jpg">
      <h3>With US<br><span>Coding is to be simple</span></h3>

      <p class="footer-links">
        <a href="index.html">Home</a>
        |
        <a href="product.html">Products</a>
        |
        <a href="about.html">About</a>
        |
        <a href="faq.html">FAQ</a>
      </p>

      <p class="footer-company-name">©2020CopyRight | Gold For Code. Ltd.</p>
    </div>

    <div class="footer-center">
      <div>
        <i class="fa fa-map-marker"></i>
        <p><span>796 State Dr,
            San Francisco</span>
          CA 94132</p>
      </div>

      <div>
        <i class="fa fa-phone"></i>
        <p>+01 123-456-7789</p>
      </div>
      <div>
        <i class="fa fa-envelope"></i>
        <p><a href="mailto:support@goldforcode.com">support@goldforcode.com</a></p>
      </div>
      <br>
      <div class="footer-icons">
        <p style="text-indent: 1em;">Connect with us on social medias!</p><br>
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-google"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
      </div>
    </div>
    <div class="footer-right">
      <p class="footer-company-about">
        <span>We are here to help</span>
        With us, CODE IS TO BE SIMPLE. We help the upcoming programmers with the code. We focuses on providing the most efficient code or snippets as the code wants to be simple. We will help programmers build up concepts in different programming languages that include C, C++, Java, HTML, CSS, Bootstrap, JavaScript, PHP, Android, SQL and Algorithm.</p>
      <p class="footer-links2">
        <a href="faq.html" style="text-indent: 6em;">FAQs</a>
        |
        <a href="contact_us.html">Contact US</a>
        <br>
        <a href="terms_and_conditions.html">Terms and Conditions</a>
        |
        <a href="privacy.html">Privacy Policy</a>
      </p>
    </div>
  </footer>
</body>

</html>