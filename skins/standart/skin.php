<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $code_page; ?>"/>
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <LINK href="<?php echo $cssfile; ?>" type="text/css" rel="stylesheet"  media="screen"/>
    </head>
    <body>
        <div align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="20" height="23" background="<?php echo $skindir; ?>tl.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="240" height="23" background="<?php echo $skindir; ?>tm.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td height="23" background="<?php echo $skindir; ?>tm.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="26" height="23" background="<?php echo $skindir; ?>tr.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" background="<?php echo $skindir; ?>l.jpg" bgcolor="#FFFFFF">
                        &nbsp;
                    </td>
                    <td width="240" align="center" valign="top" bgcolor="#FFFFFF">
                        <img src="<?php echo $skindir; ?>logo.jpg" border="0"/><br/>
                        <?php require "panel.php"; ?><br/>
                        <?php require "links.php"; ?>
                    </td>
                    <td align="center" valign="top" bgcolor="#FFFFFF">
                        <div align="right">
                            <table width="100%" border="0" cellspacing="5" cellpadding="0">
                                <tr>
                                    <td class="PanelTop">&nbsp;</td>
                                    <td width="20">&nbsp;</td>
                                    <td class="PanelTop">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top"><?php require "rules.php"; ?></td>
                                    <td width="20" align="center" valign="top">&nbsp;</td>
                                    <td align="center" valign="top"><?php require "menu.php"; ?></td>
                                </tr>
                                <tr>
                                    <td class="PanelBottom">&nbsp;</td>
                                    <td width="20">&nbsp;</td>
                                    <td class="PanelBottom">&nbsp;</td>
                                </tr>
                            </table>
                        </div>
                        <br/><?php require "mainform.php"; ?>
                    </td>
                    <td width="26" background="<?php echo $skindir; ?>r.jpg" bgcolor="#FFFFFF">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td width="20" background="<?php echo $skindir; ?>l.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td colspan="2" align="center" valign="top" bgcolor="#FFFFFF"><?php require "toolbar.php"; ?></td>
                    <td width="26" background="<?php echo $skindir; ?>r.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                    <td width="20" height="30" background="<?php echo $skindir; ?>bl.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="240" height="30" background="<?php echo $skindir; ?>bm.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td height="30" background="<?php echo $skindir; ?>bm.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                    <td width="26" height="30" background="<?php echo $skindir; ?>br.jpg" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
            </table>
        </div>
    </body>
</html>
