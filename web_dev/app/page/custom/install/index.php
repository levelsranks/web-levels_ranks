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

// Проверка на BCMath
extension_loaded('bcmath') == 0 && get_iframe('002','Расширение для PHP не было найдено :: BCMath');

// Проверка на cURL
extension_loaded('curl') == 0 && get_iframe('007','Расширение для PHP не было найдено :: cURL');

// Проверка на Zip
extension_loaded('zip') == 0 && get_iframe('008','Расширение для PHP не было найдено :: Zip');

// Проверка на GMP
extension_loaded('gmp') == 0 && get_iframe('009','Расширение для PHP не было найдено :: GMP');

// Проверка прав доступа каталога кэша ( 0777 )
substr( sprintf( '%o', fileperms( SESSIONS ) ), -4) !== '0777' && get_iframe( '004','Не установлены права доступа 777 на директорию :: /storage/cache/sessions/' );

// Проверка прав доступа на кэш аватарок ( 0777 )
substr( sprintf( '%o', fileperms( CACHE . 'img/avatars/' ) ), -4) !== '0777' && get_iframe( '005','Не установлены права доступа 777 на директорию :: /storage/cache/img/avatars/' );

// Проверка прав доступа на кэш слим - аватарок ( 0777 )
substr( sprintf( '%o', fileperms( CACHE . 'img/avatars/slim/' ) ), -4) !== '0777' && get_iframe( '006','Не установлены права доступа 777 на директорию :: /storage/cache/img/avatars/slim/' );;

$URL = '//' . $_SERVER["SERVER_NAME"] . explode('/app/',$_SERVER['REQUEST_URI'])[0];

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
    } else {
        $db_check = '1';
    }
}

// Сохранение настроек базы данных
if( isset( $_POST['save_db'] ) ) {
    $db = ['LevelsRanks' => [['HOST' => $_POST['host'], 'USER' => $_POST['user'], 'PASS' => $_POST['pass'], 'DB' => [['DB' => $_POST['db_1'], 'Prefix' => [['table' => $_POST['table'], 'name' => $_POST['servers'], 'mod' => $_POST['game_mod'], 'ranks_pack' => 'default', 'steam' => (int) $_POST['steam_mod']]]]]]]];
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
        'web_key' => $_POST['web_key'],
        'avatars' => (int) $_POST['avatars'],
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
    <title>Добро пожаловать в мастер установки LR!</title>
</head>
<link rel="stylesheet" href="../../../../storage/assets/css/themes/mainstream_white/style.css">
<style>
    :root <?php echo str_replace( ',', ';', str_replace( '"', '', file_get_contents_fix ( '../../../../storage/assets/css/themes/mainstream_white/dark_mode_palette.json' ) ) )?>
</style>
<style>
    .badge {
        display: inline-block;
        padding: .35em .6em;
        font-size: 75%;
        font-weight: 500;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        fill: #ffffff;
        color: #ffffff!important;
        background-color: var(--span-color);
        box-shadow: var(--span-color-back) 5px 5px;
    }

    .badge a {
        fill: #ffffff;
        color: #ffffff!important;
        transition-duration: 400ms;
    }

    .input-form {
        position: relative;
        text-align: left;
        margin-top: 6px;
        margin-bottom: 6px;
        width: 100%;
    }

    .btn {
        margin-top: 12px;
        float: right;
    }

    .container-fluid {
        width: 100%;
        padding-top: 0px;
    }

    .card {
        margin-bottom: 17px;
    }
</style>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <?php if( $eb_db == '0' ) {?>
                <div class="card-header">
                    <h5 class="badge">Настройка базы данных - storage/cache/sessions/db.php</h5>
                </div>
                <div class="card-container option_one">
                    <form id="db_check" enctype="multipart/form-data" method="post">
                    <div class="input-form"><div class="input_text">Host: </div><input name="host" value="<?php echo $_POST['host']?>"></div>
                        <div class="input-form"><div class="input_text">User: </div><input name="user" value="<?php echo $_POST['user']?>"></div>
                        <div class="input-form"><div class="input_text">Pass: </div><input name="pass" value="<?php echo $_POST['pass']?>"></div>
                        <div class="input-form"><div class="input_text">DB: </div><input name="db_1" value="<?php echo $_POST['db_1']?>"></div>
                        <div class="input-form"><div class="input_text">Table: </div><input placeholder="Пример: lvl_base" name="table" value="<?php echo $_POST['table']?>"></div>
                        <div class="input-form"><div class="input_text">Название группы серверов: </div><input placeholder="Пример: Основные сервера Retakes" name="servers" value="<?php if($_POST['servers'] == ''){echo '';} else { echo $_POST['servers'];}?>"></div>
                        <div class="input-form"><div class="input_text">Мод</div>
                            <select name="game_mod">
                                <option value="csgo">CS:GO</option>
                                <option value="css">CSS</option>
                            </select>
                        </div>
                        <div class="input-form"><div class="input_text">Steam mode</div>
                            <select name="steam_mod">
                                <option value="1">Only Steam</option>
                                <option value="0">No Steam</option>
                            </select>
                        </div>
                    </form>
                    <?php if ( $db_check != 2 ):?>
                    <input class="btn" name="db_check" type="submit" form="db_check" value="Проверить">
                    <?php endif;?>
                    <?php if ( $db_check == 2 ):?>
                        <input class="btn" name="save_db" type="submit" form="db_check" value="Далее">
                    <?php endif;?>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if( $eb_option == '0' ) {?>
                <div class="card-header">
                    <h5 class="badge">Основные настройки - storage/cache/sessions/options.php</h5>
                </div>
                <div class="card-container option_one">
                    <form id="options" enctype="multipart/form-data" method="post">
                        <div class="input-form"><div class="input_text">Полное название</div><input name="full_name" value=""></div>
                        <div class="input-form"><div class="input_text">Короткое название</div><input name="short_name" value=""></div>
                        <div class="input-form"><div class="input_text">Общая информация</div><input name="info" value=""></div>
                        <div class="input-form"><div class="input_text">Язык</div>
                            <select class="select" name="language">
                                <option style="display:none" value="RU">Русский</option>
                                <option value="RU">Русский</option>
                                <option value="EN">Английский</option>
                                <option value="UA">Украинский</option>
                                <option value="LT">Литовский</option>
                            </select>
                        </div>
                        <div class="input-form"><div class="input_text">Тёмный режим по умолчанию:</div>
                            <select name="dark_mode">
                                <option value="1">Включен</option>
                                <option value="0">Выключен и вообще я хорошо вижу</option>
                            </select>
                        </div>
                        <div class="input-form"><div class="input_text">Анимации по умолчанию:</div>
                            <select name="animations">
                                <option value="1">Включены</option>
                                <option value="0">Лучше поменьше</option>
                            </select>
                        </div>
                        <div class="input-form"><div class="input_text">Показывать ли аватарки:</div>
                            <select name="avatars">
                                <option value="1">Показывать</option>
                                <option value="2">Использовать случайные аватарки</option>
                                <option value="0">Не показывать</option>
                            </select>
                        </div>
                        <div class="input-form"><div class="input_text">Сайтбар по умолчанию:</div>
                            <select name="sidebar_open">
                                <option value="1">Развёрнут</option>
                                <option value="0">Свёрнут</option>
                            </select>
                        </div>
                        <div class="input-form"><div class="input_text">Закруглять ли края блоков:</div>
                            <select name="form_border">
                                <option value="1">Закруглить</option>
                                <option value="0">Оквадратить</option>
                            </select>
                        </div>
                        <div class="input-form"><div class="input_text">Авторизация по Steam</div>
                            <select name="steam_auth">
                                <option style="display:none" value="1">Есть</option>
                                <option value="1">Есть</option>
                                <option value="0">Нету</option>
                            </select>
                        </div>
                        <div class="input-form"><div class="input_text">Steam WEB KEY</div><input name="web_key" value=""></div>
                        <div class="input-form"><div class="input_text">Глав. администратор ( Steam авторизация )</div><input name="admin" value="STEAM_1:"></div>
                        <div class="input-form"><div class="input_text">Глав. админ. логин ( No Steam авторизация ): </div><input name="admin_login" value=""></div>
                        <div class="input-form"><div class="input_text">Глав. админ. пароль ( No Steam авторизация ): </div><input name="admin_pass" value=""></div>
                    </form>
                    <input class="btn" name="option_save" type="submit" form="options" value="Сохранить">
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="badge">Информация</h5>
                </div>
                <div class="card-container">
                    Ваша версия PHP: <?php if( PHP_VERSION >= '7' ) { echo '<div class="color-green">'  . PHP_VERSION . '</div>';} else { echo '<div class="color-red">'  . PHP_VERSION . '</div>
                    <div>Рекомендуется: 7.0 - Возможны проблемы галактического масштаба :O</div>';} ?>
                    <?php if ( $db_check == 1 ):?>
                        <div>Подключение к базе данных отсутствует!</div>
                    <?php elseif ( $db_check == 2 ): ?>
                        <div>База данных с таблицей успешно подключена!</div>
                    <?php endif; ?>
        </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
