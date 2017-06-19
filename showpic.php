<?php
  header("Content-type: text/html");
  header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
  header("Cache-Control: no-store, no-cache,
          must-revalidate");
  header("Cache-Control: post-check=0, pre-check=0",
          false);
  header("Pragma: no-cache");
  $pic = strip_tags( $_GET['pic'] );
  if ( ! $pic ) {
    die("No picture specified.");
  }
?>
Hey! that's mine. <img src="/<?php echo($pic); ?>" alt="Image">