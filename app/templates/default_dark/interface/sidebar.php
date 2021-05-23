<aside class="main-sidebar offcanvas">
    <section class="sidebar">
        <?php if( empty( $General->arr_general['disable_sidebar_change'] ) ):?><a href="javascript:void(0);" onclick="action_sidebar()" class="nav-toggle pp-nav-toggle"><i class="zmdi zmdi-menu"></i></a><?php endif?>
        <div class="user-sidebar-block">
            <?php if(!empty($_SESSION['steamid'])): ?>
                <div class="user-info">
                    <a href="<?php echo empty( $_SESSION['steamid32'] ) ? $General->arr_general['steam_only_authorization'] == 1 ? '?auth=login' : '#login' : $General->arr_general['site'] . 'profiles/' . $_SESSION['steamid'] . '/0/?search=1/'?>">
                        <?php ! empty( $_SESSION['steamid32'] ) && $General->get_js_relevance_avatar( $_SESSION['steamid32'] )?>
                        <img id="<?php echo empty( $_SESSION['steamid'] ) ? 0 : $_SESSION['steamid']?>" ondrag="return false" ondragstart="return false" src="<?php echo empty( $_SESSION['steamid'] ) ? $General->arr_general['site'].  'storage/cache/img/avatars_random/' . rand(1,30) . '_xs.jpg' : $General->getAvatar( $_SESSION['steamid64'], 1 )?>"></a>
                    <div class="user-details">
                        <span class="user_name"><?php echo action_text_clear( action_text_trim( (empty($General->checkName( $_SESSION['steamid64'] ))) ? $Auth->user_auth[0]['name'] : $General->checkName( $_SESSION['steamid64'] ), 17 ) )?></span>
                        <?php if( ! empty( $_SESSION['steamid'] ) ):?>
                            <?php if( ! empty( $Modules->arr_user_info ) ):
                            for ( $i5 = 0, $arr_user_info_c = sizeof( $Modules->arr_user_info ); $i5 < $arr_user_info_c; ++$i5 ):?>
                                <span class="user_text lk"><?php echo $Modules->arr_user_info[ $i5 ]?></span>
                            <?php endfor;
                            endif;?>
                            <span class="user_text"><?php echo $Translate->get_translate_phrase('_Plays_since')?> <?php echo empty( $Auth->user_auth[0]['lastconnect'] ) ? '-' : gmdate("d-m-Y", $Auth->user_auth[0]['lastconnect_max'] )?></span><span class="_logout"><a href="<?php echo $General->arr_general['site']?>/?auth=logout"><i class="zmdi zmdi-mail-reply-all"></i></a></span>
                        <?php else:?>
                            <span>
                                <?php if( $General->arr_general['steam_only_authorization'] == 0 ):?>
                                <a href="#login"><?php echo $Translate->get_translate_phrase('_Log_in')?></a>
                                <?php else:?>
                                <form id="log_in" enctype="multipart/form-data" method="post">
                                    <a href="?auth=login"><?php echo $Translate->get_translate_phrase('_Log_in')?></a>
                                </form>
                                <?php endif;?>
                            </span>
                        <?php endif;?>
                    </div>
                </div>
            <?php else: ?>
                <?php if( $General->arr_general['steam_auth'] == 1 ):?>
                    <a class="auth-btn" href="?auth=login"><i class="zmdi zmdi-steam-square"></i> SIGN IN WITH STEAM</a>
                    <a href="?auth=login" class="auth-steam-sidebar"><i class="zmdi zmdi-steam-square"></i></a>
                <?php endif; ?>
                <?php if( $General->arr_general['steam_only_authorization'] == 0 ):?>
                    <span class="user_or">Или</span>
                    <a class="login_in" href="#login"><?php echo $Translate->get_translate_phrase('_Log_in')?></a>
            <?php endif; endif; ?>
        </div>
        <ul class="sidebar-menu <?php echo !isset($_SESSION['user_admin']) && 'non-auth'; ?>">
            <li class="tooltip-js <?php $Modules->route == 'home' && print 'sidebar-active'?>" data-tooltip-js="home">
                <a href="<?php echo $General->arr_general['site'] ?>home">
                    <div class="sidebar-icon">
                        <?php $General->get_icon('zmdi', 'home', null )?>
                    </div>
                    <div class="item-name">
                        <?php echo $Translate->get_translate_phrase('_Home')?>
                    </div>
                </a>
            </li>
            <?php
            // Цикл -> Количество разделов sidebar
            for ( $d = 0, $c = sizeof( $Modules->arr_module_init['sidebar'] ); $d < $c; $d++ ):
                if( ! empty( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'] ) && $Modules->arr_module_init['sidebar'][ $d ] != 'module_sidebar_social' ):
                // Цикл -> Счёт количества
                for ( $_d = 0, $_c = sizeof( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'] ); $_d < $_c; $_d++ ):?>
                    <li class="tooltip-js <?php $Modules->route == str_replace('?page=','',$Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['href']) ? print 'sidebar-active' : false ?>" data-tooltip-js="<?php print $d."-".$_d;?>">
                        <a href="<?php echo $General->arr_general['site'] ?><?php echo $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['page']?>"
                            <?php ( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['open_new_tab'] == true ) ? print 'target="_blank"' : false?>>
                            <div class="sidebar-icon">
                                <?php $General->get_icon( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon_group'], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon'], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon_category'] )?>
                            </div>
                            <div class="item-name">
                            <?php if(substr( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name'], 0, 1) == '_') {
                                    if ($Translate->get_translate_module_phrase( $Modules->arr_module_init['sidebar'][ $d ],$Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']) == 'No Translation'){
                                        print $Translate->get_translate_phrase($Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']);
                                    } else {
                                        print $Translate->get_translate_module_phrase( $Modules->arr_module_init['sidebar'][ $d ], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']);
                                    }
                                  }else{
                                    print $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name'];
                                  }
                            ?>
                            </div>
                        </a>
                    </li>
                <?php
                endfor;
                endif;
            endfor;?>
        </ul>
    </section>
</aside>
<!-- Tooltip Block -->
<?php if( isset( $Auth->user_auth ) ): ?>
    <div class="tooltip-sidebar box-button-srv-0" style=""><?php echo $Translate->get_translate_phrase( $Auth->user_auth[0]['rank'], 'ranks_' . $Auth->server_info[ 0 ]['ranks_pack'] )?></div>
<?php endif; for ( $d = 1; $d < $Auth->user_rank_count; ++$d ):?>
    <div class="tooltip-sidebar box-button-srv-treeview-<?php echo $d?>"><?php echo $Translate->get_translate_phrase( $Auth->user_auth[$d]['rank'], 'ranks_' . $Auth->server_info[ 0 ]['ranks_pack'] )?></div>
<?php endfor;?>
<div class="tooltip-sidebar box-button-home"><?php echo $Translate->get_translate_phrase('_Home')?></div>
<?php
for ( $d = 0, $c = sizeof( $Modules->arr_module_init['sidebar'] ); $d < $c; $d++ ):
    if( ! empty( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'] ) ):
        for ( $_d = 0, $_c = sizeof( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'] ); $_d < $_c; $_d++ ):?>
            <div class="tooltip-sidebar box-button-<?php  print $d."-".$_d;?>">
                <?php if(substr( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name'], 0, 1) == '_') {
                    if ($Translate->get_translate_module_phrase( $Modules->arr_module_init['sidebar'][ $d ],$Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']) == 'No Translation'){
                        print $Translate->get_translate_phrase($Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']);
                    } else {
                        print $Translate->get_translate_module_phrase( $Modules->arr_module_init['sidebar'][ $d ], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']);
                    }
                    }else{
                    print $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name'];
                    }?>
            </div>
<?php   endfor;
    endif;
endfor;?>
<!-- End -->
<?php if( $General->arr_general['steam_only_authorization'] == 0 ):?>
<div id="login" class="modal-window">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?php echo $Translate->get_translate_phrase('_Authorization')?></h5>
                <a href="#" title="Закрыть" class="modal-close badge"><?php $General->get_icon( 'zmdi', 'close' )?></a>
            </div>
            <form id="log_in" enctype="multipart/form-data" method="post">
                <div class="login_form">
                    <div class="input-form">
                        <label><?php echo $Translate->get_translate_phrase('_Login')?></label>
                        <input type="text" value="" name="_login"/>
                    </div>
                    <div class="input-form">
                        <label><?php echo $Translate->get_translate_phrase('_Password')?></label>
                        <input type="text" value="" name="_pass"/>
                    </div>
                    <input class="btn no_steam" name="log_in" nam type="submit" value="<?php echo $Translate->get_translate_phrase('_Log_in')?>">
                </div>
            </form>
        </div>
</div>
<?php endif;?>
