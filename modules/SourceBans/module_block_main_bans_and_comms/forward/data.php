<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

empty( $Db->db_data['SourceBans'] ) && get_iframe( '012','Не найден мод - SourceBans  :: /storage/cache/sessions/db.php' );

// Типа банов.
$ban_type = [0 => '<div class="color-red">' . $Translate->get_translate_phrase('_Forever') . '</div>',1 => '<div class="color-blue">' . $Translate->get_translate_phrase('_Unban') . '</div>',2 => '<strike>Сессия</strike>'];

// Типа мутов.
$comms_type = [0 => '<div class="color-red">' . $Translate->get_translate_phrase('_Forever') . '</div>',1 => '<div class="color-blue">' . $Translate->get_translate_phrase('_Uncomm') . '</div>',2 => '<strike>Сессия</strike>'];

// CSGO || CSS
$mod = $Db->db_data['SourceBans'][0]['mod'];

// Запрос на получение информации о банах
$res_bans = $Db->queryAll('SourceBans', $Db->db_data['SourceBans'][0]['USER_ID'], $Db->db_data['SourceBans'][0]['DB_num'], "SELECT " . $Db->db_data['SourceBans'][0]['Table'] . "bans.name, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.authid, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.created, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.length, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.reason, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.type, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.ends, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.RemoveType, sb_admins.user, sb_admins.aid, sb_admins.authid AS admin_authid FROM " . $Db->db_data['SourceBans'][0]['Table'] . "bans INNER JOIN sb_admins ON " . $Db->db_data['SourceBans'][0]['Table'] . "bans.aid=sb_admins.aid order by created desc LIMIT 10");

// Запрос на получение информации о мутах
$res_comms = $Db->queryAll('SourceBans', $Db->db_data['SourceBans'][0]['USER_ID'], $Db->db_data['SourceBans'][0]['DB_num'], "SELECT " . $Db->db_data['SourceBans'][0]['Table'] . "comms.name, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.authid, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.created, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.length, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.reason, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.type, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.ends, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.RemoveType, sb_admins.user, sb_admins.aid, sb_admins.authid AS admin_authid FROM " . $Db->db_data['SourceBans'][0]['Table'] . "comms INNER JOIN sb_admins ON " . $Db->db_data['SourceBans'][0]['Table'] . "comms.aid=sb_admins.aid order by created desc LIMIT 10");