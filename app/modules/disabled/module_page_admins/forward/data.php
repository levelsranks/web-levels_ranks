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

// Запрос на получение информации о банах
$res = $Db->queryAll('SourceBans', 0, 0, "SELECT 
                                          {$Db->db_data['SourceBans'][0]['Table']}admins.aid, 
                                          {$Db->db_data['SourceBans'][0]['Table']}admins.authid, 
                                          {$Db->db_data['SourceBans'][0]['Table']}admins.user, 
                                          {$Db->db_data['SourceBans'][0]['Table']}admins.srv_group, 
                                          ( SELECT COUNT(1) FROM {$Db->db_data['SourceBans'][ 0 ]['Table']}bans WHERE aid={$Db->db_data['SourceBans'][0]['Table']}admins.aid ) AS bans_count,
                                          ( SELECT COUNT(1) FROM {$Db->db_data['SourceBans'][ 0 ]['Table']}comms WHERE aid={$Db->db_data['SourceBans'][0]['Table']}admins.aid ) AS comms_count
                                          FROM 
                                          {$Db->db_data['SourceBans'][0]['Table']}admins 
                                          WHERE {$Db->db_data['SourceBans'][0]['Table']}admins.aid > 0");

$Modules->set_page_title( $General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_phrase('_Admins_sb') );

$Modules->set_page_description( $General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_phrase('_Admins_sb') );