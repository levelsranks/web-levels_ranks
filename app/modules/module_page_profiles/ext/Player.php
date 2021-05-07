<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

namespace app\modules\module_page_profiles\ext;

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
    public $msettings;

    /**
     * @var array
     */
    public $weapons = ['weapon_knife' => '-','weapon_knife_m9_bayonet' => '-','weapon_knife_butterfly' => '-','weapon_knife_falchion' => '-','weapon_knife_def' => '-','weapon_knife_flip' => '-','weapon_knife_gut' => '-','weapon_knife_push' => '-','weapon_knife_t' => '-','weapon_knife_tactical' => '-'];

    /**
     * @var array
     */
    public $unusualkills;

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
    public $found = [];

    /**
     * @var object
     */
    public $Db;

    /**
     * @var array
     */
    public $check_user = [];

    /**
     * @var array
     */
    public $profile_status = [ 'text' => '', 'color' => '', 'priority' => 0 ];

    /**
     * @var array
     */
    public $hits = ['Head' => 0, 'Chest' => 0, 'Belly' => 0, 'LeftArm' => 0, 'RightArm' => 0, 'LeftLeg' => 0, 'RightLeg' => 0, 'Neak' => 0];

    /**
     * @var array
     */
    public $maps = ['de_mirage' => '-', 'de_dust2' => '-', 'de_cache' => '-', 'de_inferno' => '-', 'de_nuke' => '-', 'de_cbble' => '-', 'de_overpass' => '-', 'de_train' => '-'];

    /**
     * @var string
     */
    public $geo = '-';

     /**
     * @var int
     */
    public $search;

    function __construct( $General, $Db, $Modules, $id, $sg, $search ) {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        // Работа с базой данных.
        $this->Db = $Db;

        // Работа с ядром.
        $this->General = $General;

        // Работа с модулями.
        $this->Modules = $Modules;

        // Присвоение группы серверов.
        $this->server_group = (int) intval ( $sg );

        // Конвертация Steam ID
        substr( $id, 0, 5) === "STEAM" ? $this->steam_32 = $id : $this->steam_32 = con_steam64to32( $id );

        // Проверка на пустоту
        empty( $this->steam_32 ) && get_iframe( '009', 'Данная страница не существует' );

        $check_it = false;

        if ( ! empty( $Db->db_data['LevelsRanks'] ) ):
            for ( $i = 0, $c = sizeof( $Db->db_data['LevelsRanks'] ); $i < $c; $i++ ):
                $dates[] = $Db->db_data['LevelsRanks'][ $i ];
            endfor;
        endif;

        if ( ! empty( $Db->db_data['FPS'] ) ):
            for ( $i = 0, $c = sizeof( $Db->db_data['FPS'] ); $i < $c; $i++ ):
                $dates[] = $Db->db_data['FPS'][ $i ];
            endfor;
        endif;

        if ( ! empty( $Db->db_data['RankMeKento'] ) ):
            for ( $i = 0, $c = sizeof( $Db->db_data['RankMeKento'] ); $i < $c; $i++ ):
                $dates[] = $Db->db_data['RankMeKento'][ $i ];
            endfor;
        endif;

        // Вводим переменную для работы с серверами FPS
        $f = 1;

        for ( $i = 0; $i < $Db->table_statistics_count; $i++ ):

            switch ( $dates[ $i ]['DB_mod'] ) {
                case 'LevelsRanks':
                    $this->check_user[] = $Db->query( $dates[ $i ]['DB_mod'], $dates[ $i ]['USER_ID'], $dates[ $i ]['DB_num'], "SELECT steam FROM " . $dates[ $i ]['Table'] . " WHERE steam LIKE '%" . $this->get_steam_32_short() . "%' AND lastconnect > 0 limit 1" );
                    break;
                case 'FPS':
                    $this->check_user[] = $Db->query( $dates[ $i ]['DB_mod'], 0, 0, "SELECT fps_players.steam_id, fps_players.account_id FROM fps_players INNER JOIN fps_servers_stats ON fps_players.account_id = fps_servers_stats.account_id WHERE fps_players.steam_id LIKE '%{$this->get_steam_64()}%' AND fps_servers_stats.server_id = '" . $f++ . "' AND fps_servers_stats.lastconnect > 0 LIMIT 1" );
                    break;
                case 'RankMeKento':
                    $this->check_user[] = $Db->query( $dates[ $i ]['DB_mod'], $dates[ $i ]['USER_ID'], $dates[ $i ]['DB_num'], "SELECT steam FROM " . $dates[ $i ]['Table'] . " WHERE steam LIKE '%" . $this->get_steam_32_short() . "%' AND lastconnect > 0 limit 1" );
                    break;
            }

            // Поиск игрока в таблицах.
            if ( ! empty( $this->check_user[ $i ] ) ):

                $this->found[ $i ] = [
                    "DB_mod"        => $dates[ $i ]['DB_mod'],
                    "DB"            => (int) $dates[ $i ]['DB_num'],
                    "USER_ID"       => (int) $dates[ $i ]['USER_ID'],
                    "Table"         => $dates[ $i ]['Table'],
                    'name_servers'  => $dates[ $i ]['name'],
                    'mod'           => (int) $dates[ $i ]['mod'],
                    'steam'         => (int) $dates[ $i ]['steam'],
                    'ranks_pack'    => $dates[ $i ]['ranks_pack'],
                    'ranks_id'      => (int) empty( $dates[ $i ]['ranks_id'] ) ? 0 : $dates[ $i ]['ranks_id'],
                    "server_group"  => (int) $i,
                    "server_int"    => (int) $f-1
                ];

                if( $check_it == false ):
                    $check_it = $this->found[ $i ]['server_group'] == $this->server_group ? true : false;
                    if( ! empty( $search ) && $search == 1 ):
                        if ( ! empty( $this->found[ $i ]['server_group'] ) ):
                            $check_it = true;
                            if ( empty( $_GET['server_group'] ) ):
                                $this->server_group = $i;
                            endif;
                        endif;
                    endif;
                endif;
            endif;
        endfor;

        empty( $this->found[ $this->server_group ] ) && get_iframe( '009', 'Данная страница не существует' );

        $this->found_fix = array_values( $this->found );

        $this->arr_default_info = $this->get_db_arr_default_info();

        $this->top_position = $this->get_db_top_position();

        $this->top_with_player = $this->get_db_top_with_player();

        if( ! empty( $this->found[ $this->server_group ]['DB_mod'] ) && $this->found[ $this->server_group ]['DB_mod'] == 'LevelsRanks' ):

            # Плагин -> ExStats Weapons
            $Db->mysql_table_search( 'LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], $this->found[ $this->server_group ]['Table'] . '_weapons' ) == 1 && ! empty( $result = $this->get_db_exstats_weapons() ) && ( $this->weapons = $result ) && arsort( $this->weapons );

            for ( $i = 0; $i < 3; $i++ ):
                $this->top_weapons[ $i ]['name'] = sizeof( $this->weapons ) ? array_search( max( $this->weapons ), $this->weapons ) : 'weapon_knife';
                $this->top_weapons[ $i ]['kills'] = sizeof( $this->weapons ) ?  max( $this->weapons ) : '-';
                unset( $this->weapons[ $this->top_weapons[ $i ]['name'] ] );
            endfor;

            # Плагин -> Unusual Kills
            if ( $Db->mysql_table_search( 'LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], $this->found[ $this->server_group ]['Table'] . '_unusualkills' ) == 1 ):
                $this->unusualkills = $this->get_db_plugin_module_unusualkills();
            else:
                $this->unusualkills = false;
            endif;

            # Плагин -> ExStats Hits
            if ( $Db->mysql_table_search( 'LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], $this->found[ $this->server_group ]['Table'] . '_hits' ) == 1 ):
                $this->get_db_plugin_module_hits();
            endif;
            
            # Плагин -> ExStats Maps
            if ( $Db->mysql_table_search( 'LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], $this->found[ $this->server_group ]['Table'] . '_maps' ) == 1 ):
                $this->maps = $this->get_db_plugin_module_maps();
                arsort($this->maps);
            endif;

            # Плагин -> ExStats GeoIP
            if ( $Db->mysql_table_search( 'LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], $this->found[ $this->server_group ]['Table'] . '_geoip' ) == 1 ):
                $this->geo = $this->get_db_plugin_module_geoip();
            endif;
        endif;

        if( ! empty( $this->found[ $this->server_group ]['DB_mod'] ) && $this->found[ $this->server_group ]['DB_mod'] == 'FPS' ):

            ! empty( $result = $this->get_db_exstats_weapons() ) && ( $this->weapons = $result ) && arsort($this->weapons);

            for ( $i = 0; $i < 3; $i++ ):
                $this->top_weapons[ $i ]['name'] = sizeof( $this->weapons ) ? array_search( max( $this->weapons ), $this->weapons ) : 'weapon_knife';
                $this->top_weapons[ $i ]['kills'] = sizeof( $this->weapons ) ?  max( $this->weapons ) : '-';
                unset( $this->weapons[ $this->top_weapons[ $i ]['name'] ] );
            endfor;

            $this->get_db_plugin_module_hits();

            if ( $Db->mysql_table_search( 'FPS', 0, 0, 'fps_unusualkills' ) == 1 ):
                $this->unusualkills = $this->get_db_plugin_module_unusualkills();
            else:
                $this->unusualkills = false;
            endif;
        endif;

        if( ! empty( $this->found[ $this->server_group ]['DB_mod'] ) && $this->found[ $this->server_group ]['DB_mod'] == 'RankMeKento' ):

            $this->weapons = $this->get_db_exstats_weapons();

            empty( $this->weapons ) && $this->weapons = ['weapon_knife' => '-','weapon_knife_m9_bayonet' => '-','weapon_knife_butterfly' => '-','weapon_knife_falchion' => '-','weapon_knife_def' => '-','weapon_knife_flip' => '-','weapon_knife_gut' => '-','weapon_knife_push' => '-','weapon_knife_t' => '-','weapon_knife_tactical' => '-'];

            arsort($this->weapons);

            for ( $i = 0; $i < 3; $i++ ):
                $this->top_weapons[ $i ]['name'] = sizeof( $this->weapons ) ? array_search( max( $this->weapons ), $this->weapons ) : 'weapon_knife';
                $this->top_weapons[ $i ]['kills'] = sizeof( $this->weapons ) ?  max( $this->weapons ) : '-';
                unset( $this->weapons[ $this->top_weapons[ $i ]['name'] ] );
            endfor;

            $this->get_db_plugin_module_hits();
        endif;

        $this->msettings = [
            'OP' => [
                'phrase' => '_First_round_kills',
                'icon' => 'fire',
            ],
            'Penetrated' => [
                'phrase' => '_Penetrated_kills',
                'icon' => 'format-valign-top',
            ],
            'NoScope' => [
                'phrase' => '_Killing_without_scope',
                'icon' => 'circle-o',
            ],
            'Run' => [
                'phrase' => '_Kills_on_run',
                'icon' => 'run',
            ],
            'Flash' => [
                'phrase' => '_Kills_flash',
                'icon' => 'eye-off',
            ],
            'Jump' => [
                'phrase' => '_Jump_kills',
                'icon' => 'star-outline',
            ],
            'Smoke' => [
                'phrase' => '_Smoke_kills',
                'icon' => 'mood-bad',
            ],
            'Whirl' => [
                'phrase' => '_Kills_whirl',
                'icon' => 'replay',
            ],
            'LastClip' => [
                'phrase' => '_Kills_last_shoot',
                'icon' => 'repeat-one',
            ]
        ];
    }

    public function get_value() {
        return (int) empty( $this->arr_default_info['value'] ) ? 0 : $this->arr_default_info['value'];
    }

    public function get_steam_32() {
        $type = "/([0-9a-zA-Z_]{7}):([0-9]{1}):([0-9]+)/u";
        preg_match_all($type, $this->steam_32, $arr, PREG_SET_ORDER);
        if ( ! empty( $arr[0][1] ) && ! empty( $arr[0][3] ) ):
            return $arr[0][1] . ':' . $arr[0][2] . ':' . $arr[0][3];
        else:
            return false;
        endif;
    }

    public function get_steam_32_short() {
        $type = "/[0-9a-zA-Z_]{7}:([0-9]{1}):([0-9]+)/u";
        preg_match_all($type, $this->steam_32, $arr, PREG_SET_ORDER);
        if ( ! empty( $arr[0][2] ) ):
            return $arr[0][1] . ':' . $arr[0][2];
        else:
            return false;
        endif;
    }

    public function get_steam_64() {
        return con_steam32to64( $this->get_steam_32() );
    }

    public function get_name() {
        return (string) empty( $this->arr_default_info['name'] ) ? 'Unknown' : $this->arr_default_info['name'];
    }

    public function get_rank() {
        return (int) $this->arr_default_info['rank'] ?? 0;
    }

    public function get_lastconnect() {
        return (int) empty( $this->arr_default_info['lastconnect'] ) ? 0 : gmdate("d-m-Y, H:m", $this->arr_default_info['lastconnect'] );
    }

    public function get_kills() {
        return (int) empty( $this->arr_default_info['kills'] ) ? 0 : $this->arr_default_info['kills'];
    }

    public function get_deaths() {
        return (int) empty( $this->arr_default_info['deaths'] ) ? 0 : $this->arr_default_info['deaths'];
    }

    public function get_kd() {
        $a = empty( $this->get_deaths() ) ? $this->get_kills() : round( $this->get_kills() / $this->get_deaths(), 2);
        return $a . ' ( ' . $this->get_kills() . ' / ' . $this->get_deaths() . ' )';
    }

    public function get_shoots() {
        return (int) empty( $this->arr_default_info['shoots'] ) ? 0 : $this->arr_default_info['shoots'];
    }

    public function get_hits() {
        return (int) empty( $this->arr_default_info['hits'] ) ? 0 : $this->arr_default_info['hits'];
    }

    public function get_percent_hits() {
        $a = 0;
        ! empty( $this->get_shoots() ) && $a = (float) round( 100 * $this->get_hits() / $this->get_shoots() , 1);
        return $a . '% ( ' . $this->get_hits() . ' / ' . $this->get_shoots() . ' )';
    }

    public function get_headshots() {
        return (int) empty( $this->arr_default_info['headshots'] ) ? 0 : $this->arr_default_info['headshots'];
    }

    public function get_percent_headshots() {
        $a = 0;
        ! empty( $this->get_kills() ) && $a = (float) round( 100 * $this->get_headshots() / $this->get_kills() , 1);
        return $this->get_headshots() . ' ( ' . $a . '% )';
    }

    public function get_assists() {
        return (int) $this->arr_default_info['assists'];
    }

    public function get_round_win() {
        return (int) empty( $this->arr_default_info['round_win'] ) ? 0 : $this->arr_default_info['round_win'];
    }

    public function get_round_lose() {
        return (int) empty( $this->arr_default_info['round_lose'] ) ? 0 : $this->arr_default_info['round_lose'];
    }

    public function get_percent_win() {
        $a = 0;
        ! empty( $this->get_round_lose() ) && $a = (float) round( 100 * $this->get_round_win() / ( $this->get_round_win() + $this->get_round_lose() ) , 1);
        return $a . '% ( ' . $this->get_round_win() . ' / ' . $this->get_round_lose() . ' )';
    }

    public function get_playtime() {
        return (int) empty( $this->arr_default_info['playtime'] ) ? 0 : round( $this->arr_default_info['playtime'] / 60 / 60 , 0 );
    }

    public function get_top_position() {
        return (int) $this->top_position;
    }

    public function get_db_top_with_player() {
        if( ! empty( $this->found[ $this->server_group ]['DB_mod'] ) ):
            switch ( $this->found[ $this->server_group ]['DB_mod'] ) {
                case 'LevelsRanks':
                    $a = array_reverse($this->Db->queryAll( 'LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'],"SELECT `name`, rank, steam, `value` FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE '" . $this->get_value() . "' < value ORDER BY value ASC LIMIT 5" ) );
                    $size_a = sizeof( $a );
                    $b = array_merge( $a, $this->Db->queryAll( 'LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'],"SELECT `name`, rank, steam, `value` FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE value <= '" . $this->get_value() . "' ORDER BY value DESC LIMIT 11" ) );
                    $b['countdown_from'] = $this->top_position - $size_a;
                    return $b;
                    break;
                case 'RankMeKento':
                    $a = array_reverse($this->Db->queryAll( 'RankMeKento', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'],"SELECT `name`, steam, score AS `value` FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE '" . $this->get_value() . "' < score ORDER BY score ASC LIMIT 5" ) );
                    $size_a = sizeof( $a );
                    $b = array_merge( $a, $this->Db->queryAll( 'RankMeKento', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'],"SELECT `name`, steam, score AS `value` FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE `score` <= '" . $this->get_value() . "' ORDER BY score DESC LIMIT 11" ) );
                    $b['countdown_from'] = $this->top_position - $size_a;
                    return $b;
                    break;
                case 'FPS':
                    $a = array_reverse($this->Db->queryAll( 'FPS', 0, 0, "SELECT fps_players.nickname AS name,
                                                                                 fps_players.steam_id AS steam,
                                                                                 fps_servers_stats.points AS value,
                                                                                 fps_servers_stats.rank
                                                                                 FROM fps_players
                                                                                 INNER JOIN fps_servers_stats ON fps_players.account_id = fps_servers_stats.account_id
                                                                                 WHERE fps_servers_stats.server_id = '{$this->found[ $this->server_group ]['server_int']}'
                                                                                 AND '{$this->get_value()}' < fps_servers_stats.points
                                                                                 ORDER BY value ASC LIMIT 5" ) );
                    $size_a = sizeof( $a );
                    $b = array_merge( $a, $this->Db->queryAll( 'FPS', 0, 0, "SELECT fps_players.nickname AS name,
                                                                                    fps_players.steam_id AS steam,
                                                                                    fps_servers_stats.points AS value,
                                                                                    fps_servers_stats.rank
                                                                                    FROM fps_players
                                                                                    INNER JOIN fps_servers_stats ON fps_players.account_id = fps_servers_stats.account_id
                                                                                    WHERE fps_servers_stats.points <= '{$this->get_value()}'
                                                                                    AND fps_servers_stats.server_id = '{$this->found[ $this->server_group ]['server_int']}'
                                                                                    ORDER BY value DESC LIMIT 11" ) );
                    $b['countdown_from'] = $this->top_position - $size_a;
                    return $b;
                    break;
            }
        else:
            return [];
        endif;
    }

    private function get_db_arr_default_info() {
        if( ! empty( $this->found[ $this->server_group ]['DB_mod'] ) ):
            switch ( $this->found[ $this->server_group ]['DB_mod'] ) {
                case 'LevelsRanks':
                    return $this->Db->query('LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], "SELECT `name`, rank, steam, playtime, `value`, kills, headshots, deaths, round_win, round_lose, shoots, hits, lastconnect FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE steam LIKE '%" . $this->get_steam_32_short() . "%' LIMIT 1");
                    break;
                case 'RankMeKento':
                    return $this->Db->query('RankMeKento', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], "SELECT `name`, steam, connected AS playtime, score AS `value`, kills, headshots, deaths, match_win AS round_win, match_lose AS round_lose, shots, hits, lastconnect FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE steam LIKE '%" . $this->get_steam_32_short() . "%' LIMIT 1");
                    break;
                case 'FPS':
                    return $this->Db->query('FPS', 0, 0, "SELECT fps_players.steam_id AS steam,
                                                                 fps_players.nickname AS name,
                                                                 fps_servers_stats.kills,
                                                                 fps_servers_stats.deaths,
                                                                 fps_servers_stats.playtime,
                                                                 fps_servers_stats.round_win,
                                                                 fps_servers_stats.round_lose,
                                                                 fps_servers_stats.points AS value,
                                                                 fps_servers_stats.lastconnect,
                                                                 fps_servers_stats.rank,
                                                                 SUM(fps_weapons_stats.shoots) AS shoots,
                                                                 SUM(fps_weapons_stats.headshots) AS headshots,
                                                                 SUM(fps_weapons_stats.hits_head +
                                                                     fps_weapons_stats.hits_neck +
                                                                     fps_weapons_stats.hits_chest +
                                                                     fps_weapons_stats.hits_stomach +
                                                                     fps_weapons_stats.hits_left_arm +
                                                                     fps_weapons_stats.hits_right_arm +
                                                                     fps_weapons_stats.hits_left_leg +
                                                                     fps_weapons_stats.hits_right_leg) AS hits
                                                                 FROM fps_players
                                                                 INNER JOIN fps_servers_stats ON fps_players.account_id = fps_servers_stats.account_id
                                                                 LEFT JOIN fps_weapons_stats ON fps_players.account_id = fps_weapons_stats.account_id
                                                                 WHERE fps_players.steam_id = '{$this->get_steam_64()}'
                                                                 AND fps_servers_stats.server_id = '{$this->found[ $this->server_group ]['server_int']}'
                                                                 LIMIT 1");
                    break;
            }
        else:
            return [];
        endif;
    }

    private function get_db_top_position() {
        if( ! empty( $this->found[ $this->server_group ]['DB_mod'] ) ):
            switch ( $this->found[ $this->server_group ]['DB_mod'] ) {
                case 'LevelsRanks':
                    return $this->Db->query( 'LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'],"SELECT COUNT(1) AS `top` FROM (SELECT DISTINCT `value` FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE `value` >= " . $this->get_value() . " AND `lastconnect` > 0) t;")['top'];
                    break;
                case 'RankMeKento':
                    return $this->Db->query( 'RankMeKento', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'],"SELECT COUNT(1) AS `top` FROM (SELECT DISTINCT `score` FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE `score` >= " . $this->get_value() . " AND `lastconnect` > 0) t;")['top'];
                    break;
                case 'FPS':
                    return $this->Db->query( 'FPS', 0, 0, "SELECT COUNT(1) AS `top` FROM (SELECT DISTINCT `points` FROM fps_servers_stats WHERE `points` >= " . $this->get_value() . " AND server_id = " . $this->found[ $this->server_group ]['server_int'] . " ) t;")['top']+1;
                    break;
            }
        else:
            return [];
        endif;
    }

    private function get_db_exstats_weapons() {
        switch ( $this->found[ $this->server_group ]['DB_mod'] ) {
            case 'LevelsRanks':
                    $a = $this->Db->queryAll('LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], "SELECT classname, kills FROM " . $this->found[ $this->server_group ]['Table'] . "_weapons WHERE steam LIKE '%" . $this->get_steam_32_short() . "%'" );
                    $b = [];
                    for ( $i = 0, $c = sizeof( $a ); $i < $c; $i++ ):
                        $b += [$a[ $i ]['classname'] => $a[ $i ]['kills'] ];
                    endfor;
                    return $b;
                    break;
            case 'RankMeKento':
                    return $this->Db->query('RankMeKento', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], "SELECT knife AS weapon_knife,glock AS weapon_glock,hkp2000 AS weapon_hkp2000,usp_silencer AS weapon_usp_silencer,p250 AS weapon_p250,deagle AS weapon_deagle,elite AS weapon_elite,fiveseven AS weapon_fiveseven,tec9 AS weapon_tec9,cz75a AS weapon_cz75a,revolver AS weapon_revolver,nova AS weapon_nova,xm1014 AS weapon_xm1014,mag7 AS weapon_mag7,sawedoff AS weapon_sawedoff,bizon AS weapon_bizon,mac10 AS weapon_mac10,mp9 AS weapon_mp9,mp7 AS weapon_mp7,ump45 AS weapon_ump45,p90 AS weapon_p90,galilar AS weapon_galilar,ak47 AS weapon_ak47,scar20 AS weapon_scar20,famas AS weapon_famas,m4a1 AS weapon_m4a1,m4a1_silencer AS weapon_m4a1_silencer,aug AS weapon_aug,ssg08 AS weapon_ssg08,sg556 AS weapon_sg556,awp AS weapon_awp,g3sg1 AS weapon_g3sg1,m249 AS weapon_m249,negev AS weapon_negev,hegrenade AS weapon_hegrenade,flashbang AS weapon_flashbang,smokegrenade AS weapon_smokegrenade,inferno AS weapon_inferno,decoy AS weapon_decoy,taser AS weapon_taser FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE steam LIKE '%" . $this->get_steam_32_short() . "%' LIMIT 1" );
                break;
            case 'FPS':
                $a = $this->Db->queryAll('FPS', 0, 0, "SELECT fps_weapons_stats.weapon,
                                                              fps_weapons_stats.kills
                                                              FROM fps_weapons_stats
                                                              INNER JOIN fps_servers_stats ON fps_weapons_stats.account_id = fps_servers_stats.account_id
                                                              WHERE fps_weapons_stats.account_id = '{$this->check_user[ $this->server_group ]['account_id']}'
                                                              AND fps_servers_stats.server_id = '{$this->found[ $this->server_group ]['server_int']}' ");
                $b = [];
                for ( $i = 0, $c = sizeof( $a ); $i < $c; $i++ ):
                    $b += [ 'weapon_' . $a[ $i ]['weapon'] => $a[ $i ]['kills'] ];
                endfor;
                return $b;
                break;
        }
    }

    private function get_db_plugin_module_unusualkills() {
        switch ( $this->found[ $this->server_group ]['DB_mod'] ) {
            case 'LevelsRanks':
            return $this->Db->query('LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], "SELECT OP, Penetrated, NoScope, Run, Jump, Flash, Smoke, Whirl, LastClip FROM " . $this->found[ $this->server_group ]['Table'] . "_unusualkills WHERE SteamID LIKE '%" . $this->get_steam_32_short() . "%' LIMIT 1" );
                break;
            case 'FPS':
                return $this->Db->query('FPS', 0, 0, "SELECT fps_unusualkills.op AS OP,
                                                             fps_unusualkills.penetrated AS Penetrated,
                                                             fps_unusualkills.no_scope AS NoScope,
                                                             fps_unusualkills.run AS Run,
                                                             fps_unusualkills.jump AS Jump,
                                                             fps_unusualkills.flash AS Flash,
                                                             fps_unusualkills.smoke AS Smoke,
                                                             fps_unusualkills.whirl AS Whirl,
                                                             fps_unusualkills.last_clip AS LastClip
                                                             FROM fps_unusualkills
                                                             INNER JOIN fps_players ON fps_unusualkills.account_id = fps_players.account_id
                                                             WHERE fps_players.steam_id = '{$this->get_steam_64()}'
                                                             AND fps_unusualkills.server_id = '{$this->found[ $this->server_group ]['server_int']}' LIMIT 1" );
                break;
        }
    }

    public function get_unusualkills_op() {
        return (int) $this->unusualkills['OP'];
    }

    public function get_unusualkills_penetrated() {
        return (int) $this->unusualkills['Penetrated'];
    }

    public function get_unusualkills_noscope() {
        return (int) $this->unusualkills['NoScope'];
    }

    public function get_unusualkills_run() {
        return (int) $this->unusualkills['Run'];
    }

    public function get_unusualkills_jump() {
        return (int) $this->unusualkills['Jump'];
    }

    public function get_unusualkills_flash() {
        return (int) $this->unusualkills['Flash'];
    }

    public function get_unusualkills_smoke() {
        return (int) $this->unusualkills['Smoke'];
    }

    public function get_unusualkills_whirl() {
        return (int) $this->unusualkills['Whirl'];
    }

    public function get_unusualkills_last_clip() {
        return (int) $this->unusualkills['LastClip'];
    }

    private function get_db_plugin_module_hits() {
        switch ( $this->found[ $this->server_group ]['DB_mod'] ) {
            case 'LevelsRanks':
                $h = [];
                $h = $this->Db->query('LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], "SELECT Head, Chest, Belly, LeftArm, RightArm, LeftLeg, RightLeg, Neak FROM " . $this->found[ $this->server_group ]['Table'] . "_hits WHERE SteamID LIKE '%" . $this->get_steam_32_short() . "%' LIMIT 1" );
                return $this->hits = empty( $h ) ? [] : $h + $this->hits;
            break;
            case 'RankMeKento':
                $h = [];
                $h = $this->Db->query('RankMeKento', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], "SELECT head AS Head, chest AS Chest, stomach AS Belly, left_arm AS LeftArm, right_arm AS RightArm, left_leg AS LeftLeg, right_leg AS RightLeg FROM " . $this->found[ $this->server_group ]['Table'] . " WHERE steam LIKE '%" . $this->get_steam_32_short() . "%' LIMIT 1" );
                return $this->hits = empty( $h ) ? [] : $h + $this->hits;
            break;
            case 'FPS':
                $h = [];
                $h = $this->Db->query('FPS', 0, 0, "SELECT SUM(fps_weapons_stats.hits_head) AS Head,
                                                           SUM(fps_weapons_stats.hits_neck) AS Neak,
                                                           SUM(fps_weapons_stats.hits_chest) AS Chest,
                                                           SUM(fps_weapons_stats.hits_stomach) AS Belly,
                                                           SUM(fps_weapons_stats.hits_left_arm) AS LeftArm,
                                                           SUM(fps_weapons_stats.hits_right_arm) AS RightArm,
                                                           SUM(fps_weapons_stats.hits_left_leg) AS LeftLeg,
                                                           SUM(fps_weapons_stats.hits_right_leg) AS RightLeg
                                                           FROM fps_weapons_stats
                                                           INNER JOIN fps_servers_stats ON fps_weapons_stats.account_id = fps_servers_stats.account_id
                                                           WHERE fps_weapons_stats.account_id = '{$this->check_user[ $this->server_group ]['account_id']}'
                                                          AND fps_servers_stats.server_id = '{$this->found[ $this->server_group ]['server_int']}'
                                                    LIMIT 1");
                return $this->hits = empty( $h ) ? [] : $h + $this->hits;
            break;
        }
    }
    
    public function get_hits_all() {
        return (int) empty( $this->hits ) ? 0 : array_sum ( array_values ( $this->hits ) );
    }
    
    public function get_hits_head() {
        return (int) empty( $this->hits['Head'] ) ? 0 : $this->hits['Head'] . ' (' . action_int_percent_of_all( $this->hits['Head'], $this->get_hits_all() ) . '%)';
    }
    
    public function get_hits_chest() {
        return (int) empty( $this->hits['Chest'] ) ? 0 : $this->hits['Chest'] . ' (' . action_int_percent_of_all( $this->hits['Chest'], $this->get_hits_all() ) . '%)';
    }
    
    public function get_hits_belly() {
        return (int) empty( $this->hits['Belly'] ) ? 0 : $this->hits['Belly'] . ' (' . action_int_percent_of_all( $this->hits['Belly'], $this->get_hits_all() ) . '%)';
    }
    
    public function get_hits_leftarm() {
        return (int) empty( $this->hits['LeftArm'] ) ? 0 : $this->hits['LeftArm'] . ' (' . action_int_percent_of_all( $this->hits['LeftArm'], $this->get_hits_all() ) . '%)';
    }
    
    public function get_hits_rightarm() {
        return (int) empty( $this->hits['RightArm'] ) ? 0 : $this->hits['RightArm'] . ' (' . action_int_percent_of_all( $this->hits['RightArm'], $this->get_hits_all() ) . '%)';
    }
    
    public function get_hits_leftleg() {
        return (int) empty( $this->hits['LeftLeg'] ) ? 0 : $this->hits['LeftLeg'] . ' (' . action_int_percent_of_all( $this->hits['LeftLeg'], $this->get_hits_all() ) . '%)';
    }
    
    public function get_hits_rightleg() {
        return (int) empty( $this->hits['RightLeg'] ) ? 0 : $this->hits['RightLeg'] . ' (' . action_int_percent_of_all( $this->hits['RightLeg'], $this->get_hits_all() ) . '%)';
    }
    
    public function get_hits_neak() {
        return (int) empty( $this->hits['Neak'] ) ? 0 : $this->hits['Neak'] . ' (' . action_int_percent_of_all( $this->hits['Neak'], $this->get_hits_all() ) . '%)';
    }
    
    private function get_db_plugin_module_maps() {
          $a = $this->Db->queryAll('LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], "SELECT name_map, `rounds_ct` + `rounds_t` AS rounds_win FROM " . $this->found[ $this->server_group ]['Table'] . "_maps WHERE steam LIKE '%" . $this->get_steam_32_short() . "%'" );
          $b = [];
          for ( $i = 0, $c = sizeof( $a ); $i < $c; $i++ ):
                $b += [ $a[ $i ]['name_map'] => $a[ $i ]['rounds_win'] ];
          endfor;
          return $b;
    }

    private function get_db_plugin_module_geoip() {
        $a = $this->Db->query('LevelsRanks', $this->found[ $this->server_group ]['USER_ID'], $this->found[ $this->server_group ]['DB'], "SELECT country, city FROM " . $this->found[ $this->server_group ]['Table'] . "_geoip WHERE steam LIKE '%" . $this->get_steam_32_short() . "%' LIMIT 1" );

        return $a['country'] . ', ' . $a['city'];
    }
    
    /**
     * Задать статус профиля.
     *
     * @param string $text           Статус.
     */
    public function set_profile_status( $text, $color, $priority = 0) {
        $this->profile_status = [ 'text' => $text, 'color' => $color, 'priority' => $priority];
    }

    /**
     * Получить статус профиля.
     *
     * @return array                 Массив со статусом.
     */
    public function get_profile_status() {
        return $this->profile_status;
    }
}