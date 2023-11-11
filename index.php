<?php 
  session_start();

  if(!isset($_SESSION['username'])){
    header('Location: /signup');
  }else{
    $email = $_SESSION['username']."@gmail.com";
    try {
        require_once "inc/db_config.php";
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);

        

        $stmt->execute();

        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        session_regenerate_id();
        $_SESSION['user'] = $user[0]['username'];
        //$_SESSION['id'] = $user[0]['id'];
    } catch (PDOException $e) {
        die('An error occurred' . $e->getMessage());
    }
 ?>   
<!Doctype html>
<html>
  <head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=Edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   
   <title>Home</title>
   <link rel="stylesheet" href="css/simple.min.css">
  </head>
  <body>
    <header>
      <h1>Creativity Clash ©</h1>
    </header>
    <center>
      <h3>Welcome back @<?php echo $_SESSION['username'] ?? null;?> with id <?php echo$_SESSION['id']?? null;?></h3>
    </center>
    <p>Its <span class="date"></span> and another to be productive, keep thriving :)</p>
    <button><b><a href="/submit" style="color:black">Submit Project</a></b></button>
    <button><b><a href="/submitted-projects" style="color:black">View submitted projects</a></b></button>
    <form method="POST" action="logout.php">
      <button name="logout"><b>Logout</b></button>
    </form>
  </body>
</html>

<?php
  }
?>