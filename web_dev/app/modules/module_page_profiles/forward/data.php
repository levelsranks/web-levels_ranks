<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Проверяем Steam ID игрока на пустоту через великий URL(Слава URL!)
if( get_section( 'profile', false ) == true ) {

    // Проверка на URL запроса
    $type_id = ( substr( get_section( 'profile', false ), 0, 5) === "STEAM") ? 'steam' : 'id';

    $type_id == 'steam' ? $profile = get_section( 'profile', false ) : $profile = $General->steam64to32( get_section( 'profile', false ) );

    // Получаем так же из URL к какой группе серверов должен быть закреплен игрок.
    $server_group = get_section( 'server_group', '0' );

    // Через серию циклов проверяем наличие игрока в базах данных.
    for ( $d = 0; $d < $Db->table_count['LevelsRanks']; $d++ ) {
        if ($Db->query('LevelsRanks', $Db->db_data['LevelsRanks'][ $d ]['DB_num'], "SELECT steam FROM " . $Db->db_data['LevelsRanks'][ $d ]['Table'] . " WHERE steam='" . $profile . "' limit 1" ) ) {
            $Player_found[] = [
                "DB" => $Db->db_data['LevelsRanks'][ $d ]['DB_num'],
                "Table" => $Db->db_data['LevelsRanks'][ $d ]['Table']
            ];
        } else {
            $Player_found[] = null;
        }
        $res_data[] = [
            'name_servers' => $Db->db_data['LevelsRanks'][ $d ]['name'],
            'mod' => $Db->db_data['LevelsRanks'][ $d ]['mod'],
            'data_servers' => $Db->db_data['LevelsRanks'][ $d ]['Table'],
            'steam' => $Db->db_data['LevelsRanks'][ $d ]['steam']
        ];
    }

    $p_count = sizeof( $Player_found );

    if( $_GET['search'] == 1 ):
        if ( $Player_found[ $server_group ] == '' ):
        for ( $d = 0; $d < $p_count; $d++ ):
            $Player_found[ $d ] != null ? $server_group = $d : $server_group = false;
        endfor;
        endif;
    endif;

    // Если игрок найден, так давай собирать о нём инфу!
    if($Player_found[$server_group] != ''){

        // Основная информация об игроке
        $Player[$server_group] = $Db->query('LevelsRanks', $Player_found[$server_group]['DB'], "SELECT name, rank, steam, playtime, value, kills, headshots, deaths,round_win,round_lose,shoots,hits FROM " . $Player_found[$server_group]['Table'] . " WHERE steam='" . $profile . "' LIMIT 1");

        // Место игрока в топе
        $Player[$server_group] += $Db->query('LevelsRanks', $Player_found[$server_group]['DB'],"SELECT COUNT(1) AS `top` FROM (SELECT DISTINCT `value` FROM " . $Player_found[$server_group]['Table'] . " WHERE `value` >= " . $Player[$server_group]['value'] . " AND `lastconnect` > 0) t;");

        // Костыльный костыль для получения аккуратного топ 10 - ОПТИМИЗИРОВАТЬ
        $Player_top[$server_group]['ASC'] = array_reverse($Db->queryAll( 'LevelsRanks', $Player_found[$server_group]['DB'],"SELECT name, rank, steam, value FROM " . $Player_found[$server_group]['Table'] . " WHERE '" . $Player[$server_group]['value'] . "' < value ORDER BY value ASC LIMIT 5"));
        $Player_top[$server_group] = array_merge($Player_top[$server_group]['ASC'], $Db->queryAll( 'LevelsRanks', $Player_found[$server_group]['DB'],"SELECT name, rank, steam, value FROM " . $Player_found[$server_group]['Table'] . " WHERE value <= '" . $Player[$server_group]['value'] . "' ORDER BY value DESC LIMIT 11"));

        // Работа с модулем оружий
        if ($res_data[$server_group]['mod'] == 'csgo') {
            $Player[$server_group]['weapons'] = $Db->query('LevelsRanks', $Player_found[$server_group]['DB'], "SELECT weapon_knife,weapon_taser,weapon_inferno,weapon_hegrenade,weapon_glock,weapon_hkp2000,weapon_tec9,weapon_usp,weapon_p250,weapon_cz75a,weapon_fiveseven,weapon_elite,weapon_revolver,weapon_deagle,weapon_negev,weapon_m249,weapon_mag7,weapon_sawedoff,weapon_nova,weapon_xm1014,weapon_bizon,weapon_mac10,weapon_ump45,weapon_mp9,weapon_mp7,weapon_p90,weapon_galilar,weapon_famas,weapon_ak47,weapon_m4a1,weapon_m4a1_silencer,weapon_aug,weapon_sg556,weapon_ssg08,weapon_awp,weapon_scar20,weapon_g3sg1,weapon_mp5sd FROM " . $Player_found[$server_group]['Table'] . "_weapons WHERE steam='" . get_section('profile', false) . "' LIMIT 1");
        } elseif ($res_data[$server_group]['mod'] == 'css'){
            $Player[$server_group]['weapons'] = $Db->query('LevelsRanks', $Player_found[$server_group]['DB'], "SELECT weapon_usp, weapon_sg552, weapon_sg550, weapon_scout, weapon_galil, weapon_mp5navy, weapon_tmp, weapon_m3, weapon_p228, weapon_knife, weapon_glock, weapon_deagle, weapon_elite, weapon_fiveseven, weapon_xm1014, weapon_mac10, weapon_ump45, weapon_p90, weapon_famas, weapon_ak47, weapon_m4a1, weapon_awp, weapon_aug, weapon_ssg08, weapon_m249, weapon_g3sg1 FROM " . $Player_found[$server_group]['Table'] . "_weapons WHERE steam='" . get_section('profile', false) . "' LIMIT 1");
        }

        // Костыль, при получении ПУСТОТЫ впихать это чтобы не убрирать блок
        if($Player[$server_group]['weapons'] == ''){$Player[$server_group]['weapons'] = ['weapon_knife' => '-','weapon_knife_m9_bayonet' => '-','weapon_knife_butterfly' => '-','weapon_knife_falchion' => '-','weapon_knife_def' => '-','weapon_knife_flip' => '-','weapon_knife_gut' => '-','weapon_knife_push' => '-','weapon_knife_t' => '-','weapon_knife_tactical' => '-'];}

        // Работа с блоком топа по оружиями - Верхушечка
        for ( $i = 0; $i < 3; $i++ ):
            $max_weapons[ $i ]['name'] = array_search( max( $Player[ $server_group ]['weapons'] ), $Player[ $server_group ]['weapons'] );
            $max_weapons[ $i ]['kills'] = max( $Player[ $server_group ]['weapons'] );
            unset( $Player[ $server_group ]['weapons'][ $max_weapons[ $i ]['name'] ] );
        endfor;

    } else {
        header('Location: ' . $General->arr_general['site']);
        exit;
    }
} else {
    header('Location: ' . $General->arr_general['site']);
    exit;
}

$data['global']['title'] = $General->arr_general['short_name'] . ' :: ' . $Db->db_data['LevelsRanks'][$server_group]['name'] . ' :: ' . $Modules->get_translate_phrase('_Player') . ' :: ' . $Player[$server_group]['name'];
$data['global']['info'] = $General->arr_general['short_name'] . " :: " . $Db->db_data['LevelsRanks'][$server_group]['name'] . " :: Steam ID :: " . get_section( 'profile', false ) . " :: Ранг - " . $Modules->get_translate_phrase('_Rank_' . $Player[$server_group]['rank']) . " :: Количество очков - " . $Player[$server_group]['value'];
$data['global']['avatar'] = $General->getAvatar($General->steam32to64($Player[$server_group]['steam']),1);