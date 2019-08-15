<?php if( $_SESSION['steamid32'] != $General->arr_general['admin'] || IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Порядок загрузки модулей</h5>
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
        <div class="card-container">
    <?php if( get_section( 'module_page', 'home' ) != '' ):?>
                <div class="dd" id="nestable">
                    <ol class="dd-list">
                        <?php
                        $c_m_p = ( get_section( 'module_page', 'home' ) == 'sidebar' ) ? sizeof( $Modules->arr_module_init['sidebar'] ) : sizeof( $Modules->arr_module_init['page'][ get_section( 'module_page', 'home' ) ] ['interface'] );
                        for ( $i = 0; $i < $c_m_p; $i++ ) {
                            $data_id = ( get_section( 'module_page', 'home' ) == 'sidebar' ) ? $Modules->arr_module_init['sidebar'][ $i ] : $Modules->arr_module_init['page'][ get_section( 'module_page', 'home' ) ]['interface'][ $i ];
                            $data_title = ( get_section( 'module_page', 'home' ) == 'sidebar' ) ? $Modules->array_modules[$Modules->arr_module_init['sidebar'][ $i ]]['title'] : $Modules->array_modules[$Modules->arr_module_init['page'][ get_section( 'module_page', 'home' ) ]['interface'][ $i ]]['title']?>
                            <li class="dd-item" data-id="<?php echo $data_id?>">
                                <a class="module_setting" href="<?php echo $General->arr_general['site']?>?page=adminpanel&section=modules&options=<?php echo $data_id?>"><i class="zmdi zmdi-chevron-right zmdi-hc-fw"></i></a>
                                <div class="dd-handle"><?php echo $data_title?></div>
                            </li>
                        <?php } ?>
                    </ol>
                    <input type="hidden" id="nestable-output">
                </div>
    <?php endif; ?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Опции</h5>
        </div>
        <div class="card-container">
            <div class="btn_form">
            <form enctype="multipart/form-data" method="post">
                <input class="btn" type="submit" name="clear_cache_modules" Value="Обновить кэш модулей">
            </form>
            </div>
            <div class="btn_form">
                <form enctype="multipart/form-data" method="post">
                    <input class="btn" type="submit" name="clear_translator_cache" Value="Обновить кэш переводов">
                </form>
            </div>
            <div class="btn_form">
            <form enctype="multipart/form-data" method="post">
                <input class="btn" type="submit" name="clear_modules_initialization" Value="Обновить список модулей">
            </form>
            </div>
        </div>
        </div>
    </div>
<?php if ( ! empty( $_GET['options'] ) ):?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge">Настройки модуля: <?php echo $Modules->array_modules[ $_GET['options'] ]['title']?></h5>
        </div>
        <div class="card-container module_block">
            <div class="info_form info_form_left">
                <div class="info_form_line">Автор:</div>
                <div class="info_form_line_value"><?php echo $Modules->array_modules[ $_GET['options'] ]['author']?></div>
            </div>
            <div class="info_form info_form_right">
                <div class="info_form_line">Мин. версия ядра:</div>
                <div class="info_form_line_value"><?php echo $Modules->array_modules[ $_GET['options'] ]['required']['core']?></div>
            </div>
            <div class="info_form info_form_left">
                <div class="info_form_line">Версия модуля:</div>
                <div class="info_form_line_value"><?php echo $Modules->array_modules[ $_GET['options'] ]['version']?></div>
            </div>
            <div class="info_form info_form_right">
                <div class="info_form_line">Мин. версия PHP:</div>
                <div class="info_form_line_value"><?php echo $Modules->array_modules[ $_GET['options'] ]['required']['php']?></div>
            </div>
            <div class="info_form">
                <div class="info_form_line">Описание:</div>
                <div class="info_form_line_value"><?php echo $Modules->array_modules[ $_GET['options'] ]['info']?></div>
            </div>
            <div class="input-form"><div class="input_text">Активная страница:</div><input name="module_page" value="<?php echo $Modules->array_modules[ $_GET['options'] ]['page']?>"></div>
            <div class="input-form">
                <input class="border-checkbox" type="checkbox" name="module_offon" id="module_offon" <?php $Modules->array_modules[ $_GET['options'] ]['setting']['status'] == 1 && print 'checked';?>>
                <label class="border-checkbox-label" for="module_offon">Модуль вкл. / выкл.</label>
            </div>
            <div class="input-form">
                <input class="border-checkbox" type="checkbox" name="module_interface" id="module_interface" <?php $Modules->array_modules[ $_GET['options'] ]['setting']['interface'] == 1 && print 'checked';?>>
                <label class="border-checkbox-label" for="module_interface">Графическая часть</label>
            </div>
            <div class="input-form">
                <input class="border-checkbox" type="checkbox" name="module_data" id="module_data" <?php $Modules->array_modules[ $_GET['options'] ]['setting']['data'] == 1 && print 'checked';?>>
                <label class="border-checkbox-label" for="module_data">Пре-инициализация</label>
            </div>
            <div class="input-form">
                <input class="border-checkbox" type="checkbox" name="module_sessions" id="module_sessions" <?php $Modules->array_modules[ $_GET['options'] ]['setting']['sessions'] == 1 && print 'checked';?>>
                <label class="border-checkbox-label" for="module_sessions">Использование кэша</label>
            </div>
            <div class="input-form">
                <input class="border-checkbox" type="checkbox" name="module_translation" id="module_translation" <?php $Modules->array_modules[ $_GET['options'] ]['setting']['translation'] == 1 && print 'checked';?>>
                <label class="border-checkbox-label" for="module_translation">Собственный файл перевода</label>
            </div>
            <div class="input-form">
                <input class="border-checkbox" type="checkbox" name="module_css" id="module_css" <?php $Modules->array_modules[ $_GET['options'] ]['setting']['сss'] == 1 && print 'checked';?>>
                <label class="border-checkbox-label" for="module_css">Собственный CSS стиль</label>
            </div>
            <div class="input-form">
                <input class="border-checkbox" type="checkbox" name="module_js" id="module_js" <?php $Modules->array_modules[ $_GET['options'] ]['setting']['js'] == 1 && print 'checked';?>>
                <label class="border-checkbox-label" for="module_js">Собственная JS библиотека</label>
            </div>
            <input class="btn" name="option_one_save" type="submit" form="options_one" value="Сохранить">
        </div>
    </div>
</div>
<?php endif?>