<?php if( $_SESSION['steamid32'] != $General->arr_general['admin'] || IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Подключенные моды</h5>
        </div>
        <div class="card-block">
            <form id="form_servers" enctype="multipart/form-data" method="post">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                        <tr>
                            <th class="text-center">Название мода</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ( $idb = 0; $idb < $Db->mod_count; $idb++ ):?>
                        <tr>
                            <th class="text-center"><?php echo $Db->mod_name[ $idb ]?></th>
                            <th class="text-center"><button class="remove_servers" type="submit"><?php $General->get_icon( 'zmdi', 'edit' )?></button></th>
                            <th class="text-center"><button class="remove_servers" type="submit"><?php $General->get_icon( 'zmdi', 'close' )?></button></th>
                        </tr>
                        <?php endfor?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
        <div class="card-container">
            <div class="btn_form">
                <input class="btn _add_server" type="submit" value="Добавить мод">
            </div>
        </div>
    </div>
</div>