<?php if( $_SESSION['steamid32'] != $General->arr_general['admin'] || IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }?>
<div class="col-md-4">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Настройка модулей</h5>
            <div class="select-panel select-panel-pages badge">
                <select onChange="window.location.href=this.value">
                    <option style="display:none" value="" disabled selected><?php echo get_section( 'module_page', 'home' )?></option>
                    <?php for ($i = 0;$i < $Modules->arr_module_init_page_count;$i++) {$id_module = array_keys( $Modules->arr_module_init['page'] )[ $i ]?>
                        <option value="<?php echo set_url_section(get_url(2), 'module_page', $id_module) ?>">
                            <a href="<?php echo set_url_section(get_url(2), 'module_page', $id_module) ?>">Страница: <?php echo $id_module?></a></option>
                    <?php } ?>
                    <option value="<?php echo set_url_section(get_url(2), 'module_page', 'sidebar') ?>">
                        <a href="<?php echo set_url_section(get_url(2), 'module_page', 'sidebar') ?>">sidebar</a></option>
                </select>
            </div>
        </div>
    </div>
    <?php if( get_section( 'module_page', 'home' ) != ''):?>
        <div class="card">
            <div class="card-container">
                <h5>Порядок загрузки модулей</h5>
                <div class="dd" id="nestable">
                    <ol class="dd-list">
                        <?php
                        $c_m_p = ( get_section( 'module_page', 'home' ) == 'sidebar' ) ? sizeof( $Modules->arr_module_init['sidebar'] ) : sizeof( $Modules->arr_module_init['page'][ get_section( 'module_page', 'home' ) ] ['interface'] );
                        for ( $i = 0; $i < $c_m_p; $i++ ) {
                            $data_id = ( get_section( 'module_page', 'home' ) == 'sidebar' ) ? $Modules->arr_module_init['sidebar'][ $i ] : $Modules->arr_module_init['page'][ get_section( 'module_page', 'home' ) ]['interface'][ $i ];
                            $data_title = ( get_section( 'module_page', 'home' ) == 'sidebar' ) ? $Modules->array_modules[$Modules->arr_module_init['sidebar'][ $i ]]['title'] : $Modules->array_modules[$Modules->arr_module_init['page'][ get_section( 'module_page', 'home' ) ]['interface'][ $i ]]['title']?>
                            <li class="dd-item" data-id="<?php echo $data_id?>">
                                <div class="dd-handle"><?php echo $data_title?></div>
                            </li>
                        <?php } ?>
                    </ol>
                </div>
                <input type="hidden" id="nestable-output">
                <form id="form" enctype="multipart/form-data" method="post">
                    <input class="button" type="submit" name="update_modules" Value="Обновить кэш и список модулей" form="form">
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>