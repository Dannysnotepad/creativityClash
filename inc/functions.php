<?php 
  function count_projects($user_name){
    $extensionsAllowed = ['jpg','jpeg', 'png'];
    $folderpath = "users/$user_name";
    $files = scandir($folderpath);
    $imageCount = 0;
    foreach ($files as $file) {
      $extension = pathinfo($file, PATHINFO_EXTENSION);
      if(in_array(strtolower($extension), $extensionsAllowed)){
        $imageCount++;
      }
    }
    return $imageCount;
  }
?>