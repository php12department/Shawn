<?php
  $path ="images/product/";
  ini_set('max_execution_time', 0);
  ini_set('memory_limit', '-1');
  $i=1;
  foreach(glob($path."*.*") as $file) 
  {
    
        
      echo $i."<br>";
      $filenm= basename($file);
      $filename_without_ext = substr($filenm, 0, strrpos($filenm, "."));
         //$imageUploadPath ="E:/APP/WWW/shawn/images/productlivecompress/$filenm";
        $imageUploadPath ="E:/APP/WWW/shawn/images/product1/$filename_without_ext.webp";
         $imgInfo = getimagesize($file); 
         // if(imageistruecolor($filenm))
         // {
            $mime = $imgInfo['mime']; 
              switch($mime){ 
                    case 'image/jpeg': 
                        $image = imagecreatefromjpeg($file); 
                        break; 
                    case 'image/png': 
                        $image = imagecreatefrompng($file); 
                        imagepalettetotruecolor($image);
                        break; 
                    case 'image/gif': 
                        $image = imagecreatefromgif($file); 
                        imagepalettetotruecolor($image);
                        break; 
                    default: 
                        $image = imagecreatefromjpeg($file); 
                } 
                if(imagewebp($image, $imageUploadPath, 100))
              {

              }
              else
              {
                    echo $file;
              }
         // }
         // else
         // {  
         //    echo $i."platter<br>";

         // }
    
       
      $i++;
       
      
  }


?>