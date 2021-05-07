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
     * @since 0.2
     * @var array
     */
    public    $user_auth = [];

    /**
     * @since 0.2
     * @var array
     */
    public    $server_info = [];

    /**
     * @since 0.2
     * @var array
     */
    public    $base_info = [];

    /**
     * @since 0.2
     * @var array
     */
    public    $lastconnect = [];

    /**
     * @since 0.2
     * @var int
     */
    public    $user_rank_count = 0;

    /**
     * @since 0.2
     * @var array
     */
    private   $admins = 0;

    /**
     * @since 0.2
     * @var int
     */
    public    $admins_count = 0;

    /**
     * @since 0.2
     * @var object
     */
    public    $General;

    /**
     * @since 0.2
     * @var object
     */
    public    $Db;

    /**
     * Организация работы вэб-приложения с авторизацией.
     *
     * @param object $General
     * @param object $Db
     *
     * @since 0.2
     */
    function __construct( $General, $Db ) {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        // Импорт основного класса.
        $this->General = $General;

        // Импорт класса отвечающего за работу с базой данных.
        $this->Db = $Db;

        // Работа с авторизованным пользователем.
        if( isset( $_SESSION['steamid'] ) ):
            // Проверка сессии.
            $General->arr_general['session_check'] === 1 && $this->check_session();

            // Проверка авторизованного пользователя.
            ! isset( $_SESSION['user_admin'] ) && $this->check_session_admin();

            // Получение информации о авторизованном пользователе.
            $this->get_authorization_sidebar_data();
        endif;

        // Работа со Steam авторизацией.
        if(isset( $_GET["auth"] ))
        {
            if($this->General->arr_general['steam_auth'] == 1 && $_GET["auth"] == 'login') require 'app/includes/auth/steam.php';
        }

        // Работа с No-Steam авторизацией
        isset( $_POST['log_in'] ) && ! empty( $_POST['_login'] ) && ! empty( $_POST['_pass'] ) && $this->General->arr_general['steam_only_authorization'] === 0 && $this->authorization_no_steam();

        // Выход пользователя из аккаунта.
        isset( $_GET["auth"] ) && $_GET["auth"] == 'logout' && require 'app/includes/auth/steam.php';

        ( $General->arr_general['auth_cock'] == 1 && !empty($_SESSION) && empty($_COOKIE['session']) ) && $this->check_cookie();

        ( $General->arr_general['auth_cock'] == 1 && empty($_SESSION) && !empty($_COOKIE['session']) ) && $this->auth_cookie();

        if( $General->arr_general['auth_cock'] == 0 && !empty( $_COOKIE['session'] ) )
            unset($_COOKIE['session']);
    }

    // Запись в куки данных о сессии
    private function check_cookie()
    {
        foreach ($_SESSION as $key => $val)
        {
            setcookie("session[".$key."]", $val, strtotime('+1 day'));
        }
    }

    // Авторизация пользователя с помощью куки
    private function auth_cookie()
    {
        $_SESSION = $_COOKIE['session'];
        refresh();
    }

    /**
     * Получение списка администраторов.
     *
     * @return array  Массив с администраторами.
     */
    public function get_admins_list() {
        return $this->admins = $this->Db->queryAll( 'Core', 0, 0, 'SELECT `steamid`, `group`, `flags`, `access` FROM lvl_web_admins' );
    }

    /**
     * Получение количества администраторов.
     *
     * @since 0.2.120
     *
     * @return int    Количество администрации.
     */
    public function get_count_admins() {
        return $this->admins_count = sizeof( $this->admins );
    }

    /**
     * Проверка авторизованного пользователя на принадлежность ко списку администраторов.
     *
     * @since 0.2.120
     */
    public function check_session_admin() {
        $result = $this->Db->query( 'Core', 0, 0,"SELECT `steamid`, `group`, `flags`, `access` FROM lvl_web_admins WHERE steamid={$_SESSION['steamid']} LIMIT 1" );
        if( ! empty( $result ) ):
            $_SESSION['user_admin'] = 1;
            $_SESSION['user_group'] = $result['group'];
            $_SESSION['user_access'] = $result['access'];
            $_SESSION['user_flags'] = $result['flags'];
        endif;
    }

    /**
     * Проверка печенек авторизованного пользователя.
     *
     * @since 0.2.120
     */
    public function check_session() {
        if ( $_SESSION['USER_AGENT'] != $_SERVER['HTTP_USER_AGENT'] || $_SESSION['REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR'] ):
            session_unset() && session_destroy() && refresh();
        endif;
    }

    /**
     * Авторизация администратора по логину и паролю.
     *
     * @since 0.2.120
     */
    public function authorization_no_steam() {
        // Параметры к запросу.
        $params = ['user' => action_text_clear( $_POST['_login'] ), 'password' => action_text_clear( $_POST['_pass'] )];

        // Запрос на проверку пользователя.
        $result = $this->Db->query('Core', 0, 0, "SELECT `steamid`, `group`, `flags`, `access` FROM lvl_web_admins WHERE user = :user AND password = :password", $params );

        // Сверка результата запроса.
        if ( ! empty( $result ) ):
            // Пользователь. Общее значение - Steam ID 32.
            $_SESSION['steamid'] = con_steam64to32( $result['steamid'] );

            // Пользователь. Steam ID 32.
            $_SESSION['steamid32'] = con_steam64to32( $result['steamid'] );

            // Пользователь. Steam ID 64.
            $_SESSION['steamid64'] = con_steam32to64 ($result['steamid'] );

            // Пользователь. Заголовок User-Agent.
            $_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];

            // Пользователь. IP.
            $_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];

            // Пользователь. Steam ID 32 ( Сокращенный ).
            preg_match_all("/[0-9a-zA-Z_]{7}:([0-9]{1}):([0-9]+)/u", $_SESSION['steamid'], $arr, PREG_SET_ORDER);
            $_SESSION['steamid32_short'] = $arr[0][1] . ':' . $arr[0][2];

            // Пользователь. Административная инфомация.
            $_SESSION['user_admin'] = 1;
            $_SESSION['user_group'] = $result['group'];
            $_SESSION['user_access'] = $result['access'];
            $_SESSION['user_flags'] = $result['flags'];
        endif;

        // Обновление страницы.
        refresh();
    }

    /**
     * Получение информации о авторизованном пользователе для вывода данных в боковую панель.
     *
     * @since 0.2
     */
    public function get_authorization_sidebar_data() {
        // Проверка на подключенный мод - Levels Ranks.
        if ( ! empty( $this->Db->db_data['LevelsRanks'] ) ):
            // Перебор всех таблиц с модом - Levels Ranks
            for ( $d = 0; $d < $this->Db->table_count['LevelsRanks']; $d++ ):
                // Запрос о получении информации об авторизовавшемся пользователе.
                $this->base_info = $this->Db->query('LevelsRanks', $this->Db->db_data['LevelsRanks'][ $d ]['USER_ID'], $this->Db->db_data['LevelsRanks'][ $d ]['DB_num'], "SELECT name, lastconnect, rank FROM {$this->Db->db_data['LevelsRanks'][ $d ]["Table"]} WHERE steam LIKE '%{$_SESSION['steamid32_short']}%' LIMIT 1");

                // Если Пользователь  находится в таблице, заполняем итоговый массив.
                if ( ! empty( $this->base_info ) ):
                    // Базовая информация о пользователе.
                    $this->user_auth[] = $this->base_info;

                    // Информация о таблице.
                    $this->server_info[] = ['name_servers' => $this->Db->db_data['LevelsRanks'][ $d ]['name'],
                        'mod' => $this->Db->db_data['LevelsRanks'][ $d ]['mod'],
                        'ranks_pack' => $this->Db->db_data['LevelsRanks'][ $d ]['ranks_pack'],
                        'data_servers' => $this->Db->db_data['LevelsRanks'][ $d ]['Table']
                    ];
                endif;
            endfor;
        endif;

        // Проверка на подключенный мод - FPS
        if ( ! empty( $this->Db->db_data['FPS'] ) ):
            // Перебор всех таблиц с модом - FPS.
            for ( $d = 1; $d <= $this->Db->table_count['FPS']; $d++ ):

                // Запрос о получении информации об авторизовавшемся пользователе.
                $this->base_info = $this->Db->query('FPS', 0, 0, "SELECT fps_players.nickname AS name,
                                                                         fps_servers_stats.rank,
                                                                         fps_servers_stats.lastconnect
                                                                         FROM fps_players
                                                                         INNER JOIN fps_servers_stats ON fps_players.account_id = fps_servers_stats.account_id
                                                                         WHERE steam_id={$_SESSION['steamid']} AND fps_servers_stats.server_id ={$d}
                                                                         LIMIT 1");
                if ( ! empty( $this->base_info ) ):
                    // Базовая информация о пользователе.
                    $this->user_auth[] = $this->base_info;

                    // Информация о таблице.
                    $this->server_info[] = ['name_servers' => $this->Db->db_data['FPS'][ $d - 1 ]['name'],
                        'mod' => 'csgo',
                        'ranks_id' => $this->Db->db_data['FPS'][ $d - 1 ]['ranks_id'],
                        'ranks_pack' => $this->Db->db_data['FPS'][ $d - 1 ]['ranks_pack']
                    ];
                endif;
            endfor;
        endif;

        // Проверка на подключенный мод - RankMeKento.
        if ( ! empty( $this->Db->db_data['RankMeKento'] ) ):
            // Перебор всех таблиц с модом - Levels Ranks
            for ( $d = 0; $d < $this->Db->table_count['RankMeKento']; $d++ ):
                // Запрос о получении информации об авторизовавшемся пользователе.
                $this->base_info = $this->Db->query('RankMeKento', $this->Db->db_data['RankMeKento'][ $d ]['USER_ID'], $this->Db->db_data['RankMeKento'][ $d ]['DB_num'], "SELECT name, lastconnect FROM {$this->Db->db_data['RankMeKento'][ $d ]["Table"]} WHERE steam LIKE '%{$_SESSION['steamid32_short']}%' LIMIT 1");

                // Если Пользователь  находится в таблице, заполняем итоговый массив.
                if ( ! empty( $this->base_info ) ):
                    // Базовая информация о пользователе.
                    $this->user_auth[] = $this->base_info;

                    // Информация о таблице.
                    $this->server_info[] = ['name_servers' => $this->Db->db_data['RankMeKento'][ $d ]['name'],
                        'mod' => $this->Db->db_data['RankMeKento'][ $d ]['mod'],
                        'ranks_pack' => $this->Db->db_data['RankMeKento'][ $d ]['ranks_pack'],
                        'data_servers' => $this->Db->db_data['RankMeKento'][ $d ]['Table']
                    ];
                endif;
            endfor;
        endif;

        // For translating hardcoded string
        $Translate      = new \app\ext\Translate;
        
        // При отсутствии пользователя в таблицах, собираем - массив исключение.
        if ( empty( $this->user_auth[0] ) ):
            // Информация о пользователе.
            $this->user_auth[0] = ['name' => $Translate->get_translate_phrase('_Unknown'), 'lastconnect' => '', 'rank' => '00'];

            // Название сервера.
            $this->server_info[0]['name_servers'] = $Translate->get_translate_phrase('_Unknown');

            // Пак рангов.
            $this->server_info[0]['ranks_pack'] = 'default';
        endif;

        // Считаем количество таблиц с найденым пользователем.
        $this->user_rank_count = sizeof( $this->user_auth );

        $datetime = [];

        for ( $d = 0; $d < $this->user_rank_count; $d++ ):
            $datetime[] = $this->user_auth[ $d ]['lastconnect'];
        endfor;

        // Последнее актуальное подклчюение пользователя.
        $this->user_auth[0]['lastconnect_max'] = max( $datetime );
    }
}
