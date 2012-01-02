<?php

session_start();
echo '<a href="kcaptcha.php"  title="Press to reload!"><img src="./kcaptcha/index.php?'
 . session_name() . '=' . session_id() . '" border="0" align="absmiddle"></a>';
?>