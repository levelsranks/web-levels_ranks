<aside class="main-sidebar offcanvas">
    <section class="sidebar">
        <div class="user-sidebar-block">
            <div class="user-info">
                <a href="<?php echo empty( $_SESSION['steamid32'] ) ? $General->arr_general['steam_only_authorization'] == 1 ? '?auth=login' : '#login' : $General->arr_general['site'] . 'profiles/' . $_SESSION['steamid'] . '/0/?search=1/'?>">
                    <?php ! empty( $_SESSION['steamid32'] ) && $General->get_js_relevance_avatar( $_SESSION['steamid32'] )?>
                    <img id="<?php echo empty( $_SESSION['steamid'] ) ? 0 : $_SESSION['steamid']?>" ondrag="return false" ondragstart="return false" src="<?php echo empty( $_SESSION['steamid'] ) ? $General->arr_general['site'].  'storage/cache/img/avatars_random/' . rand(1,30) . '_xs.jpg' : $General->getAvatar( $_SESSION['steamid64'], 1 )?>"></a>
                <div class="user-details">
                    <span class="user_name"><?php echo empty( $_SESSION['steamid'] ) ? $Translate->get_translate_phrase('_Hero_without_name') : action_text_clear( action_text_trim( (empty($General->checkName( $_SESSION['steamid64'] ))) ? $Auth->user_auth[0]['name'] : $General->checkName( $_SESSION['steamid64'] ), 17 ) )?></span>
                    <?php if( ! empty( $_SESSION['steamid'] ) ):?>
                        <span class="user_text"><?php echo $Translate->get_translate_phrase('_Plays_since')?> <?php echo empty( $Auth->user_auth[0]['lastconnect'] ) ? '-' : gmdate("d-m-Y", $Auth->user_auth[0]['lastconnect_max'] )?></span><span class="_logout"><a href="<?php echo $General->arr_general['site']?>/?auth=logout"><i class="zmdi zmdi-mail-reply-all invert"></i></a></span>
                        <?php if( ! empty( $Modules->arr_user_info ) ):
                        for ( $i5 = 0, $arr_user_info_c = sizeof( $Modules->arr_user_info ); $i5 < $arr_user_info_c; ++$i5 ):?>
                        <span class="user_text"><?php echo $Modules->arr_user_info[ $i5 ]?></span>
                        <?php endfor;
                        endif;?>
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
            <?php if( ! empty( $_SESSION['steamid'] ) && isset( $Auth->user_auth[0]['rank'] ) ): $General->get_js_relevance_avatar( $_SESSION['steamid64'] ); ?>
                <div class="rank-info">
                    <li class="rank-mini-li"><a href="javascript:void(0);" onclick="action_treeview()" >
                            <div class="user-rank tooltip-js" data-tooltip-js="srv-0">
                                <div class="rank_img"><img src="<?php echo empty( $Auth->user_auth[0]['rank'] ) ? $General->arr_general['site'] . '/storage/cache/img/ranks/' . $Auth->server_info[ 0 ]['ranks_pack'] . '/00' : $General->arr_general['site'] . '/storage/cache/img/ranks/' . $Auth->server_info[ 0 ]['ranks_pack'] . '/' . $Auth->user_auth[0]['rank']?>.png"></div>
                                <div class="rank-details">
                                    <?php echo $Translate->get_translate_phrase( $Auth->user_auth[0]['rank'], 'ranks_' . $Auth->server_info[ 0 ]['ranks_pack'] )?>
                                </div>
                                <?php if ( $Auth->user_rank_count != 1 ):?>
                                    <div class="icon-down">
                                        <?php $General->get_icon( 'zmdi', 'chevron-down', null )?>
                                    </div>
                                <?php endif;?>
                            </div>
                        </a>
                        <ul class="treeview-menu">
                            <?php for ( $d = 1; $d < $Auth->user_rank_count; ++$d ):?>
                                <li>
                                    <div class="user-rank-more tooltip-js" data-tooltip-js="srv-treeview-<?echo $d?>">
                                        <div class="rank_img"><img src="<?php echo empty( $Auth->user_auth[ $d ]['rank'] ) ? $General->arr_general['site'] . '/storage/cache/img/ranks/' . $Auth->server_info[ $d ]['ranks_pack'] . '/00' : $General->arr_general['site'] . '/storage/cache/img/ranks/' . $Auth->server_info[ $d ]['ranks_pack'] . '/' . $Auth->user_auth[ $d ]['rank']?>.png"></div>
                                        <div class="rank-details"><?php echo $Translate->get_translate_phrase( $Auth->user_auth[ $d ]['rank'] ?? 0, 'ranks_' . $Auth->server_info[ $d ]['ranks_pack'] )?></div>
                                    </div>
                                </li>
                            <?php endfor;?>
                        </ul>
                    </li>
                </div>
            <?php endif;?>
        </div>
        <ul class="sidebar-menu">
            <li class="tooltip-js" data-tooltip-js="home">
                <a href="<?php echo $General->arr_general['site'] ?>home/" <?php $Modules->route == 'home' && print 'class="table-active"'?>>
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
                if( ! empty( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'] ) ):
                // Цикл -> Счёт количества
                for ( $_d = 0, $_c = sizeof( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'] ); $_d < $_c; $_d++ ):?>
                    <li class="tooltip-js" data-tooltip-js="<?php print $d."-".$_d;?>">
                        <a href="<?php echo ($Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['page'] == 'home') ? $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['href'] : $General->arr_general['site'] . $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['page'] ?>" <?php $Modules->route == str_replace('/','',$Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['href']) ? print 'class="table-active"' : false?>
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
                    <?php if( $General->arr_general['steam_auth'] == 1 ):?>
                        <a href="?auth=login"><?php echo $Translate->get_translate_phrase('_Steam_login')?></a>
                    <?php endif;?>
                    <input class="btn no_steam" name="log_in" nam type="submit" value="<?php echo $Translate->get_translate_phrase('_Log_in')?>">
                </div>
            </form>
        </div>
</div>
<?php endif;?>
