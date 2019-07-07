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
    public function _initiation() {

        // Проверка на существоавание option.php
        file_exists( SESSIONS . '/option.php' ) && header( 'Location: ' . get_url(2) . 'app/page/custom/install/index.php');

        if ( ! empty( $_SESSION['steamid'] ) ):
            if ( $_SESSION['USER_AGENT'] != $_SERVER['HTTP_USER_AGENT'] || $_SESSION['HTTP_X'] != $_SERVER['HTTP_X_FORWARDED_FOR'] || $_SESSION['REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR']  ):
                session_unset() && session_destroy() && die('Fake request');
            endif;
        endif;

        // Получение настроек вэб-интерфейса.
        $this->arr_general = $this->get_default_options();

        // Костыльная авторизация для главного администратора - В будущем поправить
        if( isset( $_POST['log_in'] ) && IN_LR == true ) { $admins = require SESSIONS . 'admins.php';

            for ( $i = 0, $admins_count = sizeof( $admins ); $i < $admins_count; $i++ ) {

                if($admins[$i]['login'] == action_text_clear( $_POST['_login'] ) && $admins[$i]['pass'] == action_text_clear( $_POST['_pass'] ) ) {
                    $_SESSION['steamid'] = $this->steam32to64( $this->arr_general['admin'] );
                    $_SESSION['steamid32'] = $this->arr_general['admin'];
                    $_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
                    $_SESSION['HTTP_X'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
                    $_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
                    header( 'Location: ' . get_url(1) . '#' );
                    exit;
                }
            }
            header( 'Location: ' . get_url(1) );
            exit;
        }

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

        // получение информации об авторизации по Steam.
        isset( $_GET["auch"] ) && $this->arr_general['steam_auth'] == 1 && in_array( $_GET["auch"], array( 'login', 'logout' ) ) && require 'app/includes/auth/steam.php';
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
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 1;
        }
        } elseif( $type == 2 ) {

            if ( file_exists( $url_slim ) ) {
                $time = gmdate( "d-m-Y", filemtime( $url_slim ) );
                if ( time() - $cachetime <= $time ) {
                    unlink($url);
                    unlink($url_slim);
                    echo 1;
                } else {
                    echo 0;
                }
            } else {
                echo 1;
            }
        }
    }

    /**
     * Конвертация Steam ID 32 -> 64.
     *
     * @param string       $steamid32    Steam ID игрока.
     *
     * @return string                    Выводит итог конвертации.
     */
    public function steam32to64( $steamid32 ) {
        list( , $m1, $m2 ) = explode( ':', $steamid32, 3 );
        list( $steam_cid, ) = explode( '.', bcadd((((int)$m2 * 2) + $m1 ) , '76561197960265728') , 2 );
        return $steam_cid;
    }

    /**
     * Конвертация Steam ID 64 -> 32.
     *
     * @param string       $steamid64    Steam ID игрока.
     *
     * @return string                    Выводит итог конвертации.
     */
    public function steam64to32( $steamid64 ) {
        if ( preg_match( '/^(7656119)([0-9]{10})$/', $steamid64, $match ) ) {
            $const1 = 7960265728;
            $steam32 = '';
            if ( $const1 <= $match[2] ) {
                $a = ( $match[2] - $const1 ) % 2;
                $b = ( $match[2] - $const1 - $a ) / 2;
                $steam32 = 'STEAM_1:' . $a . ':' . $b;
            }
            return $steam32;
        }
        return false;
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
            if( $group == 'zmdi' && $this->arr_general['icon_type'] == 'CSS' ) {
                return print '<i class="zmdi zmdi-' . $name . '"></i>';
            } else {
                return print '<img src="' . CACHE . 'img/icons/' . $group . '/' . $name . '.svg">';
            }
        }
    }
}