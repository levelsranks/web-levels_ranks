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
        <?php if( empty( $General->arr_general['disable_sidebar_change'] ) ):?><a href="javascript:void(0);" onclick="action_sidebar()" class="nav-toggle pp-nav-toggle"><i></i></a><?php endif?>
        <a href="<?php echo $General->arr_general['site']?>"><img ondrag="return false" ondragstart="return false" src="<?php echo file_exists( CACHE . '/img/global/logo.png' ) ? $General->arr_general['site'] . '/storage/cache/img/global/logo.png' : copy(CACHE . '/img/global/default_logo.png', CACHE . '/img/global/logo.png') && $General->arr_general['site'] . '/storage/cache/img/global/logo.png'?>"></a>
    </div>
    <ul class="right-area">
        <li class="section">
            <a href="#" class="navbar-icon">
                <?php $General->get_icon( 'custom', 'translate', 'global' )?>
            </a>
            <ul class="subsection">
                <?php for ( $i = 0; $i < $Translate->arr_languages_count; $i++ ): ?>
                    <li><a href="#" onclick="location.href = '<?php echo set_url_section( get_url( 2 ), 'language', $Translate->arr_languages[ $i ] )?>'">
                            <?php $General->get_icon( 'custom', strtolower( $Translate->arr_languages[ $i ] ), 'flags' )?> <?php echo $Translate->get_translate_phrase( '_' . $Translate->arr_languages[ $i ] )?>
                        </a></li>
                <?php endfor?>
            </ul>
        </li>
        <li class="section">
            <a href="#" class="navbar-icon">
                <div class="search"><?php $General->get_icon( 'zmdi', 'search' )?></div>
            </a>
            <ul class="subsection">
                <form enctype="multipart/form-data" method="post">
                <div class="search_form">
                    <div class="input-form">
                        <label>Поиск</label>
                        <input type="text" value="" name="_steam_id" placeholder="STEAM_1:1:390... / 7656119803..." >
                    </div>
                    <input class="btn no_steam" name="btn_search" type="submit" value="Найти">
                </div>
                </form>
            </ul>
        </li>
        <?php if( ! empty( $_SESSION['steamid32'] ) ):?>
            <li class="section">
                <a href="#" class="navbar-icon">
                    <div class="search notification">
                        <?php $General->get_icon( 'zmdi', 'notifications' )?>
                        <span id="main_notifications_badge"></span>
                    </div>
                </a>
                <ul class="subsection">
                    <div class="search_form">
                        <ul class="main_notifications" id="main_notifications"></ul>
                    </div>
                </ul>
            </li>
       <?php endif; if( ! empty( $_SESSION['steamid32'] ) && isset( $_SESSION['user_admin'] ) ):?>
            <li class="section navbar-icon">
                <a id="admin_idebar_right" href="javascript:void(0);" class="search">
                    <i class="zmdi zmdi-view-dashboard zmdi-hc-fw"></i>
                </a>
            </li>
        <?php endif;?>
    </ul>
</div>
<div class="global-container">
    <div class="container-fluid">
