<?php ! isset( $_SESSION['user_admin'] ) && get_iframe( '013','Доступ закрыт' )?>
<div id="add_server_div" class="modal-window server_form">
        <div class="card">
            <div class="card-header">
                <h5 class="badge">Добавить сервер</h5>
                <a href="#" title="Закрыть" class="modal-close badge"><i class="zmdi zmdi-close zmdi-hc-fw"></i></a>
            </div>
            <form id="add_server_form" enctype="multipart/form-data" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-header">
                            <h5 class="badge">Сервер</h5>
                        </div>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text">Название Сервера</div><input name="server_name" value=""></div>
                            <div class="input-form"><div class="input_text">IP:PORT Сервера</div><input name="server_ip_port" value="127.0.0.1:27015"></div>
                            <div class="input-form"><div class="input_text">IP:PORT Выводимый</div><input name="server_ip_port_fake" value="127.0.0.1:27015"></div>
                            <div class="input-form"><div class="input_text">RCON</div><input type="password" name="server_rcon" value=""></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-header">
                            <h5 class="badge">MySQL</h5>
                        </div>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text">Статистика :: Таблица</div>
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
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text">VIP CORE :: Таблица</div>
                                <select name="server_vip" onChange="$('.vip_id').css('display','block')">
                                    <option style="display:none" value="">-</option>
                                    <?php if ( ! empty( $Db->db_data['Vips'] ) ):for ( $q = 0, $c = sizeof( $Db->db_data['Vips'] ); $q < $c; $q++ ):?>
                                    <option value="<?php echo sprintf( '%s;%d;%d;%s', $Db->db_data['Vips'][ $q ]['DB_mod'], $Db->db_data['Vips'][ $q ]['USER_ID'], $Db->db_data['Vips'][ $q ]['DB_num'], $Db->db_data['Vips'][ $q ]['Table'] )?>"><?php echo $Db->db_data['Vips'][ $q ]['USER'] . ' -> ' . $Db->db_data['Vips'][ $q ]['DB'] . ' -> ' . $Db->db_data['Vips'][ $q ]['Table'] . ' ( ' . $Db->db_data['Vips'][ $q ]['name'] . ' )'?></option>
                                    <?php endfor;endif?>
                                </select>
                            </div>
                        </div>
                        <div class="server_form_block vip_id">
                            <div class="input-form">
                                <div class="input_text">ID Сервера ( vip_core.cfg )</div>
                                <input name="server_vip_id" value="0">
                            </div>
                        </div>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text">SB / MA :: Таблица</div>
                                <select name="server_sb">
                                    <option style="display:none" value="">-</option>
                                    <?php if ( ! empty( $Db->db_data['SourceBans'] ) ):for ( $q = 0, $c = sizeof( $Db->db_data['SourceBans'] ); $q < $c; $q++ ):?>
                                        <option value="<?php echo sprintf( '%s;%d;%d;%s', $Db->db_data['SourceBans'][ $q ]['DB_mod'], $Db->db_data['SourceBans'][ $q ]['USER_ID'], $Db->db_data['SourceBans'][ $q ]['DB_num'], $Db->db_data['SourceBans'][ $q ]['Table'] )?>"><?php echo $Db->db_data['SourceBans'][ $q ]['USER'] . ' -> ' . $Db->db_data['SourceBans'][ $q ]['DB'] . ' -> ' . $Db->db_data['SourceBans'][ $q ]['Table'] . ' ( ' . $Db->db_data['SourceBans'][ $q ]['name'] . ' )'?></option>
                                    <?php endfor;endif?>
                                </select>
                            </div>
                        </div>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text">Shop :: Таблица</div>
                                <select name="server_shop">
                                    <option style="display:none" value="">-</option>
                                    <?php if ( ! empty( $Db->db_data['Shop'] ) ):for ( $q = 0, $c = sizeof( $Db->db_data['Shop'] ); $q < $c; $q++ ):?>
                                        <option value="<?php echo sprintf( '%s;%d;%d;%s', $Db->db_data['Shop'][ $q ]['DB_mod'], $Db->db_data['Shop'][ $q ]['USER_ID'], $Db->db_data['Shop'][ $q ]['DB_num'], $Db->db_data['Shop'][ $q ]['Table'] )?>"><?php echo $Db->db_data['Shop'][ $q ]['USER'] . ' -> ' . $Db->db_data['Shop'][ $q ]['DB'] . ' -> ' . $Db->db_data['Shop'][ $q ]['Table'] . ' ( ' . $Db->db_data['Shop'][ $q ]['name'] . ' )'?></option>
                                    <?php endfor;endif?>
                                </select>
                            </div>
                        </div>
                        <div class="server_form_block">
                            <div class="input-form"><div class="input_text">WarnSystem :: Таблица</div>
                                <select name="server_warnsystem">
                                    <option style="display:none" value="">-</option>
                                    <?php if ( ! empty( $Db->db_data['WarnSystem'] ) ):for ( $q = 0, $c = sizeof( $Db->db_data['WarnSystem'] ); $q < $c; $q++ ):?>
                                        <option value="<?php echo sprintf( '%s;%d;%d;%s', $Db->db_data['WarnSystem'][ $q ]['DB_mod'], $Db->db_data['WarnSystem'][ $q ]['USER_ID'], $Db->db_data['WarnSystem'][ $q ]['DB_num'], $Db->db_data['WarnSystem'][ $q ]['Table'] )?>"><?php echo $Db->db_data['WarnSystem'][ $q ]['USER'] . ' -> ' . $Db->db_data['WarnSystem'][ $q ]['DB'] . ' -> ' . $Db->db_data['WarnSystem'][ $q ]['Table'] . ' ( ' . $Db->db_data['WarnSystem'][ $q ]['name'] . ' )'?></option>
                                    <?php endfor;endif?>
                                </select>
                            </div>
                        </div>
                    </div>
                    </div>
                    <input class="btn _add_server" type="submit" name="save_server" value="Сохранить">
                </div>
            </form>
        </div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Настройка серверов</h5>
        </div>
        <div class="card-block">
                <div class=table-responsive>
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th class="text-center">Название</th>
                            <th class="text-center">IP:PORT</th>
                            <th class="text-center">Визуальный IP:PORT</th>
                            <th class=""></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ($i_server = 0; $i_server < $General->server_list_count; $i_server++) {?>
                            <tr>
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
            <a class="btn" type="input" href="#add_server_div">Добавить сервер</a>
        </div>
        </div>
    </div>
</div>