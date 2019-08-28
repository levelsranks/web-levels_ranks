<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

/*
 * Теперь  зола лежит одна
 * Как ни вороши, ни ищи — ни души
 * Гори, гори, моя страна
 * Не туши, ой, не туши, не туши
 */

// Белый список, все любят белые списки!
$General->get_default_url_section('filter', 'value', array('value', 'kills', 'rank', 'playtime', 'headshots', 'deaths', 'playtime', 'kd') );

// Очень важная настройка, кол-во человек на странице
define('PLAYERS_ON_PAGE', '80');

$server_group = (int) intval ( get_section( 'server_group', '0' ) );

// Получаем номер страницы

$page_num = (int) intval ( get_section( 'num', '1' ) );

// Проверочка

if($page_num <= '0'){
    header('Location: ' . $General->arr_general);
    exit;
}

// Проверка на подключенный мод - Levels Ranks
if ( ! empty( $Db->db_data['LevelsRanks'] ) ):
for ($d = 0; $d < $Db->table_count['LevelsRanks']; $d++) {
        $res_data[] = ['statistics' => 'LevelsRanks',
                       'name_servers' => $Db->db_data['LevelsRanks'][$d]['name'],
                       'mod' => $Db->db_data['LevelsRanks'][$d]['mod'],
                       'USER_ID' => $Db->db_data['LevelsRanks'][$d]['USER_ID'],
                       'data_db' => $Db->db_data['LevelsRanks'][$d]['DB_num'],
                       'data_servers' => $Db->db_data['LevelsRanks'][$d]['Table']];
}
endif;

// Проверка на подключенный мод - FPS
if ( ! empty( $Db->db_data['FPS'] ) ):
    for ($d = 0; $d < $Db->table_count['FPS']; $d++) {
        $res_data[] = ['statistics' => 'FPS',
            'name_servers' => $Db->db_data['FPS'][$d]['name'],
            'mod' => $Db->db_data['FPS'][$d]['mod'],
            'USER_ID' => $Db->db_data['FPS'][$d]['USER_ID'],
            'data_db' => $Db->db_data['FPS'][$d]['DB_num'],
            'server_id' => $d+1,
            'ranks_id' => $Db->db_data['FPS'][$d]['ranks_id'],
            'data_servers' => $Db->db_data['FPS'][$d]['Table']];
    }
endif;

$res_data_count = sizeof( $res_data );

$page_num_min = ($page_num - 1) * PLAYERS_ON_PAGE;

switch ( $res_data[ $server_group ]['statistics'] ) {
    case 'LevelsRanks':
        $page_max = ceil($Db->queryNum( 'LevelsRanks', $res_data[ $server_group ]['USER_ID'], $res_data[ $server_group ]['data_db'], "SELECT COUNT(*) FROM " . $res_data[ $server_group ]['data_servers'] . " ")[0] / PLAYERS_ON_PAGE );
        $res = $Db->queryAll( 'LevelsRanks', $res_data[ $server_group ]['USER_ID'], $res_data[ $server_group ]['data_db'], "SELECT name, rank, steam, playtime, value, kills, headshots, deaths, CASE WHEN deaths = 0 THEN deaths = 1 END, TRUNCATE( kills/deaths, 2 ) AS kd FROM " . $res_data[ $server_group ]['data_servers'] . " order by " . $_SESSION['filter'] . " desc LIMIT " . $page_num_min . "," . PLAYERS_ON_PAGE . " ");
        break;
    case 'FPS':
        $page_max = ceil($Db->queryNum( 'FPS', 0, 0, 'SELECT COUNT(*) FROM ' . $res_data[ $server_group ]["data_servers"] . 'servers_stats WHERE server_id = ' . $res_data[ $server_group ]["server_id"] . ' ')[0] / PLAYERS_ON_PAGE );
        $res = $Db->queryAll( 'FPS', $res_data[ $server_group ]['USER_ID'], $res_data[ $server_group ]['data_db'],
                                                       'SELECT fps_players.nickname AS name,
                                                        fps_players.steam_id AS steam, 
                                                        fps_servers_stats.points AS value, 
                                                        fps_servers_stats.kills, 
                                                        fps_servers_stats.deaths, 
                                                        fps_servers_stats.playtime,
                                                        TRUNCATE( fps_servers_stats.kills / fps_servers_stats.deaths, 2) AS kd,
                                                        ( SELECT fps_ranks.id
                                                          FROM fps_ranks 
                                                          WHERE fps_ranks.rank_id = ' . $res_data[ $server_group ]["ranks_id"] .' 
                                                          AND fps_ranks.points <= fps_servers_stats.points 
                                                          ORDER BY fps_ranks.points DESC LIMIT 1
                                                        ) AS rank
                                                        FROM fps_players
                                                        INNER JOIN fps_servers_stats ON fps_players.account_id = fps_servers_stats.account_id
                                                        WHERE fps_servers_stats.server_id = ' . $res_data[ $server_group ]["server_id"] . ' order by ' . $_SESSION["filter"] . ' desc LIMIT ' . $page_num_min . ',' . PLAYERS_ON_PAGE . ' ');
        break;
}

$page_num > $page_max && header('Location: ' . $General->arr_general['site']);

$res == [] && header('Location: ' . $General->arr_general['site'] . '?page=toppoints&server_group=' . $server_group);
($server_group > $res_data_count-1) ? header('Location: ' . $General->arr_general['site']) : false;

$data['global']['title'] = $General->arr_general['short_name'] . ' :: ' . $Modules->get_translate_phrase('_Statistics') . ' :: ' . $res_data[$server_group]['name_servers'] . ' :: ' . $Modules->get_translate_phrase('_Page') . ' ' . $page_num;
$data['global']['info'] = $General->arr_general['short_name'] . ' :: ' . $Modules->get_translate_phrase('_Statistics') . ' :: ' . $res_data[$server_group]['name_servers'] . ' :: ' . $Modules->get_translate_phrase('_Page') . ' ' . $page_num;