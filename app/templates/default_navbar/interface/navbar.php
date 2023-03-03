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
        <a data-sidebar-open="true" class="sidebar-open-icon"><i class="zmdi zmdi-format-align-justify"></i></a>
        <a href="<?php echo $General->arr_general['site']?>"><img ondrag="return false" ondragstart="return false" src="<?php echo file_exists( CACHE . '/img/global/logo.png' ) ? $General->arr_general['site'] . '/storage/cache/img/global/logo.png' : copy(CACHE . '/img/global/default_logo.png', CACHE . '/img/global/logo.png') && $General->arr_general['site'] . '/storage/cache/img/global/logo.png'?>"></a>
    </div>
    <div class="navbar-content">
        <?php
        $sidebar = 0;
        for ( $d = 0, $c = sizeof( $Modules->arr_module_init['sidebar'] ); $d < $c; $d++ ):
            if( ! empty( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'] ) ):
            for ( $_d = 0, $_c = sizeof( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'] ); $_d < $_c; $_d++ ): if($sidebar >= 6) {$dop_content = $d; break 2;} $sidebar++;  ?>
                <a href="<?php echo ($Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['page'] == 'home') ? $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['href'] : $General->arr_general['site'] . $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['page'] ?>" <?php $Modules->route == str_replace('/','',$Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['href']) ? print 'class="table-active"' : false?>
                    <?php ( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['open_new_tab'] == true ) ? print 'target="_blank"' : false?>>
                    <?php $General->get_icon( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon_group'], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon'], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon_category'] )?>
                    <?php if(substr( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name'], 0, 1) == '_') {
                            if ($Translate->translate( $Modules->arr_module_init['sidebar'][ $d ],$Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']) == 'No Translation'){
                                print $Translate->get_translate_phrase($Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']);
                            } else {
                                print $Translate->translate( $Modules->arr_module_init['sidebar'][ $d ], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']);
                            }
                            }else{
                            print $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name'];
                            }
                    ?>
                </a>
            <?php
            endfor;
            endif;
        endfor;
        if(isset( $dop_content ) && isset ( $Modules->arr_module_init['sidebar'][ $dop_content ] ) )
        {
            echo "</div><div class='navbar-chlen'>";
            for ( $d = $dop_content, $c = sizeof( $Modules->arr_module_init['sidebar'] ); $d < $c; $d++ )
            {
                if( ! empty( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'] ) )
                {
                    for ( $_d = 0, $_c = sizeof( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'] ); $_d < $_c; $_d++ )
                    { ?>
                    <a href="<?php echo ($Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['page'] == 'home') ? $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['href'] : $General->arr_general['site'] . $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['page'] ?>" <?php $Modules->route == str_replace('/','',$Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['href']) ? print 'class="table-active"' : false?>
                        <?php ( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['open_new_tab'] == true ) ? print 'target="_blank"' : false?>>
                        <?php $General->get_icon( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon_group'], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon'], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon_category'] )?>
                        <?php if(substr( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name'], 0, 1) == '_') {
                                if ($Translate->translate( $Modules->arr_module_init['sidebar'][ $d ],$Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']) == 'No Translation'){
                                    print $Translate->get_translate_phrase($Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']);
                                } else {
                                    print $Translate->translate( $Modules->arr_module_init['sidebar'][ $d ], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']);
                                }
                                }else{
                                print $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name'];
                                }
                        ?>
                    </a>
                    <?php }
                }
            }
            echo "</div>";
        } else echo "    </div>";        ?>
    <ul class="right-area">
    <?php if(isset( $_SESSION['steamid'] ) ){ ?>
        <li class="section" style="padding: 4px;">
            <a href="<?php echo $General->arr_general['site'] ?>profiles/<?php echo $_SESSION['steamid64'] ?>/?search=1"><img style="height: 35px;border-radius: 10px;" src="<?php echo $General->getAvatar($_SESSION['steamid64'], 1) ?>" alt=""></a>
            <ul class="subsection">
                <li>
                    <a href="<?php echo $General->arr_general['site'] ?>profiles/<?php echo $_SESSION['steamid64'] ?>/?search=1">
                        My profile
                    </a>
                </li>
                <li>
                    <a href="#">
                        Balance: <?=$Modules->get_balance() ?? 0 ?>
                    </a>
                </li>
                <?php if( isset( $_SESSION['user_admin'] ) ): ?>
                    <li>
                        <a href="<?php echo $General->arr_general['site']?>adminpanel/">
                            AdminPanel
                        </a>
                    </li>
                <?php endif; ?>
                <li>
                    <a href="?auth=logout">
                        Log out
                    </a>
                </li>
            </ul>
        </li>
    <?php } ?>
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
    <?php if(empty($_SESSION["steamid"]))
    { ?>
        <a class="auth-navbar-btn" href="?auth=login">Sign in</a>
    <?php
    }?>    
</div>
<div class="global-container">
    <div class="container-fluid">
