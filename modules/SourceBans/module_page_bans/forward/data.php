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

// Количество банов на странице.
define('PLAYERS_ON_PAGE', '80');

// Номер страницы.
$page_num = (int) intval ( get_section( 'num', '1' ) );

// Типа банов.
$ban_type = [0 => '<div class="color-red">' . $Translate->get_translate_phrase('_Forever') . '</div>',1 => '<div class="color-blue">' . $Translate->get_translate_phrase('_Unban') . '</div>',2 => '<strike>Сессия</strike>'];

// CSGO || CSS
$mod = $Db->db_data['SourceBans'][0]['mod'];

// Подсчёт кол-ва страниц
$page_max = ceil($Db->queryNum('SourceBans', $Db->db_data['SourceBans'][0]['USER_ID'], $Db->db_data['SourceBans'][0]['DB_num'], "SELECT COUNT(*) FROM " . $Db->db_data['SourceBans'][0]['Table'] . "bans ")[0]/PLAYERS_ON_PAGE);

$page_num_min = ($page_num - 1) * PLAYERS_ON_PAGE;

( $page_num > $page_max || $page_num <= '0' ) && header('Location: ' . $General->arr_general['site']);

// Запрос на получение информации о банах
$res = $Db->queryAll('SourceBans', $Db->db_data['SourceBans'][0]['USER_ID'], $Db->db_data['SourceBans'][0]['DB_num'], "SELECT " . $Db->db_data['SourceBans'][0]['Table'] . "bans.name, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.authid, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.created, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.length, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.reason, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.type, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.ends, " . $Db->db_data['SourceBans'][0]['Table'] . "bans.RemoveType, sb_admins.user, sb_admins.aid, sb_admins.authid AS admin_authid FROM " . $Db->db_data['SourceBans'][0]['Table'] . "bans INNER JOIN sb_admins ON " . $Db->db_data['SourceBans'][0]['Table'] . "bans.aid=sb_admins.aid order by created desc LIMIT " . $page_num_min . "," . PLAYERS_ON_PAGE . " ");

// Задаём заголовок страницы.
$Modules->set_page_title( $General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_phrase('_Bans') . ' :: ' . $Translate->get_translate_phrase('_Page') . ' ' . $page_num );

// Задаём описание страницы.
$Modules->set_page_description( $General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_phrase('_Bans') . ' :: ' . $Translate->get_translate_phrase('_Page') . ' ' . $page_num );
