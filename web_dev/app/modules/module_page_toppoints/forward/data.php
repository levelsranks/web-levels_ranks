<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Белый список, все любят белые списки!
$General->get_default_url_section('filter', 'value', array('value', 'kills', 'rank', 'playtime', 'headshots', 'deaths', 'playtime') );

// Очень важная настройка, кол-во человек на странице
define('PLAYERS_ON_PAGE', '80');

$server_group = get_section( 'server_group', '0' );

// Получаем номер страницы

$page_num = get_section( 'num', '1' );

// Проверочка

if($page_num <= '0'){
    header('Location: ' . $General->arr_general);
    exit;
}
// Хоба, for в for'e, получаем массив необъятной информации со страницы! :D

for ($d = 0; $d < $Db->table_count['LevelsRanks']; $d++) {
        $res_data[] = ['name_servers' => $Db->db_data['LevelsRanks'][$d]['name'],'mod' => $Db->db_data['LevelsRanks'][$d]['mod'],'data_db' => $Db->db_data['LevelsRanks'][$d]['DB_num'],'data_servers' => $Db->db_data['LevelsRanks'][$d]['Table'],'count' => ceil($Db->queryNum('LevelsRanks', $Db->db_data['LevelsRanks'][$d]['DB_num'], "SELECT COUNT(*) FROM " . $Db->db_data['LevelsRanks'][$d]['Table'] . " ")[0]/PLAYERS_ON_PAGE)];
}

$res_data_count = sizeof( $res_data );

$page_num_min = ($page_num - 1) * PLAYERS_ON_PAGE;
$page_max = $res_data[$server_group]['count'];

$page_num > $page_max && header('Location: ' . $General->arr_general['site']);


// Запрос

$res[$server_group] = $Db->queryAll( 'LevelsRanks', $res_data[$server_group]['data_db'], "SELECT name,rank,steam,playtime,value,kills,headshots,deaths FROM " . $res_data[$server_group]['data_servers'] . " order by " . $_SESSION['filter'] . " desc LIMIT " . $page_num_min . "," . PLAYERS_ON_PAGE . " ");

$res[$server_group] == [] && header('Location: ' . $General->arr_general['site'] . '?page=toppoints&server_group=' . $server_group);
($server_group > $res_data_count-1 || ctype_digit($server_group) != 1) ? header('Location: ' . $General->arr_general['site']) : false;

$data['global']['title'] = $General->arr_general['short_name'] . ' :: ' . $Modules->get_translate_phrase('_Statistics') . ' :: ' . $res_data[$server_group]['name_servers'] . ' :: ' . $Modules->get_translate_phrase('_Page') . ' ' . $page_num;
$data['global']['info'] = $General->arr_general['short_name'] . ' :: ' . $Modules->get_translate_phrase('_Statistics') . ' :: ' . $res_data[$server_group]['name_servers'] . ' :: ' . $Modules->get_translate_phrase('_Page') . ' ' . $page_num;
