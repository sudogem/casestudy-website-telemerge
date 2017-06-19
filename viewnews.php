<?php 
require_once ( 'libraries/class.database.php' );
require_once ( 'libraries/class.articles.php' );

require_once ( 'config/conf.php' );
require_once ( 'config/constants.php' );

$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );
$news_article = new NewsArticles ;

$newsid = intval( $_GET['newsid'] );   
$newsdata = $news_article->getArticleByID( $newsid );

$allnews = $news_article->getAllPublishedArticles( );
// print_r( $newsdata );
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><!-- InstanceBegin template="/Templates/index.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="developer+designer" content="Arman Ortega :: arman.ortega{att}yahoo{dot}com" />
<meta name="robots" content="index , follow"  />
<meta name="revisit-after" content="7 days"  />
<meta name="description" content="Telemerge is a medical transcription company catering the increasing demand for accurate and effective data gathering and storage.The company is owned and operated by Telemerge Company Inc. A very young and promising corporation composed of tested and successful businessman in Cebu."  />
<meta name="keywords" content="cebu medical transcription , medical transcription company , affordable medical transcription ,  philippine medical transcription , affordable medical transcription in cebu , transcriptionists , outsource medical transcription "  />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Telemerge Corporation</title>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="css/style.css" media="screen" type="text/css"  />
<script type="text/javascript" src="js/footer.js" language="javascript" ></script>
<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
</head>

<body>
<div id= "container" >
  <div id="header"><span>Logo</span></div>
  <div id="slogan" >Telemerge Leading the World of Transcription...</div>
  <!-- InstanceBeginEditable name="topnav" -->
  <ul id="topnav">
    <li><a href="job.php">Job Opportunities</a> </li>
    <li><a href="clienttestimonial.php">Client Testimonials</a></li>
  </ul>
  <div class="clear"></div>
  
  <!-- InstanceEndEditable --><!-- InstanceBeginEditable name="nav" -->
  <ul id="nav" >
    <li><a href="index.php" id="cmdhome" >Home</a></li>
    <li><a href="aboutus.php" id="cmdabout" >About Us</a></li>
    <li><a href="hipaa.php" id="cmdhipaa"  >HIPAA</a></li>
    <li><a href="freetrial.php" id="cmdfreetrial" >Free Trial</a></li>
    <li><a href="contactus.php" id="cmdcontact" >Contact Us</a></li>
    <li><a href="what_is_medical_transcription.php" id="cmdmt" >Medical Transcription</a></li>
    <li><a href="request_info.php" id="cmdrequest" >Request Info</a></li>
  </ul>
  <!-- InstanceEndEditable -->
  <div class="clear" ></div>
  <!-- InstanceBeginEditable name="front-content" -->
  <!--<div id="column1" >
	<p class="text">Sed ut perspiciatis unde o mnis iste natus error sit voluptatem accusantium doloremque laudantium, totam re m aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspern atur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione volupta tem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor s it amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora i ncidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel</p>  
  </div>
   <div id="column2" >
  	<div id="welcome" >
		<p class="text" >"Sed ut perspiciatis unde o    mnis iste natus error sit voluptatem accusantium     doloremque laudantium, totam    rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae   	vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspern	atur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione volupta	tem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor s	it amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora i	ncidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel </p>
	</div>
  </div>-->
<div class="viewnews-details" >         
<h1 class="news-title" ><?php echo $newsdata[0]->newstitle ; ?></h1>
<h1 class="posted-by" ><?php echo date("M d Y", $newsdata[0]->datecreated)?> , Posted by :<?php echo $newsdata[0]->submittedby; ?> </h1>
<p class="text" >
	<?php echo $newsdata[0]->body ;?>
</p>
</div>	  
  
<div class="other-news" >
<h1>Other News and Events</h1>
	<ul class="news-listings" >
	<?php 
	$n = count ( $allnews );
	for( $i=0 ; $i<$n ; $i++ )
	{
	?>
		<li><a href="viewnews.php?newsid=<?php echo $allnews[$i]->newsID;?>"><?php echo $allnews[$i]->newstitle; ?></a></li>				
	<?php
	}
	?>	
	</ul>
</div>
  <!-- InstanceEndEditable -->
  
	<div class="clear" ></div>
	
</div>
	<div id="footer" >
		<div id="wrapper" >
			<div id="contact-info" class="left" >
				<h1><b>Contact :</b></h1>
				<h1>John Doe </h1>
				<h1>CEO, Telemerge Corporation </h1>
				<h1>Cebu  Philippines 6000</h1>				
				<h1>Email: johndoe@telemerge.com</h1>		
				<h1>Contact No: 1800-1234-5678</h1>
			</div>
			
				<!-- InstanceBeginEditable name="footnav" -->
				<ul id="footnav" >
				  <li><a href="terms.php">Terms of Use</a>&nbsp;|&nbsp;</li>
				  <li><a href="privacy-policy.php">Privacy Policy</a>&nbsp;|&nbsp;</li>
				  <li><a href="contactus.php">Contact Us</a>&nbsp;|&nbsp;</li>
				  <li><a href="sitemap.php">Sitemap</a>&nbsp;|&nbsp;</li>
			    </ul>
				<!-- InstanceEndEditable -->
				<div id="copyright" >
					<h1>Copyright &copy; 2006. Telemerge Corporation. All Rights Reserved.</h1>
				</div>
		</div>
	</div>	

</body>
<!-- InstanceEnd --></html>
