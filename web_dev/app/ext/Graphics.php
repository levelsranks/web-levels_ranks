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
     */
    function __construct( $General, $Modules, $Db ) {
        // Подгрузка данных из модулей которые не относятся к интерфейсу и должны быть получены до начала рендера страницы
        for ( $module_id = 0, $c = sizeof( $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['data'] ); $module_id < $c; $module_id++ ):
            require MODULES . $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['data'][ $module_id ] . '/forward/data.php';
        endfor;
        
        // Рендер блока - Head
        require PAGE . 'head.php';

        // Рендер блока - Sidebar
        require PAGE . 'sidebar.php';

        // Рендер блока - Navbar
        require PAGE . 'navbar.php';

        // Подгрузка данных из модулей которые относятся к интерфейсу
        for ( $module_id = 0, $c = sizeof( $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['interface'] ); $module_id < $c; $module_id++ ):
            require MODULES . $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['interface'][ $module_id ] . '/forward/interface.php';
        endfor;

        // Рендер блока - Footer
        require PAGE . 'footer.php';
    }
}