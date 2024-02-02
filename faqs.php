<?php
include('connect.php'); 
$current_page = "FAQs";

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title><?=$current_page;?> | <?php echo SITETITLE; ?></title>
    <?php include('include_css.php'); ?>
    <meta name="robots" content="follow, index, max-snippet:-1, max-image-preview:large"/>
</head>

<body>
    <!-- Header Area Start -->
    <?php include('include_header.php'); ?>
    <!-- Header Area End -->

    <!-- Breadcrumb Area Start -->
    <?php include('include_breadcrumb_area.php'); ?>
    <!-- Breadcrumb Area End -->
    
    <div class="returns-banner">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-9">
                    <h1>Frequently asked questions</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="faq-section">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-9">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12 shooping-faq">
                            <div id="accordion" class="faq-accordian">
                              <?php   
                                $faq_r = $db->rpgetData("faq","*","isDelete=0");
                                    if(@mysqli_num_rows($faq_r)>0)
                                    { 
                                      $count = 0;
                                      while($faq_d = @mysqli_fetch_array($faq_r))
                                      {
                                          $count++;
                                          if ($count==1) {
                                            $show_class = "show";
                                            $aria_expanded = "true";
                                          }else{
                                            $show_class = "hide";
                                            $aria_expanded = "false";
                                          }
                                ?>
                                        <div class="card faq-card">
                                          <div class="card-header" id="headingOne_<?php echo $count; ?>">
                                            <h5 class="mb-0 text-left" data-toggle="collapse" data-target="#collapseOne_<?php echo $count; ?>" aria-expanded="<?php echo $aria_expanded; ?>" aria-controls="collapseOne_<?php echo $count; ?>">
                                              <button class="btn btn-collapse w-100 text-left">
                                                <?php echo stripslashes($faq_d['question']); ?>
                                                <span class="float-right"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                              </button>
                                            </h5>
                                          </div>

                                          <div id="collapseOne_<?php echo $count; ?>" class="collapse <?php echo $show_class; ?>" aria-labelledby="headingOne_<?php echo $count; ?>" data-parent="#accordion">
                                            <div class="card-body">
                                              <?php echo stripslashes($faq_d['answer']); ?>
                                            </div>
                                          </div>
                                        </div>
                                      <?php
                                  }
                                }
                                ?>
                             <!--  <div class="card faq-card">
                               <div class="card-header" id="headingTwo">
                                 <h5 class="mb-0 text-left" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                   <button class="btn btn-collapse w-100 text-left collapsed">
                                    What is Loreum Ipsum? 
                                    <span class="float-right"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                   </button>
                                 </h5>
                               </div>
                               <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                 <div class="card-body">
                                   Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                 </div>
                               </div>
                             </div>
                             <div class="card faq-card">
                               <div class="card-header" id="headingThree">
                                 <h5 class="mb-0 text-left" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                   <button class="btn btn-collapse text-left w-100 collapsed" >
                                     What is Loreum Ipsum?
                                     <span class="float-right"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                   </button>
                                 </h5>
                               </div>
                               <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                 <div class="card-body">
                                   Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                 </div>
                               </div>
                             </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Area Start -->
    <?php include('include_footer.php'); ?>
    <!-- Footer Area End -->

    <!-- all js here -->
    <?php include('include_js.php'); ?>
    <script type="text/javascript">
        
    </script>
</body>

</html>