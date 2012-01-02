<?php

if (!isset($r_ip) or ($r_ip == ''))
    return;
if (isset($ModulesView) and ($ModulesView == 1))
    {
    if (isset($_SESSION['modul']) and isset($modules[$_SESSION['modul']]))
        {
        $MenuActiveModul = $_SESSION['modul'];
        if (!isset($_GET['modul']) OR ($_GET['modul'] == ''))
            $MenuActiveModul = 'news';
        }
    else
        $MenuActiveModul = 'news';
    if (isset($_GET['modul']) and ($_GET['modul'] <> NULL))
        $MenuActiveModul = $_GET['modul'];
    if (isset($_POST['modul']) and ($_POST['modul'] <> NULL))
        $MenuActiveModul = $_POST['modul'];
    if (isset($_GET['modul']) AND isset($modules[0][$_GET['modul']]) AND ($modulesAccess[$_GET['modul']] == 0))
        $MenuActiveModul = $_GET['modul'];
    echo "<select size=\"1\" name=\"my_menu\" onchange=\"document.location.href='index.php?modul='+this.value;\">";
    reset($modules);
    $sel = 0;
    while (list($menu1, $menu2) = each($modules))
        {
        $menuShow = 0;
        if (($menu2[2] < 0) and ($menu2[4] == 1))
            $menuShow = 1;
        if (isset($_SESSION['gnom']) and ($_SESSION['gnom'] >= $menu2[2]) and ($menu2[4] == 1))
            $menuShow = 1;
        if ($menuShow == 1)
            {
            if ($MenuActiveModul == $menu1)
                {
                echo '<option value="' . $menu1 . '" selected>' . $txt[$menu2[1]] . '</option>';
                $sel = 1;
                }
            else
                echo '<option value="' . $menu1 . '">' . $txt[$menu2[1]] . '</option>';
            }
        }
    if ($sel == 0)
        echo '<option value="0" selected> </option>';
    echo "</select>";
    }
//=====================================
elseif (isset($ModulesView) and ($ModulesView == 2))
    {
    $MenuForAll = '';
    $MenuPlayers = '';
    $MenuAdmin = '';
    reset($modules);
    while (list($menu1, $menu2) = each($modules))
        {
        if (($menu2[2] < 0) and ($menu2[4] == 1))
            {
            $MenuForAll = $MenuForAll . '<tr><td align="left" valign="middle"><a href="index.php?modul=' . $menu1 . '" target=_self>' . $txt[$menu2[1]] . '</a></td></tr>';
            } elseif (($menu2[2] == 0) and isset($_SESSION['gnom']) and ($menu2[4] == 1))
            {
            $MenuPlayers = $MenuPlayers . '<tr><td align="left" valign="middle"><a href="index.php?modul=' . $menu1 . '" target=_self>' . $txt[$menu2[1]] . '</a></td></tr>';
            } elseif (($menu2[2] > 0) and isset($_SESSION['gnom']) and ($_SESSION['gnom'] > 1) and ($menu2[4] == 1))
            {
            $MenuAdmin = $MenuAdmin . '<tr><td align="left" valign="middle"><a href="index.php?modul=' . $menu1 . '" target=_self>' . $txt[$menu2[1]] . '</a></td></tr>';
            }
        }
    if ($MenuForAll . $MenuPlayers . $MenuAdmin <> '')
        {
        echo '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>';
        if ($MenuForAll <> '')
            {
            echo '<td align="center" valign="top"><table border="0" cellspacing="8" cellpadding="0"><tr><td align="left" valign="middle"><b>' . $txt[254] . '</b></a></td></tr>';
            echo $MenuForAll;
            echo '</table></td>';
            }
        if ($MenuPlayers <> '')
            {
            echo '<td align="center" valign="top"><table border="0" cellspacing="8" cellpadding="0"><tr><td align="left" valign="middle"><b>' . $txt[255] . '</b></a></td></tr>';
            echo $MenuPlayers;
            echo '</table></td>';
            }
        if ($MenuAdmin <> '')
            {
            echo '<td align="center" valign="top"><table border="0" cellspacing="8" cellpadding="0"><tr><td align="left" valign="middle"><b>' . $txt[256] . '</b></a></td></tr>';
            echo $MenuAdmin;
            echo '</table></td>';
            }
        echo '</tr></table>';
        }
    }
//============================================
else
    {
    $MenuForAll = '';
    $MenuPlayers = '';
    $MenuAdmin = '';
    reset($modules);
    while (list($menu1, $menu2) = each($modules))
        {
        if (($menu2[2] < 0) and ($menu2[4] == 1))
            {
            $MenuForAll = $MenuForAll . '<tr><td align="left" valign="middle"><a href="index.php?modul=' . $menu1 . '" target=_self>' . $txt[$menu2[1]] . '</a></td></tr>';
            } elseif (($menu2[2] == 0) and isset($_SESSION['gnom']) and ($menu2[4] == 1))
            {
            $MenuPlayers = $MenuPlayers . '<tr><td align="left" valign="middle"><a href="index.php?modul=' . $menu1 . '" target=_self>' . $txt[$menu2[1]] . '</a></td></tr>';
            } elseif (($menu2[2] > 0) and isset($_SESSION['gnom']) and ($_SESSION['gnom'] > 1) and ($menu2[4] == 1))
            {
            $MenuAdmin = $MenuAdmin . '<tr><td align="left" valign="middle"><a href="index.php?modul=' . $menu1 . '" target=_self>' . $txt[$menu2[1]] . '</a></td></tr>';
            }
        }
    if ($MenuForAll . $MenuPlayers . $MenuAdmin <> '')
        {
        echo '<table width="100%" border="0" cellspacing="8" cellpadding="0">';
        if ($MenuForAll <> '')
            {
            echo '<tr><td align="left" valign="middle"><br><b>' . $txt[254] . '</b></a></td></tr>';
            echo $MenuForAll;
            }
        if ($MenuPlayers <> '')
            {
            echo '<tr><td align="left" valign="middle"><br><b>' . $txt[255] . '</b></a></td></tr>';
            echo $MenuPlayers;
            }
        if ($MenuAdmin <> '')
            {
            echo '<tr><td align="left" valign="middle"><br><b>' . $txt[256] . '</b></a></td></tr>';
            echo $MenuAdmin;
            }
        echo '</table>';
        }
    }
?>