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
define('VERSION', '0.2.109');

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

// Директория с шаблонами "Sidebars".
define('SIDEBARS', 'storage/assets/css/sidebars/');

// Директория с шаблонами "Themes".
define('THEMES', 'storage/assets/css/themes/');

// Директория с изображениями рангов.
define('RANKS_PACK', 'storage/cache/img/ranks/');

// Регистраниция основных функций.
require INCLUDES . 'functions.php';

// Создание/возобновление сессии.
session_start();

// Включение буферизации.
ob_start();

// Импортирование глобального класса отвечающего за работу с модулями.
use app\ext\Modules;

// Импортирование основного глобального класса.
use app\ext\General;

// Импортирование глобального класса отвечающего за работу с базами данных.
use app\ext\Db;

// Импортирование графического класса.
use app\ext\Graphics;

// __autoload()
spl_autoload_register( function( $class ) {
    $path = str_replace( '\\', '/', $class . '.php' );
    file_exists( $path ) && require $path;
} );

// Создание экземпляра класса работающего с модулями.
$Modules    = new Modules;

// Создание основного экземпляра класса.
$General    = new General ( $Modules );

// Создание экземпляра класса работающего с базами данных.
$Db         = new Db;

// Создание экземпляра графического класса.
$Graphics   = new Graphics ( $General, $Modules, $Db );