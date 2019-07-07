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
<script>servers.push(<?php echo json_encode( $General->server_list )?>);</script>
<?php $servers_cache = $Modules->get_module_cache('module_block_main_servers_monitoring');
switch ( $Modules->array_modules['module_block_main_servers_monitoring']['setting']['type'] ) {
    case 1:?>
        <div class="row">
            <?php for ( $i_server = 0; $i_server < $General->server_list_count; $i_server++ ) {?>
			<?php if ( $General->server_list_count % 3 == 1 && $i_server == $General->server_list_count - 1 ):?>
                <div class="col-md-4 mon-1"><div class="card plug"></div></div>
            <?php endif;?>
                <div class="col-md-4 mon-1">
                    <div class=card>
                        <div class=custom-server>
                            <div class="data-basic">
                                <div class="back">
                                    <div class="data-name" id="server-name-<?php echo $i_server?>"><?php echo $Modules->get_translate_phrase('_Update')?></div>
                                    <div class="data-map" id="server-map-<?php echo $i_server?>"></div>
                                </div>
                                <div class="back">
                                    <div class="data-players" id="server-players-<?php echo $i_server?>"></div>
                                </div>
                            </div>
                            <input id="server-connect-<?php echo $i_server?>" onclick="" type="button" value="<?php echo $Modules->get_translate_phrase('_Connect')?>">
                            <img ondrag="return false" ondragstart="return false" id="server-map-image-<?php echo $i_server?>" src="./storage/cache/img/maps/<?php if( $servers_cache !== false ){ echo $servers_cache[ $i_server ]; }?>.jpg">
                        </div>
                    </div>
                </div>
            <?php }?>
			<?php if ( $General->server_list_count % 3 != 0 ):?>
            <div class="col-md-4 mon-1"><div class="card plug"><div class="x_1"></div></div></div>
        <?php endif;?>
        </div>
        <div class="row">
            <div class="col-md-12 mon-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="badge"><?php echo $Modules->get_translate_phrase('_Online_mon')?></h5>
                    </div>
                    <div class=table-responsive>
                        <table class="table table-hover mb-0">
                            <thead>
                            <tr>
                                <th class="text-center"><?php echo $Modules->get_translate_phrase('_Game')?></th>
                                <th class="text-left"><?php echo $Modules->get_translate_phrase('_Name')?></th>
                                <th class="text-center"><?php echo $Modules->get_translate_phrase('_Players')?></th>
                                <th class="text-center"><?php echo $Modules->get_translate_phrase('_Map')?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php for ( $i_server = 0; $i_server < $General->server_list_count; $i_server++ ) {?>
                                <tr class="pointer" id="server-connect-table-<?php echo $i_server?>" onclick="">
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
                    <h5><?php echo $Modules->get_translate_phrase('_Online_mon')?></h5>
                </div>
                <div class=table-responsive>
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th class="text-center"><?php echo $Modules->get_translate_phrase('_Game')?></th>
                            <th class="text-left"><?php echo $Modules->get_translate_phrase('_Name')?></th>
                            <th class="text-center"><?php echo $Modules->get_translate_phrase('_Players')?></th>
                            <th class="text-center"><?php echo $Modules->get_translate_phrase('_Map')?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ( $i_server = 0; $i_server < $General->server_list_count; $i_server++ ) {?>
                            <tr class="pointer" id="server-connect-table-<?php echo $i_server?>" onclick="">
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
                            <input id="server-connect-<?php echo $i_server?>" onclick="" type="button" value="<?php echo $Modules->get_translate_phrase('_Connect_2')?>">
                        </div>
                        <img ondrag="return false" ondragstart="return false" id="server-map-image-<?php echo $i_server?>" src="./storage/cache/img/maps/<?php if( $servers_cache !== false ) { echo $servers_cache[ $i_server ]; }?>.jpg">
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
                    <h5 class="badge"><?php echo $Modules->get_translate_phrase('_Online_mon')?></h5>
                </div>
                <div class=table-responsive>
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th class="text-center"><?php echo $Modules->get_translate_phrase('_Game')?></th>
                            <th class="text-left"><?php echo $Modules->get_translate_phrase('_Name')?></th>
                            <th class="text-center"><?php echo $Modules->get_translate_phrase('_Players')?></th>
                            <th class="text-center"><?php echo $Modules->get_translate_phrase('_Map')?></th>
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
<?php break;}?>