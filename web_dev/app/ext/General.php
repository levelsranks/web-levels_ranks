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
     * Инициализация основных настроек.
     */
    function __construct( $Modules ) {

        $this->Modules = $Modules;

        // Получение настроек вэб-интерфейса.
        $this->arr_general = $this->get_default_options();

        if( isset( $_POST['btn_search'] ) && IN_LR == true ) {

            $search = substr( $_POST['_steam_id'], 0, 7) === "STEAM_0" ? str_replace("STEAM_0", "STEAM_1", $_POST['_steam_id'] ) : $_POST['_steam_id'];

            header( 'Location: ' . $this->arr_general['site'] . '/?page=profiles&search=1&profile=' . $search );
            exit;
        }

        ! file_exists( SESSIONS . 'servers_list.php' ) && file_put_contents( SESSIONS . 'servers_list.php', '<?php return []; ' );

        // Получение списка игровых серверов.
        $this->server_list = require SESSIONS . 'servers_list.php';

        // Общее количество игровых серверов.
        $this->server_list_count = sizeof( $this->server_list );

        // Получение языка страницы.
        $this->get_default_url_section('language', $this->arr_general['language'], array( 'RU', 'EN', 'UA', 'LT' ) );

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
     * @param string       $profile    Steam ID игрока
     * @param int          $type       Тип/Размер аватара.
     *
     * @return string                  Выводит ссылку на аватар если он существует.
     */
    public function getAvatar( $profile, $type ) {
        $url = ( $type == 1 ) ? CACHE . 'img/avatars/' . $profile . '.jpg' : CACHE . 'img/avatars/slim/' . $profile . '.jpg';

        if( $type == 1 ) {
        if ( file_exists( $url ) ) {
            return $url;
        } else {
            return 'storage/cache/img/avatars_random/' . rand(1,30) . '.jpg';
        }
        } elseif ( $type == 2 ) {
            if ( file_exists( $url ) ) {
                return $url;
            } else {
                return 'storage/cache/img/avatars_random/' . rand(1,30) . '_xs.jpg';
            }
        }
    }

    /**
     * Проверка на существование определеноого аватара
     *
     * @param string       $profile    Steam ID игрока
     * @param int          $type       Тип/Размер аватара.
     *
     * @return string                  Выводит итог проверки.
     */
    public function checkAvatar( $profile, $type ) {
        $url = CACHE . 'img/avatars/' . $profile . '.jpg';
        $url_slim = CACHE . 'img/avatars/slim/' . $profile . '.jpg';
        $cachetime = '259200';
        if( $type == 1 ) {
        if ( file_exists( $url ) ) {
            $time = gmdate("d-m-Y", filemtime($url));
            if ( time() - $cachetime <= $time ) {
                unlink($url);
                unlink($url_slim);
                return 1;
            } else {
                return 0;
            }
        } else {
            return 1;
        }
        } elseif( $type == 2 ) {

            if ( file_exists( $url_slim ) ) {
                $time = gmdate( "d-m-Y", filemtime( $url_slim ) );
                if ( time() - $cachetime <= $time ) {
                    unlink($url);
                    unlink($url_slim);
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 1;
            }
        }
    }

    /**
     * Получение настроек по умолчанию для вэб-интерфейса.
     *
     * @return array                 Массив с настройками.
     */
    public function get_default_options() {
        if ( file_exists( SESSIONS . '/options.php' ) ) {
            return require SESSIONS . '/options.php';
        } else {
            header( 'Location: ' . get_url(2) . '/app/page/custom/install/index.php' );
            exit;
        }
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
        if( $category != null ) {
            return print '<img src="' . CACHE . 'img/icons/' . $group . '/' . $category . '/' . $name . '.svg" class=svg>';
        } else {
                return print '<i class="zmdi zmdi-' . $name . ' zmdi-hc-fw"></i>';
        }
    }

    /**
     * Перевод времени.
     *
     * @param int $seconds          Время в секундах
     *
     * @return string               Итог перевода.
     */
    function action_time_exchange( $seconds ) {
        if( floor($seconds / 60 / 60 / 24 / 30 ) != 0 ) {
            $month = floor($seconds / 60 / 60 / 24 / 30 );
            return $month > 1 ? $month . ' ' . $this->Modules->get_translate_phrase('_Months') : $month . ' ' . $this->Modules->get_translate_phrase('_Month');

        } elseif ( floor($seconds / 60 / 60 / 24 / 7 ) != 0 ) {
            $week = floor($seconds / 60 / 60 / 24 / 7 );
            return $week > 1 ? $week . ' ' . $this->Modules->get_translate_phrase('_Weeks') : $week . ' ' . $this->Modules->get_translate_phrase('_Week');

        } elseif ( floor($seconds / 60 / 60 / 24 ) != 0 ) {
            $day = floor($seconds / 60 / 60 / 24 );
            return $day > 1 ? $day . ' ' . $this->Modules->get_translate_phrase('_Days') : $day . ' ' . $this->Modules->get_translate_phrase('_Day');

        } elseif ( floor($seconds / 60 / 60 ) != 0 ) {
            $hour = floor($seconds / 60 / 60 );
            return $hour > 1 ? $hour . ' ' . $this->Modules->get_translate_phrase('_Hour') : $hour . ' ' . $this->Modules->get_translate_phrase('_Hour');

        } elseif ( floor($seconds / 60 ) != 0 ) {
            $min = floor($seconds / 60 );
            return $min > 1 ? floor($seconds / 60 ) . ' ' . $this->Modules->get_translate_phrase('_Minute') : $min . ' ' . $this->Modules->get_translate_phrase('_Minute');

        } else {
            return $seconds . ' ' . $this->Modules->get_translate_phrase('_Second');
        }
    }

    /**
     * Вывод JS скрипта на проверку актуальности аватара.
     *
     * @param string $id      Steam ID - 32.
     *
     * @return string         Скрипт.
     */
    function get_js_relevance_avatar( $id ) {
        $con = con_steam32to64( $id );
        $check = ( int )$this->checkAvatar( $con, 2 );
        $this->arr_general['avatars'] == 1 && print sprintf('<script>CheckAvatar = %1$d; if (CheckAvatar == 1) { avatar.push("%2$s"); }</script>', $check, $con );
    }
}