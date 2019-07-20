<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Получаем кэш
$data['module_block_main_top'] = $Modules->get_module_cache('module_block_main_top');

// Если кэш морально устарел, то думаю его нужно обновить
if ( ( $data['module_block_main_top'] == '' ) || ( time() > $data['module_block_main_top']['time'] ) ) {

    unset( $data['module_block_main_top'] );
    
    // Тут мы создаём таймку и увеличиваем её на 1 час т.е 7200 сек.
    $data['module_block_main_top']['time'] = time() + $Modules->array_modules['module_block_main_top']['setting']['cache_time'];

    // Хоба, for подъехал
    for ($d = 0; $d < $Db->table_count['LevelsRanks']; $d++ ) {
            // Забираем в кэш всё что сможем унести
        $data['module_block_main_top'][ $d ] = $Db->queryAll( 'LevelsRanks', $Db->db_data['LevelsRanks'][$d]['USER_ID'], $Db->db_data['LevelsRanks'][$d]['DB_num'],'SELECT name,rank,steam,playtime,value,kills,deaths FROM ' . $Db->db_data['LevelsRanks'][ $d ]['Table'] . ' order by `value` desc LIMIT 10' );
    }
    // Обновляем кэш
    $Modules->set_module_cache( 'module_block_main_top', $data['module_block_main_top'] );
}