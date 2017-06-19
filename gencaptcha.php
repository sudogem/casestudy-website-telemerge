<?php
session_start();

include('libraries/class.captcha_numbers.php');
$captcha = new CaptchaNumbers(7);
$captcha->display();

$_SESSION['captcha'] = $captcha->getString();
?>