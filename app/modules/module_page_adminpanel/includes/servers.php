<?php ! isset( $_SESSION['user_admin'] ) && get_iframe( '013','Доступ закрыт' )?>
<div id="add_server_div" class="modal-window server_form">
        <div class="card">
            <div class="card-header">
                <h5 class="badge"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Add_Server')?></h5>
                <a href="#" title="Закрыть" class="modal-close badge"><i class="zmdi zmdi-close zmdi-hc-fw"></i></a>
            </div>
            <form id="add_server_form" enctype="multipart/form-data" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-header">
                            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Server')?></h5>
                        </div>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Server_name')?></div><input name="server_name_custom" value=""></div>
                            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_TechnoName')?></div><input name="server_name" value=""></div>
                            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Ip_Port_Server')?></div><input name="server_ip_port" value="127.0.0.1:27015"></div>
                            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Ip_Port_View')?></div><input name="server_ip_port_fake" value="127.0.0.1:27015"></div>
                            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Rcon')?></div><input type="password" name="server_rcon" value=""></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-header">
                            <h5 class="badge">MySQL</h5>
                        </div>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Stat_Table')?></div>
                                <select name="server_stats">
                                    <option style="display:none" value="">-</option>
                                    <?php if ( ! empty( $Db->db_data['LevelsRanks'] ) ):for ( $q = 0, $c = sizeof( $Db->db_data['LevelsRanks'] ); $q < $c; $q++ ):?>
                                        <option value="<?php echo sprintf( '%s;%d;%d;%s', $Db->db_data['LevelsRanks'][ $q ]['DB_mod'], $Db->db_data['LevelsRanks'][ $q ]['USER_ID'], $Db->db_data['LevelsRanks'][ $q ]['DB_num'], $Db->db_data['LevelsRanks'][ $q ]['Table'] )?>"><?php echo $Db->db_data['LevelsRanks'][ $q ]['USER'] . ' -> ' . $Db->db_data['LevelsRanks'][ $q ]['DB'] . ' -> ' . $Db->db_data['LevelsRanks'][ $q ]['Table'] . ' ( ' . $Db->db_data['LevelsRanks'][ $q ]['name'] . ' )'?></option>
                                    <?php endfor;endif?>
                                    <?php if ( ! empty( $Db->db_data['FPS'] ) ):for ( $q = 0, $c = sizeof( $Db->db_data['FPS'] ); $q < $c; $q++ ):?>
                                        <option value="<?php echo sprintf( '%s;%d;%d;%s', $Db->db_data['FPS'][ $q ]['DB_mod'], $Db->db_data['FPS'][ $q ]['USER_ID'], $Db->db_data['FPS'][ $q ]['DB_num'], $Db->db_data['FPS'][ $q ]['Table'] )?>"><?php echo $Db->db_data['FPS'][ $q ]['USER'] . ' -> ' . $Db->db_data['FPS'][ $q ]['DB'] . ' -> ' . $Db->db_data['FPS'][ $q ]['Table'] . ' ( ' . $Db->db_data['FPS'][ $q ]['name'] . ' )'?></option>
                                    <?php endfor;endif?>
                                </select>
                            </div>
                        </div>
                        <?php if ( ! empty( $Db->db_data['Vips'] ) ):?>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Vip_Table')?></div>
                                <select name="server_vip" onChange="$('.vip_id').css('display','block')">
                                    <option style="display:none" value="">-</option>
                                    <?php for ( $q = 0, $c = sizeof( $Db->db_data['Vips'] ); $q < $c; $q++ ):?>
                                    <option value="<?php echo sprintf( '%s;%d;%d;%s', $Db->db_data['Vips'][ $q ]['DB_mod'], $Db->db_data['Vips'][ $q ]['USER_ID'], $Db->db_data['Vips'][ $q ]['DB_num'], $Db->db_data['Vips'][ $q ]['Table'] )?>"><?php echo $Db->db_data['Vips'][ $q ]['USER'] . ' -> ' . $Db->db_data['Vips'][ $q ]['DB'] . ' -> ' . $Db->db_data['Vips'][ $q ]['Table'] . ' ( ' . $Db->db_data['Vips'][ $q ]['name'] . ' )'?></option>
                                    <?php endfor?>
                                </select>
                            </div>
                        </div>
                        <div class="server_form_block vip_id">
                            <div class="input-form">
                                <div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Vip_Sid')?></div>
                                <input name="server_vip_id" value="0">
                            </div>
                        </div>
                        <?php endif; if ( ! empty( $Db->db_data['SourceBans'] ) ):?>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Sb_Table')?></div>
                                <select name="server_sb">
                                    <option style="display:none" value="">-</option>
                                    <?php for ( $q = 0, $c = sizeof( $Db->db_data['SourceBans'] ); $q < $c; $q++ ):?>
                                        <option value="<?php echo sprintf( '%s;%d;%d;%s', $Db->db_data['SourceBans'][ $q ]['DB_mod'], $Db->db_data['SourceBans'][ $q ]['USER_ID'], $Db->db_data['SourceBans'][ $q ]['DB_num'], $Db->db_data['SourceBans'][ $q ]['Table'] )?>"><?php echo $Db->db_data['SourceBans'][ $q ]['USER'] . ' -> ' . $Db->db_data['SourceBans'][ $q ]['DB'] . ' -> ' . $Db->db_data['SourceBans'][ $q ]['Table'] . ' ( ' . $Db->db_data['SourceBans'][ $q ]['name'] . ' )'?></option>
                                    <?php endfor?>
                                </select>
                            </div>
                        </div>
                        <?php endif; if ( ! empty( $Db->db_data['Shop'] ) ):?>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Shop_Table')?></div>
                                <select name="server_shop">
                                    <option style="display:none" value="">-</option>
                                    <?php for ( $q = 0, $c = sizeof( $Db->db_data['Shop'] ); $q < $c; $q++ ):?>
                                        <option value="<?php echo sprintf( '%s;%d;%d;%s', $Db->db_data['Shop'][ $q ]['DB_mod'], $Db->db_data['Shop'][ $q ]['USER_ID'], $Db->db_data['Shop'][ $q ]['DB_num'], $Db->db_data['Shop'][ $q ]['Table'] )?>"><?php echo $Db->db_data['Shop'][ $q ]['USER'] . ' -> ' . $Db->db_data['Shop'][ $q ]['DB'] . ' -> ' . $Db->db_data['Shop'][ $q ]['Table'] . ' ( ' . $Db->db_data['Shop'][ $q ]['name'] . ' )'?></option>
                                    <?php endfor?>
                                </select>
                            </div>
                        </div>
                        <?php endif; if ( ! empty( $Db->db_data['WarnSystem'] ) ):?>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_WarnSystem_Table')?></div>
                                <select name="server_warnsystem">
                                    <option style="display:none" value="">-</option>
                                    <?php for ( $q = 0, $c = sizeof( $Db->db_data['WarnSystem'] ); $q < $c; $q++ ):?>
                                        <option value="<?php echo sprintf( '%s;%d;%d;%s', $Db->db_data['WarnSystem'][ $q ]['DB_mod'], $Db->db_data['WarnSystem'][ $q ]['USER_ID'], $Db->db_data['WarnSystem'][ $q ]['DB_num'], $Db->db_data['WarnSystem'][ $q ]['Table'] )?>"><?php echo $Db->db_data['WarnSystem'][ $q ]['USER'] . ' -> ' . $Db->db_data['WarnSystem'][ $q ]['DB'] . ' -> ' . $Db->db_data['WarnSystem'][ $q ]['Table'] . ' ( ' . $Db->db_data['WarnSystem'][ $q ]['name'] . ' )'?></option>
                                    <?php endfor?>
                                </select>
                            </div>
                        </div>
                        <?php endif; if ( ! empty( $Db->db_data['lk'] ) ):?>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Lk_Table')?></div>
                                <select name="server_lk">
                                    <option style="display:none" value="">-</option>
                                    <?php for ( $q = 0, $c = sizeof( $Db->db_data['lk'] ); $q < $c; $q++ ):?>
                                        <option value="<?php echo sprintf( '%s;%d;%d;%s', $Db->db_data['lk'][ $q ]['DB_mod'], $Db->db_data['lk'][ $q ]['USER_ID'], $Db->db_data['lk'][ $q ]['DB_num'], $Db->db_data['lk'][ $q ]['Table'] )?>"><?php echo $Db->db_data['lk'][ $q ]['USER'] . ' -> ' . $Db->db_data['lk'][ $q ]['DB'] . ' -> ' . $Db->db_data['lk'][ $q ]['Table'] . ' ( ' . $Db->db_data['lk'][ $q ]['name'] . ' )'?></option>
                                    <?php endfor?>
                                </select>
                            </div>
                        </div>
                        <?php endif?>
                    </div>
                    </div>
                    <input class="btn _add_server" type="submit" name="save_server" value="<?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Save')?>">
                </div>
            </form>
        </div>
        <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Server_setting')?></h5>
        </div>
        <div class="card-block">
                <div class=table-responsive>
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Server_Name')?></th>
                            <th class="text-center">IP:PORT</th>
                            <th class="text-center"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_View')?> IP:PORT</th>
                            <th class=""></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ($i_server = 0; $i_server < $General->server_list_count; $i_server++) {?>
                            <tr id="<?php echo $General->server_list[$i_server]['id']?>">
                                <th class="text-center">
                                    <?php echo $General->server_list[$i_server]['id']?>
                                </th>
                                <th class="text-center">
                                    <?php echo $General->server_list[$i_server]['name']?>
                                </th>
                                <th class="text-center">
                                    <?php echo $General->server_list[$i_server]['ip']?>
                                </th>
                                <th class="text-center">
                                    <?php echo $General->server_list[$i_server]['fakeip']?>
                                </th>
                                <th class="text-center">
                                    <button class="remove_servers" onclick="delete_server(this)"><?php $General->get_icon( 'zmdi', 'close' )?></button>
                                </th>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
        </div>
        <div class="card-container">
        <div class="btn_form">
            <a class="btn" type="input" href="#add_server_div"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Add_Server')?></a>
        </div>
        </div>
    </div>
</div>