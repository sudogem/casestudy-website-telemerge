<?php
$page = getmenuclick($_GET['menuclick']);
?>
<div id= "menu" >
  <ul id="nav" >
    <li ><a href="list.php?menuclick=1"  <?php echo ( $page == '1' ) ? ' class="current" ' : '' ; ?> >List of all Voice Files</a></li>
    <li><a href="new.php?menuclick=2"  <?php echo ( $page == '2' ) ? ' class="current" ' : '' ; ?> >Upload New Voice File</a></li>
    <li><a href="editprofile.php?menuclick=3"  <?php echo ( $page == '3' ) ? ' class="current" ' : '' ; ?> >Edit Profile</a></li>
  </ul>
</div> 
