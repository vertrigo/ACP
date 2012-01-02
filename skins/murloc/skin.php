<?php
// Skin config
$ModulesView = 2;
$RulesView = 0;
// Skin extended menu links
$ExtMenuHome = '../';
$ExtMenuForum = '../forum/';
$ExtMenuWOWD = '../wowd/';
$ExtMenuMap = '../pomm/';
$ExtMenuBonus = '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $code_page; ?>" />
        <meta http-equiv="Content-Style-Type" content="text/css"/>
        <LINK href="<?php echo $cssfile; ?>" type="text/css" rel="stylesheet"/>
    </head>
    <body>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr><td background="<?php echo $skindir; ?>32.jpg">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="28" height="33" align="right" valign="bottom" bgcolor="#FFFFFF">
                                <img src="<?php echo $skindir; ?>11.jpg" width="28" height="33" />
                            </td>
                            <td height="33" align="left" valign="bottom" background="<?php echo $skindir; ?>13.jpg" bgcolor="#FFFFFF">
                                <img src="<?php echo $skindir; ?>12.jpg" width="222" height="33" />
                            </td>
                            <td width="34" height="33" align="left" valign="bottom" bgcolor="#FFFFFF">
                                <img src="<?php echo $skindir; ?>14.jpg" width="34" height="33" />
                            </td>
                        </tr>
                        <tr>
                            <td width="28" height="520" align="right" valign="top" background="<?php echo $skindir; ?>31.jpg" bgcolor="#FFFFFF">
                                <img src="<?php echo $skindir; ?>21.jpg" width="28" height="244" />
                            </td>
                            <td height="700" align="left" valign="top" bgcolor="#FFFFFF" class="SkinBackBottom">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="570" align="left" valign="top" class="SkinBackTop">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td width="250" height="30" align="right" valign="top">
                                                        <?php require "rules.php"; ?>
                                                    </td>
                                                    <td height="30" colspan="2" align="center" valign="top">
                                                        <table width="90%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="center" valign="top"><?php require "menu.php"; ?></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="250" align="center" valign="top">
                                                        <br/>
                                                        <br/>
                                                        <?php require "panel.php"; ?>
                                                        <br/>
                                                        <?php require "links.php"; ?>
                                                    </td>
                                                    <td height="620" colspan="2" align="center" valign="top">
                                                        <br/>
                                                        <br/>
                                                        <?php require "mainform.php"; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="50" colspan="3" align="center" valign="bottom">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="center" valign="middle"><?php require "toolbar.php"; ?></td>
                                                                <td width="250">&nbsp;</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td width="100" height="570" align="center" valign="top">
                                            <?php
                                            if ($ExtMenuHome <> '')
                                                echo '<a href="' . $ExtMenuHome . '"><img src="' . $skindir . '01.png" width="100" height="118" border="0" /></a>';
                                            if ($ExtMenuForum <> '')
                                                echo '<a href="' . $ExtMenuForum . '"><img src="' . $skindir . '02.png" width="100" height="80" border="0" /></a>';
                                            if ($ExtMenuWOWD <> '')
                                                echo '<a href="' . $ExtMenuWOWD . '"><img src="' . $skindir . '03.png" width="100" height="76" border="0" /></a>';
                                            if ($ExtMenuMap <> '')
                                                echo '<a href="' . $ExtMenuMap . '"><img src="' . $skindir . '04.png" width="100" height="68" border="0" /></a>';
                                            if ($ExtMenuBonus <> '')
                                                echo '<a href="' . $ExtMenuBonus . '"><img src="' . $skindir . '05.png" width="100" height="86" border="0" /></a>';
                                            ?>&nbsp;
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td width="34" height="570" align="left" valign="bottom" background="<?php echo $skindir; ?>33.jpg" bgcolor="#FFFFFF">
                                <img src="<?php echo $skindir; ?>42.jpg" width="34" height="506" />
                            </td>
                        </tr>
                        <tr>
                            <td width="28" height="29" bgcolor="#FFFFFF">
                                <img src="<?php echo $skindir; ?>51.jpg" width="28" height="29" />
                            </td>
                            <td height="29" align="right" valign="top" background="<?php echo $skindir; ?>52.jpg" bgcolor="#FFFFFF">
                                <img src="<?php echo $skindir; ?>53.jpg" width="340" height="29" />
                            </td>
                            <td width="34" height="29" align="left" valign="top" bgcolor="#FFFFFF">
                                <img src="<?php echo $skindir; ?>54.jpg" width="34" height="29" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>