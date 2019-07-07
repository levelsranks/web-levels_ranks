<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Получаем кэша данного модуля.
$data['module_block_main_stats'] = $Modules->get_module_cache('module_block_main_stats');

// Проверяем актуальность кэша.
if ( ( $data['module_block_main_stats'] == '' ) || ( time() > $data['module_block_main_stats']['time'] ) ) {

    // Затираем страные данные которые могут помешать созданию кэша.
    unset( $data['module_block_main_stats']['Total_players'] );
    unset( $data['module_block_main_stats']['Players_24h'] );
    unset( $data['module_block_main_stats']['Headshot'] );

    // Сохраняем текущее время и прибавляем к нему 1 час.
    $data['module_block_main_stats']['time'] = time() + 7200;


    // Циклом подключаемся к базам данных и сохраняем информацию для нашего кэша.
    for ( $d = 0; $d < $Db->table_count['LevelsRanks']; $d++ ) {
        $data['module_block_main_stats']['Total_players'] += $Db->queryNum('LevelsRanks', $Db->db_data['LevelsRanks'][ $d ]['DB_num'], 'SELECT COUNT(1) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' LIMIT 1' )[0];
        $data['module_block_main_stats']['Players_24h'] += $Db->queryNum('LevelsRanks', $Db->db_data['LevelsRanks'][ $d ]['DB_num'], 'SELECT COUNT(1) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' WHERE lastconnect>=' . (time() - 86400) . ' LIMIT 1' )[0];
        $data['module_block_main_stats']['Headshot'] += $Db->queryNum('LevelsRanks', $Db->db_data['LevelsRanks'][ $d ]['DB_num'], 'SELECT sum(headshots) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' LIMIT 1' )[0];
    }
    // Сохраняем новый кэш для данного модуля.
    $Modules->set_module_cache( 'module_block_main_stats', $data['module_block_main_stats'] );
}