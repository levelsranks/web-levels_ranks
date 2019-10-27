<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

$res = [];

if( $Db->mysql_table_search('lk', 0, 0, 'lk_system') == true ):
    $res = $Db->queryAll( 'lk', 0, 0, "SELECT auth, `name`, all_money AS all_cash FROM lk_system WHERE all_money > 1 order by all_money desc");
else:
    $res = $Db->queryAll( 'lk', 0, 0, "SELECT auth, `name`, all_cash FROM lk WHERE all_cash > 1 order by all_cash desc");
endif;

$res == [] && header('Location: ' . $General->arr_general['site']);

// Задаём заголовок страницы.
$Modules->set_page_title( $General->arr_general['short_name'] . ' :: Топ донатеров :: ' . $Translate->get_translate_phrase('_Page') . ' ' . $page_num );

// Задаём описание страницы.
$Modules->set_page_description( $General->arr_general['short_name'] . ' :: Топ донатеров :: ' . $Translate->get_translate_phrase('_Page') . ' ' . $page_num );