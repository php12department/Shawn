<?php
$site_logo      = SITEURL.'common/images/logo.png';
$bg_img 		= SITEURL."mailbody/images/bg1.jpg";
$redirect_url 	= SITEURL."contact-us/";
$re = "margin:0 auto;background-image:url(".$bg_img.");background-repeat: no-repeat;background-size: cover; padding: 43px 83px; color: #404040; font-family: lato";
$body = '<table width="600px" border="0" style="'.$re.'">
	<tr>
		<td style="padding-bottom: 50px;border:none; text-align: center;"><img src="'.$site_logo.'" style="width:150px;margin-top:13px;"></td>
	</tr>
	<tr>
		<td style="padding:30px 0px 0px 0px; background-color: #fff;border:none; border-radius: 5px;">
			<table width="100%" border="0" style="text-align: center">
				<tr>
					<td style="font-size: 16px; font-weight:700;padding:10px 50px 5px;" align="left">
						Your request has been successfully received. 
					</td>
				</tr> 
				<tr>
					<td style="font-size: 16px; font-weight:700;padding:10px 50px 5px;" align="left">
						Please find below your request details :- 
					</td>
				</tr>
				<tr>
					<td style="font-size: 16px; font-weight:700;padding:10px 50px 5px;" align="left">
						<p>Name : '.$name.'</p> 
						<p>Email : '.$email.'</p> 
						<p>Subject : '.$subject.'</p> 
						<p>Message : '.nl2br($message).'</p> 
					</td>
				</tr>
				<tr>
					<td style="font-size: 16px; font-weight:700;padding:10px 50px 5px;">
						<a href="'.$redirect_url.'" style="background-color: #555555;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;" class="button">Back To Website</a>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';

// echo $body; die();
?>

