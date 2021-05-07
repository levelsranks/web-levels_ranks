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
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?php echo $Translate->get_translate_phrase('_Bans')?></h5>
                <div class="select-panel select-panel-pages badge"><select onChange="window.location.href=this.value">
                        <option style="display:none" value="" disabled
                                selected><?php echo $page_num ?></option><?php for ($v = 0; $v < $page_max; $v++):?>
                        <option value="<?php echo set_url_section(get_url(2), 'num', $v + 1) ?>"><a
                                    href="<?php echo set_url_section(get_url(2), 'num', $v + 1) ?>"><?php echo $v + 1 ?></a>
                            </option><?php endfor;?></select></div>
            </div>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="text-center tb-game"><?php echo $Translate->get_translate_phrase('_Game') ?></th>
                    <th class="text-center"><?php echo $Translate->get_translate_phrase('_Date') ?></th>
                    <?php if( $General->arr_general['avatars'] != 0 ) {?><th class="text-right tb-avatar"></th><?php }?>
                    <th class="text-left"><?php echo $Translate->get_translate_phrase('_Player') ?></th>
                    <?php if( $General->arr_general['avatars'] != 0 ) {?><th class="text-right tb-avatar"></th><?php }?>
                    <th class="text-left"><?php echo $Translate->get_translate_phrase('_Admin') ?></th>
                    <th class="text-left"><?php echo $Translate->get_translate_phrase('_Reason') ?></th>
                    <th class="text-center"><?php echo $Translate->get_translate_phrase('_Term') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php for ( $i = 0, $sz = sizeof( $res ); $i < $sz; $i++ ):
                    $General->get_js_relevance_avatar( $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[$i]['authid'] ) : $res[$i]['authid'] );
                    $res[$i]['aid'] != '0' && $General->get_js_relevance_avatar( $res[ $i ]['admin_authid'] )?><tr>
                        <th class="text-center tb-game"><img <?php $i  < '20' ? print 'src' : print 'data-src'?>="./storage/cache/img/mods/<?php echo $mod?>.png"></th>
                        <th class="text-center"><?php echo date('Y-m-d', $res[ $i ]['created']) ?></th>
                        <?php if( $General->arr_general['avatars'] != 0 ) {?>
                            <th class="text-right tb-avatar pointer" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[ $i ]['authid'] ) : $res[ $i ]['authid']?>&search=1' "<?php } ?>><img class="rounded-circle" id="<?php echo con_steam32to64( $res[ $i ]['authid'] ) ?>"<?php echo $i  < '20' ? 'src' : 'data-src'?>="<?php echo $General->getAvatar( con_steam32to64( $res[ $i ]['authid'] ), 2 )?>"></th>
                        <?php } ?>
                        <th class="text-left pointer" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[ $i ]['authid'] ) : $res[ $i ]['authid']?>&search=1' "<?php } ?>>
                            <a <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>href="<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[ $i ]['authid'] ) : $res[ $i ]['authid']?>&search=1"<?php } ?>><?php echo action_text_clear( action_text_trim($res[ $i ]['name'], 13) )?></a>
                        </th>
                        <?php if( $General->arr_general['avatars'] != 0 ):?>
                            <th class="text-right tb-avatar <?php $res[ $i ]['aid'] != '0' && print 'a-type'?>" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1' && $res[ $i ]['aid'] != '0'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[ $i ]['admin_authid'] ) : $res[ $i ]['admin_authid']?>&search=1' "<?php } ?>><img class="rounded-circle" id="<?php echo con_steam32to64($res[ $i ]['admin_authid']) ?>"<?php echo $i  < '20' ? 'src' : 'data-src'?>="<?php echo $res[ $i ]['admin_authid'] != 'STEAM_ID_SERVER' ? $General->getAvatar( con_steam32to64( $res[ $i ]['admin_authid'] ), 2 ) : 'storage/cache/img/avatars_random/20.jpg'?>"></th>
                        <?php endif?>
                        <th class="text-left <?php $res[ $i ]['aid'] != '0' && print 'pointer'?>" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1' && $res[ $i ]['aid'] != '0'): ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[ $i ]['admin_authid'] ) : $res[ $i ]['admin_authid']?>&search=1' "<?php endif; ?>>
                            <a <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1' && $res[ $i ]['aid'] != '0'): ?>href="<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res[ $i ]['admin_authid'] ) : $res[ $i ]['admin_authid']?>&search=1"<?php endif; ?>><?php echo action_text_clear( action_text_trim($res[ $i ]['user'], 13) )?></a>
                        </th>
                        <th class="text-left"><?php echo $res[ $i ]['reason'] ?></th>
                        <th class="text-center"><?php
                            if ($res[$i]['length'] == '0' && $res[$i]['RemoveType'] != 'U') {
                                echo $ban_type['0'];
                            } elseif ($res[$i]['RemoveType'] == 'U') {
                                echo $ban_type['1'];
                            } elseif ($res[$i]['length'] < '0' && time() >= $res[$i]['ends']) {
                                echo $ban_type['2'];
                            } elseif (time() >= $res[$i]['ends'] && $res[$i]['length'] != '0') {
                                echo '<div class="color-green"><strike>' . $Modules->action_time_exchange( $res[$i]['length'] ) . '</strike></div>';
                            }  else {
                                echo $Modules->action_time_exchange( $res[$i]['length'] );
                            }?>
                        </th>
                    </tr>
                <?php endfor; ?>
                </tbody>
            </table>
            <div class="card-bottom">
                <?php if( $page_max != 1):?>
                <div class="select-panel-pages">
                    <?php endif;?>
                    <?php if ($page_num != 1):?>
                        <a href="<?php echo set_url_section( get_url(2), 'num', $page_num - 1 ) ?>"><h5 class="badge"><?php $General->get_icon( 'zmdi', 'chevron-left' ) ?></h5></a>
                    <?php endif; ?>
                    <?php if( $page_num != $page_max ): ?>
                        <a href="<?php echo set_url_section( get_url(2), 'num', $page_num + 1 ) ?>"><h5 class="badge"><?php $General->get_icon( 'zmdi', 'chevron-right' ) ?></h5></a>
                    <?php endif; ?>
                    <?php if( $page_max != 1):?>
                </div>
            <?php endif;?>
            </div>
        </div>
    </div>
</div>