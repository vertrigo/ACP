<?php

//$_SESSION['my_root'] = $root_path;

$home_dir = str_replace($_SERVER['DOCUMENT_ROOT'], "", str_replace("\\", '/', $root_path));
//if ($home_dir[1] <> '/') $home_dir = '/'.$home_dir;
if ($_SESSION['gnom'] < 3)
    {
    $images_path = $home_dir . '/content/images/' . $PrefDirForUser . $_SESSION['realmd'] . '/' . $_SESSION['user_id'];
    $files_path = $home_dir . '/content/files/' . $PrefDirForUser . $_SESSION['realmd'] . '/' . $_SESSION['user_id'];
    // создаем папочки для реалмов
    if (!is_dir($root_path . '/content/files/' . $PrefDirForUser . $_SESSION['realmd']))
        mkdir($root_path . '/content/files/' . $PrefDirForUser . $_SESSION['realmd'], 0777);
    if (!is_dir($root_path . '/content/images/' . $PrefDirForUser . $_SESSION['realmd']))
        mkdir($root_path . '/content/images/' . $PrefDirForUser . $_SESSION['realmd'], 0777);
    // создаем папочки для аккаунтов
    if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $images_path))
        mkdir($_SERVER['DOCUMENT_ROOT'] . $images_path, 0777);
    if (!is_dir($_SERVER['DOCUMENT_ROOT'] . $files_path))
        mkdir($_SERVER['DOCUMENT_ROOT'] . $files_path, 0777);
    }
else
    {
    $images_path = $home_dir . '/content/images';
    $files_path = $home_dir . '/content/files';
    }

$_SESSION['my_files'] = $files_path;
$_SESSION['my_images'] = $images_path;

$edit_script = '
<script type="text/javascript" src="tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
// General options
	mode : "textareas",
	theme : "advanced",
//	theme : "simple",
	language : "ru",
	width : "590",
	height : "300",
	plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,images",
// Theme options
	theme_advanced_buttons1 : "undo,redo,|,forecolor,backcolor,bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "link,unlink,anchor,image,emotions,charmap,images,search,replace,sub,sup,|,bullist,numlist,outdent,indent,|,blockquote,cite,|,visualchars,nonbreaking,preview",
	theme_advanced_buttons3 : "tablecontrols,hr,removeformat,visualaid,insertlayer,moveforward,movebackward,absolute,code",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : false,
// Example content CSS (should be your site CSS)
	content_css : "css/example.css",
// Drop lists for link/image/media/template dialogs
	template_external_list_url : "js/template_list.js",
	external_link_list_url : "js/link_list.js",
	external_image_list_url : "js/image_list.js",
	media_external_list_url : "js/media_list.js",
});
</script>
';
?>