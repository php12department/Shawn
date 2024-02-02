<?php
include('connect.php'); 
if(!isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID']=="")
{
    $_SESSION['MSG'] = "NEED_TO_LOGIN_FRONTEND";
    $db->rplocation(SITEURL.'login/');
    die();
} 

$current_page = "Add Submission";
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
	<title> <?=$current_page;?> | <?php echo SITETITLE; ?></title>
	<?php include('include_css.php'); ?>
  <meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
  <!-- meta tags site details -->
  <meta property="og:locale" content="en_US" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="Upload Photos - Zilli Furniture" />
  <meta property="og:description" content="Upload photos of your new and modern furniture collection at zilli furniture after purchasing from zilli furniture. So our new customers can have a look at it." />
  <meta property="og:url" content="<?=$actual_link;?>" />
  <meta property="og:site_name" content="<?php echo SITETITLE; ?>" />
  <meta property="og:image" content="<?=SITEURL?>common/images/logo.png" />
  <meta property="og:image:secure_url" content="<?= SITEURL?>common/images/logo.png" />
  <meta property="og:image:width" content="1282" />
  <meta property="og:image:height" content="676" />
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:description" content="Upload photos of your new and modern furniture collection at zilli furniture after purchasing from zilli furniture. So our new customers can have a look at it." />
  <meta name="twitter:title" content="Upload Photos - Zilli Furniture" />
  <meta name="twitter:image" content="<?= SITEURL?>common/images/logo.png" />
  <!-- end meta tags site details -->
</head>

<body>
	<!-- Header Area Start -->
	<?php include('include_header.php'); ?>
	<!-- Header Area End -->
	
  <div class="gallary-section">
    <div class="upload-gallary-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 col-md-8 col-lg-6">
            <h3 class="mb-5 text-center">Upload Your Photos</h3>
            <div class="upload-file">
              <form name="frm" id="frm" action="<?php echo SITEURL; ?>process-addsubmission/" method="post" enctype="multipart/form-data">
                <div class="box">
                    <div class="form-group">
                      	<label for="exampleFormControlTextarea1">Upload File</label>
                      		<input type="file" name="file_name" id="file_name" class="inputfile" data-multiple-caption="{count} arquivos selecionados" >
                      	<label for="file_name"><span class="archive-name"></span></label>
                      	<div id="error_image"></div>
                    </div>
              	</div>
                 <div class="form-group">
                  <label for="comments"> Comment</label>
                  <textarea class="form-control" id="comments" name="comments" rows="6"></textarea>
                </div>
                <div class="form-group">
                  <label for="order_number"> Order Number</label>
                  <input type="text" class="form-control" id="order_number" name="order_number">
                </div>
            </div>

          </div>
        </div>
         <div class="row justify-content-center text-center">
              	<button type="submit" name="submit" id="submit" class="banner-btn
               hover-effect-span text-center">UPLOAD PHOTOS
                <span class="icon">
                  	<svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid" fill='#fff' style="width:21px; height: 10px;" viewBox="0 0 21 10"><path d="M21.000,5.000 L15.000,10.000 L15.000,6.000 L-0.000,6.000 L-0.000,4.000 L15.000,4.000 L15.000,0.000 L21.000,5.000 Z"></path></svg>
                </span>
              </button>
            </div>
        </form>
      </div>
    </div>
  </div>

	<!-- Footer Area Start -->
	<?php include('include_footer.php'); ?>
	<!-- Footer Area End -->
	<!-- all js here -->
	<?php include('include_js.php'); ?>
  <script type="text/javascript">
    /*
  By Osvaldas Valutis, www.osvaldas.info
  Available for use under the MIT License
*/

'use strict';

;( function( $, window, document, undefined )
{
  $( '.inputfile' ).each( function()
  {
    var $input   = $( this ),
      $label   = $input.next( 'label' ),
      labelVal = $label.html();

    $input.on( 'change', function( e )
    {
      var fileName = '';

      if( this.files && this.files.length > 1 )
        fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
      else if( e.target.value )
        fileName = e.target.value.split( '\\' ).pop();

      if( fileName )
        $label.find( '.archive-name' ).html( fileName );
      else
        $label.html( labelVal );
    });

    // Firefox bug fix
    $input
    .on( 'focus', function(){ $input.addClass( 'has-focus' ); })
    .on( 'blur', function(){ $input.removeClass( 'has-focus' ); });
  });
})( jQuery, window, document );

  </script>
	<script type="text/javascript">
		$(function(){
			$("#frm").validate({
				rules: {
					file_name:{required : true},
					comments:{required : true},
					order_number:{required : true},
				},
				messages: {
					file_name:{required:"Please select image."},
					comments:{required:"Please Enter comments."},
					order_number:{required:"Please Enter order number."},
				},
                errorPlacement: function(error, element) {
					if (element.attr("name") == "file_name") {
						error.insertAfter("#error_image");
					}
					else
					{
						error.insertAfter(element);
					}
				}
			});
		});
	</script>
</body>
</html>