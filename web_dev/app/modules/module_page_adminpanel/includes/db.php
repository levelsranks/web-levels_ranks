<?php ! isset( $_SESSION['user_admin'] ) && get_iframe( '013','Доступ закрыт' );
foreach ( $Db->db_data as $mod ):
    foreach ( $mod as $connection):
        $db_data[] = $connection;
    endforeach;
endforeach;
$db_data_file = require SESSIONS . '/db.php';
?>
<div id="add_connect" class="modal-window server_form">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Add_con')?></h5><div style="display:inline-block; margin-left: 15px;" class="new_connect" id="con_mod_name"></div>
            <a href="#" title="Закрыть" class="modal-close badge"><i class="zmdi zmdi-close zmdi-hc-fw"></i></a>
        </div>
        <form enctype="multipart/form-data" method="post" id="form-add-conection">
            <input type="hidden" id="con_mod_id" name="mod">
            <div class="row">
                <div class="col-md-12">
                    <div class="server_form_block">
                        <div class="input-form">
                            <div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_type_con')?></div>
                            <select name="type" onchange="changeConnect(this.value)">
                                <option value="table"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_table_con')?></option>
                                <option value="db" selected><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_db_con')?></option>
                            </select>
                            <div class="wrapper-db-select" id="db_select_con" style="display:none">
                                <div class="input_text add_connection_label"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_take_db_con')?></div>
                                <select name="db_name_for_table">
                                    <option value="-1" selected disabled><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_non_take_con')?></option>
                                <?php foreach ( $db_data_file as $mod_name => $mod ):
                                        foreach ( $mod as $connection ):?>
                                            <option style="display:none;" class="con_<?php echo $mod_name;?>" value="<?php echo $connection['DB'][0]['DB'];?>">
                                                    <?php echo $connection['DB'][0]['DB'];?>
                                            </option>
                                <?php   endforeach;
                                      endforeach;?>
                                </select>
                            </div>
                            <div id="db_option_con" style="display:flex" class="wrapper_connection_option">
                                <div>
                                    <label class="input_text add_connection_label" for="con_host"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_host')?></label>
                                    <input type="text" name="host" id="con_host">

                                    <label class="input_text add_connection_label" for="con_db_name"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_name_db')?></label>
                                    <input type="text" name="db_name" id="con_db_name">

                                    <label class="input_text add_connection_label" for="con_user_name"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_username')?></label>
                                    <input type="text" name="username" id="con_user_name">
                                </div>
                                <div>
                                    <label class="input_text add_connection_label" for="con_password"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_password')?></label>
                                    <div class="wrapper-password">
                                        <input type="password" name="password" id="con_password">
                                        <div href="#" class="password-control" onclick="return show_hide_password(this);"><i class="zmdi zmdi-eye"></i></div>
                                    </div>
                                    <label class="input_text add_connection_label" for="con_port"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_port')?></label>
                                    <input type="text" name="port" id="con_port" value="3306">

                                </div>
                            </div>
                            <div class="wrapper_connection_option">
                                <div>
                                    <label class="input_text add_connection_label" for="con_table_name"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_table_name')?></label>
                                    <input type="text" id="con_table_name" name="table_name">
                                    <div id="rank_pack_connection">
                                        <label class="input_text add_connection_label" for="con_rank_pack"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_rank_pack')?></label>
                                        <input type="text" name="rank_pack" id="con_rank_pack" value="default">
                                    </div>
                                    <label class="input_text add_connection_label" for="con_server_name"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Server_name')?></label>
                                    <input type="text" name="server_name" id="con_server_name">
                                </div>
                                <div>
                                    <div class="input-form">
                                        <div class="input_text">Steam mode</div>
                                        <select name="steam_mod">
                                            <option value="1">Only Steam</option>
                                            <option value="0">No Steam</option>
                                        </select>
                                    </div>
                                    <div class="input-form"><div class="input_text">Game mode</div>
                                        <select name="game_mod">
                                            <option value="730">CS:GO</option>
                                            <option value="240">CS:S</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn _add_server" onclick="addConection()"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_add')?></div>
        </form>
    </div>
</div>
<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_mod_list')?></h5>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th class="text-center"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_mod')?></th>
                        <th class=""></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ( $i_db = 0; $i_db < $Db->mod_count; $i_db++ ):?>
                        <tr>
                            <th class="text-center">
                                <?php echo $Db->mod_name[ $i_db ]?>
                            </th>
                            <th class="text-center">
                                <button class="remove_servers" name="<?php echo $Db->mod_name[ $i_db ]?>" onclick="action_db_delete_table(this, this.getAttribute('name'))"><?php $General->get_icon( 'zmdi', 'close' )?></button>
                            </th>
                        </tr>
                    <?php endfor?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_configure')?></h5>
        </div>
        <div class="card-container">
            <div class="input-form">
                <div class="text_on_line"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_connection')?></div>
            </div>
            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_mod')?></div>
                <select id="mods" onchange="changeConnection(this.value)">
                    <option value="-1" disabled selected><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_take_mod')?></option>
                    <option value="LevelsRanks">Levels Ranks</option>
                    <option value="FPS">Fire Players Stats</option>
                    <option value="SourceBans">SB / MA</option>
                    <option value="Vips">VIP</option>
                    <option value="Shop">Shop</option>
                    <option value="WarnSystem">WarnSystem</option>
                    <option value="lk">lk</option>
                    <option value="custom"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_custom_mode')?></option>
                </select>
                <div class="custom_mode" id="custom_mod_wrapper" style="display:none;">
                    <label for="custom_mod_name" class="input_text add_connection_label"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_enter_mode_name')?></label>
                    <input type="text" name="custom_mod" id="custom_mod_name">
                </div>  
            </div>
            <div class="input-form">
                <div class="btn_form">
                    <a class="btn" type="input" onclick="changeNameModule()" id="add_conection_button" href="#"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Add_con')?></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_list_con')?></h5>
        </div>
        <div class="card-block">
            <div class=table-responsive>
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th class="text-center"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_mod')?></th>
                        <th class="text-center"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_user')?></th>
                        <th class="text-center"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_db_con')?></th>
                        <th class="text-center"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_table_prefix')?></th>
                        <th class=""></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for ( $i_db = 0, $_c = sizeof( $db_data ); $i_db < $_c; $i_db++ ):?>
                        <tr class="<?php echo $db_data[ $i_db ]['DB_mod']?>">
                            <th class="text-center">
                                <?php echo $db_data[ $i_db ]['DB_mod']?>
                            </th>
                            <th class="text-center">
                                <?php echo $db_data[ $i_db ]['USER']?>
                            </th>
                            <th class="text-center">
                                <?php echo $db_data[ $i_db ]['DB']?>
                            </th>
                            <th class="text-center">
                                <?php echo $db_data[ $i_db ]['Table']?>
                            </th>
                            <th class="text-center">
                                <button class="remove_servers" name="<?php echo sprintf('%s;%d;%d;%d', $db_data[ $i_db ]['DB_mod'], $db_data[ $i_db ]['USER_ID'], $db_data[ $i_db ]['DB_num'], $db_data[ $i_db ]['table_id'] )?>" onclick="action_db_delete_table(this, this.getAttribute('name'))"><?php $General->get_icon( 'zmdi', 'close' )?></button>
                            </th>
                        </tr>
                    <?php endfor?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>