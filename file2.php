
<?php

include('connect.php');
  $path ="images/back/";
  //echo $path;
//   print_r(glob($path."*.*"));
$i=0;
  foreach(glob($path."*.*") as $file) 
  {
    $i++;
    var_dump($file);
    
    $file_name = basename($file);
    $path_parts = pathinfo($file_name);
    $file_type = "image/".$path_parts['extension'];
   
   
    $file_size = filesize($file_name);
    $error ="";
    
   
    if ($error > 0)
    {
        echo $error;
    }
    else if (($file_type == "image/gif") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "image/pjpeg"))
    {
        $s=$path.$file_name;
        $d="b1/" . $file_name;
        echo $i;
        $filename = compress_image($s, "images/back/b1/" . $file_name, 80);
        echo $i;
    }
    else
    {
        echo "Uploaded image should be jpg or gif or png.";
    }
    function compress_image($source_url, $destination_url, $quality)
    {
       
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        else ($image = imagecreatefrompng($source_url));
        imagejpeg($image, $destination_url, $quality);
        echo "Image uploaded successfully.";
        return $destination_url;
    }
}
echo $i; 
?>