<?php if( $_SESSION['steamid32'] != $General->arr_general['admin'] || IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }
for ( $im = 0; $im < $Db->mod_count; $im++ ):
    for ( $im2 = 0, $c = sizeof( $Db->db_data[ $Db->mod_name[ $im ] ] ); $im2 < $c; $im2++ ):
        $db_data[] = $Db->db_data[ $Db->mod_name[ $im ] ][ $im2 ];
    endfor;
endfor;?>
<div id="add_table" class="modal-window server_form">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Добавить мод</h5>
            <a href="#" title="Закрыть" class="modal-close badge"><i class="zmdi zmdi-close zmdi-hc-fw"></i></a>
        </div>
        <form enctype="multipart/form-data" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="server_form_block">
                        <div class="input-form"><div class="input_text">Мод</div>
                            <select name="mod">
                                <option value="LevelsRanks">Levels Ranks</option>
                                <option value="FPS">Fire Players Stats</option>
                                <option value="SourceBans">SB / MA</option>
                                <option value="Vips">VIP Core - R1KO</option>
                                <option value="Shop">Shop</option>
                                <option value="WarnSystem">WarnSystem</option>
                                <option value="AutoDemo">Autodemo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <input class="btn _add_server" type="submit" name="add_mods" value="Добавить">
    </div>
    </form>
</div>
<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Список модов</h5>
        </div>
        <div class="card-block">
            <div class=table-responsive>
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th class="text-center">Мод</th>
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
        <div class="card-container">
            <div class="btn_form">
                <a class="btn" type="input" href="#add_table">Добавить мод</a>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Конфигуратор</h5>
        </div>
        <div class="card-container">
            <div class="input-form">
                <div class="text_on_line">Подключения</div>
            </div>
            <div class="input-form"><div class="input_text">Мод</div>
                <select id="mods">
                    <?php for ( $i_db = 0; $i_db < $Db->mod_count; $i_db++ ):?>
                    <option value="<?php echo $Db->mod_name[ $i_db ]?>"><?php echo $Db->mod_name[ $i_db ]?></option>
                    <?php endfor?>
                </select>
            </div>
            <div class="input-form">
            <div class="btn_form">
                <a class="btn" type="input" href="#add_connect">Добавить Подключение ( don't work )</a>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Общий список подключений</h5>
        </div>
        <div class="card-block">
            <div class=table-responsive>
                <table class="table table-hover mb-0">
                    <thead>
                    <tr>
                        <th class="text-center">Мод</th>
                        <th class="text-center">Пользователь</th>
                        <th class="text-center">База данных</th>
                        <th class="text-center">Таблица | Префикс</th>
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