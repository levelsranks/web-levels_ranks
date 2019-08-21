<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Задаём основную кодировку страницы.
header('Content-Type: text/html; charset=utf-8');

// Отключаем вывод ошибок.
error_reporting(0);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

// Ограничиваем время выполнения скрипта.
set_time_limit(3);

// Нахожение в пространстве LR.
define('IN_LR', true);

// Версия LR WEB.
define('VERSION', '0.2.114');

// Директория содержащая основные блоки вэб-приложения.
define('PAGE', 'app/page/general/');

// Директория содержащая дополнительные блоки вэб-приложения.
define('PAGE_CUSTOM', 'app/page/custom/');

// Директория с модулями.
define('MODULES', 'app/modules/');

// Директория с основными конфигурационными файлами.
define('INCLUDES', 'app/includes/');

// Директория с основными кэш-файлами.
define('SESSIONS', 'storage/cache/sessions/');

// Директория с кэш-файлами модулей.
define('MODULES_SESSIONS', 'storage/cache/sessions/modules/');

// Директория содержащая графические кэш-файлы.
define('CACHE', 'storage/cache/');

// Директория с ресурсами.
define('ASSETS', 'storage/assets/');

// Директория с CSS шаблонами.
define('ASSETS_CSS', 'storage/assets/css/');

// Директория с JS библиотеками.
define('ASSETS_JS', 'storage/assets/js/');

// Директория с шаблонами "Themes".
define('THEMES', 'storage/assets/css/themes/');

// Директория с изображениями рангов.
define('RANKS_PACK', 'storage/cache/img/ranks/');

// Временные константы ( Постоянные времени ) - Минута.
define( 'MINUTE_IN_SECONDS', 60 );

// Временные константы ( Постоянные времени ) - Час.
define( 'HOUR_IN_SECONDS', 60 * MINUTE_IN_SECONDS );

// Временные константы ( Постоянные времени ) - День.
define( 'DAY_IN_SECONDS', 24 * HOUR_IN_SECONDS );

// Временные константы ( Постоянные времени ) - Неделя.
define( 'WEEK_IN_SECONDS', 7 * DAY_IN_SECONDS );

// Временные константы ( Постоянные времени ) - Месяц.
define( 'MONTH_IN_SECONDS', 30 * DAY_IN_SECONDS );

// Временные константы ( Постоянные времени ) - Год.
define( 'YEAR_IN_SECONDS', 365 * DAY_IN_SECONDS );

// Регистраниция основных функций.
require INCLUDES . 'functions.php';

// Создание/возобновление сессии.
session_start();

// Включение буферизации.
ob_start();

// Импортирование основного глобального класса.
use app\ext\General;

// Импортирование глобального класса отвечающего за работу с модулями.
use app\ext\Modules;

// Импортирование глобального класса отвечающего за работу с базами данных.
use app\ext\Db;

// Импортирование класса уведомлений.
use app\ext\Notifications;

// Импортирование глобального класса отвечающего за работу с авторизованными пользователями.
use app\ext\Auth;

// Импортирование графического класса.
use app\ext\Graphics;

// __autoload()
spl_autoload_register( function( $class ) {
    $path = str_replace( '\\', '/', $class . '.php' );
    file_exists( $path ) && require $path;
} );

// Создание основного экземпляра класса.
$General        = new General;

// Создание экземпляра класса работающего с модулями.
$Modules        = new Modules ( $General );

// Создание экземпляра класса работающего с базами данных.
$Db             = new Db;

// Создание экземпляра класса уведомлений.
$Notifications  = new Notifications ( $General, $Db, $Modules );

// Создание экземпляра класса работающего с авторизацией пользователей.
$Auth           = new Auth          ( $General );

// Создание экземпляра графического класса.
$Graphics       = new Graphics      ( $General, $Modules, $Db );