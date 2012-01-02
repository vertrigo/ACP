<?php

$d = '';
$OtherLink = '';
$date = date('d-m-Y [H:i:s]');

function text_optimazer($Mstring)
    {
    $e = 0;
    $rString = trim($Mstring);
    $rString = AddSlashes($rString);
    $rString = trim($rString);

    while ($e < 50)
        {
        if ((substr($rString, -13) == '<p>&nbsp;</p>') && (strlen($rString) > 13))
            {
            $rString = substr($rString, 0, strlen($rString) - 13);
            $e++;
            } else
            $e = 51;
        $rString = rtrim($rString);
        }

    $e = 0;
    while ($e < 50)
        {
        if ((substr($rString, 0, 13) == '<p>&nbsp;</p>') && (strlen($rString) > 13))
            {
            $rString = substr($rString, 13, strlen($rString) - 13);
            $e++;
            } else
            $e = 51;
        $rString = ltrim($rString);
        }
    return trim($rString);
    }

function getLocale($locale)
    {
    switch ($locale):
        case 0:
            $locale = "English";
            break;
        case 1:
            $locale = "Korean";
            break;
        case 2:
            $locale = "French";
            break;
        case 3:
            $locale = "German";
            break;
        case 4:
            $locale = "Chinese";
            break;
        case 5:
            $locale = "Taiwanese";
            break;
        case 6:
            $locale = "Spanish";
            break;
        case 7:
            $locale = "Spanish Mexico";
            break;
        case 8:
            $locale = "Russian";
            break;
    endswitch;
    return $locale;
    }

function getRace($rasa)
    {
    switch ($rasa):
        case 1:
            $rasa = "Human";
            break;
        case 2:
            $rasa = "Ork";
            break;
        case 3:
            $rasa = "Dwarf";
            break;
        case 4:
            $rasa = "Night elf";
            break;
        case 5:
            $rasa = "Undead";
            break;
        case 6:
            $rasa = "Tauren";
            break;
        case 7:
            $rasa = "Gnome";
            break;
        case 8:
            $rasa = "Troll";
            break;
        case 9:
            $rasa = "Goblin";
            break;
        case 10:
            $rasa = "Blood elf";
            break;
        case 11:
            $rasa = "Draenei";
            break;
    endswitch;
    print $rasa;
    }

function getClass($class)
    {
    switch ($class):
        case 1:
            $class = "Warrior";
            break;
        case 2:
            $class = "Paladin";
            break;
        case 3:
            $class = "Hunter";
            break;
        case 4:
            $class = "Rogue";
            break;
        case 5:
            $class = "Priest";
            break;
        case 6:
            $class = "Death Knight";
            break;
        case 7:
            $class = "Shaman";
            break;
        case 8:
            $class = "Mage";
            break;
        case 9:
            $class = "Warlock";
            break;
        case 11:
            $class = "Druid";
            break;
    endswitch;
    print $class;
    }

function getExpansion($typ)
    {
    switch ($typ):
        case 0:
            $typ = "World of Warcraft";
            break;
        case 1:
            $typ = "The Burning Crusade";
            break;
        case 2:
            $typ = "Wrath of the Lich King";
            break;
    endswitch;
    return $typ;
    }

function getSkinList($SkinChange)
    {
    global $txt;
    if ($SkinChange == 1)
        {
        echo "<select size=\"1\" name=\"skin_list\" onchange=\"document.location.href='index.php?acpskin='+this.value;\">";
        echo '<option selected>' . $txt['193'] . '</option>';

        $dir = opendir("./skins/");
        while ($acpskin = readdir($dir))
            {
            if ($acpskin !== '.' and $acpskin !== '..' and $acpskin !== '.svn' and
                    $acpskin !== '.git' and $acpskin !== 'index.html' and
                    $acpskin !== 'index.php' and $acpskin !== 'default')
                {
                echo "<option value=\"$acpskin\">$acpskin</option>" . "\n";
                }
            }
        closedir($dir);
        echo "</select>";
        }
    }

function ReturnMainForm($Retime)
    {
    echo '
<script type="text/javascript"> <!--
function exec_refresh(){
  window.status = "reloading..." + myvar;
  myvar = myvar + " .";
  var timerID = setTimeout("exec_refresh();", 100);
  if (timeout > 0){
  timeout -= 1;
  }else{
    clearTimeout(timerID);
    window.status = "";
    window.location = "index.php";
    }
}
var myvar = "";
var timeout = ' . $Retime . ';
exec_refresh();
//--> </script>';
    }

function getGold($gold)
    {
    $g = floor($gold / (100 * 100));
    $gold = $gold - $g * 100 * 100;
    $s = floor($gold / 100);
    $gold = $gold - $s * 100;
    $c = floor($gold);
    return sprintf("<b>%d<img src=\"images/gold.png\">&nbsp;%02d<img src=\"images/silver.png\">&nbsp;%02d<img src=\"images/copper.png\"></b>", $g, $s, $c);
    }

function generate($number)
    {
    $arr = array('a', 'b', 'c', 'd', 'e', 'f',
        'g', 'h', 'i', 'j', 'k', 'l',
        'm', 'n', 'o', 'p', 'r', 's',
        't', 'u', 'v', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F',
        'G', 'H', 'I', 'J', 'K', 'L',
        'M', 'N', 'O', 'P', 'R', 'S',
        'T', 'U', 'V', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6',
        '7', '8', '9', '0',);
    $symbol = "";
    for ($i = 0; $i < $number; $i++)
        {
        $index = rand(0, count($arr) - 1);
        $symbol .= $arr[$index];
        }
    return $symbol;
    }

function ShowPageNavigator($LinkText, $Page, $AllPages)
    {
    $Page = intval($Page);
    $AllPages = intval($AllPages);
    if ($Page > $AllPages)
        $Page = 1;
    $text = '<table border="0" cellpadding="5" cellspacing="3"><tr>';
    if ($AllPages < 16)
        {
        for ($i = 1; $i <= $AllPages; $i++)
            {
            if ($i == $Page)
                $text .= '<td class=NaviCurrent>' . $i . '</td>';
            else
                $text .= '<td class=NaviButton><a href="' . $LinkText . $i . '" target="_self">' . $i . '</a></td>';
            }
        }
    else
        {
        if ($Page < 6)
            {
            for ($i = 1; $i <= 6; $i++)
                {
                if ($i == $Page)
                    $text .= '<td class=NaviCurrent>' . $i . '</td>';
                else
                    $text .= '<td class=NaviButton><a href="' . $LinkText . $i . '" target="_self">' . $i . '</a></td>';
                }
            $text .= '<td>...</td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . ($AllPages - 2) . '" target="_self">' . ($AllPages - 2) . '</a></td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . ($AllPages - 1) . '" target="_self">' . ($AllPages - 1) . '</a></td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . $AllPages . '" target="_self">' . $AllPages . '</a></td>';
            }
        else if ($Page > ($AllPages - 5))
            {
            $text .= '<td class=NaviButton><a href="' . $LinkText . '1" target="_self">1</a></td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . '2" target="_self">2</a></td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . '3" target="_self">3</a></td>';
            $text .= '<td>...</td>';
            for ($i = ($AllPages - 5); $i <= $AllPages; $i++)
                {
                if ($i == $Page)
                    $text .= '<td class=NaviCurrent>' . $i . '</td>';
                else
                    $text .= '<td class=NaviButton><a href="' . $LinkText . $i . '" target="_self">' . $i . '</a></td>';
                }
            }
        else
            {
            $text .= '<td class=NaviButton><a href="' . $LinkText . '1" target="_self">1</a></td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . '2" target="_self">2</a></td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . '3" target="_self">3</a></td>';
            $text .= '<td>...</td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . ($Page - 1) . '" target="_self">' . ($Page - 1) . '</a></td>';
            $text .= '<td class=NaviCurrent>' . $Page . '</td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . ($Page + 1) . '" target="_self">' . ($Page + 1) . '</a></td>';
            $text .= '<td>...</td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . ($AllPages - 2) . '" target="_self">' . ($AllPages - 2) . '</a></td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . ($AllPages - 1) . '" target="_self">' . ($AllPages - 1) . '</a></td>';
            $text .= '<td class=NaviButton><a href="' . $LinkText . $AllPages . '" target="_self">' . $AllPages . '</a></td>';
            }
        }
    $text .= '</tr></table>';
    return $text;
    }

function sec_to_time($seconds)
    {
    global $txt;
    $seconds_period = array(
        31536000 => $txt['331'],
        2592000 => $txt['332'],
        86400 => $txt['333'],
        3600 => $txt['334'],
        60 => $txt['335'],
    );
    $out = '';
    foreach ($seconds_period as $period => $date_words)
        {
        $number = floor($seconds / $period);
        $out .= $number ? $number . $date_words . ' ' : '';
        $seconds -= $number * $period;
        }
    return $out;
    }

function event_actual_start($start_date, $povtor, $current_date)
    {

    $new_start = floor(($current_date - $start_date) / $povtor) * $povtor + $povtor + $start_date;
    return $new_start;
    }

function event_status($start_date, $povtor, $dlina, $current_date)
    {
    global $time_zone_corrector;
//  if (date('I',$start_date) == 0) 
//      {
//       
//      }
//  else 
//      {
//      
//      }
    $last_start = floor(($current_date - $start_date) / $povtor) * $povtor + $start_date;
    if (($current_date >= $last_start) && ($current_date < ($last_start + $dlina)))
        {
        $state = true;
        } else
        {
        $state = false;
        }
    return $state;
    }

function event_go($start_date, $end_date, $povtor, $dlina, $current_date, $dayofmonth)
    {
    $otvet = false;
    $new_start = event_actual_start($start_date, $povtor, $current_date);
    $last_start = $new_start - $povtor;
    $last_end = $last_start + $dlina;
    if ($new_start <= ($current_date + 60 * 60 * 24 + 1))
        $otvet = true;
    if ($last_start <= $current_date && $last_end >= $current_date)
        $otvet = true;
    if (date('d', $last_start) == 1 && $dlina == $dayofmonth * 24 * 60 * 60)
        $otvet = false;
    return $otvet;
    }

function soap_send($command, $username, $password, $host, $soapport = 7878)
    {
    $client = new SoapClient(NULL,
                    array(
                        "location" => "http://$host:$soapport/",
                        "uri" => "urn:MaNGOS",
                        "style" => SOAP_RPC,
                        'login' => $username,
                        'password' => $password
            ));
    try
        {
        $result = $client->executeCommand(new SoapParam($command, "command"));
        } catch (Exception $e)
        {
        $result = FALSE;
//    $result = $e->getMessage();
        }
    return $result;
    }

require "include/rev.php";
?>
