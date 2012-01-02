<?php

//Обработка $_POST
reset($_POST);
while ($post_name = current($_POST))
    {
//    $_POST[key($_POST)] = addslashes($post_name);
    $union_post = strpos(strtoupper($post_name), 'UNION'); //Если найдем UNION, то обрубаем строку!
    if ($union_post != false)
        $_POST[key($_POST)] = substr($post_name, 0, $union_post);
    unset($union_post);
    next($_POST);
    }
//Обработка $_GET
reset($_GET);
while ($get_name = current($_GET))
    {
//     $_GET[key($_GET)] = addslashes($get_name);
    $union_get = strpos(strtoupper($get_name), 'UNION'); //Если найдем UNION, то обрубаем строку!
    if ($union_get != false)
        $_GET[key($_GET)] = substr($get_name, 0, $union_get);
    unset($union_get);
    next($_GET);
    }
?>