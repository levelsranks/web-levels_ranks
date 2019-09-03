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
     * @var array
     */
    public $array_modules = [];

    /**
     * @var int
     */
    public $array_modules_count = 0;

    /**
     * @var array
     */
    public $arr_module_init = [];

    /**
     * @var int
     */
    public $arr_module_init_page_count = 0;

    /**
     * @var array
     */
    public $arr_user_info = [];

    /**
     * @var array
     */
    public $scan_modules = [];

    /**
     * @var array
     */
    public $scan_ranks_pack = [];

    /**
     * @var int
     */
    public $array_ranks_pack_count = 0;

    /**
     * @var array
     */
    public $arr_translations = [];

    /**
     * @var array
     */
    public $actual_library = [];

    /**
     * @var string
     */
    public $page_title = '';

    /**
     * @var string
     */
    public $page_description = '';

    /**
     * @var string
     */
    public $page_image = '';

    /**
     * Организация работы вэб-приложения с модулями.
     */
    function __construct( $General ) {

        $this->General = $General;

        // Получение кэшированного списка модулей.
        $this->array_modules = $this->get_arr_modules();

        // Подсчёт количества модулей.
        $this->array_modules_count = sizeof( $this->array_modules );

        // Получение списка инициализвации модулей в определенном порядке.
        $this->arr_module_init = $this->get_module_init();
        
        $this->arr_module_init_page_count = sizeof( $this->arr_module_init['page'] );

        // Актуальная библиотека CSS и JS файлов.
        $this->actual_library = file_exists( SESSIONS . '/actual_library.json' ) ? json_decode( file_get_contents( SESSIONS . '/actual_library.json') , true) : ['actual_css_ver' => 0, 'actual_js_ver' => 0];

        // Проверка таблици стилей.
        $this->check_generated_style();

        // Проверка таблици стилей.
        $this->check_generated_js();

        // Проверка для роутера страниц
        ! empty( $_GET["page"] ) && empty( $this->arr_module_init['page'][ $_GET["page"] ] ) && get_iframe( '009', 'Данная страница не существует' );

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
        if ( !file_exists( SESSIONS . 'modules_initialization.php' ) ):

            $result = [];
            $data_always = [];

            for ( $i = 0; $i < $this->array_modules_count; $i++ ):

                // Перебором забираем корневое название модуля.
                $module = array_keys( $this->array_modules )[ $i ];
                if (
                     $this->array_modules[ $module ]['setting']['status'] == 1
                     && $this->array_modules[ $module ]['required']['php'] <= PHP_VERSION
                     && $this->array_modules[ $module ]['required']['core'] <= VERSION
                 ):
                     $this->array_modules[ $module ]['setting']['interface'] == 1 && $result['page'][ $this->array_modules[ $module ]['page'] ]['interface'][] = $module;
                     $this->array_modules[ $module ]['setting']['data'] == 1 && $result['page'][ $this->array_modules[ $module ]['page'] ]['data'][] = $module;
                     $this->array_modules[ $module ]['setting']['data_always'] == 1 && $data_always[] = $module;
                     $this->array_modules[ $module ]['setting']['js'] == 1 && $result['page'][ $this->array_modules[ $module ]['page'] ]['js'][] = $module;
                     ! empty( $this->array_modules[ $module ]['sidebar'] ) && $result['sidebar'][] = $module;
                 endif;
            endfor;

            $c_page = sizeof( $result['page'] );

            $data_always_size = sizeof( $data_always );

            // Дополнительный перебор.
            for ( $i = 0; $i < $c_page; $i++ ):
                $module = array_keys( $this->array_modules )[ $i ];

                for ( $i2 = 0; $i2 < $data_always_size; $i2++ ):

                    if ( ! in_array( $data_always[ $i2 ], $result['page'][ $this->array_modules[ $module ]['page'] ]['data'] ) ) {
                        $result['page'][ $this->array_modules[ $module ]['page'] ]['data'][] = $data_always[ $i2 ];
                    }

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
     * @param string $module       Корневое название модуля.
     *
     * @return array|false         Возвращает кэш модуля.
     */
    public function get_module_cache( $module ) {
        if( file_exists(MODULES_SESSIONS . $module . '/cache.php') ):
            return require MODULES_SESSIONS . $module . '/cache.php';
        else:
            ! file_exists( MODULES_SESSIONS . $module ) && mkdir( MODULES_SESSIONS . $module, 0777, true );
            file_put_contents( MODULES_SESSIONS . $module . '/cache.php', '<?php return [];' );
            return [];
        endif;
    }

    /**
     * Задать кэш для определенного модуля.
     *
     * @param string $module        Корневое название модуля.
     * @param array $data           Массив данных.
     */
    public function set_module_cache( $module, $data ) {
        ! file_exists( MODULES_SESSIONS . $module ) && mkdir( MODULES_SESSIONS . $module, 0777, true );
        file_put_contents( MODULES_SESSIONS . $module . '/cache.php', '<?php return '.var_export_min( $data ).";" );
    }

    /**
     * Получить перевод определенной фразы из общего кэша.
     *
     * @param string $phrase        Слово для перевода.
     * @param string $group         Подмассив.
     *
     * @return string               Выводит слово в переводе.
     */
    public function get_translate_phrase( $phrase, $group = '' ) {
        if ( empty ( $group ) ):
            return empty ( $this->arr_translations[ $phrase ][ $_SESSION['language'] ] ) ? $this->arr_translations[ $phrase ]['EN'] : $this->arr_translations[ $phrase ][ $_SESSION['language'] ];
        else:
            return empty ( $this->arr_translations[ $group ][ $phrase ][ $_SESSION['language'] ] ) ? $this->arr_translations[ $group ][ $phrase ]['EN'] : $this->arr_translations[ $group ][ $phrase ][ $_SESSION['language'] ];
        endif;
    }

    /**
     * Получить перевод определенной фразы из кэша модуля.
     *
     * @param string $module_id         ID модуля.
     * @param string $phrase            Слово для перевода.
     *
     * @return string                   Выводит слово в переводе.
     */
    public function get_translate_module_phrase( $module_id, $phrase ) {
        return empty( $this->arr_translations[ $module_id ][ $phrase ][ $_SESSION['language'] ] ) ? $this->arr_translations[ $module_id ][ $phrase ]['EN'] : $this->arr_translations[ $module_id ][ $phrase ][ $_SESSION['language'] ];
    }

    /**
     * Получить список переводов определенного модуля.
     *
     * @param string $module_id         ID модуля.
     *
     * @return array                    Массив переводов.
     */
    public function get_arr_translate_module( $module_id ) {
        return $this->arr_translations[ $module_id ];
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

            // Сканирование папки с Паками рангов.
            $this->scan_ranks_pack = array_diff( scandir( RANKS_PACK, 1 ), array( '..', '.' ) );

            // Подсчёт количества модулей.
            $this->array_modules_count = sizeof( $this->scan_modules );

            // Подсчёт количества паков рангов.
            $this->array_ranks_pack_count = sizeof( $this->scan_ranks_pack );

            if( $this->array_modules_count != 0 ) {
            // Цикл перебора описания модулей.
            for ( $i = 0; $i < $this->array_modules_count; $i++ ) {
                // Получение описания определенного модуля.
                $result[ $this->scan_modules[ $i ] ] = json_decode( file_get_contents( MODULES . $this->scan_modules[ $i ] . '/description.json') , true);

                // Проверка на поддержку мульти-перевода.
                if ($result[ $this->scan_modules[ $i ] ]['setting']['translation'] == 1) {
                    // Получение кэша перевода модулей.
                    $result_translation[ $this->scan_modules[ $i ] ] = json_decode( file_get_contents(MODULES . $this->scan_modules[ $i ] . '/translation.json') , true);
                }
            }

            for ( $i = 0; $i < $this->array_ranks_pack_count; $i++ ):
                $this->rank_pack[ 'ranks_' . $this->scan_ranks_pack[ $i ] ] = json_decode( file_get_contents( RANKS_PACK . $this->scan_ranks_pack[ $i ] . '/title.json' ) , true);
            endfor;

            $result_translation += $this->rank_pack;

            // Объединение общего кэша мульти-перевода с кэшэм переводов модулей.
            $result_translation += require SESSIONS . 'translator.php';
            }

            // Создание/редактирование кэша модулей.
            file_put_contents( SESSIONS . 'modules_cache.php', '<?php return '.var_export_min( $result ).";" );

            // Создание/редактирование кэша мульти-переводов.
            file_put_contents( SESSIONS . 'translator_cache.php', '<?php return '.var_export_min( $result_translation ).";" );
        }
        return require SESSIONS . 'modules_cache.php';
    }

    /**
     * Проверка сгенерированного стиля.
     */
    public function check_generated_style() {
        // При отсутствии списока модулей для дальнейшей инициализации, выполняется создание данного списка.
        if ( ! file_exists( SESSIONS . '/actual_library.json' ) || ! file_exists( ASSETS_CSS . '/generation/style_generated.min.ver.' . $this->actual_library['actual_css_ver'] . '.css' ) || empty( $this->actual_library['actual_css_ver'] ) ):

            // Проверка на существование каталога с генерируемыми файлами
            ! file_exists( ASSETS_CSS . 'generation' ) && mkdir( ASSETS_CSS . 'generation', 0777, true );

            // Если файл с темой существует, добавить ссылку на файл в массив для компрессии.
            file_exists( THEMES . $this->General->arr_general['theme'] .'/style.css' ) && $files_css_compress[] = THEMES . $this->General->arr_general['theme'] .'/style.css';

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
                    $this->array_modules[ $module ]['setting']['css'] == 1 && $files_css_compress[] = MODULES . $module . '/assets/css/' . $this->array_modules[ $module ]['setting']['type'] . '.css';
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
    }

    /**
     * Проверка сгенерированного JavaScript.
     */
    public function check_generated_js() {

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
                    $this->array_modules[ $module ]['setting']['js'] == 1 && $files_js_compress[] = MODULES . $module . '/assets/js/' . $this->array_modules[ $module ]['setting']['type'] . '.js';
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
    }

    /**
     * Самостоятельно добавить раздел в sidebar.
     *
     * @param string $module_id         ID модуля.
     * @param array $array              Опции раздела.
     *
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
     * @param string $text             Опции раздела.
     */
    public function set_user_info_text( $text ) {
        $this->arr_user_info[] = $text;
    }

    /**
     * Задать заглавие страницы.
     *
     * @param string $text             Заголовок страницы.
     */
    public function set_page_title( $text ) {
        $this->page_title = $text;
    }

    /**
     * Задать описание страницы.
     *
     * @param string $text             Описание страницы.
     */
    public function set_page_description( $text ) {
        $this->page_description = $text;
    }

    /**
     * Задать изображение страницы.
     *
     * @param string $text             Изображение страницы.
     */
    public function set_page_image( $text ) {
        $this->page_image = $text;
    }

    /**
     * Компрессирует CSS файлы
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
     * @param int $seconds          Время в секундах
     * @param int $type             Тип вывода.
     *
     * @return string               Итог перевода.
     */
    function action_time_exchange( $seconds, $type = 0 ) {
        if( floor($seconds / 60 / 60 / 24 / 30 ) != 0 && ( $type == 0 || $type == 5 ) ) {
            $month = floor($seconds / 60 / 60 / 24 / 30 );
            return $month > 1 ? $month . ' ' . $this->get_translate_phrase('_Months') : $month . ' ' . $this->get_translate_phrase('_Month');

        } elseif ( floor($seconds / 60 / 60 / 24 / 7 ) != 0 && ( $type == 0 || $type == 4 ) ) {
            $week = floor($seconds / 60 / 60 / 24 / 7 );
            return $week > 1 ? $week . ' ' . $this->get_translate_phrase('_Weeks') : $week . ' ' . $this->get_translate_phrase('_Week');

        } elseif ( floor($seconds / 60 / 60 / 24 ) != 0 && ( $type == 0 || $type == 3 ) ) {
            $day = floor($seconds / 60 / 60 / 24 );
            return $day > 1 ? $day . ' ' . $this->get_translate_phrase('_Days') : $day . ' ' . $this->get_translate_phrase('_Day');

        } elseif ( floor($seconds / 60 / 60 ) != 0 && ( $type == 0 || $type == 2 ) ) {
            $hour = floor($seconds / 60 / 60 );
            return $hour > 1 ? $hour . ' ' . $this->get_translate_phrase('_Hour') : $hour . ' ' . $this->get_translate_phrase('_Hour');

        } elseif ( floor($seconds / 60 ) != 0 && ( $type == 0 || $type == 1 ) ) {
            $min = floor($seconds / 60 );
            return $min > 1 ? $min . ' ' . $this->get_translate_phrase('_Minute') : $min . ' ' . $this->get_translate_phrase('_Minute');

        } else {
            return $seconds . ' ' . $this->get_translate_phrase('_Second');
        }
    }
}