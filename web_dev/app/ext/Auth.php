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

    function __construct( $General ) {

        $this->General = $General;

        $this->admins = require SESSIONS . 'admins.php';

        $this->admins_count = sizeof( $this->admins );

        if ( ! empty( $_SESSION['steamid'] ) ):
            if ( $_SESSION['USER_AGENT'] != $_SERVER['HTTP_USER_AGENT'] || $_SESSION['REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR']  ):
                session_unset() && session_destroy() && die('Fake request');
            endif;
        endif;

        // получение информации об авторизации по Steam.
        isset( $_GET["auth"] ) && $this->General->arr_general['steam_auth'] == 1 && in_array( $_GET["auth"], array( 'login', 'logout' ) ) && require 'app/includes/auth/steam.php';

        $this->_POST();
    }

    public function _POST() {
        if( isset( $_POST['log_in'] ) ) {
            $_POST['_login'] == '' && exit;
            for ( $i = 0; $i < $this->admins_count; $i++ ) {
                if($this->admins[$i]['login'] == action_text_clear( $_POST['_login'] ) && $this->admins[$i]['pass'] == action_text_clear( $_POST['_pass'] ) ) {
                    $_SESSION['steamid'] = con_steam32to64( $this->General->arr_general['admin'] );
                    $_SESSION['steamid32'] = $this->General->arr_general['admin'];
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
}