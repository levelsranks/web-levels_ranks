<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

class Admin {

    function __construct( $General, $Modules, $Auth, $Db ) {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        // Ведущая проверка.
        ( empty( $_SESSION['steamid32'] ) || ! isset( $_SESSION['user_admin'] ) ) && get_iframe( '013','Доступ закрыт' ) && die();

        $this->General = $General;

        $this->Modules = $Modules;

        $this->Db = $Db;
    }

    /**
     * Полностью очистить кэш вэб-приложения включая кэш модулей.
     */
    function action_clear_all_cache() {
        // Ссылки на кэшируемые файлы.
        $cache_files = [ 'modules_cache' => SESSIONS . 'modules_cache.php',
            'translator_cache' => SESSIONS . 'translator_cache.php',
            'css_and_js_actual_library_cache' => SESSIONS . 'actual_library.json',
            'css_cache' => ASSETS_CSS . '/generation/style_generated.min.ver.' . $this->Modules->actual_library['actual_css_ver'] . '.css',
            'js_cache' => ASSETS_JS . '/generation/app_generated.min.ver.' . $this->Modules->actual_library['actual_js_ver'] . '.js'
        ];

        // Очищаем кэш каждого модуля.
        for ( $i = 0; $i < $this->Modules->array_modules_count; $i++ ):
            $module = array_keys( $this->Modules->array_modules )[ $i ];

            // При существовании файла кэша, удалить его.
            file_exists( MODULES . $module . '/temp/cache.php' ) && unlink(MODULES . $module . '/temp/cache.php');
        endfor;

        // Удаляем файл с описанием каждого модуля.
        file_exists( $cache_files['modules_cache'] ) && unlink( $cache_files['modules_cache'] );

        // Удаляем файл с переводами.
        file_exists( $cache_files['translator_cache'] ) && unlink( $cache_files['translator_cache'] );

        // Удаляем файл с информацией о актульаных версиях кэша стилей и JS библиотек.
        file_exists( $cache_files['css_and_js_actual_library_cache'] ) && unlink( $cache_files['css_and_js_actual_library_cache'] );

        // Удаляем файл с генерируемыми стилями.
        file_exists( $cache_files['css_cache'] ) && unlink( $cache_files['css_cache'] );

        // Удаляем файл с генерируемыми JS библиотекой.
        file_exists( $cache_files['js_cache'] ) && unlink( $cache_files['js_cache'] );

        // Обновление страницы.
        refresh();
    }

    /**
     * Очистить порядок загрузки модулей.
     */
    function action_clear_modules_initialization() {
        // Ссылки на кэшируемые файлы.
        $cache_files = ['modules_initialization' => SESSIONS . 'modules_initialization.php'];

        // Удаляем файл с порядком инициализации модулей.
        file_exists( $cache_files['modules_initialization'] ) && unlink( $cache_files['modules_initialization'] );

        // Очистка кэша вэб-приложения.
        $this->action_clear_all_cache();
    }

    /**
     * Редактирования порядка загрузки модулей.
     */
    function edit_modules_initialization() {

        $array = $this->Modules->arr_module_init;

        $data =  json_decode( $_POST['data'], true );

        for ( $i2 = 0, $c = sizeof( $data ); $i2 < $c; $i2++ ) {
            $_data[] = $data[ $i2 ]['id'];
        }

        get_section( 'module_page', 'home' ) == 'sidebar' ? $array['sidebar'] = $_data : $array['page'][ get_section( 'module_page', 'home' ) ]['interface'][ get_section( 'module_interface_adjacent', 'afternavbar' ) ] = $_data;

        file_put_contents( SESSIONS . 'modules_initialization.php', '<?php return '.var_export_min( $array, true ).";" );
    }

    /**
     * Очистить кэш переводов.
     */
    function action_clear_translator_cache() {
        // Ссылки на кэшируемые файлы.
        $cache_files = ['translator_cache' => SESSIONS . 'translator_cache.php'];

        // Удаляем файл с порядком инициализации модулей.
        file_exists( $cache_files['translator_cache'] ) && unlink( $cache_files['translator_cache'] );

        // Обновление страницы.
        refresh();
    }

    /**
     * Изменение параметров в '/storage/cache/sessions/options.php'.
     */
    function edit_options() {

        $arr = $this->General->arr_general;

        $option = [
            'full_name' => $_POST['full_name'],
            'short_name' => $_POST['short_name'],
            'info' => $_POST['info'],
            'language' => $_POST['language'],
            'web_key' => $_POST['web_key'],
            'avatars' => (int) $_POST['avatars'],
            'avatars_cache_time' => (int) $_POST['avatars_cache_time']
        ];

        // Обновление файла.
        file_put_contents( SESSIONS . 'options.php', '<?php return '.var_export_min( array_replace($arr, $option), true ).";" );

        // Обновление страницы.
        refresh();
    }

    /**
     * Изменение параметров в '/storage/cache/sessions/options.php'.
     */
    function action_db_add_mods() {

        $db = require SESSIONS . '/db.php';

        $db += [ $_POST['mod'] => []];
        // Обновление файла.
        file_put_contents( SESSIONS . 'db.php', '<?php return '.var_export_opt( $db, true ).";" );

        // Обновление страницы.
        header("Refresh: 0");
    }

    function action_db_add_connection() {

        $db = require SESSIONS . '/db.php';
        
        if (!isset($_POST['mod']) || !isset($_POST['type']) || $_POST['type'] != 'table' && $_POST['type'] != 'db') 
            return ['error' => 'Ошибка'];

        $mod = $_POST['mod'];
        $type = $_POST['type'];

        if ($type == 'db') {

            if (empty($_POST['host']))          return ['error' => 'Введите хост!'];                        else $host = $_POST['host'];
            if (empty($_POST['db_name']))       return ['error' => 'Введите название базы данных!'];        else $db_name = $_POST['db_name'];
            if (empty($_POST['password']))      return ['error' => 'Введите пароль пользователя бд!'];      else $password = $_POST['password'];
            if (empty($_POST['username']))      return ['error' => 'Введите имя пользователя бд!'];         else $username = $_POST['username'];
            if (empty($_POST['port']))          return ['error' => 'Введите порт!'];                        else $port = $_POST['port'];
            if (empty($_POST['table_name']))    return ['error' => 'Введите название таблицы!'];            else $table_name = $_POST['table_name'];
            $server_name = empty($_POST['server_name']) ? '' : $_POST['server_name'];
            $steam_mod = empty($_POST['steam_mod']) ? '1' : $_POST['steam_mod'];
            $game_mod = empty($_POST['game_mod']) ? '730' : $_POST['game_mod'];
            if ($mod == 'LevelsRanks' && empty($_POST['rank_pack'])) {       
                return ['error' => 'Введите пакет рангов!'];  
            }                      
            else {
                $rank_pack = $_POST['rank_pack'];
            }

            $query = ['HOST' => $host, 'PORT' => $port, 'USER' => $username, 'PASS' => $password, 'DB' =>[0 =>['DB' => $db_name,'Prefix' =>[0 =>['table' => $table_name, 'name' => $server_name,'mod' => $game_mod,'steam' => $steam_mod]]]]];
            if ($mod == 'LevelsRanks') {
                $query['DB'][0]['Prefix'][0]['ranks_pack'] = $rank_pack;
            }
            if(empty($db[$mod])) {
                $db[$mod] = [0 => $query];
                file_put_contents( SESSIONS . 'db.php', '<?php return '.var_export_opt( $db, true ).";" );
                return ['success' => 'Новый мод создан!']; 
            } else {
                $db[$mod][] = $query;
                file_put_contents( SESSIONS . 'db.php', '<?php return '.var_export_opt( $db, true ).";" );
                return ['success' => 'Новая база данных добавлена!']; 
            }
        }

        if ($type == 'table') {
            if (empty($db[$mod]))                                                           return ['error' => 'Сначала создайте базу данных!'];
            if (empty($_POST['db_name_for_table']) || $_POST['db_name_for_table'] == '-1') {
                return ['error' => 'Выберите базу данных!']; 
            }
            else {
                $db_name_for_table = $_POST['db_name_for_table'];
            }
            if (empty($_POST['table_name']))                            return ['error' => 'Введите название таблицы!'];    else $table_name = $_POST['table_name'];
            if ($mod == 'LevelsRanks' && empty($_POST['rank_pack']))    return ['error' => 'Введите пакет рангов!'];        else $rank_pack = $_POST['rank_pack'];
            $server_name = empty($_POST['server_name']) ? '' : $_POST['server_name'];
            $steam_mod = empty($_POST['steam_mod']) ? '1' : $_POST['steam_mod'];
            $game_mod = empty($_POST['game_mod']) ? '730' : $_POST['game_mod'];
            
            foreach ($db[$mod] as $num => $connection) {
                if ($connection['DB'][0]['DB'] == $db_name_for_table) {
                    $query = [ 'table' => $table_name, 'name' => $server_name, 'mod' => $steam_mod, 'steam' => $game_mod];
                    if ($mod == 'LevelsRanks') {
                        $query['ranks_pack'] = $rank_pack;
                    }
                    $db[$mod][$num]['DB'][0]['Prefix'][] = $query;
                    file_put_contents( SESSIONS . 'db.php', '<?php return '.var_export_opt( $db, true ).";" );
                    return ['success' => 'Новая таблица добавлена!']; 
                }
            }
            return ['error' => 'Указанная база данных не найдена!'];
        }
        return ['error' => 'Неизвестная ошибка!'];
    }

    /**
     * Добавление сервера
     */
    function action_add_server() {

        $params = ['server_ip_port' => $_POST['server_ip_port'] ?? 0,
                   'server_ip_port_fake' => $_POST['server_ip_port_fake'] ?? 0,
                   'server_name' => $_POST['server_name'] ?? 0,
                   'server_name_custom' => $_POST['server_name_custom'] ?? 0,
                   'server_rcon' => $_POST['server_rcon'] ?? 0,
                   'server_stats' => $_POST['server_stats'] ?? 0,
                   'server_vip' => $_POST['server_vip'] ?? 0,
                   'server_vip_id' => $_POST['server_vip_id'] ?? 0,
                   'server_sb' => $_POST['server_sb'] ?? 0,
                   'server_shop' => $_POST['server_shop'] ?? 0,
                   'server_warnsystem' => $_POST['server_warnsystem'] ?? 0,
                   'server_lk' => $_POST['server_lk'] ?? 0
                  ];

        $this->Db->query( 'Core', 0, 0, "INSERT INTO lvl_web_servers VALUES (NULL,
                                                              :server_ip_port,
                                                              :server_ip_port_fake,
                                                              :server_name,
                                                              :server_name_custom,
                                                              :server_rcon,
                                                              :server_stats,
                                                              :server_vip,
                                                              :server_vip_id,
                                                              :server_sb,
                                                              :server_shop,
                                                              :server_warnsystem,
                                                              :server_lk);", $params );

        // Обновление страницы.
        refresh();
    }

    /**
     * Удаление сервера
     */
    function action_del_server() {
        $params = ['id' => $_POST['del_server']];

        $this->Db->query( 'Core', 0, 0, 'DELETE FROM lvl_web_servers WHERE id = :id', $params );
    }

    /**
     * Редактирование параметров определенного модуля.
     */
    function edit_module() {

        $Module_data = $this->Modules->array_modules[ $_GET['options'] ];

        // А где цикл то, что за беспредел? :D
        $Module_data['page'] = $_POST['module_page'];
        $Module_data['setting']['status'] = $_POST['module_offon'] == 'on' ? 1 : 0;
        $Module_data['setting']['type'] = (int) $_POST['module_type'] ?? 0;
        $Module_data['setting']['translation'] = $_POST['module_translation'] == 'on' ? 1 : 0;
        $Module_data['setting']['interface'] = $_POST['module_interface'] == 'on' ? 1 : 0;
        $Module_data['setting']['data'] = $_POST['module_data'] == 'on' ? 1 : 0;
        $Module_data['setting']['data_always'] = $_POST['module_data_always'] == 'on' ? 1 : 0;
        $Module_data['setting']['css'] = $_POST['module_css'] == 'on' ? 1 : 0;
        $Module_data['setting']['js'] = $_POST['module_js'] == 'on' ? 1 : 0;
        $Module_data['setting']['cache_enable'] = $_POST['module_cache_enable'] == 'on' ? 1 : 0;
        $Module_data['setting']['cache_time'] = (int) $_POST['module_cache_time'] ?? 0;

        file_put_contents( MODULES . $_GET['options'] . '/description.json', json_encode( $Module_data, JSON_UNESCAPED_UNICODE ) );

        $modules_init = $this->Modules->arr_module_init;

        if( ! empty( $Module_data['sidebar'] ) && ! in_array( $_GET['options'], $modules_init['sidebar'] ) ) {
            $modules_init['sidebar'] =+ $_GET['options'];
        }

        file_put_contents( SESSIONS . '/modules_initialization.php', '<?php return '.var_export_min( $modules_init, true ).";" );

        $this->action_clear_all_cache();
    }
}