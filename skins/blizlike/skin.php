<?php
$ModulesView = 1;
$RulesView = 1;
$LinkView = 3;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $code_page; ?>" />
        <meta http-equiv="Content-Style-Type" content="text/css"/>
        <LINK href="<?php echo $cssfile; ?>" type="text/css" rel="stylesheet"/>
        <style type="text/css">
            <!--
            .style1 {
                font-size: 28px;
                font-weight: bold;
                color: #CCCCCC;
            }
            -->
        </style>
    </head>
    <body>
        <div align="center">
            <table width="1012" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="45" valign="bottom" align="left" width="50%">&nbsp;<span class="style1">WORLD OF WARCRAFT</span></td>
                    <td valign="bottom" align="right" width="50%"><?php require "rules.php"; ?>&nbsp;&nbsp;<?php require "menu.php"; ?>&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td height="15" colspan="2" class="content-top">&nbsp;</td>
                </tr>
            </table>
            <table width="1014" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td background="<?php echo $skindir; ?>content-bg.png">
                        <table width="1014" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="15">&nbsp;</td>
                                <td width="984" height="576" background="<?php echo $skindir; ?>allbg.jpg" align="center" valign="top" ><table width="984" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td height="500" class="ConTop" align="center" valign="top">
                                                <table width="984" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td width="22">&nbsp;</td>
                                                        <td height="90" align="center" valign="middle"><?php require "links.php"; ?></td>
                                                        <td width="22">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td width="22">&nbsp;</td>
                                                        <td height="430" align="center" valign="top" background="<?php echo $skindir; ?>bglich.jpg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td class="ConLich" height="430" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr><td width="5">&nbsp;</td>
                                                                                <td width="220" align="center" valign="top"><br/><?php require "panel.php"; ?></td>
                                                                                <td width="9">&nbsp;</td>
                                                                                <td width="800" align="center" valign="top"><br/><br/><?php require "mainform.php"; ?></td><td width="5">&nbsp;</td>
                                                                            </tr>
                                                                        </table>
                                                                        &nbsp;</td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td width="22">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3" height="5"></td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="76" background="<?php echo $skindir; ?>footer-tile.gif" align="center" valign="middle">
                                                <?php require "toolbar.php"; ?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="15">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>
            <table width="1012" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="EndCon">&nbsp;</td>
                </tr>
            </table>

        </div>
    </body>
</html>
