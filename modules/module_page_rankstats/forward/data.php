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
$data['module_page_rankstats'] = $Modules->get_module_cache('module_page_rankstats');

$server_group = get_section( 'server_group', '0' );

// Проверяем актуальность кэша.
if ( ( $data['module_page_rankstats'] == '' ) || ( time() > $data['module_page_rankstats']['time'] ) ) {

    // Затираем страные данные которые могут помешать созданию кэша.
    unset( $data['module_page_rankstats']['data'] );

    // Сохраняем текущее время и прибавляем к нему 1 час.
    $data['module_page_rankstats']['time'] = time() + $Modules->array_modules['module_page_rankstats']['setting']['cache_time'];

    // Циклом подключаемся к базам данных и сохраняем информацию для нашего кэша.
    for ( $d = 0; $d < $Db->table_count['LevelsRanks']; $d++ ) {
        $data['module_page_rankstats']['data'][] = $Db->queryAll('LevelsRanks', $Db->db_data['LevelsRanks'][$d]['USER_ID'], $Db->db_data['LevelsRanks'][ $d ]['DB_num'], 'SELECT rank, COUNT(rank) * 100.0 / ((SELECT COUNT(rank) FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ') * 1.0) AS Percent FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' GROUP BY rank' );
    }

    ! file_exists( MODULES_SESSIONS . 'module_page_rankstats' ) && mkdir( MODULES_SESSIONS . 'module_page_rankstats', 0777, true );

    // Сохраняем новый кэш для данного модуля.
    $Modules->set_module_cache( 'module_page_rankstats', $data['module_page_rankstats'] );
}

$data['global']['title'] = $General->arr_general['short_name'] . ' :: ' . $Modules->get_translate_phrase('_Rank_stats') . ' :: ' . $Db->db_data['LevelsRanks'][$server_group]['name'];
$data['global']['info'] = $General->arr_general['short_name'] . ' :: ' . $Modules->get_translate_phrase('_Rank_stats') . ' :: ' . $Db->db_data['LevelsRanks'][$server_group]['name'];
