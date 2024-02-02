<?php
$site_logo      = SITEURL.'common/images/logo.png';
$site_name      = SITETITLE;
$site_name      = isset($site_name) ? ucwords($site_name) : "-";
$site_address   = SITEADDRESS;
$reseturl       = ADMINURL."set-new-password/".md5($id)."/".$fps."/";
$reseturl       = isset($reseturl) ? $reseturl : "";
$copyright_year = date("Y");

$body = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
        <style type="text/css">

            body{width: 100%; background-color: #0d0b0c; margin:0; padding:0; -webkit-font-smoothing: antialiased;mso-margin-top-alt:0px; mso-margin-bottom-alt:0px; mso-padding-alt: 0px 0px 0px 0px;}

            p,h1,h2,h3,h4{margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;}

            span.preheader{display: none; font-size: 1px;}

            html{width: 100%;}
            
            table{font-size: 12px;border: 0;}

            .menu-space{padding-right:25px;}

            a,a:hover { text-decoration:none;}

            @media only screen and (max-width:640px){
                body {width:auto!important;}
                table [class=main] {width:440px !important;}
                table [class=two-left] {width:420px !important; margin:0px auto;}
                table [class=full] {width:100% !important; margin:0px auto;}
                table [class=two-left-inner] {width:400px !important; margin:0px auto;}
                table [class=menu-icon] { display:none;}
            }

            @media only screen and (max-width:479px) {
                body {width:auto!important;}
                table [class=main]  {width:310px !important;}
                table [class=two-left] {width:300px !important; margin:0px auto;}
                table [class=full] {width:100% !important; margin:0px auto;}
                table [class=two-left-inner] {width:280px !important; margin:0px auto;}
                table [class=menu-icon] { display:none;}
            }
        </style>
    </head>
    <body yahoo="fix" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#0d0b0c">
            <tr>
                <td align="center" valign="top">
                    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                        <tr>
                            <td height="100" align="center" valign="top" style="font-size:100px; line-height:100px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="330" align="center" valign="top" style="background:#fff;color:#000; border: 2px solid #f15f23; border-bottom: none; -moz-border-radius: 4px 4px 0px 0px; border-radius: 4px 4px 0px 0px;">
                                <table width="510" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                    <tr>
                                        <td height="40" align="left" valign="top" style="font-size:40px; line-height:40px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="full">
                                                <tr>
                                                    <td align="center" valign="top"><a href="#"><img editable="true" mc:edit="bm9-01" src="'.$site_logo.'" alt="" title="" style="display:block" width="150" height="auto"/></a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="30" align="left" valign="top" style="font-size:50px; line-height:30px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                                <tr>
                                                    <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:normal; line-height:32px;" mc:edit="bm9-04"><multiline>Reset Password</multiline></td>
                                                </tr>
                                                <tr>
                                                    <td height="10" align="left" valign="top" style="font-size:10px; line-height:10px;">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top" style="font-family:Open Sans, sans-serif, Verdana; font-size:15px; font-weight:normal; line-height:24px; padding:0px 25px 0px 25px;" mc:edit="bm9-06"><multiline>Click below link to reset your password !<span style="font-weight: bold;"></span></multiline></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top" style="font-family:Open Sans, sans-serif, Verdana; font-size:15px; font-weight:normal; line-height:24px; padding:5px 25px;" mc:edit="bm9-06"><multiline></multiline></td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top" style="font-family:Open Sans, sans-serif, Verdana; font-size:15px; font-weight:normal; line-height:24px; padding:0px 25px;" mc:edit="bm9-06"><multiline></multiline></td>
                                                </tr>
                                                <tr>
                                                    <td height="40" align="center" valign="top">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td align="center" valign="top">
                                                        <table width="220" border="0" align="center" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td height="50" align="center" valign="middle" bgcolor="#F15F23" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; font-weight:bold; -moz-border-radius: 50px; border-radius: 50px;" mc:edit="bm9-07"><multiline><a href="'.$reseturl.'" style="text-decoration:none; color:#FFF;">Reset Password</a></multiline></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="40" align="center" valign="top">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" style="background:#5271b7;color:#FFF;border: 2px solid #f15f23; border-top: none;">
                                <table width="380" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                                    <tr>
                                        <td height="45" align="center" valign="top" style="font-size:45px; line-height:45px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:normal; line-height:28px;" mc:edit="bm9-13"><multiline>'.$site_name.', '.$site_address.'</multiline></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold; line-height:28px;" mc:edit="bm9-14"><multiline>Copyright &copy; '.$copyright_year.' '.$site_name.'</multiline></td>
                                    </tr>
                                    <tr>
                                        <td height="30" align="center" valign="top" style="font-size:30px; line-height:30px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="100" align="center" valign="top" style="font-size:100px; line-height:100px;">&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>';
?>