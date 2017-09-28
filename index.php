<?php
require_once (__DIR__ . '/config/conf.php' );
require_once (__DIR__ . '/config/constants.php' );
require_once (__DIR__ . '/sysfunctions/sysfunc.php' );
require_once (__DIR__ . '/http/class.sessions.php' );
require_once (__DIR__ . '/libraries/class.database.php' );
require_once (__DIR__ . '/libraries/class.client_testimonials.php' );
require_once (__DIR__ . '/libraries/class.useraccount.php' );
require_once (__DIR__ . '/libraries/class.articles.php' );
$session = new sessions();
$db = new database ( $conf['dbhost'] , $conf['dbusername'] , $conf['dbpassword'] , $conf['dbdatabasename'] );
print_r('<br><br>db: ');
print_r($db);
$testi = new clientTestimonials;
$account = new userAccount;
$newsarticles = new NewsArticles ;
$client_testi = $testi->getPublishedClientTestimonials( 1 );
//echo count($result)-1;
// print_r($result);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>Telemerge Corporation - an affordable medical transcription company in Philippines</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="designer+developer" content="Arman Ortega :: arman.ortega{at}yahoo{dot}com" />
<meta name="robots" content="index , follow"  />
<meta name="revisit-after" content="7 days"  />
<meta name="description" content="Telemerge is a medical transcription company catering the increasing demand for accurate and effective data gathering and storage.The company is owned and operated by Telemerge Company Inc. A very young and promising corporation composed of tested and successful businessman in Cebu."  />
<meta name="keywords" content="cebu medical transcription  affordable medical transcription  philippine medical transcription  affordable medical transcription in cebu  transcriptionists  outsource medical transcription "  />
<link rel="stylesheet" href="css/style.css" media="screen" type="text/css"  />
<script type="text/javascript" src="js/scripts.js" language="javascript" ></script>
<script type="text/javascript" src="js/footer.js" language="javascript" ></script>
</head>
<body>
<div id= "container" >
  <div id="header"><span>Telemerge Transcription - afforadable medical transcription in Philippines</span></div>
  <div id="slogan" >Telemerge Leading the World of Transcription...</div>
  <ul id="topnav">
    <li><a href="job.php" >Job Opportunities</a> </li>
    <li><a href="clienttestimonial.php" >Client Testimonials</a></li>
  </ul>
  <div class="clear"></div>
  <ul id="nav" >
    <li><a href="index.php" id="cmdhome" class="cmddefault" >Home</a></li>
    <li><a href="aboutus.php" id="cmdabout" >About Us</a></li>
    <li><a href="hipaa.php" id="cmdhipaa" >HIPAA</a></li>
    <li><a href="freetrial.php" id="cmdfreetrial" >Free Trial</a></li>
    <li><a href="contactus.php" id="cmdcontact"  >Contact Us</a></li>
    <li><a href="what_is_medical_transcription.php" id="cmdmt" >Medical Transcription</a></li>
    <li><a href="request_info.php" id="cmdrequest" >Request Info</a></li>
  </ul>
  <div class="clear" ></div>
    <div id="welcome" >
    <h1><span>Welcome to Telemerge</span></h1>
    <img src="images/mt-pic002.jpg" class="imageleft"  />
    <p>Telemerge is&nbsp;medical transcription company located at the  IT hub in Asia-Cebu.&nbsp; We are operating 24  hours a day, 7 days a week catering all kinds of medical transcription jobs with  the least offering price in town charging as low as 12 cents per line with 98%  accuracy.&nbsp; With machineries and personnel  that we employed, we guarantee quality of service and security of data to our  clients.</p>
    <p class="text" >&nbsp;</p>
  </div>
  <div class="clear" >&nbsp;</div>
  <div id="company-services" align="center"  >
    <a href="freetrial.php" ><div class="bigbtn-freetrial"  style="margin-left:30px ; float:left ; " ></div></a>
    <a href="signup.php" ><div class="bigbtn-register"  style="margin-right:30px ; float:right ;"></div></a>  </div>
<div class="clear" >&nbsp;</div>
<div id="extra" >
      <h1><span>Medical Transcription Services</span></h1>
   <div id="extrabox" >
  <h2 class="cap1">We Transcribe :</h2>
  <ul class="commonlist-items02">
    <li>History of the Patient</li>
    <li>Operative and Procedure Notes</li>
    <li>Discharge Summary</li>
    <li>Progress Report</li>
    <li>Chart notes</li>
    <li>Consultation Report</li>
    <li>Rehabilitation Report</li>
    <li>Emergency Notes ... and many others alike</li>
  </ul>
  </div>
</div>
<div id="login" >
      <h1><span>Login</span></h1>
      <div id="loginbox" >
<?php
if ($session->getAttribute( 'login_error' ) )
{
  echo "<div class='invalid_pw'>" . $session->getAttribute( 'login_error' ) . "</div>";
  $session->removeAttribute( 'login_error' );
}
?>
        <form method="post" action="systempanel/do-login.php" >
          <label for="username">Member's Login ID  : </label>
          <input type="text" name="username" class="inputfield" size="22" maxlength="15" />
          <br />
          <label for="password">Password :</label>
          <input type="password" name="password"  class="inputfield passwordchar" size="22" maxlength="15"  />
          <br />
          <p class="submit" >
            <input type="submit" name="submit" id="submit" value="Login &raquo;" style="margin-top:2px; margin-left: 0px;  "  />
          </p>
        </form>
      </div>
  <div id="notregister" >
      <p>Not registered yet ? <span class="sign-up" ><a href="signup.php" >Sign-up </a></span>now !</p>
      <p><span class="sign-up" ><a href="javascript:popupWindow('lostpassword.php','mh', 430,190)" >Lost your password ?</a></span></p>
  </div>
</div>
<div class="clear" >&nbsp;</div>
<div class="commonlist-items" id="advantages" >
  <h1 class="cap2"><span>Advantages:</span></h1>
  <div id="advantagesbox" >
  <h2 class="cap4">Manpower</h2>
    <ul>
    <li>High Qualified Staff</li>
    <li>Continuous Personnel Development Programs</li>
    </ul>
  <h2 class="cap4">Technical</h2>
    <ul>
    <li>24/7 Technical Support</li>
    <li>High end Infrastructure</li>
    </ul>
  <h2 class="cap4">Data Security</h2>
    <ul>
    <li>Tight Confidentiality</li>
    <li>High regard to Security</li>
    </ul>
    <div id="rightblocks"  class="commonlist-items">
      <h2 class="cap4">Price </h2>
        <ul>
        <li>Minimal Charging</li>
        <li>Per line basis charging</li>
        </ul>
      <h2 class="cap4">Legal</h2>
        <ul>
        <li>Compliance to standards</li>
        <li>Certification</li>
        <li>Service network</li>
        </ul>
    </div>
  </div>
</div>
<div class="clear" ></div>
<div id="news" >
    <h1><span>News and Events</span></h1>
    <div id="newsbox" >
<?php
$publishednews = $newsarticles->getAllPublishedArticles(2);
//print_r($publishednews);
  $n = count( $publishednews );
  for($i=0 ; $i < $n ; $i++ )
  {
    $newsid =  $publishednews[$i]->newsID ;
    $datecreated = $publishednews[$i]->datecreated ;
    $day = date( "d" , $datecreated );
    $month = date( "M" ,  $datecreated );
    $year = date( "Y" ,  $datecreated );
    $newstitle = $publishednews[$i]->newstitle ;
    $newsbody =  $publishednews[$i]->body ;
?>
<div class="newsinfo"><span class="day"><?php echo $day ;?></span> <span class="month"><?php echo $month ; ?></span> <span class="year"><?php echo $year ; ?></span> </div>
<p class="text" ><strong><?php echo $newstitle ; ?></strong><br>
<?php echo makeAShortSummary( $newsbody ); ?>
<span style="float:right"><a href="viewnews.php?newsid=<?php echo $newsid ; ?>" class="readmore" >Read More . . .</a></span></p>
<div class="clear"></div>
<?php } ?>
</div>
</div>
<div id="testimonials" >
    <h1><span>Client Testimonials</span></h1>
    <div id="testimonialsbox" >
    <?php
    $n = count($client_testi);
    for( $i=0 ; $i<$n; $i++ )
    {
    ?>
<p class="text" ><?php echo makeAShortSummary( $client_testi[$i]->message ) ; ?></p><br />
<span class="testi-owner" >- <?php  $name = $account->getUserAccountById( $client_testi[$i]->userID ) ;  echo $name[0]->fullname . ", " . "CEO" . "/"  . $name[0]->company ; ?> </span>
<div class= "linerule" ></div>
    <?php
    }
    ?>
    <a href="clienttestimonial.php" class="link01" >More client testimonial here &raquo;</a>
    </div>
</div>
</div>
<div class="clear"></div>
  <!-- begin foote -->
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
    <ul id="footnav" >
      <li><a href="terms.php">Terms of Use</a>&nbsp;|&nbsp;</li>
      <li><a href="privacy-policy.php">Privacy Policy</a>&nbsp;|&nbsp;</li>
      <li><a href="contactus.php">Contact Us</a>&nbsp;|&nbsp;</li>
      <li><a href="sitemap.php">Sitemap</a>&nbsp;|&nbsp;</li>
    </ul>
    <div id="copyright" >
      <h1>Copyright &copy; 2006. Telemerge Corporation. All Rights Reserved.</h1>
    </div>
  <div id="cssvalid" >
  Valid CSS XHTML
  </div>
  </div>
</div>
  <!-- end foote -->
</body>
</html>