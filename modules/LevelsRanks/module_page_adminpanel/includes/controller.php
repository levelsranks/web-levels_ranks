<?php
/**
 * @author WizZzarD <artur.rusanov2013@gmail.com>
 *
 * @link https://steamcommunity.com/id/WizzarD_1/
 *
 * @license GNU General Public License Version 3
 */
// Отключаем вывод ошибок.
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

// Ограничиваем время выполнения скрипта.
set_time_limit(4);

// Нахожение в пространстве LR.
define('IN_LR', true);

// Основная директория вэб-приложения.
define('APP', '../../../../app/');

// Основная директория вэб-приложения.
define('STORAGE', '../../../../storage/');

// Директория содержащая основные блоки вэб-приложения.
define('PAGE', APP . 'page/general/');

// Директория содержащая дополнительные блоки вэб-приложения.
define('PAGE_CUSTOM', APP . 'page/custom/');

// Директория с модулями.
define('MODULES', APP . 'modules/');

// Директория с основными конфигурационными файлами.
define('INCLUDES', APP . 'includes/');

// Директория содержащая графические кэш-файлы.
define('CACHE', STORAGE . 'cache/');

// Директория с ресурсами.
define('ASSETS', STORAGE . 'assets/');

// Директория с основными кэш-файлами.
define('SESSIONS', CACHE . 'sessions/');

// Директория содержащая логи.
define('LOGS', CACHE . 'logs/');

// Директория содержащая изображения.
define('IMG', CACHE . 'img/');

// Директория с CSS шаблонами.
define('ASSETS_CSS', ASSETS . 'css/');

// Директория с JS библиотеками.
define('ASSETS_JS', ASSETS . 'js/');

// Директория с шаблонами "Themes".
define('THEMES', ASSETS_CSS . 'themes/');

// Директория с изображениями рангов.
define('RANKS_PACK', IMG . 'ranks/');

// Временные константы ( Постоянные времени ) - Минута.
define('MINUTE_IN_SECONDS', 60);

// Временные константы ( Постоянные времени ) - Час.
define('HOUR_IN_SECONDS', 3600);

// Временные константы ( Постоянные времени ) - День.
define('DAY_IN_SECONDS', 86400);

// Временные константы ( Постоянные времени ) - Неделя.
define('WEEK_IN_SECONDS', 604800);

// Временные константы ( Постоянные времени ) - Месяц.
define('MONTH_IN_SECONDS', 2592000);

// Временные константы ( Постоянные времени ) - Год.
define('YEAR_IN_SECONDS', 31536000);

// Запускаем сессию
session_start();

// Регистраниция основных функций.
require '../../../includes/functions.php';

// Импортирование класса базы данных.
require_once '../../../ext/Db.php';

// Импортирование класса отвечающего за работу с языками и переводами.
require_once '../../../ext/Translate.php';

// Импортирование класса отвечающего за работу с уведомлениями.
require_once '../../../ext/Notifications.php';

// Импортирование основного класса настроек.
require_once '../../../ext/General.php';

// Импортирование класса отвечающего за работу с модулями.
require_once '../../../ext/Modules.php';

// Импортирование класса отвечающего за работу с авторизацией.
require_once '../../../ext/Auth.php';

// Импортирования класса для работы с панелью администратора.
require_once '../ext/Admin.php';


$Translate      = new \app\ext\Translate;

$Db             = new \app\ext\Db();

$Notifications  = new \app\ext\Notifications ( $Translate, $Db );

$General        = new \app\ext\General ( $Db );

$Modules        = new \app\ext\Modules       ( $General, $Translate, $Notifications );

$Auth           = new \app\ext\Auth          ( $General, $Db );

// Создаём экземпляр класса для работы с админкой
$Admin = new Admin ( $General, $Modules, $Auth, $Db, $Translate);

if (isset($_POST['function']) && $_POST['function'] == 'add_conection') {
    $result = $Admin->action_db_add_connection();
    echo json_encode($result);
}