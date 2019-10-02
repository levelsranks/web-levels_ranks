<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

if ( $_GET["auth"] == 'login' ) {
    require 'app/ext/LightOpenID.php';
    try {
        $openid = new LightOpenID( 'http:' . $this->General->arr_general['site'] );
        if ( ! $openid->mode ) {
            $openid->identity = 'https://steamcommunity.com/openid';
            header( 'Location: ' . $openid->authUrl() );
            if ( ! headers_sent() ) {?>
                <script type="text/javascript">window.location.href="<?php echo $openid->authUrl() ?>";</script>
                <noscript><meta http-equiv="refresh" content="0;url=<?php echo $openid->authUrl() ?>" /></noscript>
                <?php exit;
            }
        } elseif ( $openid->mode == 'cancel' ) {
            echo 'User has canceled authentication!';
        } else {
            if ( $openid->validate() ) {
                $id = $openid->identity;
                $ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match( $ptn, $id, $matches );
                $_SESSION['steamid'] = $matches[1];
                $_SESSION['steamid64'] = $matches[1];
                $_SESSION['steamid32'] = con_steam64to32( $matches[1] );
                preg_match_all("/[0-9a-zA-Z_]{7}:([0-9]{1}):([0-9]+)/u", $_SESSION['steamid32'], $arr, PREG_SET_ORDER);
                $_SESSION['steamid32_short'] = $arr[0][1] . ':' . $arr[0][2];
                $_SESSION['USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
                $_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
                header('Location: ' . $this->General->arr_general['site']);
                if ( ! headers_sent() ) {?>
                    <script type="text/javascript">window.location.href="<?php echo $this->General->arr_general['site'] ?>";</script>
                    <noscript><meta http-equiv="refresh" content="0;url=<?php echo $this->General->arr_general['site'] ?>" /></noscript>
                    <?php exit;
                }
            }
        }
    } catch( ErrorException $e ) {
    }
};
if ( $_GET["auth"] == 'logout' ) {
    session_unset();
    session_destroy();
    header('Location: ' . $this->General->arr_general['site']);
    if ( ! headers_sent() ) {?>
        <script type="text/javascript">window.location.href="<?php echo $this->General->arr_general['site'] ?>";</script>
        <noscript><meta http-equiv="refresh" content="0;url=<?php echo $this->General->arr_general['site'] ?>" /></noscript>
        <?php exit;
    }
}