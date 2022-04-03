<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */
$red = $_SESSION['rpage'] ?? '';
if ( ! empty( $_GET["auth"] ) && $_GET["auth"] == 'login' ) {
    require 'app/ext/LightOpenID.php';
    try 
    {
        $openid = new LightOpenID( "http:" . $this->General->arr_general['site'] );
        if ( ! $openid->mode ) 
        {
            $openid->identity = 'https://steamcommunity.com/openid';
            header( 'Location: ' . $openid->authUrl() );
            if ( ! headers_sent() ) {?>
                <script type="text/javascript">window.location.href="<?php echo $openid->authUrl() ?>";</script>
                <noscript><meta http-equiv="refresh" content="0;url=<?php echo $openid->authUrl() ?>" /></noscript>
                <?php exit;
            }
        } 
        elseif ( $openid->mode == 'cancel' ) 
            echo 'User has canceled authentication!';
        else
        {
            if ( $openid->validate() ) 
            {
                preg_match( "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/", $openid->identity, $matches );

                $steam32 = con_steam64to32( $matches[1] );

                $_SESSION = [
                    "steamid"           => $matches[1],
                    "steamid64"         => $matches[1],
                    "steamid32"         => $steam32,
                    "steamid32_short"   => substr( $steam32, 8 ),
                    "USER_AGENT"        => $_SERVER['HTTP_USER_AGENT'],
                    "REMOTE_ADDR"       => $this->General->get_client_ip_cdn()
                ];

                if( ! empty( $Db->db_data['LevelsRanks'] ) )
                {
                    try
                    {
                        $Pdox = new \app\ext\Pdox( "LevelsRanks", 0, 0 );

                        if( empty( $test = $Pdox->table("")->where("steam", $steam32)->get() ) )
                        {
                            $nick = json_decode( file_get_contents( 'https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $this->General->arr_general['web_key'] . '&steamids=' . $matches[1] ), true ); 

                            $insert_data = [
                                "steam" => $steam32,
                                "name" => $nick['response']['players']['0']['personaname'] ?? "unknown",
                                "lastconnect" => time()
                            ];

                            $Pdox->table("")->insert( $insert_data );
                        }
                    }
                    catch( Exception $e )
                    {
                        // пропускаем, че нам сделать..
                    }
                }

                $this->generateToken();

                header('Location: ' . $this->General->arr_general['site']);
            }
        }
    } 
    catch( ErrorException $e ) 
    {
        //echo $e->getMessage(); Убираем сообщения, и просто редиректим, в случае чего
        header('Location: ' . $this->General->arr_general['site']);
    }
};
if ( ! empty( $_GET["auth"] ) && $_GET["auth"] == 'logout' ) 
{
    // Чистим токен из базы
    $this->cookieEnabled() && $this->delToken( $_SESSION["steamid64"] );

    // Удаляем сессию
    session_unset();
    session_destroy();

    // Чистим токен у пользователя
    setcookie('cookie_token', null, 1, "/", ".".$_SERVER['HTTP_HOST']);

    // Редирект
    header('Location: ' . $this->General->arr_general['site']);
    if ( ! headers_sent() ) {?>
        <script type="text/javascript">window.location.href="<?php echo $this->General->arr_general['site'] ?>";</script>
        <noscript><meta http-equiv="refresh" content="0;url=<?php echo $this->General->arr_general['site'] ?>" /></noscript>
        <?php exit;
    }
}
