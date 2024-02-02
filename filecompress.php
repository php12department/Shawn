
<?php
include('connect.php');
  $path ="images/productlive/";
  ini_set('max_execution_time', 0);
  //echo $path;
//   print_r(glob($path."*.*"));
  foreach(glob($path."*.*") as $file) 
  {
        //echo $file."<br>";
       
         $filenm= basename($file);
         $imageUploadPath ="E:/APP/WWW/shawn/images/productlivecompress/$filenm";
        // $imageSize=getimagesize($filenm);
        // var_dump($imageSize);
        $compressedImage = compressImage($file, $imageUploadPath, 50); 
       // var_dump($compressedImage);
        if($compressedImage){ 
            $compressedImageSize = filesize($compressedImage); 
           // $compressedImageSize = convert_filesize($compressedImageSize); 
             
            $status = 'success'; 
            $statusMsg = "Image compressed successfully."; 
        }else{ 
            $statusMsg = "Image compress failed!"; 
        } 
        echo $statusMsg;

        if(!empty($compressedImage)){ ?>
           
            <p><b>Compressed Image Size:</b> <?php echo $compressedImageSize; ?></p>
            <img src="<?php echo $compressedImage; ?>">
        <?php } 
  }
  function compressImage($source, $destination, $quality) { 
    // Get image info 

   
    $imgInfo = getimagesize($source); 
    
    $mime = $imgInfo['mime']; 
   
     
    // Create a new image from file 
    switch($mime){ 
        case 'image/jpeg': 
            $image = imagecreatefromjpeg($source); 
            break; 
        case 'image/png': 
            $image = imagecreatefrompng($source); 
            break; 
        case 'image/gif': 
            $image = imagecreatefromgif($source); 
            break; 
        default: 
            $image = imagecreatefromjpeg($source); 
    } 
     
    // Save image 
    $a=imagejpeg($image, $destination, $quality); 
     
    // Return compressed image 
    return $a; 
}

// function convert_filesize($bytes, $decimals = 2) { 
//     $size = array('B','KB','MB','GB','TB','PB','EB','ZB','YB'); 
//     $factor = floor((strlen($bytes) - 1) / 3); 
//     return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor]; 
// }

?>