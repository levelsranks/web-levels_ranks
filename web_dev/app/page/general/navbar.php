<?php
    /**
     * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
     *
     * @link https://steamcommunity.com/profiles/76561198038416053
     * @link https://github.com/M0st1ce
     *
     * @license GNU General Public License Version 3
     */
?>
<div class=navbar>
    <div class=logo-area>
        <a href="#" data-toggle="offcanvas" class="nav-toggle pp-nav-toggle"><i></i></a>
        <a href="<?php echo $General->arr_general['site']?>"><img ondrag="return false" ondragstart="return false" src="storage/cache/img/global/logo.png"></a>
    </div>
    <ul class="right-area">
        <li class="section">
            <a href="#" class="language">
                <?php $General->get_icon( 'custom', 'translate', 'global' )?>
            </a>
            <ul class="subsection">
                <li>
                    <a href="#" onclick="location.href = '<?php echo set_url_section( get_url( 2 ), 'language', 'RU' )?>'">
                        <?php $General->get_icon( 'custom', 'ru', 'flags' )?> <?php echo $Modules->get_translate_phrase( '_RU' )?>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="location.href = '<?php echo set_url_section( get_url( 2 ), 'language', 'EN' )?>'">
                        <?php $General->get_icon( 'custom', 'en', 'flags' )?> <?php echo $Modules->get_translate_phrase( '_EN' )?>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="location.href = '<?php echo set_url_section( get_url( 2 ), 'language', 'UA' )?>'">
                        <?php $General->get_icon( 'custom', 'ua', 'flags' )?> <?php echo $Modules->get_translate_phrase( '_UA' )?>
                    </a>
                </li>
                <li>
                    <a href="#" onclick="location.href = '<?php echo set_url_section( get_url( 2 ), 'language', 'LT' )?>'">
                        <?php $General->get_icon( 'custom', 'lt', 'flags' )?> <?php echo $Modules->get_translate_phrase( '_LT' )?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="section dark-mode">
            <a href="javascript:void(0);" onclick="dark_mode()">
                <?php $General->get_icon( 'custom', 'moon', 'global' )?>
            </a>
        </li>
    </ul>
</div>
<div class="global-container">
    <div class="container-fluid">
<?php
// Подгрузка данных из модулей которые относятся к интерфейсу
for ( $module_id = 0, $c = sizeof( $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['interface'] ); $module_id < $c; $module_id++ ):
    require MODULES . $Modules->arr_module_init['page'][ get_section( 'page', 'home' ) ]['interface'][ $module_id ] . '/forward/interface.php';
endfor;