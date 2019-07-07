<?php if( $_SESSION['steamid32'] != $General->arr_general['admin'] || IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Настройка серверов</h5>
        </div>
        <div class="card-block">
            <form id="form_servers" enctype="multipart/form-data" method="post">
                <div class=table-responsive>
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th class="text-center">Основной IP</th>
                            <th class="text-center">Визуальный IP</th>
                            <th class=""></th>
                        </tr>
                        </thead>
                        <tbody class="_servers" id="servers">
                        <?php for ($i_server = 0; $i_server < $General->server_list_count; $i_server++) {?>
                            <tr class="server_line">
                            <th class="text-center"><div class="input-form">
                                    <input type="text" value="<?php echo $General->server_list[$i_server]['ip']?>" name="serversip[]"/>
                                </div></th>
                            <th class="text-center"><div class="input-form">
                                    <input type="text" value="<?php echo $General->server_list[$i_server]['fakeip']?>" name="serversfakeip[]"/>
                                </div></th>
                            <th class="text-center"><button class="remove_servers" type="submit"><?php $General->get_icon( 'zmdi', 'close' )?></button></th>
                            </tr><?php } ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <div class="rp_block">
            <input class="add_server" type="submit" id="add" value="Добавить сервер"/>
            <input class="save_servers" type="submit" name="save_servers" Value="Сохранить список" form="form_servers">
        </div>
    </div>
</div>