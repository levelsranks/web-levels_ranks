<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Количество банов на странице.
define('PLAYERS_ON_PAGE', '80');

// Номер страницы.
$page_num = get_section( 'num', '1' );

// Типа банов.
$comms_type = [0 => '<div class="color-red">' . $Modules->get_translate_phrase('_Forever') . '</div>',1 => '<div class="color-blue">' . $Modules->get_translate_phrase('_Uncomm') . '</div>',2 => '<strike>Сессия</strike>'];

// CSGO || CSS
$mod = $Db->db_data['SourceBans'][0]['mod'];

// Подсчёт кол-ва страниц
$page_max = ceil($Db->queryNum('SourceBans', $Db->db_data['AutoDemo'][0]['USER_ID'], $Db->db_data['SourceBans'][0]['DB_num'], "SELECT COUNT(*) FROM " . $Db->db_data['SourceBans'][0]['Table'] . "comms ")[0]/PLAYERS_ON_PAGE);

$page_num_min = ($page_num - 1) * PLAYERS_ON_PAGE;

( $page_num > $page_max || $page_num <= '0' ) && header('Location: ' . $General->arr_general['site']);

// Запрос на получение информации о банах
$res = $Db->queryAll('SourceBans', $Db->db_data['AutoDemo'][0]['USER_ID'], $Db->db_data['SourceBans'][0]['DB_num'], "SELECT " . $Db->db_data['SourceBans'][0]['Table'] . "comms.name, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.authid, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.created, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.length, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.reason, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.type, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.ends, " . $Db->db_data['SourceBans'][0]['Table'] . "comms.RemoveType, sb_admins.user, sb_admins.aid, sb_admins.authid AS admin_authid FROM " . $Db->db_data['SourceBans'][0]['Table'] . "comms INNER JOIN sb_admins ON " . $Db->db_data['SourceBans'][0]['Table'] . "comms.aid=sb_admins.aid order by created desc LIMIT " . $page_num_min . "," . PLAYERS_ON_PAGE . " ");

$data['global']['title'] = $General->arr_general['short_name'] . ' :: ' . $Modules->get_translate_phrase('_Comms') . ' :: ' . $Modules->get_translate_phrase('_Page') . ' ' . $page_num;
$data['global']['info'] = $General->arr_general['short_name'] . ' :: ' . $Modules->get_translate_phrase('_Comms') . ' :: ' . $Modules->get_translate_phrase('_Page') . ' ' . $page_num;
