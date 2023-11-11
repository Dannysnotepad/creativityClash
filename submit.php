<?php
  session_start();

  if(!isset($_SESSION['username'])){
    header('Location: /login');
  }else{
?>

<?php

  $allowed_extensions = ['jpg', 'jpeg', 'png'];
 if(isset($_POST['submit'])){
    
    $parentfolder = 'users';
    $subfolder = $_SESSION['username'];
    $folderpath = "{$parentfolder}/{$subfolder}/{$title}";
    
    if(!is_dir($folderpath) && !file_exists($folderpath)){
      mkdir($folderpath, 0777, true);
      
      
      
    }else{
      $msg = '<p style="color:darkred">Folder already exist</p>';
    }
   if(!empty($_FILES['upload']['name'])){
     $file_name = $_FILES['upload']['name'];
     $file_size = $_FILES['upload']['size'];
     $file_tmp = $_FILES['upload']['tmp_name'];
     $target_dir = "{$folderpath}/{$file_name}";
     
     //Check file extentsion
     $file_ext = explode('.', $file_name);
     $file_ext = strtolower(end($file_ext));
     
     //validate file
     if(in_array($file_ext, $allowed_extensions)){
       if($file_size <= 1000000 ){
         move_uploaded_file($file_tmp, $target_dir);
         
       }else{
         $message = '<p style="color:darkred">File size is too big</p>';
       }
     }else{
       $message = '<p style="color:darkred">Sorry, only jpeg, jpg and png files are allowed</p>';
     }
   }
   
   //upload to database
      $username = $_SESSION['username'];
      $title = htmlspecialchars($_POST['title']);
      $description = htmlspecialchars($_POST['des']);
      $img_path = $folderpath.$file_name;
      $project_submited_at = date('Y-m-d H:i:s');
      
      try {
       require_once  "inc/db_config.php";
       $query = "INSERT INTO projects (username, title, description, img_path, project_submited_at, users_id) VALUES (:username, :title, :description, :img_path, :project_submited_at, :users_id)";
       $stmt = $pdo->prepare($query);
    
       $stmt->bindParam(':username', $_SESSION['username']);
       $stmt->bindParam(':title', $title);
       $stmt->bindParam(':description', $description);
       $stmt->bindParam(':img_path', $img_path);
       $stmt->bindParam(':project_submited_at', $project_submited_at);
       $stmt->bindParam(':users_id', $_SESSION['id']);
    
       $stmt->execute();
    
       $pdo = null;
       $stmt = null;
       
       $success = '<p style="color:green">Project uploaded successfully</p>';
    
  } catch (PDOException $e) {
    die('An error ocurred' . $e->getMessage());
  }
   
 }
?>

<!Doctype html>
<html>
  <head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=Edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   
   <title>Project Submit</title>
   <link rel="stylesheet" href="css/simple.min.css">
  </head>
  <body>
    <header>
      <h1>Creativity Clash</h1>
    </header>
    <h2>Submit project</h2>
    <?php echo $success ?? null; ?>
    <form id="form" method="POST" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
      <label>
        Title<br>
        <input type="text" name="title" placeholder="Enter the title or name of brand" required>
      </label>
      <label>
        Description<br>
        <textarea id="des" name="des"></textarea>
      </label>
      <label>
        File<br>
        <?php echo $message ?? null; ?>
        <input type="file" id="img" name="upload" required>
      </label>
      <button id="submit" name="submit">Submit</button>
    </form>
    <button><b><a href="/" style="color:black">back to home</a></b></button>
    
  </body>
</html>

<?php
  }
?>