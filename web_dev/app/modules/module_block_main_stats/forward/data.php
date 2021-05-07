<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

switch ( empty( $Modules->array_modules['module_block_main_stats']['setting']['cache_enable'] ) ? 0 : $Modules->array_modules['module_block_main_stats']['setting']['cache_enable'] ) {
    case 0:
        // Проверка на подключенный мод - Levels Ranks
        if ( ! empty( $Db->db_data['LevelsRanks'] ) ):

            // Циклом подключаемся к базам данных и сохраняем информацию для нашего кэша.
            for ( $d = 0; $d < $Db->table_count['LevelsRanks']; $d++ ):
                $d_data[] = $Db->queryAll('LevelsRanks', $Db->db_data['LevelsRanks'][ $d ]['USER_ID'], $Db->db_data['LevelsRanks'][ $d ]['DB_num'],
                    'SELECT ( SELECT COUNT(1) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' LIMIT 1) AS Total_players,
                            ( SELECT COUNT(1) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' WHERE lastconnect>=' . (time() - 86400) . ' LIMIT 1) AS Players_24h,
                            ( SELECT sum(headshots) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' LIMIT 1) AS Headshot,
                            ( SELECT sum(playtime) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' LIMIT 1) AS playtime')[0];
            endfor;
        endif;

        // Проверка на подключенный мод - FPS
        if ( ! empty( $Db->db_data['FPS'] ) ):
            $d_data[] = $Db->queryAll('FPS', 0, 0,
                'SELECT ( SELECT COUNT(1) FROM fps_players ) AS Total_players,
                            ( SELECT COUNT(1) FROM fps_servers_stats WHERE lastconnect>=' . (time() - 86400) . ') AS Players_24h,
                            ( SELECT sum(headshots) FROM fps_weapons_stats ) AS Headshot,
                            ( SELECT sum(playtime) FROM fps_servers_stats ) AS playtime')[0];
        endif;
        $data['module_block_main_stats'] = empty( $d_data['Total_players'] ) ? ['Total_players' => array_sum( array_column( $d_data, 'Total_players') ), 'Players_24h' => array_sum( array_column( $d_data, 'Players_24h') ), 'Headshot' => array_sum( array_column( $d_data, 'Headshot') ), 'playtime' => array_sum( array_column( $d_data, 'playtime') )] : $d_data;

        // Проверка на подключенный мод - RankMeKento
        if ( ! empty( $Db->db_data['RankMeKento'] ) ):
            for ( $d = 0; $d < $Db->table_count['RankMeKento']; $d++ ):
                $d_data[] = $Db->queryAll('RankMeKento', $Db->db_data['RankMeKento'][ $d ]['USER_ID'], $Db->db_data['RankMeKento'][ $d ]['DB_num'],
                    'SELECT ( SELECT COUNT(1) FROM ' . $Db->db_data['RankMeKento'][ $d ]['Table'] . ' LIMIT 1) AS Total_players,
                            ( SELECT COUNT(1) FROM ' . $Db->db_data['RankMeKento'][ $d ]['Table'] . ' WHERE lastconnect>=' . (time() - 86400) . ' LIMIT 1) AS Players_24h,
                            ( SELECT sum(headshots) FROM ' . $Db->db_data['RankMeKento'][ $d ]['Table'] . ' LIMIT 1) AS Headshot,
                            ( SELECT sum(connected) FROM ' . $Db->db_data['RankMeKento'][ $d ]['Table'] . ' LIMIT 1) AS playtime')[0];
            endfor;
        endif;
        $data['module_block_main_stats'] = empty( $d_data['Total_players'] ) ? ['Total_players' => array_sum( array_column( $d_data, 'Total_players') ), 'Players_24h' => array_sum( array_column( $d_data, 'Players_24h') ), 'Headshot' => array_sum( array_column( $d_data, 'Headshot') ), 'playtime' => array_sum( array_column( $d_data, 'playtime') )] : $d_data;
        break;
    case 1:
        // Получаем кэша данного модуля.
        $data['module_block_main_stats'] = $Modules->get_module_cache('module_block_main_stats');

        // Проверяем актуальность кэша.
        if ( ( empty( $data['module_block_main_stats'] ) ) || ( ! empty( $data['module_block_main_stats']['time'] ) && time() > $data['module_block_main_stats']['time'] ) ) {

            // Затираем страные данные которые могут помешать созданию кэша.
            $data['module_block_main_stats']['Total_players'] = 0;
            $data['module_block_main_stats']['Players_24h'] = 0;
            $data['module_block_main_stats']['Headshot'] = 0;
            $data['module_block_main_stats']['playtime'] = 0;
            $data['module_block_main_stats']['time'] = 0;

            // Сохраняем текущее время и прибавляем к нему 1 час.
            $data['module_block_main_stats']['time'] = time() + $Modules->array_modules['module_block_main_stats']['setting']['cache_time'];

            // Проверка на подключенный мод - Levels Ranks
            if ( ! empty( $Db->db_data['LevelsRanks'] ) ):
                // Циклом подключаемся к базам данных и сохраняем информацию для нашего кэша.
                for ( $d = 0; $d < $Db->table_count['LevelsRanks']; $d++ ) {
                    $data['module_block_main_stats']['Total_players'] += $Db->queryNum('LevelsRanks', $Db->db_data['LevelsRanks'][ $d ]['USER_ID'], $Db->db_data['LevelsRanks'][ $d ]['DB_num'], 'SELECT COUNT(1) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' LIMIT 1')[0];
                    $data['module_block_main_stats']['Players_24h'] += $Db->queryNum('LevelsRanks', $Db->db_data['LevelsRanks'][ $d ]['USER_ID'], $Db->db_data['LevelsRanks'][ $d ]['DB_num'], 'SELECT COUNT(1) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' WHERE lastconnect>=' . (time() - 86400) . ' LIMIT 1')[0];
                    $data['module_block_main_stats']['Headshot'] += $Db->queryNum('LevelsRanks', $Db->db_data['LevelsRanks'][ $d ]['USER_ID'], $Db->db_data['LevelsRanks'][ $d ]['DB_num'], 'SELECT sum(headshots) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' LIMIT 1')[0];
                    $data['module_block_main_stats']['playtime'] += $Db->queryNum('LevelsRanks', $Db->db_data['LevelsRanks'][ $d ]['USER_ID'], $Db->db_data['LevelsRanks'][ $d ]['DB_num'], 'SELECT sum(playtime) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' LIMIT 1')[0];
                }
            endif;

            // Проверка на подключенный мод - FPS
            if ( ! empty( $Db->db_data['FPS'] ) ):
                $data['module_block_main_stats']['Total_players'] += $Db->queryNum('FPS', 0, 0, 'SELECT COUNT(1) FROM fps_players LIMIT 1')[0];
                $data['module_block_main_stats']['Players_24h'] += $Db->queryNum('FPS', 0, 0, 'SELECT COUNT(1) FROM fps_servers_stats WHERE lastconnect>=' . (time() - 86400) . ' LIMIT 1')[0];
                $data['module_block_main_stats']['Headshot'] += $Db->queryNum('FPS', 0, 0, 'SELECT sum(headshots) FROM fps_weapons_stats LIMIT 1')[0];
                $data['module_block_main_stats']['playtime'] += $Db->queryNum('FPS', 0, 0, 'SELECT sum(playtime) FROM fps_servers_stats LIMIT 1')[0];
            endif;

            // Проверка на подключенный мод - RankMeKento
            if ( ! empty( $Db->db_data['RankMeKento'] ) ):
                // Циклом подключаемся к базам данных и сохраняем информацию для нашего кэша.
                for ( $d = 0; $d < $Db->table_count['RankMeKento']; $d++ ) {
                    $data['module_block_main_stats']['Total_players'] += $Db->queryNum('RankMeKento', $Db->db_data['RankMeKento'][ $d ]['USER_ID'], $Db->db_data['RankMeKento'][ $d ]['DB_num'], 'SELECT COUNT(1) FROM ' . $Db->db_data['RankMeKento'][ $d ]['Table'] . ' LIMIT 1')[0];
                    $data['module_block_main_stats']['Players_24h'] += $Db->queryNum('RankMeKento', $Db->db_data['RankMeKento'][ $d ]['USER_ID'], $Db->db_data['RankMeKento'][ $d ]['DB_num'], 'SELECT COUNT(1) FROM ' . $Db->db_data['RankMeKento'][ $d ]['Table'] . ' WHERE lastconnect>=' . (time() - 86400) . ' LIMIT 1')[0];
                    $data['module_block_main_stats']['Headshot'] += $Db->queryNum('RankMeKento', $Db->db_data['RankMeKento'][ $d ]['USER_ID'], $Db->db_data['RankMeKento'][ $d ]['DB_num'], 'SELECT sum(headshots) FROM ' . $Db->db_data['RankMeKento'][ $d ]['Table'] . ' LIMIT 1')[0];
                    $data['module_block_main_stats']['playtime'] += $Db->queryNum('RankMeKento', $Db->db_data['RankMeKento'][ $d ]['USER_ID'], $Db->db_data['RankMeKento'][ $d ]['DB_num'], 'SELECT sum(connected) FROM ' . $Db->db_data['RankMeKento'][ $d ]['Table'] . ' LIMIT 1')[0];
                }
            endif;
            
            // Сохраняем новый кэш для данного модуля.
            $Modules->set_module_cache( 'module_block_main_stats', $data['module_block_main_stats'] );
        }
        break;
}