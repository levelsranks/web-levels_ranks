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

class Graphics {

    /**
     * Инициализация графической составляющей вэб-интерфейса с подгрузкой модулей.
     *
     * @since 0.2
     */
    function __construct( $General, $Modules, $Db, $Auth, $Notifications ) {

        $Graphics = $this;

        $this->General = $General;

        $this->Auth = $Auth;
        
        // Подгрузка данных из модулей которые не относятся к интерфейсу и должны быть получены до начала рендера страницы
        for ( $module_id = 0, $c_mi = sizeof( $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['data'] ); $module_id < $c_mi; $module_id++ ):
            $file = MODULES . $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['data'][ $module_id ] . '/forward/data.php';
            file_exists( $file ) && require $file;
        endfor;

        // Дополнительный поток под модули, которые должны задействовать ядро на постоянной основе, а не локально.
        for ( $module_id = 0, $c_mi = sizeof( $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['data_always'] ); $module_id < $c_mi; $module_id++ ):
            $file = MODULES . $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['data_always'][ $module_id ] . '/forward/data_always.php';
            file_exists( $file ) && require $file;
        endfor;

        // Рендер блока - Head
        require PAGE . 'head.php';

        // Рендер блока - Sidebar
        require PAGE . 'sidebar.php';

        // Рендер блока - Navbar
        require PAGE . 'navbar.php';

        // Подгрузка данных из модулей которые относятся к интерфейсу
        for ( $module_id = 0, $c_mi = sizeof( $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['interface'] ); $module_id < $c_mi; $module_id++ ):
            $file = MODULES . $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['interface'][ $module_id ] . '/forward/interface.php';
            file_exists( $file ) && require $file;
        endfor;

        // Рендер блока - Footer
        require PAGE . 'footer/2.php';
    }

    /**
     * Получение фонового ихображения.
     *
     * @since 0.2
     *
     * @return string  Ссылка на изображение ( CSS / Style )
     */
    public function get_css_background_image() {
        if ( ! empty( $this->General->arr_general['background_image'] ) && $this->General->arr_general['background_image'] != 'null' ) {
            return 'body { background-image: url(./storage/cache/img/global/backgrounds/' . $this->General->arr_general["background_image"] . ')} ';
        }
    }

    /**
     * Вывод кнопки изменения боковой панели.
     *
     * @since 0.2
     *
     * @return string Итоговый вывод.
     */
    public function get_css_sidebar_toggle() {
        if ( ! empty( $this->General->arr_general['disable_sidebar_change'] ) ) {
            return '.logo-area img {left:-8px} ';
        }
    }

    /**
     * Ограничение основного графического контейнера.
     *
     * @since 0.2
     *
     * @return string  Итоговый максимальный размер контейнера ( CSS / Style )
     */
    public function get_css_graphics_container() {
        if ( ! empty( $this->General->arr_general['graphics_container'] ) ):
            if ( $this->General->arr_general['graphics_container'] == 'static' ):
                return '.container-fluid{max-width:1400px} ';
            elseif( $this->General->arr_general['graphics_container'] == 'stretch' ):
                return '.container-fluid{max-width:1920px} ';
            endif;
        endif;
    }

    /**
     * Получение и вывод цветовой палитный сайта.
     *
     * @since 0.2
     * 
     * @return string         Цветовая плалитра ( CSS / Style / ROOT )
     */
    public function get_css_color_palette() {
        if ( isset ( $_SESSION['dark_mode'] ) && $_SESSION['dark_mode'] == true ) {
            return ':root' . str_replace( '"', '', str_replace( '",', ';', file_get_contents_fix ( 'storage/assets/css/themes/' . $this->General->arr_general['theme'] . '/palettes/' . $this->General->arr_general['dark_palette'] . '.json' ) ) ) .  ' ';
        } else {
            return ':root' . str_replace( '"', '', str_replace( '",', ';', file_get_contents_fix ( 'storage/assets/css/themes/' . $this->General->arr_general['theme'] . '/palettes/' . $this->General->arr_general['white_palette'] . '.json' ) ) ) .  ' ';
        }
    }
}