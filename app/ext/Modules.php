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
     * @var int
     */
    public $array_templates_count = 0;

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
    public $scan_templates = [];

    /**
     * @since 0.2
     * @var array
     */
    public $scan_ranks_pack = [];

    /**
     * @since 0.2
     * @var array
     */
    public $template_modules = [];

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
     * @since 0.2
     * @var object
     */
    public    $Router;

     /**
     * @since 0.2
     * @var string
     */
    public  $route;

    /**
     * Организация работы вэб-приложения с модулями.
     *
     * @param object $General
     * @param object $Translate
     * @param object $Notifications
     *
     * @since 0.2
     */
    function __construct( $General, $Translate, $Notifications, $Router ) {

        // Проверка на основную константу.
        defined('IN_LR') != true && die();

        $this->General = $General;

        $this->Translate = $Translate;

        $this->Notifications = $Notifications;

        $this->Router  = $Router;

        //Проверка на iframe
        (!empty($_GET['code']) && !empty($_GET['description'])) && exit(require PAGE_CUSTOM . '/error/index.php');

        // Получение кэшированного списка модулей.
        $this->array_modules = $this->get_arr_modules();

        // Подсчёт количества модулей.
        $this->array_modules_count = sizeof( $this->array_modules );

        // Получение списка инициализвации модулей в определенном порядке.
        $this->arr_module_init = $this->get_module_init();
        
        $this->arr_module_init_page_count = sizeof( $this->arr_module_init['page'] );

        // Получение кеша всех шаблонов
        $this->arr_templates = $this->get_templates_init();

        // Сканирование папки с модулями.
        $this->scan_templates = array_diff( scandir( TEMPLATES, 1 ), array( '..', '.', 'disabled' ) );

        $this->template_modules = $this->get_cache_template_modules();

        // Сканирование дополнительных модулей в шаблоне
        (file_exists(TEMPLATES . $General->arr_general['theme'] . '/modules/')) && $this->get_template_modules();

        // Подсчёт количества модулей.
        $this->array_templates_count = sizeof( $this->scan_templates );

        //Добавление новых роутов
        $this->AddRoutes();

        $this->route = ($Router->match()['target'] ?? $Router->SearchRoute());

        $basename = parse_url($General->arr_general['site'], PHP_URL_PATH);

        (empty( $basename ) && empty( $this->route ) || $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == $basename) && $this->route = 'home';

        // Библиотека актуальности.
        $this->actual_library = $this->get_actual_library();

        isset( $_SESSION['user_admin'] ) && $this->check_actual_modules_list();

        // Проверка JS файлов.
        $this->check_generated_js();

        // Проверка таблици стилей.
        $this->check_generated_style();

        // Сканирование и добавление новых шаблонов
        $this->check_actual_templates();

        // Проверка для роутера страниц
        ! empty( $checkroute ) && empty( $this->arr_module_init['page'][ $this->route ] ) && get_iframe( '009', 'Данная страница не существует' );

        $_SESSION['page_redirect'] = $this->route;

        $this->check_copy();
    }

    // Хз зачем я создал эту функцию, просто для получения кеша определенных модулей
    public function get_cache_template_modules()
    {
        if(file_exists(SESSIONS . 'templates_modules_cache.php'))
            return require SESSIONS . 'templates_modules_cache.php';
    }

    // Добавление стилей для каждого стиля модуля в шаблоне (Да, по тупому, да и похрен)
    public function get_template_modules()
    {
        (!file_exists(TEMPLATES . $this->General->arr_general['theme'] . '/modules/')) && die;
        
        $scan = array_diff( scandir( TEMPLATES . $this->General->arr_general['theme'] . '/modules/', 1 ), array( '..', '.', 'disabled' ) );
        if(!empty($scan) && $scan != array_keys($this->template_modules))
        {
            $result = [];
            foreach ($scan as $key => $val)
            {
                if(file_exists(TEMPLATES . $this->General->arr_general['theme'] . '/modules/' . $scan[ $key ] . '/dop.css'))
                    $result[ $scan[ $key ] ]['css'] = 1;

                if(file_exists(TEMPLATES . $this->General->arr_general['theme'] . '/modules/' . $scan[ $key ] . '/dop.js'))
                    $result[ $scan[ $key ] ]['js'] = 1;
            }

            file_put_contents( SESSIONS . 'templates_modules_cache.php', '<?php return '.var_export_min( $result ).";" );

            $this->template_modules = $result;

            return $result;
        }
        return $this->template_modules;
    }
    
    // Добавление шаблонов в отдельное кеширование
    public function get_templates_init()
    {
        if(!file_exists(SESSIONS . 'templates_cache.php'))
        {
            $scan = array_diff( scandir( TEMPLATES, 1 ), array( '..', '.', 'disabled' ) );
            if( sizeof($scan) != 0 ) 
            {
                foreach ($scan as $key => $val)
                {
                    $result[ $scan[ $key ] ] = json_decode( file_get_contents( TEMPLATES . $scan[ $key ] . '/description.json') , true);
                }
            }

            // Создание/редактирование кэша шаблона.
            file_put_contents( SESSIONS . 'templates_cache.php', '<?php return '.var_export_min( $result ).";" );

            return $result;
        }
        return require SESSIONS . 'templates_cache.php';
    }

    //Добавление роутов исходя из модулей
    public function AddRoutes()
    {
        //Цикл для добавления роутов исходя из страниц модулей
        foreach ($this->arr_module_init['page'] as $key => $val)
            $this->Router->map('GET', '/'.$key.'/', $key, $key);

        return;
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
     * @since 0.3.0
     */
    public function check_actual_templates()
    {
        $keys = array_keys($this->arr_templates);

        $zalupka = array_values(array_diff($keys, $this->scan_templates));
        $zalupka2 = array_values(array_diff($this->scan_templates, $keys));

        if(!empty($zalupka) || !empty($zalupka2))
        {
            foreach (array_keys($this->arr_templates) as $val)
            {
                $search = array_search($val, $this->scan_templates);
                if($this->scan_templates[$search] == $val)
                {
                    $templates[] = $val;
                }
                else
                {
                    $note[] = ['text' => 'Шаблон '.$val.' был успешно удален!', 'status' => 'error'];
                }
            }

            // Проверка на модули, которых нет в оригинальном массиве, и их добавление в итоговый массив
            foreach ($this->scan_templates as $val)
            {
                $search = array_search($val, array_keys($this->arr_templates));
                if(array_keys($this->arr_templates)[$search] != $val)
                {
                    $templates[] = $val;
                    $note[] = ['text' => 'Шаблон '.$val.' был успешно добавлен!'];
                }
            }

            for($i = 0; $i < sizeof( $templates ); $i++)
                $result[ $templates[ $i ] ] = json_decode( file_get_contents( TEMPLATES . $templates[ $i ] . '/description.json') , true);

            file_put_contents( SESSIONS . 'templates_cache.php', '<?php return '.var_export_min( $result ).";" );

            if(!empty($note) && isset($_SESSION['user_admin']))
            {
                for($i = 0; $i < sizeof($note); $i++)
                    $this->General->sendNote($note[$i]['text'], $note[$i]['status'] ?? 'success', 3);
            }
            unlink(SESSIONS . 'templates_modules_cache.php');

            $this->action_clear_style_cache();
            
            header("Refresh:3");
        }
    }

    /**
     * Проверка на актуальный список модулей.
     *
     * @since 0.2.122
     */
    public function check_actual_modules_list() {
        // Сканирование папки с модулями.
        $scan_modules = array_diff( scandir( MODULES, 1 ), array( '..', '.', 'disabled' ) );

        $keys = array_keys($this->array_modules);
        $zalupka = array_values(array_diff($scan_modules, $keys));
        $zalupka2 = array_values(array_diff($keys, $scan_modules));

        if(!empty($zalupka) || !empty($zalupka2)):
            // Удаление тех модулей, которых нет в выборке из папки
            foreach (array_keys($this->array_modules) as $val)
            {
                $search = array_search($val, $scan_modules);
                if($scan_modules[$search] == $val)
                {
                    $modules[] = $val;
                }
                else
                {
                    $note[] = ['text' => 'Модуль '.$val.' был успешно удален!', 'status' => 'error'];
                }
            }

            // Проверка на модули, которых нет в оригинальном массиве, и их добавление в итоговый массив
            foreach ($scan_modules as $val)
            {
                $search = array_search($val, array_keys($this->array_modules));
                if(array_keys($this->array_modules)[$search] != $val)
                {
                    $modules[] = $val;
                    $note[] = ['text' => 'Модуль '.$val.' был успешно добавлен!'];
                }
            }
            
            for ( $i = 0, $c = sizeof( $modules ); $i < $c; $i++ ):
                
                // Получение информации о модуле
                $modules_desc[ $modules[ $i ] ] = json_decode( file_get_contents( MODULES . $modules[ $i ] . '/description.json') , true);

                if ($modules_desc[ $modules[ $i ] ]['setting']['status'] == 1 && $modules_desc[ $modules[ $i ] ]['required']['php'] <= PHP_VERSION && $modules_desc[ $modules[ $i ] ]['required']['core'] <= VERSION && $modules_desc[ $modules[ $i ] ]['page'] != 'all'):
                    if( ! empty( $modules_desc[ $modules[ $i ] ]['setting']['interface'] ) && $modules_desc[ $modules[ $i ] ]['setting']['interface'] == 1 ):
                        $result['page'][ $modules_desc[ $modules[ $i ] ]['page'] ]['interface'][ empty( $modules_desc[ $modules[ $i ] ]['setting']['interface_adjacent'] ) ? 'afternavbar' : $modules_desc[ $modules[ $i ] ]['setting']['interface_adjacent'] ][] = $modules[ $i ];
                    endif;
                    if( ! empty( $modules_desc[ $modules[ $i ] ]['setting']['interface_always'] ) && $modules_desc[ $modules[ $i ] ]['setting']['interface_always'] == 1 ):
                        $result['interface_always'][ empty( $modules_desc[ $modules[ $i ] ]['setting']['interface_always_adjacent'] ) ? 'afternavbar' : $modules_desc[ $modules[ $i ] ]['setting']['interface_always_adjacent'] ][] = ['name' => $modules[ $i ] ] ;
                    endif;
                    ! empty( $modules_desc[ $modules[ $i ] ]['setting']['data'] ) && $modules_desc[ $modules[ $i ] ]['setting']['data'] == 1 && $result['page'][ $modules_desc[ $modules[ $i ] ]['page'] ]['data'][] = $modules[ $i ];
                    ! empty( $modules_desc[ $modules[ $i ] ]['setting']['data_always'] ) && $modules_desc[ $modules[ $i ] ]['setting']['data_always'] == 1 && $result['data_always'][] = $modules[ $i ];
                    ! empty( $modules_desc[ $modules[ $i ] ]['setting']['js'] ) && $modules_desc[ $modules[ $i ] ]['setting']['js'] == 1 && $result['page'][ $modules_desc[ $modules[ $i ] ]['page'] ]['js'][] = ['name' => $modules[ $i ], 'type' => $modules_desc[ $modules[ $i ] ]['setting']['type']];
                    ! empty( $modules_desc[ $modules[ $i ] ]['setting']['css'] ) && $modules_desc[ $modules[ $i ] ]['setting']['css'] == 1 && $result['page'][ $modules_desc[ $modules[ $i ] ]['page'] ]['css'][] = ['name' => $modules[ $i ], 'type' => $modules_desc[ $modules[ $i ] ]['setting']['type']];
                    ! empty( $modules_desc[ $modules[ $i ] ]['sidebar'] ) && $result['sidebar'][] = $modules[ $i ];
                endif;
                
            endfor;

            if(file_exists(SESSIONS . 'modules_initialization.php'))
            {
                $cache = require SESSIONS . 'modules_initialization.php';

                if (! function_exists("array_key_last")) {
                    function array_key_last($array) {
                        if (!is_array($array) || empty($array)) {
                            return NULL;
                        }
                       
                        return array_keys($array)[count($array)-1];
                    }
                }

                //Циклы на распределение в сайдбаре, и на главной
                foreach ($result['sidebar'] as $key => $val)
                {
                    $search = array_search($val, $cache['sidebar']);
                    if($cache['sidebar'][$search] == $val)
                        $res[$search] = $val;
                    else
                        $res[array_key_last($result['sidebar']) + sizeof($res) ?? 1] = $val;

                }
                foreach ($result['page']['home']['interface']['afternavbar'] as $key => $val)
                {
                    $search = array_search($val, $cache['page']['home']['interface']['afternavbar']);
                    if($cache['page']['home']['interface']['afternavbar'][$search] == $val)
                        $restwo[$search] = $val;
                    else
                        $restwo[array_key_last($result['page']['home']['interface']['afternavbar']) + sizeof($restwo) ?? 1] = $val;
                }

                //Сортировка массивов по ключам
                ksort($res);
                ksort($restwo);
                //Присваивание итоговому результату отсортированные массивы
                $result['sidebar'] = array_values($res);
                $result['page']['home']['interface']['afternavbar'] = array_values($restwo);
            }

            // Сохраняем наш файл с перебором модулей.
            file_put_contents( SESSIONS . 'modules_initialization.php', '<?php return '.var_export_min( $result ).";\n" );

            // Создание/редактирование кэша модулей.
            file_put_contents( SESSIONS . 'modules_cache.php', '<?php return '.var_export_min( $modules_desc ).";" );

            // Удаление, чтобы не мешал
            unlink( SESSIONS . '/actual_library.json' );

            // Высылает уведомления админам 
            if(!empty($note) && isset($_SESSION['user_admin']))
            {
                for($i = 0; $i < sizeof($note); $i++)
                    $this->General->sendNote($note[$i]['text'], $note[$i]['status'] ?? 'success', 3);
            }

            $this->action_clear_style_cache();

            header("Refresh:3");
        endif;
    }

    /**
     * Полностью очистить кэш вэб-приложения включая кэш модулей.
     */
    function action_clear_style_cache() {
        // Ссылки на кэшируемые файлы.
        $cache_files = [
            'css_cache' => ASSETS_CSS . '/generation/style_generated.min.ver.' . $this->actual_library['actual_css_ver'] . '.css',
            'js_cache' => ASSETS_JS . '/generation/app_generated.min.ver.' . $this->actual_library['actual_js_ver'] . '.js',
        ];

        // Удаляем файл с генерируемыми стилями.
        file_exists( $cache_files['css_cache'] ) && unlink( $cache_files['css_cache'] );

        // Удаляем файл с генерируемыми JS библиотекой.
        file_exists( $cache_files['js_cache'] ) && unlink( $cache_files['js_cache'] );
    } 

    private function check_copy()
    {
        $get = file_get_contents_fix(PAGE . "footer.php");
        if(!strpos($get, "levels-ranks-web"))
            exit(get_iframe("Ой", 'Удалять копирайты нельзя!'));
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

            $this->css_library[] = ASSETS_CSS . '/style.css';

            $this->css_library[] = TEMPLATES . $this->General->arr_general['theme'] .'/assets/css/style.css';

            // Подсчёт количества под-стилей.
            $css_library = array_diff( scandir( TEMPLATES . $this->General->arr_general['theme'] .'/assets/css/css_library/', 1 ), array( '..', '.' ) );

            // После проверки на существование подстиля, добавление ссылки подстиля в массив для компрессии.
            for ( $cgs = 0, $cgs_c = sizeof( $css_library ); $cgs < $cgs_c; $cgs++ ) {
                file_exists( TEMPLATES . $this->General->arr_general['theme'] .'/assets/css/css_library/' . $css_library[ $cgs ] . '/' . (int) $this->General->arr_general[ $css_library[ $cgs ] ] . '.css' ) && $this->css_library[] = TEMPLATES . $this->General->arr_general['theme'] .'/assets/css/css_library/' . $css_library[ $cgs ] . '/' . (int) $this->General->arr_general[ $css_library[ $cgs ] ] . '.css';
            }

        else:
            // При отсутствии списока модулей для дальнейшей инициализации, выполняется создание данного списка.
            if ( ! file_exists( SESSIONS . '/actual_library.json' ) || empty( $this->actual_library['actual_css_ver'] ) || ! file_exists( ASSETS_CSS . '/generation/style_generated.min.ver.' . $this->actual_library['actual_css_ver'] . '.css' ) ):

                $files_css_compress = [];

                // Проверка на существование каталога с генерируемыми файлами
                ! file_exists( ASSETS_CSS . 'generation' ) && mkdir( ASSETS_CSS . 'generation', 0777, true );

                // Если файл с темой существует, добавить ссылку на файл в массив для компрессии.
                file_exists( ASSETS_CSS .'/style.css' ) && $files_css_compress[0] = ASSETS_CSS . '/style.css';

                // Добавление файла темы
                file_exists( TEMPLATES . $this->General->arr_general['theme'] .'/assets/css/style.css' ) && $files_css_compress[1] = TEMPLATES . $this->General->arr_general['theme'] .'/assets/css/style.css';

                // Подсчёт количества под-стилей.
                $css_library = array_diff( scandir( TEMPLATES . $this->General->arr_general['theme'] .'/assets/css/css_library/', 1 ), array( '..', '.' ) );

                // После проверки на существование подстиля, добавление ссылки подстиля в массив для компрессии.
                for ( $cgs = 0, $cgs_c = sizeof( $css_library ); $cgs < $cgs_c; $cgs++ ) {
                    file_exists( TEMPLATES . $this->General->arr_general['theme'] .'/assets/css/css_library/' . $css_library[ $cgs ] . '/' . (int) $this->General->arr_general[ $css_library[ $cgs ] ] . '.css' ) && $files_css_compress[] = TEMPLATES . $this->General->arr_general['theme'] .'/assets/css/css_library/' . $css_library[ $cgs ] . '/' . (int) $this->General->arr_general[ $css_library[ $cgs ] ] . '.css';
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

                file_exists( TEMPLATES . $this->General->arr_general['theme'] .'/assets/js/app.js' ) && $files_js_compress[] = TEMPLATES . $this->General->arr_general['theme'] .'/assets/js/app.js';

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