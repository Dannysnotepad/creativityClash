<?php

session_start();

if(isset($_SESSION['admin'])){
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $email = $_POST['user'];
    try {
      require_once 'inc/db_config.php';
      $query = "DELETE FROM users WHERE email = :email;";
      
      $stmt = $pdo->prepare($query);
      
      $stmt->bindParam(':email', $email);
      
      $stmt->execute();
      
      rmdir("users/".$email);
      
      $pdo = null;
      $stmt = null;
      
      
      header('Location: /admin');
    } catch (PDOException $e) {
      die("An error ocurred".$e->getMesaage());
    }
  }
}else{
  header('Location: /adminlogin');
}