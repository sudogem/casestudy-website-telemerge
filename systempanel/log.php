<?php
require_once( '../http/class.sessions.php' );
$session = new sessions ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=shift_jis" />
<title>Login</title>
<link rel="stylesheet" href="../css/admin2.css" media="screen"  />
</head>

<body class="blogin" >
	<div id="login" >
		<!--<img src="../images/logo_03.jpg"  class="imageleft"  style="margin-left: 100px ; margin-bottom:10px;"  />-->
		<br />
		<?php
		if (  $session->getAttribute( 'login_error' ) != NULL ) {
		?>
		<h1 class="invalidpw" ><?php echo $session->getAttribute( 'login_error' ) ; $session->removeAttribute( 'login_error' ) ; ?></h1>
		<?php
		}
		?>
		<form name="login" method="post" action="do-login.php" >
			<label for="username" >Username :</label>
			<input name="username" class="clogin"  /><br />
			<label for="password" >Password :</label>
			<input name="password" class="clogin"  /><br />
			<p class="submit" ><input type="submit" name="submit" value="Submit&nbsp;&gt;&gt;&gt;" style="  margin-left:135px;"  /> </p>
		</form>
	</div>
</body>
</html>
