<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?php echo $Translate->get_translate_phrase('_List_recent_bans')?></h5>
            </div>
            <div class=table-responsive>
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th class="text-center tb-game"><?php echo $Translate->get_translate_phrase('_Game') ?></th>
                        <th class="text-center"><?php echo $Translate->get_translate_phrase('_Date') ?></th>
                        <?php if( $General->arr_general['avatars'] != 0 ):?>
                        <th class="text-right tb-avatar"></th>
                        <?php endif?>
                        <th class="text-left"><?php echo $Translate->get_translate_phrase('_Player') ?></th>
                        <?php if( $General->arr_general['avatars'] != 0 ):?>
                        <th class="text-right tb-avatar"></th>
                        <?php endif?>
                        <th class="text-left"><?php echo $Translate->get_translate_phrase('_Admin') ?></th>
                        <th class="text-center"><?php echo $Translate->get_translate_phrase('_Term') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ($i = 0, $c_b = sizeof( $res_bans ); $i < $c_b; $i++) {
                        $General->get_js_relevance_avatar( $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_bans[$i]['authid'] ) : $res_bans[$i]['authid'] );
                        $res_bans[$i]['aid'] != '0' && $General->get_js_relevance_avatar( $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_bans[$i]['admin_authid'] ) : $res_bans[$i]['admin_authid'] )?><tr>
                            <th class="text-center tb-game"><img <?php $i  < '20' ? print 'src' : print 'data-src'?>="./storage/cache/img/mods/<?php echo $mod?>.png"></th>
                            <th class="text-center"><?php echo date('Y-m-d', $res_bans[ $i ]['created']) ?></th>
                            <?php if( $General->arr_general['avatars'] != 0 ) {?>
                                <th class="text-right tb-avatar pointer" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_bans[ $i ]['authid'] ) : $res_bans[ $i ]['authid']?>&search=1' "<?php } ?>><img class="rounded-circle" id="<?php echo con_steam32to64($res_bans[ $i ]['authid']) ?>"<?php echo $i  < '20' ? 'src' : 'data-src'?>="<?php echo $General->getAvatar( con_steam32to64( $res_bans[ $i ]['authid'] ), 2 )?>"></th>
                            <?php } ?>
                            <th class="text-left pointer" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_bans[ $i ]['authid'] ) : $res_bans[ $i ]['authid']?>&search=1' "<?php } ?>>
                                <a <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>href="<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_bans[ $i ]['authid'] ) : $res_bans[ $i ]['authid']?>&search=1"<?php } ?>><?php echo action_text_clear( action_text_trim($res_bans[ $i ]['name'], 13) )?></a>
                            </th>
                            <?php if( $General->arr_general['avatars'] != 0 ) {?>
                            <th class="text-right tb-avatar <?php $res_bans[ $i ]['aid'] != '0' && print 'a-type'?>" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1' && $res_bans[ $i ]['aid'] != '0'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_bans[ $i ]['admin_authid'] ) : $res_bans[ $i ]['admin_authid']?>&search=1' "<?php } ?>><img class="rounded-circle" id="<?php echo con_steam32to64( $res_bans[ $i ]['admin_authid'] ) ?>"<?php echo $i  < '20' ? 'src' : 'data-src'?>="<?php echo $res_bans[ $i ]['admin_authid'] != 'STEAM_ID_SERVER' ? $General->getAvatar( con_steam32to64( $res_bans[ $i ]['admin_authid'] ), 2 ) : 'storage/cache/img/avatars_random/20.jpg'?>"></th><?php }?>
                            <th class="text-left <?php $res_bans[ $i ]['aid'] != '0' && print 'pointer'?>" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1' && $res_bans[ $i ]['aid'] != '0'): ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_bans[ $i ]['admin_authid'] ) : $res_bans[ $i ]['admin_authid']?>&search=1' "<?php endif; ?>>
                                <a <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1' && $res_bans[ $i ]['aid'] != '0'): ?>href="<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_bans[ $i ]['admin_authid'] ) : $res_bans[ $i ]['admin_authid']?>&search=1"<?php endif; ?>><?php echo action_text_clear( action_text_trim($res_bans[ $i ]['user'], 13) )?></a>
                            </th>
                            <th class="text-center"><?php
                                if ($res_bans[$i]['length'] == '0' && $res_bans[$i]['RemoveType'] != 'U') {
                                    echo $ban_type['0'];
                                } elseif ($res_bans[$i]['RemoveType'] == 'U') {
                                    echo $ban_type['1'];
                                } elseif ($res_bans[$i]['length'] < '0' && time() >= $res_bans[$i]['ends']) {
                                    echo $ban_type['2'];
                                } elseif (time() >= $res_bans[$i]['ends'] && $res_bans[$i]['length'] != '0') {
                                    echo '<div class="color-green"><strike>' . $Modules->action_time_exchange( $res_bans[$i]['length'] ) . '</strike></div>';
                                }  else {
                                    echo $Modules->action_time_exchange( $res_bans[$i]['length'] );
                                }?>
                            </th>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?php echo $Translate->get_translate_phrase('_List_recent_mut_gags')?></h5>
            </div>
            <div class=table-responsive>
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th class="text-center"><?php echo $Translate->get_translate_phrase('_Type') ?></th>
                        <th class="text-center"><?php echo $Translate->get_translate_phrase('_Date') ?></th>
                        <?php if( $General->arr_general['avatars'] != 0 ) {?><th class="text-right tb-avatar"></th><?php }?>
                        <th class="text-left"><?php echo $Translate->get_translate_phrase('_Player') ?></th>
                        <?php if( $General->arr_general['avatars'] != 0 ) {?><th class="text-right tb-avatar"></th><?php }?>
                        <th class="text-left"><?php echo $Translate->get_translate_phrase('_Admin') ?></th>
                        <th class="text-center"><?php echo $Translate->get_translate_phrase('_Term') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    for ($i = 0, $c_c = sizeof( $res_comms ); $i < $c_c; $i++) {
                        $General->get_js_relevance_avatar( $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_comms[ $i ]['authid'] ) : $res_comms[ $i ]['authid'] );
                        $res_comms[ $i ]['aid'] != '0' && $General->get_js_relevance_avatar( $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_comms[ $i ]['admin_authid'] ) : $res_comms[ $i ]['admin_authid'] )?><tr>
                            <th class="text-center tb-type"><?php $res_comms[ $i ]['type'] == 1 ? $General->get_icon( 'zmdi', 'mic', null ) : $General->get_icon( 'zmdi', 'comment-text', null )?></th>
                            <th class="text-center"><?php echo date('Y-m-d', $res_comms[ $i ]['created']) ?></th>
                            <?php if( $General->arr_general['avatars'] != 0 ) {?>
                                <th class="text-right tb-avatar pointer" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_comms[ $i ]['authid'] ) : $res_comms[ $i ]['authid']?>&search=1' "<?php } ?>><img class="rounded-circle" id="<?php echo con_steam32to64($res_comms[ $i ]['authid']) ?>"<?php $i  < '20' ? print 'src' : print 'data-src'?>="
                        <?php echo $General->getAvatar( con_steam32to64( $res_comms[ $i ]['authid'] ), 2 )?>"></th>
                                </th>
                            <?php } ?>
                            <th class="text-left pointer" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_comms[ $i ]['authid'] ) : $res_comms[ $i ]['authid']?>&search=1' "<?php } ?>>
                                <a <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1'){ ?>href="<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_comms[ $i ]['authid'] ) : $res_comms[ $i ]['authid']?>&search=1"<?php } ?>><?php echo action_text_clear( action_text_trim($res_comms[ $i ]['name'], 13) )?></a>
                            </th>
                            <?php if( $General->arr_general['avatars'] != 0 ) {?>
                            <th class="text-right tb-avatar <?php $res_comms[ $i ]['aid'] != '0' && print 'a-type'?>" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1' && $res_comms[ $i ]['aid'] != '0'){ ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_comms[ $i ]['admin_authid'] ) : $res_comms[ $i ]['admin_authid']?>&search=1' "<?php } ?>><img class="rounded-circle" id="<?php echo con_steam32to64( $res_comms[ $i ]['admin_authid'] ) ?>"<?php $i  < '20' ? print 'src' : print 'data-src'?>="<?php echo $res_comms[ $i ]['admin_authid'] != 'STEAM_ID_SERVER' ? $General->getAvatar( con_steam32to64( $res_comms[ $i ]['admin_authid'] ), 2 ) : 'storage/cache/img/avatars_random/20.jpg'?>"></th><?php }?>
                            <th class="text-left <?php $res_comms[ $i ]['aid'] != '0' && print 'pointer'?>" <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1' && $res_comms[ $i ]['aid'] != '0'): ?>onclick="location.href = '<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_comms[ $i ]['admin_authid'] ) : $res_comms[ $i ]['admin_authid']?>&search=1' "<?php endif; ?>>
                                <a <?php if ($Modules->array_modules['module_page_profiles']['setting']['status'] == '1' && $res_comms[ $i ]['aid'] != '0'): ?>href="<?php echo $General->arr_general['site'] ?>?page=profiles&profile=<?php print $General->arr_general['only_steam_64'] === 1 ? con_steam32to64( $res_comms[ $i ]['admin_authid'] ) : $res_comms[ $i ]['admin_authid']?>&search=1"<?php endif; ?>><?php echo action_text_clear( action_text_trim($res_comms[ $i ]['user'], 13) )?></a>
                            </th>
                            <th class="text-center"><?php
                                if ( $res_comms[ $i ]['length'] == '0' && $res_comms[ $i ]['RemoveType'] != 'U' ) {
                                    echo $comms_type['0'];
                                } elseif ( $res_comms[$i]['RemoveType'] == 'U') {
                                    echo $comms_type['1'];
                                } elseif ( $res_comms[$i]['length'] < '0' && time() >= $res_comms[$i]['ends'] ) {
                                    echo $comms_type['2'];
                                } elseif (time() >= $res_comms[$i]['ends'] && $res_comms[$i]['length'] != '0') {
                                    echo '<div class="color-green"><strike>' . $Modules->action_time_exchange( $res_comms[$i]['length'] ) . '</strike></div>';
                                }  else {
                                    echo $Modules->action_time_exchange( $res_comms[$i]['length'] );
                                }?>
                            </th>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>