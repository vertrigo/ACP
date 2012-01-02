ALTER TABLE `log`
 ADD COLUMN `realmd` int(11) unsigned NOT NULL default '1' AFTER `old_data`;