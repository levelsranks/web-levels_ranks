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

class General {

    /**
     * @since 0.2
     * @var array
     */
    public $arr_general = [];

    /**
     * @since 0.2
     * @var array
     */
    public $notes = [];

    /**
     * @since 0.2
     * @var array
     */
    public $server_list = [];

    /**
     * @since 0.2
     * @var int
     */
    public $server_list_count = 0;

    /**
     * Инициализация основных настроек.
     *
     * @param object $Db
     *
     * @since 0.2
     */
    function __construct( $Db ) {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        //Проверка на iframe
        (!empty($_GET['code']) && !empty($_GET['description'])) && exit(require PAGE_CUSTOM . '/error/index.php');

        $this->Db = $Db;

        // Получение настроек вэб-интерфейса.
        $this->arr_general = $this->get_default_options();

        if( isset( $_POST['btn_search'] ) && IN_LR == true ) {

            $search = substr( $_POST['_steam_id'], 0, 7) === "STEAM_0" ? str_replace("STEAM_0", "STEAM_1", $_POST['_steam_id'] ) : $_POST['_steam_id'];

            header( 'Location: ' . $this->arr_general['site'] . 'profiles/' . $search . '/?search=1' );
            exit;
        }

        // Получение списка игровых серверов.
        $this->server_list = $this->get_server_list();

        // Общее количество игровых серверов.
        $this->server_list_count = get_arr_size( $this->server_list );

        // Получение языка страницы.
        $this->get_default_url_section('language', $this->arr_general['language'], array( 'RU', 'EN', 'UA', 'LT', 'DE', 'CH','PT', 'RS', 'BA', 'CRO' ) );

        // Получение информации о состоянии сайт-бара.
        $this->get_default_url_section('sidebar_open', $this->arr_general['sidebar_open'], array( true, false ) );

    }

    /**
     * Получает и задает название подраздела из URL по умолчанию, сохраняя результат по умолчанию в сессию.
     *
     * @since 0.2
     *
     * @param string|bool       $section       Название подраздела.
     * @param string            $default       Значние по умолчанию.
     * @param array|null        $arr_true      Белый список.
     *
     */
    public function get_default_url_section( $section, $default, $arr_true ) {
        ! isset( $_SESSION[ $section ] ) && $_SESSION[ $section ] = $default;
        isset ( $_GET[ $section ] ) && in_array( $_GET[ $section ], $arr_true ) && $_SESSION[ $section ] = $_GET[ $section ];
    }

    /**
     * Получает определенного аватара.
     *
     * @since 0.2
     *
     * @param  string      $profile    Steam ID игрока
     * @param  int         $type       Тип/Размер аватара.
     *
     * @return string                  Выводит ссылку на аватар если он существует.
     */
    public function getAvatar( $profile, $type ) {
        $url = CACHE . 'img/avatars/' . $profile . '.json';
        switch ( $type ) {
            case 1:
                if ( file_exists( $url ) && $this->arr_general['avatars'] == 1 ):
                    $file = json_decode(file_get_contents($url), true);
                    return $file['avatar'];
                elseif ( ! file_exists( $url ) || $this->arr_general['avatars'] == 0 || $this->arr_general['avatars'] == 2 ):
                    return $this->arr_general['site'] . 'storage/cache/img/avatars_random/' . rand(1,30) . '.jpg';
                endif;
                break;
            case 2:
                if ( file_exists( $url ) && $this->arr_general['avatars'] == 1 ):
                    $file = json_decode(file_get_contents($url), true);
                    return $file['slim'];
                elseif ( ! file_exists( $url ) || $this->arr_general['avatars'] == 0 || $this->arr_general['avatars'] == 2 ):
                    return $this->arr_general['site'] .'storage/cache/img/avatars_random/' . rand(1,30) . '_xs.jpg';
                endif;
                break;
        }
    }

    /**
     * Проверка на существование определеноого аватара и его актуальность.
     *
     * @since 0.2
     *
     * @param  string       $profile    Steam ID игрока
     * @param  int          $type       Тип/Размер аватара.
     *
     * @return int                      Выводит итог проверки.
     */
    public function checkAvatar( $profile, $type ) {
        $url = CACHE . 'img/avatars/' . $profile . '.json';
        if( $type == 1 ) {
            if ( file_exists( $url ) ):
                if ( time() >= filemtime( $url ) + $this->arr_general['avatars_cache_time'] ):
                    unlink( $url );
                    return 1;
                else:
                    return 0;
                endif;
            else:
                return 1;
            endif;
        }
    }

    /**
     * Получение никнейма игрока.
     *
     * @since 0.2
     *
     * @param  string       $profile    Steam ID игрока
     *
     * @return string                   Выводит итог проверки.
     */
    public function checkName( $profile ) {
        $url = CACHE . 'img/avatars/' . $profile . '.json';
        if ( file_exists( $url ) ) {
            $file = json_decode(file_get_contents($url), true);
            return $file['name'];
        } else {
            $this->getAvatar($profile, 1);
            return false;
        }
    }

    /**
     * Отправка уведомлений через функцию.
     *
     * @since 0.2
     *
     * @return bool                 true
     */
    public function sendNote($text, $status, $time = 4.5)
    {
        $this->notes[] = [
            'content' => $text,
            'status' => $status,
            'time' => $time,
        ];
    }

    /**
     * Получение настроек по умолчанию для вэб-интерфейса.
     *
     * @since 0.2
     *
     * @return array                 Массив с настройками.
     */
    public function get_default_options() {
        $options = file_exists( SESSIONS . '/options.php' ) ? require SESSIONS . '/options.php' : null;
        return !isset( $options['animations'] ) ? exit(require 'app/page/custom/install/index.php') : $options;
    }

    /**
     * Получение списка серверов.
     *
     * @return array                 Массив со списком серверов.
     */
    public function get_server_list() {
        return $this->Db->queryAll( 'Core', 0, 0,'SELECT * FROM lvl_web_servers' );
    }

    /**
     * Получение иконок и работа с ними.
     *
     * @since 0.2
     *
     * @param  string $group     Название папки из которой будет читаться иконка.
     * @param  string $name      Название иконки.
     * @param  string $category  Дополнительное название под-категории, если она имеется. По умолчанию нету.
     *
     * @return string|false      Выводит содержимое SVG файла.
     */
    function get_icon( $group, $name, $category = null ) {
        return print $category == null ? '<i class="zmdi zmdi-' . $name . ' zmdi-hc-fw"></i>' : '<img src="' . $this->arr_general['site'] . CACHE . 'img/icons/' . $group . '/' . $category . '/' . $name . '.svg" class=svg>';
    }

    /**
     * Вывод JS скрипта на проверку актуальности аватара.
     *
     * @since 0.2
     * 
     * @param  string   $id      Steam ID - 32.
     * @param  int      $type    Тип аватара.
     *
     * @return string            Скрипт.
     */
    function get_js_relevance_avatar( $id, $type = 1 ) {
        if ( $this->arr_general['avatars'] == 1 ):
            $con = is_numeric( $id ) ? $id : con_steam32to64( $id );
            $check = (int) $this->checkAvatar( $con, $type );
            echo sprintf('<script>CheckAvatar = %1$d; if (CheckAvatar == 1) { avatar.push("%2$s"); }</script>', $check, $con );
        endif;
    }


    /**
    * Счетчик посещений
    */
    public function online_stats()
    {
        if(isset($_SESSION['steamid32']))
            $User = $_SESSION['steamid32'];
        else $User = 'guest';


        $param['ip'] = $_SERVER['REMOTE_ADDR'];
        $Online = $this->Db->queryOneColumn( 'Core', 0, 0, "SELECT user FROM lr_web_online WHERE ip = :ip", $param );

        if(empty($Online))
        {
            $params = [
                'user'  => $User,
                'ip'    => $_SERVER['REMOTE_ADDR']
            ];
            $this->Db->query('Core', 0, 0, "INSERT INTO lr_web_online(id, user, ip, time) VALUES (NULL, :user, :ip, NOW())", $params );
        }
        else
        {
            if($Online != $User)
            {
                $params = [
                    'user'  => $User,
                    'ip'    => $_SERVER['REMOTE_ADDR']
                ];
                $this->Db->query('Core', 0, 0, 'UPDATE lr_web_online SET time = NOW(), user = :user WHERE ip = :ip', $params );
            }
            else
            {
                $this->Db->query('Core', 0, 0, "UPDATE lr_web_online SET time = NOW() WHERE  ip = :ip", $param );
            }
        }

        $this->Db->query('Core', 0, 0, "DELETE FROM lr_web_online WHERE time < SUBTIME(NOW(), '0 0:05:0')" );

        $_Param['date'] = date('m.Y');

        $_Attendance_ID = $this->Db->queryOneColumn( 'Core', 0, 0, 'SELECT id FROM lr_web_attendance WHERE date = :date', $_Param );

        if($_Attendance_ID)
        {   
            $_ParamU['id'] = $_Attendance_ID;
            $this->Db->query( 'Core', 0, 0, "UPDATE lr_web_attendance SET visits = visits + 1 WHERE id = :id", $_ParamU );
        }
        else 
        {
            $this->Db->query( 'Core', 0, 0, "INSERT INTO lr_web_attendance(id, date, visits) VALUES (NULL, :date, 1)", $_Param );
        }
    }
}
