<?php
require_once ( '../config/conf.php' );
require_once ( '../libraries/class.client_testimonials.php' );
$testimonial = new clientTestimonials();
// $page = getcurrent_page();
$page = getmenuclick($_GET['menuclick']);
$xx = $testimonial->recentTestimonialSubmitted();
$numtesti = count( $xx );
?>
<div id="menu" >
<ul id="nav" >
  <li><a href="list.php?menuclick=1" <?php echo ( $page == '1' ) ? ' class="current" ' : '' ; ?> >List of all Voice Files</a></li>
  <li><a href="new.php?menuclick=2" <?php echo ( $page == '2' ) ? ' class="current" ' : '' ;?> > Upload New Voice File</a></li>
  <li><a href="usermanager.php?menuclick=3" <?php echo ( $page == '3' ) ? ' class="current" ' : '' ;?> >User Manager</a></li>
  <li><a href="newsmanager.php?menuclick=4" <?php echo ( $page == '4' ) ? ' class="current" ' : '' ;?> >List of all News/Events </a></li>   
  <li><a href="newsmanager_add.php?menuclick=5" <?php echo ( $page == '5' ) ? ' class="current" ' : '' ;?> >Add New News/Events </a></li>     
  <li><a href="testimonialmanager.php?menuclick=6"  <?php echo ( $page == '6' ) ? ' class="current" ' : '' ;?>  >List of all Client Testimonials <br /><?php  echo ($numtesti) . ' unread testimonial(s)' ; ?></a></li>
  <li><a href="resumemanager.php?menuclick=7"  <?php echo ( $page == '7' ) ? ' class="current" ' : '' ;?>  >List of all Resume</a></li>
</ul>
</div>
