<?php

session_start();
unset($_SESSION['user_id']);
unset($_SESSION['ip']);
session_destroy();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Выход из Личного Кабинета</title>
        <meta http-equiv="Content-Style-Type" content="text/css">
        <link href="lkstyle.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript"> <!--
            function exec_refresh(){
                window.status = "Переадресация..." + myvar;
                myvar = myvar + " .";
                var timerID = setTimeout("exec_refresh();", 100);
                if (timeout > 0){
                    timeout -= 1;
                }else{
                    clearTimeout(timerID);
                    window.status = "";
                    window.location = "index.php";
                }
            }
            var myvar = "";
            var timeout = 10;
            exec_refresh();
            //--> </script>
    </head>
    <body>
        <br>
        <div align="center">
            <table width="100%" height="30" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="50%" align="center" valign="center" class="MyLogout">Logout Completed.</td>
                </tr>
            </table></div>