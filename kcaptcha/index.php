<?php
session_start();
error_reporting (E_ALL);
include('kcaptcha.php');
$captcha = new KCAPTCHA();
if($_REQUEST[session_name()]){$_SESSION['captcha_keystring'] = $captcha->getKeyString();}
?>