<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

use app\modules\module_page_profiles\ext\Player;

$Router->map( 'GET|POST', 'profiles/[:id]/', 'profiles' );
$Router->map( 'GET|POST', 'profiles/[:id]/[i:sid]/', 'profiles' );

$Map = $Router->match();

$server_id = $Map['params']['sid'] ?? 0;
$profile = $Map['params']['id'];
$search = intval( $_GET['search'] ?? 0 );

empty( $Map ) && get_iframe("404", "Похоже, URL введен хреново");

// Проверка поля 'profile' на пустоту.
empty( $profile ) && get_iframe( '009', 'Данная страница не существует' );

// Создаём экземпляр класса с импортом подкласса Db и указанием Steam ID игрока.
$Player = new Player ( $General, $Db, $Modules, $profile, $server_id, $search );

// Задаём заголовок страницы.
$Modules->set_page_title( $General->arr_general['short_name'] . ' :: ' .  $Player->found[ $Player->server_group ]['name_servers'] . ' :: ' . $Translate->get_translate_phrase('_Player') . ' :: ' .  $Player->get_name() );

// Задаём описание страницы.
$Modules->set_page_description( $General->arr_general['short_name'] . " :: " .  $Player->found[ $Player->server_group ]['name_servers'] . " :: Steam ID :: " . get_section( 'profile', false ) . " :: Ранг - " . $Translate->get_translate_phrase( $Player->get_rank(), 'ranks_' . $Player->found[  $Player->server_group  ]['ranks_pack'] ) . " :: Количество очков - " .  $Player->get_value() );

// Задаём изображение страницы.
$Modules->set_page_image( $General->getAvatar( con_steam32to64( $Player->get_steam_32() ), 1 ) );

// Основной статус игрока
$Player->set_profile_status( $Translate->get_translate_phrase('_Player'), 'var(--span-color)' );