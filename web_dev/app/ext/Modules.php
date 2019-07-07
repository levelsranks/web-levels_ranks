<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

namespace app\ext;

class Modules extends General {

    /**
     * Организация работы вэб-приложения с модулями.
     */
    function __construct() {
        // Получение кэшированного списка модулей.
        $this->array_modules = $this->get_arr_modules();

        // Подсчёт количества модулей.
        $this->array_modules_count = sizeof( $this->array_modules );

        // Получение списка инициализвации модулей в определенном порядке.
        $this->arr_module_init = $this->get_module_init();

        $this->arr_module_init_page_count = sizeof( $this->arr_module_init['page'] );

        // Проверка для роутера страниц

        empty( $this->arr_module_init['page'][ $_GET["page"] ] ) && $_GET["page"] != '' && get_iframe( '009', 'Данная страница не существует' );

        // Получение кэшированного листа переводов.
        $this->arr_translations = require SESSIONS . 'translator_cache.php';
    }

    /**
     * Инициализация модулей.
     *
     * @return array         Возвращает список модулей для инициализации.
     */
    public function get_module_init() {
        // При отсутствии списока модулей для дальнейшей инициализации, выполняется создание данного списка.
        if ( !file_exists( SESSIONS . 'modules_initialization.php' ) ) {
            $result = [];

            // Перебором забираем корневое название модулей.
            for ( $i = 0; $i < $this->array_modules_count; $i++ ):
                 $module = array_keys( $this->array_modules )[ $i ];
                if (
                     $this->array_modules[ $module ]['setting']['status'] == 1
                     && $this->array_modules[ $module ]['required']['php'] <= phpversion()
                     && $this->array_modules[ $module ]['required']['core'] <= VERSION
                 ):
                     $this->array_modules[ $module ]['setting']['interface'] == 1 && $result['page'][ $this->array_modules[ $module ]['page'] ]['interface'][] = $module;
                     $this->array_modules[ $module ]['setting']['data'] == 1 && $result['page'][ $this->array_modules[ $module ]['page'] ]['data'][] = $module;
                     $this->array_modules[ $module ]['setting']['css'] == 1 && $result['page'][ $this->array_modules[ $module ]['page'] ]['css'][] = $module;
                     $this->array_modules[ $module ]['setting']['js'] == 1 && $result['page'][ $this->array_modules[ $module ]['page'] ]['js'][] = $module;
                     $this->array_modules[ $module ]['sidebar'] != '' && $result['sidebar'][] = $module;
                 endif;
            endfor;

            // Сохраняем наш файл с перебором модулей.
            file_put_contents( SESSIONS . 'modules_initialization.php', '<?php return '.var_export_min( $result ).";\n" );
        }
        return require SESSIONS . 'modules_initialization.php';
    }

    /**
     * Получение кэша определенного модуля.
     *
     * @param string $module       Корневое название модуля.
     *
     * @return array|false         Возвращает кэш модуля.
     */
    public function get_module_cache( $module ) {
        return file_exists(MODULES_SESSIONS . $module . '/cache.php') ? require MODULES_SESSIONS . $module . '/cache.php' : false;
    }

    /**
     * Задать кэш для определенного модуля.
     *
     * @param string $module        Корневое название модуля.
     * @param array $data           Массив данных.
     */
    public function set_module_cache( $module, $data ) {
        file_put_contents( MODULES_SESSIONS . $module . '/cache.php', '<?php return '.var_export_min( $data ).";" );
    }

    /**
     * Получить перевод определенной фразы из общего кэша.
     *
     * @param string $phrase        Слово для перевода.
     *
     * @return string               Выводит слово в переводе.
     */
    public function get_translate_phrase( $phrase ) {
        return $this->arr_translations[ $phrase ][ $_SESSION['language'] ];
    }

    /**
     * Получить перевод определенной фразы из кэша модуля.
     *
     * @param string $module_id       Название модуля.
     * @param string $phrase            Слово для перевода.
     *
     * @return string                   Выводит слово в переводе.
     */
    public function get_translate_module_phrase( $module_id, $phrase ) {
        return $this->arr_translations[ $module_id ][ $phrase ][ $_SESSION['language'] ];
    }

    /**
     * Получение кэша модулей.
     *
     * @return array            Выводит массив с полным описанием модулей.
     */
    public function get_arr_modules() {
        $result = [];
        $result_translation = [];

        // Проверка на существование кэша модулей и кэша переводов.
        if ( ! file_exists( SESSIONS . 'modules_cache.php' ) || ! file_exists( SESSIONS . 'translator_cache.php' ) ) {
            // Сканирование папки с модулями.
            $this->scan_modules = array_diff( scandir( MODULES, 1 ), array( '..', '.' ) );

            // Подсчёт количества модулей.
            $this->array_modules_count = sizeof( $this->scan_modules );

            if( $this->array_modules_count != 0 ) {
            // Цикл перебора описания модулей.
            for ( $i = 0; $i < $this->array_modules_count; $i++ ) {
                // Получение описания определенного модуля.
                $result[ $this->scan_modules[ $i ] ] = json_decode(file_get_contents(MODULES . $this->scan_modules[ $i ] . '/description.json') , true);

                // Проверка на поддержку мульти-перевода.
                if ($result[ $this->scan_modules[ $i ] ]['setting']['translation'] == 1) {
                    // Получение кэша перевода модулей.
                    $result_translation[ $this->scan_modules[ $i ] ] = json_decode(file_get_contents(MODULES_SESSIONS . $this->scan_modules[ $i ] . '/translation.json') , true);
                }
            }
            // Объединение общего кэша мульти-перевода с кэшэм модулей.
            $result_translation += require SESSIONS . 'translator.php';
            }

            // Создание/редактирование кэша модулей.
            file_put_contents( SESSIONS . 'modules_cache.php', '<?php return '.var_export_min( $result ).";" );

            // Создание/редактирование кэша мульти-переводов.
            file_put_contents( SESSIONS . 'translator_cache.php', '<?php return '.var_export_min( $result_translation ).";" );
        }
        return require SESSIONS . 'modules_cache.php';
    }
}