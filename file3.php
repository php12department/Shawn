<?php

include('connect.php');
  $path ="images/back/";
  //echo $path;
//   print_r(glob($path."*.*"));
  foreach(glob($path."*.*") as $file) 
  {
    $file_name = basename($file);
    $path_parts = pathinfo($file_name);
    if($path_parts['extension']=="jpeg/jpg");
    {
        $sourceFile = $file_name;
        $outputFile = $file_name;
        $outputQuality = 60;
        $imageLayer = imagecreatefromjpeg($sourceFile);
        imagejpeg($imageLayer, $outputFile, $outputQuality);
    }

  }
?>