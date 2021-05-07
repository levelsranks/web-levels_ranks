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

$server_group = (int) intval ( get_section( 'server_group', '0' ) );

// Проверяем актуальность кэша.
if ( ( empty( $data['module_page_rankstats'] ) ) || ( time() > $data['module_page_rankstats']['time'] ) ):

    // Затираем страные данные которые могут помешать созданию кэша.
    unset( $data['module_page_rankstats']['data'] );

    // Сохраняем текущее время и прибавляем к нему 1 час.
    $data['module_page_rankstats']['time'] = time() + $Modules->array_modules['module_page_rankstats']['setting']['cache_time'];

    // Проверка на подключенный мод - Levels Ranks
    if ( ! empty( $Db->db_data['LevelsRanks'] ) ):
        // Циклом подключаемся к базам данных и сохраняем информацию для нашего кэша.
        for ( $d = 0; $d < $Db->table_count['LevelsRanks']; $d++ ):
            $data['module_page_rankstats']['data'][] = $Db->queryAll('LevelsRanks', $Db->db_data['LevelsRanks'][$d]['USER_ID'], $Db->db_data['LevelsRanks'][ $d ]['DB_num'], "SELECT rank, COUNT(rank) * 100.0 / ((SELECT COUNT(rank) FROM {$Db->db_data['LevelsRanks'][ $d ]['Table']}) * 1.0) AS Percent FROM {$Db->db_data['LevelsRanks'][ $d ]['Table']} GROUP BY rank" );
        endfor;
    endif;

    // Проверка на подключенный мод - FPS
    if ( ! empty( $Db->db_data['FPS'] ) ):
        for ($d = 1; $d <= $Db->table_count['FPS']; $d++ ):
            $data['module_page_rankstats']['data'][]  = $Db->queryAll( 'FPS', 0, 0, "SELECT rank, COUNT(rank) * 100.0 / ((SELECT COUNT(rank) FROM fps_servers_stats WHERE fps_servers_stats.server_id = '{$d}') * 1.0) AS Percent FROM fps_servers_stats WHERE fps_servers_stats.server_id = '{$d}' GROUP BY rank" );
        endfor;
    endif;
    
    // Сохраняем новый кэш для данного модуля.
    $Modules->set_module_cache( 'module_page_rankstats', $data['module_page_rankstats'] );
endif;

if( $server_group > $Db->table_statistics_count - 1 || $server_group < 0 ):
    header( 'Location: ' . $General->arr_general['site'] );
    die();
endif;

// Задаём заголовок страницы.
$Modules->set_page_title( $General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_phrase('_Rank_stats') . ' :: ' .  $Db->statistics_table[ $server_group ]['name'] );

// Задаём описание страницы.
$Modules->set_page_description( $General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_phrase('_Rank_stats') . ' :: ' . $Db->statistics_table[ $server_group ]['name'] );