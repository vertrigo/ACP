<?php

if ($mail_method == 'test')
    {
    echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td height="25" align="center" valign="middle" class="ErrTitle">
       <b>' . $mail_subject . '</b></td></tr>
<tr><td height="45" align="center" valign="middle"  class="ErrTab"><br>' . $mail_body . '<br><br><hr><br>' . $mail_body2 . '<br><br></td></tr>
</table><br /><br /><div align="center"><A href="index.php"><?php echo $txt[12]; ?></a></div>';
    } else
    {
    // отсылка по почте
    if (isset($mail_event) AND ($mail_event == 'standart'))
        $mail_message = '<html><head><title>mail robot message</title>
<style type="text/css">
<!--
td.TableTitle {
background-color:#BCBCDE;
color:#000000;
font-family:Tahoma, Arial, Helvetica, sans-serif;
font-size:9px;
} 
a {
font-family:Tahoma, Arial, Helvetica, sans-serif;
font-size:9px;
}
td.TableLeft {
	background-color:#E9FFE1;
	border:#333333;
	border-left-style: solid;
	border-bottom-style: solid;
	border-bottom-width: 1px;
	border-left-width: 1px;
}
td.TableRight {
	background-color:#E9FFE1;
	border:#333333;
	border-right-style: solid;
	border-bottom-style: solid;
	border-bottom-width: 1px;
	border-right-width: 1px;
}
td.TableCenter {
	background-color:#E9FFE1;
	border:#333333;
	border-bottom-style: solid;
	border-bottom-width: 1px;
}
-->
</style>
</head>
<body>
<div align="center">
<table width="420" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25" colspan="3" align="center" valign="middle" class="TableTitle">' . $mail_subject . '</td>
  </tr>
    <tr><td width="10" class="TableLeft">&nbsp;</td>
      <td width="400" align="justify" valign="middle" class="TableCenter"><br>' . $mail_body . '<br><br></td>
    <td width="10" class="TableRight" >&nbsp;</td></tr>
    <tr><td class="TableLeft">&nbsp;</td>
      <td width="400" align="justify" valign="middle" class="TableCenter"><br>' . $mail_body2 . '<br><br></td>
    <td class="TableRight">&nbsp;</td></tr>
</table></div>
</body>
</html>
';
    include ("include/class.phpmailer.php");   // путь к файлу class.phpmailer.php
    $mail = new PHPMailer();                     // активируем класс

    if ($encoding == 'cp1251')
        $mail->Is1251();          // выбор кодировки
    else
        $mail->IsUTF8();

    switch ($mail_method)
        {                           // выбор метода отправки
        case 'mail':
            $mail->IsMAIL();                              // через php 
            break;
        case 'smtp':
            $mail->IsSMTP();                              // smtp
            $mail->Host = $mail_smtp_Host;   // SMTP сервер
            $mail->SMTPAuth = true;        // включить SMTP аутентификацию
            $mail->Username = $mail_smtp_Username;    // пропишите Ваш почтовый адрес
            $mail->Password = $mail_smtp_Password;   // введите пароль на указанный ящик
            break;
        case 'sendmail':
            $mail->IsSENDMAIL();                          // sendmail
            break;
        }
    $mail->From = $mail_from;                   // укажите от кого письмо
    $mail->FromName = $mail_from_name;              // имя отправителя
    $mail->AddAddress($post_mail, "WoW User");       // е-маил кому отправлять и на какое имя
    $mail->AddReplyTo($mail_from, $mail_from_name);  // е-маил и имя на который пойдет ответ на Ваше письмо
    $mail->WordWrap = 50;                           // set word wrap
    $mail->IsHTML(true);                            // отправить в HTML формате 
    $mail->Subject = $mail_subject;               // тема письма
    $mail->Body = $mail_message;               // тело письма в html формате
    if (!$mail->Send())
        {
        echo '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td height="25" align="center" valign="middle" class="ErrTitle"><b>'
        . $txt[64] . '</b></td></tr><tr><td height="45" align="center" valign="middle"  class="ErrTab"><b>' . $txt[65] . ' - '
        . $mail->ErrorInfo . '</b><br>' . $txt[119] . '</td></tr></table><br>';
        } else
        {
        echo '<div align="center>"><img src="images/mail1.png"><br><br>';
        echo $txt[63] . '<br></div><br><br>';
        }
    }
?> 