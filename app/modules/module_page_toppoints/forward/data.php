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

$page_max = 0;

$server_group = (int) intval ( get_section( 'server_group', '0' ) );

$server_group >= $Db->table_statistics_count && get_iframe( '009', 'Данная страница не существует' );

// Получаем номер страницы
$page_num = (int) intval ( get_section( 'num', '1' ) );

$page_num <= 0 && get_iframe( '009', 'Данная страница не существует' );

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

// Проверка на подключенный мод - RankMeKento
if ( ! empty( $Db->db_data['RankMeKento'] ) ):
    for ($d = 0; $d < $Db->table_count['RankMeKento']; $d++) {
        $res_data[] = ['statistics' => 'RankMeKento',
            'name_servers' => $Db->db_data['RankMeKento'][$d]['name'],
            'mod' => $Db->db_data['RankMeKento'][$d]['mod'],
            'USER_ID' => $Db->db_data['RankMeKento'][$d]['USER_ID'],
            'data_db' => $Db->db_data['RankMeKento'][$d]['DB_num'],
            'data_servers' => $Db->db_data['RankMeKento'][$d]['Table']];
    }
endif;

$res = [];

$page_num_min = ($page_num - 1) * PLAYERS_ON_PAGE;

if( ! empty( $res_data[ $server_group ]['statistics'] ) ):
    switch ( $res_data[ $server_group ]['statistics'] ) {
        case 'LevelsRanks':
            $page_max = ceil($Db->queryNum( 'LevelsRanks', $res_data[ $server_group ]['USER_ID'], $res_data[ $server_group ]['data_db'], "SELECT COUNT(*) FROM " . $res_data[ $server_group ]['data_servers'] . " WHERE lastconnect > 0")[0] / PLAYERS_ON_PAGE );
            $res = $Db->queryAll( 'LevelsRanks', $res_data[ $server_group ]['USER_ID'], $res_data[ $server_group ]['data_db'], "SELECT name, rank, steam, playtime, value, kills, headshots, deaths, CASE WHEN deaths = 0 THEN deaths = 1 END, TRUNCATE( kills/deaths, 2 ) AS kd FROM " . $res_data[ $server_group ]['data_servers'] . " WHERE lastconnect > 0 order by " . $_SESSION['filter'] . " desc LIMIT " . $page_num_min . "," . PLAYERS_ON_PAGE . " ");
            break;
        case 'FPS':
            $page_max = ceil($Db->queryNum( 'FPS', 0, 0, 'SELECT COUNT(*) FROM fps_servers_stats WHERE server_id = ' . $res_data[ $server_group ]["server_id"] . ' AND lastconnect > 0 ')[0] / PLAYERS_ON_PAGE );
            $res = $Db->queryAll( 'FPS', $res_data[ $server_group ]['USER_ID'], $res_data[ $server_group ]['data_db'],
                'SELECT fps_players.nickname AS name,
                                                        fps_players.account_id, 
                                                        fps_players.steam_id AS steam, 
                                                        fps_servers_stats.points AS value, 
                                                        fps_servers_stats.kills, 
                                                        fps_servers_stats.deaths, 
                                                        fps_servers_stats.playtime,
                                                        ( SELECT SUM(headshots) FROM fps_weapons_stats WHERE fps_weapons_stats.account_id = fps_players.account_id AND fps_weapons_stats.server_id = ' . $res_data[ $server_group ]["server_id"] . ' )  AS headshots,
                                                        TRUNCATE( fps_servers_stats.kills / fps_servers_stats.deaths, 2) AS kd,
                                                        fps_servers_stats.rank
                                                        FROM fps_players
                                                        INNER JOIN fps_servers_stats ON fps_players.account_id = fps_servers_stats.account_id
                                                        WHERE fps_servers_stats.server_id = ' . $res_data[ $server_group ]["server_id"] . ' AND fps_servers_stats.lastconnect > 0 order by ' . $_SESSION["filter"] . ' desc LIMIT ' . $page_num_min . ',' . PLAYERS_ON_PAGE . ' ');
            break;
        case 'RankMeKento':
            $page_max = ceil($Db->queryNum( 'RankMeKento', $res_data[ $server_group ]['USER_ID'], $res_data[ $server_group ]['data_db'], "SELECT COUNT(*) FROM " . $res_data[ $server_group ]['data_servers'] . " ")[0] / PLAYERS_ON_PAGE );
            $res = $Db->queryAll( 'RankMeKento', $res_data[ $server_group ]['USER_ID'], $res_data[ $server_group ]['data_db'], "SELECT `name`, steam, connected AS playtime, score AS `value`, kills, headshots, deaths, CASE WHEN deaths = 0 THEN deaths = 1 END, TRUNCATE( kills/deaths, 2 ) AS kd FROM " . $res_data[ $server_group ]['data_servers'] . " WHERE lastconnect > 0 order by " . $_SESSION['filter'] . " desc LIMIT " . $page_num_min . "," . PLAYERS_ON_PAGE . " ");
            break;
    }
endif;

$page_num > $page_max && get_iframe( '009', 'Данная страница не существует' );

$res == [] && header('Location: ' . $General->arr_general['site'] . '?page=toppoints&server_group=' . $server_group);

// Задаём заголовок страницы.
$Modules->set_page_title( $General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_phrase('_Statistics') . ' :: ' . $Db->statistics_table[ $server_group ]['name'] . ' :: ' . $Translate->get_translate_phrase('_Page') . ' ' . $page_num );

// Задаём описание страницы.
$Modules->set_page_description( $General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_phrase('_Statistics') . ' :: ' . $Db->statistics_table[ $server_group ]['name'] . ' :: ' . $Translate->get_translate_phrase('_Page') . ' ' . $page_num );