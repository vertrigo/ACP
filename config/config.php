<?php

//=====================================================
// подключения к базам данных
//ACP
$k_ip     = '127.0.0.1';
$k_userdb = 'root';
$k_pw     = '12345';
$k_db     = 'acp';

// realmd/auth
$r_ip     = '127.0.0.1';     
$r_userdb = 'root';
$r_pw     = '12345';
$r_db     = '335_realmd';

// characters
$c_ip     = $MyRealms[$_SESSION['realmd']]['c_ip'];
$c_userdb = $MyRealms[$_SESSION['realmd']]['c_userdb'];
$c_pw     = $MyRealms[$_SESSION['realmd']]['c_pw'];
$c_db     = $MyRealms[$_SESSION['realmd']]['c_db'];

// mangos/world
$m_ip     = $MyRealms[$_SESSION['realmd']]['m_ip'];
$m_userdb = $MyRealms[$_SESSION['realmd']]['m_userdb'];
$m_pw     = $MyRealms[$_SESSION['realmd']]['m_pw'];
$m_db     = $MyRealms[$_SESSION['realmd']]['m_db'];

//sd2 (if exist)
$s_ip     = $MyRealms[$_SESSION['realmd']]['s_ip'];
$s_userdb = $MyRealms[$_SESSION['realmd']]['s_userdb'];
$s_pw     = $MyRealms[$_SESSION['realmd']]['s_pw'];
$s_db     = $MyRealms[$_SESSION['realmd']]['s_db'];

//=====================================================
$AutoBanCount = 5; // попыток.
$AutoBanTime = 15; // в минутах.
$KcaptchaEnable = 2; // 0 - выкл, 1 - вкл. 
                     // 2 - капча если один раз ввели неверно.

//=====================================================
// Языковые настройки
$lang     = 'ru';   // ru или en
$encoding = 'utf8'; // utf8 или cp1251 для английского языка ставим utf8
$ampie_encoding = 'utf8'; // кодировка для графической статистики ampie. Рекомендуется utf8.

//=====================================================
// модуль управления персонажем
$gm_free_pay    = 2;          // здесь указываем GMLEVEL с которого начинается 
                              // бесплатное выполнение операций 
$Rename_price   =    300000;  // цена переименования
$Relocate_price =  20000000;  // цена переноса персонажа на другой аккаунт
$Teleport_price =     50000;  // цена телепорта персонажа в сталицу
$Gender_price   =    500000;  // цена смены пола у персонажа
$Custom_price   =     30000;  // цена смены образа персонажа (парикмахерская).
$Talant_price   =     10000;  // Цена сброса талантов
$Change_race_price = 5000000; // Цена смены расы/фракции

//=====================================================
$ServerSystem      = 0;           // 0-mangos или 1-trinity
$ServerName        = 'Server WOW'; 

//=====================================================
$DefaultModule     = 'news'; // Модуль по умолчанию.
$ChangeRealmModule = 'stat'; // Модуль на который переключается при смене реалма
$Multifraction = 0;  // Разрешить переносить на аккаунт персонажей обеих фракций.
                     // 0 - только одна фракция на аккаунте, 1 - обе.
$HeroicChar    = 1;  // Max Heroic Characters per Realmd
$ShowIdAcc     = 0;  // Показ ИД игрока
$AccIpLimit    = 0;  // если не ноль, то указывает максимально возможное количество
                     // аккаунтов на одном IP. 0 - отключена проверка.
$PassRemember  = 1;  // Разрешение/Запрет функции восстановления пароля
                     // 1 - разрешено, 0 - запрещено
$def_exp_acc   = 2;  // (дефолтовое значение поля EXPANSION у аккаунтов
                     // 0 - wow
                     // 1 - tbc
                     // 2 - wotlk
$time_zone_corrector = 0;     // корректировка времени для расписания ивентов.
                              // здесь указываем количество минут, которые
                              // надо прибавить к времени ивентов в расписании.
/*
$autobroadcast = 0;  // autobroadcast выводит список объявлений данного патча.
                     // on|off|Realmd    0 - off , 1 - mangos , 2 - realmd 3 - characters
 */

//=====================================================
$acpskin = 'standart'; // шкурка сайта
                       // skins: standart, green, purple
$SkinChange = 1;       // разрешить смену скина в ссылке
                       // 1 - меняем, 0 - нет.

//Для смены скина использовать ссылку типа: index.php?acpskin=MySkin

//=====================================================
// Character viewer prefics. если '', то выключено; 
// (нужен для интеграции с wowd или cswowd.)
// это начало ссылки подписывает к именам персонажей. 
$charview ='';
//$charview = '../cswowd/?player=';
$gildview = '';
//$gildview = '../cswowd/?guild=';
$npcview ='';
//$npcview = '../cswowd/?npc=';

//=====================================================
// Баны
                     // addon "Jail" (работа с тюрьмой)
$JailShow     = 0;   // показывать или нет персонажей находящихся в тюрьме.
                     // 0 - нет, 1 - показывать.
$UnBanLevel   = 2;   // ГМ-уровень для доступа к разбану.


// !!! Модуль погашения банов пока не реализован !!!
/*
$PayUnBan     = 0;   // включить модуль денежного погашеия БАНа
$UnBan_Price  = 1;   // количество денег снимаемое за убирание 1 минуты бана
$UnJail_Price = 1;   // количество денег снимаемое за убирание 1 минуты тюрьмы
*/

//=====================================================
// Настройки почты. 
$AccountEmailChange = 0; // 1 - разрешено менять почтовый ящик аккаунта. 0 - нет.
$mail_subject         = 'server WoW mail service'; // тема письма
$mail_from            = 'server@mail.ru';          // от кого письмо
$mail_from_name       = 'WoW Server mailBOT';      // имя отправителя
$mail_method          = 'smtp';                    // "test", "mail", "sendmail", or "smtp"
$mail_smtp_Host       = "smtp.mail.ru";            // SMTP сервер
$mail_smtp_Username   = "Server WOW";              // почтовый ящик на сервере отправителе
$mail_smtp_Password   = "*****";                   // пароль на указанный ящик

//=====================================================
// модуль показа лога
$LogPageSize  = 40;    // Длина страницы лога
$LogDateLimit = 60;    // Срок давности для лога. (дней)
$LogSavePass  = 0;     // 0/1 (1-сохраняем.)
                       // Сохранять новые пароли в логе (не советую!)

//=====================================================
// модуль баг-репортов
$WriteBagreport  =      1;   // Включить модуль багрепорта. 0=off, 1=on
$PageBagReport   =     10;   // количество записей на странице баг-репорта.
$ThanksBagReport = 100000;   // благодарность за багрепорт (в игровых денежных еденицах).
$PrefDirForUser  = 'realmd_users_'; // Префикс 

//=====================================================
// новости  (0=off, 1=on)
$LoginNews      =  1; // новости для всех (при авторизации)
$PlayerNews     =  1; // новости для игроков
$AdminNews      =  0; // новости админам и ГМам
$PageNews       =  5; // длина страницы
$PageNewsEdit   = 20; // длина страницы редактора новостей и материаллов

//=====================================================
// показ статических материалов
$RulesView     = 0; // 0 - показ ввиде обычного меню. 
                    // 1 - показ ввиде выпадающего меню.
                    // в шаблон вставляется строка: require "rules.php";

//=====================================================
// Показ меню модулей
$ModulesView  = 2; // 0 - показ ввиде обычного вертикального меню.
                   // 1 - показ ввиде выпадающего меню.
                   // 2 - горизонтальное расположение трех меню
                   // Показ ввиде обычногого меню. с разделением групп по горизонтали.

//=====================================================
// Показ ссылок
$LinkView         = 1; // 0 - вертикальное меню.
                       // 1 - Вертикальные кнопки (картинки)
                       // 2 - Горизонтальные кнопки (картинки)
                       // 3 - Горизонтальное меню.
$LinkImageCaption = 0; // показ подписей к картинкам 
                       // 0 - не показывать, 1 - показывать

//=====================================================
// Настройка онлайна и гильдий
$PageOnline        = 20;  // размер страницы для онлайна и гильдий.
$ActiveGuildChar   = 30;  // Количество активных членов гильдии для показа
                          // при 0 - показ всей гильдии.

//=====================================================
// disable print ERROR
error_reporting(E_ERROR | E_PARSE | E_WARNING);
//error_reporting(E_ALL);
//ini_set('display_errors', 0); //disable on production servers!

?>