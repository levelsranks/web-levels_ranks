<?php ! isset( $_SESSION['user_admin'] ) && get_iframe( '013','Доступ закрыт' )?>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_General_settings')?></h5>
        </div>
        <div class="card-container option_one">
            <form id="options_one" enctype="multipart/form-data" method="post">
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Full_name')?></div><input name="full_name" value="<?php echo $General->arr_general['full_name']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Short_name')?></div><input name="short_name" value="<?php echo $General->arr_general['short_name']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Basic_information')?></div><input name="info" value="<?php echo $General->arr_general['info']?>"></div>
                    <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Language')?></div>
                        <select class="select" name="language">
                            <option style="display:none" value="<?php echo $General->arr_general['language']?>"><?php echo $Translate->get_translate_phrase( '_' . $General->arr_general['language'] )?></option>
                            <?php for ( $i = 0; $i < $Translate->arr_languages_count; $i++ ): ?>
                            <option value="<?php echo $Translate->arr_languages[ $i ]?>"><?php echo $Translate->get_translate_phrase('_' . $Translate->arr_languages[ $i ])?></option>
                            <?php endfor?>
                        </select>
                    </div>
                    <div class="input-form"><div class="input_text">Steam WEB KEY</div><input name="web_key" type="password" value="<?php echo $General->arr_general['web_key']?>"></div>
                <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Show_avatars')?></div>
                    <select name="avatars">
                        <option style="display:none" value="<?php echo (int) $General->arr_general['avatars']?>"><?php if( $General->arr_general['avatars'] == 1 ) { echo 'Показывать';} elseif ( $General->arr_general['avatars'] == 2) { echo 'Использовать случайные аватарки';} else { echo 'Не показывать';}?></option>
                        <option value="1">Показывать</option>
                        <option value="2">Использовать случайные аватарки</option>
                        <option value="0">Не показывать</option>
                    </select>
                </div>
                <div class="input-form"><div class="input_text">Время сохранения аватаров(Сек.)</div><input name="avatars_cache_time" value="<?php echo $General->arr_general['avatars_cache_time']?>"></div>
            </form>
            <input class='btn' name="option_one_save" type="submit" form="options_one" value="<?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Save')?>">
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h5 class="badge"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Extra_settingss')?></h5>
        </div>
        <div class="card-container">
            <div class="input-form">
                <div class="text_on_line"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Decor')?></div>
            </div>
            <?php $Background_images = array_diff( scandir( CACHE . '/img/global/backgrounds/', 1 ), array( '..', '.' ) )?>
            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Background_image')?></div>
                <select class="select" name="background_image" onChange="set_options_data_select( getAttribute('name'), value )">
                    <option style="display:none" value="<?php echo $General->arr_general['background_image'] == 'null' ? $Translate->get_translate_module_phrase( 'module_page_adminpanel','_No_image') : $General->arr_general['background_image']?>"><?php echo $General->arr_general['background_image'] == 'null' ? $Translate->get_translate_module_phrase( 'module_page_adminpanel','_No_image') : $General->arr_general['background_image']?></option>
                    <?php for ( $i = 0, $_c = sizeof( $Background_images ); $i < $_c; $i++ ):?>
                        <option value="<?php echo $Background_images[ $i ]?>"><?php echo $Background_images[ $i ]?></option>
                    <?php endfor?>
                    <option value="null"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_No_image')?></option>
                </select>
            </div>
            <?php $palettes = $Modules->scan_templates; ?>
            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Template')?></div>
                <select class="select" name="theme" onChange="set_options_data_select( getAttribute('name'), value )">
                    <option style="display:none" value="<?php echo $General->arr_general['theme']?>"><?php echo $General->arr_general['theme']?></option>
                    <?php foreach ($Modules->scan_templates as $key => $val): ?>
                        <option value="<?php echo $val?>"><?php echo $val?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="input-form">
                <div class="text_on_line"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Design')?></div>
            </div>
            <div class="input-form"><div class="input_text"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Primary_graphics_container')?></div>
                <select class="select" name="graphics_container" onChange="set_options_data_select( getAttribute('name'), value )">
                    <option style="display:none" value="<?php echo $General->arr_general['graphics_container']?>"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_S' . substr( $General->arr_general['graphics_container'], 1 ) )?></option>
                        <option value="stretch"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Stretch')?></option>
                        <option value="static"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Static')?></option>
                </select>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'css')" class="border-checkbox" type="checkbox" name="animations" id="animations" <?php $General->arr_general['animations'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="animations"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Animation_default')?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'')" class="border-checkbox" type="checkbox" name="sidebar_open" id="sidebar_open" <?php $General->arr_general['sidebar_open'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="sidebar_open"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Sidebar_default')?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'')" class="border-checkbox" type="checkbox" name="disable_sidebar_change" id="disable_sidebar_change" <?php $General->arr_general['disable_sidebar_change'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="disable_sidebar_change"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Disable_sidebar_change')?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'css')" class="border-checkbox" type="checkbox" name="form_border" id="form_border" <?php $General->arr_general['form_border'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="form_border"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Round_shapes')?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'css')" class="border-checkbox" type="checkbox" name="graphics.sidebar_blur" id="graphics.sidebar_blur" <?php $General->arr_general['graphics.sidebar_blur'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="graphics.sidebar_blur"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Sidebar_blur')?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'css')" class="border-checkbox" type="checkbox" name="graphics.blocks_blur" id="graphics.blocks_blur" <?php $General->arr_general['graphics.blocks_blur'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="graphics.blocks_blur"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Blocks_blur')?></label>
            </div>
            <div class="input-form">
                <div class="text_on_line"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Configuration')?></div>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'')" class="border-checkbox" type="checkbox" name="steam_auth" id="steam_auth" <?php $General->arr_general['steam_auth'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="steam_auth"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Steam_access_authorization')?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'')" class="border-checkbox" type="checkbox" name="steam_only_authorization" id="steam_only_authorization" <?php $General->arr_general['steam_only_authorization'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="steam_only_authorization"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Steam_only_authorization')?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'')" class="border-checkbox" type="checkbox" name="SB_admins_import" id="SB_admins_import" <?php $General->arr_general['SB_admins_import'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="SB_admins_import"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Import_admin_list')?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'')" class="border-checkbox" type="checkbox" name="only_steam_64" id="only_steam_64" <?php $General->arr_general['only_steam_64'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="only_steam_64"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Use_Steam_ID')?></label>
            </div>
            <div class="input-form">
                <div class="text_on_line"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Optimization')?></div>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'css')" class="border-checkbox" type="checkbox" name="enable_css_cache" id="enable_css_cache" <?php $General->arr_general['enable_css_cache'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="enable_css_cache"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Enable_css_cache')?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'js')" class="border-checkbox" type="checkbox" name="enable_js_cache" id="enable_js_cache" <?php $General->arr_general['enable_js_cache'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="enable_js_cache"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Enable_js_cache')?></label>
            </div>
            <div class="input-form">
                <div class="text_on_line"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Security')?></div>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'')" class="border-checkbox" type="checkbox" name="session_check" id="session_check" <?php $General->arr_general['session_check'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="session_check"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Session_check')?></label>
            </div>
            <div class="input-form">
                <input onclick="set_options_data(this.id,'css')" class="border-checkbox" type="checkbox" name="auth_cock" id="auth_cock" <?php $General->arr_general['auth_cock'] === 1 && print 'checked'?>>
                <label class="border-checkbox-label" for="auth_cock"><?php echo $Translate->get_translate_module_phrase( 'module_page_adminpanel','_Cockie')?></label>
            </div>
        </div>
    </div>
</div>