<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

namespace app\ext;

class Player {

    /**
     * @var string
     */
    public $steam_32;

    /**
     * @var int
     */
    public $steam_64;

    /**
     * @var int
     */
    public $server_group;

    /**
     * @var array
     */
    public $arr_default_info;

    /**
     * @var array
     */
    public $weapons;

    /**
     * @var array
     */
    public $top_weapons;

    /**
     * @var int
     */
    public $top_position;

    /**
     * @var array
     */
    public $found;

    /**
     * @var //
     */
    public $Db;

    function __construct( $Db, $id, $sg ) {

        $check_it = false;

        // Работа с базой данных.
        $this->Db = $Db;

        // Присвоение группы серверов.
        $this->server_group = $sg;

        // Конвертация Steam ID
        substr( $id, 0, 5) === "STEAM" ? $this->steam_32 = $id : $this->steam_32 = con_steam64to32( $id );

        // Поиск игрока в таблицах.
        for ( $i = 0; $i < $Db->table_count['LevelsRanks']; $i++ ):
            if ( $Db->query( 'LevelsRanks', $Db->db_data['LevelsRanks'][ $i ]['DB_num'], "SELECT steam FROM " . $Db->db_data['LevelsRanks'][ $i ]['Table'] . " WHERE steam='" . $this->get_steam_32() . "' limit 1" ) ):

                $this->found[$i] = [
                    "DB"            => $Db->db_data['LevelsRanks'][ $i ]['DB_num'],
                    "Table"         => $Db->db_data['LevelsRanks'][ $i ]['Table'],
                    'name_servers'  => $Db->db_data['LevelsRanks'][ $i ]['name'],
                    'mod'           => $Db->db_data['LevelsRanks'][ $i ]['mod'],
                    'steam'         => $Db->db_data['LevelsRanks'][ $i ]['steam'],
                    "server_group"  => $i
                ];

                if( $check_it == false ):
                    $check_it = $this->found[ $i ]['server_group'] == $this->server_group ? true : false;
                    if( $_GET['search'] == 1 ):
                            if ( ! empty( $this->found[ $i ]['server_group'] ) ):
                                $check_it = true;
                                $this->server_group = $i;
                            endif;
                            endif;
                            endif;
                endif;
        endfor;

        $this->arr_default_info = $this->get_db_arr_default_info();

        $this->top_position = $this->get_db_top_position();

        $this->top_with_player = $this->get_db_top_with_player();


        // Плагин Ex_weapons
        if ( $Db->mysql_table_search( 'LevelsRanks', $this->found[ $this->server_group ]['DB'], $this->found[ $this->server_group ]['Table'] . '_weapons' ) == 1 ):
            $this->weapons = $this->get_db_exstats_weapons();
        else:
            $this->weapons = ['weapon_knife' => '-','weapon_knife_m9_bayonet' => '-','weapon_knife_butterfly' => '-','weapon_knife_falchion' => '-','weapon_knife_def' => '-','weapon_knife_flip' => '-','weapon_knife_gut' => '-','weapon_knife_push' => '-','weapon_knife_t' => '-','weapon_knife_tactical' => '-'];
        endif;

        empty( $this->weapons ) && $this->weapons = ['weapon_knife' => '-','weapon_knife_m9_bayonet' => '-','weapon_knife_butterfly' => '-','weapon_knife_falchion' => '-','weapon_knife_def' => '-','weapon_knife_flip' => '-','weapon_knife_gut' => '-','weapon_knife_push' => '-','weapon_knife_t' => '-','weapon_knife_tactical' => '-'];

        for ( $i = 0; $i < 3; $i++ ):
            $this->top_weapons[ $i ]['name'] = array_search( max( $this->weapons ), $this->weapons );
            $this->top_weapons[ $i ]['kills'] = max( $this->weapons );
            unset( $this->weapons[ $this->top_weapons[ $i ]['name'] ] );
        endfor;

    }

    public function get_value() {
        return (int) empty( $this->arr_default_info['value'] ) ? 0 : $this->arr_default_info['value'];
    }

    public function get_steam_32() {
        return (string) $this->steam_32;
    }

    public function get_name() {
        return (string) empty( $this->arr_default_info['name'] ) ? 'Unknown' : $this->arr_default_info['name'];
    }

    public function get_rank() {
        return (int) empty( $this->arr_default_info['rank'] ) ? 0 : $this->arr_default_info['rank'];
    }

    public function get_kills() {
        return (int) empty( $this->arr_default_info['kills'] ) ? 0 : $this->arr_default_info['kills'];
    }

    public function get_deaths() {
        return (int) empty( $this->arr_default_info['deaths'] ) ? 0 : $this->arr_default_info['deaths'];
    }

    public function get_kd() {
        $a = empty( $this->get_deaths() ) ? 0 : round( $this->get_kills() / $this->get_deaths(), 2);
        return $a . ' ( ' . $this->get_kills() . ' / ' . $this->get_deaths() . ' )';
    }

    public function get_shoots() {
        return (int) $this->arr_default_info['deaths'];
    }

    public function get_hits() {
        return (int) $this->arr_default_info['hits'];
    }

    public function get_percent_hits() {
        $a = round( $this->get_shoots() / 100, 1 );
        $b = empty( $this->get_shoots() ) ? 0 : round( $this->get_hits() / $a, 1 );
        return $b . '% ( ' . $this->get_hits() . ' / ' . $this->get_shoots() . ' )';
    }

    public function get_headshots() {
        return (int) $this->arr_default_info['headshots'];
    }

    public function get_percent_headshots() {
        $a = round( $this->get_kills() / 100, 1 );
        $b = empty( $this->get_headshots() ) ? 0 : round( $this->get_headshots() / $a , 1 );
        return $this->arr_default_info['headshots'] . ' ( ' . $b . ' )';
    }

    public function get_assists() {
        return (int) $this->arr_default_info['assists'];
    }

    public function get_round_win() {
        return (int) $this->arr_default_info['round_win'];
    }

    public function get_round_lose() {
        return (int) $this->arr_default_info['round_lose'];
    }

    public function get_percent_win() {
        $a = round( $this->get_round_lose() / 100, 1 );
        $b = empty( $this->get_round_win() ) ? 0 : round( $this->get_round_win() / $a, 1 );
        return $b . '% (' . $this->get_round_win() . '/' . $this->get_round_lose() . ')';
    }

    public function get_playtime() {
        return (int) round( $this->arr_default_info['playtime'] / 60 / 60 , 0 );
    }

    public function get_steam_64() {
        return (int) $this->steam_64;
    }

    public function get_top_position() {
        return (int) $this->top_position;
    }

    public function get_db_top_with_player() {
        $a = array_reverse($this->Db->queryAll( 'LevelsRanks', $this->found[ $this->server_group ]['DB'],"SELECT name, rank, steam, value FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE '" . $this->get_value() . "' < value ORDER BY value ASC LIMIT 5" ) );
        $b = array_merge( $a, $this->Db->queryAll( 'LevelsRanks', $this->found[ $this->server_group ]['DB'],"SELECT name, rank, steam, value FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE value <= '" . $this->get_value() . "' ORDER BY value DESC LIMIT 11" ) );
        return $b;
    }

    private function get_db_arr_default_info() {
        return $this->Db->query('LevelsRanks', $this->found[ $this->server_group ]['DB'], "SELECT name, rank, steam, playtime, value, kills, headshots, deaths,round_win,round_lose,shoots,hits FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE steam='" . $this->get_steam_32() . "' LIMIT 1");
    }

    private function get_db_top_position() {
        return $this->Db->query( 'LevelsRanks', $this->found[ $this->server_group ]['DB'],"SELECT COUNT(1) AS `top` FROM (SELECT DISTINCT `value` FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE `value` >= " . $this->get_value() . " AND `lastconnect` > 0) t;")['top'];
    }

    private function get_db_exstats_weapons() {
        if ( $this->found[ $this->server_group ]['mod'] == 'csgo' ) {
            return $this->Db->query('LevelsRanks', $this->found[ $this->server_group ]['DB'], "SELECT weapon_knife,weapon_taser,weapon_inferno,weapon_hegrenade,weapon_glock,weapon_hkp2000,weapon_tec9,weapon_usp,weapon_p250,weapon_cz75a,weapon_fiveseven,weapon_elite,weapon_revolver,weapon_deagle,weapon_negev,weapon_m249,weapon_mag7,weapon_sawedoff,weapon_nova,weapon_xm1014,weapon_bizon,weapon_mac10,weapon_ump45,weapon_mp9,weapon_mp7,weapon_p90,weapon_galilar,weapon_famas,weapon_ak47,weapon_m4a1,weapon_m4a1_silencer,weapon_aug,weapon_sg556,weapon_ssg08,weapon_awp,weapon_scar20,weapon_g3sg1,weapon_mp5sd FROM " . $this->found[ $this->server_group ]['Table'] . "_weapons WHERE steam='" . $this->get_steam_32() . "' LIMIT 1" );
        } elseif ( $this->found[ $this->server_group ]['mod'] == 'css' ){
            return $this->Db->query('LevelsRanks', $this->found[ $this->server_group ]['DB'], "SELECT weapon_usp, weapon_sg552, weapon_sg550, weapon_scout, weapon_galil, weapon_mp5navy, weapon_tmp, weapon_m3, weapon_p228, weapon_knife, weapon_glock, weapon_deagle, weapon_elite, weapon_fiveseven, weapon_xm1014, weapon_mac10, weapon_ump45, weapon_p90, weapon_famas, weapon_ak47, weapon_m4a1, weapon_awp, weapon_aug, weapon_ssg08, weapon_m249, weapon_g3sg1 FROM " . $this->found[ $this->server_group ]['Table'] . "_weapons WHERE steam='" . $this->get_steam_32() . "' LIMIT 1" );
        }
    }
}