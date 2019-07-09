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

// Проверка прав доступа каталога кэша ( 0777 )
substr( sprintf( '%o', fileperms( SESSIONS ) ), -4) !== '0777' && get_iframe( '004','Не установлены права доступа 777 на директорию :: /storage/cache/sessions/' );

// Проверка прав доступа на кэш аватарок ( 0777 )
substr( sprintf( '%o', fileperms( CACHE . 'img/avatars/' ) ), -4) !== '0777' && get_iframe( '005','Не установлены права доступа 777 на директорию :: /storage/cache/img/avatars/' );

// Проверка прав доступа на кэш слим - аватарок ( 0777 )
substr( sprintf( '%o', fileperms( CACHE . 'img/avatars/slim/' ) ), -4) !== '0777' && get_iframe( '006','Не установлены права доступа 777 на директорию :: /storage/cache/img/avatars/slim/' );;

$URL = 'http';
if ( $_SERVER["HTTPS"] == "on" ) {
    $URL .= "s";
}
$URL .= '://' . $_SERVER["SERVER_NAME"] . explode('app/',$_SERVER['REQUEST_URI'])[0];

! file_exists( SESSIONS . '/db.php' ) ? $eb_db = '0' : $eb_db = 1;

// Получение настроек базы данных
( $eb_db == 1 ) ? $db = require SESSIONS . '/db.php' : false;

if ( $eb_db == 1 ) {

! file_exists( SESSIONS . '/options.php' ) ? $eb_option = '0' : $eb_option = 1;

( $eb_option == 1 ) ? $option = require SESSIONS . '/options.php' : false;

if( $eb_option != false ) { header( 'Location: ' . $URL );die(); }

if( $eb_db == false ) { header( 'Location: ' . $URL );die(); }

}

// Проверка соединения с базой данных
if(isset($_POST['db_check'])) {

    $con = mysqli_connect($_POST['host'], $_POST['user'], $_POST['pass'], $_POST['db_1']);

    $result = mysqli_query($con, 'SELECT name FROM ' . $_POST['table'] . ' ORDER BY name DESC LIMIT 1');

    if ( $result ) {
        $db_check = '2';
    } else {
        $db_check = '1';
    }
}

// Сохранение настроек базы данных
if( isset( $_POST['save_db'] ) ) {
    $db = ['LevelsRanks' => [['HOST' => $_POST['host'], 'USER' => $_POST['user'], 'PASS' => $_POST['pass'], 'DB' => [['DB' => $_POST['db_1'], 'Prefix' => [['table' => $_POST['table'], 'name' => $_POST['servers'], 'mod' => $_POST['game_mod'], 'steam' => (int) $_POST['steam_mod']]]]]]]];
    file_put_contents( SESSIONS . '/db.php', '<?php return '.var_export_opt( $db, true ).";" );
    header( 'Location: ' . get_url(2) );
}

if( isset( $_POST['option_save'] ) ) {

    $steam_admin = substr( $_POST['admin'], 0, 7) === "STEAM_0" ? str_replace("STEAM_0", "STEAM_1", $_POST['admin'] ) : $_POST['admin'];

    $default = [
        'full_name' => $_POST['full_name'],
        'short_name' => $_POST['short_name'],
        'info' => $_POST['info'],
        'site' => $URL,
        'language' => $_POST['language'],
        'theme' => 'mainstream_white',
        'dark_mode' => (int) $_POST['dark_mode'],
        'animations' => (int) $_POST['animations'],
        'sidebar_open' => (int) $_POST['sidebar_open'],
        'form_border' => (int) $_POST['form_border'],
        'sidebar' => 'mainstream',
        'web_key' => $_POST['web_key'],
        'avatars' => (int) $_POST['avatars'],
        'ranks_pack' => 'default',
        'icon_type' => 'SVG',
        'badge_type' => 2,
        'steam_auth' => (int) $_POST['steam_auth'],
        'secure_key' => 'this_is_key_is_default_privet_wender_secure',
        'admin' => $steam_admin
    ];

    file_put_contents( SESSIONS . '/options.php', '<?php return '.var_export_opt( $default, true ).";" );

    $admin = [
            ['login' => $_POST['admin_login'], 'pass' => $_POST['admin_pass'], 'access' => 'z']
    ];

    file_put_contents( SESSIONS . '/admins.php', '<?php return '.var_export_opt( $admin, true ).";" );

    header( 'Location: ' . get_url(1) );
}?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.2/css/all.css" />
    <title>Добро пожаловать в мастер установки LR!</title>
</head>
<style>
    @font-face {
        font-display: fallback;
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 300;
        src: local('Montserrat Light'), local('Montserrat-Light'), url(https://fonts.gstatic.com/s/montserrat/v13/JTURjIg1_i6t8kCHKm45_cJD3gnD_g.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    @font-face {
        font-display: fallback;
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 400;
        src: local('Montserrat Regular'), local('Montserrat-Regular'), url(https://fonts.gstatic.com/s/montserrat/v13/JTUSjIg1_i6t8kCHKm459W1hyzbi.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
    }

    @font-face {
        font-display: fallback;
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 400;
        src: local('Montserrat Regular'), local('Montserrat-Regular'), url(https://fonts.gstatic.com/s/montserrat/v13/JTUSjIg1_i6t8kCHKm459Wlhyw.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    @font-face {
        font-display: fallback;
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 500;
        src: local('Montserrat Medium'), local('Montserrat-Medium'), url(https://fonts.gstatic.com/s/montserrat/v13/JTURjIg1_i6t8kCHKm45_ZpC3g3D_u50.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
    }

    @font-face {
        font-display: fallback;
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 500;
        src: local('Montserrat Medium'), local('Montserrat-Medium'), url(https://fonts.gstatic.com/s/montserrat/v13/JTURjIg1_i6t8kCHKm45_ZpC3gnD_g.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    @font-face {
        font-display: fallback;
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 600;
        src: local('Montserrat SemiBold'), local('Montserrat-SemiBold'), url(https://fonts.gstatic.com/s/montserrat/v13/JTURjIg1_i6t8kCHKm45_bZF3g3D_u50.woff2) format('woff2');
        unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
    }

    @font-face {
        font-display: fallback;
        font-family: 'Montserrat';
        font-style: normal;
        font-weight: 600;
        src: local('Montserrat SemiBold'), local('Montserrat-SemiBold'), url(https://fonts.gstatic.com/s/montserrat/v13/JTURjIg1_i6t8kCHKm45_bZF3gnD_g.woff2) format('woff2');
        unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }

    body{
        font-family: 'Montserrat', sans-serif;
        font-weight: 400;
        font-size: 15px;
        position: relative;
        background-color: #2b2b2b;
        overflow: hidden;
        color: #fff;
    }

    dl,
    ol,
    ul,
    ol ol,
    ol ul,
    ul ol,
    ul ul {
        margin-top: 0;
        margin-bottom: 0;
        padding: 0;
    }

    .color-red {
        color: #dc3545!important;
    }

    .color-green {
        color: #28a745!important;
    }

    .container {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .line {
        position: fixed;
        margin-top: 2%;
        left: 20%;
        background: #3e3d3e;
        height: 0.18%;
        width: 60%;
        z-index: 3;
    }

    .php_block{
        position: fixed;
        font-weight: 700;
        font-size: 1.4vw;
        margin-top: 2.85%;
        left: 19.85%;
        border-radius: 4px;
        z-index: 99;
    }
    .php_block .color-green, .php_block .color-red{
        display: inline-block
    }

    .install_block{
        position: fixed;
        overflow: hidden;
        margin-top: 7%;
        left: 20%;
        background-color: rgba(31, 31, 31, 0.7);
        height: 80%;
        width: 60%;
        z-index: 99;
        border-radius: 4px;
    }

    .install_block .title{
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 99;
        font-weight: 600;
        font-size: 1.1vw;
        color: #ffffff;
    }

    .install_block .next{
        position: absolute;
        bottom: 20px;
        right: 20px;
        z-index: 99;
        font-weight: 600;
        font-size: 1.1vw;
    }
    .install_block input,.install_block select{
        cursor: pointer;
        white-space: nowrap;
        text-align: center;
        outline: none;
        float: right;
        padding: 7px 16px;
        color: #fff;
        background-color: #3E3D3E;
        border: 1px solid #fff;
        font-weight: 400;
        font-size: 0.7vw;

    }

    .db_setting{
        position: absolute;
        left: 23px;
        top: 80px;
    }

    .db_setting .name{
        color: #ffffff;
        font-weight: 500;
        font-size: 0.9vw;
        margin-bottom: 20px;
        text-align: left;
    }

    .db_setting .name input{
        cursor: text;
        margin-left: 20px;
        text-align: left;
        background-color: inherit;
        color: #ffffff;
        width: 30vw;
    }

    .db_setting .name select{
        cursor: text;
        margin-left: 10px;
        text-align: left;
        background-color: rgba(31, 31, 31, 0.7);
        color: #ffffff;
        width: 8vw;
    }

</style>
<body>
<div class="container">
    <div class="line"></div>
    <div class="php_block">
        <div class="php_version">Ваша версия PHP: <?php if( PHP_VERSION >= '7' ) { echo '<div class="color-green">'  . PHP_VERSION . '</div>';} else { echo '<div class="color-red">'  . PHP_VERSION . '</div>
        <div class="php_version_recomendet">Рекомендуется: 7.0 - Возможны проблемы галактического масштаба :O</div>';} ?>
    </div>
    </div>
    <div class="install_block">
        <?php if( $eb_db == '0' ) {?>
        <div class="title">Настройка базы данных - storage/cache/sessions/db.php</div>
        <form id="db_check" enctype="multipart/form-data" method="post">
        <div class="db_setting">
            <div class="name">Host: <input name="host" value="<?php echo $_POST['host']?>"></div>
            <div class="name">User: <input name="user" value="<?php echo $_POST['user']?>"></div>
            <div class="name">Pass: <input name="pass" value="<?php echo $_POST['pass']?>"></div>
            <div class="name">DB: <input name="db_1" value="<?php echo $_POST['db_1']?>"></div>
            <div class="name">Table: <input name="table" placeholder="Пример: lvl_base" value="<?php echo $_POST['table']?>"></div>
            <div class="name">Название группы серверов: <input name="servers" placeholder="Пример: Основные сервера Retakes" value="<?php if($_POST['servers'] == ''){echo '';} else { echo $_POST['servers'];}?>"></div>
            <div class="name">Мод:
                <select name="game_mod">
                    <option value="csgo">CS:GO</option>
                    <option value="css">CSS</option>
                </select>
            </div>
            <div class="name">Steam mode:
                <select name="steam_mod">
                    <option value="1">Only Steam</option>
                    <option value="0">No Steam</option>
                </select>
            </div><?php if ( $db_check == 1 ):?>
                <div class="name">Подключение к базе данных отсутствует</div>
            <?php elseif ( $db_check == 2 ): ?>
            <div class="name">База данных с таблицей успешно подключена!</div>
            <?php endif; ?>
            <input type="submit" value="Проверить" name="db_check" form="db_check">
        </div>
        </form>
        <?php if ( $db_check == 2 ):?>
        <div class="next"><input name="save_db" type="submit" form="db_check" value="Далее"></div>
        <?php endif;?>
        <?php } ?>
        <?php if( $eb_option == '0' ) {?>
            <div class="title">Основные настройки - storage/cache/sessions/options.php</div>
            <form id="options" enctype="multipart/form-data" method="post">
                <div class="db_setting">
                    <div class="name">Полное название: <input name="full_name" placeholder="Пример: OCGN.RU | OCGN.PRO :: Соревновательная платформа CS:GO" value=""></div>
                    <div class="name">Короткое название: <input name="short_name" placeholder="Пример: OCGN.RU | OCGN.PRO" value=""></div>
                    <div class="name">Общая информация: <input name="info" placeholder="Пример: OCGN.RU | OCGN.PRO :: Соревновательная платформа без читеров, позволяющая вам тренироваться и участвовать на турнирах по Counter-Strike: Global Offensive!" value=""></div>
                    <div class="name">Язык:
                        <select name="language">
                            <option value="RU">Русский</option>
                            <option value="EN">Английский</option>
                            <option value="UA">Украинский</option>
                            <option value="LT">Литовский</option>
                        </select>
                    </div>
                    <div class="name">Тёмный режим по умолчанию:
                        <select name="dark_mode">
                            <option value="1">Включен</option>
                            <option value="0">Выключен и вообще я хорошо вижу</option>
                        </select>
                    </div>
                    <div class="name">Анимации по умолчанию:
                        <select name="animations">
                            <option value="1">Включены</option>
                            <option value="0">Лучше поменьше</option>
                        </select>
                    </div>
                    <div class="name">Показывать ли аватарки:
                        <select name="avatars">
                            <option value="1">Показывать</option>
                            <option value="2">Использовать случайные аватарки</option>
                            <option value="0">Не показывать</option>
                        </select>
                    </div>
                    <div class="name">Сайтбар по умолчанию:
                        <select name="sidebar_open">
                            <option value="1">Развёрнут</option>
                            <option value="0">Свёрнут</option>
                        </select>
                    </div>
                    <div class="name">Закруглять ли края блоков:
                        <select name="form_border">
                            <option value="1">Закруглить</option>
                            <option value="0">Оквадратить</option>
                        </select>
                    </div>
                    <div class="name">Авторизация по Steam:
                        <select name="steam_auth">
                            <option value="1">Есть</option>
                            <option value="0">Нету</option>
                        </select>
                    </div>
                    <div class="name">Steam WEB KEY: <input name="web_key" value=""></div>
                    <div class="name">Глав. админ. ( Steam авторизация ): <input name="admin" placeholder="Пример: STEAM_1:1:39075162 . Поле не должно быть пустым в любом случае." value=""></div>
                    <div class="name">Глав. админ. логин ( No Steam авторизация ): <input name="admin_login" placeholder="Пример: M0st1ce" value=""></div>
                    <div class="name">Глав. админ. пароль ( No Steam авторизация ): <input name="admin_pass" placeholder="Пример: 123_321" value=""></div>
                </div>
            </form>
                <div class="next"><input name="option_save" type="submit" form="options" value="Сохранить"></div>
        <?php } ?>
    </div>
</div>
</body>
</html>
