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
     * @var array
     */
    public $arr_general = [];

    /**
     * @var array
     */
    public $server_list = [];

    /**
     * @var int
     */
    public $server_list_count = 0;


    /**
     * Инициализация основных настроек.
     */
    function __construct() {
        // Получение настроек вэб-интерфейса.
        $this->arr_general = $this->get_default_options();

        if( isset( $_POST['btn_search'] ) && IN_LR == true ) {

            $search = substr( $_POST['_steam_id'], 0, 7) === "STEAM_0" ? str_replace("STEAM_0", "STEAM_1", $_POST['_steam_id'] ) : $_POST['_steam_id'];

            header( 'Location: ' . $this->arr_general['site'] . '/?page=profiles&search=1&profile=' . $search );
            exit;
        }

        // Получение списка игровых серверов.
        $this->server_list = $this->get_server_list();

        // Общее количество игровых серверов.
        $this->server_list_count = get_arr_size( $this->server_list );

        // Получение языка страницы.
        $this->get_default_url_section('language', $this->arr_general['language'], array( 'RU', 'EN', 'UA', 'LT', 'DE', 'CH' ) );

        // Получение информации об использовании тёмного интерфейса.
        $this->get_default_url_section('dark_mode', $this->arr_general['dark_mode'], array( true, false ) );

        // Получение информации о состоянии сайт-бара.
        $this->get_default_url_section('sidebar_open', $this->arr_general['sidebar_open'], array( true, false ) );
    }

    /**
     * Получает и задает название подраздела из URL по умолчанию, сохраняя результат по умолчанию в сессию.
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
     * @param  string      $profile    Steam ID игрока
     * @param  int         $type       Тип/Размер аватара.
     *
     * @return string                  Выводит ссылку на аватар если он существует.
     */
    public function getAvatar( $profile, $type ) {
        $url = ( $type == 1 ) ? CACHE . 'img/avatars/' . $profile . '.jpg' : CACHE . 'img/avatars/slim/' . $profile . '.jpg';
        switch ( $type ) {
            case 1:
                if ( file_exists( $url ) && $this->arr_general['avatars'] == 1 ):
                    return $url;
                elseif ( ! file_exists( $url ) || $this->arr_general['avatars'] == 0 || $this->arr_general['avatars'] == 2 ):
                    return 'storage/cache/img/avatars_random/' . rand(1,30) . '.jpg';
                endif;
                break;
            case 2:
                if ( file_exists( $url ) && $this->arr_general['avatars'] == 1 ):
                    return $url;
                elseif ( ! file_exists( $url ) || $this->arr_general['avatars'] == 0 || $this->arr_general['avatars'] == 2 ):
                    return 'storage/cache/img/avatars_random/' . rand(1,30) . '_xs.jpg';
                endif;
                break;
        }
    }

    /**
     * Проверка на существование определеноого аватара и его актуальность.
     *
     * @param  string       $profile    Steam ID игрока
     * @param  int          $type       Тип/Размер аватара.
     *
     * @return int                      Выводит итог проверки.
     */
    public function checkAvatar( $profile, $type ) {
        $url = CACHE . 'img/avatars/' . $profile . '.jpg';
        $url_slim = CACHE . 'img/avatars/slim/' . $profile . '.jpg';
        switch ( $type ) {
            case 1:
                if ( file_exists( $url ) ):
                    if ( time() >= filemtime( $url ) + $this->arr_general['avatars_cache_time'] ):
                        unlink( $url );
                        file_exists( $url_slim ) && unlink( $url_slim );
                        return 1;
                    else:
                        return 0;
                    endif;
                else:
                    return 1;
                endif;
                break;
            case 2:
                if ( file_exists( $url_slim ) ):
                    if ( time() >= filemtime( $url_slim ) + $this->arr_general['avatars_cache_time'] ):
                        unlink( $url_slim );
                        file_exists( $url ) && unlink( $url );
                        return 1;
                    else:
                        return 0;
                    endif;
                else:
                    return 1;
                endif;
                break;
        }
    }

    /**
     * Получение настроек по умолчанию для вэб-интерфейса.
     *
     * @return array                 Массив с настройками.
     */
    public function get_default_options() {
        $options = file_exists( SESSIONS . '/options.php' ) ? require SESSIONS . '/options.php' : header( 'Location: ' . get_url(2) . '/app/page/custom/install/index.php' );
        return empty( $options ) ? header( 'Location: ' . get_url(2) . '/app/page/custom/install/index.php' ) : $options;
    }

    /**
     * Получение списка серверов.
     *
     * @return array                 Массив со списком серверов.
     */
    public function get_server_list() {
        return file_exists( SESSIONS . 'servers_list.php' ) ? require SESSIONS . 'servers_list.php' : file_put_contents( SESSIONS . 'servers_list.php', '<?php return []; ' );
    }

    /**
     * Получение иконок и работа с ними.
     *
     * @param string $group         Название папки из которой будет читаться иконка.
     * @param string $name          Название иконки.
     * @param string $category      Дополнительное название под-категории, если она имеется. По умолчанию нету.
     *
     * @return string|false         Выводит содержимое SVG файла.
     */
    function get_icon( $group, $name, $category = null ) {
        return print $category == null ? '<i class="zmdi zmdi-' . $name . ' zmdi-hc-fw"></i>' : '<img src="' . CACHE . 'img/icons/' . $group . '/' . $category . '/' . $name . '.svg" class=svg>';
    }

    /**
     * Вывод JS скрипта на проверку актуальности аватара.
     *
     * @param  string   $id      Steam ID - 32.
     * @param  int      $type    Тип аватара.
     *
     * @return string            Скрипт.
     */
    function get_js_relevance_avatar( $id, $type = 2 ) {
        if ( $this->arr_general['avatars'] == 1 ):
            $con = $id[0] == 'S' ? con_steam32to64( $id ) : $id;
            $check = (int) $this->checkAvatar( $con, $type );
            echo sprintf('<script>CheckAvatar = %1$d; if (CheckAvatar == 1) { avatar.push("%2$s"); }</script>', $check, $con );
        endif;
    }
}