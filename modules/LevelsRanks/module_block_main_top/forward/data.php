<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

switch ( empty( $Modules->array_modules['module_block_main_top']['setting']['cache_enable'] ) ? 0 : $Modules->array_modules['module_block_main_top']['setting']['cache_enable'] ) {
    case 0:
        // Проверка на подключенный мод - Levels Ranks
        if ( ! empty( $Db->db_data['LevelsRanks'] ) ):
            for ($d = 0; $d < $Db->table_count['LevelsRanks']; $d++ ):
                // Забираем массив даннхы
                $data['module_block_main_top'][] = $Db->queryAll( 'LevelsRanks', $Db->db_data['LevelsRanks'][$d]['USER_ID'], $Db->db_data['LevelsRanks'][$d]['DB_num'],'SELECT name, rank, steam, playtime, value, kills, deaths, CASE WHEN deaths = 0 THEN deaths = 1 END, TRUNCATE( kills/deaths, 2 ) AS kd FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' WHERE lastconnect > 0 order by `value` desc LIMIT 10' );
            endfor;
        endif;

        // Проверка на подключенный мод - FPS
        if ( ! empty( $Db->db_data['FPS'] ) ):
            for ($d = 1; $d <= $Db->table_count['FPS']; $d++ ):
                // Забираем массив даннхы
                $data['module_block_main_top'][] = $Db->queryAll( 'FPS', 0, 0,
                    'SELECT fps_players.nickname AS name,
                                                        fps_players.steam_id AS steam, 
                                                        fps_servers_stats.points AS value, 
                                                        fps_servers_stats.kills, 
                                                        fps_servers_stats.deaths, 
                                                        fps_servers_stats.playtime,
                                                        fps_servers_stats.rank,
                                                        CASE WHEN fps_servers_stats.deaths = 0 THEN fps_servers_stats.deaths = 1 END, TRUNCATE( fps_servers_stats.kills/fps_servers_stats.deaths, 2 ) AS kd
                                                        FROM fps_players
                                                        INNER JOIN fps_servers_stats ON fps_players.account_id = fps_servers_stats.account_id
                                                        WHERE fps_servers_stats.server_id = ' . $d . ' AND fps_servers_stats.lastconnect > 0
                                                        order by `value` desc LIMIT 10' );
            endfor;
        endif;

        // Проверка на подключенный мод - RankMeKento
        if ( ! empty( $Db->db_data['RankMeKento'] ) ):
            for ($d = 0; $d < $Db->table_count['RankMeKento']; $d++ ):
                // Забираем массив даннхы
                $data['module_block_main_top'][] = $Db->queryAll( 'RankMeKento', $Db->db_data['RankMeKento'][$d]['USER_ID'], $Db->db_data['RankMeKento'][$d]['DB_num'],'SELECT `name`, steam, connected AS playtime, score AS `value`, kills, deaths, CASE WHEN deaths = 0 THEN deaths = 1 END, TRUNCATE( kills/deaths, 2 ) AS kd FROM ' . $Db->db_data['RankMeKento'][ $d ]['Table'] . ' WHERE lastconnect > 0 order by `value` desc LIMIT 10' );
            endfor;
        endif;

        break;
    case 1:
        // Получаем кэш
        $data['module_block_main_top'] = $Modules->get_module_cache('module_block_main_top');

// Если кэш морально устарел, то думаю его нужно обновить
        if ( ( empty( $data['module_block_main_top'] ) ) || ( time() > $data['module_block_main_top']['time'] ) ) {

            unset( $data['module_block_main_top'] );

            // Обновляем время последнего кэширования.
            $data['module_block_main_top']['time'] = time() + $Modules->array_modules['module_block_main_top']['setting']['cache_time'];

            // Проверка на подключенный мод - Levels Ranks
            if ( ! empty( $Db->db_data['LevelsRanks'] ) ):
                for ($d = 0; $d < $Db->table_count['LevelsRanks']; $d++ ):
                    // Забираем массив даннхы
                    $data['module_block_main_top'][] = $Db->queryAll( 'LevelsRanks', $Db->db_data['LevelsRanks'][$d]['USER_ID'], $Db->db_data['LevelsRanks'][$d]['DB_num'],'SELECT name, rank, steam, playtime, value, kills, deaths, CASE WHEN deaths = 0 THEN deaths = 1 END, TRUNCATE( kills/deaths, 2 ) AS kd FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' WHERE lastconnect > 0 order by `value` desc LIMIT 10' );
                endfor;
            endif;

            // Проверка на подключенный мод - FPS
            if ( ! empty( $Db->db_data['FPS'] ) ):
                for ($d = 1; $d <= $Db->table_count['FPS']; $d++ ):
                    // Забираем массив даннхы
                    $data['module_block_main_top'][] = $Db->queryAll( 'FPS', 0, 0,
                        'SELECT fps_players.nickname AS name,
                                                        fps_players.steam_id AS steam, 
                                                        fps_servers_stats.points AS value, 
                                                        fps_servers_stats.kills, 
                                                        fps_servers_stats.deaths, 
                                                        fps_servers_stats.playtime,
                                                        fps_servers_stats.rank,
                                                        CASE WHEN fps_servers_stats.deaths = 0 THEN fps_servers_stats.deaths = 1 END, TRUNCATE( fps_servers_stats.kills/fps_servers_stats.deaths, 2 ) AS kd
                                                        FROM fps_players
                                                        INNER JOIN fps_servers_stats ON fps_players.account_id = fps_servers_stats.account_id
                                                        WHERE fps_servers_stats.server_id = ' . $d . ' AND fps_servers_stats.lastconnect > 0
                                                        order by `value` desc LIMIT 10' );
                endfor;
            endif;

            // Проверка на подключенный мод - Levels Ranks
            if ( ! empty( $Db->db_data['RankMeKento'] ) ):
                for ($d = 0; $d < $Db->table_count['RankMeKento']; $d++ ):
                    // Забираем массив даннхы
                    $data['module_block_main_top'][] = $Db->queryAll( 'RankMeKento', $Db->db_data['RankMeKento'][$d]['USER_ID'], $Db->db_data['RankMeKento'][$d]['DB_num'],'SELECT `name`, steam, connected AS playtime, score AS `value`, kills, deaths, CASE WHEN deaths = 0 THEN deaths = 1 END, TRUNCATE( kills/deaths, 2 ) AS kd FROM ' . $Db->db_data['RankMeKento'][ $d ]['Table'] . ' WHERE lastconnect > 0 order by `value` desc LIMIT 10' );
                endfor;
            endif;
            
            // Обновляем кэш
            $Modules->set_module_cache( 'module_block_main_top', $data['module_block_main_top'] );
        }
        break;
}