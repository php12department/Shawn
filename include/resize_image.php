<?php    

class SimpleImage {   

	var $image; 

	var $image_type;   

	function load($filename) 

	{   

		$image_info = getimagesize($filename); 

		$this->image_type = $image_info[2];

		if( $this->image_type == IMAGETYPE_JPEG ) 

		{   

			$this->image = imagecreatefromjpeg($filename); 

		} 

		elseif( $this->image_type == IMAGETYPE_GIF )

		{  

			$this->image = imagecreatefromgif($filename); 

		} 

		elseif( $this->image_type == IMAGETYPE_PNG || $this->image_type == "image/png") 

		{   

			$this->image = imagecreatefrompng($filename);

			

		} 

	} 

	function save($filename, $image_type=IMAGETYPE_JPEG, $compression=75, $permissions=null)

	{



	  // do this or they'll all go to jpeg

	  $image_type=$this->image_type;

	

	  if( $image_type == IMAGETYPE_JPEG ) 

	  {

		 imagejpeg($this->image,$filename,$compression);

	  } 

	  elseif( $image_type == IMAGETYPE_GIF ) 

	  {

		 imagegif($this->image,$filename);  

	  } 

	  elseif( $image_type == IMAGETYPE_PNG ) 

	  {

		// need this for transparent png to work          

		imagealphablending($this->image, false);

		imagesavealpha($this->image,true);

		imagepng($this->image,$filename);

	  }   

	  if( $permissions != null) 

	  {

		 chmod($filename,$permissions);

	  }

	

	}

	function output($image_type=IMAGETYPE_JPEG) 

	{   

		if( $image_type == IMAGETYPE_JPEG ) 

		{ 

			imagejpeg($this->image); 

		} 

		elseif( $image_type == IMAGETYPE_GIF ) 

		{   

			imagegif($this->image); 

		} 

		elseif( $image_type == IMAGETYPE_PNG ) 

		{   

			imagepng($this->image); 

		} 

	} 

	function getWidth() 

	{   	

		return imagesx($this->image); 

	} 

	function getHeight() 

	{   

		return imagesy($this->image); 

	} 

	function resizeToHeight($height) 

	{   

		$ratio = $height / $this->getHeight(); 

		$width = $this->getWidth() * $ratio; 

		$this->resize($width,$height); 

	}   

	function resizeToWidth($width) 

	{ 

		$ratio = $width / $this->getWidth(); 

		$height = $this->getheight() * $ratio; 

		$this->resize($width,$height); 

	}   

	function scale($scale) 

	{ 

		$width = $this->getWidth() * $scale/100; 

		$height = $this->getheight() * $scale/100; $this->resize($width,$height); 

	}   

	function resize($width,$height,$forcesize='n') 

	{

		/* optional. if file is smaller, do not resize. */

	  	if ($forcesize == 'n') 

		{

			if ($width > $this->getWidth() && $height > $this->getHeight())

			{

				 $width = $this->getWidth();

				 $height = $this->getHeight();

			}

		}

		

		$new_image = imagecreatetruecolor($width, $height);

		/* Check if this image is PNG or GIF, then set if Transparent*/  

		if(($this->image_type == IMAGETYPE_GIF) || ($this->image_type==IMAGETYPE_PNG))

		{

			imagealphablending($new_image, false);

			imagesavealpha($new_image,true);

			$transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);

			imagefilledrectangle($new_image, 0, 0, $width, $height, $transparent);

		}

		imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());

		$this->image = $new_image;   

	

	}   


	function createThumbnail($image_name,$new_width,$new_height,$uploadDir,$moveToDir)
	{
		
	    
	    $mime = getimagesize($uploadDir);

	    if($mime['mime']=='image/png'){ $src_img = imagecreatefrompng($uploadDir); }
	    if($mime['mime']=='image/jpg'){ $src_img = imagecreatefromjpeg($uploadDir); }
	    if($mime['mime']=='image/jpeg'){ $src_img = imagecreatefromjpeg($uploadDir); }
	    if($mime['mime']=='image/pjpeg'){ $src_img = imagecreatefromjpeg($uploadDir); } 

	    $old_x          =   imageSX($src_img);
	    $old_y          =   imageSY($src_img);

	    if($old_x > $old_y)
	    {
	        $thumb_w    =   $new_width;
	        $thumb_h    =   $old_y/$old_x*$new_width;
	    }

	    if($old_x < $old_y)
	    {
	        $thumb_w    =   $old_x/$old_y*$new_height;
	        $thumb_h    =   $new_height;
	    }

	    if($old_x == $old_y)
	    {
	        $thumb_w    =   $new_width;
	        $thumb_h    =   $new_height;
	    }

	    $dst_img        =   imagecreatetruecolor($thumb_w,$thumb_h);

	    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 


	    // New save location
	    if($mime['mime']=='image/png'){ $result = imagepng($dst_img,$moveToDir,8); }
	    if($mime['mime']=='image/jpg'){ $result = imagejpeg($dst_img,$moveToDir,80); }
	    if($mime['mime']=='image/jpeg'){ $result = imagejpeg($dst_img,$moveToDir,80); }
	    if($mime['mime']=='image/pjpeg'){ $result = imagejpeg($dst_img,$moveToDir,80); }

	    imagedestroy($dst_img); 
	    imagedestroy($src_img);

	    return $result;
	} 

} 

?>

