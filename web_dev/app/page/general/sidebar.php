<?php
/**
 * @author Anastasia Sidak <m0st1ce.nastya@gmail.com>
 *
 * @link https://steamcommunity.com/profiles/76561198038416053
 * @link https://github.com/M0st1ce
 *
 * @license GNU General Public License Version 3
 */

// Проверяем на существование сессию и при её наличии собираем информацию об игроке.
if ( $_SESSION['steamid'] ) {
    // С помощью цикла делаем запросы к базе данных.
    for ( $d = 0; $d < $Db->table_count['LevelsRanks']; $d++ ) {
        $res_data_sidebar[] = ['name_servers' => $Db->db_data['LevelsRanks'][$d]['name'], 'mod' => $Db->db_data['LevelsRanks'][$d]['mod'], 'data_servers' => $Db->db_data['LevelsRanks'][$d]['Table']];
        $base_info = $Db->query('LevelsRanks',  $Db->db_data['LevelsRanks'][$d]['DB_num'], 'SELECT name, lastconnect, rank FROM ' . $Db->db_data['LevelsRanks'][$d]["Table"] . ' where steam="' . $_SESSION['steamid32'] . '"' );
        if ($base_info != '') {
            $user_auth[] = $base_info;
            $lastconnect[] = $base_info['lastconnect'];
        }
    }

    if ( $user_auth[0] == '' || $user_auth[0] == '' ) {
        $user_auth[0] = ['name' => 'Неизвестно', 'lastconnect' => '', 'rank' => '00'];
        $lastconnect = '-';
        $res_data_sidebar[0]['name_servers'] = 'Неизвестно';
    }

    $user_rank_count = sizeof( $user_auth );
}?>
<aside class="main-sidebar offcanvas">
    <section class="sidebar">
        <div class="user-sidebar-block">
            <div class="user-info">
                <a href="<?php empty( $_SESSION['steamid32'] ) ? print '#' : print $General->arr_general['site'] . '?page=profiles&profile=' . $_SESSION['steamid32']?>">
                    <?php if( $General->arr_general['avatars'] != 0 ) {?><script>CheckAvatar = <?php empty( $_SESSION['steamid'] ) ? print 0 : $General->checkAvatar( $_SESSION['steamid'], 2 )?>;if(CheckAvatar == 1) {avatar.push("<?php echo $_SESSION['steamid']?>");}</script><?php }?>
                    <img id="<?php empty( $_SESSION['steamid'] ) ? print 0 : print $_SESSION['steamid']?>" ondrag="return false" ondragstart="return false" src="
                    <?php if( empty( $_SESSION['steamid'] ) ) { echo 'storage/cache/img/avatars_random/' . rand(1,30) . '_xs.jpg';
                    } else{
                    if ( $General->arr_general['avatars'] == 1){ echo $General->getAvatar($_SESSION['steamid'],1);
                    } elseif( $General->arr_general['avatars'] == 2 || $General->arr_general['avatars'] == 0) {
                        echo 'storage/cache/img/avatars_random/' . rand(1,30) . '_xs.jpg';
                    }}?>"></a>
                <div class="user-details">
                    <span class="user_name"><?php empty( $_SESSION['steamid'] ) ? print 'Герой без имени' : print $user_auth[0]['name']?></span>
                    <?php if( $_SESSION['steamid'] != '' ):?>
                        <span class="user_datetime"><?php echo $Modules->get_translate_phrase('_Plays_since')?> <?php ($lastconnect == '-') ? print $lastconnect : print gmdate("d-m-Y", max($lastconnect))?></span>
                    <?php else:?>
                        <span><a href="#login">Войти</a></span>
                    <?php endif;?>
                </div>
            </div>
            <?php if( ! empty( $_SESSION['steamid'] ) ):?>
                <div class="rank-info">
                    <li class="rank-mini-li"><a href="">
                        <div class="user-rank tooltip-right" data-tooltip="<?php echo $res_data_sidebar[0]['name_servers'];?>">
                            <img src="<?php empty( $user_auth[0]['rank'] ) ? print '00' : print 'storage/cache/img/ranks/' . $General->arr_general['ranks_pack'] . '/' . $user_auth[0]['rank']?>.png">
                            <div class="rank-details">
                                <?php echo $Modules->get_translate_phrase( '_Rank_' . $user_auth[0]['rank'] )?>
                            </div>
                            <?php if ( $user_rank_count != 1 ):?>
                            <div class="icon-down"><?php $General->get_icon( 'zmdi', 'chevron-down', null )?></div>
                            <?php endif;?>
                        </div>
                        </a>
                        <ul class="treeview-menu">
                            <?php for ( $d = 1; $d < $user_rank_count; ++$d ):?>
                                <li>
                                    <div class="user-rank-more tooltip-right" data-tooltip="<?php echo $res_data_sidebar[ $d ]['name_servers']?>">
                                        <img src="<?php empty( $user_auth[ $d ]['rank'] ) ? print '00' : print 'storage/cache/img/ranks/' . $General->arr_general['ranks_pack'] . '/' . $user_auth[ $d ]['rank']?>.png">
                                        <div class="rank-details"><?php echo $Modules->get_translate_phrase( '_Rank_' . $user_auth[$d]['rank'] )?></div>
                                    </div>
                                </li>
                            <?php endfor;?>
                        </ul>
                    </li>
                </div>
            <?php endif;?>
        </div>
        <ul class="sidebar-menu">
            <li class="tooltip-right" data-tooltip="<?php echo $Modules->get_translate_phrase('_Home')?>"><a href="?page=home" <?php get_section( 'page', 'home' ) == 'home' && print 'class="table-active"'?>>
                    <div class="sidebar-icon"><?php $General->get_icon('zmdi', 'home', null )?></div>
                    <div class="item-name"><?php echo $Modules->get_translate_phrase('_Home')?></div>
                </a>
            </li>
            <?php for ( $d = 0, $c = sizeof( $Modules->arr_module_init['sidebar'] ); $d < $c; $d++ ):
                    for ( $_d = 0, $_c = sizeof( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'] ); $_d < $_c; $_d++ ):?>
            <li class="tooltip-right" data-tooltip="<?php mb_substr( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name'], 0, 1) == '_' ? print $Modules->get_translate_phrase($Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']) : print $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']?>">
                <a href="<?php echo $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['href']?>" <?php get_section( 'page', 'home' ) == str_replace('?page=','',$Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['href']) ? print 'class="table-active"' : false?>
                    <?php ( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['open_new_tab'] == true ) ? print 'target="_blank"' : false?>>
                    <div class="sidebar-icon">
                        <?php $General->get_icon( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon_group'], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon'], $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['icon_category'] )?>
                    </div>
                    <div class="item-name">
                        <?php mb_substr( $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name'], 0, 1) == '_' ? print $Modules->get_translate_phrase($Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']) : print $Modules->array_modules[ $Modules->arr_module_init['sidebar'][ $d ] ]['sidebar'][ $_d ]['name']?>
                    </div>
                </a>
            </li>
            <?php   endfor;
                  endfor;
                  if( $General->arr_general['admin'] == $_SESSION['steamid32'] ):?>
            <li class="tooltip-right" data-tooltip="Панель администратора">
                <a href="<?php echo get_url(2) . '?page=adminpanel'?>">
                    <div class="sidebar-icon">
                        <?php $General->get_icon( 'zmdi', 'coffee' )?>
                    </div>
                    <div class="item-name">
                        Панель администратора
                    </div>
                </a>
            </li>
            <?php endif;?>
        </ul>
    </section>
</aside>
<div class="swipe-area offcanvas"></div>
<div id="login" class="modal-window">
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="badge">Авторизация</h5>
                <a href="#" title="Закрыть" class="modal-close badge"><?php $General->get_icon( 'zmdi', 'close' )?></a>
            </div>
            <form id="log_in" enctype="multipart/form-data" method="post">
            <div class="login_form">
            <div class="input-form">
                <label>Логин</label>
                <input type="text" value="" name="_login"/>
            </div>
            <div class="input-form">
                <label>Пароль</label>
                <input type="text" value="" name="_pass"/>
            </div>
                <?php if( $General->arr_general['steam_auth'] == 1 ) {?><a href="?auch=login">Войти по Steam</a><?php }?>
                <input class="btn no_steam" name="log_in" nam type="submit" value="Войти">
            </div>
            </form>
        </div>
    </div>
</div>