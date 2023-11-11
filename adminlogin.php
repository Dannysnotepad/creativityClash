<?php
session_start();

if(isset($_POST['submit'])){
    $email = htmlspecialchars($_POST['email']);
    $pwd = htmlspecialchars($_POST['password']);
  
  try {
    require_once  "inc/db_config.php";
    $query = "SELECT * FROM admin WHERE email = :email and pwd = :pwd;";
    $stmt = $pdo->prepare($query);
    
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':pwd', md5($pwd));
    
    $stmt->execute();
    
    $admin = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if($admin){
      session_regenerate_id();
      $_SESSION['admin'] = substr($email, 0, -10);
      header('Location: /admin');
      exit();
    }else if(!$admin){
      $msg = '<p style="color:darkred">Wrong credentials</p>';
    }else{
      $msg = '<p style="color:darkred">Something went wrong</p>';
    }
    
    
    /*$pdo = null;
    $stmt = null;*/
    
    
  } catch (PDOException $e) {
    die('An error ocurred' . $e->getMessage());
  }
  
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/simple.min.css">
  </head>
  <body>
    <header>
      <h1>Creativity Clash ©</h1>
    </header>
    <br><br>
    <main>
      <?php echo $msg ?? null; ?>
      <form method="POST" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <fieldset>
          <legend><h3>Login as admin</h3></legend>
          <label>
            Email Address
            <input type="email" name="email" required="">
          </label>
          <label>
            Password
            <input type="password" name="password" required>
          </label>
          <button name="submit">Login</button>
        </fieldset>
      </form>
    </main>
  </body>
</html>