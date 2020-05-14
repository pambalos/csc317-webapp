<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gold For Code</title>
  <link rel="stylesheet" type="text/css" href="resources/static/styles.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="resources/js/cart.js"></script>
</head>
<body>

  <!--header  please copy to your page-->
  <div class="header">
    <img id="GFC" src="resources/static/Gold_for_Code.jpg" alt="Gold For Code">
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
          <a href="register.php">Sign Up</a>
          <a onclick = "signout()" href="sign_in.html">Sign Out</a>
          <a href="account.php">Account</a>
        </div>
      </div>
      <a class="active" href="Cart.php"><i class="fa fa-shopping-cart"></i> Cart</a>
    </div>
  </nav>

    <?php
    include('lib/common.php');
    include('lib/show_queries.php');

    function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
            ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }

    if ($showQueries) {
        array_push($query_msg, "showQueries currently turned ON, to disable change to 'false' in lib/common.php");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        console_log("In handle GET");

        $enteredUsername = mysqli_real_escape_string($db, $_GET['username']);
        $enteredPassword = mysqli_real_escape_string($db, $_GET['psw']);
        console_log($enteredUsername);

        if (empty($enteredUsername)) {
            array_push($error_msg,  "Please enter an email address.");
        }

        if (empty($enteredPassword)) {
            array_push($error_msg,  "Please enter a password.");
        }

        if (!empty($enteredUsername) && !empty($enteredPassword)) {
            console_log("In handle GET2");

            $query = "SELECT password FROM User WHERE Username='$enteredUsername'";
            $result = mysqli_query($db, $query);
            include('lib/show_queries.php');
            $count = mysqli_num_rows($result);

            if (!empty($result) && ($count > 0)) {
                //then found a user
                console_log("Should fail here...");
                echo '
                        <div style="width: 100%; min-height: 600px; align-content: center;"> 
                            <h3> Failed to create new account: Username already taken </h3>
                        </div>
                    ';
                sleep(2);
                header(REFRESH_TIME . 'url=register.php');
            } else {
                console_log("Making a user");
                //make a user
                $query = "insert into user value (" . "\"" . $_GET['username'] . "\", \"" . $_GET['psw'] . "\", \"" . $_GET['email'] . "\", \"" . $_GET['fname'] . "\", \"" . $_GET['lname'] . "\")" ;
                console_log($query);
                $res = mysqli_query($db, $query);
                $_SESSION['Username'] = $enteredUsername;
                if ($res == true) {
                    array_push($query_msg, "Saving login info...");
                    header(REFRESH_TIME . 'url=account.php');    //to view the password hashes and login success/failure
                    echo '
                        <div style="width: 100%; min-height: 600px; align-content: center;"> 
                            <h3> Logging in... Please wait </h3>
                        </div>
                    ';
                } else {
                    header(REFRESH_TIME . 'url=register.php');    //to view the password hashes and login success/failure
                    echo '
                        <div style="width: 100%; min-height: 600px; align-content: center;"> 
                            <h3> Ran into some internal error, sorry </h3>
                        </div>
                    ';
                }
            }
        }
    }

    include('lib/error.php');
    ?>
</body>
</html>