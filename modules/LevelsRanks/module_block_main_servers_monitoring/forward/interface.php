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
<script>servers.push(<?php echo json_encode( action_array_keep_keys( $General->server_list, ['ip', 'fakeip'] ) )?>);</script>
<?php $servers_cache = $Modules->get_module_cache('module_block_main_servers_monitoring');
switch ( $Modules->array_modules['module_block_main_servers_monitoring']['setting']['type'] ) {
    case 1:?>
        <div class="row">
            <?php for ( $i_server = 0; $i_server < $General->server_list_count; $i_server++ ):?>
                <?php if ( $General->server_list_count % 3 == 1 && $i_server == $General->server_list_count - 1 ):?>
                    <div class="col-md-4 mon-1"><div class="card plug"><div class="x_1_invert"></div></div></div>
                <?php endif;?>
                <div class="col-md-4 mon-1">
                    <div class=card>
                        <div class=custom-server>
                            <div class="data-basic">
                                <div class="data-name" id="server-name-<?php echo $i_server?>">-</div>
                                <div class="online">
                                    <div id="online_gr-<?php echo $i_server?>" class="online2" style="width:0%"></div>
                                    <div class="value" id="server-players-<?php echo $i_server?>"></div>
                                </div>
                                <div class="border_ip"></div>
                                <div class="ip" id="server-ip-<?php echo $i_server?>"></div>
                                <a class="btn_connect btn_connect_<?php echo $i_server?>" id="<?php echo $i_server?>" onclick="get_players_data(id)" href="javascript:void(0);"><i class="icon-connect zmdi zmdi-caret-right-circle zmdi-hc-fw"></i></a>
                            </div>
                            <img ondrag="return false" ondragstart="return false" id="server-map-image-<?php echo $i_server?>" src="./storage/cache/img/maps/<?php echo empty( $servers_cache[ $i_server ] ) ? '730/-' : $servers_cache[ $i_server ]?>.jpg">
                        </div>
                    </div>
                </div>
            <?php endfor;?>
            <?php if ( $General->server_list_count % 3 != 0 ):?>
                <div class="col-md-4 mon-1"><div class="card plug"><div class="x_1"></div></div></div>
            <?php endif;?>
        </div>
        <div class="row">
            <div class="col-md-12 mon-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="badge"><?php echo $Translate->get_translate_phrase('_Online_mon')?></h5>
                    </div>
                    <div class=table-responsive>
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th class="text-center"><?php echo $Translate->get_translate_phrase('_Game')?></th>
                                <th class="text-left"><?php echo $Translate->get_translate_phrase('_Name')?></th>
                                <th class="text-center"><?php echo $Translate->get_translate_phrase('_Players')?></th>
                                <th class="text-center"><?php echo $Translate->get_translate_phrase('_Map')?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for ( $i_server = 0; $i_server < $General->server_list_count; $i_server++ ) {?>
                                <tr class="pointer str_connect_<?php echo $i_server?>" id="<?php echo $i_server?>" onclick="get_players_data(id)">
                                    <th class="text-center"><img id="server-tablemod-<?php echo $i_server?>" src="./storage/cache/img/global/null.png"></th>
                                    <th class="text-left" id="server-tablename-<?php echo $i_server?>"></th>
                                    <th class="text-center" id="server-tableplayers-<?php echo $i_server?>"></th>
                                    <th class="text-center" id="server-tablemap-<?php echo $i_server?>"></th>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php break;case 2:?>
    <div class="row">
        <div class="col-md-12 mon-2">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo $Translate->get_translate_phrase('_Online_mon')?></h5>
                </div>
                <div class=table-responsive>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center"><?php echo $Translate->get_translate_phrase('_Game')?></th>
                            <th class="text-left"><?php echo $Translate->get_translate_phrase('_Name')?></th>
                            <th class="text-center"><?php echo $Translate->get_translate_phrase('_Players')?></th>
                            <th class="text-center"><?php echo $Translate->get_translate_phrase('_Map')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ( $i_server = 0; $i_server < $General->server_list_count; $i_server++ ) {?>
                            <tr class="pointer str_connect_<?php echo $i_server?>" id="<?php echo $i_server?>" onclick="get_players_data(id)">
                                <th class="text-center"><img id="server-tablemod-<?php echo $i_server?>" src="./storage/cache/img/global/null.png"></th>
                                <th class="text-left" id="server-tablename-<?php echo $i_server?>"></th>
                                <th class="text-center" id="server-tableplayers-<?php echo $i_server?>"></th>
                                <th class="text-center" id="server-tablemap-<?php echo $i_server?>"></th>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php break;case 3: // Привет ребятам с SiberiaGaming.ru :D ?>
    <div class="row">
        <?php for ( $i_server = 0; $i_server < $General->server_list_count; $i_server++ ):?>
            <?php if ( $General->server_list_count % 3 == 1 && $i_server == $General->server_list_count - 1 ):?>
                <div class="col-md-4 mon-1"><div class="card plug"><div class="x_1_invert"></div></div></div>
            <?php endif;?>
            <div class="col-md-4 mon-1">
                <div class=card>
                    <div class=custom-server>
                        <div class="data-basic">
                            <div class="data-name" id="server-name-<?php echo $i_server?>">-</div>
                            <div class="online">
                                <div id="online_gr-<?php echo $i_server?>" class="online2" style="width:0%"></div>
                                <div class="value" id="server-players-<?php echo $i_server?>"></div>
                            </div>
                            <div class="border_ip">
                                <div class="ip" id="server-ip-<?php echo $i_server?>"></div>
                            </div>
                            <a class="btn_connect btn_connect_<?php echo $i_server?>" id="<?php echo $i_server?>" onclick="get_players_data(id)" href="javascript:void(0);"><div class="btn_connect_text"><?php echo $Translate->get_translate_phrase('_Connect_2')?></div></a>
                        </div>
                        <img ondrag="return false" ondragstart="return false" id="server-map-image-<?php echo $i_server?>" src="./storage/cache/img/maps/<?php echo empty( $servers_cache[ $i_server ] ) ? '730/-' : $servers_cache[ $i_server ]?>.jpg">
                    </div>
                </div>
            </div>
        <?php endfor;?>
        <?php if ( $General->server_list_count % 3 != 0 ):?>
            <div class="col-md-4 mon-1"><div class="card plug"><div class="x_1"></div></div></div>
        <?php endif;?>
    </div>
    <div class="row">
        <div class="col-md-12 mon-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="badge"><?php echo $Translate->get_translate_phrase('_Online_mon')?></h5>
                </div>
                <div class=table-responsive>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center"><?php echo $Translate->get_translate_phrase('_Game')?></th>
                            <th class="text-left"><?php echo $Translate->get_translate_phrase('_Name')?></th>
                            <th class="text-center"><?php echo $Translate->get_translate_phrase('_Players')?></th>
                            <th class="text-center"><?php echo $Translate->get_translate_phrase('_Map')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ( $i_server = 0; $i_server < $General->server_list_count; $i_server++ ) {?>
                            <tr id="server-connect-table-<?php echo $i_server?>" onclick="">
                                <th class="text-center"><img id="server-tablemod-<?php echo $i_server?>" src="./storage/cache/img/global/null.png"></th>
                                <th class="text-left" id="server-tablename-<?php echo $i_server?>"></th>
                                <th class="text-center" id="server-tableplayers-<?php echo $i_server?>"></th>
                                <th class="text-center" id="server-tablemap-<?php echo $i_server?>"></th>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php break;}for ( $i_server = 0; $i_server < $General->server_list_count; $i_server++ ):?>
<div id="server-players-online-<?php echo $i_server?>" class="modal-window-server">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_phrase('_Server_Information')?></h5>
            <a title="Закрыть" id="<?php echo $i_server?>" onclick="close_modal(id)" href="javascript:void(0);" class="modal-close badge"><?php $General->get_icon( 'zmdi', 'close' )?></a>
        </div>
        <div class=server_block_scroll>
            <div class=table-responsive>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center"><?php echo $Translate->get_translate_phrase('_Player')?></th>
                        <th class="text-center"><?php echo $Translate->get_translate_phrase('_Point')?></th>
                        <th class="text-center"><?php echo $Translate->get_translate_phrase('_Play_time')?></th>
                    </tr>
                    </thead>
                    <tbody id="players_online_<?php echo $i_server?>">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="input-form">
            <a class="btn btn_connect_now" id="connect_server_<?php echo $i_server?>"><?php echo $Translate->get_translate_phrase('_Connect_2')?></a>
        </div>
    </div>
</div>
<?php endfor?>
