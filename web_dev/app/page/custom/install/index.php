<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// задаём основную кодировку страницы.
header('Content-Type: text/html; charset=utf-8');

// Отключаем показ ошибок.
error_reporting(0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

// Ограничиваем время выполнения скрипта.
set_time_limit(3);

// Нахожение в пространстве LR.
define('IN_LR', true);

// Директория содержащая основные блоки вэб-приложения.
define('PAGE', '../../../../app/page/general/');

// Директория содержащая дополнительные блоки вэб-приложения.
define('PAGE_CUSTOM', '../../../../app/page/custom/');

// Директория с модулями.
define('MODULES', '../../../../app/modules/');

// Директория с основными конфигурационными файлами.
define('INCLUDES', '../../../../app/includes/');

// Директория с CSS шаблонами.
define('ASSETS_CSS', '../../../../storage/assets/css/');

// Директория с JS библиотеками.
define('ASSETS_JS', '../../../../storage/assets/js/');

// Директория с основными кэш-файлами.
define('SESSIONS', '../../../../storage/cache/sessions/');

// Директория содержащая графические кэш-файлы.
define('CACHE', '../../../../storage/cache/');

// Директория с шаблонами "Sidebars".
define('SIDEBARS', '../../../../storage/assets/css/sidebars/');

// Директория с шаблонами "Themes".
define('THEMES', '../../../../storage/assets/css/themes/');

// Директория с изображениями рангов.
define('RANKS_PACK', '../../../../storage/cache/img/ranks/');

// Регистраниция основных функций.
require INCLUDES . 'functions.php';

// Проверка на PDO
class_exists('PDO') || get_iframe('001','Для работы нужна поддержка PDO');

// Проверка на BCMath
extension_loaded('bcmath') == 0 && get_iframe('001','Расширение для PHP не было найдено :: BCMath');

// Проверка на cURL
extension_loaded('curl') == 0 && get_iframe('001','Расширение для PHP не было найдено :: cURL');

// Проверка на Zip
extension_loaded('zip') == 0 && get_iframe('001','Расширение для PHP не было найдено :: Zip');

// Проверка на GMP
extension_loaded('gmp') == 0 && get_iframe('001','Расширение для PHP не было найдено :: GMP');

// Проверка прав доступа каталога кэша ( 0777 )
substr( sprintf( '%o', fileperms( SESSIONS ) ), -4) !== '0777' && get_iframe( '002','Не установлены права доступа 777 на директорию :: /storage/cache/sessions/' );

// Создание папки - avatars
! file_exists( CACHE . 'img/avatars/' ) && mkdir( CACHE . 'img/avatars/', 0777, true );

// Проверка прав доступа на кэш аватарок ( 0777 )
substr( sprintf( '%o', fileperms( CACHE . 'img/avatars/' ) ), -4) !== '0777' && get_iframe( '002','Не установлены права доступа 777 на директорию :: /storage/cache/img/avatars/' );

// Создание папки - slim
! file_exists( CACHE . 'img/avatars/slim/' ) && mkdir( CACHE . 'img/avatars/slim/', 0777, true );

// Проверка прав доступа на кэш слим - аватарок ( 0777 )
substr( sprintf( '%o', fileperms( CACHE . 'img/avatars/slim/' ) ), -4) !== '0777' && get_iframe( '002','Не установлены права доступа 777 на директорию :: /storage/cache/img/avatars/slim/' );

// Создание папки - css
! file_exists( ASSETS_CSS ) && mkdir( ASSETS_CSS, 0777, true );

// Проверка прав доступа на ассеты - CSS ( 0777 )
substr( sprintf( '%o', fileperms( ASSETS_CSS ) ), -4) !== '0777' && get_iframe( '002','Не установлены права доступа 777 на директорию :: /storage/assets/css/' );

// Создание папки - js
! file_exists( ASSETS_JS ) && mkdir( ASSETS_JS, 0777, true );

// Проверка прав доступа на ассеты - JS ( 0777 )
substr( sprintf( '%o', fileperms( ASSETS_JS ) ), -4) !== '0777' && get_iframe( '002','Не установлены права доступа 777 на директорию :: /storage/assets/js/' );

// Проверка на существование файла с настройками
! file_exists( SESSIONS . '/options.php' ) && file_put_contents( SESSIONS . '/options.php', '<?php return []; ' );

// Проверка на существование файла с базой данных
! file_exists( SESSIONS . '/db.php' ) && file_put_contents( SESSIONS . '/db.php', '<?php return []; ' );

// Создание/возобновление сессии.
session_start();

$options = require SESSIONS . '/options.php';

$db = require SESSIONS . '/db.php';

// Язык
if ( isset( $_POST['EN'] ) || isset( $_POST['RU'] ) ):
    $options['language'] = isset( $_POST['EN'] ) ? 'EN' : 'RU';
    file_put_contents( SESSIONS . '/options.php', '<?php return '.var_export_min( $options ).";\n" );
    header_fix( get_url(1) );
endif;

// Информация о серверах

if ( isset( $_POST['servers_info_save'] ) ) {
    $options['short_name'] = $_POST['servers_name'];
    $options['full_name'] = $_POST['servers_full_name'];
    $options['info'] = $_POST['servers_info'];
    $URL = '//' . $_SERVER["SERVER_NAME"] . explode('/app/',$_SERVER['REQUEST_URI'])[0];
    $options['site'] = substr( $URL, -1 ) == '/' ? $URL : $URL . '/';
    file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min( $options ) . ";\n");
    header_fix( get_url(1) );
}

// WEB KEY API

if ( ! empty( $_POST['web_key'] ) ) {
    $result = curl_init( 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $_POST['web_key'] . '&steamids=76561198038416053' );
    curl_setopt($result, CURLOPT_RETURNTRANSFER, 1);
    $url = curl_exec($result);
    $data = json_decode( $url, true )['response']['players'];
    if( $data[0]['steamid'] == 76561198038416053 ) {
        $options['web_key'] = $_POST['web_key'];
        $options['steam_auth'] = 1;
        $options['only_steam_64'] = 0;
        $options['avatars'] = 1;
        $options['avatars_cache_time'] = 259200;
        file_put_contents( SESSIONS . '/options.php', '<?php return '.var_export_min( $options ).";\n" );
        header_fix( get_url(1) );
    } else {
        $error = true;
    }
} elseif ( ! empty( $_POST['nope'] ) ) {
    $options['web_key'] = 1;
    $options['steam_auth'] = 0;
    $options['only_steam_64'] = 0;
    $options['avatars'] = 2;
    $options['avatars_cache_time'] = 259200;
    file_put_contents( SESSIONS . '/options.php', '<?php return '.var_export_min( $options ).";\n" );
    header_fix( get_url(1) );
}

// Sidebar

if ( isset( $_POST['sidebar_open'] ) || isset( $_POST['sidebar_close'] ) ) {
    $options['sidebar_open'] = isset( $_POST['sidebar_open'] ) ? (int) 1 : (int) 0;
    file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min($options) . ";\n");
    header_fix( get_url(1) );
}

// Бэйджи

if ( isset( $_POST['badge_type_1'] ) || isset( $_POST['badge_type_2'] ) ) {
    $options['badge_type'] = isset( $_POST['badge_type_1'] ) ? (int) 1 : (int) 2;
    file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min($options) . ";\n");
    header_fix( get_url(1) );
}

// Form Border

if ( isset( $_POST['form_border_0'] ) || isset( $_POST['form_border_1'] ) ) {
    $options['form_border'] = isset( $_POST['form_border_1'] ) ? (int) 1 : (int) 0;
    file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min($options) . ";\n");
    header_fix( get_url(1) );
}

// animation

if ( isset( $_POST['animations_on'] ) || isset( $_POST['animations_off'] ) ) {
    $options['animations'] = isset( $_POST['animations_on'] ) ? (int) 1 : (int) 0;
    file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min($options) . ";\n");
    header_fix( get_url(1) );
}

// dark_mode

if ( isset( $_POST['dark_mode_on'] ) || isset( $_POST['dark_mode_off'] ) ) {
    $options['dark_mode'] = isset( $_POST['dark_mode_on'] ) ? (int) 1 : (int) 0;
    $options['theme'] = 'mainstream_white';
    file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min($options) . ";\n");
    header_fix( get_url(1) );
}

// admin

if ( isset( $_POST['check_admin_steam'] ) ) {
    $_SESSION['admin'] = con_steam32to64( $_POST['admin'] );
    $result = curl_init( 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . $options['web_key'] . '&steamids=' . $_SESSION['admin'] . ' ' );
    curl_setopt($result, CURLOPT_RETURNTRANSFER, 1);
    $url = curl_exec($result);
    $data = json_decode( $url, true )['response']['players'][0];
}

if ( isset( $_POST['check_admin_steam_da'] ) && isset( $_SESSION['admin'] ) ) {
    $options['admin'] = con_steam64to32( $_SESSION['admin'] );
    file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min($options) . ";\n");
    header_fix( get_url(1) );
}

if ( isset( $_POST['check_admin_steam_net'] ) && isset( $_SESSION['admin'] ) ) {
    unset( $_SESSION['admin'] );
    header_fix( get_url(1) );
}

if ( isset( $_POST['admin_nosteam_save'] ) ) {
    $admin[] = ['login' => $_POST['admin_login'],'pass' => $_POST['admin_login'], 'access' => 'z'];
    $options['admin'] = '1';
    file_put_contents(SESSIONS . '/admins.php', '<?php return ' . var_export_min( $admin ) . ";\n");
    file_put_contents(SESSIONS . '/options.php', '<?php return ' . var_export_min($options) . ";\n");
    header_fix( get_url(1) );
}

// Проверка соединения с базой данных

if( isset( $_POST['db_check'] ) ) {

    $con = mysqli_connect($_POST['HOST'], $_POST['USER'], $_POST['PASS'], $_POST['DATABASE'], $_POST['PORT']);

    $result = mysqli_query($con, 'SELECT name FROM ' . $_POST['TABLE'] . ' ORDER BY name DESC LIMIT 1');

    if ( $result ) {
        $db_check = 2;
        $table = 'CREATE TABLE IF NOT EXISTS lr_web_notifications (
                  `id` INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
                  steam VARCHAR(128) NOT NULL,
                  text VARCHAR(256) NOT NULL,
                  values_insert VARCHAR(512) NOT NULL,
                  url VARCHAR(128) NOT NULL,
                  icon VARCHAR(64) NOT NULL,
                  seen int(11) NOT NULL,
                  status int(11) NOT NULL,
                  date TIMESTAMP NOT NULL) ENGINE = InnoDB CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;';
        $con->query( $table );
        $db = ['LevelsRanks' => [['HOST' => $_POST['HOST'], 'PORT' => $_POST['PORT'], 'USER' => $_POST['USER'], 'PASS' => $_POST['PASS'], 'DB' => [['DB' => $_POST['DATABASE'], 'Prefix' => [['table' => $_POST['TABLE'], 'name' => $_POST['NAME'], 'mod' => $_POST['game_mod'], 'ranks_pack' => 'default', 'steam' => (int) $_POST['steam_mod']]]]]]]];
        file_put_contents( SESSIONS . '/db.php', '<?php return '.var_export_opt( $db, true ).";" );
        header_fix( get_url(1) );
    } else {
        $db_check = 1;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Добро пожаловать в мастер установки LR!</title>
</head>
<link rel="stylesheet" href="../../../../storage/assets/css/themes/mainstream_white/style.css">
<link rel="stylesheet" href="../../../../app/page/custom/install/css/style.css">
<style>
    :root <?php echo str_replace( ',', ';', str_replace( '"', '', file_get_contents_fix ( '../../../../storage/assets/css/themes/mainstream_white/dark_mode_palette.json' ) ) )?>
</style>
<body>
<div class="container-fluid">
    <div class="row">
<?php
// Проверка на язык страницы
if ( empty( $options['language'] ) ) {
    require PAGE_CUSTOM . 'install/includes/options/language.php';
} elseif ( empty( $options['full_name'] ) || empty( $options['short_name'] ) || empty( $options['info'] ) || empty( $options['site'] ) ) {
    require PAGE_CUSTOM . 'install/includes/options/name.php';
} elseif ( empty( $options['web_key'] ) ) {
    require PAGE_CUSTOM . 'install/includes/options/webkey.php';
} elseif ( empty( $options['sidebar_open'] ) && ! is_int ( $options['sidebar_open'] ) ) {
    require PAGE_CUSTOM . 'install/includes/options/sidebar.php';
} elseif ( empty( $options['badge_type'] ) && ! is_int ( $options['badge_type'] ) ) {
    require PAGE_CUSTOM . 'install/includes/options/badge_type.php';
} elseif ( empty( $options['form_border'] ) && ! is_int ( $options['form_border'] ) ) {
    require PAGE_CUSTOM . 'install/includes/options/form_border.php';
} elseif ( empty( $options['animations'] ) && ! is_int ( $options['animations'] ) ) {
    require PAGE_CUSTOM . 'install/includes/options/animations.php';
} elseif ( empty( $options['dark_mode'] ) && ! is_int ( $options['dark_mode'] ) ) {
    require PAGE_CUSTOM . 'install/includes/options/dark_mode.php';
} elseif ( empty( $options['admin'] ) && $options['web_key'] == 1 ) {
    require PAGE_CUSTOM . 'install/includes/options/admin_no_steam.php';
} elseif ( empty( $options['admin'] ) && $options['web_key'] !== 1 ) {
    require PAGE_CUSTOM . 'install/includes/options/admin_steam.php';
} elseif ( empty( $db ) ) {
    require PAGE_CUSTOM . 'install/includes/options/db.php';
} else {?>
    <script type="text/javascript">window.location.href="<?php echo '//' . $_SERVER["SERVER_NAME"] . explode('/app/',$_SERVER['REQUEST_URI'])[0]?>";</script>
    <noscript><meta http-equiv="refresh" content="0;url=<?php echo '//' . $_SERVER["SERVER_NAME"] . explode('/app/',$_SERVER['REQUEST_URI'])[0]?>" /></noscript>
<?}?></div>
</div>
</body>
</html>
