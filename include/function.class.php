<?php
class Functions 
{
    /** Local Database Detail **/
    protected $db_l_host = "localhost";
    protected $db_l_user = "root";
    protected $db_l_pass = "";
    protected $db_l_name = "zillif5_zillifurniture"; 
    
    /** Live Database Detail **/
    protected $db_host = "localhost";
    protected $db_user = "zillif5_zillifurniture";
    protected $db_pass = "^w=j6H1r43nD"; 
    protected $db_name = "zillif5_zillifurniture"; 
    
    protected $con = false; 
    public $myconn; 
    
    function __construct() {
        global $myconn;

        if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'pc-24' || $_SERVER['HTTP_HOST'] == '192.168.43.162'){ 
            $myconn = @mysqli_connect($this->db_l_host,$this->db_l_user,$this->db_l_pass,$this->db_l_name);
        } else {
            $myconn = @mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
        }
        
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();die;
        }
    }
	/*
		*** Main Function <<<
			-> rpgetData() 
				- return single and multi records
			-> rpgetValue() 
				- return single records
			-> rpgetTotalRecord()
				- return number of records
			-> rpgetMaxVal()
				- return maximum value
			-> rpinsert()
				- insert record
			-> rpdelete()
				- delete record
			-> rpupdate()
				- update record
			-> tableExists()
				- check whether table exist or not
			-> rplimitChar()
				- return trimed character string
			-> rpdupCheck()
				- check for duplicate record in table
			-> rplocation()
				- redirect to given URL
			-> rpgetDisplayOrder()
				- get next display order
			-> rpcreateSlug()
				- create alias of given string
			-> rpgetTotalReview()
				- number of total review of product
			-> rpcatData()
				- get cid/sid/ssid from slug
			-> clean()
				- prevent mysql injction
	*/
	public function rpgetData($table, $rows = '*', $where = null, $order = null,$die=0) // Select Query, $die==1 will print query
    {
		
		$results = array();
        $q = 'SELECT '.$rows.' FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;
		if($die==1){ echo $q;die; }
        if($this->tableExists($table))
       	{
			
			if(@mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_query($GLOBALS['myconn'],$q);
				return $results;
			}else{
				return false;
			}
        }
		else{
			return false;
		}
    }
	
	public function rpgetValue($table, $row=null, $where=null,$die=0) // single records ref HB function
    {
		if($this->tableExists($table) && $row!=null && $where!=null)
       	{
			$q = 'SELECT '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){ echo $q; }
			if(@mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_array(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return false;
			}
        }
		else{
			return false;
		}
    }
	
	public function rpgetMaxVal($table, $row=null, $where=null,$die=0)
    {
		if($this->tableExists($table) && $row!=null && $where!=null)
       	{
			$q = 'SELECT MAX('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_array(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
        }
		else{
			return 0;
		}
    }
	public function rpgetMinVal($table, $row=null, $where=null,$die=0)
    {
		if($this->tableExists($table) && $row!=null && $where!=null)
       	{
			$q = 'SELECT MIN('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_array(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
        }
		else{
			return 0;
		}
    }
	
	public function rpgetSumVal($table, $row=null, $where=null,$die=0)
    {
		if($this->tableExists($table) && $row!=null && $where!=null)
       	{
			$q = 'SELECT SUM('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_array(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
        }
		else{
			return 0;
		}
    }
	
	public function rpgetAvgVal($table, $row=null, $where=null,$die=0)
    {
		if($this->tableExists($table) && $row!=null && $where!=null)
       	{
			$q = 'SELECT AVG('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_array(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
        }
		else{
			return 0;
		}
    }
	
	public function rpgetTotalRecord($table, $where = null,$die=0) // return number of records
    {
		$q = 'SELECT * FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
		if($die==1){
			echo $q;die;
		}
        if($this->tableExists($table))
			return mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))+0;
        else
			return 0;
    }
	
	public function rpinsert($table,$values,$rows = 0,$die=0) // rpinsert - Insert and Die Values 
    {
	
		if($this->tableExists($table))
        {
		
            $insert = 'INSERT INTO '.$table;
            if(count($rows) > 0)
            {
                $insert .= ' ('.implode(",",$rows).')';
            }
 
            for($i = 0; $i < count($values); $i++)
            {
                if(is_string($values[$i]))
                    $values[$i] = '"'.$values[$i].'"';
            }
            $values = implode(',',$values);
            $insert .= ' VALUES ('.$values.')';
			if($die==1){
				echo $insert;die;
			}
            $ins = @mysqli_query($GLOBALS['myconn'],$insert);           
            if($ins)
            {
				$last_id = mysqli_insert_id($GLOBALS['myconn']);
                return $last_id;
            }
            else
            {
                return false;
            }
        }
    }
	
	public function rpdelete($table,$where = null,$die=0)
    {
        if($this->tableExists($table))
        {
            if($where != null)
            {
                $delete = 'DELETE FROM '.$table.' WHERE '.$where;
				if($die==1){
					echo $delete;die;
				}
				$del = @mysqli_query($GLOBALS['myconn'],$delete);
            }
            if($del)
            {
                return true;
            }
            else
            {
               return false;
            }
        }
        else
        {
            return false;
        }
    }
	
    public function rpupdate($table,$rows,$where,$die=0) //update query
    {
        if($this->tableExists($table))
        {
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
			//print_r($where);die;
            
            $update = 'UPDATE '.$table.' SET ';
            $keys = array_keys($rows);
            for($i = 0; $i < count($rows); $i++)
           	{
                if(is_string($rows[$keys[$i]]))
                {
                    $update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
                }
                else
                {
                    $update .= $keys[$i].'='.$rows[$keys[$i]];
                }
                 
                // Parse to add commas
                if($i != count($rows)-1)
                {
                    $update .= ',';
                }
            }
            $update .= ' WHERE '.$where;
			if($die==1){
				echo $update;//die;
			}
			//$update = trim($update," AND");
            $query = @mysqli_query($GLOBALS['myconn'],$update);
            if($query)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
	
	public function tableExists($table)
    {
        return true;
    }
	
	public function rplimitChar($content,$limit,$url="javascript:void(0);",$txt="&hellip;")
    {
        if(strlen($content)<=$limit){
			return $content;
		}else{
			$ans = substr($content,0,$limit);
			if($url!=""){
				$ans .= "<a href='$url' class='desc'>$txt</a>";
			}else{
				$ans .= "&hellip;";
			}
			return $ans;
		}
    }
	
	public function rpdupCheck($table, $where = null,$die=0) // Duplication Check
    {
        $q = 'SELECT id FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
		if($die==1){ echo $q;die; }
		if($this->tableExists($table))
       	{
			$results = @mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q));
			if($results>0){
				return true;
			}else{
				return false;
			}
        }
		else
      		return false;
    }
	
	public function rplocation($redirectPageName=null) // Location
    {
		if($redirectPageName==null)
		{
		?>
		<script>
		    location.href = <?php echo $this->SITEURL; ?>;
		</script>
		<?php
			/*header("Location:".$this->SITEURL);
			exit;*/
		}
		else
		{?>
		<script>
		    location.href = "<?php echo $redirectPageName; ?>";
		</script>
		<?php
			/*header("Location:".$redirectPageName);
			exit;*/
		}
    }
	
	public function rpgetDisplayOrder($table,$where=null,$die=0) // Display Order
    {
        $q = 'SELECT MAX(display_order) as display_order FROM '.$table;
        if($where != null)
            $q .= ' WHERE '.$where;
		if($die==1){
			echo $q;die;
		}
        if($this->tableExists($table))
       	{
			$results = @mysqli_query($GLOBALS['myconn'],$q);
			if(@mysqli_num_rows($results)>0){
				$disp_d = mysqli_fetch_array($results);
				return intval($disp_d['display_order'])+1;
			}else{
				return 1;
			}
        }
		else{
      		return 1;
		}
    }
	
	public function rpcreateSlug($string)    // Slug 
	{   
		$slug = strtolower(trim(preg_replace('/-{2,}/','-',preg_replace('/[^a-zA-Z0-9-]/', '-', $string)),"-"));
		return $slug;
	}
	
	public function rpcreateProSlug($string) // Product Slug 
	{   
		$slug = strtolower(trim(preg_replace('/-{2,}/','-',preg_replace('/[^a-zA-Z0-9-.]/', '-', $string)),"-"));
		return $slug;
	}
	
	public function rpnum($val,$deci="2",$sep=".",$thousand_sep=""){
		return number_format($val,$deci,$sep,$thousand_sep);
	}
	
	public function rpget_client_ip(){
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
		  	$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
		 	$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
		  	$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
		  	$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		  	$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
		  	$ipaddress = getenv('REMOTE_ADDR');
		else
		  	$ipaddress = 'UNKNOWN';
		  
		return $ipaddress;
	}
	
	public function catData($cslug=null,$sslug=null,$ssslug=null){
		if($cslug!=null && $sslug==null && $ssslug==null){
			return $this->rpgetData("category","*","slug='".$cslug."' AND isDelete=0");
		}else if($cslug!=null && $sslug!=null && $ssslug==null){
			$cid	= $this->rpgetValue("category","id","slug='".$cslug."'");
			return $this->rpgetData("subcategory","*","cid='".$cid."' AND slug='".$sslug."' AND isDelete=0");
		}else{
			return false;
		}
	}
	
	public function rpgetReview($pid,$p=true)
    {
		$total_review 	= $this->rpgetTotalRecord("product_review","pid = '".$pid."'");
		$avg_rate 		= 20*intval($this->rpgetAvgVal("product_review","rate","id = '".$pid."'"));
		?>
		<div class="ratings">
			<div class="rating-box">
				<div style="width:<?php echo $avg_rate; ?>%" class="rating"></div>
			</div>
			<?php if($p){ ?>
			<p class="rating-links">
				<a href="javascript:void(0);"><?php echo $total_review; ?> Review(s)</a> <span class="separator">|</span> <a href="javascript:void(0);" onClick="rBC();">Add Your Review</a> 
			</p>
			<?php } ?>
		</div>
		<?php
    }
	
	public function clean($string)
	{
		$string = trim($string);								// Trim empty space before and after
		// if(get_magic_quotes_gpc()) {
		// 	$string = stripslashes($string);					        // Stripslashes
		// }
		$string = mysqli_real_escape_string($GLOBALS['myconn'],$string);			        // mysql_real_escape_string
		return $string;
	}
	function rpconvertYoutube($string) {
		return preg_replace(
			"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
			"<iframe width=\"100%\" height=\"250\" src=\"//www.youtube.com/embed/$2\" allowfullscreen frameborder=\"0\"></iframe>",
			$string
		);
	}
	public function rpcheckLogin($url=""){
		if(!isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) || $_SESSION[SESS_PRE.'_SESS_USER_ID']==""){
			$_SESSION[SESS_PRE.'_FAIL_LOG'] = "1";
			if($url==""){
				$_SESSION['backUrl'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$this->rplocation(SITEURL.'login/');
			}else{
				$this->rplocation($url);
			}
		}
    }
	
	public function rpcheckAdminLogin($url=""){
		if(!isset($_SESSION[SESS_PRE.'_ADMIN_SESS_ID']) || $_SESSION[SESS_PRE.'_ADMIN_SESS_ID']==""){
			if($url==""){
				$_SESSION['MSG'] = "NEED_TO_LOGIN";
				$_SESSION['adminbackUrl'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$this->rplocation(ADMINURL);
			}else{
				$this->rplocation($url);
			}
		}
    }
	
	public function printr($val,$isDie=1){
		echo "<pre>";
		print_r($val);
		if($isDie){die;}
	}
	public function rpCheckRemember(){
		if(isset($_COOKIE['SESS_COOKIE']) && $_COOKIE['SESS_COOKIE']>0){
			$_SESSION[SESS_PRE.'_SESS_USER_ID']=$_COOKIE['SESS_COOKIE'];
		}
	}
	public function rpDate($date, $format="Y-m-d h:i:s"){
		return date_format(date_create($date),$format);
	}
	public function rpgetCategoryTree(){ 
		$hcat_arr=array();
		$hcat_r=$this->rpgetData("category","*","isDelete=0","display_order");
		if(@mysqli_num_rows($hcat_r)>0){
			while($hcat_d=@mysqli_fetch_array($hcat_r)){
				
				$hid=$hcat_d['id'];
				$hname=stripslashes($hcat_d['name']);
				$hslug=stripslashes($hcat_d['slug']);
				$himage_path=stripslashes($hcat_d['image_path']);
				$hurl=SITEURL.$hslug.'/';
				
				$hscat_arr=array();
				$hscat_r=$this->rpgetData("subcategory","*","cid='".$hid."' AND isDelete=0","display_order");
				if(@mysqli_num_rows($hscat_r)>0){
					$cnt_abc = 0;
					while($hscat_d=@mysqli_fetch_array($hscat_r)){
						$hsid=$hscat_d['id'];
						$hsname=stripslashes($hscat_d['name']);
						$hsslug=stripslashes($hscat_d['slug']);
						$hssurl=SITEURL.$hslug."/".$hsslug.'/';
						$hscat_arr[$hsid]=array(
										"id"	=> $hsid,
										"name"	=> $hsname,
										"slug"	=> $hsslug,
										"url"	=> $hssurl,
										);
					}
				}
				$hcat_arr[$hid]=array(
							"id"	=> $hid,
							"name"	=> $hname,
							"slug"	=> $hslug,
							"image_path"	=> $himage_path,
							"url"	=> $hurl,
							"sub_cat"	=> $hscat_arr,
						);
			}
		}
		return $hcat_arr;
	}

	function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
	{
	   
	    $pagination = '';
	    if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
	        $pagination .= '<ul class="pagination_my mt-20">';
	        
	        $right_links    = $current_page + 3; 
	        $previous       = $current_page - 3; //previous link 
	        $next           = $current_page + 1; //next link
	        $first_link     = true; //boolean var to decide our first link
	        
	        if($current_page > 1){
				$previous_link = ($previous==0 || $previous==-1)? 1: $previous;
	            $pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>'; //first link
	            $pagination .= '<li><a href="#" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
	                for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
	                    if($i > 0){
	                        $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
	                    }
	                }   
	            $first_link = false; //set first link to false
	        }
	        
	        if($first_link){ //if current active page is first link
	            $pagination .= '<li class="first active">'.$current_page.'</li>';
	        }elseif($current_page == $total_pages){ //if it's the last active link
	            $pagination .= '<li class="last active">'.$current_page.'</li>';
	        }else{ //regular current link
	            $pagination .= '<li class="active">'.$current_page.'</li>';
	        }
	                
	        for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
	            if($i<=$total_pages){
	                $pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
	            }
	        }
	        if($current_page < $total_pages){ 
					$next_link = ($i > $total_pages) ? $total_pages : $i;
	                $pagination .= '<li><a href="#" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
	                $pagination .= '<li class="last"><a href="#" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
	        }
	        
	        $pagination .= '</ul>'; 
	    }
	    return $pagination; //return pagination links
	}

	public function rppaginate_function_front($item_per_page, $current_page, $total_records, $total_pages)
	{
		$pagination = '';
		if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
			$right_links    = $current_page + 3; 
			$previous       = $current_page - 3; 
			$next           = $current_page + 1; 
			$first_link     = true; 

			if($current_page > 1){
				$previous_link = ($previous<=0)?1:$previous;
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="1" title="First">&laquo;</a></li>'; //first link
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
					for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
						if($i > 0){
							$pagination .= '<li class="paginate_button "><a href="#"  data-page="'.$i.'" aria-controls="datatable1" title="Page'.$i.'">'.$i.'</a></li>';
						}
					}   
				$first_link = false; //set first link to false
			}
			
			if($first_link){ //if current active page is first link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}elseif($current_page == $total_pages){ //if it's the last active link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}else{ //regular current link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}
			
			for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
				if($i<=$total_pages){
					$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
				}
			}

			if($current_page < $total_pages){ 
				$next_link = ($i > $total_pages)? $total_pages : $i;
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
			}
		}
		return $pagination; //return pagination links
	}
	
	public function rpgetJoinData($table1,$table2,$join_on,$rows = '*',$where = null, $order = null,$die=0) // Select Query, $die==1 will print query
    {
		$results = array();
        $q = 'SELECT '.$rows.' FROM '.$table1." JOIN ".$table2." ON ".$join_on;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;
		if($die==1){ echo $q;die; }
		if(@mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
			$results = @mysqli_query($GLOBALS['myconn'],$q);
			return $results;
		}else{
			return false;
		}
    }
	
	public function rpgetJoinData2($table, $join, $rows = '*', $where = null, $order = null,$die=0) // Select Query, $die==1 will print query
    {
		$results = array();
        $q = 'SELECT '.$rows.' FROM '.$table. $join;
        if($where != null)
            $q .= ' WHERE '.$where;
        if($order != null)
            $q .= ' ORDER BY '.$order;
		if($die==1){ echo $q;die; }
		if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
			$results = @mysqli_query($GLOBALS['myconn'],$q);
			return $results;
		}else{
			return false;
		}
    }
	
	public function rpGetNotificationTxt($ntype1,$ntype){
		return constant($ntype);
	}
	public function rpGetJobNotificationLink($ntype,$jid,$prop_id=0){
		$url = "javascript:void(0);";
		switch ($ntype) {
			case "JOB_APPLY":
				return SITEURL."buyer/my-jobs/proposals/".$jid."/";
				break;
			case "JOB_AWARD":
				return SITEURL."seller/applied-jobs/view/".$prop_id."/";
				break;
			case "JOB_DECLINE":
				return SITEURL."seller/applied-jobs/view/".$prop_id."/";
				break;
			case "JOB_QUERY_ASK":
				return SITEURL."job/".$jid."/#queryMain";
				break;
			case "JOB_QUERY_REPLY":
				return SITEURL."job/".$jid."/#queryMain";
				break;
			case "JOB_INVOICE":
				return SITEURL."buyer/my-jobs/proposals/".$jid."/view/".$prop_id."/";
				break;
			case "JOB_PAYMENT_RELEASE":
				return SITEURL."seller/applied-jobs/view/".$prop_id."/";
				break;
			default:
				return "javascript:void(0);";
				break;
		}
	}
	public function rpGetServiceNotificationLink($ntype,$sid=0,$oid=0){
		$url = "javascript:void(0);";
		switch ($ntype) {
			case "SERVICE_PURCHASE":
				return SITEURL."seller/work-queue/".$oid."/view/";
				break;
			case "SERVICE_STATUS":
				return SITEURL."buyer/orders/".$oid."/view/";
				break;
			case "SERVICE_CONFIRM":
				return SITEURL."seller/work-queue/".$oid."/view/";
				break;
			default:
				return "javascript:void(0);";
				break;
		}
	}
	public function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
	
	public function rpgetProductQty($pid)
    {
		$proQty = $this->rpgetValue("product","qty","id='".$pid."'"); 
		return $proQty;
    }
    
	public function getStar($star,$is_for_admin="")
	{
		$rating = '';
       	for ($i=0; $i < 5; $i++) 
       	{ 
       		if($is_for_admin==1)
       		{
       			$checked = ($star>$i) ? 'la la-star' : 'la la-star-o';
       		}
       		else
       		{
       			$checked = ($star>$i) ? 'fa fa-star color' : 'fa fa-star-o';
       		}
   			$rating.= '<i class="'.$checked.'"></i>';
       	}

	    return $rating;

	}

	public function get_single_rating($pid)
    {
		$wh = "pid='".$pid."' AND isDelete=0 AND status='Y' ";
    	$rating_sum = $this->rpgetSumVal("product_review","pro_rating",$wh);

    	$rating_count = $this->rpgetTotalRecord("product_review",$wh);
    	if($rating_sum > 0) 
    	{
    		$star = $rating_sum / $rating_count;
    	} 
    	else 
    	{
    		$star = 0;
    	}
		?>
		<div class="product-rating">
			<?php
           	for ($i=0; $i < 5; $i++) 
           	{ 
           		$checked = ($star>$i) ? 'fa fa-star color' : 'fa fa-star';
       		?><i class="<?= $checked; ?>"></i>
       		<?php
           	}
           	?>
        </div>
		<?php
    }

	public function week_day_array()
    {
        $WEEK_DAY_ARRAY = array("1"=>"MONDAY","2"=>"TUESDAY","3"=>"WEDNESDAY","4"=>"THURSDAY","5"=>"FRIDAY","6"=>"SATURDAY","7"=>"SUNDAY");

        return $WEEK_DAY_ARRAY;
    }

    public function order_status_arr($order_status)
    {
        $ORDER_STATUS_ARRAY = array("0"=>"Cancelled","1"=>"In Progress", "2"=>"Completed", "3"=>"Shipped", "4"=>"Delivered","5"=>"Returned");

        return $ORDER_STATUS_ARRAY[$order_status];
    }

    public function order_status_with_label($order_status)
    {
    	$dis_label = '';
        if($order_status == 0)
        {
        	$dis_label = '<span class="kt-badge kt-badge--unified-danger kt-badge--lg kt-badge--inline kt-badge--rounded kt-badge--bold">Cancelled</span>';
        }
        else if($order_status == 1)
        {
        	$dis_label = '<span class="kt-badge kt-badge--unified-brand kt-badge--lg kt-badge--inline kt-badge--rounded kt-badge--bold">In Progress</span>';
        }
        else if($order_status == 2)
        {
        	$dis_label = '<span class="kt-badge kt-badge--unified-info kt-badge--lg kt-badge--inline kt-badge--rounded kt-badge--bold">Completed</span>';
        }
        else if($order_status == 3)
        {
        	$dis_label = '<span class="kt-badge kt-badge--unified-warning kt-badge--lg kt-badge--inline kt-badge--rounded kt-badge--bold">Shipped</span>';
        }
        else if($order_status == 4)
        {
        	$dis_label = '<span class="kt-badge kt-badge--unified-success kt-badge--lg kt-badge--inline kt-badge--rounded kt-badge--bold">Delivered</span>';
        }
        else if($order_status == 5)
        {
        	$dis_label = '<span class="kt-badge kt-badge--unified-primary kt-badge--lg kt-badge--inline kt-badge--rounded kt-badge--bold">Returned</span>';
        }

        return $dis_label;
    }

    public function proBadge($type)
    {
		$proBadge = '';
    	if($type == 1)
    	{
    		$proBadge = '<span class="status-span">Trending</span>';
    	}
    	else if($type == 2)
    	{
    		$proBadge = '<span class="status-span">New</span>';
    	}

    	return $proBadge;
    }

   //  public function checkIsDiscountProduct($pro_id,$cate_id,$sub_cate_id=0,$sub_sub_cate_id=0,$price)
   //  {
   //  	$curr_date = date("Y-m-d");
   //  	$discount_r = $this->rpgetData("discount","*","cate_id='".$cate_id."' AND start_date <= '".$curr_date."' AND expiration_date >= '".$curr_date."' AND isDelete=0");
   //  	$discount_c = @mysqli_num_rows($discount_r);

   //  	if($discount_c > 0)
   //  	{
   //  		$discount_d = @mysqli_fetch_array($discount_r);

   //  		$dis_desc 				= $discount_d['disc_desc'];
   //  		$dis_type 				= $discount_d['type'];
   //  		$dis_amount 			= $discount_d['amount'];
   //  		$dis_sub_cate_id 		= $discount_d['sub_cate_id'];
   //  		$dis_sub_sub_cate_id 	= $discount_d['sub_sub_cate_id'];


   //  		if($discount_d['type']=="flat")
	  //   	{
			// 	$discount_amt = $discount_d['amount'];
			// }
			// else
			// {
			// 	$discount_amt = $price*($discount_d['amount']/100);
			// }

   //  		if($dis_sub_cate_id!=0)
   //  		{
   //  			if($dis_sub_cate_id == $sub_cate_id)
   //  			{
   //  				if($dis_sub_sub_cate_id!=0)
   //  				{
	  //   				if($dis_sub_sub_cate_id == $sub_sub_cate_id)
		 //    			{
		 //    				$discount_data['discount_desc'] 	= $dis_desc;
		 //    				$discount_data['discount_type'] 	= $dis_type;
			//     			$discount_data['discount_amount'] 	= $dis_amount;
			//     			$discount_data['total_discount'] 	= $discount_amt;
			//     			$discount_data['is_discount_pro'] 	= 1;
		 //    			}
		 //    			else
		 //    			{
		 //    				$discount_data['discount_desc'] 	= "";
		 //    				$discount_data['discount_type'] 	= "";
			//     			$discount_data['discount_amount'] 	= 0;
			//     			$discount_data['total_discount'] 	= 0;
			//     			$discount_data['is_discount_pro'] 	= 0;
		 //    			}
		 //    		}
		 //    		else
		 //    		{
		 //    			$discount_data['discount_desc'] 	= $dis_desc;
		 //    			$discount_data['discount_type'] 	= $dis_type;
		 //    			$discount_data['discount_amount'] 	= $dis_amount;
		 //    			$discount_data['total_discount'] 	= $discount_amt;
		 //    			$discount_data['is_discount_pro'] 	= 1;
		 //    		}
   //  			}
   //  			else
   //  			{
   //  				$discount_data['discount_desc'] 	= "";
   //  				$discount_data['discount_type'] 	= "";
	  //   			$discount_data['discount_amount'] 	= 0;
	  //   			$discount_data['total_discount'] 	= 0;
	  //   			$discount_data['is_discount_pro'] 	= 0;
   //  			}
   //  		}
   //  		else
   //  		{
   //  			$discount_data['discount_desc'] 	= $dis_desc;
   //  			$discount_data['discount_type'] 	= $dis_type;
   //  			$discount_data['discount_amount'] 	= $dis_amount;
   //  			$discount_data['total_discount'] 	= $discount_amt;
   //  			$discount_data['is_discount_pro'] 	= 1;
   //  		}
   //  	}
   //  	else
   //  	{
   //  		$discount_data['discount_desc'] 	= "";
   //  		$discount_data['discount_type'] 	= "";
			// $discount_data['discount_amount'] 	= 0;
			// $discount_data['total_discount'] 	= 0;
			// $discount_data['is_discount_pro'] 	= 0;
   //  	}

   //  	return $discount_data;
   //  }

    public function checkIsDiscountProduct($pro_id,$cate_id,$sub_cate_id=0,$sub_sub_cate_id=0,$price)
    {
    	$curr_date = date("Y-m-d");

    	// $discount_r3 = $this->rpgetData("discount","*"," (cate_id='".$cate_id."' AND sub_cate_id='".$sub_cate_id."' AND sub_sub_cate_id='".$sub_sub_cate_id."') AND sub_cate_id!=0 AND sub_sub_cate_id!=0 AND start_date <= '".$curr_date."' AND expiration_date >= '".$curr_date."' AND isDelete=0 AND FIND_IN_SET('".$pro_id."','pid')>0 ","id DESC",0);
    	$discount_r3 = $this->rpgetData("discount","*"," (cate_id='".$cate_id."' AND sub_cate_id='".$sub_cate_id."' AND sub_sub_cate_id='".$sub_sub_cate_id."') AND start_date <= '".$curr_date."' AND expiration_date >= '".$curr_date."' AND isDelete=0 AND pid NOT LIKE '%".$pro_id."%' ","id DESC",0);
    	$discount_c3 = @mysqli_num_rows($discount_r3);

    	// $discount_r2 = $this->rpgetData("discount","*"," (cate_id='".$cate_id."' AND sub_cate_id='".$sub_cate_id."') AND sub_cate_id!=0 AND sub_sub_cate_id=0 AND start_date <= '".$curr_date."' AND expiration_date >= '".$curr_date."' AND isDelete=0 AND FIND_IN_SET('".$pro_id."','pid')>0 ","id DESC",0);
    	$discount_r2 = $this->rpgetData("discount","*"," (cate_id='".$cate_id."' AND sub_cate_id='".$sub_cate_id."') AND sub_cate_id!=0 AND sub_sub_cate_id=0 AND start_date <= '".$curr_date."' AND expiration_date >= '".$curr_date."' AND isDelete=0 AND pid NOT LIKE '%".$pro_id."%' ","id DESC",0);
    	$discount_c2 = @mysqli_num_rows($discount_r2);

    	// $discount_r = $this->rpgetData("discount","*","cate_id='".$cate_id."' AND sub_cate_id=0 AND sub_sub_cate_id=0 AND start_date <= '".$curr_date."' AND expiration_date >= '".$curr_date."' AND isDelete=0 AND FIND_IN_SET('".$pro_id."','pid')>0 ","id DESC",0);
    	$discount_r = $this->rpgetData("discount","*","cate_id='".$cate_id."' AND sub_cate_id=0 AND sub_sub_cate_id=0 AND start_date <= '".$curr_date."' AND expiration_date >= '".$curr_date."' AND isDelete=0 AND pid NOT LIKE '%".$pro_id."%' ","id DESC",0);
    	$discount_c = @mysqli_num_rows($discount_r);

    	// return $discount_r2;die;

    	if($discount_c3 > 0)
    	{
    		$discount_d = @mysqli_fetch_array($discount_r3);

    		$dis_desc 				= $discount_d['disc_desc'];
    		$dis_type 				= $discount_d['type'];
    		$dis_amount 			= $discount_d['amount'];
    		$dis_sub_cate_id 		= $discount_d['sub_cate_id'];
    		$dis_sub_sub_cate_id 	= $discount_d['sub_sub_cate_id'];


    		if($discount_d['type']=="flat")
	    	{
				$discount_amt = $discount_d['amount'];
			}
			else
			{
				$discount_amt = $price*($discount_d['amount']/100);
			}

    		if($dis_sub_cate_id!=0)
    		{
    			if($dis_sub_cate_id == $sub_cate_id)
    			{
    				if($dis_sub_sub_cate_id!=0)
    				{
	    				if($dis_sub_sub_cate_id == $sub_sub_cate_id)
		    			{
		    				$discount_data['discount_desc'] 	= $dis_desc;
		    				$discount_data['discount_type'] 	= $dis_type;
			    			$discount_data['discount_amount'] 	= $dis_amount;
			    			$discount_data['total_discount'] 	= $discount_amt;
			    			$discount_data['is_discount_pro'] 	= 1;
		    			}
		    			else
		    			{
		    				$discount_data['discount_desc'] 	= "";
		    				$discount_data['discount_type'] 	= "";
			    			$discount_data['discount_amount'] 	= 0;
			    			$discount_data['total_discount'] 	= 0;
			    			$discount_data['is_discount_pro'] 	= 0;
		    			}
		    		}
		    		else
		    		{
		    			$discount_data['discount_desc'] 	= $dis_desc;
		    			$discount_data['discount_type'] 	= $dis_type;
		    			$discount_data['discount_amount'] 	= $dis_amount;
		    			$discount_data['total_discount'] 	= $discount_amt;
		    			$discount_data['is_discount_pro'] 	= 1;
		    		}
    			}
    			else
    			{
    				$discount_data['discount_desc'] 	= "";
    				$discount_data['discount_type'] 	= "";
	    			$discount_data['discount_amount'] 	= 0;
	    			$discount_data['total_discount'] 	= 0;
	    			$discount_data['is_discount_pro'] 	= 0;
    			}
    		}
    		else
    		{
    			$discount_data['discount_desc'] 	= $dis_desc;
    			$discount_data['discount_type'] 	= $dis_type;
    			$discount_data['discount_amount'] 	= $dis_amount;
    			$discount_data['total_discount'] 	= $discount_amt;
    			$discount_data['is_discount_pro'] 	= 1;
    		}
    		return $discount_data;
    		die;
    	}
    	else if($discount_c2 > 0)
    	{
    		$discount_d = @mysqli_fetch_array($discount_r2);

    		$dis_desc 				= $discount_d['disc_desc'];
    		$dis_type 				= $discount_d['type'];
    		$dis_amount 			= $discount_d['amount'];
    		$dis_sub_cate_id 		= $discount_d['sub_cate_id'];
    		$dis_sub_sub_cate_id 	= $discount_d['sub_sub_cate_id'];


    		if($discount_d['type']=="flat")
	    	{
				$discount_amt = $discount_d['amount'];
			}
			else
			{
				$discount_amt = $price*($discount_d['amount']/100);
			}

    		if($dis_sub_cate_id!=0)
    		{
    			if($dis_sub_cate_id == $sub_cate_id)
    			{
    				if($dis_sub_sub_cate_id!=0)
    				{
	    				if($dis_sub_sub_cate_id == $sub_sub_cate_id)
		    			{
		    				$discount_data['discount_desc'] 	= $dis_desc;
		    				$discount_data['discount_type'] 	= $dis_type;
			    			$discount_data['discount_amount'] 	= $dis_amount;
			    			$discount_data['total_discount'] 	= $discount_amt;
			    			$discount_data['is_discount_pro'] 	= 1;
		    			}
		    			else
		    			{
		    				$discount_data['discount_desc'] 	= "";
		    				$discount_data['discount_type'] 	= "";
			    			$discount_data['discount_amount'] 	= 0;
			    			$discount_data['total_discount'] 	= 0;
			    			$discount_data['is_discount_pro'] 	= 0;
		    			}
		    		}
		    		else
		    		{
		    			$discount_data['discount_desc'] 	= $dis_desc;
		    			$discount_data['discount_type'] 	= $dis_type;
		    			$discount_data['discount_amount'] 	= $dis_amount;
		    			$discount_data['total_discount'] 	= $discount_amt;
		    			$discount_data['is_discount_pro'] 	= 1;
		    		}
    			}
    			else
    			{
    				$discount_data['discount_desc'] 	= "";
    				$discount_data['discount_type'] 	= "";
	    			$discount_data['discount_amount'] 	= 0;
	    			$discount_data['total_discount'] 	= 0;
	    			$discount_data['is_discount_pro'] 	= 0;
    			}
    		}
    		else
    		{
    			$discount_data['discount_desc'] 	= $dis_desc;
    			$discount_data['discount_type'] 	= $dis_type;
    			$discount_data['discount_amount'] 	= $dis_amount;
    			$discount_data['total_discount'] 	= $discount_amt;
    			$discount_data['is_discount_pro'] 	= 1;
    		}
    		return $discount_data;
    		die;
    	}
    	else if($discount_c > 0)
    	{
    		$discount_d = @mysqli_fetch_array($discount_r);

    		$dis_desc 				= $discount_d['disc_desc'];
    		$dis_type 				= $discount_d['type'];
    		$dis_amount 			= $discount_d['amount'];
    		$dis_sub_cate_id 		= $discount_d['sub_cate_id'];
    		$dis_sub_sub_cate_id 	= $discount_d['sub_sub_cate_id'];


    		if($discount_d['type']=="flat")
	    	{
				$discount_amt = $discount_d['amount'];
			}
			else
			{
				$discount_amt = $price*($discount_d['amount']/100);
			}

    		if($dis_sub_cate_id!=0)
    		{
    			if($dis_sub_cate_id == $sub_cate_id)
    			{
    				if($dis_sub_sub_cate_id!=0)
    				{
	    				if($dis_sub_sub_cate_id == $sub_sub_cate_id)
		    			{
		    				$discount_data['discount_desc'] 	= $dis_desc;
		    				$discount_data['discount_type'] 	= $dis_type;
			    			$discount_data['discount_amount'] 	= $dis_amount;
			    			$discount_data['total_discount'] 	= $discount_amt;
			    			$discount_data['is_discount_pro'] 	= 1;
		    			}
		    			else
		    			{
		    				$discount_data['discount_desc'] 	= "";
		    				$discount_data['discount_type'] 	= "";
			    			$discount_data['discount_amount'] 	= 0;
			    			$discount_data['total_discount'] 	= 0;
			    			$discount_data['is_discount_pro'] 	= 0;
		    			}
		    		}
		    		else
		    		{
		    			$discount_data['discount_desc'] 	= $dis_desc;
		    			$discount_data['discount_type'] 	= $dis_type;
		    			$discount_data['discount_amount'] 	= $dis_amount;
		    			$discount_data['total_discount'] 	= $discount_amt;
		    			$discount_data['is_discount_pro'] 	= 1;
		    		}
    			}
    			else
    			{
    				$discount_data['discount_desc'] 	= "";
    				$discount_data['discount_type'] 	= "";
	    			$discount_data['discount_amount'] 	= 0;
	    			$discount_data['total_discount'] 	= 0;
	    			$discount_data['is_discount_pro'] 	= 0;
    			}
    		}
    		else
    		{
    			$discount_data['discount_desc'] 	= $dis_desc;
    			$discount_data['discount_type'] 	= $dis_type;
    			$discount_data['discount_amount'] 	= $dis_amount;
    			$discount_data['total_discount'] 	= $discount_amt;
    			$discount_data['is_discount_pro'] 	= 1;
    		}

    		return $discount_data;
    		die;
    	}
    	else
    	{
    		$discount_data['discount_desc'] 	= "";
    		$discount_data['discount_type'] 	= "";
			$discount_data['discount_amount'] 	= 0;
			$discount_data['total_discount'] 	= 0;
			$discount_data['is_discount_pro'] 	= 0;

			return $discount_data;
			die;
    	}

    	// return $discount_data;
    }


    public function calculate_distance($destination_zip)
	{
	    $origin         = SITE_ZIPCODE;
	    $destination    = $destination_zip;

	    $api = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=".$origin."&destinations=".$destination."&key=".GOOGLE_API_KEY);
	   // $api = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=".$origin."&destinations=".$destination."&mode=bicycling&sensor=false");
	    
	    $data = json_decode($api);
	    echo "<pre>";
        print_r($data);exit;
	    $distance_mile = $data->rows[0]->elements[0]->distance->text;
	    $distance  =  explode(" ", $distance_mile);
	    echo "<pre>";
        print_r($distance);exit;
        if($distance[1]=='ft'){
            $cal_dist  = ($distance[0]/5280);
        }else{
           $cal_dist  = $distance[0]; 
        }
        //$distance[0]=5;
        //$cal_dist = 8;
        
	    $where_cal    = " ".$distance[0]." BETWEEN from_mile AND to_mile AND above_mile=0 AND isDelete=0";
	    $distance_r   = $this->rpgetData("shipping_charges","*",$where_cal,"");
	    $distance_d   = @mysqli_fetch_array($distance_r);
	    $distance_c   = @mysqli_num_rows($distance_r);

	    if ($distance_c>0) {
	        	$shipping_charges['distance'] 			= $cal_dist;
	        	$shipping_charges['shipping_charges'] 	= $distance_d['amount'];
	        	$shipping_charges['shipping_id'] 		= $distance_d['id'];
	        	$shipping_charges['msg'] 				= "success";
	    }else{
	    	$where    	  		= " from_mile >= ".$distance[0]."  AND above_mile=1 AND isDelete=0";
		    $distance_above_r   = $this->rpgetData("shipping_charges","*",$where,"");
		    $distance_above_d   = @mysqli_fetch_array($distance_above_r);
		    $distance_above_c   = @mysqli_num_rows($distance_above_r);

		    if ($distance_above_c>0) {
		    	$shipping_charges['distance'] 			= $cal_dist;
	        	$shipping_charges['shipping_charges'] 	= "0";
	        	$shipping_charges['shipping_id'] 		= $distance_above_d['id'];
	        	$shipping_charges['msg'] 				= "call_admin";
		    }else{
		    	$shipping_charges['distance'] 			= $cal_dist;
	        	$shipping_charges['shipping_charges'] 	= "0";
	        	$shipping_charges['shipping_id'] 		= "0";
	        	$shipping_charges['msg'] 				= "call_admin";
		    }

	    }

	    return $shipping_charges;
	}
/*	public function getLnt($zip){
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=
        ".urlencode($zip)."&sensor=false&key=".GOOGLE_API_KEY;
        $result_string = file_get_contents($url);
        $result = json_decode($result_string, true);
        print_r($result);
        $result1[]=$result['results'][0];
        $result2[]=$result1[0]['geometry'];
        $result3[]=$result2[0]['location'];
        return $result3[0];
    }
	public function calculate_distance($destination_zip){
        $first_lat = $this->getLnt(SITE_ZIPCODE);
        $next_lat = $this->getLnt($destination_zip);
        $lat1 = $first_lat['lat'];
        $lon1 = $first_lat['lng'];
        $lat2 = $next_lat['lat'];
        $lon2 = $next_lat['lng']; 
            $theta=$lon1-$lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
        echo "miles".$miles;exit;
        if ($unit == "K"){
        return ($miles * 1.609344)." ".$unit;
        }
        else if ($unit =="N"){
        return ($miles * 0.8684)." ".$unit;
        }
        else{
        return $miles." ".$unit;
        }
            
	}*/
}
include("admin.class.php");
include("cart.class.php");
?>