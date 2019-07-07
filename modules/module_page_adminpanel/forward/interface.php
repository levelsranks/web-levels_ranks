<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

if( $_SESSION['steamid32'] != $General->arr_general['admin'] || IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }?>
<div class="row">
    <div class="col-md-2">
                    <div class="card menu">
                            <div class="card-header">
                                <h5 class="badge">Настройки</h5>
                            </div>
                            <ul class="nav">
                                <li <?php get_section( 'section', 'modules' ) == 'modules' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','modules')?>';">
                                    <a>Настройка модулей</a>
                                </li>
                                <li <?php get_section( 'section', 'modules' ) == 'servers' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','servers')?>';">
                                    <a>Настройка серверов</a>
                                </li>
                            </ul>
                        </div>
    </div>
    <?php switch ( get_section( 'section', 'modules' ) ) {
        case 'general':
            require MODULES . 'module_page_adminpanel' . '/includes/general.php';
            break;
        case 'modules':
            require MODULES . 'module_page_adminpanel' . '/includes/modules.php';
            break;
        case 'servers':
            require MODULES . 'module_page_adminpanel' . '/includes/servers.php';
            break;
    }?>
</div>