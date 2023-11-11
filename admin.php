<?php
session_start();

if(!isset($_SESSION['admin'])){
  header('Location: /adminlogin');
}else{
?>
<?php
include "inc/functions.php";

try {
  include_once('inc/db_config.php');
  
  $query = "SELECT * FROM users;";
  
  $stmt = $pdo->prepare($query);
  
  $stmt->execute();
  
  $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  
} catch (Exception $e) {
}

//var_dump($participants);

?>


<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="css/simple.min.css">
  </head>
  <body>
    <header>
      <h1>Creativity Clash ©</h1>
    </header>
    <main>
      <center>
        <h2>Welcome <?php echo $_SESSION['admin'] ?? null; ?></h2>
        <section>
          <h3>List of participants</h3>
          <?php 
          if(empty($participants)){
    echo "<p>No user found</p>";
  }else{
    foreach ($participants as $row){
      $project = count_projects($row['username']);
      echo "<div>";
      echo "<h5>".htmlspecialchars($row['username'])."</h5>";
      echo "<span>Project count $project</span><br>";
      echo "<small>".htmlspecialchars($row['account_created_at'])."</small>";
      echo "<hr>";
      echo "</div>";
    }
  }
          ?>
        </section>
        <sectio>
          <form method="POST" action="deleteUsers.php">
            <select name="user">
                        <?php 
          if(empty($participants)){
    $noUser = "<p>No user found</p>";
  }else{
    foreach ($participants as $row){
      echo "<option value=".$row['email'].">".$row['username']."</option>";
    }
  }
          ?>
          
            </select>
            <button name="submit">Delete user</button>
          </form>
        </section>
        <br><br><br>
        <form method="POST" action="logout.php">
         <button name="logout"><b>Logout</b></button>
       </form>
      </center>
    </main>
  </body>
</html>


<?php
}
?>