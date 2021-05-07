<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

/**
 * Хуже не было давно -
 * Я пробиваю третье дно.
 * Море нечем потрясти.
 * Выживают лопасти.
 */

// Ведущая проверка.
( ! isset( $_SESSION['user_admin'] ) ) && get_iframe( '013','Доступ закрыт' ) && die();

// Импортирования класса для работы с панелью администратора.

use app\ext\Pdox;
use app\modules\module_page_adminpanel\ext\Admin;

// Создаём экземпляр класса для работы с админкой
$Admin = new Admin ( $General, $Modules, $Auth, $Db, $Translate );

# Настройки модулей

// Нажатие на кнопку - Очистить кэш модулей.
isset( $_POST['clear_cache_modules'] ) && $Admin->action_clear_all_cache();

// Нажатие на кнопку - Обновить список модулей.
isset( $_POST['clear_modules_initialization'] ) && $Admin->action_clear_modules_initialization();

// Нажатие на кнопку - Очистить кэш перевоов.
isset( $_POST['clear_translator_cache'] ) && $Admin->action_clear_translator_cache();

// Перемещение блоков - Порядок загрузки модулей.
isset( $_POST['data'] ) && $Admin->edit_modules_initialization();

// Нажатие на кнопку - Настрйоки модуля -> Сохранить.
isset( $_POST['module_save'] ) && $Admin->edit_module();

# Основные настройки

// Нажатие на кнопку - Основные настройки -> Сохранить.
isset( $_POST['option_one_save'] ) && $Admin->edit_options();

# Настройка базы данных

// Нажатие на кнопку - Добавить мод.
isset( $_POST['add_mods'] ) && $Admin->action_db_add_mods();

// Нажатие на кнопку - Добавить сервер.
isset( $_POST['save_server'] ) && $Admin->action_add_server();

// Нажатие на кнопку - Удалить сервер.
isset( $_POST['del_server'] ) && $Admin->action_del_server();

// Нажатие на кнопку - Добавить DB.
isset( $_POST['function'] ) && $Admin->action_db_add_connection();

!empty($_GET['section']) && $_GET['section'] == 'stats' ? $Chart_Visits =  $Admin->charts_attendance() : NULL;

#Настройка шаблонов

//Нажатие на кнопку - Очистить кеш шаблонов
isset( $_POST['clear_templates_cache'] ) && $Admin->clear_templates_cache();

// Задаём заголовок страницы.
$Modules->set_page_title( $General->arr_general['short_name'] . ' :: ' . $Translate->get_translate_phrase('_Admin_panel') );