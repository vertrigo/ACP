<?php

$modules  = array (
// modul              path                        Name    Access  Admin Menu
'char'     => array ('modules/char.php',           257,      0,     3,   0  ),  
'acc'      => array ('modules/acc.php',              1,      0,     3,   1  ),
'accedit'  => array ('modules/accedit.php',        257,      0,     3,   0  ),	
'charedit' => array ('modules/charedit.php',       257,      0,     2,   0  ),
'mail'     => array ('modules/mail.php',           257,     -1,     3,   0  ),
'login'    => array ('include/authpanel.php',      257,     -1,     3,   0  ),
'reg'      => array ('modules/reg.php',              4,     -1,     3,   1  ),
'remember' => array ('modules/remember.php',       257,     -1,     3,   0  ),
'log'      => array ('modules/log.php',            134,      2,     3,   1  ),
'command'  => array ('modules/command.php',         68,      0,     3,   1  ),
'news'     => array ('modules/news.php',           173,     -1,     2,   1  ),
'newsedit' => array ('modules/newsedit.php',       178,      2,     3,   1  ),
'tickets'  => array ('modules/tickets.php',        179,      2,     3,   1  ),
'bagtrack' => array ('modules/bagtracker.php',     194,      0,     2,   1  ),
'bagedit'  => array ('modules/bageditor.php',      257,      2,     3,   0  ),
'banlist'  => array ('modules/bans.php',           180,     -1,     2,   1  ),
'online'   => array ('modules/online.php',         221,     -1,     2,   1  ),
'gilds'    => array ('modules/gildies.php',        229,     -1,     2,   1  ),
'static'   => array ('modules/static.php',         258,     -1,     2,   0  ),
'rulesedit'=> array ('modules/rulesedit.php',      236,      3,     3,   1  ),
'stat'     => array ('modules/stat.php',           269,     -1,     2,   1  ),
'events'   => array ('modules/events.php',         319,     -1,     2,   1  ),

);
/*
Доступ пользователей к модулям:
-1 - доступ всем (гостям)
0 - игрокам
1 - модерам
2 - ГМ-ам
3 - Админам
4 - Супер админу (консоль)
100 - не доступен
*/
?>