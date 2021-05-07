<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

! isset( $_SESSION['user_admin'] ) && get_iframe( '013','Доступ закрыт' )?>
<aside class="sidebar-right">
    <section class="sidebar">
        <div class="user-sidebar-right-block">
            <div class="info">
                <div class="details">
                    <div class="admin_type"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Chief_admin')?></div>
                    <div class="admin_rights"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_All_access_rights')?></div>
                </div>
            </div>
        </div>
        <div class="card menu">
            <ul class="nav">
                <li <?php get_section( 'section', 'modules' ) == 'stats' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','stats')?>';">
                    <a><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Admin_stats')?></a>
                </li>
                <li <?php get_section( 'section', 'modules' ) == 'general' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','general')?>';">
                    <a><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_General_settings')?></a>
                </li>
                <li <?php get_section( 'section', 'modules' ) == 'modules' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','modules')?>';">
                    <a><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Configuring_modules')?></a>
                </li>
                <li <?php get_section( 'section', 'modules' ) == 'servers' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','servers')?>';">
                    <a><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Server_setting')?></a>
                </li>
                <li <?php get_section( 'section', 'modules' ) == 'db' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','db')?>';">
                    <a><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Database_settings')?></a>
                </li>
                <li <?php get_section( 'section', 'modules' ) == 'web' && print 'class="table-active"'?> onclick="location.href = '<?php echo set_url_section(get_url( 2 ),'section','web')?>';">
                    <a>Настройка шаблона</a>
                </li>
            </ul>
        </div>
    </section>
</aside>
<div class="row row_admins">
    <?php switch ( get_section( 'section', 'modules' ) ) {
        case 'modules':
            require MODULES . 'module_page_adminpanel' . '/includes/modules.php';
            break;
        case 'servers':
            require MODULES . 'module_page_adminpanel' . '/includes/servers.php';
            break;
        case 'db':
            require MODULES . 'module_page_adminpanel' . '/includes/db.php';
            break;
        case 'web':
            require MODULES . 'module_page_adminpanel' . '/includes/web.php';
            break;
         case 'stats':
            require MODULES . 'module_page_adminpanel' . '/includes/stats.php';
            break;
        default:
            require MODULES . 'module_page_adminpanel' . '/includes/general.php';
            break;
    }?>
</div>