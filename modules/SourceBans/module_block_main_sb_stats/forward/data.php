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

// Получаем кэша данного модуля.
$data['module_block_main_sb_stats'] = $Modules->get_module_cache('module_block_main_sb_stats');

// Проверяем актуальность кэша.
if ( ( empty( $data['module_block_main_sb_stats'] ) ) || ( ! empty( $data['module_block_main_sb_stats']['time'] ) && time() > $data['module_block_main_sb_stats']['time'] ) ) {

    // Загружаем данные и сохраняем их в кеш на указанное пользователем время (по-умолчанию, 1 час).
    $data = $Db->queryNum(
        'SourceBans', $Db->db_data['SourceBans'][0]['USER_ID'], $Db->db_data['SourceBans'][0]['DB_num'],
        str_replace(
            '{{TABLE_PREFIX}}', $Db->db_data['SourceBans'][ 0 ]['Table'],
            "
            SELECT
                (SELECT COUNT(*) FROM {{TABLE_PREFIX}}_admins WHERE authid <> 'STEAM_ID_SERVER') AS admin_count,
                (SELECT COUNT(*) FROM {{TABLE_PREFIX}}_bans) AS ban_count,
                (SELECT COUNT(*) FROM {{TABLE_PREFIX}}_comms) AS comm_count
            "
        )
    );
    $data['module_block_main_sb_stats']['time'] = time() + $Modules->array_modules['module_block_main_sb_stats']['setting']['cache_time'];
    $data['module_block_main_sb_stats']['count_admins'] = $data[0];
    $data['module_block_main_sb_stats']['count_bans'] = $data[1];
    $data['module_block_main_sb_stats']['count_comms'] = $data[2];
    
    // Сохраняем новый кэш для данного модуля.
    $Modules->set_module_cache( 'module_block_main_sb_stats', $data['module_block_main_sb_stats'] );
}