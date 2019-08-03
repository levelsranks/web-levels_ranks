<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Проверка поля 'profile' на пустоту.
empty( get_section( 'profile', false ) ) && header('Location: ' . $General->arr_general['site'] ) && exit;

// Импортируем класс который будет работать со страницей игрока.
use app\ext\Player;

// Создаём экземпляр класса с импортом подкласса Db и указанием Steam ID игрока.
$Player = new Player ( $General, $Db, get_section( 'profile', false ), get_section( 'server_group', '0' ) );

$data['global']['title'] = $General->arr_general['short_name'] . ' :: ' .  $Db->db_data['LevelsRanks'][ get_section( 'server_group', '0' ) ]['name'] . ' :: ' . $Modules->get_translate_phrase('_Player') . ' :: ' .  $Player->get_name();
$data['global']['info'] = $General->arr_general['short_name'] . " :: " .  $Db->db_data['LevelsRanks'][ get_section( 'server_group', '0' ) ]['name'] . " :: Steam ID :: " . get_section( 'profile', false ) . " :: Ранг - " . $Modules->get_translate_phrase( $Player->get_rank(), 'ranks_' . $Player->found[  $Player->server_group  ]['ranks_pack'] ) . " :: Количество очков - " .  $Player->get_value();
$data['global']['avatar'] = $General->arr_general['avatars'] == 1 ? $General->getAvatar(con_steam32to64( $Player->get_steam_32() ),1) : 'storage/cache/img/avatars_random/' . rand(1,30) . '.jpg';