
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
include('lib/error.php');
include("sign_in.html");
?>
