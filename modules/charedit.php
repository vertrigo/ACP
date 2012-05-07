<?php

if ($_POST['character'] >= 0)
    {
    $c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
    mysql_select_db($c_db, $c_connect);
    mysql_query("SET NAMES '$encoding'");
    $res = mysql_query("SELECT `name`, `class`, `guid`, `race`, `online`, `gender`, `level`, `money`, `xp` FROM `characters` WHERE (`guid` = " . (int) $_POST['character'] . ") and (`account` = " . $_SESSION['user_id'] . ") and (`online` = 0) LIMIT 1") or trigger_error(mysql_error());
    if (mysql_num_rows($res) == 0)
        {
        echo 'Not select character!';
        } else
        {
        $cres = mysql_fetch_array($res);
        if (($cres['race'] == 1) or ($cres['race'] == 3) or ($cres['race'] == 4) or ($cres['race'] == 7) or ($cres['race'] == 11))
            $char_race = 1; //Alliance
        if (($cres['race'] == 2) or ($cres['race'] == 5) or ($cres['race'] == 6) or ($cres['race'] == 8) or ($cres['race'] == 10))
            $char_race = 2; //Horde
        $money = $cres['money'];
        $char_lvl = $cres['level'];
        $char_class = $cres['level'];
        // ANTI-ERROR !!!!!!
         switch($_POST['id'])
            {
               case 1:
                      echo $txt[94] . '<br>';
                      echo '<br>' . $txt[87]; // aures
                      $res = mysql_query("DELETE FROM `character_aura` WHERE `guid` = " . (int) $_POST['character']);
                      if ($res)
                          echo $txt[92] . '<br>';
                      else
                          echo $txt[93] . '<br>';
                      //=
                      echo '<br>' . $txt[88]; // groups
                      $res = mysql_query("DELETE FROM `groups` WHERE `leaderGuid` = " . (int) $_POST['character']);
                      if ($res)
                          echo $txt[92] . '<br>';
                      else
                          echo $txt[93] . '<br>';
                      //=
//		      echo '<br>'.$txt[89]; // leader groups
//		      $res = mysql_query("DELETE FROM `group_member` WHERE `leaderGuid` = ".(int)$_POST['character']);
//		      if ($res) echo $txt[92].'<br>';
//		          else echo $txt[93].'<br>';
                      //=
                      echo '<br>' . $txt[90]; // member groups
                      $res = mysql_query("DELETE FROM `group_member` WHERE `memberGuid` = " . (int) $_POST['character']);
                      if ($res)
                          echo $txt[92] . '<br>';
                      else
                          echo $txt[93] . '<br>';
                      //=
                      echo '<br>' . $txt[249]; // revive char
                      $res = mysql_query("DELETE FROM `corpse` WHERE `player` = " . (int) $_POST['character']);
                      if ($res)
                          echo $txt[92] . '<br>';
                      else
                          echo $txt[93] . '<br>';
                      //=
                      echo '<br>' . $txt[91]; // go to tavern
                      $res = mysql_query("UPDATE `characters`, `character_homebind` SET `characters`.`position_x`=`character_homebind`.`position_x`, `characters`.`position_y`=`character_homebind`.`position_y`, `characters`.`position_z`=`character_homebind`.`position_z`, `characters`.`map`=`character_homebind`.`map` WHERE `characters`.`guid`=" . (int) $_POST['character'] . " AND `characters`.`guid`=`character_homebind`.`guid`");
                      if ($res)
                          echo $txt[92] . '<br>';
                      else
                          echo $txt[93] . '<br>';
                      echo '<br><br>' . $txt[95] . '<br><br>';

                      $log_account = $_SESSION['user_id'];
                      $log_character = $_POST['character'];
                      $log_mode = 9;
                      $log_email = '';
                      $log_resultat = '';
                      $log_note = '';
                      $log_old_data = '';
                      require('include/log.php');

                      ReturnMainForm(60);
                      break;
               case 2:
                      if (($money >= $Rename_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
                      { //rename
                           echo $txt[96] . '<br><br><hr><br><br>';
                           if ($_SESSION['gnom'] >= $gm_free_pay)
                               $PayMoney = 0;
                           else
                               $PayMoney = $Rename_price;
                           $res = mysql_query("update `characters` set `at_login` = `at_login` | 1, `money` = `money` - " . $PayMoney . " where `guid` = " . (int) $_POST['character']);
                           if ($res)
                               echo $txt[97] . $txt[98] . '<br><br><br><hr><br><br><br>';
                           else
                               echo $txt[99] . '<br><br><br><br>';

                           $log_account = $_SESSION['user_id'];
                           $log_character = (int) $_POST['character'];
                           $log_mode = 7;
                           $log_email = '';
                           $log_resultat = '';
                           $log_note = '';
                           $log_old_data = $cres['name'];
                           require('include/log.php');

                           ReturnMainForm(60);
                      }
                      break;
//===================
               case 5:
                      if (($money >= $Gender_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
                      { //Gender
                           $NewGender = 0;
                           echo $txt[243] . '<br><br><hr><br><br>';
                           $res = mysql_query("select `gender` from `characters`  where `guid` = " . (int) $_POST['character'] . " limit 1");
                           $gres = mysql_fetch_array($res);
                           if ($gres['gender'] == 0)
                           {
                               $NewGender = 1;
                           }
                           if ($_SESSION['gnom'] >= $gm_free_pay)
                              $PayMoney = 0;
                           else
                              $PayMoney = $Gender_price;
                           $res = mysql_query("update `characters` set `at_login` = `at_login` | 8,`gender` = " . $NewGender . ", `money` = `money` - " . $PayMoney . " where `guid` = " . (int) $_POST['character']);
                           if ($res)
                               echo $txt[97] . '<br><br><br><hr><br><br><br>';
                           else
                               echo $txt[99] . '<br><br><br><br>';
                           ReturnMainForm(60);
                      }
                      break;
//===================
             case 6:
                    if (($money >= $Custom_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
                    { //Customize
                        $NewGender = 0;
                        echo $txt[260] . '<br><br><hr><br><br>';
                        if ($_SESSION['gnom'] >= $gm_free_pay)
                            $PayMoney = 0;
                        else
                            $PayMoney = $Custom_price;
                        $res = mysql_query("update `characters` set `at_login` = `at_login` | 8, `money` = `money` - " . $PayMoney . " where `guid` = " . (int) $_POST['character']);
                        if ($res)
                            echo $txt[97] . '<br><br><br><hr><br><br><br>';
                        else
                            echo $txt[99] . '<br><br><br><br>';
                        ReturnMainForm(60);
                    }
                    break;
//===================
             case 7:
                    if (($money >= $Talant_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
                    { //Customize
                         $NewGender = 0;
                         echo $txt[264] . '<br><br><hr><br><br>';
                         if ($_SESSION['gnom'] >= $gm_free_pay)
                             $PayMoney = 0;
                         else
                             $PayMoney = $Talant_price;
                         $res = mysql_query("update `characters` set `at_login` = `at_login` | 4, `money` = `money` - " . $PayMoney . " where `guid` = " . (int) $_POST['character']);
                         if ($res)
                             echo $txt[97] . '<br><br><br><hr><br><br><br>';
                         else
                             echo $txt[99] . '<br><br><br><br>';
                         ReturnMainForm(60);
                    }
                    break;
//===================
             case 8:
                    if (($money >= $Change_race_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
                    { //change race
                         echo $txt[359] . '<br><br><hr><br><br>';
                         if ($_SESSION['gnom'] >= $gm_free_pay)
                             $PayMoney = 0;
                         else
                             $PayMoney = $Change_race_price;
                         $res = mysql_query("update `characters` set `at_login` = `at_login` | 64, `money`=`money` - " . $PayMoney . " where `guid` = " . (int) $_POST['character']);
                         if ($res)
                             echo $txt[97] . '<br><br><br><hr><br><br><br>';
                         else
                             echo $txt[99] . '<br><br><br><br>';
                         ReturnMainForm(60);
                    }
                    break;
//===================
             case 3:
                    if (($money >= $Relocate_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
                    { //change account
                         echo ' <form method="POST"><input name="modul" value="charedit" type=hidden>
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="240" height="40" align="right" valign="middle">' . $txt[100] . '</td>
	<td width="20" height="40"></td>
    <td width="240" height="40" align="left" valign="middle"><input type="text" name="new_acc"></td>
  </tr>
  <tr>
    <td colspan="3" width="500" height="40" align="center" valign="middle"><b>' . $txt[181] . '</b></td>
  </tr>
  <tr>
    <td width="240" height="40" align="right" valign="middle">' . $txt[2] . '</td>
	<td width="20" height="40"></td>
    <td width="240" height="40" align="left" valign="middle"><input type="password" name="pass1"></td>
  </tr>
  <tr>
    <td width="240" height="40" align="right" valign="middle">' . $txt[48] . '</td>
	<td width="20" height="40"></td>
    <td width="240" height="40" align="left" valign="middle"><input type="password" name="pass2"></td>
  </tr>
  <tr>
    <td width="240" height="40" align="right" valign="middle"><input name="character" value="' . (int) $_POST['character'] . '" type=hidden>
	<input name=id value="101" type=hidden></td>
	<td width="20" height="40"></td>
    <td width="240" height="40" align="left" valign="middle"><input type="submit" value="' . $txt[11] . '"></td>
  </tr>
</table><br></form>	<br><br><br><br>';
                    }
                    break;
             case 4:
                     if (($money >= $Teleport_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
                     { // city-teleport
                          echo '<br><form method="POST"><input name="modul" value="charedit" type=hidden>
<input name="character" value="' . $_POST['character'] . '" type=hidden><input name=id value="102" type=hidden>
<table width="500" border="0" cellspacing="0" cellpadding="0">
<tr><td height="25" colspan="4" align="center" valign="middle" class="TableTitle"><b>' . $txt[105] . '</b></td></tr>';
                          require('include/cites.php');
                          $kol = 0;
                          $kol2 = 0;
                          while ($kol < count($cites))
                              {
                                   if (((($char_race == $cites[$kol][2]) or ($cites[$kol][2] == 3)) and ($char_lvl >= $cites[$kol][3])) or ($_SESSION['gnom'] >= $gm_free_pay))
                                   {
                                          echo '<tr><td width="90" height="80" align="center" valign="middle" class="TableLeft">';
                                          echo "<input name=city type=radio value='";
                                          echo $cites[$kol][0];
                                          echo "'></td>";
                                          echo '<td width="150" height="90" align="left" valign="middle" class="TableCenter"><img src="images/cites/' . ($kol + 1) . '.jpg"></td>';
                                          echo '<td width="190" height="90" align="left" valign="middle" class="TableCenter"><b>' . $cites[$kol][1] . '</b></td>';
                                          echo '<td width="80"  height="90" align="left" valign="middle" class="TableRight">';
                                          if ($cites[$kol][2] == 1)
                                              echo '<img src="images/alliance.png">';
                                          if ($cites[$kol][2] == 2)
                                              echo '<img src="images/horde.png">';
                                          if ($cites[$kol][2] == 3)
                                              echo '<img src="images/all_races.png">';
                                          if ($cites[$kol][2] == 0)
                                              echo '<img src="images/gm_teleport.png">';
                                          echo '&nbsp;</td></tr>';
                                          $kol2++;
                                   }
                                   $kol++;
                              }
                           echo '</table><br>';
                           if ($kol2 > 0)
                               echo '<input type="submit" value="' . $txt[11] . '">';
                           else
                               echo $txt[172];
                           echo '</form><br><br>';
                     }
                     break;
              case 101:
                     if (($money >= $Relocate_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
                     { // reloc acc
                          if (($_POST['pass1'] == $_POST['pass2']) AND (strtoupper(SHA1(strtoupper($_SESSION['kito']) . ':' . strtoupper($_POST['pass1']))) == strtoupper($_SESSION['slovo']))
                          AND ($_POST['new_acc'] != '') AND (strtoupper($_POST['new_acc']) != strtoupper($_SESSION['kito'])))
                          {
                               $r_connect = mysql_connect($r_ip, $r_userdb, $r_pw);
                               mysql_select_db($r_db, $r_connect);
                               mysql_query("SET NAMES '$encoding'");
                               $res = mysql_query("SELECT `id` FROM `account` WHERE (`username`='" . addslashes($_POST['new_acc']) . "') LIMIT 1") or trigger_error(mysql_error());
                               if (mysql_num_rows($res) > 0)
                               {
                                   $row0 = mysql_fetch_assoc($res);
                                   $new_acc_id = $row0['id'];
                                   $c_connect = mysql_connect($c_ip, $c_userdb, $c_pw);
                                   mysql_select_db($c_db, $c_connect);
                                   mysql_query("SET NAMES '$encoding'");
                                   $res = mysql_query("SELECT `guid`,`race` from `characters` where `account` = " . $new_acc_id . " order by `level` desc");
                                   $dnum = mysql_num_rows($res);
                                   if ($dnum <= 9)
                                   {
                                       if ($dnum > 0)
                                       {
                                           $dres = mysql_fetch_array($res);
                                           if (($dres['race'] == 1) or ($dres['race'] == 3) or ($dres['race'] == 4) or ($dres['race'] == 7) or ($dres['race'] == 11))
                                                $drace = 1;
                                           if (($dres['race'] == 2) or ($dres['race'] == 5) or ($dres['race'] == 6) or ($dres['race'] == 8) or ($dres['race'] == 10))
                                                $drace = 2;
                                           if ($Multifraction == 1)
                                               $drace = $char_race;
                                       }
                                       else
                                           $drace = $char_race;

                                       $ccres = mysql_query("SELECT count(`guid`) as `heroic` from `characters` where (`account` = " . $new_acc_id . ") and (`class` = 6)");
                                       $cc = mysql_fetch_array($ccres);
                                       if (($cc['heroic'] < $HeroicChar) OR ($char_class <> 6))
                                       {
                                            if ($drace == $char_race)
                                            {
                                                if ($_SESSION['gnom'] >= $gm_free_pay)
                                                   $PayMoney = 0;
                                                else
                                                   $PayMoney = $Relocate_price;
                                                $res = mysql_query("UPDATE `characters` SET `account` = "
                                        . $new_acc_id . ", `money` = `money` - " . $PayMoney . " WHERE `guid` = " . (int) $_POST['character'])
                                        or trigger_error(mysql_error());
                                                echo '<br><br>' . $txt[103] . '<br><br>';

                                                $log_account = $_SESSION['user_id'];
                                                $log_character = $_POST['character'];
                                                $log_mode = 6;
                                                $log_email = '';
                                                $log_resultat = $new_acc_id;
                                                $log_note = $_POST['new_acc'];
                                                $log_old_data = $_SESSION['kito'];
                                                require('include/log.php');
                                            }
                                            else
                                                echo '<br><br>' . $txt[121] . '<br><br>';
                                       }
                                       else
                                            echo '<br><br>' . $txt[177] . $HeroicChar . '<br><br>';
                                   }
                                   else
                                       echo '<br><br>' . $txt[104] . '<br><br>';
                               }
                               else
                                   echo '<br><br>' . $txt[102] . '<br><br>';
                           }
                           else
                               echo '<br><br>' . $txt[101] . '<br><br>';
                           ReturnMainForm(80);
                     }
                     break;
              case 102:
                     if (($money >= $Teleport_price) OR ($_SESSION['gnom'] >= $gm_free_pay))
                        { // teleport
                          require('include/cites.php');
                          echo '<img src="images/cites/' . ($_POST['city']) . '.jpg"><br>';
                          echo '<br>' . $txt[106] . ' ' . $cites[$_POST['city'] - 1][1] . ' - ';
                          $sqler = $cites[$_POST['city'] - 1][4];
                          if ($_SESSION['gnom'] < $gm_free_pay)
                          {
                              $sqler .= ', `money` = `money` - ' . $Teleport_price;
                          }
                          $sqler .= " WHERE `guid`='" . $_POST['character'] . "'";
                          $res = mysql_query($sqler) or trigger_error(mysql_error());
                          if ($res)
                              echo $txt[92] . '<br>';
                          else
                              echo $txt[107] . '<br>';
                          echo '<br><br>';
                          ReturnMainForm(60);
                        }
                        break;
             }
         }
    }
?>