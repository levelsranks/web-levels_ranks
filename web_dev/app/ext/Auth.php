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

class Auth {

    /**
     * @var array
     */
    public    $user_auth = [];

    /**
     * @var array
     */
    public    $server_info = [];

    /**
     * @var array
     */
    public    $base_info = [];

    /**
     * @var array
     */
    public    $lastconnect = [];

    /**
     * @var array
     */
    public    $res_data_sidebar = [];

    /**
     * @var int
     */
    public    $user_rank_count = 0;

    function __construct( $General, $Db ) {

        $this->General = $General;

        $this->Db = $Db;

        $this->admins = $this->get_admins_list();

        $this->admins_count = sizeof( $this->admins );

        if ( ! empty( $_SESSION['steamid'] ) ):
            if ( $_SESSION['USER_AGENT'] != $_SERVER['HTTP_USER_AGENT'] || $_SESSION['REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR']  ):
                session_unset() && session_destroy() && die('Fake request');
            endif;
        endif;

        // получение информации об авторизации по Steam.
        isset( $_GET["auth"] ) && $this->General->arr_general['steam_auth'] == 1 && in_array( $_GET["auth"], array( 'login', 'logout' ) ) && require 'app/includes/auth/steam.php';

        $this->General->arr_general['steam_only_authorization'] === 0 && $this->_POST();

        isset( $_SESSION['steamid'] ) && $this->get_authorization_sidebar_data();
    }

    /**
     * Получение списка администраторов.
     *
     * @return array                 Массив с администраторами..
     */
    public function get_admins_list() {
        if ( file_exists( SESSIONS . '/admins.php' ) ):
            return require SESSIONS . '/admins.php';
        else:
            file_put_contents( SESSIONS . 'admins.php', '<?php return [];' );
            return [];
        endif;

    }

    public function _POST() {
        if( isset( $_POST['log_in'] ) && ! empty( $this->admins ) ) {
            empty( $_POST['_login'] ) && exit;
            for ( $i = 0; $i < $this->admins_count; $i++ ) {
                if($this->admins[$i]['login'] == action_text_clear( $_POST['_login'] ) && $this->admins[$i]['pass'] == action_text_clear( $_POST['_pass'] ) ) {
                    $_SESSION['steamid'] = con_steam32to64( $this->General->arr_general['admin'] );
                    $_SESSION['steamid32'] = $this->General->arr_general['admin'];
                    preg_match_all("/[0-9a-zA-Z_]{7}:([0-9]{1}):([0-9]+)/u", $_SESSION['steamid32'], $arr, PREG_SET_ORDER);
                    $_SESSION['steamid32_short'] = $arr[0][1] . ':' . $arr[0][2];
                    $_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
                    $_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
                    header( 'Location: ' . get_url(1) . '#' );
                    exit;
                }
            }
            header( 'Location: ' . get_url(1) );
            exit;
        }

    }

    public function get_authorization_sidebar_data() {

        if ( ! empty( $this->Db->db_data['LevelsRanks'] ) ):
            // С помощью цикла делаем запросы к базе данных.
            for ($d = 0; $d < $this->Db->table_count['LevelsRanks']; $d++) {
                $this->res_data_sidebar[ $d ] = ['name_servers' => $this->Db->db_data['LevelsRanks'][ $d ]['name'],
                    'mod' => $this->Db->db_data['LevelsRanks'][ $d ]['mod'],
                    'ranks_pack' => $this->Db->db_data['LevelsRanks'][ $d ]['ranks_pack'],
                    'data_servers' => $this->Db->db_data['LevelsRanks'][ $d ]['Table']];
                $this->base_info = $this->Db->query('LevelsRanks', $this->Db->db_data['LevelsRanks'][ $d ]['USER_ID'], $this->Db->db_data['LevelsRanks'][ $d ]['DB_num'], 'SELECT name, lastconnect, rank FROM ' . $this->Db->db_data['LevelsRanks'][ $d ]["Table"] . ' WHERE steam LIKE "%' . $_SESSION['steamid32_short'] . '%" LIMIT 1');
                if ($this->base_info != '') {
                    $this->user_auth[] = $this->base_info;
                    $this->server_info[] = $this->res_data_sidebar[ $d ];
                    $this->lastconnect[] = $this->base_info['lastconnect'];
                }
            }
        endif;
        if ( ! empty( $this->Db->db_data['FPS'] ) ):
            // С помощью цикла делаем запросы к базе данных.
            for ( $d = 1; $d <= $this->Db->table_count['FPS']; $d++ ) {
                $this->res_data_sidebar[ $d ] = ['name_servers' => $this->Db->db_data['FPS'][$d - 1]['name'],
                    'mod' => 'csgo',
                    'ranks_id' => $this->Db->db_data['FPS'][$d - 1]['ranks_id'],
                    'ranks_pack' => $this->Db->db_data['FPS'][$d - 1]['ranks_pack']
                ];
                $this->base_info = $this->Db->query('FPS', 0, 0, 'SELECT fps_players.nickname AS name,
                                                                         fps_servers_stats.rank
                                                                         FROM fps_players
                                                                         INNER JOIN fps_servers_stats ON fps_players.account_id = fps_servers_stats.account_id
                                                                         WHERE steam_id="' . $_SESSION['steamid'] . '"
                                                                         AND fps_servers_stats.server_id = ' . $d . '
                                                                         LIMIT 1');
                if ($this->base_info != '') {
                    $this->user_auth[] = $this->base_info;
                    $this->server_info[] = $this->res_data_sidebar[ $d ];
                    $this->lastconnect[] = $this->base_info['lastconnect'];
                }
            }
        endif;
        if ( empty( $this->user_auth[0] ) ) {
            $this->user_auth[0] = ['name' => 'Неизвестно', 'lastconnect' => '', 'rank' => '00'];
            $this->lastconnect = '-';
            $this->server_info[0]['name_servers'] = 'Неизвестно';
            $this->server_info[0]['ranks_pack'] = 'default';
        }
        $this->user_rank_count = sizeof($this->user_auth);
    }
}