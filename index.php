<?php

// session
session_start();
// data protection
require "include/protect.php";
// declare realms
require "config/realmlist.php";
if (!isset($_SESSION['realmd']))
    $_SESSION['realmd'] = 1;
if (isset($_GET['realmdselect']))
    $_SESSION['realmd'] = $_GET['realmdselect'];
// load config
require "config/config.php";
// load modules list
require "include/modules_list.php";
// I am
$d = '&copy;&nbsp;Kot&nbsp;DaW' . 'IN' . 'chi&nbsp;' . date('Y') . '&nbsp;';
if (isset($_SESSION['modul']))
    $ModuleCurrent = $_SESSION['modul'];
else
    $ModuleCurrent = $DefaultModule;
// autorisation
require "include/auth.php";
// root
$root_path = dirname(__FILE__);
// select languge
if ($lang == 'en')
    require "include/text." . $lang . ".php";
else
    require "include/text." . $lang . "." . $encoding . ".php";
// declare all function
require "include/func.php";
// change curent skin
if ($SkinChange == 1)
    {
    if (isset($_GET['acpskin']) AND (file_exists("skins/" . $_GET['acpskin'] . "/skin.php")))
        $skin = $_GET['acpskin'];
    if (isset($_SESSION['acpskin']) AND ($_SESSION['acpskin'] <> ''))
        {
        if (isset($_GET['acpskin']) AND (file_exists("skins/" . $_GET['acpskin'] . "/skin.php")))
            $_SESSION['acpskin'] = $_GET['acpskin'];
        if (file_exists("skins/" . $_SESSION['acpskin'] . "/skin.php"))
            $acpskin = $_SESSION['acpskin'];
        }
    }
// css
$cssfile = "skins/$acpskin/style.css";
if (!file_exists($cssfile))
    $cssfile = 'lkstyle.css';
// load skin
$skindir = "skins/$acpskin/";
$skinfile = "skins/$acpskin/skin.php";
// select code page
if ($encoding == 'cp1251')
    $code_page = 'windows-1251';
else
    $code_page = 'utf-8';
// go to skin file
if (file_exists($skinfile))
    include($skinfile);
else
    include("skins/default/skin.php");
?>

