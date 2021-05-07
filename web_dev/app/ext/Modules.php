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

class Modules {

    /**
     * @since 0.2
     * @var array
     */
    public $array_modules = [];

    /**
     * @since 0.2
     * @var int
     */
    public $array_modules_count = 0;

    /**
     * @since 0.2
     * @var array
     */
    public $arr_module_init = [];

    /**
     * @since 0.2
     * @var int
     */
    public $arr_module_init_page_count = 0;

    /**
     * @since 0.2
     * @var array
     */
    public $arr_user_info = [];

    /**
     * @since 0.2
     * @var array
     */
    public $scan_modules = [];

    /**
     * @since 0.2
     * @var array
     */
    public $scan_ranks_pack = [];

    /**
     * @since 0.2
     * @var int
     */
    public $array_ranks_pack_count = 0;

    /**
     * @since 0.2
     * @var array
     */
    public $actual_library = [];

    /**
     * @since 0.2
     * @var array
     */
    public $css_library = [];

    /**
     * @since 0.2
     * @var array
     */
    public $js_library = [];

    /**
     * @since 0.2
     * @var string
     */
    public $page_title = '';

    /**
     * @since 0.2
     * @var string
     */
    public $page_description = '';

    /**
     * @since 0.2
     * @var string
     */
    public $page_image = '';

    /**
     * @since 0.2
     * @var object
     */
    public $General;

    /**
     * @since 0.2.122
     * @var object
     */
    public $Translate;

    /**
     * @since 0.2.122
     * @var object
     */
    public $Notifications;

    /**
     * Организация работы вэб-приложения с модулями.
     *
     * @param object $General
     * @param object $Translate
     * @param object $Notifications
     *
     * @since 0.2
     */
    function __construct( $General, $Translate, $Notifications ) {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        $this->General = $General;

        $this->Translate = $Translate;

        $this->Notifications = $Notifications;

        // Получение кэшированного списка модулей.
        $this->array_modules = $this->get_arr_modules();

        // Подсчёт количества модулей.
        $this->array_modules_count = sizeof( $this->array_modules );

        // Получение списка инициализвации модулей в определенном порядке.
        $this->arr_module_init = $this->get_module_init();
        
        $this->arr_module_init_page_count = sizeof( $this->arr_module_init['page'] );

        // Библиотека актуальности.
        $this->actual_library = $this->get_actual_library();

        //isset( $_SESSION['user_admin'] ) && $this->check_actual_modules_list();

        // Проверка JS файлов.
        $this->check_generated_js();

        // Проверка таблици стилей.
        $this->check_generated_style();

        // Проверка для роутера страниц
        ! empty( $_GET["page"] ) && empty( $this->arr_module_init['page'][ $_GET["page"] ] ) && get_iframe( '009', 'Данная страница не существует' );
    }

    /**
     * Получить библиотеку актуальных данных.
     *
     * @since 0.2.122
     *
     * @return array    Актуальная информация.
     */
    public function get_actual_library() {
        if( file_exists( SESSIONS . '/actual_library.json' ) ):
            return json_decode( file_get_contents( SESSIONS . '/actual_library.json') , true );
        else:
            $actual = ['actual_css_ver' => 0, 'actual_js_ver' => 0, 'actual_modules_count' => 0];
            file_put_contents( SESSIONS . '/actual_library.json', json_encode( $actual ) );
            return $actual;
        endif;
    }

    /**
     * Проверка на актуальный список модулей.
     *
     * @since 0.2.122
     */
    public function check_actual_modules_list() {
        // Сканирование папки с модулями.
        $scan_modules = array_diff( scandir( MODULES, 1 ), array( '..', '.', 'disabled' ) );

        // Подсчёт количества модулей.
        $scan_modules_count = sizeof( $scan_modules );

        if( $this->actual_library['actual_modules_count'] != $scan_modules_count ):
            if( $scan_modules_count > $this->actual_library['actual_modules_count'] ):
                $modules = array_values( array_diff ( $scan_modules, array_keys( $this->array_modules ) ) );
                for ( $i = 0, $c = sizeof( $modules ); $i < $c; $i++ ):
                    $modules_desc[ $modules[ $i ] ] = json_decode( file_get_contents( MODULES . $modules[ $i ] . '/description.json') , true);
                endfor;
                $final = $this->array_modules + $modules_desc;

                else:

            endif;
        endif;
    }

    /**
     * Инициализация модулей.
     *
     * @since 0.2
     *
     * @return array         Возвращает список модулей для инициализации.
     */
    public function get_module_init() {
        
        // При отсутствии списока модулей для дальнейшей инициализации, выполняется создание данного списка.
        if ( ! file_exists( SESSIONS . 'modules_initialization.php' ) ):

            $result = [];

            for ( $i = 0; $i < $this->array_modules_count; $i++ ):

                // Перебором забираем корневое название модуля.
                $module = array_keys( $this->array_modules )[ $i ];
                if (
                     $this->array_modules[ $module ]['setting']['status'] == 1
                     && $this->array_modules[ $module ]['required']['php'] <= PHP_VERSION
                     && $this->array_modules[ $module ]['required']['core'] <= VERSION
                     && $this->array_modules[ $module ]['page'] != 'all'
                 ):
                    if( ! empty( $this->array_modules[ $module ]['setting']['interface'] ) && $this->array_modules[ $module ]['setting']['interface'] == 1 ):
                        $result['page'][ $this->array_modules[ $module ]['page'] ]['interface'][ empty( $this->array_modules[ $module ]['setting']['interface_adjacent'] ) ? 'afternavbar' : $this->array_modules[ $module ]['setting']['interface_adjacent'] ][] = $module;
                    endif;
                    if( ! empty( $this->array_modules[ $module ]['setting']['interface_always'] ) && $this->array_modules[ $module ]['setting']['interface_always'] == 1 ):
                        $result['interface_always'][ empty( $this->array_modules[ $module ]['setting']['interface_always_adjacent'] ) ? 'afternavbar' : $this->array_modules[ $module ]['setting']['interface_always_adjacent'] ][] = ['name' => $module ] ;
                    endif;
                    ! empty( $this->array_modules[ $module ]['setting']['data'] ) && $this->array_modules[ $module ]['setting']['data'] == 1 && $result['page'][ $this->array_modules[ $module ]['page'] ]['data'][] = $module;
                    ! empty( $this->array_modules[ $module ]['setting']['data_always'] ) && $this->array_modules[ $module ]['setting']['data_always'] == 1 && $result['data_always'][] = $module;
                    ! empty( $this->array_modules[ $module ]['setting']['js'] ) && $this->array_modules[ $module ]['setting']['js'] == 1 && $result['page'][ $this->array_modules[ $module ]['page'] ]['js'][] = ['name' => $module, 'type' => $this->array_modules[ $module ]['setting']['type']];
                    ! empty( $this->array_modules[ $module ]['setting']['css'] ) && $this->array_modules[ $module ]['setting']['css'] == 1 && $result['page'][ $this->array_modules[ $module ]['page'] ]['css'][] = ['name' => $module, 'type' => $this->array_modules[ $module ]['setting']['type']];
                    ! empty( $this->array_modules[ $module ]['sidebar'] ) && $result['sidebar'][] = $module;
                 endif;
            endfor;

            for ( $i2 = 0; $i2 < $c = sizeof( $result['page'] ); $i2++ ):

                // Перебором забираем корневое название страницы.
                $page = array_keys( $result['page'] )[ $i2 ];

                for ( $i = 0; $i < $this->array_modules_count; $i++ ):

                    // Перебором забираем корневое название модуля.
                    $module = array_keys( $this->array_modules )[ $i ];

                    if (
                        $this->array_modules[ $module ]['setting']['status'] == 1
                        && $this->array_modules[ $module ]['required']['php'] <= PHP_VERSION
                        && $this->array_modules[ $module ]['required']['core'] <= VERSION
                        && $this->array_modules[ $module ]['page'] == 'all'
                    ):
                        if( ! empty( $this->array_modules[ $module ]['setting']['interface'] ) && $this->array_modules[ $module ]['setting']['interface'] == 1 ):
                            $result['page'][ $page ]['interface'][ empty( $this->array_modules[ $module ]['setting']['interface_adjacent'] ) ? 'afternavbar' : $this->array_modules[ $module ]['setting']['interface_adjacent'] ][] = $module;
                        endif;
                        if( ! empty( $this->array_modules[ $module ]['setting']['interface_always'] ) && $this->array_modules[ $module ]['setting']['interface_always'] == 1 ):
                            $result['interface_always'][ empty( $this->array_modules[ $module ]['setting']['interface_always_adjacent'] ) ? 'afternavbar' : $this->array_modules[ $module ]['setting']['interface_always_adjacent'] ][] = ['name' => $module ] ;
                        endif;
                        ! empty( $this->array_modules[ $module ]['setting']['data'] ) && $this->array_modules[ $module ]['setting']['data'] == 1 && $result['page'][ $page ]['data'][] = $module;
                        ! empty( $this->array_modules[ $module ]['setting']['data_always'] ) && $this->array_modules[ $module ]['setting']['data_always'] == 1 && $result['data_always'][] = $module;
                        ! empty( $this->array_modules[ $module ]['setting']['js'] ) && $this->array_modules[ $module ]['setting']['js'] == 1 && $result['page'][ $page ]['js'][] = ['name' => $module, 'type' => $this->array_modules[ $module ]['setting']['type']];
                        ! empty( $this->array_modules[ $module ]['setting']['css'] ) && $this->array_modules[ $module ]['setting']['css'] == 1 && $result['page'][ $page ]['css'][] = ['name' => $module, 'type' => $this->array_modules[ $module ]['setting']['type']];
                        ! empty( $this->array_modules[ $module ]['sidebar'] ) && $result['sidebar'][] = $module;
                    endif;
                endfor;
            endfor;


            // Сохраняем наш файл с перебором модулей.
            file_put_contents( SESSIONS . 'modules_initialization.php', '<?php return '.var_export_min( $result ).";\n" );
        endif;
        return require SESSIONS . 'modules_initialization.php';
    }

    /**
     * Получение кэша определенного модуля.
     *
     * @since 0.2
     *
     * @param string $module       Корневое название модуля.
     *
     * @return array|false         Возвращает кэш модуля.
     */
    public function get_module_cache( $module ) {
        if( file_exists(MODULES . $module . '/temp/cache.php' ) ):
            return require MODULES . $module . '/temp/cache.php';
        else:
            ! file_exists( MODULES . $module . '/temp' ) && mkdir( MODULES . $module . '/temp', 0777, true );
            file_put_contents( MODULES . $module . '/temp/cache.php', '<?php return [];' );
            return [];
        endif;
    }

    /**
     * Задать кэш для определенного модуля.
     *
     * @since 0.2
     *
     * @param string $module        Корневое название модуля.
     * @param array $data           Массив данных.
     */
    public function set_module_cache( $module, $data ) {
        ! file_exists( MODULES . $module . '/temp' ) && mkdir( MODULES . $module . '/temp', 0777, true );
        file_put_contents( MODULES . $module . '/temp/cache.php', '<?php return '.var_export_min( $data ).";" );
    }

    /**
     * Получение кэша модулей.
     *
     * @since 0.2
     *
     * @return array            Выводит массив с полным описанием модулей.
     */
    public function get_arr_modules() {
        $result = [];

        // Проверка на существование кэша модулей и кэша переводов.
        if ( ! file_exists( SESSIONS . 'modules_cache.php' ) ) {
            // Сканирование папки с модулями.
            $this->scan_modules = array_diff( scandir( MODULES, 1 ), array( '..', '.', 'disabled' ) );

            // Подсчёт количества модулей.
            $this->array_modules_count = sizeof( $this->scan_modules );

            if( $this->array_modules_count != 0 ) {
                // Цикл перебора описания модулей.
                for ( $i = 0; $i < $this->array_modules_count; $i++ ) {
                    // Получение описания определенного модуля.
                    $result[ $this->scan_modules[ $i ] ] = json_decode( file_get_contents( MODULES . $this->scan_modules[ $i ] . '/description.json') , true);
                }

            }

            // Создание/редактирование кэша модулей.
            file_put_contents( SESSIONS . 'modules_cache.php', '<?php return '.var_export_min( $result ).";" );
        }
        return require SESSIONS . 'modules_cache.php';
    }

    /**
     * Проверка сгенерированного стиля.
     *
     * @since 0.2
     */
    public function check_generated_style() {
        if( empty( $this->General->arr_general['enable_css_cache'] ) ) :

            $this->css_library[] = THEMES . $this->General->arr_general['theme'] .'/style.css';

            // Подсчёт количества под-стилей.
            $css_library = array_diff( scandir( THEMES . $this->General->arr_general['theme'] .'/css_library/', 1 ), array( '..', '.' ) );

            // После проверки на существование подстиля, добавление ссылки подстиля в массив для компрессии.
            for ( $cgs = 0, $cgs_c = sizeof( $css_library ); $cgs < $cgs_c; $cgs++ ) {
                file_exists( THEMES . $this->General->arr_general['theme'] .'/css_library/' . $css_library[ $cgs ] . '/' . (int) $this->General->arr_general[ $css_library[ $cgs ] ] . '.css' ) && $this->css_library[] = THEMES . $this->General->arr_general['theme'] .'/css_library/' . $css_library[ $cgs ] . '/' . (int) $this->General->arr_general[ $css_library[ $cgs ] ] . '.css';
            }

        else:
            // При отсутствии списока модулей для дальнейшей инициализации, выполняется создание данного списка.
            if ( ! file_exists( SESSIONS . '/actual_library.json' ) || empty( $this->actual_library['actual_css_ver'] ) || ! file_exists( ASSETS_CSS . '/generation/style_generated.min.ver.' . $this->actual_library['actual_css_ver'] . '.css' ) ):

                $files_css_compress = [];

                // Проверка на существование каталога с генерируемыми файлами
                ! file_exists( ASSETS_CSS . 'generation' ) && mkdir( ASSETS_CSS . 'generation', 0777, true );

                // Если файл с темой существует, добавить ссылку на файл в массив для компрессии.
                file_exists( THEMES . $this->General->arr_general['theme'] .'/style.css' ) && $files_css_compress[0] = THEMES . $this->General->arr_general['theme'] .'/style.css';

                // Подсчёт количества под-стилей.
                $css_library = array_diff( scandir( THEMES . $this->General->arr_general['theme'] .'/css_library/', 1 ), array( '..', '.' ) );

                // После проверки на существование подстиля, добавление ссылки подстиля в массив для компрессии.
                for ( $cgs = 0, $cgs_c = sizeof( $css_library ); $cgs < $cgs_c; $cgs++ ) {
                    file_exists( THEMES . $this->General->arr_general['theme'] .'/css_library/' . $css_library[ $cgs ] . '/' . (int) $this->General->arr_general[ $css_library[ $cgs ] ] . '.css' ) && $files_css_compress[] = THEMES . $this->General->arr_general['theme'] .'/css_library/' . $css_library[ $cgs ] . '/' . (int) $this->General->arr_general[ $css_library[ $cgs ] ] . '.css';
                }

                for ( $i = 0; $i < $this->array_modules_count; $i++ ):

                    // Перебором забираем корневое название модуля.
                    $module = array_keys( $this->array_modules )[ $i ];

                    // Если модуль проходит проверку и имеет свою стилистику, то забираем ссылку на стиль в массив для компрессии.
                    if (
                        $this->array_modules[ $module ]['setting']['status'] == 1
                        && $this->array_modules[ $module ]['required']['php'] <= PHP_VERSION
                        && $this->array_modules[ $module ]['required']['core'] <= VERSION
                    ):
                        array_key_exists('css', $this->array_modules[ $module ]['setting'] ) && $this->array_modules[ $module ]['setting']['css'] == 1 && $files_css_compress[] = MODULES . $module . '/assets/css/' . $this->array_modules[ $module ]['setting']['type'] . '.css';
                    endif;
                endfor;

                // Сжимаем все файлы из массива.
                $final_css_compress = $this->action_css_compress( $files_css_compress );

                // Обновляем актуальность кэша.
                $this->actual_library['actual_css_ver'] = time();
                file_put_contents( SESSIONS . '/actual_library.json', json_encode( $this->actual_library ) );

                // Очистка старых кэш файлов
                $temp_files = glob(ASSETS_CSS . 'generation/*');
                foreach( $temp_files as $temp_file ){
                    if( is_file( $temp_file ) )
                        unlink( $temp_file );
                }

                // Сохраняем итоговый CSS файл.
                file_put_contents( ASSETS_CSS . '/generation/style_generated.min.ver.' . $this->actual_library['actual_css_ver'] . '.css', $final_css_compress );
            endif;
        endif;
    }

    /**
     * Проверка сгенерированного JavaScript.
     *
     * @since 0.2
     */
    public function check_generated_js() {

        if( empty( $this->General->arr_general['enable_js_cache'] ) ):

            $this->js_library[] = ASSETS_JS . 'app.js';
        else:
            // При отсутствии списока модулей для дальнейшей инициализации, выполняется создание данного списка.
            if ( ! file_exists( SESSIONS . '/actual_library.json' ) || ! file_exists( ASSETS_JS . '/generation/app_generated.min.ver.' . $this->actual_library['actual_js_ver'] . '.js' ) || empty( $this->actual_library['actual_js_ver'] ) ):

                // Проверка на существование каталога с генерируемыми файлами
                ! file_exists( ASSETS_JS . 'generation' ) && mkdir( ASSETS_JS . 'generation', 0777, true );

                file_exists( ASSETS_JS . '/app.js' ) && $files_js_compress[] = ASSETS_JS . '/app.js';

                // Перебором забираем корневое название модулей.
                for ( $i = 0; $i < $this->array_modules_count; $i++ ):
                    $module = array_keys( $this->array_modules )[ $i ];
                    if (
                        $this->array_modules[ $module ]['setting']['status'] == 1
                        && $this->array_modules[ $module ]['required']['php'] <= PHP_VERSION
                        && $this->array_modules[ $module ]['required']['core'] <= VERSION
                    ):
                        array_key_exists('js', $this->array_modules[ $module ]['setting'] ) && $this->array_modules[ $module ]['setting']['js'] == 1 && $files_js_compress[] = MODULES . $module . '/assets/js/' . $this->array_modules[ $module ]['setting']['type'] . '.js';
                    endif;
                endfor;

                $final_js_compress = $this->action_js_compress( $files_js_compress );

                $this->actual_library['actual_js_ver'] = time();

                // Обновляем options
                file_put_contents( SESSIONS . '/actual_library.json', json_encode( $this->actual_library ) );

                // Очистка старых кэш файлов
                $temp_files = glob( ASSETS_JS . 'generation/*' );
                foreach( $temp_files as $temp_file ) {
                    if( is_file( $temp_file ) )
                        unlink( $temp_file );
                }

                // Сохраняем итоговый JS файл.
                file_put_contents( ASSETS_JS . '/generation/app_generated.min.ver.' . $this->actual_library['actual_js_ver'] . '.js', $final_js_compress );
            endif;
        endif;
    }

    /**
     * Самостоятельно добавить раздел в sidebar.
     *
     * @since 0.2
     *
     * @param string $module_id         ID модуля.
     * @param array $array              Опции раздела.
     */
    public function set_sidebar_select( $module_id, $array ) {
        if ( ! in_array( $module_id, $this->arr_module_init['sidebar'] ) ):
            $this->arr_module_init['sidebar'][] = $module_id;
            $this->array_modules[ $module_id ]['sidebar'][] = $array;
        else:
            $this->array_modules[ $module_id ]['sidebar'][] = $array;
        endif;
    }

    /**
     * Добавление какого-либо текста в информационный блок авторизованного игрока в sidebar.
     *
     * @since 0.2
     *
     * @param string $text             Опции раздела.
     */
    public function set_user_info_text( $text ) {
        $this->arr_user_info[] = $text;
    }

    /**
     * Задать заглавие страницы.
     *
     * @since 0.2
     *
     * @param string $text             Заголовок страницы.
     */
    public function set_page_title( $text ) {
        $this->page_title = $text;
    }

    /**
     * Получить загловок страницы.
     *
     * @since 0.2.124
     *
     * @return  string $text             Заголовок страницы.
     */
    public function get_page_title() {
        return empty( $this->page_title ) ? $this->General->arr_general['full_name'] : $this->page_title;
    }

    /**
     * Задать описание страницы.
     *
     * @since 0.2
     *
     * @param string $text             Описание страницы.
     */
    public function set_page_description( $text ) {
        $this->page_description = $text;
    }

    /**
     * Получить описание страницы.
     *
     * @since 0.2.124
     *
     * @return  string $text             Описание страницы.
     */
    public function get_page_description() {
        return empty( $this->page_description ) ? $this->General->arr_general['info'] : $this->page_description;
    }

    /**
     * Задать ссылку на изображение страницы.
     *
     * @since 0.2
     *
     * @param string $text             Изображение страницы.
     */
    public function set_page_image( $text ) {
        $this->page_image = $text;
    }

    /**
     * Получить ссылку на изображение страницы.
     *
     * @since 0.2
     *
     * @return  string $text             Изображение страницы.
     */
    public function get_page_image() {
        if( empty( $this->page_image ) ):
            return file_exists( CACHE . '/img/global/bar_logo.jpg' ) ? $this->General->arr_general['site'] . 'storage/cache/img/global/bar_logo.jpg' : copy(CACHE . '/img/global/default_bar_logo.jpg', CACHE . '/img/global/bar_logo.jpg') && $this->General->arr_general['site'] . 'storage/cache/img/global/bar_logo.jpg';
        else:
            return $this->General->arr_general['site'] . $this->page_image;
        endif;
    }

    /**
     * Компрессирует CSS файлы
     *
     * @since 0.2
     *
     * @param  array   $files         Массив файлов.
     *
     * @return string                 Итог компрессии.
     */
    public function action_css_compress( $files = [] ) {
        $buffer = "";
        foreach ($files as $cssFile) {
            $buffer .= file_get_contents($cssFile);
        }
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

        $buffer = str_replace(': ', ':', $buffer);

        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);

        return $buffer;
    }

    /**
     * Компрессирует JS файлы
     *
     * @since 0.2
     *
     * @param  array   $files         Массив файлов.
     *
     * @return string                 Итог компрессии.
     */
    public function action_js_compress( $files = [] ) {
        $buffer = "";
        foreach ($files as $File) {
            $buffer .= file_get_contents($File);
        }

        return $buffer;
    }

    /**
     * Перевод времени.
     *
     * @since 0.2
     * 
     * @param int $seconds          Время в секундах
     * @param int $type             Тип вывода.
     *
     * @return string               Итог перевода.
     */
    function action_time_exchange( $seconds, $type = 0 ) {
        if( floor($seconds / 60 / 60 / 24 / 30 ) != 0 && ( $type == 0 || $type == 5 ) ) {
            $month = floor($seconds / 60 / 60 / 24 / 30 );
            return $month > 1 ? $month . ' ' . $this->Translate->get_translate_phrase('_Months') : $month . ' ' . $this->Translate->get_translate_phrase('_Month');
        } elseif ( floor($seconds / 60 / 60 / 24 / 7 ) != 0 && ( $type == 0 || $type == 4 ) ) {
            $week = floor($seconds / 60 / 60 / 24 / 7 );
            return $week > 1 ? $week . ' ' . $this->Translate->get_translate_phrase('_Weeks') : $week . ' ' . $this->Translate->get_translate_phrase('_Week');
        } elseif ( floor($seconds / 60 / 60 / 24 ) != 0 && ( $type == 0 || $type == 3 ) ) {
            $day = floor($seconds / 60 / 60 / 24 );
            return $day > 1 ? $day . ' ' . $this->Translate->get_translate_phrase('_Days') : $day . ' ' . $this->Translate->get_translate_phrase('_Day');
        } elseif ( floor($seconds / 60 / 60 ) != 0 && ( $type == 0 || $type == 2 ) ) {
            $hour = floor($seconds / 60 / 60 );
            return $hour > 1 ? $hour . ' ' . $this->Translate->get_translate_phrase('_Hour') : $hour . ' ' . $this->Translate->get_translate_phrase('_Hour');
        } elseif ( floor($seconds / 60 ) != 0 && ( $type == 0 || $type == 1 ) ) {
            $min = floor($seconds / 60 );
            return $min > 1 ? $min . ' ' . $this->Translate->get_translate_phrase('_Minute') : $min . ' ' . $this->Translate->get_translate_phrase('_Minute');
        } else {
            return $seconds . ' ' . $this->Translate->get_translate_phrase('_Second');
        }
    }
}