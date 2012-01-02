<?php
$ModulesView = 1;
$RulesView = 1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $code_page; ?>" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <LINK href="<?php echo $cssfile; ?>" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div align="center">
            <table width="1210" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="18" height="24" background="<?php echo $skindir; ?>tl.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td colspan="2" height="24" align="left" valign="bottom" background="<?php echo $skindir; ?>tm.jpg" bgcolor="#FFFFFF">
                        <img src="<?php echo $skindir; ?>t1.jpg" width="649" height="24" /></td>
                    <td width="22" height="24" background="<?php echo $skindir; ?>tr.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                    <td width="18" height="182" background="<?php echo $skindir; ?>ll.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td colspan="2" height="182" align="left" valign="top" bgcolor="#FFFFFF">
                        <table width="1170" border="0" cellspacing="0" cellpadding="0"><tr>
                                <td align="left" valign="top" width="649"><img src="<?php echo $skindir; ?>l1.jpg" width="649" height="182" align="top" /></td>
                                <td align="right" valign="top" width="521"><?php require "rules.php"; ?>-<?php require "menu.php"; ?></td>
                            </tr></table>
                    </td>
                    <td width="22" height="182" background="<?php echo $skindir; ?>mr.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                    <td width="18" background="<?php echo $skindir; ?>ml.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="240" align="center" valign="top" bgcolor="#FFFFFF"><?php require "panel.php"; ?><br/>
                        <?php require "links.php"; ?></td>
                    <td width="930" align="center" valign="top" bgcolor="#FFFFFF">
                        <?php require "mainform.php"; ?></td>
                    <td width="22" background="<?php echo $skindir; ?>mr.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                    <td width="18" background="<?php echo $skindir; ?>ml.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td height="23" colspan="2" align="center" valign="bottom" bgcolor="#FFFFFF"><?php require "toolbar.php"; ?></td>
                    <td height="23" background="<?php echo $skindir; ?>mr.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                    <td width="18" height="23" background="<?php echo $skindir; ?>bl.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td colspan="2" height="23" background="<?php echo $skindir; ?>bm.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="22" height="23" background="<?php echo $skindir; ?>br.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
            </table>
        </div>
    </body>
</html>