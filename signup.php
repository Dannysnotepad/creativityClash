<?php

if(isset($_POST['submit'])){
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $pwd = htmlspecialchars($_POST['password']);
    $accont_created_at = date('Y-m-d H:i:s');
  
  try {
    require_once  "inc/db_config.php";
    $query = "INSERT INTO users (username, email, pwd, account_created_at) VALUES (:username, :email, :pwd, :account_created_at)";
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pwd', md5($pwd));
    $stmt->bindParam(':account_created_at', $accont_created_at);
    
    $stmt->execute();
    
    $pdo = null;
    $stmt = null;
    
    //Creating a folder with the name the user
    $parentfolder = 'users';
    $folderpath = "{$parentfolder}/{$username}";
    
    if(!is_dir($folderpath) && !file_exists($folderpath)){
      mkdir($folderpath, 0777, true);
    } 
    
    header('Location: /login');
    
  } catch (PDOException $e) {
    die('An error ocurred' . $e->getMessage());
  }
  
}/*else{
  $msg = '<p style="color:darkred">Something went wrong</p>';
}*/
?>


<!Doctype html>
<html>
  <head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=Edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   
   <title>Signup</title>
   <link rel="stylesheet" href="css/simple.min.css">
  </head>
  <body>
    <header>
      <h1>Creativity Clash ©</h1>
    </header>
    <h2>Signup</h2>
    <?php echo $message ?? null; ?>
    <form method="POST" action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" id="form">
      <label>
        Username
        <input type="text" id="username" name="username" placeholder="e.g John Doe" required>
      </label>
      <label>
        Email Address
        <input type="email" name="email" placeholder="Enter your email address" required>
      </label>
      <label>
        Password
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </label>
      <button id="submit" name="submit">Signup</button>
      <br>
      <span>Already have an account?...<a href="/login">login</a></span>
    </form>
    <script src="js/signup.js"></script>
  </body>
</html>